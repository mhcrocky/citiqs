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
    <input type="text" id="order" name="order" autofocus />
</main>

<script>
    document.getElementById('order').addEventListener('change', function(){
        console.dir('change');
    });

    document.getElementById('order').addEventListener('input', function(){
        console.dir('input');
    });

</script>
