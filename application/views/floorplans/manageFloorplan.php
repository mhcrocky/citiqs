<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($spots) { ?>
    <div style="margin-top: 3%;" class="main-content-inner text-center">
        <div style="background: rgba(255,255,255,.2);padding: 25px;">
            <div  class="row create_floor">
                <div class="col-md-12 mt-2" >
                    <div class="form-group" style="margin-top:70px !important">
                        <label for="floor_plan_name">Floor plan name</label>
                        <input
                            type="text"
                            name="floor_plan_name"
                            class="form-control"
                            id="floor_plan_name"
                            <?php if (!empty($floorplan['floorplanName'])) { ?>
                            value="<?php echo $floorplan['floorplanName']; ?>"
                            <?php } ?>
                        />
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
                <!-- TO DO ADD IMAGES -->
                <!-- <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="area_type">Images category</label>
                        <select class="form-control" id="images_category">
                            <?php #foreach ($floorplan_images as $key => $category) {?>
                                <option value="<?php #echo $key;?>" ><?php #echo ucfirst($key);?></option>
                            <?php #}?>
                        </select>
                    </div>
                </div> -->
                <?php #foreach ($floorplan_images as $key => $category) {?>
                    <!-- <div class="col-md-3" id="cat_<?php #echo $key;?>" style="display: none;">
                        <div class="form-group">
                            <label for="area_type">Images</label>
                            <select class="form-control images_list">
                                <?php #foreach ($category as $img_key => $img) {?>
                                    <option value="<?php #echo $img;?>" ><?php #echo ucfirst($img);?></option>
                                <?php #}?>
                            </select>
                        </div>
                    </div> -->
                <?php #}?>
                <!-- <div class="col-md-3">
                    <button type="button" id="add_image" class="btn btn-outline-success">Add image</button>
                </div> -->
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
                    <div class="form-group">
                        <label for="area_count">Select spot</label>
                        <select class="form-control" name="area_count" id="area_count">
                            <option value="">Select spot</option>
                            <?php foreach($spots as $spot) { ?>
                                <option value="<?php echo $spot['spotId']; ?>">
                                    <?php
                                        echo $spot['spotName'] . '&nbsp;&nbsp;';
                                        echo ($spot['spotActive'] === '1') ? '(ACTIVE)' : '(NOT ACTIVE)';
                                    ?>
                                </option>
                            <?php } ?>

                        </select>
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
<?php } else { ?>
    <div style="margin-top: 3%;" class="main-content-inner">
        <p>No local spots. <a href="<?php echo $this->baseUrl; ?>spots">Add spot</a>
    </div>
<?php } ?>

<script>
    var globalFloorplan = (function() {
        // to do check if not areas
        let globals = {};
        <?php if(!empty($floorplan) && !empty($areas)) { ?>
            globals = {
                floorplanID: '<?php echo $floorplan['id']; ?>',
                floor_name: '<?php echo $floorplan['floorplanName']; ?>',
                areas: $.parseJSON('<?php echo json_encode($areas); ?>'),
                canvasJSON: '<?php echo $floorplan['canvas']; ?>',
                imageId: 'floor_image',
                canvasId: 'canvas',
            }
        <?php } ?>

        return globals;
    }());
    console.dir(globalFloorplan);
</script>
