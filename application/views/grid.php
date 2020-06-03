<!DOCTYPE html>
<html><head>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="">
    <meta charset="UTF-8">
    <title>tiqs | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/home/styles/main-style.css">
    <link rel="stylesheet" href="../../assets/home/styles/how-it-works.css">
    <link rel="stylesheet" href="../../assets/home/styles/home-page.css">
    <link rel="stylesheet" href="../../assets/home/styles/grid.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script> 
    
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    
	<link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!--    
    <link href="../../assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    -->
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body>

<div class="main-wrapper theme-editor-wrapper">

<script src="../../assets/home/js/vanilla-picker.js"></script>

	<div class="theme-editor">
		<div class="theme-editor-header d-flex justify-content-between">
			<div>
				<img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">
			</div>
			<div class='theme-editor-header-buttons'>
				<button class='grid-button button theme-editor-header-button'>Submit</button>
				<button class='grid-button-cancel button theme-editor-header-button'>Cancel</button>
			</div>
		</div>
		<div class="theme-editor-content">
			<div class="theme-editor-item">
				<p>Background Color:</p>
				<div class='color-picker'>
					<a href="#" id="background-color" class="popup-parent"></a>
				</div><!-- end color picker -->
			</div><!-- end editor item -->

			<div class="theme-editor-item">
				<p>Border Color:</p>
				<div class='color-picker'>
					<a href="#" id="border-color" class="popup-parent"></a>
				</div><!-- end color picker -->
			</div><!-- end editor item -->

			<div class="theme-editor-item">
				<p>Button Background Color:</p>
				<div class='color-picker'>
					<a href="#" id="button-bgColor" class="popup-parent"></a>
				</div><!-- end color picker -->
			</div><!-- end editor item -->
			
			<div class="theme-editor-item">
				<p>Button text Color:</p>
				<div class='color-picker'>
					<a href="#" id="button-text-color" class="popup-parent"></a>
				</div><!-- end color picker -->
			</div><!-- end editor item -->

			<div class="theme-editor-item">
				<p>Text Color:</p>
				<div class='color-picker'>
					<a href="#" id="text-color" class="popup-parent"></a>
				</div><!-- end color picker -->
			</div><!-- end editor item -->

			<div class="theme-editor-item">
				<p>Grid Item Background:</p>
				<div class='color-picker'>
					<a href="#" id="grid-item-background" class="popup-parent"></a>
				</div><!-- end color picker -->
			</div><!-- end editor item -->

			<div class="theme-editor-item">
				<p>Button Border Radius:</p>
				<div class='number-picker'>
					<input type="tel" id='button-radius'>
				</div><!-- end color picker -->
			</div><!-- end editor item -->

			<div class="theme-editor-item">
				<p>Grid Item Border Radius:</p>
				<div class='number-picker'>
					<input type="tel" id='grid-item-radius'>
				</div><!-- end color picker -->
			</div><!-- end editor item -->

			<div class="theme-editor-item">
				<p>Text Size:</p>
				<div class='number-picker'>
					<input type="tel" id='text-size' maxlength="2">
				</div><!-- end color picker -->
			</div><!-- end editor item -->
			
			<div class="theme-editor-item">
				<label class="custom-checkbox" id='show-search-bar'>
  					<input type="checkbox" checked="checked"><span class="checkmark"></span>Show Search Bar
				</label>
			</div><!-- end editor item -->
			
			
		</div>
		<div class='theme-editor-footer'>
			<div>
				<h3 onclick='copyToClipboard()'>Iframe Settings<small>Copy to clipboard</small></h3>
				<textarea name="" id="iframe-placeholder" placeholder='<script src="https://tiqs.com/js/iframeResizer.min.js"></script><iframe src="https://tiqs.com/location/xxxxx" width="100%" scrolling="yes" frameborder="0"></iframe><script>iFrameResize({autoResize:true, sizeHeight:true}</script>' disabled value='<script src="https://tiqs.com/js/iframeResizer.min.js"></script><iframe src="https://tiqs.com/location/xxxxx" width="100%" scrolling="yes" frameborder="0"></iframe><script>iFrameResize({autoResize:true, sizeHeight:true}</script>'></textarea>
			</div>
			<div>
				<input type="text" value='' id='iframe-settings' style='display:none'>
				<button class='grid-button button edit-buttons-hide-desktop'>Submit</button>
				<button class='grid-button-cancel button edit-buttons-hide-desktop'>Cancel</button>
				<input type="hidden" value='Iframe Settings' id='footer-text' >
			</div>
			
			
		</div>
		
	</div><!-- end theme editor -->

	<div class="grid-wrapper">
		<div class="grid-list">
			
			<div class="grid-list-header row">
				<div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
					<h2>Filter Options</h2>
					<button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit" id='button-theme-editor'>Customize grid</button>
				</div><!-- end col 4 -->
				<div class="col-lg-4 col-md-4 col-sm-12 date-picker-column">				
					<div>
						From:
						<div class='date-picker-content'>
							<input type="text" placeholder="Select Date.." data-input class="flatpickr"> <!-- input is mandatory -->
							<!--<a class="input-button" title="toggle" data-toggle>
								<i class="far fa-calendar-alt"></i>
							</a>
							<a class="input-button" title="clear" data-clear>
								<i class="far fa-window-close"></i>
							</a>-->
						</div>	
					</div>
					<div>
						To:
						<div class='date-picker-content'>
							<input type="text" placeholder="Select Date.." data-input class="flatpickr-to"> <!-- input is mandatory -->
							<!--<a class="input-button" title="toggle" data-toggle>
								<i class="far fa-calendar-alt"></i>
							</a>
							<a class="input-button" title="clear" data-clear>
								<i class="far fa-window-close"></i>
							</a>-->
						</div>
					</div>
				</div><!-- end date picker -->

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					Search by name:
					<form class="form-inline">
					    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					    <button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit">Search</button>
    				</form>
				</div>	
			</div><!-- end grid header -->
			
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">2019-10-01 09:41:01</p>
					<p class="item-code">G-S5DPRArG</p>
					<div class="grid-image">
						<form id="addUser_316" class="file_form" action="<?php echo base_url(); ?>userLabelImageCreate" method="post" role="form" enctype="multipart/form-data">
						    <img src="<?php echo base_url(); ?>uploads/LabelImages/1-G-S5DPRArG-1576063192.jpg">
						    <label for="file-upload" class="custom-file-upload btn btn-primary">
    					   	    Click Here to upload an image
						    </label>
						    <input type="file" id="file-upload" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'/ >	   
							<!--<input type="file" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'>-->
							<input type="hidden" value="316" name="id" id="id">
							<button type="submit" name="labelimage" value="Submit" class='btn btn-success iconWrapper'>
							<span class="fa-stack fa-2x">
								<i class="fas fa-check"></i>
							</span>
							</button>
						</form>
					</div>
					<p class="item-description">Just for testing</p>
					<p class="item-category">The passport</p>
				</div>
				<div class="grid-footer">
					<!-- <a class="btn btn-sm btn-info btn-edit-item" href="javascript:void(0)" title="Edit">Edit</a>-->
					<!--<a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="316" title="Delete">delete</a>-->
					<div class='iconWrapper'>
						<span class="fa-stack fa-2x edit-icon btn-edit-item">					    
						    <i class="far fa-edit"></i>
						</span>
					</div>
					<div class='iconWrapper delete-icon-wrapper'>
						<span class="fa-stack fa-2x delete-icon">
						    <i class="fas fa-times"></i>
						</span>
					</div>
					<div class='iconWrapper'>
						<span class="fa-stack fa-2x print-icon">
						     <i class="fas fa-print"></i>
						</span>
					</div>
					<!--<a class="btn btn-sm btn-info print" href="#" data-userid="316" title="Print">Print</a>-->
				</div>
				<div class="item-editor theme-editor">
					<div class="theme-editor-header d-flex justify-content-between">
						<div>
							<img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">
						</div>
						<div class="theme-editor-header-buttons">
							<button class="grid-button button theme-editor-header-button">Submit</button>
							<button class="grid-button-cancel button theme-editor-header-button">Cancel</button>
						</div>
					</div>
					<div class="edit-signle-item-container">
						<h3>Item Heading</h3>
						<form action="" class='form-inline'>
						<div>
							<label for="category">Category</label>
							<select name="category" id="" class='form-control'>
								<option value="">lorem ipsum</option>
								<option value="">lorem ipsum</option>
								<option value="">lorem ipsum</option>
								<option value="">lorem ipsum</option>
							</select>
						</div>
						<div>
							<label for="description">Description</label>
							<input type="text" class='form-control'>
						</div>
					</form>
					</div>
				</div>
			</div><!-- end grid item -->
			
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">2019-10-01 09:41:01</p>
					<p class="item-code">G-S5DPRArG</p>
					<div class="grid-image">
						<form id="addUser_316" class="file_form" action="<?php echo base_url(); ?>userLabelImageCreate" method="post" role="form" enctype="multipart/form-data">
						    <img src="<?php echo base_url(); ?>uploads/LabelImages/1-G-S5DPRArG-1576063192.jpg">
						    <label for="file-upload" class="custom-file-upload btn btn-primary">
    					   	    Click Here to upload an image
						    </label>
						    <input type="file" id="file-upload" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'/ >	   
							<!--<input type="file" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'>-->
							<input type="hidden" value="316" name="id" id="id">
							<button type="submit" name="labelimage" value="Submit" class='btn btn-success'>Submit</button>
						</form>
					</div>
					<p class="item-description">Just for testing</p>
					<p class="item-category">The passport</p>
				</div>
				<div class="grid-footer">
					<a class="btn btn-sm btn-info btn-edit-item" href="javascript:void(0)" title="Edit">Edit</a>
					<a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="316" title="Delete">delete</a>
					<a class="btn btn-sm btn-info print" href="#" data-userid="316" title="Print">Print</a>
				</div>
				<div class="item-editor theme-editor">
					<div class="theme-editor-header d-flex justify-content-between">
						<div>
							<img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">
						</div>
						<div class="theme-editor-header-buttons">
							<button class="grid-button button theme-editor-header-button">Submit</button>
							<button class="grid-button-cancel button theme-editor-header-button">Cancel</button>
						</div>
					</div>
					<div class="edit-signle-item-container">
						<h3>Item Heading</h3>
						<form action="" class='form-inline'>
						<div>
							<label for="category">Category</label>
							<select name="category" id="" class='form-control'>
								<option value="">lorem ipsum</option>
								<option value="">lorem ipsum</option>
								<option value="">lorem ipsum</option>
								<option value="">lorem ipsum</option>
							</select>
						</div>
						<div>
							<label for="description">Description</label>
							<input type="text" class='form-control'>
						</div>
					</form>
					</div>
				</div>
			</div><!-- end grid item -->
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">2019-10-01 09:41:01</p>
					<p class="item-code">G-S5DPRArG</p>
					<div class="grid-image">
						<form id="addUser_316" class="file_form" action="<?php echo base_url(); ?>userLabelImageCreate" method="post" role="form" enctype="multipart/form-data">
						    <img src="<?php echo base_url(); ?>uploads/LabelImages/1-G-S5DPRArG-1576063192.jpg">
						    <label for="file-upload" class="custom-file-upload btn btn-primary">
    					   	    Click Here to upload an image
						    </label>
						    <input type="file" id="file-upload" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'/ >	   
							<!--<input type="file" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'>-->
							<input type="hidden" value="316" name="id" id="id">
							<button type="submit" name="labelimage" value="Submit" class='btn btn-success'>Submit</button>
						</form>
					</div>
					<p class="item-description">Just for testing</p>
					<p class="item-category">The passport</p>
				</div>
				<div class="grid-footer">
					<a class="btn btn-sm btn-info btn-edit-item" href="<?php echo base_url(); ?>editOldlabel/316" title="Edit">Edit</a>
					<a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="316" title="Delete">delete</a>
					<a class="btn btn-sm btn-info print" href="#" data-userid="316" title="Print">Print</a>

				</div>
			</div>
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">06.12.2019.</p>
					<p class="item-code">#######</p>
					<div class='grid-image'>
					<img src="../../assets/home/images/slide2.jpg" alt=""  class='lightbox-open'>
					</div>
					<p class='item-description'>Item Description</p>
					<p class='item-category'>Item Category</p>
				</div>
				<div class="grid-footer">				
					<button class='grid-button button'>Claim</button>
				</div>
			</div><!-- end grid item -->
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">06.12.2019.</p>
					<p class="item-code">#######</p>
					<div class='grid-image'>
					<img src="../../assets/home/images/slide2.jpg" alt=""  class='lightbox-open'>
					</div>
					<p class='item-description'>Item Description</p>
					<p class='item-category'>Item Category</p>
				</div>
				<div class="grid-footer">				
					<button class='grid-button button'>Claim</button>
				</div>
			</div><!-- end grid item -->
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">06.12.2019.</p>
					<p class="item-code">#######</p>
					<div class='grid-image'>
					<img src="../../assets/home/images/slide2.jpg" alt=""  class='lightbox-open'>
					</div>
					<p class='item-description'>Item Description</p>
					<p class='item-category'>Item Category</p>
				</div>
				<div class="grid-footer">				
					<button class='grid-button button'>Claim</button>
				</div>
			</div><!-- end grid item -->
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">06.12.2019.</p>
					<p class="item-code">#######</p>
					<div class='grid-image'>
					<img src="../../assets/home/images/slide2.jpg" alt=""  class='lightbox-open'>
					</div>
					<p class='item-description'>Item Description</p>
					<p class='item-category'>Item Category</p>
				</div>
				<div class="grid-footer">				
					<button class='grid-button button'>Claim</button>
				</div>
			</div><!-- end grid item -->
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">06.12.2019.</p>
					<p class="item-code">#######</p>
					<div class='grid-image'>
					<img src="../../assets/home/images/slide2.jpg" alt=""  class='lightbox-open'>
					</div>
					<p class='item-description'>Item Description</p>
					<p class='item-category'>Item Category</p>
				</div>
				<div class="grid-footer">				
					<button class='grid-button button'>Claim</button>
				</div>
			</div><!-- end grid item -->
			<div class="grid-item">
				<div class="item-header">
					<p class="item-date">06.12.2019.</p>
					<p class="item-code">#######</p>
					<div class='grid-image'>
					<img src="../../assets/home/images/slide2.jpg" alt="" class='lightbox-open'>
					</div>
					<p class='item-description'>Item Description</p>
					<p class='item-category'>Item Category</p>
				</div>
				<div class="grid-footer">				
					<button class='grid-button button'>Claim</button>
				</div>
			</div><!-- end grid item -->
			
		</div><!-- end grid list -->
	</div><!-- end grid wrapper -->
</div><!-- end main wrapper -->


<!-- lightbox for image -->
<div id="lightbox-modal">
	<div class='lightbox-modal-content'>
		<img src="" alt="" id='lightbox-image'>
		<span id="close-lightbox">×</span>
	</div>	
</div>

<script>
	
	"use strict";

	var lightboxLink = document.getElementsByClassName('lightbox-open');
	var lightboxModal = document.getElementById('lightbox-modal');
	var lightboxImage = document.getElementById('lightbox-image');
	var span = document.getElementById("close-lightbox");
	var lightboxImageURL;

	for(let i = 0; i < lightboxLink.length; i++){
		lightboxLink[i].addEventListener('click', lightBoxModal)
	}

	function lightBoxModal(){
		lightboxImageURL = this.getAttribute("src");
		lightboxImage.setAttribute('src', lightboxImageURL);
		lightboxModal.classList.add('active-modal');
	}

	span.onclick = function() {
		lightboxModal.classList.remove('active-modal');
	}

	window.onclick = function(event) {
		if (event.target == lightboxModal) {
			lightboxModal.classList.remove('active-modal');
		}
	};

	/*global Picker*/

	function $(selector, context) {
		return (context || document).querySelector(selector);
	}

	// background color
	var backgroundColor = $('#background-color'),
		popupBasic = new Picker({
			parent: $('#background-color'),
			color:'#fff',
		});
		popupBasic.onChange = function(color) {
		document.documentElement.style.setProperty('--main-bg-color', color.rgbaString);
		backgroundColor.style.setProperty('background-color', color.rgbaString);
	};

	//border color
	var borderColor = $('#border-color'),
		popupBasic = new Picker({
			parent: borderColor,
			color:'#e25f2a',
		});
		popupBasic.onChange = function(color) {
		document.documentElement.style.setProperty('--border-color', color.rgbaString);
	};

	// button background color
	var buttonBgColor = $('#button-bgColor'),
		popupBasic = new Picker({
			parent: buttonBgColor,
			color:'#e25f2a',
		});
		popupBasic.onChange = function(color) {
		document.documentElement.style.setProperty('--button-BgColor', color.rgbaString);
	};

	// button text color
	var buttonTextColor = $('#button-text-color'),
		popupBasic = new Picker({
			parent: buttonTextColor,
			color:'#fff',
		});
		popupBasic.onChange = function(color) {
		document.documentElement.style.setProperty('--button-text-color', color.rgbaString);
	};

	// text color
	var textColor = $('#text-color'),
		popupBasic = new Picker({
			parent: textColor,
			color:'#333333',
		});
		popupBasic.onChange = function(color) {
		document.documentElement.style.setProperty('--text-color', color.rgbaString);
	};
	
	// text color
	var gridItemBackground = $('#grid-item-background'),
		popupBasic = new Picker({
			parent: gridItemBackground,
			color:'#333333',
		});
		popupBasic.onChange = function(color) {
		document.documentElement.style.setProperty('--grid-item-background', color.rgbaString);
	};

	// button radius
	document.getElementById('button-radius').addEventListener('input', function(){
		console.log('test');
		document.documentElement.style.setProperty('--button-radius', document.getElementById('button-radius').value + 'px');
	}) 

	// grid item border radius
	document.getElementById('grid-item-radius').addEventListener('input', function(){
		console.log('test');
		document.documentElement.style.setProperty('--grid-item-radius', document.getElementById('grid-item-radius').value + 'px');
	}) 

	// text size
	document.getElementById('text-size').addEventListener('input', function(){
		console.log('test');
		document.documentElement.style.setProperty('--text-size', document.getElementById('text-size').value + 'px');
	}) 
	
// Copy to clipboard 
	
	function copyToClipboard() {
	  /* Get the text field */
		
	  var copyTextLiteral = document.getElementById('iframe-placeholder').getAttribute('placeholder');
		
	  var copyText = document.getElementById('iframe-settings');
	  copyText.setAttribute('value', copyTextLiteral );
	  /* Select the text field */
	  copyText.select();
	  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

	  /* Copy the text inside the text field */
	  document.execCommand("copy");

	  /* Alert the copied text */
	  alert(copyText.value);
	}

</script>

<script>
	
	// show search bar 
	var showSearchBar = document.getElementById('show-search-bar');
	var checked = true;
	showSearchBar.addEventListener('change', function(){	
		if(checked){
			document.documentElement.style.setProperty('--show-search-bar', 'none');
			checked = false;
			console.log('da')
		}else{
			document.documentElement.style.setProperty('--show-search-bar', 'flex');
			checked = true;
			console.log('ne')
		}
	});
	
	// date picker 
	$(".flatpickr").flatpickr();
	$(".flatpickr-to").flatpickr();

</script>

<script>
	
	var grid_editor = document.getElementsByClassName('theme-editor')[0];
	var grid_button_open_editor = document.getElementById('button-theme-editor');
	var grid_header = document.getElementsByClassName('grid-list-header')[0];
	var grid_edit_item_button = document.querySelectorAll('.btn-edit-item'); 
	var grid_item_editor = document.getElementsByClassName('item-editor')[0];
	
	grid_button_open_editor.addEventListener('click', function(){
		grid_editor.classList.add('display');
	})
	
	document.querySelectorAll('.theme-editor-header-button').forEach(item => {
  		item.addEventListener('click', event => {
			grid_editor.classList.remove('display');
			grid_item_editor.classList.remove('display');
  		})
	})
	
	grid_edit_item_button.forEach(item => {
  		item.addEventListener('click', event => {
			grid_editor.classList.remove('display');
			grid_item_editor.classList.add('display');
  		})
	})

</script>

<style>
	
.flatpickr-calendar{
	font-family: 'caption-light', sans-serif !important;
}
		
.flatpickr-input{
	border: 1px solid #ccc;
	padding: 5px 10px;
	border-radius: var(--button-radius);
	width: 100%;
	font-family: 'caption-light', sans-serif;
}
	
</style>

</body>
</html>
