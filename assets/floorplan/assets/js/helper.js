'use strict';
function showFloorplan(floorplanObject) {
    return new FloorShow({
        imgEl: $('#' + floorplanObject['imageId']),
        floorElementID: floorplanObject['canvasId'],
        floorplanID: floorplanObject['floorplanID,'],
        floor_name: floorplanObject['floor_name'],
        areas: floorplanObject['areas'],
        canvasJSON: floorplanObject['canvasJSON'],
    });
}
