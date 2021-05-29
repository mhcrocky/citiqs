<div class="col-12 step step-2 active" id="person-input">
    <h3 id="title">
        <span id="choose-spot">Selecteer: </span>
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
        /*
        ?>

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
                        <img style="width:100%;height: 250px; border-top-left-radius: 10px;border-top-right-radius: 10px;" class="bd-placeholder-img card-img-top"
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
*/



?>

<?php if($spots_exist): ?>
    <table style="background: none !important;" class="table table-striped w-100 text-center">
        <tr>
            <th id="place"><?php echo $this->language->tLine('Place'); ?></th>
            <th id="status"><?php echo $this->language->tLine('Status'); ?></th>
        </tr>
        <?php foreach($spots as $key=>$spot): ?>
        
            <tr>
                <td style="vertical-align: middle !important;">
                    <a style="text-decoration: none;" class="text-dark" href="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot['data']->id; ?>?order=<?php echo $orderRandomKey; ?>">
                        <?php echo $spot['data']->descript; ?>
                    <a>
                </td>
                <td style="vertical-align: middle !important;">
                <?php if($spot['data']->status == 'soldout'): ?>
                    <a href="javascript:;" id="btn-soldout" class="btn btn-danger">
                        <?php echo 'Sold Out'; ?>
                    </a>
                <?php else: ?>
                    <a href="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot['data']->id; ?>?order=<?php echo $orderRandomKey; ?>" id="btn-available" class="btn btn-primary">
                       <?php echo $this->language->tLine('Available'); ?>
                    </a>
                <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
