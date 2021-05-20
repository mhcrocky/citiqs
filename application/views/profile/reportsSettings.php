<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main class="container">
    <p>
        Send
        <label>
            <input type="checkbox" value="1" id ="<?php echo $xReport; ?>" /><?php echo ucfirst(str_replace('_', ' ', $xReport));?>
        </label>
        and / or
        <label>
            <input type="checkbox" value="1" id ="<?php echo $zReport; ?>" /><?php echo ucfirst(str_replace('_', ' ', $zReport));?>
        </label>
</main>