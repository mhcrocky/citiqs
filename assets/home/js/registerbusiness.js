var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
	acc[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.maxHeight) {
			panel.style.maxHeight = null;
			panel.style.border = 'none';
		} else {
			panel.style.maxHeight = panel.scrollHeight + "px";
			/* panel.style.border = '1px solid #ffffff4a';
				panel.style.borderTop = 'none';
				panel.borderTopLeftRadius = 0 + 'px';
				panel.borderTopRightRadius = 0 + 'px';*/
		}
	});
}
function capenable() {
	document.getElementById("capsubmit").style.display = "block";
}

function capdisable() {
	document.getElementById("capsubmit").style.display = "none";
}

function playThisVideo(element) {
	removeShowFromElements('videos')
	let videoDiv = element.parentElement.previousElementSibling;
	let video = videoDiv.firstElementChild.firstElementChild;
	$(videoDiv).toggleClass('show');
	if (videoDiv.classList.contains('show')) {
		video.src += "?autoplay=1";
	} else {
		video.src += "?autoplay";
	}
}

function removeShowFromElements(collection) {
	let elements = document.getElementsByClassName(collection);
	let i;
	let elementsLength = elements.length;
	for (i = 0; i < elementsLength; i++) {
		elements[i].classList.remove('show');
	}
}