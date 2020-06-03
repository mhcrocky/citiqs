'use strict';
function disableEnable(elementId) {
    var element = document.getElementById(elementId);
    // element.disabled = true;
    setTimeout( function() {
        // element.disabled = false;
    }, transitionSpeed );
}

function moveRight () {
    var left = parseInt(testimonialsStyles.getPropertyValue('left'));
    if ( left > - (testimonialCount - 1 ) * sliderWidth ) {
        newleft = left - sliderWidth + 'px';
        testimonials.style.left = newleft;
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

function showTestimonialByImage(imagePixelValue) {
    var allImages = event.target.parentElement.children;
    var testimonials = document.getElementById("testimonials-wrapper");
    for (var counter = 0; counter < allImages.length; counter += 1 ) {
        allImages[counter].className = "image";
    }
    event.target.className += " active-image";
    
    testimonials.style.left = imagePixelValue;
    disableEnable("left");
    disableEnable("right");
}
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

var transitionSpeed = 400;
var sliderWidth = 520;
var testimonialCount = 6;
var testimonialImages = document.getElementById("images").children;
var testimonials = document.getElementById("testimonials-wrapper");
var testimonialsStyles = window.getComputedStyle(testimonials);
var newleft;
var testimonialBox = document.getElementsByClassName("testimonial");
var singleTestimonial = document.getElementsByClassName("single-testimonial")[0];
var testimonialHeight = 0;

for(var i = 0; i < testimonialBox.length; i++){
    if(testimonialHeight < testimonialBox[i].offsetHeight){
        testimonialHeight = testimonialBox[i].offsetHeight + 10;
    }
}

singleTestimonial.style.height = testimonialHeight + 10 + 'px';
testimonials.style.height = testimonialHeight + 10 + 'px';

if (window.innerWidth <= 1024) {
    sliderWidth = document.getElementsByClassName("testimonial")[0].offsetWidth;
    testimonials.style.width = sliderWidth * 6 + 'px';
}


var left_first = '0px';
var left_second = (-1 * sliderWidth).toString() + 'px';
var left_third = (-2 * sliderWidth).toString() + 'px';
var left_fourth = (-3 * sliderWidth).toString() + 'px';
var left_fifth = (-4 * sliderWidth).toString() + 'px';
var left_six = (-5 * sliderWidth).toString() + 'px';

document.getElementById('image-1').addEventListener('click', function(){
    showTestimonialByImage(left_first)
});
document.getElementById('image-2').addEventListener('click', function(){
    showTestimonialByImage(left_second)
});
document.getElementById('image-3').addEventListener('click', function(){
    showTestimonialByImage(left_third)
});
document.getElementById('image-4').addEventListener('click', function(){
    showTestimonialByImage(left_fourth)
});
document.getElementById('image-5').addEventListener('click', function(){
    showTestimonialByImage(left_fifth)
});
document.getElementById('image-6').addEventListener('click', function(){
    showTestimonialByImage(left_six)
});

var slideIndex = 0;
showSlides();



var testimonialSize = document.getElementsByClassName('image').length;
var testimonialCoutner = 0;
setInterval(function(){
    if(testimonialCoutner <= testimonialSize){
        moveRight ();
        testimonialCoutner++;
    }else{
        document.getElementsByClassName('text')[0].style.left = 0;
        testimonialCoutner = 1;
        document.getElementsByClassName('image')[testimonialSize - 1].classList.remove('active-image');
        document.getElementsByClassName('image')[0].classList.add('active-image');
    }
}, 20000)