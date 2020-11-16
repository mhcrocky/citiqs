<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<h1 style="margin:70px 0px 20px 35px">Service Fee Ledgers</h1>
<?php
    if($setting->exact_option == 1){
        $accounting = 'exact';
    }elseif($setting->visma_option == 1){
        $accounting = 'visma';
    }
?>
<main class="row" style="margin:0px 20px">
    <div class="col-lg-6 col-md-12">
        <div class="card" style="background-color:#138575">
            <div class="card-body setting-card-body pb-0">
                <a href="<?php echo base_url($accounting.'/config'); ?>" type="button" class="btn btn-primary setting-btn" data-card-widget="collapse" data-toggle="tooltip" title="Setting">Setting</a>
                <p class="lead text-white setting-lead">Overiew</p>
            </div>
        </div>
        <div class="table-responsive project-stats">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Service Fee Ledgers</th>
                        <th class="w60"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($services) {
                        foreach ($services as $l) { ?>
                            <tr>
                                <td><a href="<?php echo base_url('setting/'.$accounting.'/service/'.$l->id); ?>">[<?php echo $l->external_code; ?>] Service Fee[<?php echo $l->serviceFeeAmount ?>](<?php echo $l->serviceFeeTax ?>%)</a></td>
                                <td class="w80 text-right"><a href="<?php echo base_url('setting/'.$accounting.'/service/'.$l->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> <a href="<?php echo base_url('setting/'.$accounting.'/service_delete/'.$l->id); ?>" class="btn btn-default btn-xs delete"><i class="fa fa-trash"></i></a></button></td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="card" style="background-color:#138575">
            <div class="card-body setting-card-body pb-0">
                <a href="<?php echo base_url('setting/'.$accounting.'/service'); ?>" type="button" class="btn btn-success setting-btn" data-card-widget="collapse" data-toggle="tooltip" title="Setting">Add</a>
                <p class="lead text-white setting-lead">Setting</p>
            </div>
        </div>
        <?php echo form_open('setting/'.$accounting.'_service/save') . "\r\n"; ?>
        <!-- <div class="form-group">
                <label for="debitor">Debitor *</label>
                <input type="text" name="debitor" id="debitor" class="form-control" data-parsley-trigger="change keyup" required value="<?php echo $this->session->flashdata('rate_desc'); ?>">
            </div> -->
        <div class="form-group">
            <label for="external_id" class="control-label">Service Fee Ledger *</label>
            <select name="external_id" id="external_id" class="form-control select2" required>
                <option value="" selected="selected">--- select service fee ledger ---</option>
                <?php
                if (isset($external_services) && is_array($external_services)) {
                    foreach ($external_services as $service) {
                        $parts = explode("|", $service);
                        if(count($parts)==3){
                            $value = trim($parts[0]).'_'.trim($parts[2]);
                        }else{
                            $value = trim($parts[0]);
                        }
                ?>
                        <option value="<?php echo $value ?>"><?php echo $parts[1] ?></option>
                <?php }
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="service_id">Services Type *</label>
            <select name="service_id" id="service_id" class="form-control select2">
                <option value="" selected="selected">--- select service fee ---</option>
                <?php
                if (isset($services_type) && is_array($services_type)) {
                    foreach ($services_type as $type) { ?>
                        <option value="<?php echo $type->id ?>">Service Fee[<?php echo $type->serviceFeeAmount ?>] VAT (<?php echo $type->serviceFeeTax ?>%)</option>
                <?php  }
                } ?>
            </select>
        </div>
        <p>
            <button type="submit" name="rate_submit" id="rate_submit" class="form_submit btn btn-primary" data-loading-text="Processing">Save Sales Ledger</button>
        </p>
        </form>
    </div>

</main>
<script>
    $(document).ready(function() {
        $('select').select2();
    });
</script>
<style>
    .setting-btn {
        float: right;
        margin-top: 5px;
        margin-right: 5px;
    }

    .setting-lead {
        margin-left: 10px;
        margin-bottom: 10px;
        margin-top: 10px;
    }

    .setting-card-body {
        padding: 1px;
    }
</style>