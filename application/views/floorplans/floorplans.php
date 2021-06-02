<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<main class="row" style="margin:0px 20px">
    <?php if (is_null($floorplans)) { ?>
        <p>No floorplans for your object. <a href="<?php echo $this->baseUrl; ?>add_floorplan">Add</a></p>
    <?php } ?>

</main>
