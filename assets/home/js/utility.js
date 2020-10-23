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