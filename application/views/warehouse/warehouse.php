<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="row" style="margin:70px 0px 20px 0px">
    <div>
        <?php
            if (isset($reports)) {
                $keys = array_keys($reports);
            ?>
                <ul class="nav nav-tabs">
                    <?php foreach ($keys as $key) { ?>
                        <li <?php if ($key === 'orders') echo 'class="active"'?> >
                            <a data-toggle="tab" href="#<?php echo $key ?>"><?php echo ucfirst($key); ?></a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <?php foreach ($reports as $key => $values) { ?>
                    <div id="<?php echo $key; ?>" class="tab-pane <?php if ($key === 'orders') echo 'active'?>" style="background-color: #FFF; text-align:left">
                        <?php
                            if ($key === 'orders') {
                                include_once FCPATH . 'application/views/warehouse/includes/ordersReportes.php';
                            } elseif ($key === 'categories') {
                                include_once FCPATH . 'application/views/warehouse/includes/categoriesReportes.php';
                            } elseif ($key === 'spots') {
                                include_once FCPATH . 'application/views/warehouse/includes/spotsReportes.php';
                            } elseif ($key === 'buyers') {
                                include_once FCPATH . 'application/views/warehouse/includes/buyersReportes.php';
                            } elseif ($key === 'products') {
                                include_once FCPATH . 'application/views/warehouse/includes/productsReportes.php';
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