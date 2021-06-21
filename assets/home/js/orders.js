'use strict';
function showOrderProducts(data) {
    if(!data) return;

    let products = data[1];
    let popover = productDetailsHtml(products);

    // list += '<a ';
    // list +=     'style="color:#000" ';
    // list +=     'href="#" ';
    // list +=     'data-toggle="popover" ';
    // list +=     'data-placement="right" ';
    // list +=     'data-trigger="focus" ';
    // list +=     'data-content="' + popover + '" ';
    // list += '>';
    // list +=     'Products';
    // list += '</a>';

    return popover;
}

function productDetailsHtml(products) {
    let i;
    let content = '';
    for (i in products) {        
        if (i === 'spotPrinter') continue;
        let rawProduct = products[i];
        let rawProductLength = rawProduct.length;
        let j;
        for (j = 0; j < rawProductLength; j++) {
            let product = rawProduct[j];
            if (!product) continue;
            let style = (product['subMainPrductOrderIndex'] === '0') ? '' : ' padding-left:15px';
            content += '<p style=\'text-align:left;margin-bottom:0px;' + style + '\'>';
            content += '# ' + product.productQuantity + ' ' + product.productName;
            content += '</p>';
            if (product['remark']) {
                content += '<p style=\'text-align:left;margin-bottom:0px;' + style + '\'>';
                content += product['remark'];
                content += '</p>';
            }
        }        
    }
    return content;
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
    button +=    'data-message="Uw bestelling \'' + data[0] + '\' is klaar en mag afgehaald worden." ';
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
    let mobile = document.querySelectorAll('[data-user-id="' + element.dataset.mobile + '"]')[0].value;
    let post = {
        mobilenumber: mobile,
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
                    "data": function (row, type, val, meta) {
                        if (row[14] === orderGlobals.prePaid || row[14] === orderGlobals.postPaid) {
                            return row[2];
                        }
                        return '';
                    }
                },
                {
                    "targets": 3,
                    "data": function (row, type, val, meta) {
                        return row[3] + '&nbsp(' + row[12] + ')';
                    }
                },
                {
                    "targets": 4,
                    "visible": false,
                    "searchable": false,
                    "width": "20%"
                    // "data": function (row, type, val, meta) {
                    //     return showOrderStatuses(orderGlobals.orderStatuses, row);
                    // }
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
                    "data": function (row, type, val, meta) {
                        return sendSmsButton(row);
                    },
                    "width": "10%"
                },
                {
                    "targets": 10,
                    "visible": false,
                    "searchable": false,
                },
                {
                    "targets": 11,
                    "visible": false,
                    "searchable": false,
                },
                {
                    "targets": 12,
                    "visible": false,
                    "searchable": false,
                },
                {
                    "targets": 13,
                    "visible": orderGlobals.getRemarks,
                    "searchable": orderGlobals.getRemarks,
                },
                {
                    "targets": 14,
                    "data": function (row, type, val, meta) {
                        if (row[14] === orderGlobals.prePaid) {
                            return 'Pay at waiter (pre paid)';
                        } else if  (row[14] === orderGlobals.postPaid) {
                            return 'Pay at waiter (post paid)';
                        }
                        if (row[14]) {
                            return row[14].charAt(0).toUpperCase() + row[14].slice(1);
                        }
                        return;
                    },
                    "width": "10%"
                },
                {
                    "targets": 15,
                    "data": function (row, type, val, meta) {
                        if (row[15] === orderGlobals.deliveryTypeId || row[15] === orderGlobals.pickupTypeId) {
                            return confrimOrderButton(row);
                        }
                        return;
                    },
                    "width": "10%"
                },
                {
                    "targets": 16,
                    "data": function (row, type, val, meta) {
                        return (row[20] === '1') ? 'Printed' : 'Not printed';
                    },
                    "width": "10%"
                },
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
            },
            rowCallback: function(row, data) {
                let type = data[15];
                let confrimStatus = data[19];
                colorRow(row, type, confrimStatus);
            }
        });
    });
}

function fetchOrders() {    
    let url = globalVariables.ajax + 'fetchOrders'
    let post = {
        paid: '1'
    }
    let selectedStatus = document.getElementById('orderStatus');
    let selectedPrinter = document.getElementById('selectedPrinter');

    if (selectedStatus && selectedStatus.value) {
        post['orderStatus'] = selectedStatus.value;
    }
    if (selectedPrinter && selectedPrinter.value) {
        post['selectedPrinter'] = selectedPrinter.value;
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
    // if (smsButton.dataset.status !== 'finished') {
    //     smsButton.parentElement.parentElement.parentElement.remove();
    // }
}

function confrimOrderButton(data) {
    let button = '';

    button += '<button class="btn btn-primary" ';
    button +=    'data-modal-id="' + orderGlobals.checkOrderModalId + '" ';
    button +=    'data-orderid="' + data[0] + '" ';
    button +=    'data-buyer-id="' + data[10] + '" ';
    button +=    'data-buyer-email="' + data[7] + '" ';
    button +=    'data-buyer-mobile="' + data[8] + '" ';
    button +=    'data-buyer-city="' + data[16] + '" ';
    button +=    'data-buyer-zipcode="' + data[17] + '" ';
    button +=    'data-buyer-address="' + data[18] + '" ';
    button +=    'data-order-type="' + data[15] + '" ';
    button +=    'data-spot="' + data[3] + '" ';
    button +=    'data-pickup-time="' + data[5] + '" ';
    button +=    'data-products-string=\'' + JSON.stringify(data[1]) + '\' ';
    button +=    'onclick="showDeliveryModal(this)"';
    button += '>';
    button +=    prepareButtonInnerHtml(data[15], data[19]);
    button += '</button>';
    return button;
}

function prepareButtonInnerHtml(typeStatus, confirmStatus) {
    let type = '';
    let buttonInnerHtml = '';

    if (typeStatus === orderGlobals.deliveryTypeId) {
        type = 'Delivery';
    } else if (typeStatus === orderGlobals.pickupTypeId) {
        type = 'Pickup';
    }

    if (confirmStatus === orderGlobals.orderConfirmWaiting) {
        buttonInnerHtml = type + ' confirmed'
    } else if (confirmStatus === orderGlobals.orderConfirmTrue) {
        buttonInnerHtml = type + ' confirmed'
    } else if (confirmStatus === orderGlobals.orderConfirmFalse) {
        buttonInnerHtml = type + ' rejected'
    }

    return buttonInnerHtml;
}

function showDeliveryModal(element) {
    let modalBody = '';
    let productsString = element.dataset.productsString
    if (element.dataset.orderType === orderGlobals.deliveryTypeId) {
        modalBody = getDeliveryModalBody(element.dataset, productsString);
    } else if (element.dataset.orderType === orderGlobals.pickupTypeId) {
        modalBody = getPickupModalBody(element.dataset, productsString);
    }
    let modalFooter = getModalFooter(element.dataset);

    $('#' + element.dataset.modalId + ' .modal-body').html(modalBody);
    $('#' + element.dataset.modalId + ' .modal-footer').html(modalFooter);
    $('#' + element.dataset.modalId).modal('show');

    // getDistance(orderGlobals.userId, element.dataset.buyerId);
}

function getDeliveryModalBody(data, productsString) {
    let products = JSON.parse(productsString)
    let deliveryModalBody = '';

    deliveryModalBody += '<p><span style="font-weight:900">Order ID:&nbsp;</span>' + data.orderid +' </p>';
    deliveryModalBody += '<p><span style="font-weight:900">Distance:&nbsp;</span><span id="distance">Waiting ...</span></p>';
    deliveryModalBody += '<p><span style="font-weight:900">City:&nbsp;</span>' + data.buyerCity +' </p>';
    deliveryModalBody += '<p><span style="font-weight:900">Zipcode:&nbsp;</span>' + data.buyerZipcode +' </p>';
    deliveryModalBody += '<p><span style="font-weight:900">Address:&nbsp;</span>' + data.buyerAddress +' </p>';
    deliveryModalBody += '<h3 style="font-size:22px; font-weight:900; margin-bottom:10px">Products</h3>';
    deliveryModalBody += productDetailsHtml(products)

    return deliveryModalBody;
}

function getPickupModalBody(data, productsString) {
    let products = JSON.parse(productsString)
    let pickupModalBody = '';

    pickupModalBody += '<p><span style="font-weight:900">Order ID:&nbsp;</span>' + data.orderid +' </p>';
    pickupModalBody += '<p><span style="font-weight:900">Spot:&nbsp;</span>' + data.spot +' </p>';
    pickupModalBody += '<p><span style="font-weight:900">Pickup time:&nbsp;</span>' + data.pickupTime +' </p>';
    pickupModalBody += '<h3 style="font-size:22px; font-weight:900; margin-bottom:10px">Products</h3>';
    pickupModalBody += productDetailsHtml(products)

    return pickupModalBody;
}

function getModalFooter(data) {
    let modalFooter = '';
    modalFooter += '<button ';
    modalFooter +=     'class="btn btn-danger btn-lg" ';
    modalFooter +=     'style="border-radius:50%; margin-right:73%; font-size:24px" ';
    modalFooter +=     'onclick="confrimRejectOrderAction(\'' + data.orderid + '\', \'' + orderGlobals.orderConfirmFalse + '\')" ';
    modalFooter += '>';
    modalFooter +=     '<i class="fa fa-times" aria-hidden="true"></i>';
    modalFooter += '</button>';
    modalFooter += '<button ';
    modalFooter +=     'class="btn btn-success btn-lg" ';
    modalFooter +=     'style="border-radius:50%; margin-right:5px; font-size:24px" ';
    modalFooter +=     'onclick="confirmOrderAction(\'' + data.orderid + '\', \'' + orderGlobals.orderConfirmTrue + '\')" ';
    modalFooter += '>';
    modalFooter +=     '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    modalFooter += '</button>';

    return modalFooter;
}

function confirmOrderAction(orderId, confirmStatus) {
    let url = globalVariables.ajax + 'confirmOrderAction';
    let data = document.querySelectorAll('[data-orderid="' + orderId + '"]')[0].dataset;
    let key;
    let post = {};

    for (key in data) {
        if (data.hasOwnProperty(key)) {
            post[key] = data[key];
        }
    }

    post['confirmStatus'] = confirmStatus;

    $('#' + orderGlobals.checkOrderModalId).modal('hide');
    sendAjaxPostRequest(post, url, 'confirmOrderAction', manageServerResponse);
}

function confrimRejectOrderAction(orderId, confirmStatus) {
    alertify.confirm(
        'CONFIRM ORDER REJECT',
        'Are you sure you want to reject this order?',
        function() {
            confirmOrderAction(orderId,confirmStatus)
        },
        function() {
            alertify.error('Canceled')
            $('#' + orderGlobals.checkOrderModalId).modal('hide');
        }
    );
}

function manageServerResponse(data) {

    if (data['status'] === '1') {
        let button = document.querySelectorAll('[data-orderid="' + data['orderId'] + '"]')[0];
        let row = button.parentElement.parentElement;

        button.innerHTML = prepareButtonInnerHtml(data['type'], data['confirmStatus']);
        alertify.success(data['message']);
        colorRow(row, data['type'], data['confirmStatus']);
    } else {
        alertify.error(data['message']);
    }
}

function colorRow(row, typeStatus, confrimStatus ) {
    let typeBackgroundColor = '';

    if (confrimStatus === orderGlobals.orderConfirmFalse) {
        typeBackgroundColor = orderGlobals.rejectedColor;
    }

    if (!typeBackgroundColor) {
        if (typeStatus === orderGlobals.localTypeId) {
            typeBackgroundColor = orderGlobals.typeColors['local'];
        } else if (typeStatus === orderGlobals.deliveryTypeId) {
            typeBackgroundColor = orderGlobals.typeColors['delivery'];
        } else if (typeStatus === orderGlobals.pickupTypeId) {
            typeBackgroundColor = orderGlobals.typeColors['pickup'];
        }
    }

    row.style.backgroundColor = typeBackgroundColor;
    row.children[0].style.backgroundColor = typeBackgroundColor;
}

function getDistance(vendorId, buyerId) {
    let post = {
        'vendorId' : vendorId,
        'buyerId' : buyerId
    }
    let url = globalVariables.ajax + 'getDistance'
    sendAjaxPostRequest(post, url, 'getDistance', showDistance, ['distance']);
}

function showDistance(distanceId, data = null) {
    let distance = document.getElementById(distanceId);
    if (data['status'] === '0' || !data['distance']['text']) {
        distance.innerHTML = data['message'];
        return;
    }
    distance.innerHTML = data['distance']['text'] ? data['distance']['text'] : 'Information not available';
}

document.addEventListener("DOMContentLoaded", function() {
    fetchOrders();
});
