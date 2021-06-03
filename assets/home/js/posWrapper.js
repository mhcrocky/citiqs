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
    if (isPrinted()) {
        alertify.error('You can not cancel printed order');
        return;
    }
    (makeOrderGlobals['orderDataRandomKey']) ? $('#confirmCancel').modal('show') : resetPosOrder();
}

function resetPosOrder() {
    $('#selectPaymentMethod').modal('hide');
    $('#voucher').modal('hide');

    document.getElementById(makeOrderGlobals.modalCheckoutList).innerHTML = '';
    document.getElementById('selectSaved').value = '';
    document.getElementById('checkoutName').innerHTML = 'Checkout';
    document.getElementById('posOrderName').value = '';
    document.getElementById('codeId').value = '';

    makeOrderGlobals['orderDataRandomKey'] = '';
    posGlobals['selectedOrderName'] = '';
    posGlobals['posOrderId'] = '';
    countOrderedToZero('countOrdered');
    showSavedName();
    showPrintButton();
    resetTotal();
}

function deletePosOrder() {

    let url = globalVariables.ajax  + 'deletePosOrder/' + posGlobals['posOrderId'];
    sendUrlRequest(url, 'deletePosOrder', deletePosOrderResponse, [makeOrderGlobals['orderDataRandomKey']]);
}

function deletePosOrderResponse(orderDataRandomKey, response) {
    if (response['status'] === '1') {
        $('#confirmCancel').modal('hide');
        removeOrderFromSelectList(orderDataRandomKey);
        resetPosOrder();
    }
}

function removeOrderFromSelectList(orderDataRandomKey) {
    $('#selectSaved option[value="' + orderDataRandomKey +'"]').remove();
    if ($('#selectSaved option').length === 1) {
        $(".selectSavedOrdersList").hide();
    }
}

function holdOrder(element) {
    let saveName = posGlobals['posOrderName'].value;
    if (!saveName.trim()) {
        alertify.error('Order name is required');
    } else {
        let locked = parseInt(element.dataset.locked);
        if (locked) return;
        fetchAndSendHoldOrderData();
    }
}

function prepareSendHoldOrderData(orderId = 0) {
    let pos = 1;
    let send = prepareSendData(pos);
    let savedInputName = posGlobals['posOrderName'];
    let saveOrderName = savedInputName.value ? savedInputName.value : posGlobals['spotName'];
    if (!send) {
        alertify.error('No product(s) in order list');
    }

    send['posOrder'] = {
        'saveName' : saveOrderName,
        'spotId' : makeOrderGlobals.spotId,
    }

    if (orderId) {
        send['posOrder']['orderId'] = orderId;
    }

    if (makeOrderGlobals['orderDataRandomKey']) {
        send['orderDataRandomKey'] = makeOrderGlobals['orderDataRandomKey'];
    }
    return send;
}

function fetchAndSendHoldOrderData(orderId = 0) {
    $.ajax({
        url: globalVariables.ajax + 'setOrderSession',
        data: prepareSendHoldOrderData(orderId),
        type: 'POST',
        success: function (response) {
            let data = JSON.parse(response);
            posGlobals['posOrderName'].value = '';
            posGlobals['holdOrderElement'].setAttribute('data-locked', '0');
            $('#holdOrder').modal('hide');
            if (data['status'] !== '0') {
                $(".selectSavedOrdersList").show();
                if (!makeOrderGlobals['orderDataRandomKey']) {
                    $('#selectSaved option[value="' + data['orderRandomKey'] +'"]').remove();
                    $('#selectSaved').append('<option value="' + data['orderRandomKey'] + '">' + data['orderName'] + ' (' + data['lastChange'] + ')</option>');
                    makeOrderGlobals['orderDataRandomKey'] = data['orderRandomKey'];
                } else {
                    let options = document.getElementById('selectSaved').options;
                    let optionsLenght = options.length;
                    let i;
                    for (i = 0; i < optionsLenght; i++) {
                        let option = options[i];
                        if (option.value === data['orderRandomKey']) {
                            option.innerHTML = data['orderName'] + ' (' + data['lastChange'] + ')';
                            break;
                        }
                    }
                }

                posGlobals['posOrderId'] = data['posOrderId'];
                posGlobals['selectedOrderName'] = data['orderName'];
                document.getElementById('checkoutName').innerHTML = ('Checkout ' + data['orderName']  + ' (' + data['lastChange'] + ')');
                document.getElementById('selectSaved').value = data['orderRandomKey'];
                showSavedName();
                showPrintButton();

                if (orderId) {
                    fetchSavedOrder(posGlobals['selectSavedElement']);
                }

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

function posTriggerModalClick(modalButtonId) {
    let posResponseDiv = document.getElementById(makeOrderGlobals.posResponse);
    let orderContainer = document.getElementById(makeOrderGlobals.posMakeOrderId);
    posResponseDiv.style.display = 'none';
    orderContainer.style.display  = 'block';
    triggerModalClick(modalButtonId);
}

function updateToPrinted(orderId) {
    let elements = document.querySelectorAll('#' + makeOrderGlobals['posMakeOrderId'] + ' [data-printed="0"]');
    let elementsLength = elements.length;
    let i;
    for (i = 0; i < elementsLength; i++) {
        let element = elements[i];
        element.setAttribute('data-printed', '1');
    }
    fetchAndSendHoldOrderData(orderId);
}

function posPayOrder(element) {
    let locked = parseInt(element.dataset.locked);
    if (locked) return;

    element.setAttribute('data-locked', '1');

    let post = prepearePosPost(element);
    let url = globalVariables.baseUrl + 'Alfredinsertorder/posPayment'

    sendAjaxPostRequest(post, url, 'posPayOrder', posPayOrderResponse, [element]);
    return;
}

function prepearePosPost(element, code = null) {
    let orderedProducts = document.getElementsByClassName(makeOrderGlobals.orderedProducts);
    let orderedProductsLength = orderedProducts.length;

    if (!orderedProductsLength) {
        alertify.error('No product(s) in order list');
        element.setAttribute('data-locked', '0');
        return;
    }

    let data = getOrderExtedned(orderedProducts, orderedProductsLength);
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
            'paid' : element.dataset.paid,
            'paymentType' : element.dataset.paymentMethod
        },
        'orderExtended' :  data['orderExtended'],
    }

    if (posGlobals['posOrderId']) {
        post['posOrderId'] = posGlobals['posOrderId'];
    }

    if (code) {
        post['code'] = code;
    }

    return post;
}

function getOrderExtedned(orderedProducts, orderedProductsLength) {
    let orderExtended = [];
    let orderAmount = 0;
    let i;
    let j;
    for (i = 0; i < orderedProductsLength; i++) {
        let orderedItem = orderedProducts[i];
        let product = document.querySelectorAll('#' + orderedItem.id + ' [data-add-product-price]')[0];
        if (product.dataset.printed === '1') continue;
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
    unlockPos(element);

    if (data['redirect']) {
        redirectToNewLocation(data['redirect']);
        return;
    }

    if (data['status'] === '0') {
        alertifyAjaxResponse(data);
        return;
    }

    if (data['status'] === '1' && data['paid'] === '1') {
        payResponse(data);
        return;
    }

    if (data['status'] === '1' && data['print'] === '1') {
        alertify.success('Request for printing sent');
        updateToPrinted(data['orderId']);
        return;
    }

    return;
}

function payResponse(data) {
    let orderId = data['orderId'];
    removeOrderFromSelectList(makeOrderGlobals['orderDataRandomKey']);
    showOrderId(orderId);
    if (posGlobals['posOrderId']) {
        deletePosOrder();
    }
    // sednNotification(orderId);
    // printOrder(orderId);
    resetPosOrder();
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
    if (!makeOrderGlobals.oneSignalId) return
    let url = globalVariables.baseUrl + 'Alfredinsertorder/posSendNoticication/' + orderId + '/' + makeOrderGlobals.oneSignalId;
    $.get(url, function(data, status) {});
}

// function printOrder(orderId) {
//     let justPrint = 'http://localhost/tiqsbox/index.php/Cron/justprint/' + orderId;
//     $.get(justPrint, function(data, status) {});
// }

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

function showLoginModal() {
    // TO DO COMMENT NEXT TWO LINES BEFORE PUSH !!!!!!!!!!!!!!!!!!!!!!!
    // $('#posLoginModal').modal('hide');
    // return;
    if (!posGlobals['unlock']) {
        $('#posLoginModal').modal('show');
    }
}

function posLogin() {
    let url = globalVariables.ajax + 'posLogin';
    let pin = posGlobals['pinCodeELement'].value;
    if (!pin) {
        alertify.error('PIN is required');
        return;
    }

    let post = {
        'posPin' : pin
    }

    sendAjaxPostRequestImproved(post, url, posLoginResponse)

    return;
}

function posLoginResponse(response) {
    if (response['status'] === '0') {
        alertify.error('Invalid PIN');
        return;
    } else {
        posGlobals['pinCodeELement'].value = '';
        posGlobals['pinCodeELement'].setAttribute('value', '');
        posGlobals['unlock'] = true;
        posGlobals['posManager'] = (response['posManager'] === '1') ? true : false;
        toggleManagerButton();
        $('#posLoginModal').modal('hide');
        posGlobals['checkActivityId'] = checkActivity();
    }
}

function toggleManagerButton() {
    let displayValue = posGlobals['posManager'] ? 'initial' : 'none';
    posGlobals['managerButton'].style.display = displayValue;
}

function lockPos() {
    let url = globalVariables.ajax + 'lockPos';
    sendUrlRequest(url, 'lockPos', lockPosRespone);
}

function lockPosRespone(response) {
    if (response['status'] === '1') {
        posGlobals['unlock'] = false;
        posGlobals['posManager'] = false;
        showLoginModal();
        clearActivtiyInterval();
        toggleManagerButton()
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
    }, 20000);
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
        makeOrderGlobals['orderDataRandomKey'] = element.value;
        posGlobals['selectedOrderName'] = response['posOrderName'];
        posGlobals['posOrderId'] = response['posOrderId'];

        document.getElementById(makeOrderGlobals['modalCheckoutList']).innerHTML = response['checkoutList'];
        document.getElementById('checkoutName').innerHTML = 'Checkout ' + response['posOrderName'] + ' (' + response['lastChange'] + ')';
        resetTotal();
        countOrdered('countOrdered');
        showSavedName();
        showPrintButton();
    }
}

function toogleSelectSavedOrders() {
    if (!posGlobals.hasOwnProperty('spotPosOrders') || !posGlobals['spotPosOrders']) {
        $(".selectSavedOrdersList").hide();
    }
}

function showSavedName() {
    document.getElementById('posOrderName').value = posGlobals['selectedOrderName'];
}

function showPrintButton() {
    return;
    let displayElement  = posGlobals['selectedOrderName'] ? 'block' : 'none';
    document.getElementById('posPrintButton').style.display = displayElement;
}

function posVoucherPay(element, codeId) {
    // let locked = parseInt(element.dataset.locked);
    // if (locked) return;
    // element.setAttribute('data-locked', '1');

    let codeElement = document.getElementById(codeId);
    let code = codeElement.value.trim();
    if (code) {
        let post = prepearePosPost(element, code);
        let url = globalVariables.ajax + 'posVoucherPay';
        sendAjaxPostRequest(post, url, 'posVoucherPay', posVoucherPayResponse, [element]);
    } else {
        alertify.error('Code is required');
    }
}

function posVoucherPayResponse(element, response) {
    if (response['status'] === '1') {
        let url = globalVariables.baseUrl + 'Alfredinsertorder/posPayment';
        sendAjaxPostRequest(response['order'], url, 'posPayOrder', posPayOrderResponse, [element]);
        return;
    }

    // handle select payment method

    alertifyAjaxResponse(response);
}

function isPrinted() {
    if (makeOrderGlobals.hasOwnProperty('posMakeOrderId')) {
        let elements = document.querySelectorAll('#' + makeOrderGlobals['posMakeOrderId'] + ' [data-printed="1"]');
        return elements.length ? true : false;
    }
    return false;
}


function redirectToSpot(location) {
    redirectToNewLocation(location);
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