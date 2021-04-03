// table functions
function loadTable(tableId) {
    $('#' + tableId).DataTable({
        ajax : {
            url :  globalVariables.ajax + 'getVendorPaymentMethods?group=' + paymentMethodsGlobals['tableIds'][tableId],
        },
        "columnDefs": [
            {
                "name": "id",
                "targets": 0,
                "visible": false,
                "data": function(row, type, val, meta) {
                    return row.id;
                }
            },
            {
                "name": "productGroup",
                "targets": 1,
                "data": function(row, type, val, meta) {
                    return row.productGroup;
                }
            },
            {
                "name": "paymentMethod",
                "targets": 2,
                "data": function(row, type, val, meta) {
                    return returnPaymetType(row);
                }
            },
            {
                "name": "active",
                "targets": 3,
                "data": function(row, type, val, meta) {
                    return returnActive(tableId, row.id, row.active);
                }
            },
            {
                "name": "vendorCost",
                "targets": 4,
                "data": function(row, type, val, meta) {
                    return returnCost(tableId, row.id, row.vendorCost);
                }
            },
            {
                "name": "percent",
                "targets": 5,
                "data": function(row, type, val, meta) {
                    return row.percent;
                }
            },
            {
                "name": "amount",
                "targets": 6,
                "data": function(row, type, val, meta) {
                    return row.amount;
                }
            }
        ]
    });
}

function returnCost(tableId, id, value) {
    let html = '';
    let newValue = (value === '0') ? '1' : '0';

    html += '<p '
    html +=     'data-table-id="' + tableId + '" ';
    html +=     'data-row-id="' + id + '" ';
    html +=     'data-value="' + newValue + '" ';
    html +=     'onclick="updatePaymentMethodCost(this)" title="Click to change"';
    html += '>';
    html +=     (value === '1') ? 'Yes' : 'No';
    html += '</p>';

    return html;
}

function returnPaymetType(row) {
    if (row.paymentMethod === 'prePaid') {
        return 'Cash payment (pre paid)';
    } else if (row.paymentMethod === 'postPaid') {
        return 'Cash payment (post paid)';
    }
    return row.paymentMethod;
}

function updatePaymentMethodCost(element) {
    let data = element.dataset;
    let post = {
        'vendorCost' : data['value']
    }
    let url = globalVariables.ajax + 'updatePaymentMethodCost/' + data['rowId'];

    sendAjaxPostRequest(post, url, 'updatePaymentMethodCost', updatePaymentMethodResponse, [data['tableId']]);
    return;
}

function updatePaymentMethodResponse(tableId, response) {
    alertifyAjaxResponse(response);
    if (response['status'] === '1') {
        reloadTable(tableId);
    }
}

function loadAllTables(tableIds) {
    let index;

    for (index in tableIds) {
        loadTable(index);
    }

    return;
}

function returnActive(tableId, id, value) {
    let html = '';
    let newValue = (value === '0') ? '1' : '0';

    html += '<p '
    html +=     'data-table-id="' + tableId + '" ';
    html +=     'data-row-id="' + id + '" ';
    html +=     'data-value="' + newValue + '" ';
    html +=     'onclick="updatePaymentMethodActive(this)" title="Click to change"';
    html += '>';
    html +=     (value === '1') ? 'Yes' : 'No';
    html += '</p>';

    return html;
}

function updatePaymentMethodActive(element) {
    let data = element.dataset;
    let url = globalVariables.ajax + 'activatePaymentMethod/' + data['rowId'];
    let post = {
        'active' : data['value']
    }

    sendAjaxPostRequestImproved(post, url, updatePaymentMethodResponse, [data['tableId']]);
    return;
}

loadAllTables(paymentMethodsGlobals.tableIds);
