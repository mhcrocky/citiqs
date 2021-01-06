'use stritc';

function actviateApiRequest(form) {
    let url = globalVariables.ajax + 'actviateApiRequest';
    sendFormAjaxRequest(form, url, 'actviateApiRequest', alertifyAjaxResponse)
    return false;
}