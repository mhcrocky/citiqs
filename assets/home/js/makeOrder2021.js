'use strict';
function changeSiblingValue(element, action) {
    let input = $(element).siblings('input')[0];
    changeInputQuantity(input, action);
    return;
}

function changeInputQuantity(input, action) {
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
            input.checked = false;
            dipsalyButtons(input);
            input.removeAttribute('checked');
        } else if (input.type === 'text')  {
            setInputAttribte(input, 'value', '');
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
    let displayStyle = element.checked ? 'display:initial' : 'display:none';
    let input = elementToDisplay.getElementsByTagName('input')[0];

    setInputAttribte(elementToDisplay, 'style', displayStyle);
    setInputAttribte(input, 'value', '1');
    setInputAttribte(input, 'disabled', !element.checked);
    setInputAttribte(element, 'checked', element.checked);
}

function mainProductQuantity(element, action) {
    changeSiblingValue(element, action);
    // to do 
    // => show element in checkout modal
    // => change value for all elements with same data-id
    // => remove element if value is 0
    // => reset value to 0 on product list if element is removed
}

function addInCheckoutList(modalId, dataProductId, productName, productPrice) {
    let modal = document.getElementById(modalId);
    let modalBodyHtml = modal.getElementsByClassName('modal-body')[0].innerHTML;
    let productQuantityInput = document.querySelector('[data-id="' + dataProductId + '"]');
    showAllInCheckoutModal(modalBodyHtml, productName, productPrice);
    changeInputQuantity(productQuantityInput, true);
    clearModal(modalId);
    $('#' + modalId).modal('hide');
}

function showAllInCheckoutModal(html, productName, productPrice) {
    let template = getAllItemTemplate(html, productName, productPrice);
    console.dir(template);
    appendInCheckoutModal(template);
}

function appendInCheckoutModal(html) {
    $('#checkout-modal-list').append(html);
}

function getAllItemTemplate(html, productName, productPrice) {
    let template =  `<div>
                        <div class='menu-list__item' style="border-bottom: 0px #fff;">
                            <div class='menu-list__name'>
                                <b>${productName}</b>
                            </div>
                            <div class='menu-list__right-col'>
                                <div class='menu-list__price'>
                                    <b class='menu-list__price'>${productPrice}&euro; </b>
                                </div>
                            </div>
                        </div>
                        ${html}
                    </div>`;
    return template;
}

// let categoryButton = document.querySelector('[data-id="' + category.id + '"]');
$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        animation : false,
        placement : "right",
        container: 'body'
    });

    var splideCategories = new Splide(
    '#splideCategories',
        {
            perPage    : 1,
            perMove    : 1,
            height     : '9rem',
            focus      : 'center',
            trimSpace  : false,
            
        } 
    ).mount(window.splide.Extensions);

});
