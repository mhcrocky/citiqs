<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="row" style="margin:70px 0px 20px 0px">
        <div class="col-sm-12" style="margin:20px 0px;">
            <form method="post" action="<?php echo base_url() ?>warehouse">
                <div class="float-right text-center pl-3">
                    <div class="form-group">
                        <input
                            style="width: 330px;"
                            class="date form-control-sm mb-2"
                            type="text"
                            name="datetimes"
                            id="timePeriod"
                        />
                    </div>
                    <div class="col-lg-1 offset-lg-9 col-sm-12">
                        <input type="submit" value="Filter" class="btn btn-primary" />
                    </div>
                </div>
            </form>             
        </div>
        <div class="w-100 p-3">
        <?php
            if (isset($reports)) {
                $keys = array_keys($reports);
            ?>
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($keys as $key) { ?>
                        <li class="nav-item">
                            <a
                                class="nav-link <?php if ($key === 'orders') echo 'active'; ?>"
                                data-toggle="tab"
                                href="#<?php echo $key ?>"><?php echo ucfirst($key); ?></a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <?php foreach ($reports as $key => $values) { ?>
                    <div id="<?php echo $key; ?>" class="tab-pane <?php if ($key === 'orders') echo 'active'?>" style="text-align:left">
                   
                        <?php
                            if ($key === 'orders') {
                                include_once FCPATH . 'application/views/warehouse/includes/reports/ordersReportes.php';
                            } elseif ($key === 'categories') {
                                include_once FCPATH . 'application/views/warehouse/includes/reports/categoriesReportes.php';
                            } elseif ($key === 'spots') {
                                include_once FCPATH . 'application/views/warehouse/includes/reports/spotsReportes.php';
                            } elseif ($key === 'buyers') {
                                include_once FCPATH . 'application/views/warehouse/includes/reports/buyersReportes.php';
                            } elseif ($key === 'products') {
                                include_once FCPATH . 'application/views/warehouse/includes/reports/productsReportes.php';
                            }
                        ?>

                    </div>
                    <?php } ?>
                </div>
            <?php
            }
        ?>
    </div>
</main>
<script>
    const warehouseGlobals = (function(){
        let globals = {
            'from' : '<?php echo $from; ?>',
            'to' : '<?php echo $to; ?>'
        }
        Object.freeze(globals);
        return globals;
    })();
</script>