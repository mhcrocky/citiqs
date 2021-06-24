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
    let floorplanId = element.dataset.floorplanId;
    let parentId =  element.dataset.parentId;
    let url = globalVariables.ajax + 'deleteFloorplan/' + floorplanId;
    sendGetRequest(url, deleteFloorplanResponse, [parentId]);

    console.dir(floorplanId);
}

function deleteFloorplanResponse(containerId, response) {
    alertifyAjaxResponse(response);

    if (response['status'] === '1') {
        document.getElementById(containerId).remove();
    }
}

$(document).ready(function () {
    showFloorplans(floorplansGlobals['floorplans']);
    $(window).resize(function () {
        // check this function
        scaleFloorplans(floorplansGlobals['floorplanObjects']);
    });    
});
