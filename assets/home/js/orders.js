'use strict';

function populateTable(elementId, orders) {
    let tableBody = '';
    let orderId;
    let order;
    let orderDetails;
    
    for (orderId in orders) {
        orderDetails = orders[orderId];
        order = orderDetails[0];
        console.dir(orderDetails);
        console.dir(order);
        tableBody +=    '<tr>';
        tableBody +=        '<th>' + order['orderId'] + '</th>';
        tableBody +=        '<th></th>';
        tableBody +=        '<th>' + order['orderAmount'] + '</th>';
        tableBody +=        '<th>Change status</th>';
        tableBody +=        '<th>' + order['orderStatus'] + '</th>';
        tableBody +=        '<th>' + order['buyerUserName'] + '</th>';
        tableBody +=        '<th>' + order['buyerMobile'] + '</th>';
        tableBody +=    '</tr>';
    }
    $('#' + elementId).html(tableBody);
}

function fetchOrders() {
    let url = globalVariables.ajax + 'fetchOrders'
    let post = {
        paid: '1',
        orderStatus: orderGlobals.orderFinished
    }
    sendAjaxPostRequest(post, url, 'fetchOrders', populateTable, [orderGlobals.tableId])
}

fetchOrders();
