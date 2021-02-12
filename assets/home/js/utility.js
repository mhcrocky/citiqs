'use strict';
function removeParent(element) {
    element.parentElement.remove();
}
function submitForm(formId) {
    document.getElementById(formId).submit();
}
function inIframe () {
    try {
        return window.self !== window.top;
    } catch (e) {
        return false;
    }
}
function reloadPageIfMinus(element, checkZeroValue = '1') {    
    let inputValue = parseFloat(element.value);
    let checkZero = checkZeroValue === '1' ? true : false;

    if (checkZero && (inputValue <= 0 || isNaN(inputValue))) {
        location.reload();
        return;
    }
    if (!checkZero && (inputValue < 0 || isNaN(inputValue))) {
        location.reload();
        return;
    }
    return;
}

function redirectToNewLocation(location) {
    let newLocation = location.trim();
    if (newLocation) {
        newLocation = globalVariables['baseUrl'] + newLocation
        window.location.href = newLocation;
    }
}

function alertifyMessage(element) {
    alertify[element.dataset.messageType](element.dataset.message)
}

function alertifyErrMessage(element) {
    let inputValue = element.value.trim();
    let minLength = parseInt(element.dataset.minLength);
    if (inputValue.length < minLength) {
        let errMessage = element.dataset.errorMessage;
        alertify.error(errMessage);
        element.style.border = '1px solid #f00'
        return 1;
    } else {
        element.style.border = 'initial'
        return 0;
    }   
}

function validateFormData(form) {
    let inputs = form.querySelectorAll('[data-form-check]')
    let inputsLength = inputs.length;
    let i;
    let countErrors = 0;

    for (i = 0; i < inputsLength; i++) {
        let input = inputs[i];
        countErrors += alertifyErrMessage(input);
    }
    return countErrors ? false : true;
}

function alertifyAjaxResponse(response) {
    let messages = response['messages'];
    let message;
    let action = response.status === '1' ? 'success' : 'error'
    // if (response.status === '1') {
        for (message of messages) {
            alertify[action](message);
        }
    // }
}
function facebookCustom(name, nameValue) {
    if (typeof fbq !== 'undefined') {
        fbq('trackCustom', name , {promotion: nameValue});
    }
}