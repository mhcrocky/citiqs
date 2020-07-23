'use strict';
$('document').ready(function(){
    $('.productTimePickers').datetimepicker({
        dayOfWeekStart : 1,
    });
});


function updateProductSpotStatus(element) {
    let url = globalVariables.ajax + 'updateProductSpotStatus/' + element.dataset.spotProductId;
    let post = {
        'showInPublic' : element.value,
    }
    sendAjaxPostRequest(post, url, 'updateProductSpotStatus');
}