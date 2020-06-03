/* CUSTOMIZE GRID */

	"use strict";

	// var lightboxLink = document.getElementsByClassName('lightbox-open');
	// var lightboxModal = document.getElementById('lightbox-modal');
	// var lightboxImage = document.getElementById('lightbox-image');
	// var span = document.getElementById("close-lightbox");
	// var lightboxImageURL;
	//
	// for(let i = 0; i < lightboxLink.length; i++){
	// 	lightboxLink[i].addEventListener('click', lightBoxModal)
	// }
	//
	// function lightBoxModal(){
	// 	lightboxImageURL = this.getAttribute("src");
	// 	lightboxImage.setAttribute('src', lightboxImageURL);
	// 	lightboxModal.classList.add('active-modal');
	// }
	//
	// span.onclick = function() {
	// 	lightboxModal.classList.remove('active-modal');
	// }
	//
	// window.onclick = function(event) {
	// 	if (event.target == lightboxModal) {
	// 		lightboxModal.classList.remove('active-modal');
	// 	}
	// };

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
