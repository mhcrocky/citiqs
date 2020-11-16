<h1 style="margin:70px 0px 20px 35px">Visma Configuration</h1>
<main class="row" style="margin:0px 20px">
    <!-- <div class="col-sm-12" style="margin:20px 0px;"> -->
        <div class="col-md-6 col-sm-12">
            <form method="post" action="<?php echo base_url() ?>config_visma/app_settings">
                <div class="card" style="background-color:#138575">
                    <div class="card-body pb-0">
                        <p class="lead text-white">Store visma setting</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="year" class="col-sm-3 control-label">Accounting Year</label>
                    <div class="col-sm-9">
                        <select name="visma_year" id="year" class="form-control">
                            <option value="">--- select Accounting year ---</option>
                            <?php
                            if (isset($years) && is_array($years)) {
                                foreach ($years as $year) {
                                    $parts = explode("|", $year);
                                    $sel = ($setting->visma_year == $parts[0] ? 'selected' : '');
                                ?>
                                <option value="<?php echo $parts[0] ?>" <?php echo $sel ?>><?php echo $parts[1] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <!-- <hr />
                <div class="form-group">
                    <label for="visma_booking_account" class="col-sm-3 control-label">Visma Booking Account</label>
                    <div class="col-sm-9">
                        <select name="visma_booking_account" id="visma_booking_account" class="form-control">
                            <option value="" selected="selected">--- select Booking account ---</option>
                            <?php
                            if (isset($banks_data) && is_array($banks_data)) {
                                foreach ($banks_data as $gla) {
                                    $parts = explode("|", $gla);
                                    $sel = ($setting->visma_booking_account == trim($parts[0]) ? 'selected' : '');
                            ?>
                                    <option value="<?php echo trim($parts[0]) ?>" <?php echo $sel ?>><?php echo $parts[1] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div> -->
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" name="default_visma" id="default_visma" class="default_exact btn btn-primary btn-sm" data-loading-text="Processing....">Save settings</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card" style="background-color:#138575">
                <div class="card-body pb-0">
                    <p class="lead text-white text-white">Visma Vat / Debtors Settings</p>
                </div>
            </div>
            <div class="row">
                <label for="year" class="col-sm-12 control-label">Ledger Links</label>
                <div class="col-md-6">
                <a href="<?php echo base_url(); ?>setting/visma/vat">VAT ledger links</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <a href="<?php echo base_url(); ?>setting/visma/debitors">Payments ledger links</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <a href="<?php echo base_url(); ?>setting/visma/creditors">Sales ledger links</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <a href="<?php echo base_url(); ?>setting/visma/service">Service Fee ledger links</a>
                </div>
            </div>
        </div>
    <!-- </div> -->
</main>