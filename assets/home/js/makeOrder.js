'use strict';
function toogleCategories(element) {
    let categories = orderGlobals.categories;
    let i;
    let categorieslength = categories.length;
    if (element.value === '0') {
        for (i = 0; i < categorieslength; i++) {            
        let elementClass = 'category_' + categories[i]['categoryId'];
            $('.' + elementClass).show();
        }
        return;
    }

    for (i = 0; i < categorieslength; i++) {            
        let elementClass = 'category_' + categories[i]['categoryId'];
        if (elementClass === element.value) {
            $('.' + elementClass).show();
        } else {
            $('.' + elementClass).hide();
        }
    }
    return;
}

function addToOrder(amountId, quantiyId, price, className, orderAmountId, orderQuantityId, categoryId, nameId, decsriptionId, plus) {
    let amountElement = document.getElementById(amountId);
    let amountValue = parseFloat(amountElement.value);

    let quantityElement = document.getElementById(quantiyId);
    let quantityValue = parseFloat(quantityElement.value);

    let orderAmountElement = document.getElementById(orderAmountId);
    let orderQuantityElement = document.getElementById(orderQuantityId);


    let categoryElement = document.getElementById(categoryId);
    let nameElement = document.getElementById(nameId);
    let descriptionElement = document.getElementById(decsriptionId);

    if (amountValue >= 0) {
        amountValue = (plus) ? (amountValue + parseFloat(price)) : amountValue > 0 ? (amountValue - parseFloat(price)) : 0;
        amountElement.value = amountValue;
    }

    if (quantityValue >= 0) {
        quantityValue = (plus) ? (quantityValue + 1) : quantityValue > 0 ? (quantityValue - 1) : 0;
        quantityElement.value = quantityValue;
    }

    if (amountValue > 0 && quantityValue > 0) {
        $('.' + className).removeClass('hideElement').addClass('showOrders');
        amountElement.disabled = false;
        quantityElement.disabled = false;
        categoryElement.disabled = false;
        nameElement.disabled = false;
        descriptionElement.disabled = false;
    } else {
        $('.' + className).removeClass('showOrders').addClass('hideElement');
        amountElement.disabled = true;
        quantityElement.disabled = true;
        categoryElement.disabled = true;
        nameElement.disabled = true;
        descriptionElement.disabled = true;
    }

    orderAmountElement.innerHTML = amountValue;
    orderQuantityElement.innerHTML = quantityValue;

    return;
}

jQuery(document).ready(function($) {
    $('.main-slider').slick({
        dots: true,
        arrows: true,
        infinite: false,
        speed: 300,
        slidesToScroll: 1,
        rows: 1,
        slidesPerRow: 1,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
        ]
    });
});