'use strict';
function redirectToMakeOrder(urlPath) {
    let url = globalVariables.baseUrl + urlPath;
    window.location.replace(url);
}

function checkSpotId(form) {
    let url = globalVariables.ajax + 'checkSpotId';
    sendFormAjaxRequest(form, url, 'checkSpotId', redirectToMakeOrder);
    return false;
}

$(document).ready(function() {
    $('.selectSpot').select2();
});