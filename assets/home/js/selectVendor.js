'use strict';

function redirectToSelectedVendor(urlPath) {
    let url = globalVariables.baseUrl + urlPath;
    window.location.replace(url);
}

$(document).ready(function() {
    $('.selecVendor').select2();
});
