<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<main>
    <input type="text" id="orderId" name="orderId" autofocus />
</main>
<script>
    var scannerGlobals = (function(){
        let globals = {
            'order' : document.getElementById('orderId')
        }

        Object.freeze(globals);

        return globals;
    }());
</script>
