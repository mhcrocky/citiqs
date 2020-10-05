'use strict';

function addToOrder(amountId, quantiyId, price, orderAmountId, orderQuantityId, categoryId, nameId, decsriptionId, priceId, showOrderedQuantity, productId, plus) {

    let amountElement = document.getElementById(amountId);
    let amountValue = parseFloat(amountElement.value);

    let quantityElement = document.getElementById(quantiyId);
    let quantityValue = parseFloat(quantityElement.value);

    let orderAmountElement = document.getElementById(orderAmountId);
    let orderQuantityElement = document.getElementById(orderQuantityId);    
    let showProductOrderedQuantity = document.getElementById(showOrderedQuantity);

    let categoryElement = document.getElementById(categoryId);
    let nameElement = document.getElementById(nameId);
    // let descriptionElement = document.getElementById(decsriptionId);
    let priceElement = document.getElementById(priceId);
    let productIdElement = document.getElementById(productId);

    let amountTrigger = false;
    let orderTrigger = false;

    if (amountValue >= 0) {
        
        if (plus) {

            amountValue = amountValue + parseFloat(price);
            orderAmountElement.innerHTML = (parseFloat(orderAmountElement.innerHTML) + parseFloat(price)).toFixed(2);
        } else {
            if (amountValue > 0) {
                amountValue = amountValue - parseFloat(price);
                amountTrigger = true;
            } else {
                amountValue = 0;
            }
            
            let orderAmountValue = parseFloat(orderAmountElement.innerHTML);

            if (orderAmountValue > 0 && amountValue > 0) {
                orderAmountElement.innerHTML = (orderAmountValue - parseFloat(price)).toFixed(2);
            }

            if (orderAmountValue > 0 && amountValue === 0) {
                orderAmountElement.innerHTML = amountTrigger ? (orderAmountValue - parseFloat(price)).toFixed(2) : orderAmountValue.toFixed(2);
                amountTrigger = false;
            }


        }
        amountElement.value = amountValue.toFixed(2);
    }

    if (quantityValue >= 0) {
        let orderQuantityValue = parseInt(orderQuantityElement.innerHTML);

        if (plus) {
            quantityValue = quantityValue + 1;
            orderQuantityElement.innerHTML = orderQuantityValue + 1;
        } else {
            if (quantityValue > 0) {
                quantityValue = quantityValue > 0 ? (quantityValue - 1) : 0;
                orderTrigger = true;
            } else {
                quantityValue = 0;
            }

            if (orderQuantityValue > 0 && quantityValue > 0) {
                orderQuantityElement.innerHTML = orderQuantityValue - 1;
            }

            if (orderQuantityValue > 0 && quantityValue === 0) {
                orderQuantityElement.innerHTML = orderTrigger ? (orderQuantityValue - 1) : orderQuantityValue;
                orderTrigger = false;
            }
        }
        
        showProductOrderedQuantity.innerHTML = quantityValue;
        quantityElement.value = quantityValue;
    }

    if (amountValue > 0 || quantityValue > 0) {
        amountElement.disabled = false;
        quantityElement.disabled = false;
        categoryElement.disabled = false;
        nameElement.disabled = false;
        // descriptionElement.disabled = false;
        priceElement.disabled = false;
        productIdElement.disabled = false;
        // document.getElementById('home').style.display = "none";
    } else {
        amountElement.disabled = true;
        quantityElement.disabled = true;
        categoryElement.disabled = true;
        nameElement.disabled = true;
        // descriptionElement.disabled = true;
        priceElement.disabled = true;
        productIdElement.disabled = true;
        // document.getElementById('home').style.display = "initial";
    }

    return;
}

function submitMakeOrderForm(formId, orderAmount, orderQuantity) {
    let amount = parseFloat(document.getElementById(orderAmount).innerHTML);
    let quantity = parseInt(document.getElementById(orderQuantity).innerHTML);
    if (amount && quantity || makeOldOrderGlobals.thGroup) {
        let form = document.getElementById(formId);
        form.submit();
    }
}
jQuery(document).ready(function($) {
    $('.main-slider').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
		slidesToShow: 1,
		adaptiveHeight: true
    });
    
    $('[data-toggle="popover"]').popover({
        animation : false,
        placement : "right",
        container: 'body'
    });
});

function showAddOns(className) {
    $('.' + className).toggle()
}
