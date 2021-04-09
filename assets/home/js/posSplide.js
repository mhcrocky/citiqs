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

var splideCategories = new Splide(
    '#splideCategories',
        {
            perPage    : 3,
            perMove    : 1,
            height     : '9rem',
            focus      : 'center',
            trimSpace  : false,
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
            perPage     : 5,
            direction   : 'ttb',
            height      : '70vh'
        }
    ).mount(window.splide.Extensions);

$(document).ready(function(){
    triggerHashValue();
})
