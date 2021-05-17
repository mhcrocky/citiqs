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
        let message = 'change' + document.getElementById('order').value;
        console.dir(message);
    });

    document.getElementById('order').addEventListener('input', function(){
        let message = 'input' + document.getElementById('order').value;
        console.dir(message);
    });
    
    var input = document.getElementById("order");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();

            alert(document.getElementById('order').value);
        }
    });
</script>
