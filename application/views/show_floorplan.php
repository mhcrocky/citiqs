<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-12 mt-2">
            <h1><?php echo $floorplan->floor_name; ?></h1>
        </div>
    </div>
    <div class="row mb-5 canvas_row" id="canvas_row">
        <div class="col-md-12 mh-100" id="floor_image">
            <canvas id="canvas" width="200" height="200"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <button type="button" class="btn btn-outline-primary" id="zoomIn">Zoom In</button>
            <button type="button" class="btn btn-outline-primary" id="zoomOut">Zoom Out</button>
        </div>
    </div>
</div>
<div class="modal" id="booking_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="spotForm" onsubmit="return updateSpot(this)">
                <div class="modal-header">
                    <h5 class="modal-title">Spot settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                
                    <div class="form-group">
                        <label for="available">Available:</label>
                        <select class="form-control" id="available" name="spot[available]" requried>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="spot[price]" step="0.01" class="form-control" requried />
                    </div> -->
                    <div class="form-group">
                        <label for="area_count">Persons:</label>
                        <input type="number" id="area_count" name="spot[area_count]" step="1" class="form-control" requried />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-outline-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var showFloorPlanGloabals = (function(){
        let globals = {
            floorplanID: '<?php echo $floorplan->id; ?>',
            floor_name: '<?php echo $floorplan->floor_name; ?>',
            areas: $.parseJSON('<?php echo json_encode($areas); ?>'),
            canvasJSON: '<?php echo $floorplan->canvas;?>'
        }
        Object.freeze(globals);
        return globals;
    })();

    $('#zoomIn').click(function () {
        floorplan.scaleAndPositionCanvas(1.25);
    })

    $('#zoomOut').click(function () {
        floorplan.scaleAndPositionCanvas(0.75);
    })
</script>