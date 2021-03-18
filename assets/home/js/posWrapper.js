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

function cancelPosOrder() {
    if (posGlobals['selectedOrderRandomKey']) {
        $('#confirmCancel').modal('show');
    } else {
        resetPosOrder();
    }
}

function resetPosOrder() {
    document.getElementById(makeOrderGlobals.modalCheckoutList).innerHTML = '';
    document.getElementById('selectSaved').value = '';
    document.getElementById('checkoutName').innerHTML = 'Checkout';
    document.getElementById('posOrderName').value = '';

    posGlobals['selectedOrderRandomKey'] = '';
    posGlobals['selectedOrderName'] = '';
    posGlobals['selectedOrderShortName'] = '';

    countOrderedToZero('countOrdered');
    resetTotal();
}

function deletePosOrder() {
    if (posGlobals['selectedOrderRandomKey'] && makeOrderGlobals['spotId']) {
        let url = globalVariables.ajax  + 'deletePosOrder/' + posGlobals['selectedOrderRandomKey'] + '/' + makeOrderGlobals['spotId'];
        sendUrlRequest(url, 'deletePosOrder', deletePosOrderResponse);
    }
}

function deletePosOrderResponse(response) {
    if (response['status'] === '1') {
        $('#selectSaved option[value="' + posGlobals['selectedOrderRandomKey'] +'"]').remove();
        if ($('#selectSaved option').length === 1) {
            $(".selectSavedOrdersList").hide();
        }
        resetPosOrder();
        $('#confirmCancel').modal('hide');     
    }
}

function holdOrder(element, saveNameId) {
    let savedInputName = document.getElementById(saveNameId);
    let saveName = savedInputName.value;

    if (!saveName.trim()) {
        alertify.error('Order name is required');
    } else {
        let locked = parseInt(element.dataset.locked);
        if (locked) return;

        let pos = 1;
        let send = prepareSendData(pos);
        if (!send) {
            alertify.error('No product(s) in order list');
        }
        send['posOrder'] = {
            'saveName' : saveName,
            'spotId' : makeOrderGlobals.spotId,
        }

        // console.dir(send);
        // return;

        if (posGlobals['selectedOrderRandomKey']) {
            send['orderDataRandomKey'] = posGlobals['selectedOrderRandomKey'];
        }

        $.ajax({
            url: globalVariables.ajax + 'setOrderSession',
            data: send,
            type: 'POST',
            success: function (response) {
                let data = JSON.parse(response);
                savedInputName.value = '';
                element.setAttribute('data-locked', '0');
                $('#holdOrder').modal('hide');
                if (data['status'] !== '0') {
                    $(".selectSavedOrdersList").show();
                    if (!posGlobals['selectedOrderRandomKey']) {
                        $('#selectSaved').append('<option value="' + data['orderRandomKey'] + '">' + data['orderName'] + '</option>');
                        posGlobals['selectedOrderRandomKey'] = data['orderRandomKey'];
                    } else {
                        let options = document.getElementById('selectSaved').options;
                        let optionsLenght = options.length;
                        let i;
                        for (i = 0; i < optionsLenght; i++) {
                            let option = options[i];
                            if (option.value === data['orderRandomKey']) {
                                option.innerHTML = data['orderName'];
                                break;
                            }
                        }
                    }

                    posGlobals['selectedOrderName'] = data['orderName'];
                    posGlobals['selectedOrderShortName'] = data['orderShortName'];

                    document.getElementById('checkoutName').innerHTML = ('Checkout ' + data['orderName']);
                    // document.getElementById('posOrderName').value = data['orderShortName'];
                    document.getElementById('selectSaved').value = data['orderRandomKey'];
                } else {
                    alertify.error('Process failed! Check order details')
                }
            },
            error: function (err) {
                savedInputName.value = '';
                element.setAttribute('data-locked', '0');
                console.dir(err);
            }
        });
    }
}

function posTriggerModalClick(modalButtonId) {
    let posResponseDiv = document.getElementById(makeOrderGlobals.posResponse);
    let orderContainer = document.getElementById(makeOrderGlobals.posMakeOrderId);
    posResponseDiv.style.display = 'none';
    orderContainer.style.display  = 'block';
    triggerModalClick(modalButtonId);
}

function posPayOrder(element) {
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
            'spotId' : makeOrderGlobals.spotId,
            'isPos' : '1',
            'posPrint' : '0',
            'paid' : element.dataset.paid
        },
        'orderExtended' :  data['orderExtended'],
    }

    let url = globalVariables.baseUrl + 'Alfredinsertorder/posPayment'

    sendAjaxPostRequest(post, url, 'posPayOrder', posPayOrderResponse, [element]);
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

function posPayOrderResponse(element, data) {
    let orderId = data['orderId'];
    unlockPos(element)
    if (element.dataset.paid === '1') {
        payResponse(orderId);
    } else {
        updateResponse(orderId);
        alertify.error('Order not paid');
    }
    return;
}

function payResponse(orderId) {
    if (!parseInt(orderId)) {
        alertify.error('Order not made');
        return;
    }
    deletePosOrder();
    resetPosOrder();
    showOrderId(orderId);
    sednNotification(orderId);
    printOrder(orderId);
    return;
}

function updateResponse(orderId) {
    if (!parseInt(orderId)) {
        alertify.error('Order not saved');
        return;
    }
    alertify.success('Order saved');
    $('#holdOrder').modal('hide');
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

// function removeSavedOrder(orderRandomKey) { // TO DO UPDATE
//     if (!orderRandomKey) return;
//     let optionItem = document.getElementById(orderRandomKey);    
//     if (optionItem) optionItem.remove();
//     document.getElementById('saveHoldOrder').innerHTML = 'Save order'
// }

function showLoginModal() {
    return true;
    if (!posGlobals['unlock']) {
        $('#posLoginModal').modal('show');
    }
}

function posLogin(form) {
    if (!validateFormData(form)) return false;

    let url = globalVariables.ajax + 'posLogin';

    sendFormAjaxRequest(form, url, 'posLogin', posLoginResponse, [form])

    return false;
}

function posLoginResponse(form, response) {
    if (response['status'] === '0') {
        return;
    } else {
        form.reset();
        posGlobals['unlock'] = true;
        $('#posLoginModal').modal('hide');
        posGlobals['checkActivityId'] = checkActivity();
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
        clearActivtiyInterval();
    } else {
        alertify.error('Pos not locked!');
    }
}

function resetCounter() {
    if (posGlobals['unlock']) {
        posGlobals['counter'] = 0;
        clearInterval(posGlobals['checkActivityId']);
        posGlobals['checkActivityId'] = checkActivity();
    }
}

function checkActivity() {
    return setInterval( function() {
        if (posGlobals['unlock']) {
            posGlobals['counter'] = posGlobals['counter'] + 10;
            if (!(posGlobals['counter'] % 30)) {
                lockPos();
            }
        }
    }, 10000);
}

function clearActivtiyInterval() {
    posGlobals['counter'] = 0;
    clearInterval(posGlobals['checkActivityId']);
}

function fetchSavedOrder(element) {
    let orderDataRandomKey = element.value;
    if (!orderDataRandomKey) {
        resetPosOrder();
        return;
    };

    makeOrderGlobals['orderDataRandomKey'] = orderDataRandomKey;

    let url = globalVariables.ajax + 'fetchSavedOrder';
    let post  = {
        'spotId' : makeOrderGlobals.spotId,
        'orderDataRandomKey' : orderDataRandomKey
    }

    sendAjaxPostRequest(post, url, 'fetchSavedOrder', fetchSavedOrderResponse, [element]) 
}

function fetchSavedOrderResponse(element, response) {
    if (response) {
        posGlobals['selectedOrderRandomKey'] = element.value;
        posGlobals['selectedOrderName'] = response['posOrderName'];        
        document.getElementById(makeOrderGlobals['modalCheckoutList']).innerHTML = response['checkoutList'];
        document.getElementById('checkoutName').innerHTML = 'Checkout ' + response['posOrderName'];
        resetTotal();
        countOrdered('countOrdered');
    }
}

function toogleSelectSavedOrders() {
    if (!posGlobals['spotPosOrders']) {
        $(".selectSavedOrdersList").hide();
    }
}

toogleSelectSavedOrders();
resetTotal();
countOrdered('countOrdered');
showLoginModal();
runKeyboard('posKeyboard');

posGlobals['checkActivityId'] = checkActivity();

window.onclick = function(e) {    
    showLoginModal();
    resetCounter();
    runKeyboard('posKeyboard');
}

window.onkeyup = function(e) {
    if (e.keyCode === 27) {
        showLoginModal();
    }
}

window.onkeydown = function(e) {
    if (e.keyCode === 27) {
        showLoginModal();
    }
}

window.onmousemove = function(e) {
    resetCounter();
}
