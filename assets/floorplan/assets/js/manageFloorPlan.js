'use strict';
function updateSpot(form) {    
    sendFormAjaxRequest(form, form.action, 'updateSpot')
    return false;
}
let floorplan;
$(document).ready(function () {
    floorplan = new FloorShow({
        imgEl: $('#floor_image'),
        floorElementID: 'canvas',
        floorplanID: showFloorPlanGloabals.floorplanID,
        floor_name: showFloorPlanGloabals.floor_name,
        areas: showFloorPlanGloabals.areas,
        canvasJSON: showFloorPlanGloabals.canvasJSON

    });

    floorplan.areaClickCallback = function (area_data) {
        // area_count is area data, something buid before alfred, in lost and foud
        let posSpot = 'pos?spotid=' + area_data['area_count'];
        redirectToNewLocation(posSpot);
    }
});


$(window).resize(function () {
    floorplan.scaleAndPositionCanvas();
});
