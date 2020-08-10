'use strict';
function removeParent(element) {
    element.parentElement.remove();
}
function submitForm(formId) {
    document.getElementById(formId).submit();
}