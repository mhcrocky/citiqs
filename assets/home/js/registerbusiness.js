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

function checkIfsUserExists(element) {
	let email = element.value;

    if (!email) {
		alertifyErrMessage(element)
	};
    if (email.includes('@')) {
        let emailParts = email.split('@');
        if (!emailParts[1].includes('.')) return;
        let post = {
            'email' : email
        }
        let url = globalVariables.ajax + 'checkIfVendorExists';
        sendAjaxPostRequest(post, url, 'checkIfsUserExists', alertUserExists);
    }
}

function alertUserExists(response)  {
	if (parseInt(response) === 1) {
		alertify.error('User with this email already exists. Reset your password or check your email to activate account');
	}
}
function registerNewBusiness(formId, passwordId, repeatPasswordId) {
    let password = document.getElementById(passwordId).value.trim();
    let repeatPassword = document.getElementById(repeatPasswordId).value.trim();

    if (!password) {
        alertify.error('Password is required');
        return false;
    }
    if (!repeatPassword) {
        alertify.error('Repeat password is required');
        return false;
    }
    if (password !== repeatPassword) {
        alertify.error('Password and repeat password do not match');
        return false;
    }

	let form = document.getElementById(formId);

    if (validateFormData(form)) {
        form.submit();
    } else {
        return false;
    }
}
