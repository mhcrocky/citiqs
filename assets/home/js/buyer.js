// table functions
console.dir(globalVariables);
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


// loadAllTables(paymentMethodsGlobals.tableIds);
