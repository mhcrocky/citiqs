'use strict';
function registerAmbasador(form) {     
    if (validateFormData(form)) {
        let url = globalVariables.ajax + 'registerAmbasador';
        sendFormAjaxRequest(form, url, 'registerAmbasador', registerAmbasadorResponse, [form]);
    }
    return false; 
}

function registerAmbasadorResponse(form, response) {
    alertifyAjaxResponse(response);
    if (response['status'] === '1') {
        form.reset();
    }
}
