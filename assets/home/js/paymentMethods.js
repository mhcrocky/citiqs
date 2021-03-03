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
                    return row.paymentMethod;
                }
            },
            {
                "name": "vendorCost",
                "targets": 3,
                "data": function(row, type, val, meta) {
                    return returnCost(tableId, row.id, row.vendorCost, 'vendorCost');
                }
            },
            {
                "name": "buyerCost",
                "targets": 4,
                "data": function(row, type, val, meta) {
                    return returnCost(tableId, row.id, row.buyerCost, 'buyerCost');
                }
            }
        ]
    });
}

function returnCost(tableId, id, value, type) {
    let html = '';
    let newValue = (value === '0') ? '1' : '0';

    html += '<p '
    html +=     'data-table-id="' + tableId + '" ';
    html +=     'data-row-id="' + id + '" ';
    html +=     'data-value="' + newValue + '" ';
    html +=     'data-type="' + type + '" ';
    html +=     'onclick="updatePaymentMethodCost(this)" title="Click to change"';
    html += '>';
    html +=     (value === '1') ? 'Yes' : 'No';
    html += '</p>';

    return html;
}

function updatePaymentMethodCost(element) {
    let data = element.dataset;
    let post = {};
    let secondValue = (data['value'] === '1') ? '0' : '1';
    let secondType = (data['type'] === 'vendorCost') ? 'buyerCost' : 'vendorCost';
    
    post[data['type']] = data['value'];
    post[secondType] = secondValue;

    let url = globalVariables.ajax + 'updatePaymentMethodCost/' + data['rowId'];

    sendAjaxPostRequest(post, url, 'updatePaymentMethodCost', updatePaymentMethodCostResponse, [data['tableId']]);
    return;
}

function updatePaymentMethodCostResponse(tableId, response) {
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

loadAllTables(paymentMethodsGlobals.tableIds);
