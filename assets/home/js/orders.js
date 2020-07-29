'use strict';
function showOrderProducts(data) {
    if(!data) return;
    let products = data[1];
    let i;
    let list = '<ol>';
    for (i in products) {
        if (i === 'spotPrinter') continue;
        let product;
        let printer;
        product = products[i];
        if (!product) continue;
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
    button += '<button class="btn btn-primary" ';
    button +=    'data-order-id=' + data[0] + '" ';
    button +=    'data-mobile="' + data[10] + '" ';
    button +=    'data-message="Jouw bestelling \'' + data[0] + '\' staat klaar in de keuken" ';
    button +=    'data-recipent="buyer" ';
    button +=    'onclick="sendSms(this)"';
    button += '>SMS</button>';
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
        // $('#ordersList tfoot th').each( function () {
        //     var title = $(this).text();
        //     $(this).html('<input type="text" style="width:100px" />');
        // });
    
        $('#ordersList').DataTable({
            data: data,
            order: [[5, 'desc' ]],
            pagingType: "first_last_numbers",
            pageLength: 25,
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
            // initComplete: function () {
            //     this.api().columns().every( function () {
            //         var that = this;
    
            //         $( 'input', this.footer() ).on( 'keyup change clear', function () {
            //             if ( that.search() !== this.value ) {
            //                 that
            //                     .search( this.value )
            //                     .draw();
            //             }
            //         });
            //     });
            // },
            // rowCallback: function(row, data) {
            //     if (data[4] === 'not seen') {
            //         row.style.backgroundColor = '#ff4d4d';
            //     }
            // }
        });
    });
}

function fetchOrders() {    
    let url = globalVariables.ajax + 'fetchOrders'
    let post = {
        paid: '1'
    }
    let selectedStatus = document.getElementById('orderStatus').value;
    let selectedPrinter = document.getElementById('selectedPrinter').value;

    if (selectedStatus) {
        post['orderStatus'] = selectedStatus;
    }
    if (selectedPrinter) {
        post['selectedPrinter'] = selectedPrinter;
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
    // setInterval(function() {        
    //     return  destroyAndFetch();
    // }, 1000000);

    $('[data-toggle="popover"]').popover({
        html:true,
        animation: false,
        trigger: 'hover',
        delay: {
            "hide": 100
        }
    });
    $('.popover-dismiss').popover({
        trigger: 'focus'
    })
});
