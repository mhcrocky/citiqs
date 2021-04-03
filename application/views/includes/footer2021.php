<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
	<script>
	
		// quantity input
		var quantity_section = $('.quantity-section');
		var quantity_button_plus = $('.quantity-button--plus');
		var quantity_button_minus = $('.quantity-button--minus');
		var quantity_input = $('.quantity-input');
		
		quantity_button_plus.click(function(){
			let num = $(this).siblings('.quantity-input').val();
			num++;
			$(this).siblings('.quantity-input').val(num)
			console.log($(this).siblings('.quantity-input').val())
		})
		
		quantity_button_minus.click(function(){
			let num = $(this).siblings('.quantity-input').val();
			if(num >= 1){
				num--;
				$(this).siblings('.quantity-input').val(num)
				console.log($(this).siblings('.quantity-input').val())
			}
		})
		
	</script>
  </body>
</html>