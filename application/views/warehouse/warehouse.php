<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    $keys = array_keys($reports);
?>

<main class="row" style="margin:70px 0px 20px 0px">
    <div class="container">
        <ul class="nav nav-tabs">
            <?php foreach ($keys as $key) { ?>
                <li <?php if ($key === 'orders') echo 'class="active"'?> >
                    <a data-toggle="tab" href="#<?php echo $key ?>"><?php echo $key ?></a>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php foreach ($reports as $key => $value) { ?>
            <div id="<?php echo $key; ?>" class="tab-pane <?php if ($key === 'orders') echo 'active'?>">
                <?php var_dump($value); ?>
            </div>
            <?php } ?>
        </div>
    </div>
</main>