'use strict';

function getArguments() {
    let florplanArguments = {
        floorElementID: 'canvas',
        imgEl: $('#floor_image'),
        // <?php #if ($floorplan_images) { ?>
        // 	// objectsImages: $.parseJSON('<?php #echo json_encode($floorplan_images); ?>'),
        // <?php #} ?>
    }
    if (globalFloorplan.hasOwnProperty('floorplanID')) {
        florplanArguments['floorplanID'] = globalFloorplan['floorplanID'];
        florplanArguments['imageUploaded'] = true;
        florplanArguments['floor_name'] = globalFloorplan['floor_name'];
        florplanArguments['canvasJSON'] = globalFloorplan['canvasJSON'];
        florplanArguments['areas'] = globalFloorplan['areas'];
    }

    return florplanArguments;
}
var floorplan;
$(document).ready(function () {
    $('#occupied_color').colorpicker({format: "rgb", useAlpha: false});
    $('#free_color').colorpicker({format: "rgb", useAlpha: false});
    $('#unavailable_color').colorpicker({format: "rgb", useAlpha: false});
    $('#label_color').colorpicker({format: "rgb", useAlpha: false});

    //Show images for active category
    var active_cat = $('#images_category').val();
    $('#cat_'+active_cat).show();

    floorplan = new FloorEditor(getArguments());

    fabric.Object.prototype.transparentCorners = true;
    fabric.Object.prototype.cornerColor = 'red';
    fabric.Object.prototype.cornerStyle = 'circle';

    fabric.Object.prototype.controls.deleteControl = new fabric.Control({
        position: {x: 0.5, y: -0.5},
        offsetY: -8,
        offsetX: 8,
        cursorStyle: 'pointer',
        mouseUpHandler: (eventData, target) => {
            floorplan.deleteObject(eventData, target)
        },
        render: floorplan.renderIcon(floorplan.deleteImg),
        cornerSize: 24
    });

    $('#uploadImageField').change(function () {
        floorplan.addImage($(this).prop('files')[0]);
    });

    $('#drawning_mode').click(function () {
        floorplan.drawningModeToggle($(this))
    });

    $('#save').click(function () {
        floorplan.saveFloor();
    })

    $('#floor_plan_name').change(function () {
        floorplan.floor_name = $(this).val();
    });

    $('#save_area_options_btn').click(function () {
        // floorplan.canvas.getActiveObject().options.unavailable_color = $('#unavailable_color input').val();
        // floorplan.canvas.getActiveObject().options.free_color        = $('#free_color input').val();
        // floorplan.canvas.getActiveObject().options.occupied_color    = $('#occupied_color input').val();
        // floorplan.canvas.getActiveObject().options.label_color       = $('#label_color input').val();
        // floorplan.canvas.getActiveObject().options.area_label        = $('#area_label').val();
        // floorplan.canvas.getActiveObject().options.opacity           = $('#opacity').val();
        // floorplan.canvas.getActiveObject().options.area_count        = parseInt($('#area_count').val()) < 2 ? 1 : parseInt($('#area_count').val());
        var options = {
            unavailable_color: $('#unavailable_color input').val(),
            free_color: $('#free_color input').val(),
            occupied_color: $('#occupied_color input').val(),
            label_color: $('#label_color input').val(),
            area_label: $('#area_label').val(),
            opacity: $('#opacity').val(),
            area_count: parseInt($('#area_count').val()) < 2 ? 1 : parseInt($('#area_count').val())
        };
        floorplan.updateArea(options);
        $('#area_options').modal('hide');
    });

    $('#add_image').click(function () {
        if (!floorplan.drawning_mode) {
            return false;
        }
        var active_cat = $('#images_category').val();
        var object_image = $('#cat_'+active_cat + ' .images_list').val();
        floorplan.addObjectImage(active_cat, object_image);
    })
});

$(window).resize(function () {
    floorplan.scaleAndPositionCanvas();
});
