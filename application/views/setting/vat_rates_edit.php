<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<h1 style="margin:70px 0px 20px 35px">VAT(%) Ledgers</h1>
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
                <p class="lead text-white setting-lead">Overview</p>
            </div>
        </div>
        <div class="table-responsive project-stats">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>VAT (%)</th>
                        <th class="w60"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($vat_rates) {
                        foreach ($vat_rates as $l) { ?>
                            <tr>
                                <td><a href="<?php echo base_url('setting/'.$accounting.'/vat/'.$l->id); ?>">[<?php echo $l->rate_code ; ?>] <?php echo $l->rate_desc; ?></a></td>
                                <td class="w80 text-right"><a href="<?php echo base_url('setting/'.$accounting.'/vat/'.$l->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> <a href="<?php echo base_url('setting/'.$accounting.'/vat_delete/'.$l->id); ?>" class="btn btn-default btn-xs delete"><i class="fa fa-trash"></i></a></button></td>
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
                <a href="<?php echo base_url('setting/'.$accounting.'/vat'); ?>" type="button" class="btn btn-success setting-btn" data-card-widget="collapse" data-toggle="tooltip" title="Add">Add</a>
                <p class="lead text-white setting-lead">Setting</p>
            </div>
        </div>
        <?php #print_r($rate); exit;
        ?>
        <?php echo form_open('setting/'.$accounting.'_vatrate/update') . "\r\n"; ?>
        <input type="hidden" name="id" value="<?php echo $rate->id; ?>">
        <div class="form-group">
            <label for="rate_desc">VAT group *</label>
            <input type="text" name="rate_desc" id="rate_desc" class="form-control" data-parsley-trigger="change keyup" required value="<?php echo $rate->rate_desc; ?>">
        </div>
        <!-- <div class="form-group">
                <label for="rate_code">Code [VH, VL, VN] *</label>
                <input type="text" name="rate_code" id="rate_code" class="form-control w60" data-parsley-trigger="change keyup" data-parsley-pattern="^[a-zA-Z]+$" required value="<?php echo $rate->rate_code; ?>">
            </div> -->
        <div class="form-group">
            <label for="rate_perc">Percentage(%) *</label>
            <input type="text" name="rate_perc" id="rate_perc" class="form-control w60" data-parsley-trigger="change keyup" required value="<?php echo $rate->rate_perc; ?>">
        </div>
        <div class="form-group">
            <label for="vat_external_code">VAT% Ledgers</label>
            <select name="vat_external_code" id="vat_external_code" class="form-control">
                <option value="" selected="selected">--- select VAT account ---</option>
                <?php
                if (isset($vats) && is_array($vats)) {
                    foreach ($vats as $vat) {
                        $parts = explode("|", $vat);
                        if(count($parts)==3){
                            $value = trim($parts[0]).'_'.trim($parts[2]);
                        }else{
                            $value = trim($parts[0]);
                        }
                        $sel = ($rate->vat_external_code == trim($parts[0]) ? 'selected' : '');
                ?>
                        <option value="<?php echo $value ?>" <?php echo $sel ?>><?php echo $parts[1] ?></option>
                <?php  }
                } ?>
            </select>
        </div>
        <p>
            <button type="submit" name="rate_submit" id="rate_submit" class="form_submit btn btn-primary" data-loading-text="Processing">Save Tax Group</button>
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