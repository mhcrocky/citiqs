<?php $backgroundColors = ['background-blue-light', 'background-blue', 'background-orange-light', 'background-purple-light', 'background-orange']; ?>
<div class="col-12 step step-2 active" id="person-input">
    <h3 id="title">
        <span id="choose-spot">Choose an available SPOT: </span>
    </h3>
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
            
            $spots = $rows;

        }
        
        ?>
    <?php $count = 0; ?>
    <?php $backgroundCount = 0; ?>
    <?php if($spots_exist): ?>
    <div class="w-100 social-box">
        <div class="w-100 container text-center">
            <?php foreach($spots as $key=>$spot): ?>
            <div class="row">






                <div class="w-100 text-center">
                    <div id="card" class="w-100 box"
                    <?php if(!empty($spot['data']->image) || $spot['data']->image != ''): ?>
                        style="padding: 0px !important;height: 500px;"
                    <?php endif; ?>
                        onclick="window.location.replace(`<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot['data']->id; ?>`)">
                        <?php if(!empty($spot['data']->image) || $spot['data']->image != ''): ?>
                        <img style="width:100%;height: 250px" class="bd-placeholder-img card-img-top"
                            src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $spot['data']->image; ?>">
                        <?php endif; ?>
                        <div class="box-title mt-2">
                            <h3 id="spot-title"><?php echo $spot['data']->descript; ?></h3>
                        </div>
                        <div class="box-text">
                            <span class="spot-data"><?php echo date("d.m.Y", strtotime($eventDate)) ?></span>
                        </div>
                        <div class="box-text">
                            <span class="spot-data"><?php echo $spot['data']->pricingdescript; ?> €
                                <?php echo number_format($spot['data']->price, 2); ?></span>
                        </div>
                        <div class="box-btn pt-4">
                            <a id="choose-time"
                                href="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot['data']->id; ?>"
                                class="button button-orange mb-25"><?= ($this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME")) ? $this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME") : 'Next'; ?></a>
                        </div>
                    </div>
                </div>



                <?php $backgroundCount++; ?>
                <?php if($backgroundCount == count($backgroundColors)): ?>
                <?php $backgroundCount = 0; ?>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="social-box">
        <div class="container text-center">
            <h3 class="text-content mb-50">
                Sorry, we don't have any SPOT available for this date!
            </h3>
        </div>
    </div>
    <?php endif; ?>
    <div class="w-100 go-back-wrapper">
        <a class="go-back-button" href="javascript:history.back()">Go Back</a>
    </div>
</div>
<script>

</script>
