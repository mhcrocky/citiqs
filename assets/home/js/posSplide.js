'use strict';

// import Splide from '/upwork/alfred/node_modules/@splidejs/splide';
// import URLHash from '/alfred/node_modules/@splidejs/splide-extension-url-hash';

function runSplide() {
    var splide = new Splide(
        // '.splide',
        //     {
        //         perPage: 3,
        //         perMove: 1,
        //     }

        ).mount(window.splide.Extensions);


    // splide.on('move', function(e) {
    //     let categoryId = 'category_' + e;
    //     let element = document.querySelectorAll('[data-index="' + categoryId + '"]')[0];
    //     // console.dir();
    //     $(element).trigger('click');
    // });
}

// runSplide();
var splide = new Splide(
    '.splide',
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

splide.on('moved', function(e) {
    // console.dir(this);
    // console.dir(e);
    // console.dir(window.location);
    // console.dir(window.location.hash);
    let hashTag = window.location.hash;
    let splideHash = hashTag.replace('#', '');
    let element = document.querySelectorAll('[data-splide-hash="' + splideHash + '"]')[0];
    $(element).trigger('click');
});
