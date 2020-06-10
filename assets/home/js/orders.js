'use strict';

function populateTable(elementId, skiptStatus, orders) {
    let tableBody = '';
    let orderId;
    let order;
    let orderDetails;
    
    for (orderId in orders) {
        orderDetails = orders[orderId];
        order = orderDetails[0];
        if (order['orderStatus'] !== skiptStatus) {
            tableBody +=    '<tr>';
            tableBody +=        '<th>' + order['orderId'] + '</th>';
            tableBody +=        '<th>' + showOrderProducts(orderDetails) + '</th>';
            tableBody +=        '<th>' + order['orderAmount'] + '</th>';
            tableBody +=        '<th>' + showOrderStatuses(orderGlobals.orderStatuses, order['orderId'], order['orderStatus']) + '</th>';
            tableBody +=        '<th>' + order['orderStatus'] + '</th>';
            tableBody +=        '<th>' + order['buyerUserName'] + '</th>';
            tableBody +=        '<th ';
            tableBody +=            'data="order-id=' + order['orderId'] + '" ';
            tableBody +=            'data="buyer-mobile=' + order['buyerMobile'] + '">' + order['buyerMobile'];
            tableBody +=        '</th>';
            tableBody +=    '</tr>';
        }        
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

fetchOrders();
