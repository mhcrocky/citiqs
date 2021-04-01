<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<div class="main-wrapper theme-editor-wrapper">
    <div class="grid-wrapper">
        <div class="grid-list">
            <div class="grid-list-header row">
                <div class="col-lg-2 col-md-2 col-sm-12 grid-header-heading">
                    <h2>Filter Options</h2>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12">
                    <!--Search by name:-->
                    <form class="form-inline" method="post" action="<?php echo base_url() ?>reservations/<?php echo $vendorId; ?>">
                   
                        <div style="display: none;" class="form-group">
                            <label for="object">Select object: </label>
                            <select class="form-control" id="object" name="object" required>
                                <option value=""><?php echo $this->language->tLine('Select'); ?></option>
                                <?php
                                $not_null = 0;
                                 foreach ($objects as $object) { ?>
                                    <?php
                                    $selected = '';
                                    
                                    if ($object['userId'] == $vendorId) {
                                        $selected = 'selected';
                                        $change_val = &$not_null;
                                        $change_val = 1;
                                       
                                    }
                                  
                                    ?>
                                    
                                    <option <?php echo $selected; ?>
                                            value="<?php echo $object['id'] ?>"><?php echo $object['objectName'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                       <?php if($not_null == '0'): ?>
                           <strong>Sorry, we didn't find any object for this vendor! </strong>
                       <?php exit(); endif; ?>
                        <div class="form-group">
                            <label for="date">Date: </label>
                            <input
                                    class="form-control"
                                    type="date" id="date"
                                    name="date"
                                    required
                                    min="<?php echo date('Y-m-d'); ?>"
                                    value="<?php echo isset($get['date']) ? $get['date'] : date('Y-m-d'); ?>"/>
                        </div>
                        <!-- <div class="form-group">
                            <label for="start">From: </label>
                            <input
                                class="form-control"
                                type="time"
                                id="start"name="start"
                                value="<?php #echo isset($get['start']) ? $get['start'] : date('H:i'); ?>"
                                required/>
                        </div>
                        <div class="form-group">
                            <label for="end">To: </label>
                            <input
                                class="form-control"
                                type="time"
                                id="end"
                                value="<?php #echo isset($get['end']) ? $get['end'] : date('H:i'); ?>"
                                name="end"
                                required/>
                        </div> -->
                        <div class="form-group">
                            <label for="persons">Persons: </label>
                            <input
                                    class="form-control"
                                    type="number"
                                    id="persons"
                                    name="persons"
                                    min="1"
                                    value="<?php echo isset($get['persons']) ? $get['persons'] : '1'; ?>"
                                    step="1"
                                    required/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-outline-success my-1 my-sm-0 button grid-button" type="submit">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div>
        <?php //var_dump($floorplans); ?>
            <?php 
            if (isset($floorplans) && !empty($floorplans)) {
                foreach ($floorplans as $floorplan) {
                    
                    ?>
                    <div class="row mb-5 canvas_row" style="margin-top:50px" id="canvas_row_<?php echo $floorplan['id']; ?>">
                        <div class="col-md-12 mh-100 " id="floor_image_<?php echo $floorplan['id']; ?>">
                            <h2><?php echo $floorplan['floor_name']; ?></h2>
                            <canvas id="canvas_<?php echo $floorplan['id']; ?>" width="200" height="800"></canvas>
                        </div>
                    </div>
                    <div id="row_<?php echo $floorplan['id']; ?>" class="row">
                        <button type="button" class="btn btn-outline-primary"
                                id="zoomIn_<?php echo $floorplan['id']; ?>">Zoom In
                        </button>
                        <button type="button" class="btn btn-outline-primary"
                                id="zoomOut_<?php echo $floorplan['id']; ?>">Zoom Out
                        </button>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="modal" id="booking_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Booking</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="area_data">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-outline-primary" role="button" id="bookNow"
                                    onclick="bookNow('bookData')">Book now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; ?>
<script>
    const BASE_URL = '<?php echo base_url(); ?>';
</script>

<!--<script src="--><?php //echo base_url(); ?><!--assets/floorplan/assets/js/jquery-3.5.1.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/fabric_v4.0.0-beta.8.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorplan.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorplanShow.js"></script>
<script>
    <?php
    if (isset($floorplans) && !empty($floorplans)) {
    ?>
    var reservationGloabls = (function () {
        let globals = JSON.parse('<?php echo json_encode($get); ?>');
        Object.freeze(globals);
        return globals;
    })();

    function bookNow(bookDataId) {
        let element = document.getElementById(bookDataId);
        let values = element.value.split('|');
        if (values.length === 3) {
            let redirect = BASE_URL + 'reservations/makeReservations?';
            redirect += 'object=' + element.dataset['object'];
            redirect += '&date=' + element.dataset['date'];
            redirect += '&persons=' + element.dataset['persons'];
            redirect += '&areaId=' + element.dataset['areaid'];
            redirect += '&start=' + values[0];
            redirect += '&end=' + values[1];
            redirect += '&price=' + values[2];
            window.location.replace(redirect);
        } else {
            alertify.error('Please select period');
        }
    }

    <?php
    foreach($floorplans as $floorplan) {
    ?>

    $(document).ready(function () {

        floorplan_<?php echo $floorplan['id'];?> = new FloorShow({
            imgEl: $('#floor_image_<?php echo $floorplan['id']; ?>'),
            floorElementID: 'canvas_<?php echo $floorplan['id']; ?>',
            floorplanID: <?php echo $floorplan['id']; ?>,
            floor_name: '',
            areas: JSON.parse('<?php echo json_encode($floorplan['areas']); ?>'),
            canvasJSON: '<?php echo $floorplan['canvas'];?>'
        });

        floorplan_<?php echo $floorplan['id'];?>.areaClickCallback = function (area_data) {
            var out = "";
            if (area_data && typeof (area_data) == "object") {
                let bookButton = document.getElementById('bookNow');
                if (area_data['options']['status'] === 'unavailable') {
                    out += '<p>This spot is unavailable</p>';
                    bookButton.style.display = 'none';
                } else {
                    out += '<p>Hey there, let\'s book this amazing place!</p>';

                    out += '<select ';
                    out += 'id="bookData" data-object="' + reservationGloabls['object'] + '" ';
                    out += 'data-date="' + reservationGloabls['date'] + '" ';
                    out += 'data-persons="' + reservationGloabls['persons'] + '" ';
                    out += 'data-areaid="' + area_data['id'] + '" >';
                    out += '<option>Select</option>';
                    let i;
                    let timeSlots = area_data['timeSlots'];
                    let timeSlotsLength = timeSlots.length;
                    for (i = 0; i < timeSlotsLength; i++) {
                        out += '<option value="';
                        out += timeSlots[i]['slotTimeFrom'] + '|' + timeSlots[i]['slotTimeTo'] + '|' + timeSlots[i]['slotPrice'];
                        out += '">'
                        out += 'From: ' + timeSlots[i]['slotTimeFrom'] + ' to: ' + timeSlots[i]['slotTimeTo'] + '. Price: ' + timeSlots[i]['slotPrice'] + ' &euro;';
                        out += '</option>';
                    }
                    out += '</select>';
                    bookButton.style.display = 'initial';
                }
            } else {
                out = area_data;
            }
            $('#area_data').html(out);
            $('#booking_modal').modal();
        }
        $('#zoomIn_<?php echo $floorplan['id'];?>').click(function () {
            floorplan_<?php echo $floorplan['id'];?>.scaleAndPositionCanvas(1.125);
        })

        $('#zoomOut_<?php echo $floorplan['id'];?>').click(function () {
            floorplan_<?php echo $floorplan['id'];?>.scaleAndPositionCanvas(0.875);
        })
    });

    $(window).resize(function () {
        floorplan_<?php echo $floorplan['id'];?>.scaleAndPositionCanvas();
    });
    <?php
    }
    }
    ?>


</script>
