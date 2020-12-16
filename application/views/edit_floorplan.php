<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/floorplan/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/floorplan/assets/css/main.css">
<div style="margin-top: 3%;" class="main-content-inner text-center">
<div style="background: rgba(255,255,255,.2);padding: 25px;">
	<div  class="row create_floor">
		<div class="col-md-12 mt-2" >
			<div class="form-group" style="margin-top:70px !important">
				<label for="floor_plan_name">Floor plan name</label>
				<input type="text" name="floor_plan_name" class="form-control" id="floor_plan_name"
					   value="<?php echo (isset($floorplan) AND $floorplan) ? $floorplan->floor_name : '' ?>">
			</div>
		</div>
		<div class="col-md-3 mt-3">
			<div class="dada">
				<label for="uploadImageField" class="chous">Choose file</label>
				<input type="file" class="my" id="uploadImageField" name="image"/>
			</div>
		</div>
		<div class="col-md-3 mt-3">
			<button type="button" id="drawning_mode" class="btn btn-outline-primary">Drawning mode off</button>
		</div>
		<div class="col-md-3 mt-3">
			<button type="button" id="save" class="btn btn-outline-success">Save</button>
		</div>
		<div class="col-md-3 mt-3">
			<div class="form-group">
				<label for="area_type">Area type</label>
				<select class="form-control" id="area_type">
					<option value="rect" selected>Rect</option>
					<option value="circle">Circle</option>
				</select>
			</div>
		</div>

	</div>
    <div class="row images-category">
        <div class="col-md-3">
            <div class="form-group mb-0">
                <label for="area_type">Images category</label>
                <select class="form-control" id="images_category">
                    <?php foreach ($floorplan_images as $key => $category) {?>
                        <option value="<?php echo $key; ?>" ><?php echo ucfirst($key);?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php foreach ($floorplan_images as $key => $category) {?>
            <div class="col-md-3" id="cat_<?php echo $key; ?>" style="display: none;">
                <div class="form-group">
                    <label for="area_type">Images</label>
                    <select class="form-control images_list">
                        <?php foreach ($category as $img_key => $img) {?>
                            <option value="<?php echo $img; ?>" ><?php echo ucfirst($img);?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-3">
            <button type="button" id="add_image" class="btn btn-outline-success">Add image</button>
        </div>
    </div>
	<div class="row mh-100 mb-5 canvas_row" id="canvas_row">
		<div class="col-md-12 mh-100 p-2" id="floor_image">
			<canvas id="canvas" width="200" height="200"></canvas>
		</div>
	</div>

	<div class="row">
		<h1>&nbsp &nbsp Areas info</h1>
	</div>
</div>
						</div>
<div class="modal" id="area_options" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Area options</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group" >
					<label for="area_label">Label</label>
					<input type="text" class="form-control" name="area_label" id="area_label" >
				</div>
				<div class="form-group">
					<label for="label_color">Label color</label>
					<div id="label_color" class="input-group" title="Label color" data-color="red">
						<input type="text" name="label_color" class="form-control input-lg" value="red"/>
						<span class="input-group-append">
    						<span class="input-group-text colorpicker-input-addon"><i></i></span>
  						</span>
					</div>
				</div>
				<div class="form-group"  >
					<label for="area_count">Spot count</label>
					<input type="number" class="form-control" min="1" name="area_count" id="area_count" >
				</div>
				<div class="form-group area_input">
					<label for="occupied_color">Occupied color</label>
					<div id="occupied_color" class="input-group" title="Occupied color" data-color="red">
						<input type="text" name="occupied_color" class="form-control input-lg" value="red"/>
						<span class="input-group-append">
    						<span class="input-group-text colorpicker-input-addon"><i></i></span>
  						</span>
					</div>
				</div>

				<div class="form-group area_input">
					<label for="free_color">Free color</label>
					<div id="free_color" class="input-group" title="Free color" data-color="green">
						<input type="text" name="free_color" class="form-control input-lg" value="green"/>
						<span class="input-group-append">
    						<span class="input-group-text colorpicker-input-addon"><i></i></span>
  						</span>
					</div>
				</div>

				<div class="form-group area_input">
					<label for="unavailable_color">Unavailable color</label>
					<div id="unavailable_color" class="input-group" title="Unavailable color" data-color="gray">
						<input type="text" name="unavailable_color" class="form-control input-lg" value="gray"/>
						<span class="input-group-append">
    						<span class="input-group-text colorpicker-input-addon"><i></i></span>
  						</span>
					</div>
				</div>

				<div class="form-group ">
					<div class="form-group">
						<label for="opacity">Opacity</label>
						<input type="range" class="form-control-range" id="opacity" min="0" max="1" step="0.01">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary" id="save_area_options_btn">Save changes</button>
			</div>
		</div>
	</div>
</div> 

<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script >
	const BASE_URL = '<?php echo base_url(); ?>';
    const OBJECT_ID = '<?php echo $objectId; ?>';
    const FLOOR_IMAGES_PATH = '<?php echo str_replace('\\', '/', $floorplan_images_path);?>';
</script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/fabric_v4.0.0-beta.8.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorplan.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorEditor.js"></script>
<script>

	var floorplan;
	$(document).ready(function () {
		$('#occupied_color').colorpicker({format: "rgb", useAlpha: false});
		$('#free_color').colorpicker({format: "rgb", useAlpha: false});
		$('#unavailable_color').colorpicker({format: "rgb", useAlpha: false});
		$('#label_color').colorpicker({format: "rgb", useAlpha: false});

		//Show images for active category
        var active_cat = $('#images_category').val();
        $('#cat_'+active_cat).show();

		floorplan = new FloorEditor({
            floorElementID: 'canvas',
            imgEl: $('#floor_image'),
            <?php if ($floorplan_images) { ?>
                objectsImages: $.parseJSON('<?php echo json_encode($floorplan_images); ?>'),
            <?php } ?>

			<?php if (isset($floorplan) AND $floorplan) { ?>
				floorplanID: <?php echo $floorplan->id; ?>,
                imageUploaded: <?php echo $floorplan->file_name ? 'true' : 'false'; ?>,
				floor_name: '<?php echo $floorplan->floor_name; ?>',
				areas: $.parseJSON('<?php echo json_encode($areas); ?>'),
				canvasJSON: '<?php echo $floorplan->canvas;?>'
			<?php } ?>
		});

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
</script>