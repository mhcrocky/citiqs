'use strict';
function redirectTo(urlPath) {
    let url = globalVariables.baseUrl + urlPath;
    window.location.replace(url);
}

// function checkSpotId(form) {
//     let url = globalVariables.ajax + 'checkSpotId';
//     sendFormAjaxRequest(form, url, 'checkSpotId', redirectTo);
//     return false;
// }

$(document).ready(function() {
    $('.selectSpot').select2();
});