<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/css/card-style.css">
<style>
    #spot-active {
        background: #b32400 !important;
    }
</style>
<?php $backgroundColors = ['background-blue-light', 'background-blue', 'background-orange-light', 'background-purple-light', 'background-orange']; ?>
    <div class="col-12 step step-2 active" id="person-input">
        <h3>Choose an available SPOT:</h3>
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
                <div class="social-box">
                    <div class="container text-center">
                        
                        <div class="row">
            <?php foreach($spots as $key=>$spot): ?>

                    



                    <div class="col-lg-6 col-xs-12 text-center">
					<div class="box" onClick="window.location.replace('<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot["data"]->id; ?>')">
                        <img style="filter: invert(70%);" width="auto" height="50px" src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $spot['data']->image; ?>" >
						<div class="box-title">
							<h3><?php echo $spot['data']->descript; ?></h3>
						</div>
                        <div class="box-text">
							<span><?php echo date("d.m.yy", strtotime($eventDate)) ?></span>
						</div>
						<div class="box-text">
							<span><?php echo $spot['data']->pricingdescript; ?> € <?php echo number_format($spot['data']->price, 2); ?></span>
						</div>
						<div class="box-btn">
                        <a href="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot['data']->id; ?>" class="button button-orange mb-25"><?= ($this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME")) ? $this->language->Line("SPOTS-BOOKING-0005", "CHOOSE A TIME") : 'Next'; ?></a>
                    </div>
					 </div>
				</div>



                    <?php $backgroundCount++; ?>
                    <?php if($backgroundCount == count($backgroundColors)): ?>
                        <?php $backgroundCount = 0; ?>
                    <?php endif; ?>
            <?php endforeach; ?>
                    </div>
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
