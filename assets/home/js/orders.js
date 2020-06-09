'use strict';


function fetchOrders() {
    let url = globalVariables.ajax + 'fetchOrders'
    let post = {
        paid: '1',
        orderStatus: orderGlobals.orderFinished
    }
    sendAjaxPostRequest(post, url, 'fetchOrders')
}



fetchOrders();