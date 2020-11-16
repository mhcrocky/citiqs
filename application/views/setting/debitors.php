<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<h1 style="margin:70px 0px 20px 35px">Payment Ledgers</h1>
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
                        <th>Payment Ledgers</th>
                        <th class="w60"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($debitors) {
                        foreach ($debitors as $l) { ?>
                            <tr>
                                <td><a href="<?php echo base_url('setting/'.$accounting.'/debitors/'.$l->id); ?>">[<?php echo $l->external_code; ?>] <?php echo $payment_types[$l->payment_type]; ?></a></td>
                                <td class="w80 text-right"><a href="<?php echo base_url('setting/'.$accounting.'/debitors/'.$l->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> <a href="<?php echo base_url('setting/'.$accounting.'/debit_delete/'.$l->id); ?>" class="btn btn-default btn-xs delete"><i class="fa fa-trash"></i></a></button></td>
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
                <a href="<?php echo base_url('setting/'.$accounting.'/debitors'); ?>" type="button" class="btn btn-success setting-btn" data-card-widget="collapse" data-toggle="tooltip" title="Setting">Add</a>
                <p class="lead text-white setting-lead">Setting</p>
            </div>
        </div>
        <?php echo form_open('setting/'.$accounting.'_debitor/save') . "\r\n"; ?>
        <!-- <div class="form-group">
                <label for="debitor">Debitor *</label>
                <input type="text" name="debitor" id="debitor" class="form-control" data-parsley-trigger="change keyup" required value="<?php echo $this->session->flashdata('rate_desc'); ?>">
            </div> -->
        <div class="form-group">
            <label for="external_id" class="control-label">Payment Ledger *</label>
            <select name="external_id" id="external_id" class="form-control select2" required>
                <option value="" selected="selected">--- select payment ledger ---</option>
                <?php
                if (isset($external_debitors) && is_array($external_debitors)) {
                    foreach ($external_debitors as $debtor) {
                        $parts = explode("|", $debtor);
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
            <label for="payment_type">Payment Type *</label>
            <select name="payment_type" id="payment_type" class="form-control select2">
                <option value="" selected="selected">--- select payment type ---</option>
                <?php
                if (isset($payment_types) && is_array($payment_types)) {
                    foreach ($payment_types as $key => $type) { ?>
                        <option value="<?php echo $key ?>"><?php echo $type ?></option>
                <?php  }
                } ?>
            </select>
        </div>
        <p>
            <button type="submit" name="rate_submit" id="rate_submit" class="form_submit btn btn-primary" data-loading-text="Processing">Save Payment Ledger</button>
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