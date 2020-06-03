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
        // console.log(area_data);
        document.getElementById('available').value = area_data.available;
        document.getElementById('area_count').value = area_data.area_count;
        // document.getElementById('price').value = area_data.price;
        document.getElementById('spotForm').action = globalVariables.ajax + 'updateSpot/' + area_data.id
        $('#booking_modal').modal();
    }
});


$(window).resize(function () {
    floorplan.scaleAndPositionCanvas();
});
