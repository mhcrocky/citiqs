<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="main-wrapper">
    <div class="col-half background-blue" id="info424">
        <div class="background-blue height-50">
            <div style="text-align: left">
                <a href="javascript:history.back()"><i class="fa fa-arrow-circle-left"
                        style="font-size:48px; color:white"></i></a>
            </div>
            <div class="width-650"></div>
            <div class="text-center mb-50" style="text-align:center">
            <?php if(file_exists(FCPATH . 'assets/home/images/' . $spot->image) && $spot->image != ''): ?>
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $spot->image; ?>" alt="tiqs"
                    width="150" height="auto" />
            <?php endif; ?>
            </div>

            <div style="text-align: center">
                <p class="text-content mb-50">
                    <?php echo $this->language->Line("TIMESLOT-BOOKING-0001", "CHOOSE YOUR TIME"); ?></p>
            </div>
            <div class="login-box" style="text-align: center">
                <form id="checkItem"
                    action="<?php echo $this->baseUrl; ?>booking_agenda/time_slots/<?php echo $spot->id; ?>?order=<?php echo $orderRandomKey; ?>"
                    method="post" enctype="multipart/form-data"
                >
                    <input type="hidden" id="startTime" name="startTime" />
                    <input type="hidden" id="endTime" name="endTime" />
                    <?php
                        $status_open = false;
                        // echo '<pre>';
                        foreach ($timeSlots as $key => $timeSlot) {
                            if ($timeSlot['multiple_timeslots'] === '1') {

                                #print_r($timeSlot);

                                $start_time = '';
                                $end_time = '';

                                $duration = explode(':', $timeSlot['duration']);
                                $overflow = explode(':', $timeSlot['overflow']);

                                $step = 3600 * (intval($duration[0]) + intval($overflow[0]));
                                $step += 60 * (intval($duration[1]) + intval($overflow[1]));
                                $step += intval($duration[2]) + intval($overflow[2]);
                                // var_dump($step);die();

                                // print_r($timeSlot['duration']);
                                // echo '<br/><br/>';
                                // print_r($timeSlot['overflow']);
                                // echo '<br/><br/>';
                                // print_r(strtotime($timeSlot['duration']));
                                // echo '<br/><br/>';
                                // print_r(strtotime($timeSlot['overflow']));
                                // echo '<br/><br/>';
                                // print_r(date('H:i:s', strtotime($timeSlot['duration'])));
                                // echo '<br/><br/>';
                                // print_r(date('H:i:s', strtotime($timeSlot['overflow'])));
                                // echo '<br/><br/>';
                                // $step = date('H:i:s', strtotime($timeSlot['duration']) + strtotime($timeSlot['overflow']));
                                // print_r($step);
                                // $step = explode(':', $step);
                                // print_r($step);
                                // $step = intval($step[0]) * 3600 + intval($step[1]) * 60 + intval($step[2]);
                                // print_r($step);
                                // echo '<br/><br/><br/><br/>';

                                $checkStartPoint = date('H:i:s', strtotime($timeSlot['fromtime']));
                                // print_r($checkStartPoint);
                                $checkStartPoint = explode(':', $checkStartPoint);
                                // print_r($checkStartPoint);

                                $checkStartPoint = intval($checkStartPoint[0]) * 3600 + intval($checkStartPoint[1]) * 60 + intval($checkStartPoint[2]);
                                // print_r($checkStartPoint);
                                // echo '<br/>';

                                $checkEndPoint = date('H:i:s', ($checkStartPoint + $step));
                                // print_r($checkEndPoint);
                                $checkEndPoint = explode(':', $checkEndPoint);
                                // print_r($checkEndPoint);
                                $checkEndPoint = intval($checkEndPoint[0]) * 3600 + intval($checkEndPoint[1]) * 60 + intval($checkEndPoint[2]);
                                // print_r($checkEndPoint);
                                // echo '<br/>';
                                $endTime = date('H:i:s', strtotime($timeSlot['totime']));
                                // print_r($endTime);
                                $endTime = explode(':', $endTime);
                                // print_r($endTime);
                                $hours = ($timeSlot['totime'] > $timeSlot['fromtime']) ? intval($endTime[0]) : intval($endTime[0]) + 24;
                                $endTime = $hours * 3600 + intval($endTime[1]) * 60 + intval($endTime[2]);
                                // print_r($endTime);

                                // die();
                                $i = 0;
                                $notBreak = true;
                                #while (!($endTime >= $checkStartPoint && $endTime <= $checkEndPoint)) {
                                while ($notBreak) {   

                                    // to fetch last period
                                    $notBreak = !($endTime >= $checkStartPoint && $endTime <= $checkEndPoint);
                                    // if ($i < 25) {
                                    //     $i++;
                                        // var_dump('START POINT: ' .date('H:i:s', $checkStartPoint));
                                        // var_dump('POINT: ' . date('H:i:s', $endTime));
                                        // var_dump('END POINT: ' .date('H:i:s', $checkEndPoint));
                                        // var_dump(!($endTime >= $checkStartPoint && $endTime <= $checkEndPoint));
                                        // $notBreak = !($endTime >= $checkStartPoint && $endTime <= $checkEndPoint);
                                    //     if ($i === 21) die();
                                    // }
                                    // continue;

                                    if ($i == 0) {
                                        $start_time = Booking_agenda::explode_time($timeSlot['fromtime']);
                                        $end_time = $start_time + Booking_agenda::explode_time($timeSlot['duration']);
                                    } else {
                                        $start_time = $end_time + Booking_agenda::explode_time($timeSlot['overflow']);
                                        $end_time = $start_time + Booking_agenda::explode_time($timeSlot['duration']);
                                    }

                                    $timeslotSoldout = Booking_agenda::check_if_soldout($timeSlot['id'], Booking_agenda::second_to_hhmm($start_time), Booking_agenda::second_to_hhmm($end_time), $timeSlot['available_items']);
                                    $timeSlot['status'] = ($timeslotSoldout === true) ? 'soldout' : 'open';
                                    
                                    if ($timeSlot['status'] !== 'soldout') {
                                        $status_open = true; ?>
                                            <p>
                                                <input
                                                    type="radio"
                                                    id="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>"
                                                    name="selected_time_slot_id"
                                                    value="<?php echo $timeSlot['id']; ?>"
                                                    data-starttime="<?php echo $start_time; ?>"
                                                    data-endtime="<?php echo $end_time; ?>"
                                                    checked
                                                />
                                                <label
                                                    style="font-family: caption-light; font-size: large; text-align: right;"
                                                    for="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>"
                                                >
                                                    <?php echo $timeSlot['timeslotdescript']; ?>
                                                </label>
                                                <div>
                                                    <?php echo Booking_agenda::second_to_hhmm($start_time).' - '.Booking_agenda::second_to_hhmm($end_time); ?>
                                                </div>
                                            </p>
                                        <?php
                                    } else {
                                        ?>
                                            <p>
                                                <div style="font-family: caption-light; font-size: small">
                                                    <?php echo Booking_agenda::second_to_hhmm($start_time).' - '.Booking_agenda::second_to_hhmm($end_time); ?>
                                                    &nbsp;&nbsp;
                                                    <span style="color: #ff4d4d;font-weight:bold;">SOLD OUT</span>
                                                </div>
                                            </p>
                                        <?php
                                    };
                                    $i++;
                                    $checkStartPoint += $step;
                                    $checkEndPoint += $step;
                                }
                            } else {
                                $dt1 = new DateTime($timeSlot['fromtime']);
                                $fromtime = $dt1->format('H:i');
                                $dt2 = new DateTime($timeSlot['totime']);
                                $totime = $dt2->format('H:i');

                                if ($timeSlot['status'] != "soldout") {
                                    $status_open = true;
                                    ?>
                                        <p>
                                            <input
                                                type="radio"
                                                id="test<?php echo $timeSlot['id']; ?>"
                                                name="selected_time_slot_id"
                                                value="<?php echo $timeSlot['id']; ?>"
                                                checked
                                            />
                                            <label
                                                style="font-family: caption-light; font-size: large; text-align: right;"
                                                for="test<?php echo $timeSlot['id']; ?>"
                                            >
                                                <?php echo $timeSlot['timeslotdescript']; ?>
                                            </label>
                                            <div>
                                                <?php echo $fromtime .' - '.$totime; ?>
                                            </div>
                                        </p>
                                    <?php
                                } else {
                                    ?>
                                        <p>
                                            <div style="font-family: caption-light; font-size: small">
                                                <?php echo $fromtime.' - '.$totime; ?>
                                                &nbsp;&nbsp;
                                                <span style="color: #ff4d4d;font-weight:bold;">SOLD OUT</span>
                                            </div>
                                        </p>
                                    <?php
                                }
                            }
                        }
                    ?>
                    <?php if ($status_open) { ?>
                        <div class="form-group has-feedback mt-35">
                            <div style="text-align: center; ">
                                <input type="hidden" name="save" value="1" />
                                <button
                                    type="button"
                                    onclick="submitTimeslotForm()"
                                    class="button button-orange mb-25"
                                >
                                    <?php echo ($this->language->Line("TIMESLOT-BOOKING-0002", "NEXT")) ? $this->language->Line("TIMESLOT-BOOKING-0002", "NEXT") : 'NEXT'; ?>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            <?php if($spot->maxBooking > 1): ?>
            <div style="text-align:center">
                <p style="font-size: smaller" class="text-content mb-50">
                    <?php echo $this->language->Line("TIMESLOT-BOOKING-0003", "RESERVE LONG TIMESLOT? ADD AN ADDITIONAL TIME SLOT TO YOUR BOOKING IN THE NEXT SCREEN"); ?>
                </p>
            </div>
            <?php endif; ?>
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
                <?php if(isset($floorplan) && isset($floorplan->file_name)){ ?>
                <img style="visibility: hidden;"
                    src="<?php echo base_url().'uploads/floorPlans/' . $floorplan->file_name; ?>">
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!--
    <script>
        const BASE_URL = '<?php #echo $this->baseUrl; ?>';
        const FLOOR_IMAGES_PATH = '<?php #echo str_replace('\\', '/', $floorplan_images_path);?>';
    </script>

    <script src="<?php #echo $this->baseUrl; ?>assets/floorplan/assets/js/popper.min.js"></script>
    <script src="<?php #echo $this->baseUrl; ?>assets/home/js/objectFloorPlans.js"></script>
    <script src="<?php #echo $this->baseUrl; ?>assets/floorplan/assets/js/fabric_v4.0.0-beta.8.js"></script>
    <script src="<?php #echo $this->baseUrl; ?>assets/floorplan/assets/js/floorplan.js"></script>
    <script src="<?php #echo $this->baseUrl; ?>assets/floorplan/assets/js/floorEditor.js"></script>

    <script>
        var floorplan;
        $(document).ready(function() {
            floorplan = new FloorEditor({
                floorElementID: 'canvas',
                imgEl: $('#floor_image'),
                <?php #if ($floorplan_images) { ?>
                objectsImages: $.parseJSON('<?php #echo json_encode($floorplan_images); ?>'),
                <?php #} ?>

                <?php #if (isset($floorplan) AND $floorplan) { ?>
                floorplanID: <?php #echo $floorplan->id; ?>,
                imageUploaded: <?php #echo $floorplan->file_name ? 'true' : 'false'; ?>,
                floor_name: '<?php #echo $floorplan->floor_name; ?>',
                areas: $.parseJSON('<?php #echo json_encode($areas); ?>'),
                canvasJSON: '<?php #echo $floorplan->canvas;?>'
                <?php #} ?>
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


    </script>
-->
