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
    if (location.trim()) {
        console.dir(globalVariables)
        newLocation = globalVariables['baseUrl'] + newLocation
        window.location.href = newLocation;
    }
}

function alertifyMessage(element) {
    alertify[element.dataset.messageType](element.dataset.message)

}
