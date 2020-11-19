<!DOCTYPE html>
<html >
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
    [type="radio"]:checked + label,
    [type="radio"]:not(:checked) + label
    {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #666;
    }
    [type="radio"]:checked + label:before,
    [type="radio"]:not(:checked) + label:before {
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
    [type="radio"]:checked + label:after,
    [type="radio"]:not(:checked) + label:after {
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
    [type="radio"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    [type="radio"]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

</style>


<div class="main-wrapper" >
    <div class="col-half background-blue" id="info424" >
        <div class="background-blue height-50" >
        <div style="text-align: left">
            <a href="javascript:history.back()"><i class="fa fa-arrow-circle-left" style="font-size:48px; color:white"></i></a>
        </div>
            <div class="width-650"></div>
            <div class="text-center mb-50" style="text-align:center">
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $spot->image; ?>" alt="tiqs" width="150" height="auto" />
            </div>

            <div align="center">
                <p class="text-content mb-50"><?php echo $this->language->Line("TIMESLOT-BOOKING-0001", "CHOOSE YOUR TIME"); ?></p>
            </div>
            <div class="login-box" align="center">
                <form id="checkItem" action="<?php echo $this->baseUrl; ?>booking_agenda/time_slots/<?php echo $spot->id; ?>" method="post" enctype="multipart/form-data">
                    <?php $status_open = false; ?>
                    <?php foreach ($timeSlots as $key => $timeSlot): ?>
                        
                        <?php if($timeSlot['status'] != "soldout"): ?>
                        
                        <?php $status_open = true; ?>
                            <p>
                                <input type="radio" id="test<?php echo $timeSlot['id']; ?>" name="selected_time_slot_id" value="<?php echo $timeSlot['id']; ?>" checked>
                                <label style="font-family: caption-light; font-size: large; text-align: right;" for="test<?php echo $timeSlot['id']; ?>">
                                    <?php echo $timeSlot['timeslotdescript']; ?>
                                </label>
                            <div>
                                <?php echo date("H:i", strtotime($timeSlot['fromtime'])).' - '.date("H:i", strtotime($timeSlot['totime'])); ?>
                            </div>
                            </p>
                        <?php else: ?>
                            <p>
                            <div style="font-family: caption-light; font-size: small">
                            <?php echo date("H:i", strtotime($timeSlot['fromtime'])).' - '.date("H:i", strtotime($timeSlot['totime'])); ?>
                                &nbsp <span style="color: #ff4d4d;font-weight:bold;"> SOLD OUT</span>
                            </div>
                            </p>
                        <?php endif; ?>
                     <?php endforeach; ?>

                     <?php if($status_open): ?>
                    <div class="form-group has-feedback mt-35" >
                        <div style="text-align: center; ">
                            <input type="hidden" name="save" value="1" />
                            <button type="submit" class="button button-orange mb-25"><?php echo ($this->language->Line("TIMESLOT-BOOKING-0002", "NEXT")) ? $this->language->Line("TIMESLOT-BOOKING-0002", "NEXT") : 'NEXT'; ?></button>
                        </div>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            <div align="center">
                <p style="font-size: smaller" class="text-content mb-50"><?php echo $this->language->Line("TIMESLOT-BOOKING-0003", "RESERVE LONG TIMESLOT? ADD AN ADDITIONAL TIME SLOT TO YOUR BOOKING IN THE NEXT SCREEN"); ?></p>
            </div>
            <div class="form-group has-feedback mt-35" >
                <div style="text-align: right">
                    <a href="#top" ><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-half  background-yankee timeline-content">

    </div>
</div>
</body>


