'use strict';

function sendReportPrintRequest(element) {
    let timePickkerId = element.dataset.timepickerId
    let timePickerValue = document.getElementById(timePickkerId).value;
    let url = globalVariables.ajax + 'sendReportPrintRequest';
    let times = timePickerValue.split(' - ');
    let post = {
        'dateTimeFrom' : times[0],
        'dateTimeTo' : times[1],
        'report': element.dataset.report
    }
 
    sendAjaxPostRequest(post, url, 'sendReportPrintRequest', alertifyAjaxResponse)
}