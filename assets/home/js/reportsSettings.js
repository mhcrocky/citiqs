'use strict';
function togglePeriod(value) {
    if (value === 'week') {
        document.getElementById('week').style.display = 'initial';
        document.getElementById('month').style.display = 'none';
    } else if (value === 'month') {
        document.getElementById('week').style.display = 'none';
        document.getElementById('month').style.display = 'initial'
    } else {
        document.getElementById('week').style.display = 'none';
        document.getElementById('month').style.display = 'none';
    }
}

function saveReport(form) {
    let url = globalVariables['ajax'] + 'saveReportsSettings';
    sendFormAjaxRequestImproved(form, url, saveReportResponse);
    return false;
}

function saveReportResponse(response) {
    if (response.hasOwnProperty('status')) {
        alertifyAjaxResponse(response);
    } else {

    }
}
