<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<style>
    header, footer {
        display: none;
    }
</style>

<main>
    <input type="text" id="order" name="order" autofocus oninput="alertInput(this.value)" />
</main>
<script>
    function alertInput(orderId) {
        alert(orderId);
    }
</script>
