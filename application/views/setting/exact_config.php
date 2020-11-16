<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<h1 style="margin:70px 0px 20px 35px">Exact Configuration</h1>
<main class="row" style="margin:0px 20px">
    <!-- <div class="col-sm-12" style="margin:20px 0px;"> -->
        <div class="col-md-6 col-sm-12">
            <form method="post" action="<?php echo base_url() ?>config_exact/app_settings">
                <div class="card" style="background-color:#138575">
                    <div class="card-body pb-0">
                        <p class="lead text-white">Store exact setting</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exact_division" class="col-sm-3 control-label">Administration</label>
                    <div class="col-sm-9">
                        <select name="exact_division" id="exact_division" class="form-control">
                        <option value="">--- select Exact Administration ---</option>
                        <?php
                        if ($divisions) {
                        foreach($divisions as $division) {
                            $parts = explode("|", $division);
                            if ($setting->exact_division == $parts[1]) {$sel = 'selected';} else {$sel = '';}
                            ?>
                            <option value="<?php echo $parts[1] ?>" <?php echo $sel ?>><?php echo $parts[0] ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exact_year" class="col-sm-3 control-label">Accounting Year</label>
                    <div class="col-sm-9">
                        <select name="exact_year" id="exact_year" class="form-control">
                            <option value="">--- select Accounting year ---</option>
                            <?php
                            if (isset($years) && is_array($years)) {
                                foreach ($years as $year) {
                                    $parts = explode("|", $year);
                                    $sel = ($setting->exact_year == $parts[0] ? 'selected' : '');
                                ?>
                                <option value="<?php echo $parts[0] ?>" <?php echo $sel ?>><?php echo $parts[1] ?> - <?php echo $parts[2] ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exact_journal" class="col-sm-3 control-label">Exact Journal</label>
                    <div class="col-sm-9">
                        <select name="exact_journal" id="exact_journal" class="form-control">
                        <?php
                        if ($journals) {
                        foreach($journals as $journal) {
                            $parts = explode("|", $journal);
                            if ($setting->exact_journal == $parts[0]) {$sel = 'selected';} else {$sel = '';}
                        ?>
                            <option value="<?php echo $parts[0] ?>" <?php echo $sel ?>><?php echo $parts[1] ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" name="default_exact" id="default_exact" class="default_exact btn btn-primary btn-sm" >Save settings</button>
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
                <a href="<?php echo base_url(); ?>setting/exact/vat">VAT ledger links</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <a href="<?php echo base_url(); ?>setting/exact/debitors">Payments ledger links</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <a href="<?php echo base_url(); ?>setting/exact/creditors">Sales ledger links</a>
                </div>
            </div>
        </div>
    <!-- </div> -->
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