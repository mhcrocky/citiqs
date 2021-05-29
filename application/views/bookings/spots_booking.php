<!DOCTYPE html>
<html>
<head>
<style>
.form-control {
    font-family:'caption-light'; 
    border:none; 
    border-radius: 50px; 
}


p.p-input {
    font-family:'caption-light'; 
    color: #ffffff; 
    font-size:100%; 
    text-align: center
}

p.p-title {
    font-family:'caption-bold'; 
    font-size:300%; 
    color:#ffffff;
}

.checked-img {
    background: #4d4dff;
}

</style>
<body>
<?php $backgroundColors = ['background-blue-light', 'background-blue', 'background-orange-light', 'background-purple-light', 'background-orange']; ?>
<?php //$backgroundColors = ['background-blue-light', 'background-blue']; ?>

<div class="main-wrapper">
    <div class="col-half background-blue" id="info424">
        <?php 
        $last = $this->uri->total_segments();
        $agenda_id = $this->uri->segment($last);
        if($spots){
            $spots_exist = false;
            $rows = array();
            $keys = array_keys($spots);
            for($i=0; $i< count($spots); $i++){
                
                if($agenda_id == $spots[$keys[$i]]['data']->agenda_id){
                    $spots_exist = true;
                    $rows[$keys[$i]] = $spots[$keys[$i]];
                    
                }
            }
            // here we filter egendaId spots
            $spots = $rows;

        }
        
        ?>
            <?php $count = 0; ?>
            <?php $backgroundCount = 0; ?>
            <?php if($spots_exist): ?>
            <?php foreach($spots as $key=>$spot): ?>
                <?php if($count % 2 == 0): ?>
                    <div style="background:<?php echo $spot['data']->background_color; ?> !important" class="<?php echo $backgroundColors[$backgroundCount]; ?> height-40">
                    <div style="text-align: left">
                        <a href="javascript:history.back()"><i class="fa fa-arrow-circle-left" style="font-size:48px; color:white"></i></a>
                    </div>
                        <div class="width-650"></div>
                        <div align="center">
                            <p class="text-content mb-50"><?php echo date("d.m.Y", strtotime($eventDate)) ?></p>
                        </div>
                        
                        <div class="text-center mb-50" style="text-align:center">
                        <?php if(file_exists(FCPATH . 'assets/home/images/' . $spot['data']->image) && $spot['data']->image != ''): ?>
                            <img src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $spot['data']->image; ?>" alt="tiqs" width="150"
                                 height="auto"/>
                        <?php endif; ?>
                        </div>
                        

                        <?php if ($spot['status'] != "soldout"): ?>
                            <div align="center">
                                <p class="text-content mb-50" style="text-transform: uppercase"><?php echo $spot['data']->descript; ?></p>
                            </div>
                            <div align="center">
                            <?php if($spot['data']->price != 0): ?>
                                <p class="text-content" style="text-transform: uppercase">
                                    <?php
                                        echo $spot['data']->pricingdescript . '&nbsp;&euro;&nbsp;';
                                        $price = intval($spot['data']->timeSlotPrice) ? $spot['data']->timeSlotPrice : $spot['data']->price;
                                        echo number_format($price, 2);
                                    ?>
                                </p>
                                <p class="text-content mb-50" style="font-family: caption-light;font-size: small">
                                    <?php
                                        echo $spot['data']->feedescript . '&nbsp;&euro;&nbsp' . number_format(($spot['data']->reservationFee), 2, ",",".");
                                    ?>
                                </p>
                            <?php else: ?>
                            <div align="center">
                                <p class="text-content" style="text-transform: uppercase">&nbsp</p>
                                <p class="text-content mb-50" style="font-family: caption-light;font-size: small">&nbsp</p>
                            </div>
                            <?php endif; ?>
                            </div>
                            <div class="form-group has-feedback mt-35">
                                <div style="text-align: center; ">
                                <?php if($spot['data']->send_to_email == 1): ?>
                                    <a href="mailto:<?php echo $spot['data']->spot_email; ?>" class="button button-orange mb-25"> <?php echo $this->language->tLine('Send To Email'); ?> </a>
                                <?php else: ?>
                                    <a href="<?php echo $this->baseUrl; ?>booking_agenda/time_slots/<?php echo $spot['data']->id; ?>?order=<?php echo $orderRandomKey; ?>" class="button button-orange mb-25"><?php echo ($this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME")) ? $this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME") : 'Next'; ?> </a>
                                <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div align="center">
                                <p class="text-content mb-50" style="text-transform: uppercase;">
                                    <?php echo $spot['data']->soldoutdescript; ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="form-group has-feedback mt-35">
                            <div style="text-align: right">
                                <a href="#top"><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php $backgroundCount++; ?>
                    <?php if($backgroundCount == count($backgroundColors)): ?>
                        <?php $backgroundCount = 0; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php $count++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        
    </div>

    <div class="col-half background-yellow" id="info424">
    

            <?php $count = 0; ?>
            <?php $backgroundCount = count($backgroundColors) - 1; ?>
            <?php if($spots_exist): ?>
            <?php foreach($spots as $key=>$spot): ?>
                <?php if($count % 2 != 0): ?>
                    <div class="<?php echo $backgroundColors[$backgroundCount]; ?> height-40">
                        <div style="text-align: left">
                            <a style="visibility:hidden;" href="#top"><i class="fa fa-arrow-circle-left" style="font-size:48px; color:white"></i></a>
                        </div>
                        <div class="width-650"></div>
                        <div align="center">
                            <p class="text-content mb-50"><?php echo date("d.m.Y", strtotime($eventDate)) ?></p>
                        </div>
                        <div class="text-center mb-50" style="text-align:center">
                        <?php if(file_exists(FCPATH . 'assets/home/images/' . $spot['data']->image) && $spot['data']->image != ''): ?>
                            <img src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $spot['data']->image; ?>" alt="tiqs" width="150"
                                 height="auto"/>
                        <?php endif; ?>
                        </div>

                        <?php if ($spot['status'] != "soldout"): ?>
                            <div align="center">
                                <p class="text-content mb-50" style="text-transform: uppercase"><?php echo $spot['data']->descript; ?></p>
                            </div>
                            <?php if($spot['data']->price != 0): ?>
                            <div align="center">
                                <p class="text-content" style="text-transform: uppercase">
                                    <?php
                                        echo $spot['data']->pricingdescript . '&nbsp;&euro;&nbsp;';
                                        $price = intval($spot['data']->timeSlotPrice) ? $spot['data']->timeSlotPrice : $spot['data']->price;
                                        echo number_format($price, 2);
                                    ?>
                                </p>
                                <p class="text-content mb-50" style="font-family: caption-light;font-size: small">
                                    <?php
                                        echo $spot['data']->feedescript . '&nbsp;&euro;&nbsp' . number_format(($spot['data']->reservationFee), 2, ",",".");
                                    ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <div align="center">
                                <p class="text-content" style="text-transform: uppercase">&nbsp</p>
                                <p class="text-content mb-50" style="font-family: caption-light;font-size: small">&nbsp</p>
                            </div>
                            <?php endif; ?>
                            <div class="form-group has-feedback mt-35">
                                <div style="text-align: center; ">
                                    <a href="<?php echo $this->baseUrl; ?>booking_agenda/time_slots/<?php echo $spot['data']->id; ?>?order=<?php echo $orderRandomKey; ?>" class="button button-orange mb-25"><?= ($this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME")) ? $this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME") : 'Next'; ?> </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div align="center">
                                <p class="text-content mb-50" style="text-transform: uppercase;">
                                    <?php echo $spot['data']->soldoutdescript; ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="form-group has-feedback mt-35">
                            <div style="text-align: right">
                                <a href="#top"><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php $backgroundCount--; ?>
                    <?php if($backgroundCount == count($backgroundColors)): ?>
                        <?php $backgroundCount = count($backgroundColors); ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php $count++; ?>
            <?php endforeach; ?>
            <?php endif;?>
    </div>
</div>
</body>
<script>
/*
$(document).ready(function(){

    $(".img-check").click(function(){
        $(".check").removeClass("check");
        $(".checked-img").removeClass("checked-img");
        $(this).addClass("check");
        $(".check img").addClass("checked-img");
    });
    
    $('#save').on('click',function(e){
        e.preventDefault();
        let description = $("input[name=description]").val();
        let sold_out_description = $("input[name=sold_out_description]").val();
        let pricing_description = $("input[name=pricing_description]").val();
        let fee_description = $("input[name=fee_description]").val();
        let available_booking = $("input[name=available_booking]").val();
        let order = $("input[name=order").val();
        let number_persons = $("input[name=number_persons]").val();
        let price = $("input[name=price]").val();
        let agenda_id = $("input[name=agenda_id]").val();
        let image = $(".check").data("image");
        console.log(agenda_id);
        let spotData = {
            description:description,
            agenda_id: agenda_id,
            numberofpersons: number_persons,
            order: order,
            price: price,
            soldoutdescript: sold_out_description,
            pricingdescript: pricing_description,
            feedescript: fee_description,
            available_items: available_booking,
            image: image
        }
        $.post('//echo base_url(); ?>Agenda_booking/create_spots', spotData);
    });
})
*/
</script>
