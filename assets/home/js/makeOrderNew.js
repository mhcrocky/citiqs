'use strict';



$(document).ready(function(){
    $('.items-slider').slick({
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true
    });

    $('.categoryNav a').on("click", function () {
        let actIndex = parseInt(this.dataset.index);
        goToSlide(actIndex);
    });

    $('[data-toggle="popover"]').popover({
        animation : false,
        placement : "right",
        container: 'body'
    });
    countOrdered('countOrdered');
    resetTotal();
    if (makeOrderGlobals.categorySlide) {
        goToSlide(parseInt(makeOrderGlobals.categorySlide));
    }
    if (inIframe()) {
        let logo = document.getElementById(makeOrderGlobals.logoImageId);
        if (logo) {
            logo.style.display = 'none';
        }
    }
});
