<!DOCTYPE html>
<html>

<body>

    <style>
    .container {
        position: relative;
        width: 100%;
        max-width: 400px;
    }

    .container img {
        width: 100%;
        height: auto;
    }

    .container .btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        text-align: center;
    }

    .container .btn:hover {
        background-color: black;
    }

    .column-left {
        float: left;
        width: 33.333%;
    }

    .column-right {
        float: right;
        width: 33.333%;
    }

    .column-center {
        display: inline-block;
        width: 33.333%;
    }

    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }

    [type="radio"]:checked+label,
    [type="radio"]:not(:checked)+label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #666;
    }

    [type="radio"]:checked+label:before,
    [type="radio"]:not(:checked)+label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff;
    }

    [type="radio"]:checked+label:after,
    [type="radio"]:not(:checked)+label:after {
        content: '';
        width: 30px;
        height: 30px;
        background: #f8000c;
        position: absolute;
        top: -4px;
        left: -8px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }

    [type="radio"]:not(:checked)+label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }

    [type="radio"]:checked+label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
    </style>


    <div class="main-wrapper">
        <div class="col-half background-blue" id="info424">
            <div class="background-blue height-50">
                <div style="text-align: left">
                    <a href="javascript:history.back()"><i class="fa fa-arrow-circle-left"
                            style="font-size:48px; color:white"></i></a>
                </div>
                <div class="width-650"></div>
                <div class="text-center mb-50" style="text-align:center">
                    <img src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $spot->image; ?>" alt="tiqs"
                        width="150" height="auto" />
                </div>

                <div align="center">
                    <p class="text-content mb-50">
                        <?php echo $this->language->Line("TIMESLOT-BOOKING-0001", "CHOOSE YOUR TIME"); ?></p>
                </div>
                <div class="login-box" align="center">
                    <form id="checkItem"
                        action="<?php echo $this->baseUrl; ?>booking_agenda/time_slots/<?php echo $spot->id; ?>?order=<?php echo $orderRandomKey; ?>"
                        method="post" enctype="multipart/form-data">
                        <input type="hidden" id="startTime" name="startTime">
                        <input type="hidden" id="endTime" name="endTime">
                        <?php $status_open = false; ?>
                        <?php foreach ($timeSlots as $key => $timeSlot): ?>
                        <?php 
                        if($timeSlot['multiple_timeslots'] == 1):
                            $fromtime = explode(':',$timeSlot['fromtime']);
                            $totime = explode(':', $timeSlot['totime']);
                            $duration = explode(':', $timeSlot['duration']);
                            $overflow = explode(':', $timeSlot['overflow']);

                            $time_diff = ($totime[0]*60 - $fromtime[0]*60) + ($totime[1] - $fromtime[1]);
                            $time_duration = ($duration[0]*60 + $overflow[0]*60) + ($duration[1] + $overflow[1]);
                            $time_div = intval($time_diff/$time_duration);
                            $start_time = '';
                            $end_time = '';
                            for($i=0; $i < $time_div; $i++):
                            
                            if($i == 0){
                                $start_time = Booking_agenda::explode_time($timeSlot['fromtime']);
                                $end_time = $start_time + Booking_agenda::explode_time($timeSlot['duration']);
                            } else {
                                $start_time = $end_time + Booking_agenda::explode_time($timeSlot['overflow']);
                                $end_time = $start_time + Booking_agenda::explode_time($timeSlot['duration']);
                            }

                        if($timeSlot['status'] != "soldout"): ?>

                        <?php $status_open = true; ?>

                        <p>
                            <input type="radio" id="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>" name="selected_time_slot_id"
                                value="<?php echo $timeSlot['id']; ?>" data-starttime="<?php echo $start_time; ?>" data-endtime="<?php echo $end_time; ?>" checked>
                            <label style="font-family: caption-light; font-size: large; text-align: right;"
                                for="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>">
                                <?php echo $timeSlot['timeslotdescript']; ?>
                            </label>
                        <div>
                            <?php echo Booking_agenda::second_to_hhmm($start_time).' - '.Booking_agenda::second_to_hhmm($end_time); ?>
                        </div>
                        </p>
                        <?php  else: ?>
                        <p>
                        <div style="font-family: caption-light; font-size: small">
                        <?php echo Booking_agenda::second_to_hhmm($start_time).' - '.Booking_agenda::second_to_hhmm($end_time); ?>
                            &nbsp <span style="color: #ff4d4d;font-weight:bold;"> SOLD OUT</span>
                        </div>
                        </p>
                        <?php endif; ?>
                        <?php endfor; ?>
                        <?php else: 
                        $dt1 = new DateTime($timeSlot['fromtime']);
                        $fromtime = $dt1->format('H:i');
                        $dt2 = new DateTime($timeSlot['totime']);
                        $totime = $dt2->format('H:i'); ?>

                        <?php 
                        if($timeSlot['status'] != "soldout"): ?>

                        <?php $status_open = true; ?>

                        <p>
                            <input type="radio" id="test<?php echo $timeSlot['id']; ?>" name="selected_time_slot_id"
                                value="<?php echo $timeSlot['id']; ?>" checked>
                            <label style="font-family: caption-light; font-size: large; text-align: right;"
                                for="test<?php echo $timeSlot['id']; ?>">
                                <?php echo $timeSlot['timeslotdescript']; ?>
                            </label>
                        <div>
                            <?php echo $fromtime .' - '.$totime; ?>
                        </div>
                        </p>
                        <?php else: ?>
                        <p>
                        <div style="font-family: caption-light; font-size: small">
                            <?php echo $fromtime.' - '.$totime; ?>
                            &nbsp <span style="color: #ff4d4d;font-weight:bold;"> SOLD OUT</span>
                        </div>
                        </p>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <?php if($status_open): ?>
                        <div class="form-group has-feedback mt-35">
                            <div style="text-align: center; ">
                                <input type="hidden" name="save" value="1" />
                                <button type="button" onclick="submitTimeslotForm()"
                                    class="button button-orange mb-25"><?php echo ($this->language->Line("TIMESLOT-BOOKING-0002", "NEXT")) ? $this->language->Line("TIMESLOT-BOOKING-0002", "NEXT") : 'NEXT'; ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
                <div align="center">
                    <p style="font-size: smaller" class="text-content mb-50">
                        <?php echo $this->language->Line("TIMESLOT-BOOKING-0003", "RESERVE LONG TIMESLOT? ADD AN ADDITIONAL TIME SLOT TO YOUR BOOKING IN THE NEXT SCREEN"); ?>
                    </p>
                </div>
                <div class="form-group has-feedback mt-35">
                    <div style="text-align: right">
                        <a href="#top"><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-half  background-yankee timeline-content">
            <div class="row mh-100 mb-5 canvas_row" id="canvas_row">
                <div class="col-md-12 mh-100 p-2 mt-5" id="floor_image">
                    <canvas id="canvas" width="200" height="200"></canvas>
                    <img style="visibility: hidden;"
                        src="<?php echo base_url().'uploads/floorPlans/'.$floorplan->file_name; ?>">
                </div>
            </div>
        </div>
    </div>
</body>

<script>
const BASE_URL = '<?php echo base_url(); ?>';
const FLOOR_IMAGES_PATH = '<?php echo str_replace('\\', '/', $floorplan_images_path);?>';
</script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/popper.min.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/objectFloorPlans.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/fabric_v4.0.0-beta.8.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorplan.js"></script>
<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorEditor.js"></script>
<script>
var floorplan;
$(document).ready(function() {

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
        position: {
            x: 0.5,
            y: -0.5
        },
        offsetY: -8,
        offsetX: 8,
        cursorStyle: 'pointer',
        mouseUpHandler: (eventData, target) => {
            floorplan.deleteObject(eventData, target);
            console.log(floorplan);
        },
        render: floorplan.renderIcon(floorplan.deleteImg),
        cornerSize: 24
    });
    $(window).resize(function() {
        floorplan.scaleAndPositionCanvas();
    });


});

function submitTimeslotForm(){
    let timeslotId = $('input[name="selected_time_slot_id"]:checked').val();
    let startTime = $('input[name="selected_time_slot_id"]:checked').data('starttime');
    let endTime = $('input[name="selected_time_slot_id"]:checked').data('endtime');
    $('#startTime').val(startTime);
    $('#endTime').val(endTime);
    $('#checkItem').submit();
}
</script>