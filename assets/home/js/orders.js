'use strict';
function showOrderProducts(data) {
    if(!data) return;
    let products = data[1];
    let i;
    let list = ''
    let popover = '';

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

        
        popover += '<p style=\'text-align:left\'>Product: ' + product.productName + ' ';
        popover += '| Quantity: ' + product.productQuantity + ' ';
        popover += '| Printer: ' + printer + '</p>';
    }

    list += '<a ';
    list +=     'href="#" ';
    list +=     'data-toggle="popover" ';
    list +=     'data-placement="right" ';
    list +=     'data-trigger="focus" ';
    list +=     'data-content="' + popover + '" ';
    list += '>';
    list +=     'Products';
    list += '</a>';

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

	sendAjaxPostRequest(post, url, 'updatePhoneNumber');
    // sendAjaxPostRequest(post, url, 'updatePhoneNumber', destroyAndFetch);
}

function sendSmsButton(data) {
    let button = '';
    button += '<button class="btn btn-primary" ';
    button +=    'data-order-id="' + data[0] + '" ';
    button +=    'data-mobile="' + data[10] + '" ';
    button +=    'data-message="Jouw bestelling \'' + data[0] + '\' is klaar." ';
    button +=    'onclick="sendSms(this)"';
    button += '>SMS ';
    button +=   '<span ';
    button +=       'class="badge badge-light" ';
    button +=       'id="smsCounter' + data[0] + '" ';
    button +=       'data-status="' + data[4] + '">';
    button +=       data[11];
    button +=   '</span>';
    button += '</button>';
    return button;
}

function sendSms(element) {
    let url = globalVariables.ajax + 'sendSms/' + element.dataset.orderId;
    let post = {
        mobilenumber: document.getElementById(element.dataset.mobile).value,
        messagetext: element.dataset.message
    }
    let smsCounterId = 'smsCounter' + element.dataset.orderId;
    sendAjaxPostRequest(post, url, 'sendSms', changeElementInnerHtml, [smsCounterId]);
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
            order: [[0, 'desc' ]],
            pagingType: "first_last_numbers",
            pageLength: 15,
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
                    "targets": 3,
                    "data": function (row, type, val, meta) {
                        return row[3] + '&nbsp(' + row[12] + ')';
                    }
                },
                {
                    "targets": 4,
                    "data": function (row, type, val, meta) {
                        return showOrderStatuses(orderGlobals.orderStatuses, row);
                    }
                },
                {
                    "targets": 7,
                    "visible": false,
                    "searchable": false,
                },
                {
                    "targets": 8,
                    "data": function (row, type, val, meta) {
                        return showPhoneNumber(row);
                    }
                },
                {
                    "targets": 9,
                    "visible": orderGlobals.getRemarks,
                    "searchable": orderGlobals.getRemarks,
                },
                {
                    "targets": 10,
                    "data": function (row, type, val, meta) {
                        return sendSmsButton(row);
                    },
                    "width": "10%"
                }            
            ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;
    
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    });
                });
            },
            drawCallback: function () {
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
                });
            }
            // rowCallback: function(row, data) {
            //     let selectedStatus = document.getElementById('orderStatus').value;
            //     if (selectedStatus && selectedStatus !== data[4]) {
            //         console.dir(data[4]);
            //         row.style.display = 'none';
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

function changeElementInnerHtml(elementId, newContent) {
    let smsButton = document.getElementById(elementId);
    smsButton.innerHTML = newContent;
    if (smsButton.dataset.status !== 'finished') {
        smsButton.parentElement.parentElement.parentElement.remove();
    }
}
document.addEventListener("DOMContentLoaded", function() {
    fetchOrders();
});
