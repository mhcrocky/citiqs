'use strict';

function submitAreaForm(formId) {
    let form = document.getElementById(formId);
    if (validateFormData(form)) {
        form.submit();
    }
}
