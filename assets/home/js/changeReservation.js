'use strict';

function changeReservation(form) {
    if (validateFormData(form)) {
        let url = globalVariables.ajax + 'changeReservation';
        sendFormAjaxRequestImproved(form, url, alertifyAjaxResponse);
    }
    return false;
}
