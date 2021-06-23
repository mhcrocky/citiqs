'use strict';

function showFloorplans(floorplans) {
    let i = 0;
    let floorplanLenght = floorplans.length;
    let floorplan
    for( i = 0; i < floorplanLenght; i++) {
        floorplan = new FloorShow({
            imgEl: $('#' + floorplans[i]['imageId']),
            floorElementID: floorplans[i]['canvasId'],
            floorplanID: floorplans[i].floorplanID,
            floor_name: floorplans[i].floor_name,
            areas: floorplans[i].areas,
            canvasJSON: floorplans[i].canvasJSON,    
        });

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

$(document).ready(function () {
    showFloorplans(floorplansGlobals['floorplans']);
    $(window).resize(function () {
        // check this function
        scaleFloorplans(floorplansGlobals['floorplanObjects']);
    });    
});
