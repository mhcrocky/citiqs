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
    let url = reportsGlobals['updateUrl'];
    sendFormAjaxRequestImproved(form, url, saveReportResponse);
    return false;
}

function saveReportResponse(response) {

    alertifyAjaxResponse(response);

    if (response.hasOwnProperty('reportId')) {
        reportsGlobals['updateUrl'] = reportsGlobals['updateUrl'] + '/' + response['reportId']
    }
}
