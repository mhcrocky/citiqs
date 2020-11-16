<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<h1 style="margin:70px 0px 20px 35px;">Sales ledger</h1>
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
                        <th>Ledger</th>
                        <th class="w60"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($creditors) {
                        foreach ($creditors as $l) {
                            foreach ($categories as $cat) {
                                if ($cat->id == $l->product_category_id) {
                                    $category  = $cat->category;
                                }
                            }
                            foreach ($products as $pro) {
                                if ($pro->id == $l->product_id) {
                                    $category  = '['.$category.']'.' '.$pro->name;
                                }
                            }
                    ?>
                            <tr>
                                <td><a href="<?php echo base_url('setting/'.$accounting.'/creditors/'.$l->id); ?>">[<?php echo $l->external_id ?>] <?php echo $category ?></a></td>
                                <td class="w80 text-right"><a href="<?php echo base_url('setting/'.$accounting.'/creditors/'.$l->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> <a href="<?php echo base_url('setting/'.$accounting.'/credit_delete/'.$l->id); ?>" class="btn btn-default btn-xs delete"><i class="fa fa-trash"></i></a></button></td>
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
                <a href="<?php echo base_url('setting/'.$accounting.'/creditors'); ?>" type="button" class="btn btn-success setting-btn" data-card-widget="collapse" data-toggle="tooltip" title="Add">Add</a>
                <p class="lead  text-white setting-lead">Setting</p>
            </div>
        </div>
        <?php echo form_open('setting/'.$accounting.'_credit/update') . "\r\n"; ?>
        <input type="hidden" name="id" value="<?php echo $creditor_data->id; ?>">
        <div class="form-group">
            <label for="external_id" class="control-label">Sale ledger *</label>
            <select name="external_id" id="external_id" class="form-control" required>
                <option value="" selected="selected">--- select sale ledger account ---</option>
                <?php
                if (isset($external_creditors) && is_array($external_creditors)) {
                    foreach ($external_creditors as $credit) {
                        $parts = explode("|", $credit);
                        $sel = ($creditor_data->external_id == trim($parts[0]) ? 'selected' : '');
                ?>
                        <option value="<?php echo $parts[0] ?>" <?php echo $sel ?>><?php echo $parts[1] ?></option>
                <?php }
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="product_category_id">Product category *</label>
            <select name="product_category_id" id="product_category_id" class="form-control">
                <option value="" selected="selected">--- select product category ---</option>
                <?php
                if (isset($categories) && is_array($categories)) {
                    foreach ($categories as $cat) {
                        $sel = ($creditor_data->product_category_id == $cat->id ? 'selected' : ''); ?>
                        <option value="<?php echo $cat->id ?>" <?php echo $sel ?>><?php echo $cat->category ?></option>
                <?php  }
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control">
                <option value="" selected="selected">--- select product ---</option>
                <?php
                if (isset($products) && is_array($products)) {
                    foreach ($products as $product) {
                        $sel = ($creditor_data->product_id == $product->id ? 'selected' : ''); ?>
                        <option value="<?php echo $product->id ?>" <?php echo $sel ?>><?php echo $product->name ?> [<?php echo $product->price ?>]</option>
                <?php  }
                } ?>
            </select>
        </div>
        <p>
            <button type="submit" name="rate_submit" id="rate_submit" class="form_submit btn btn-primary" data-loading-text="Processing">Save Sale Ledger</button>
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