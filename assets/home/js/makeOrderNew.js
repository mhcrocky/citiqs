'use strict';
function toggleElement(element) {
    let container = element.parentElement.parentElement.nextElementSibling;
    let inputField = container.children[1];
    let checked = element.checked;
    container.style.visibility = checked ? 'visible' : 'hidden';
    inputField.disabled = checked ? false : true;
    if (isOrdered(element)) {
        let itemId = element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.id;
        populateShoppingCart(itemId);
    }
}

function changeProductQuayntity(element, className) {
    let type = element.dataset.type;
    let inputField = (type === 'plus') ? element.previousElementSibling : element.nextElementSibling;
    let value = parseInt(inputField.value);
    let minValue = parseInt(inputField.min);
    let ancestor = '#' + makeOrderGlobals.checkoutModal;
    let isOrdered = element.closest(ancestor);

    if (type === 'minus' && value > minValue) {
        value = value - 1;
    }

    if (type === 'plus') {
        value = value + 1;
    }

    inputField.setAttribute('value', value);
    changeAddonInputAttributes(element, value, className, isOrdered);

    if (isOrdered) {
        let itemId = element.parentElement.parentElement.parentElement.parentElement.id;
        populateShoppingCart(itemId);
        resetTotal();
    }
}

function changeAddonInputAttributes(element, quantity, className, isOrdered) {
    let ancestor = '#' + makeOrderGlobals.checkoutModal;
    if (!element.parentElement.parentElement.nextElementSibling) return;
    let classParent = element.parentElement.parentElement.nextElementSibling.children[1];
    let addonInputs = classParent.getElementsByClassName(className);
    let addonInputsLength = addonInputs.length;
    let i;

    for (i = 0; i < addonInputsLength; i++) {
        let addonInput = addonInputs[i];
        let toggleDisabled = false;
        if (addonInput.closest(ancestor) === isOrdered) {
            if (addonInput.disabled === true) {
                toggleDisabled = true;
                addonInput.disabled = false;
            }

            let newStep = quantity;
            addonInput.setAttribute('step', newStep);

            let newMin = newStep * parseInt(addonInput.dataset.initialMinQuantity);
            addonInput.setAttribute('min', newMin);

            let newMax = newStep * parseInt(addonInput.dataset.initialMaxQuantity);
            addonInput.setAttribute('max', newMax);

            let newValue = newStep;
            addonInput.setAttribute('value', newValue);

            if (toggleDisabled) {
                addonInput.disabled = true;
            }
        }
    }
}

function changeAddonQuayntity(element) {
    let type = element.dataset.type;
    let inputField = (type === 'plus') ? element.previousElementSibling : element.nextElementSibling;
    let value = parseInt(inputField.value);
    let minValue = parseInt(inputField.min);
    let maxValue = parseInt(inputField.max);
    let stepValue = parseInt(inputField.step);
    
    if (type === 'minus' && value > minValue) {
        value = value - stepValue;
    }

    if (type === 'plus' && value < maxValue) {
        value = value + stepValue;
    }

    inputField.setAttribute('value', value);

    if (isOrdered(element)) {
        let itemId = element.parentElement.parentElement.parentElement.parentElement.parentElement.id;
        populateShoppingCart(itemId);
    }
}

function isOrdered(element) {
    let ancestor = '#' + makeOrderGlobals.checkoutModal;
    let isOrdered = element.closest(ancestor);
    if (isOrdered) {
        resetTotal();
        return true;
    }
    return false;
}

function cloneProductAndAddons(element) {
    let productContainerId = 'product_' + element.dataset.productId;
    let productContainer = document.getElementById(productContainerId);
    let orderContainer = document.getElementById(makeOrderGlobals.modalCheckoutList);
    let clone;

    let date  = new Date();
    let randomId = productContainerId + '_' + date.getTime() + '_' + Math.floor(Math.random() * 10000);

    checkoutHtmlHeader(orderContainer, randomId, element);
    productContainer.removeAttribute('id');
    clone = $(productContainer).clone();
    productContainer.setAttribute('id', productContainerId);
    resetAddons(productContainer);
    clone.appendTo(document.getElementById(randomId));
    resetTotal();
    populateShoppingCart(randomId);
}

function checkoutHtmlHeader(orderContainer, randomId, element) {
    let htmlCheckout = '';
    htmlCheckout +=  '<div id="' + randomId + '" class="orderedProducts" style="margin-bottom: 30px; padding-left:0px">';
    htmlCheckout +=      '<div class="alert alert-dismissible" style="padding-left: 0px; margin-bottom: 10px;">';
    htmlCheckout +=          '<a href="#" onclick="removeOrdered(\'' + randomId + '\')" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    htmlCheckout +=          '<h4>' + element.dataset.productName + ' (&euro;' + element.dataset.productPrice + ')';
    htmlCheckout +=      '</div>';
    htmlCheckout +=  '</div>';
    $(orderContainer).append(htmlCheckout);
}

function populateShoppingCart(randomId) {
    
    $('.' + randomId).remove();
    let products = document.querySelectorAll('#' + randomId + ' [data-add-product-price]');
    let addons = document.querySelectorAll('#' + randomId + ' [data-addon-price]');
    let addonsLength = addons.length;
    let i;
    let product = products[0];
    let html = '';
    let aditionalList = [];
    let price = parseFloat(product.value) * parseFloat(product.dataset.addProductPrice);

    for (i = 0; i < addonsLength; i++) {
        let addon = addons[i];
        let checkbox = addon.parentElement.previousElementSibling.children[0].children[0];
        if (checkbox.checked) {
            price = price + parseFloat(addon.dataset.addonPrice) * parseFloat(addon.value);
            let addonString = addon.dataset.addonName + ' (' + addon.value +')';
            aditionalList.push(addonString);
        }
    }

    html += '<div class="shopping-cart__single-item ' + randomId + '" data-ordered-id="' + randomId + '">';
    html +=     '<div class="shopping-cart__single-item__details">';
    html +=         '<p style="text-align:left">';
    html +=             '<span class="shopping-cart__single-item__quantity">' + product.value + '</span>';
    html +=             ' x ';
    html +=             '<span class="shopping-cart__single-item__name">' + product.dataset.name + '</span>';
    html +=         '</p>';
    html +=         '<p class="shopping-cart__single-item__additional"  style="text-align:left">' + aditionalList.join(', ') + '</p>';
    html +=         '<p>&euro; <span class="shopping-cart__single-item__price">' + price.toFixed(2) +'</span></p>';
    html +=     '</div>';
    html +=     '<div class="shopping-cart__single-item__remove" onclick="focusOnOrderItem(\'modal__checkout__list\', \'' + randomId + '\')">';
    html +=         '<i class="fa fa-info-circle" aria-hidden="true"></i>';
    html +=     '</div>';
    html += '</div>';
    // data-toggle="modal" data-target="#checkout-modal"
    $('#' + makeOrderGlobals.shoppingCartList).append(html);
}

function changeTotal(value, reset = false) {
    let totals = document.getElementsByClassName('totalPrice');
    let totalsLength = totals.length;
    let i;
    let total;
    let totalValue;
    for (i = 0; i < totalsLength; i++) {
        total = totals[i];
        totalValue = !reset ? parseFloat(total.innerHTML) : 0;
        totalValue = totalValue + parseFloat(value);
        total.innerHTML = totalValue.toFixed(2);
    }
}

function resetTotal() {
    let products = document.querySelectorAll('#modal__checkout__list [data-add-product-price]');
    let productsLength = products.length;
    let addons = document.querySelectorAll('#modal__checkout__list [data-addon-price]');
    let addonsLength = addons.length;
    let i;
    let value = 0;

    for (i = 0; i < productsLength; i++) {
        let product = products[i];
        value = value + parseFloat(product.dataset.addProductPrice)  * parseFloat(product.value);
    }

    for (i = 0; i < addonsLength; i++) {
        let addon = addons[i];
        let checkbox = addon.parentElement.previousElementSibling.children[0].children[0];
        if (checkbox.checked) {
            value = value + parseFloat(addon.dataset.addonPrice) * parseFloat(addon.value);
        }
    }
    
    changeTotal(value, true);
}

function resetAddons(productContainer) {
    let products = productContainer.getElementsByClassName(makeOrderGlobals.checkProduct);
    let productsLength = products.length;
    let addons = productContainer.getElementsByClassName(makeOrderGlobals.checkAddons);
    let addonsLength = addons.length;
    let i;
    for (i = 0; i < productsLength; i++) {
        let product = products[i];
        product.setAttribute('value', '1');
    }
    for (i = 0; i < addonsLength; i++) {
        let addon = addons[i];
        addon.checked = false;

        let addonInput = addon.parentElement.parentElement.nextElementSibling.children[1];

        addonInput.setAttribute('min', addonInput.dataset.min);
        addonInput.setAttribute('max', addonInput.dataset.max);
        addonInput.setAttribute('value', '1');
        addonInput.setAttribute('step', '1');

        toggleElement(addon);
    }
}

function removeOrdered(elementId) {
    document.getElementById(elementId).remove();
    document.querySelectorAll('#' + makeOrderGlobals.shoppingCartList + ' [data-ordered-id = "' + elementId + '"]')[0].remove();
    resetTotal();
}

function focusOnOrderItem(containerId, itemId) {
    $('#checkout-modal').modal('show');
    let items = document.getElementById(containerId).children;
    let itemsLength = items.length;
    let i;
    for (i = 0; i < itemsLength; i++) {
        let item = items[i];
        if (item.id !== itemId) {
            item.style.display = 'none';
        } else {
            item.style.display = 'initial';
        }
    }
}

function focusCheckOutModal(containerId) {
    $('#checkout-modal').modal('show');
    let items = document.getElementById(containerId).children;
    let itemsLength = items.length;
    let i;
    for (i = 0; i < itemsLength; i++) {
        let item = items[i];
        item.style.display = 'initial';
    }
}

function checkout() {
    let orderedProducts = document.getElementsByClassName(makeOrderGlobals.orderedProducts);
    let orderedProductsLength = orderedProducts.length;
    let orderedItem;
    let i;
    let j;
    let post = [];

    for (i = 0; i < orderedProductsLength; i++) {
        orderedItem = orderedProducts[i];
        let product = document.querySelectorAll('#' + orderedItem.id + ' [data-add-product-price]')[0];
        let addons = document.querySelectorAll('#' + orderedItem.id + ' [data-addon-price]');
        let addonsLength = addons.length;
        let productAmount = (parseFloat(product.value) * parseFloat(product.dataset.addProductPrice)).toFixed(2);
        post[i] = {};
        post[i][product.dataset.productExtendedId] = {
            'amount' : productAmount,
            'quantity' : product.value,
            'category' : product.dataset.category,
            'name' : product.dataset.name,
            'price' : product.dataset.addProductPrice,
            'productId' : product.dataset.productId,
            'onlyOne' : product.dataset.onlyOne,
            'addons' : {}
        };

        if (product.dataset.remarkId !== '0') {
            let productRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-product-remark-id=' + product.dataset.remarkId + ']')[0].value;
            post[i][product.dataset.productExtendedId]['remark'] = productRemark;
        }

        if (addonsLength) {
            for (j = 0; j < addonsLength; j++) {
                let addon = addons[j];
                if (addon.parentElement.previousElementSibling.children[0].children[0].checked) {
                    let addonAmount = parseFloat(addon.value) * parseFloat(addon.dataset.addonPrice);
                    post[i][product.dataset.productExtendedId]['addons'][addon.dataset.addonExtendedId] = {
                        'amount' : addonAmount,
                        'quantity' : addon.value,
                        'category' : addon.dataset.category,
                        'name' : addon.dataset.addonName,
                        'price' : addon.dataset.addonPrice,
                        'minQuantity' : addon.min,
                        'maxQuantity' : addon.max,
                        'step' : addon.step,
                        'initialMinQuantity' : addon.dataset.initialMinQuantity,
                        'initialMaxQuantity' : addon.dataset.initialMaxQuantity,
                    }
                    if (addon.dataset.remarkId !== '0') {
                        let addonRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-addon-remark-id=' + addon.dataset.remarkId + ']')[0].value;
                        post[i][product.dataset.productExtendedId]['addons'][addon.dataset.addonExtendedId]['remark'] = addonRemark;
                    }
                }
            }
        }
    }

    let send = {
        'data' : post
    }

    $.ajax({
        url: globalVariables.ajax + 'setOrderSession',
        data: send,
        type: 'POST',
        success: function (response) {
            if (response === '1') {
                window.location.href = globalVariables.baseUrl + 'checkout_order';
            }
        },
        error: function (err) {
            console.dir(err);
        }
    });
}

var makeOrderGlobals = (function(){
    let globals = {
        'checkoutModal' : 'checkout-modal',
        'modalCheckoutList' : 'modal__checkout__list',
        'checkProduct' : 'checkProduct',
        'checkAddons' : 'checkAddons',
        'shoppingCartList' : 'shopping-cart__list',
        'orderedProducts' : 'orderedProducts'
    }
    Object.freeze(globals);
    return globals;
}());

$(document).ready(function(){
    $('.items-slider').slick({
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true
    });
    resetTotal();
});
