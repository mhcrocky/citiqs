'use strict';
function showOrderProducts(data) {
    let products = data[1];
    let i;
    let list = '<ol>';
    for (i in products) {
        if (i === 'spotPrinter') continue;
        let product;
        let printer;
        product = products[i];
        if (product['productPrinter']) {
            printer = (products['spotPrinter'] === product['productPrinter'][0]) ? products['spotPrinter'] : product['productPrinter'][0];
        } else {
            printer = products['spotPrinter'];
        }

        
        list += '<li style="text-align:left">Product: ' + product.productName + ' ';
        list += '| Quantity: ' + product.productQuantity + ' ';
        list += '| Printer: ' + printer + '</li>';
    }
    list += '</ol>';
    return list;
}

function showOrderStatuses(orderStatuses, data) {
    let orderStatusesLength = orderStatuses.length;
    let status;
    let i;
    let select = '<select data-order-id="' + data[0] + '" onchange="changeStatus(this)">'
    for (i = 0; i < orderStatusesLength; i++) {
        status = orderStatuses[i];
        select += '<option value="'  + status + '" ';
        if (status === data[4]) {
            select += 'selected ';
        }
        select += '>'  + status + '</option>';
    }
    select += '</select>';
    return select;
}

function changeStatus(element) {
    let url = globalVariables.ajax + 'updateOrder/' + element.dataset.orderId;
    let post = {
        orderStatus : element.value
    }
    sendAjaxPostRequest(post, url, 'changeStatus', destroyAndFetch);
}


function showPhoneNumber(data) {
    let number = (data[8]) ? data[8] : '';
    let phoneNumber = ''
    phoneNumber += '<input type="text" ';
    phoneNumber += 'id="' + data[10] + '" ';
    phoneNumber += 'value="' + number + '" ';
    phoneNumber += 'data-user-id="' + data[10] + '" ';
    phoneNumber += 'onchange="updatePhoneNumber(this)" ';
    phoneNumber += 'required />';

    return phoneNumber;
}

function updatePhoneNumber(element) {
    let url = globalVariables.ajax + 'updateUser/' + element.dataset.userId;
    let post = {
        mobile: element.value
    }
    sendAjaxPostRequest(post, url, 'updatePhoneNumber', destroyAndFetch);
}

function sendSmsButton(data) {
    let button = '';
    if (data[9] === '0') {
        let disabled = data[4] === 'done' ? '' : 'disabled';
        button += '<button class="btn btn-primary" ' + disabled + ' ';
        button +=    'data-order-id=' + data[0] + '" ';
        button +=    'data-mobile="' + data[10] + '" ';
        button +=    'data-message="Jouw bestelling \'' + data[0] + '\' staat klaar in de keuken" ';
        button +=    'data-recipent="buyer" ';
        button +=    'onclick="sendSms(this)"';
        button += '>SMS</button>';
    } else {
        button += 'Sent'
    }
    return button;
}

function sendSms(element) {
    let url = globalVariables.ajax + 'sendSms/' + element.dataset.orderId;
    let post = {
        mobilenumber: document.getElementById(element.dataset.mobile).value,
        messagetext: element.dataset.message,
        recipent: element.dataset.recipent
    }
    sendAjaxPostRequest(post, url, 'sendSms', destroyAndFetch);
}

function populateTable(data) {
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';
        $('#ordersList tfoot th').each( function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100px" />');
        });
    
        $('#ordersList').DataTable({
            data: data,
            order: [[5, 'desc' ]],
            pagingType: "first_last_numbers",
            pageLength:10,
            columnDefs: [
                {
                    "targets": 1,
                    "data": function (row, type, val, meta) {
                        return showOrderProducts(row);
                    }
                },
                {
                    "targets": 2,
                    "visible": false,
                    "searchable": false,
                },
                {
                    "targets": 4,
                    "data": function (row, type, val, meta) {
                        return showOrderStatuses(orderGlobals.orderStatuses, row);
                    }
                },
                {
                    "targets": 8,
                    "data": function (row, type, val, meta) {
                        return showPhoneNumber(row);
                    }
                },
                {
                    "targets": 9,
                    "data": function (row, type, val, meta) {
                        return sendSmsButton(row);
                    }
                }            
            ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;
    
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        console.dir(this.value);
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    });
                });
            }
        });
    });
}

function fetchOrders() {    
    let url = globalVariables.ajax + 'fetchOrders'
    let post = {
        paid: '1',
        orderStatus: orderGlobals.orderFinished
    }
    sendAjaxPostRequest(post, url, 'fetchOrders', populateTable);
}

function destroyAndFetch() {
    $('#ordersList').DataTable().destroy();
    return fetchOrders();
}

document.addEventListener("DOMContentLoaded", function() {
    fetchOrders();
    // fetch new data every 10 seconds
    setInterval(function() {
        $('#ordersList').DataTable().destroy();
        return fetchOrders();
    }, 10000);
    
});

// function populateTable(elementId, skiptStatus, orders) {
//     let ordersLength = orders.length;
//     let i;
//     let tableBody = '';
//     let order;

//     for(i = 0 ; i < ordersLength; i++) {
//         order = orders[i];
//         console.dir(order);
//         tableBody +=    '<tr>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=        '<th>' + order['orderId'] + '</th>';
//         tableBody +=    '</tr>';

//     }
//     $('#' + elementId).html(tableBody);

//     // let tableBody = '';
//     // let orderId;
//     // let order;
//     // let orderDetails;
//     // let finishedClass;
//     // console.dir(orders);
//     // for (orderId in orders) {
//     //     orderDetails = orders[orderId];
//     //     order = orderDetails[0];
        
//     //     finishedClass = order['orderStatus'] === skiptStatus ? 'finished hideRow' : 'notFinished';
//     //     tableBody +=    '<tr class="' + finishedClass + '">';
//     //     tableBody +=        '<th>' + order['orderId'] + '</th>';
//     //     tableBody +=        '<th>' + showOrderProducts(orderDetails) + '</th>';
//     //     tableBody +=        '<th>' + order['orderAmount'] + '</th>';
//     //     tableBody +=        '<th>' + order['spotName'] + '</th>';
//     //     tableBody +=        '<th>' + showOrderStatuses(orderGlobals.orderStatuses, order['orderId'], order['orderStatus']) + '</th>';
//     //     tableBody +=        '<th>' + order['orderStatus'] + '</th>';
//     //     tableBody +=        '<th>' + order['buyerUserName'] + '</th>';
//     //     tableBody +=        '<th>' + showPhoneNumber(order) + '</th>';
//     //     tableBody +=        '<th>' + order['buyerEmail'] + '</th>';
//     //     tableBody +=        '<th>';
//     //     if (order['sendSms'] === '0') {
//     //         let disabled = order['orderStatus'] === 'done' ? '' : 'disabled';
//     //         tableBody += '<button class="btn btn-primary" ' + disabled + ' ';
//     //         tableBody +=    'data-order-id=' + order['orderId'] + '" ';
//     //         tableBody +=    'data-mobile="' + order['buyerMobile'] + '" ';
//     //         tableBody +=    'data-message="Jouw bestelling \'' + order['orderId'] + '\' staat klaa" ';
//     //         tableBody +=    'data-recipent="buyer" ';
//     //         tableBody +=    'onclick="sendSms(this)"';
//     //         tableBody += '>Send sms</button>';
//     //     } else {
//     //         tableBody += 'Sms send (buyer)'
//     //     }
//     //     tableBody +=        '<th>';
//     //     // if (order['sendSmsDriver'] === '0') {
//     //     //     console.dir(order['driverNumber']);
//     //     //     if (order['driverNumber']) {
//     //     //         let disabled = order['orderStatus'] === 'done' ? '' : 'disabled';
//     //     //         tableBody += '<button class="btn btn-primary" ' + disabled + ' ';
//     //     //         tableBody +=    'data-order-id=' + order['orderId'] + '" ';
//     //     //         tableBody +=    'data-mobile="' + order['driverNumber'] + '" ';
//     //     //         tableBody +=    'data-message="Order staat klaar bij ' + orderGlobals.vendorName + '" ';
//     //     //         tableBody +=    'data-recipent="driver" ';
//     //     //         tableBody +=    'onclick="sendSms(this)"';
//     //     //         tableBody += '>Send sms</button>';
//     //     //     } else {
//     //     //         tableBody += '<a href="' + globalVariables.baseUrl + 'profile">SET DRIVER NUMBER</a>';
//     //     //     }
            
//     //     // } else {
//     //     //     tableBody += 'Sms send (driver)'
//     //     // }
//     //     tableBody +=        '</th>';
//     //     tableBody +=    '</tr>';
//     // }
//     $('#' + elementId).html(tableBody);
// }

// function showOrderStatuses(orderStatuses, orderId, orderStatus) {
//     let orderStatusesLength = orderStatuses.length;
//     let status;
//     let i;
//     let select = '<select data-order-id="' + orderId + '" onchange="changeStatus(this)">'
//     for (i = 0; i < orderStatusesLength; i++) {
//         status = orderStatuses[i];
//         select += '<option value="'  + status + '" ';
//         if (status === orderStatus) {
//             select += 'selected ';
//         }
//         select += '>'  + status + '</option>';
//     }
//     select += '</select>';
//     return select;
// }

// function showOrderProducts(products) {
//     let productsLength = products.length;
//     let product;
//     let i;
//     let list = '<ol>';
//     for (i = 0; i < productsLength; i++) {
//         product = products[i];
//         list += '<li>Product: ' + product.productName + ' Quantity: ' + product.productQuantity + '</li>';
//     }
//     list += '</ol>';
//     return list;
// }









