'use strict';

function showFloorplans(floorplans) {
    let i = 0;
    let floorplanLenght = floorplans.length;
    let floorplan
    for( i = 0; i < floorplanLenght; i++) {
        floorplan = showFloorplan(floorplans[i]);

        floorplansGlobals['floorplanObjects'].push(floorplan);
    }
}

function scaleFloorplans(floorplans) {
    let i = 0;
    let floorplanLenght = floorplans.length;
    for( i = 0; i < floorplanLenght; i++) {
        let floorplan = floorplans[i];
        floorplan.scaleAndPositionCanvas();
    }
}

function deleteFloorplan(element) {
    let message = 'Delete floorplan "' + element.dataset.name + '"';
    alertify.confirm(
        'Confirm delete',
        message,
        function() {
            let floorplanId = element.dataset.floorplanId;
            let parentId =  element.dataset.parentId;
            let url = globalVariables.ajax + 'deleteFloorplan/' + floorplanId;
            sendGetRequest(url, deleteFloorplanResponse, [parentId]);
        },
        function() {
            alertify.error('Cancel')
        }
    );
}

function deleteFloorplanResponse(containerId, response) {
    alertifyAjaxResponse(response);

    if (response['status'] === '1') {
        document.getElementById(containerId).remove();
    }
}

$(document).ready(function () {
    if (typeof(floorplansGlobals) !== 'undefined') {
        showFloorplans(floorplansGlobals['floorplans']);
    }

    $(window).resize(function () {
        // check this function
        scaleFloorplans(floorplansGlobals['floorplanObjects']);
    });    
});
