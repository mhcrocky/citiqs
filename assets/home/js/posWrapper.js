'use strict';
function showCategory(element, categoryId, categoriesClass) {
    let categories = document.getElementsByClassName(categoriesClass);
    let categoriesLength = categories.length;
    let i;
    for (i = 0; i < categoriesLength; i++) {
        let category = categories[i];			
        if (category.id !== categoryId) {
            let categoryButton = document.querySelector('[data-id="' + category.id + '"]');
            category.style.display = 'none';
            categoryButton.classList.remove(makeOrderGlobals.activeClass);
        } else {
            category.style.display = 'block';				
        }
    }
    element.classList.add(makeOrderGlobals.activeClass);
}


function posTriggerModalClick(modalButtonId) {
    triggerModalClick(modalButtonId);
}

function cancelPosOrder(orderDataRandomKey,) {
    if (orderDataRandomKey) {
        $('#confirmCancel').modal('show');
    } else {
        resetPosOrder();
    }
}

function resetPosOrder() {
    document.getElementById(makeOrderGlobals.modalCheckoutList).innerHTML = '';
    countOrderedToZero('countOrdered');
    resetTotal();
}

function deleteOrder(spotId, orderDataRandomKey) {
    window.location.href =  globalVariables.baseUrl + 'pos/delete/' + orderDataRandomKey + '/' +  spotId;
}

function holdOrder(spotId, saveNameId) {
    let saveName = document.getElementById(saveNameId).value;
    if (!saveName.trim()) {
        alertify.error('Order name is required');
    } else {
        let pos = 1;
        let urlPart ='pos?spotid=' + spotId + '&';
        let send = prepareSendData(pos);
        if (!send) {
            alertify.error('No product(s) in order list');
        }
        send['posOrder'] = {
            'saveName' : saveName,
            'spotId' : spotId
        }
        sendOrderAjaxRequest(send, urlPart);
    }
}

function posTriggerModalClick(modalButtonId) {
    let posResponseDiv = document.getElementById(makeOrderGlobals.posResponse);
    let orderContainer = document.getElementById(makeOrderGlobals.posMakeOrderId);
    posResponseDiv.style.display = 'none';
    orderContainer.style.display  = 'block';
    triggerModalClick(modalButtonId);
    // setRemarkIds();
}

function setRemarkIds() {
    let container = document.getElementById(makeOrderGlobals.posMakeOrderId);
    let remarks = container.getElementsByClassName('remarks');
    let remarksLenght = remarks.length;
    let i;
    for (i = 0; i < remarksLenght; i++) {
        let remark = remarks[i];
        let remarkId = i + '_';
        if (!remark.id) {
            if (remark.dataset.productRemarkId) {
                remarkId += remark.dataset.productRemarkId;
            }
            if (remark.dataset.addonRemarkId) {
                remarkId = remark.dataset.addonRemarkId;
            }
            remark.id = remarkId;
            $(keyboardHtml(remarkId)).insertAfter(remark)
        }
    }
}

function keyboardHtml(targetId) {    
    let keyboard =
        `<div
            class="virtual-keyboard-hook"
            data-target-id="${targetId}"
            data-keyboard-mapping="qwerty"
            style="text-align: center; font-size: 20px;"
        >
            <i class="fa fa-keyboard-o" aria-hidden="true"></i>
        </div>`;
    return keyboard;
}

function posPayment(element) {
    let locked = parseInt(element.dataset.locked);
    if (locked) {
        return;
    }

    element.setAttribute('data-locked', '1');

    let orderedProducts = document.getElementsByClassName(makeOrderGlobals.orderedProducts);
    let orderedProductsLength = orderedProducts.length;

    if (!orderedProductsLength) {
        alertify.error('No product(s) in order list');
        element.setAttribute('data-locked', '0');
        return;
    }

    let data = getOrderExtedned(orderedProducts,orderedProductsLength);
    let post = {
        'vendorId' : makeOrderGlobals.vendorId,
        'oneSignalId' : makeOrderGlobals.oneSignalId,
        'spotId' : makeOrderGlobals.spotId,
        'orderDataRandomKey' : makeOrderGlobals.orderDataRandomKey,
        'pos' : '1',
        'user' : {
            'roleid' : makeOrderGlobals.buyerRoleId,
            'usershorturl' : makeOrderGlobals.buyershorturl,
            'salesagent' : makeOrderGlobals.salesagent,
            'username' : 'pos user',
            'email' : 'posusertest@tiqs.com',
            'mobile' : '1234567890',
            'newsletter' : '0',
        },
        'order' : {
            'waiterTip' : 0,
            'serviceFee' : getServiceFee(data['orderAmount']),
            'amount' : data['orderAmount'],
            'remarks' : '',
            'spotId' : makeOrderGlobals.spotId
        },
        'orderExtended' :  data['orderExtended'],
    }

    let url = globalVariables.baseUrl + 'Alfredinsertorder/posPayment'
    if (makeOrderGlobals['orderDataRandomKey']) {
        url += '/' + makeOrderGlobals['orderDataRandomKey'];
    }
    sendAjaxPostRequest(post, url, 'posPayment', manageResponse, [element]);
    return;
}

function getOrderExtedned(orderedProducts, orderedProductsLength) {
    let orderExtended = [];
    let orderAmount = 0;
    let i;
    let j;
    for (i = 0; i < orderedProductsLength; i++) {
        let orderedItem = orderedProducts[i];
        let product = document.querySelectorAll('#' + orderedItem.id + ' [data-add-product-price]')[0];
        let addons = document.querySelectorAll('#' + orderedItem.id + ' [data-addon-price]');
        let addonsLength = addons.length;
        let mainPrductOrderIndex = 0;
        let subMainPrductOrderIndex = 0;
        let productRemark = ''
        let productOrderItem = new Map();
        let productValue = parseInt(product.value);

        //increase order amount
        orderAmount += productValue * parseFloat(product.dataset.addProductPrice);

        if (product.dataset['remarkId'] !== '0') {
            productRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-product-remark-id="' + product.dataset.remarkId + '"]')[0].value;
        }

        productOrderItem = {
            'productsExtendedId' : product.dataset.productExtendedId,
            'quantity' : productValue,
            'remark' : productRemark,
            'mainPrductOrderIndex' : mainPrductOrderIndex,
            'subMainPrductOrderIndex' : subMainPrductOrderIndex,
        }

        if (!addonsLength) {
            if (productRemark.length || !orderExtended.length) {
                orderExtended.push(productOrderItem);
            } else {
                let orderExtendedLength = orderExtended.length;
                let z;

                for (z = 0; z < orderExtendedLength; z++) {
                    if (orderExtended[z]['productsExtendedId'] === productOrderItem['productsExtendedId']) {
                        orderExtended[z]['quantity'] += productOrderItem['quantity']
                        productOrderItem = false;
                        break;
                    }
                }
                if (productOrderItem) {
                    orderExtended.push(productOrderItem);
                }
            }

        } else {
            mainPrductOrderIndex = i + 1;
            productOrderItem['mainPrductOrderIndex'] = mainPrductOrderIndex;
            orderExtended.push(productOrderItem);

            for (j = 0; j < addonsLength; j++) {
                let addon = addons[j];
                if (addon.parentElement.previousElementSibling.children[0].children[0].checked) {
                    //increase order amount
                    orderAmount +=  parseFloat(addon.value) * parseFloat(addon.dataset.addonPrice);

                    let addonOrderItem = {};
                    let addonRemark = '';
                    if (addon.dataset['remarkId'] !== '0') {
                        addonRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-addon-remark-id="' + addon.dataset.remarkId + '"]')[0].value;
                    }

                    addonOrderItem = {
                        'productsExtendedId' : addon.dataset.addonExtendedId,
                        'quantity' : addon.value,
                        'remark' : addonRemark,
                        'subMainPrductOrderIndex' : mainPrductOrderIndex,
                        'mainPrductOrderIndex' : 0,
                    }
                    orderExtended.push(addonOrderItem);
                }
            }
        }
    }

    let returnData = new Map()
    returnData = {
        'orderAmount' : orderAmount,
        'orderExtended' : orderExtended
    }

    return returnData;
}

function manageResponse(element, data) {
    let orderId = data['orderId'];
    unlockPos(element)
    if (!parseInt(orderId)) {
        alertify.error('Order not made');
        return;
    }
    resetPosOrder();
    removeSavedOrder(data['orderRandomKey']);
    showOrderId(orderId);
    sednNotification(orderId);
    printOrder(orderId);
    return;
}

function unlockPos(element) {
    element.setAttribute('data-locked', '0');
}

function showOrderId(orderId) {
    let responseContainer = document.getElementById(makeOrderGlobals.posResponse);
    let orderContainer = document.getElementById(makeOrderGlobals.posMakeOrderId);    
    let html = '<p>Order is done. Order id is: ' + orderId + '</p>';

    orderContainer.style.display = 'none';
    responseContainer.style.display = 'block';
    responseContainer.innerHTML = html;
}

function sednNotification(orderId) {
    if (!posGlobals.venodrOneSignalId) return
    let url = globalVariables.baseUrl + 'Alfredinsertorder/posSendNoticication/' + orderId + '/' + posGlobals.venodrOneSignalId;
    $.get(url, function(data, status) {});
}

function printOrder(orderId) {
    let justPrint = 'http://localhost/tiqsbox/index.php/Cron/justprint/' + orderId;
    $.get(justPrint, function(data, status) {});
}

function printReportes(vendorId, reportType) {
    let url = globalVariables.baseUrl + 'api/report?vendorid=' + vendorId + '&report=' + reportType;
    $.get(url, function(data, status) {
        let response = JSON.parse(data);
        if (response.status === '1') {
            let tiqsBoxPrintReport = 'http://localhost/tiqsbox/index.php/Cron/printreportes/' + vendorId + '/' + reportType;
            $.get(tiqsBoxPrintReport, function(data, status) {});
        }
    });
}


function getServiceFee(orderAmount) {
    let serviceFee = orderAmount * posGlobals.serviceFeePercent / 100 + posGlobals.minimumOrderFee;
    if (serviceFee > posGlobals.serviceFeeAmount) {
        serviceFee = posGlobals.serviceFeeAmount;
    }
    return serviceFee;
}

function countOrderedToZero(countOrdered) {
    let elements =  document.getElementsByClassName(countOrdered);
    let elementsLength  = elements.length;
    let i;
    for (i = 0; i < elementsLength; i++) {
        elements[i].innerHTML = '0';
    }
}

function removeSavedOrder(orderRandomKey) {
    if (!orderRandomKey) return;
    let optionItem = document.getElementById(orderRandomKey);    
    if (optionItem) optionItem.remove();
    document.getElementById('saveHoldOrder').innerHTML = 'Save order'
}

function showLoginModal() {
    $('#posLoginModal').modal('show');
}

function posLogin(form) {
    let url = globalVariables.ajax + 'posLogin';
    sendFormAjaxRequest(form, url, 'posLogin', posLoginResponse)
    return false;
}

function posLoginResponse(response) {
    if (response['status'] === '0') {
        return;
    } else {
        posGlobals['unlock'] = true;
        $('#posLoginModal').modal('hide');
    }
}

function lockPos() {
    let url = globalVariables.ajax + 'lockPos';
    sendUrlRequest(url, 'lockPos', lockPosRespone);
}

function lockPosRespone(response) {
    if (response['status'] === '1') {
        posGlobals['unlock'] = false;
        showLoginModal();
    } else {
        alertify.error('Pos not locked!');
    }

}

$(document).ready(function(){
    if (typeof makeOrderGlobals === 'undefined') return;
    let sumbitFormButton = document.getElementById(makeOrderGlobals.checkoutContinueButton);
    if (sumbitFormButton) {
        sumbitFormButton.click();
    }
});


resetTotal();
countOrdered('countOrdered');

if (!posGlobals['unlock']) {
    showLoginModal();
    window.onclick = function(e) {    
        showLoginModal();
    }
}
