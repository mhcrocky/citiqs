<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="container" style="margin-top:20px">
    <div class="row">
        <div class="col-lg-6">
            <form method="post" id="<?php echo $id; ?>" onsubmit="return saveDesign(this)">
                <?php 
                    include_once FCPATH . 'application/views/warehouse/includes/design/selectTypeView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/closed.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/selectSpotView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/makeOrderNewView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/checkoutOrderView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/buyerDetailsView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/payOrderView.php';
                ?>
                <input type="submit" class="btn btn-primary" value="submit" />
            </form>
        </div>
        <div class="col-lg-6">
            <div style="margin:auto; width:80%;">
                <iframe id="iframe" src="<?php echo $iframeSrc; ?>" width="400px" height="650px" style="position:fixed"></iframe>
            </div>
        </div>
    </div>
</main>
