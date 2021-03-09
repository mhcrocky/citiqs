'use strzct';
// modal script
// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
var btn = document.getElementById("modal-button");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks on the button, open the modal
if (btn) {
    btn.onclick = function() {
        modal.style.display = "block";
    }
}
// When the user clicks on <span> (x), close the modal
if (span) {
	span.onclick = function() {
		modal.style.display = "none";
	}
}
if (modal) {
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

// scroll to DHL section


$("#dhl-button").click(function() {
	$('html,body').animate(
		{scrollTop: $("#dhl-section").offset().top},
		'slow'
	);
});

$("#who-button").click(function() {
	$('html,body').animate(
		{scrollTop: $("#who-section").offset().top},
		'slow'
	);
});

$("#how-button").click(function() {
	$('html,body').animate(
		{scrollTop: $("#how-section").offset().top},
		'slow'
	);
});

$("#packages-button").click(function() {
	$('html,body').animate(
		{scrollTop: $("#packages-section").offset().top},
		'slow'
	);
});

$("#hit-button").click(function() {
    $('html,body').animate(
        {scrollTop: $("#hit-section").offset().top},
        'slow'
    );
});

$('#hamburger-menu').click(function(){
    $('#header-menu').toggleClass('show');
});
