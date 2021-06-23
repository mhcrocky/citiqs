'use strict';
function loadTable(tableId) {
    $('#' + tableId).DataTable({
        ajax : {
            url :  globalVariables.baseUrl + 'get_buyer_orders',
        },
        "columnDefs": [
            {
                "targets": 0,
                "data": function(row, type, val, meta) {
                    return row.orderId;
                }
            },
            {
                "targets": 1,
                "data": function(row, type, val, meta) {
                    return row.orderAmount;
                }
            },
            {
                "targets": 2,
                "data": function(row, type, val, meta) {
                    return row.serviceFee;
                }
            },
            {
                "targets": 3,
                "data": function(row, type, val, meta) {
                    return row.waiterTip;
                }
            },
            {
                "targets": 4,
                "data": function(row, type, val, meta) {
                    return row.refundAmount;
                }
            },
            {
                "targets": 5,
                "data": function(row, type, val, meta) {
                    return row.voucherAmount;
                }
            },
            {
                "targets": 6,
                "data": function(row, type, val, meta) {
                    return getTotalOrderAmount(row);
                }
            },
            {
                "targets": 7,
                "data": function(row, type, val, meta) {
                    return row.voucherCode;
                }
            },
            {
                "targets": 8,
                "data": function(row, type, val, meta) {
                    return row.created;
                }
            },
            {
                "targets": 9,
                "data": function(row, type, val, meta) {
                    return row.vendorUserName;
                }
            },
            {
                "targets": 10,
                "data": function(row, type, val, meta) {
                    return row.spotName;
                }
            },
            {
                "targets": 11,
                "data": function(row, type, val, meta) {
                    return row.spotType;
                }
            },
            {
                "targets": 12,
                "data": function(row, type, val, meta) {
                    return row.paymentMethod;
                }
            },
            {
                "targets": 13,
                "data": function(row, type, val, meta) {
                    return getOrderDetails(row);
                }
            },
        ]
    });
}

function getTotalOrderAmount(row) {
    let amount = 0;

    amount += parseFloat(row.orderAmount);
    amount += parseFloat(row.serviceFee);
    amount += parseFloat(row.waiterTip);
    amount -= parseFloat(row.refundAmount);
    amount -= parseFloat(row.voucherAmount);

    return amount.toFixed(2);
}

function getOrderDetails(row) {
    let property;
    let details = '';

    details += '<span ';
    details +=      'title="Click to see details" ';
    details +=      'class="orderDetails" ';
    details +=      'onclick="getOrderProducts(this)" ';
    for (property in row) {
        details +=      'data-' + property.toLowerCase() + '="' + row[property] + '" ';
    }

    details += '>Details</span>';
    return details;
}

function getOrderProducts(element) {
    let orderData = element.dataset;
    let url = globalVariables.baseUrl + 'fetch_order/' + orderData.orderid;
    sendGetRequest(url, showOrderDetais, [orderData]);
}

function showOrderDetais(orderData, products) {
    $('#orderDetails').modal('show');
    let key;
    for (key in orderData) {
        populateHtmlElement(key, orderData[key]);
    }
    showProducts(products);
    setReceiptHref(orderData['orderid']);
}

function populateHtmlElement(id, value) {
    if ($('#' + id).length) {
        $('#' + id).empty().html(value);
    }
    return;
}

function showProducts(products) {
    let productsLength = products.length;
    let i;
    let html = '';

    for (i = 0; i < productsLength; i++) {
        let product = products[i];
        html += '<li class="list-group-item">';
        html +=     product['productName'];
        html +=     ' #' + product['productQuantity'];
        html +=     ' (' + product['productPrice'] + ' &euro;)';
        html += '</li>';
    }

    $('#products').empty().html(html);
    return;
}

function setReceiptHref(orderId) {
    let href = globalVariables.baseUrl + 'receipts/' + orderId + '-email.png';
    document.getElementById('receiptLink').setAttribute('href', href);
}

loadTable(buyerOrders['tableId']);
