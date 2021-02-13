<button id='iframe-popup-open'>open popup</button>

<!-- start popup -->
<div class="iframe-popup hide" id='iframe-popup'>
	<div class='iframe-popup__close' id='popup-close'></div>
	<div class="iframe-popup__content">
		<iframe src="<?php echo $iframeSrc; ?>" frameborder="0"  style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" id='iframe-wrapper'></iframe>
	</div>
</div>
<!-- end popup -->