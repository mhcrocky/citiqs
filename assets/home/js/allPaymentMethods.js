'use stric';
function insertAllPaymentMethods() {
    let url = globalVariables.ajax + 'insertAllPaymentMethods';
    sendUrlRequest(url, 'insertAllPaymentMethods', insertAllPaymentMethodsResponse);
}

function insertAllPaymentMethodsResponse(response) {
    alertifyAjaxResponse(response);
}
