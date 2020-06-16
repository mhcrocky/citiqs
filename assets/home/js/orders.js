'use strict';

function populateTable(elementId, skiptStatus, orders) {
    let tableBody = '';
    let orderId;
    let order;
    let orderDetails;
    let finishedClass;
    for (orderId in orders) {
        orderDetails = orders[orderId];
        order = orderDetails[0];
        finishedClass = order['orderStatus'] === skiptStatus ? 'finished hideRow' : 'notFinished';
        tableBody +=    '<tr class="' + finishedClass + '">';
        tableBody +=        '<th>' + order['orderId'] + '</th>';
        tableBody +=        '<th>' + showOrderProducts(orderDetails) + '</th>';
        tableBody +=        '<th>' + order['orderAmount'] + '</th>';
        tableBody +=        '<th>' + order['spotName'] + '</th>';
        tableBody +=        '<th>' + showOrderStatuses(orderGlobals.orderStatuses, order['orderId'], order['orderStatus']) + '</th>';
        tableBody +=        '<th>' + order['orderStatus'] + '</th>';
        tableBody +=        '<th>' + order['buyerUserName'] + '</th>';
        tableBody +=        '<th>' + showPhoneNumber(order) + '</th>';
        tableBody +=        '<th>' + order['buyerEmail'] + '</th>';
        tableBody +=        '<th>';
        if (order['sendSms'] === '0') {
            let disabled = order['orderStatus'] === 'done' ? '' : 'disabled';
            tableBody += '<button class="btn btn-primary" ' + disabled + ' ';
            tableBody +=    'data-order-id=' + order['orderId'] + '" ';
            tableBody +=    'data-buyer-mobile=' + order['buyerMobile'] + '" ';
            tableBody +=    'data-message="Je kan je eten afhalen bij de keuken" ';
            tableBody +=    'onclick="sendSms(this)"';
            tableBody += '>Send sms</button>';
        } else {
            tableBody += 'Sms send'
        }
        tableBody +=        '</th>';
        tableBody +=    '</tr>';
    }
    $('#' + elementId).html(tableBody);
}

function showOrderStatuses(orderStatuses, orderId, orderStatus) {
    let orderStatusesLength = orderStatuses.length;
    let status;
    let i;
    let select = '<select data-order-id="' + orderId + '" onchange="changeStatus(this)">'
    for (i = 0; i < orderStatusesLength; i++) {
        status = orderStatuses[i];
        select += '<option value="'  + status + '" ';
        if (status === orderStatus) {
            select += 'selected ';
        }
        select += '>'  + status + '</option>';
    }
    select += '</select>';
    return select;
}

function showOrderProducts(products) {
    let productsLength = products.length;
    let product;
    let i;
    let list = '<ol>';
    for (i = 0; i < productsLength; i++) {
        product = products[i];
        list += '<li>Product: ' + product.productName + ' Quantity: ' + product.productQuantity + '</li>';
    }
    list += '</ol>';
    return list;
}

function changeStatus(element) {
    let url = globalVariables.ajax + 'updateOrder/' + element.dataset.orderId;
    let post = {
        orderStatus : element.value
    }
    sendAjaxPostRequest(post, url, 'changeStatus', fetchOrders);
}

function fetchOrders() {
    
    let url = globalVariables.ajax + 'fetchOrders'
    let post = {
        paid: '1',
        orderStatus: orderGlobals.orderFinished
    }
    sendAjaxPostRequest(post, url, 'fetchOrders', populateTable, [orderGlobals.tableId, orderGlobals.orderFinished]);
}

function sendSms(element) {
    let url = globalVariables.ajax + 'sendSms/' + element.dataset.orderId;
    let post = {
        mobilenumber: element.dataset.buyerMobile,
        messagetext: element.dataset.message
    }
    sendAjaxPostRequest(post, url, 'sendSms', fetchOrders);
}

function showPhoneNumber(order) {
    let phoneNumber = ''
    phoneNumber += '<input type="text" ';
    phoneNumber += 'value="' + order['buyerRawMobile'] + '" ';
    phoneNumber += 'data-user-id="' + order['buyerId'] + '" ';
    phoneNumber += 'onchange="updatePhoneNumber(this)" ';
    phoneNumber += 'required />';

    return phoneNumber;
}

function updatePhoneNumber(element) {
    let url = globalVariables.ajax + 'updateUser/' + element.dataset.userId;
    let post = {
        mobile: element.value
    }
    sendAjaxPostRequest(post, url, 'updatePhoneNumber', fetchOrders);
}

function toggleFinished(element, toggleClas) {
    $('.' + element.value).removeClass(toggleClas);
    $('.' + element.dataset.hide).addClass(toggleClas);
}

fetchOrders();

// fetch new data every 300 seconds
setInterval(function(){return fetchOrders()}, 300000);