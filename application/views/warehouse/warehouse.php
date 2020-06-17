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
                            <a data-toggle="tab" href="#<?php echo $key ?>"><?php echo $key ?></a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <?php foreach ($reports as $key => $values) { ?>
                    <div id="<?php echo $key; ?>" class="tab-pane <?php if ($key === 'orders') echo 'active'?>" style="background-color: #FFF; text-align:left">
                        <?php
                            if ($key === 'orders') {
                                include_once FCPATH . 'application/views/warehouse/includes/orderReportes.php';
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