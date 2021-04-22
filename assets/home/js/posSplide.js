'use strict';
function triggerHashValue() {
    let hashTag = window.location.hash;
    if (hashTag) {
        let splideHash = hashTag.replace('#', '');
        let element = document.querySelectorAll('[data-splide-hash="' + splideHash + '"]')[0];
        if (element) {
            $(element).trigger('click');
        }
    }
    return;
}

var options = {}

var splideCategories = new Splide(
    '#splideCategories',
        {
            perPage    : 6,
            perMove    : 1,
            height     : '9rem',
            focus      : 'left',
            trimSpace  : false,
			gap		   : 10, 
			pagination : false,
            breakpoints: {
                600: {
                    perPage: 2,
                    height : '6rem',
                }
            }
        } 
    ).mount(window.splide.Extensions);

splideCategories.on('moved', function(e) {
    triggerHashValue();
});

var splideSpots = new Splide(
        '#splideSpots',
        {
            perMove     : 1,
            perPage     : 7,
			gap         : 10,
            direction   : 'ttb',
            height      : '81vh',
			pagination  : false,
        }
    ).mount(window.splide.Extensions);

$(document).ready(function(){
    triggerHashValue();
})
