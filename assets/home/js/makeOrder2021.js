'use strict';
function changeValue(element, action) {
    let input = $(element).siblings('input')[0];
    let max = input.max;
    let min = input.min;
    let newValue = parseInt(input.value);

    (action) ? newValue++  : newValue--;

    if (newValue >= min && newValue <= max) {
        setInputAttribte(input, 'value', newValue);
    }

    return;
}

function clearModal(modalId) {
    let modal = document.getElementById(modalId);
    let inputs = modal.getElementsByTagName('input');
    let inputsLength = inputs.length;
    let i;
    for (i = 0; i < inputsLength; i++) {
        let input = inputs[i];
        if (input.type === 'checkbox') {
            setInputAttribte(input, 'checked', false);
        } else {
            let resetValue = (input.type === 'number')  ? '0' : '';
            setInputAttribte(input, 'value', resetValue);
            setInputAttribte(input, 'disabled', true);
        }
    }
    return;
}

function setInputAttribte(input, attribute, newValue) {
    input[attribute] = newValue;
    input.setAttribute(attribute, newValue);
}

function dipsalyButtons(element) {
    let elementToDisplay = element.parentElement.parentElement.nextElementSibling;
    let displayStyle = element.checked ? 'initial' : 'none';
    let input = elementToDisplay.getElementsByTagName('input')[0];

    elementToDisplay.style.display = displayStyle;
    setInputAttribte(input, 'disabled', !element.checked);
}

function mainProductQuantity(element, action) {
    changeValue(element, action);
    // to do => show element in checkout modal
}

$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        animation : false,
        placement : "right",
        container: 'body'
    });

    var splideCategories = new Splide(
    '#splideCategories',
        {
            perPage    : 4,
            perMove    : 1,
            height     : '9rem',
            focus      : 'center',
            trimSpace  : false,
            
        } 
    ).mount(window.splide.Extensions);

});



    // // quantity input
    // var quantity_section = $('.quantity-section');
    // var quantity_button_plus = $('.quantity-button--plus');
    // var quantity_button_minus = $('.quantity-button--minus');
    // var quantity_input = $('.quantity-input');

    // quantity_button_plus.click(function() {
    //     console.dir($(this).siblings('.quantity-input'));

    //     let num = $(this).siblings('.quantity-input').val();
    //     num++;
    //     $(this).siblings('.quantity-input').val(num)
    // })

    // quantity_button_minus.click(function(){
    //     let num = $(this).siblings('.quantity-input').val();
    //     if(num >= 1){
    //         num--;
    //         $(this).siblings('.quantity-input').val(num)
    //     }
    // })


