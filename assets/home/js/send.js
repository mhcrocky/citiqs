'use strict';

function returnIdSufixes() {
    return [
        'email', 'emailverify', 'code', 'mobile', 'username', 
        'address', 'addressa', 'zipcode', 'city', 'country', 
        'image', 'imageResponseFullName', 'IsDropOffPoint', 
        'roleId', 'descript', 'categoryid', 'dclw', 'dcll', 'dclh', 'dclwgt'
    ];
}

function toogleIds(ids, display, prefix) {
    let idsLength = ids.length;
    let i;
    let id;
    let element;
    for (i = 0; i < idsLength; i++) {
        if (ids[i] === 'email' || ids[i] === 'emailverify'
            || ids[i] === 'IsDropOffPoint' || ids[i] === 'roleId'
        ) {
            continue;
        }
        id = prefix + ids[i];
        element = globalVariables.doc.getElementById(id);
        if (element) {
            element.style.display = display;
            if (display === 'block') {
                element.disabled = false;
                if (ids[i] !== 'addressa') {
                    element.required = true;
                }
            } else {
                element.disabled = true;
                element.required = false;
            }
        }
    }
}

function checkEmail(element, prefix) {
    if (element.value) {
        let ajax = globalVariables.ajax + 'users/';
        $.get(ajax + encodeURIComponent(element.value), function(data) {
            var result = JSON.parse(data);
            if (result.username) {
                toogleIds(returnIdSufixes(), 'block', prefix);
            } else {
                toogleIds(returnIdSufixes(), 'none', prefix);
            }
        });
    }
}

function checkEmailsAndSubmit(userEmailId, userVerifyEmailId, recipientEmailId, recipientVerifyEmailId, isPrivate = true) {
    let userEmail = globalVariables.doc.getElementById(userEmailId);
    let userVerifyEmail = globalVariables.doc.getElementById(userVerifyEmailId);
    let recipientEmail = globalVariables.doc.getElementById(recipientEmailId);
    let recipientVerifyEmail = globalVariables.doc.getElementById(recipientVerifyEmailId);
    let errors = 0;
    let message = '';

    if (userEmail.value !== userVerifyEmail.value) {
        message += 'Emails don\' match! \n';
        userEmail.style.border = '1px solid #f00';
        userVerifyEmail.style.border = '2px solid #f00';
        errors++
    };
    if (recipientEmail.value !== recipientVerifyEmail.value) {
        message += 'Recipient emails don\' match! \n';
        recipientEmail.style.border = '1px solid #f00';
        recipientVerifyEmail.style.border = '2px solid #f00';
        errors++
    };
    if (errors) {
        alertify.alert(message);
        return false;
    }
    let post = preparePost();
    console.dir(post);
    if (post) {
        let url = globalVariables.ajax + 'sendItem';
        let callBack = 'sendItem';
        if (isPrivate) {
            resetData();
        }
        sendAjaxPostRequest(post, url, callBack);
    }
}

function preparePost() {
    let prefixes = ['sender_', 'recipient_', 'label_'];
    let prefixesLength = prefixes.length;
    let ids = returnIdSufixes();
    let idsLength = ids.length;
    let prefix;
    let id;
    let element;
    let elementId
    let i;
    let j;
    let countErr = 0;
    let post = {
        'sender_': {},
        'recipient_' : {},
        'label_' : {},
    }

    for (i = 0; i < prefixesLength; i++) {
        prefix = prefixes[i];
        for (j = 0; j < idsLength; j++) {
            id = ids[j];
            elementId = prefix + id;
            element = globalVariables.doc.getElementById(elementId);
            if (element && !element.disabled) {  
                if (!element.value && id !== 'addressa') {
                    console.dir(elementId);
                    countErr++
                    element.style.border = '1px solid #f00';
                }
                post[prefix][id] = element.value;
            }
        }
    }

    if (countErr) {
        let message = 'Request failed! Insert required fileds';
        alertify.alert(message);
        return false;
    }

    post['sender'] = post['sender_'];
    delete post['sender_'];
    post['recipient'] = post['recipient_'];
    delete post['recipient_'];
    post['label'] = post['label_'];
    delete post['label_'];
    return post;
}

function uploadImageAndGetCode(element) {
    let formData = new FormData();	
    if (typeof element.files[0] !== 'undefined') {
        formData.append('field_value', element.files[0]);
        let url = globalVariables.ajax + 'labelImageUploadAndGetCode';
        sendFormDataAjaxRequest(formData, url, 'uploadImageAndGetCode', changeHtmlForCode, ['label_code', 'label_image', 'label_imageResponseFullName', 'labelImg']);
    }    
    return false;
}

function changeHtmlForCode(inputField, imageDatabaseName, imageFullName, labelImg, data) {
    let inputCode = globalVariables.doc.getElementById(inputField);
    let inputImageDatabaseName = globalVariables.doc.getElementById(imageDatabaseName);
    let inputImageFullName = globalVariables.doc.getElementById(imageFullName);
    let image = globalVariables.doc.getElementById(labelImg);

    inputCode.value = data.code;    
    inputCode.setAttribute('type', 'hidden');
    inputImageDatabaseName.value = data.imageDatabaseName;
    inputImageDatabaseName.setAttribute('type', 'hidden');
    inputImageFullName.value = data.imageFullName;
    inputImageFullName.setAttribute('type', 'hidden');
    image.src = globalVariables.baseUrl + 'uploads/LabelImages/' + data.imageFullName;
}

function triger(inputId) {
    let input = globalVariables.doc.getElementById(inputId);
    input.onchange = function() {
        uploadImageAndGetCode(input);
    }
}

function resetData () {
    let prefixes = ['sender_', 'recipient_', 'label_'];
    let prefixesLength = prefixes.length;
    let ids = returnIdSufixes();
    let idsLength = ids.length;
    let prefix;
    let id;
    let element;
    let elementId
    let i;
    let j;

    for (i = 0; i < prefixesLength; i++) {
        prefix = prefixes[i];
        for (j = 0; j < idsLength; j++) {
            id = ids[j];
            if (id === 'IsDropOffPoint' || id === 'roleId') {
                continue;
            }
            elementId = prefix + id;
            element = globalVariables.doc.getElementById(elementId);
            if (element) {
                element.value = '';
            }
        }
    }
    if (globalVariables.doc.getElementById('labelImg')) {
        globalVariables.doc.getElementById('labelImg').src = '';
    }
}

var transitionSpeed = 400;
var sliderWidth = 520;
var testimonialCount = 3;
var testimonialImages = document.getElementById("images").children;
var testimonials = document.getElementById("testimonials-wrapper");
var testimonialsStyles = window.getComputedStyle(testimonials);
var newleft;
var testimonialBox = document.getElementsByClassName("testimonial-section__text");
var singleTestimonial = document.getElementsByClassName("single-testimonial")[0];
var testimonialHeight = 0;

for(var i = 0; i < testimonialBox.length; i++){
	console.log('++++', testimonialHeight)
	if(testimonialHeight < testimonialBox[i].offsetHeight){
		testimonialHeight = testimonialBox[i].offsetHeight + 10;
	}
}

singleTestimonial.style.height = testimonialHeight + 10 + 'px';
testimonials.style.height = testimonialHeight + 10 + 'px';
console.log(testimonialHeight, 'ovo')

if(window.innerWidth > 1024){

}else{
	sliderWidth = document.getElementsByClassName("testimonial")[0].offsetWidth;
	console.log(sliderWidth, 'else',document.getElementsByClassName("testimonial")[0].offsetWidth)
	testimonials.style.width = sliderWidth * 3 + 'px';
	testimonials.style.left = (sliderWidth * (-2) + 'px');
}

function disableEnable ( elementId ) {
	var element = document.getElementById(elementId);
	element.disabled = true;
	setTimeout( function() {
		element.disabled = false;
	}, transitionSpeed );
}

function moveRight () {
	var left = parseInt(testimonialsStyles.getPropertyValue('left'));
	if ( left > - (testimonialCount - 1 ) * sliderWidth ) {
		newleft = left - sliderWidth + 'px';
		testimonials.style.left = newleft;
		disableEnable("right");
		for (var counter = 0; counter < (testimonialImages.length -1); counter += 1) {
			if (testimonialImages[counter].className.indexOf("active-image") !== -1) {
				testimonialImages[counter].className = "image";
				testimonialImages[counter].nextElementSibling.className += " active-image";
				return;
			}
		}
	}
}

function moveLeft () {
	var left = parseInt(testimonialsStyles.getPropertyValue('left'));
	if ( left < 0 ) {
		newleft = left + sliderWidth + 'px';
		testimonials.style.left = newleft;
		disableEnable("left");
		for (var counter = 1; counter < testimonialImages.length ; counter += 1) {
			if (testimonialImages[counter].className.indexOf("active-image") !== -1) {
				testimonialImages[counter].className = "image";
				testimonialImages[counter].previousElementSibling.className += " active-image";
				return;
			}
		}
	}
}

function showTestimonialByImage ( imagePixelValue) {
	var allImages = event.target.parentElement.children;
	for (var counter = 0; counter < allImages.length; counter += 1 ) {
		allImages[counter].className = "image";
	}
	event.target.className += " active-image";
	var testimonials = document.getElementById("testimonials-wrapper");
	testimonials.style.left = imagePixelValue;
	disableEnable("left");
	disableEnable("right");
	console.log('click')
}

var left_first = '0px';
var left_second = (-1 * sliderWidth).toString() + 'px';
var left_third = (-2 * sliderWidth).toString() + 'px';
var left_fourth = (-3 * sliderWidth).toString() + 'px';

document.getElementById('image-1').addEventListener('click', function(){
	showTestimonialByImage(left_first)
});
document.getElementById('image-2').addEventListener('click', function(){
	showTestimonialByImage(left_second)
});
document.getElementById('image-3').addEventListener('click', function(){
	showTestimonialByImage(left_third)
});

var slideIndex = 0;
showSlides();

function showSlides() {
	var i;
	var slides = document.getElementsByClassName("mySlides");
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";
	}
	slideIndex++;
	if (slideIndex > slides.length) {slideIndex = 1}
	slides[slideIndex-1].style.display = "block";
	setTimeout(showSlides, 4000); // Change image every 2 seconds
}
