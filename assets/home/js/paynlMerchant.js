'use strict';

function uploadDocumentsForPayNl(form) {
    let url = globalVariables.ajax + 'uploadDocumentsForPayNl';
    sendFormAjaxRequest(form, url, 'uploadDocumentsForPayNl', uploadDocumentsForPayNlResponse, [form]);
    return false;
}

function uploadDocumentsForPayNlResponse(form, response) {
    if (response['status'] === '0' || response['status'] === '1') {
        alertifyAjaxResponse(response);
        cleanErrors('errors');
        if (response['status'] === '1') form.reset();
        return;
    }

    let messages = response['messages'];
    displayErroreMessage(messages);
}

function cleanErrors(className) {
    let errors = document.getElementsByClassName(className);
    let errorsLength = errors.length;
    let i;
    for (i = 0; i < errorsLength; i++) {
        errors[i].innerHTML = '';
    }
    return;
}

function displayErroreMessage(messages) {
    console.dir(messages);
    let errId;
    for (errId in messages) {
        document.getElementById(errId).innerHTML = messages[errId];
    }
}
