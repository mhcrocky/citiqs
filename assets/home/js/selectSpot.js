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

function redirectToSpot(selectedSpotClass) {
    let spot = document.getElementsByClassName(selectedSpotClass);
    if (spot.length) {
        spot = spot[0];
        let url = globalVariables.baseUrl + spot.dataset.redirect;
        window.location.replace(url);
    } else {
        alertify.error('Please select spot');
    }
}