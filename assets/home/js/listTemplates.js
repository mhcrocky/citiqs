'use strict';
$(document).ready(function(){
    if (listTemplates.hasOwnProperty('templates')) {
        $('#listTemplates').DataTable({});
    }

    if (listTemplates.hasOwnProperty('landingPages')) {
        $('#listLandingPages').DataTable({});
    }
})
