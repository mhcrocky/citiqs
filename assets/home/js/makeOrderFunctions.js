'use_strict';

function toggleElement(element, printed = '0') {
    if (printed === '1') {
        console.dir(element);
        alertify.error('Not allowed to change. Item printed!');
        element.checked = true;
        return;
    }
    let container = element.parentElement.parentElement.nextElementSibling;
    let inputField = container.children[1];
    let checked = element.checked;
    let allowedChoices = parseInt(inputField.dataset.allowedChoices);
    let addonTypeId = element.dataset.addonTypeIdCheck;

    if (allowedChoices > 0 && checked) {
        checkAllowedChoices(container.parentElement, allowedChoices, addonTypeId, element)
    }


    if (inputField.dataset.isBoolean === '0') {
        container.style.visibility = checked ? 'visible' : 'hidden';
    } else if (inputField.dataset.isBoolean === '1') {
        container.style.visibility = 'hidden';
    }

    inputField.disabled = checked ? false : true;
    if (!checked) inputField.value = inputField.min;

    if (isOrdered(element)) {
        let itemId = element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.id;
        populateShoppingCart(itemId);
    }
}

function checkQuantity(container, allowedChoices, addonTypeId) {
    let quantityElements = container.querySelectorAll('input[data-addon-type-id="' + addonTypeId + '"]');
    let quantityElementsLength = quantityElements.length;
    let i;
    let quantity = 0;
    for (i = 0; i < quantityElementsLength; i++) {
        let element = quantityElements[i]
        if (!element.disabled) {
            quantity += parseInt(element.value);
        }
        if (quantity >= allowedChoices) {
            return false;
        }
    }
    return true;
}

function checkAllowedChoices(container, allowedChoices, addonTypeId, elementChecked) {
    let checkedElements = container.querySelectorAll('[data-addon-type-id-check="' + addonTypeId + '"]:checked');
    let checkedElementsLength = checkedElements.length;
    if (checkedElementsLength > allowedChoices || !checkQuantity(container, allowedChoices, addonTypeId)) {
        let i;
        for (i = 0; i < checkedElementsLength; i++) {
            let element = checkedElements[i];
            let container = element.parentElement.parentElement.nextElementSibling;
            let inputField = container.children[1];
            if (element !== elementChecked) {
                element.checked = false;
                container.style.visibility = 'hidden';
                inputField.value = inputField.min;
                inputField.disabled = true;
            }
        }
        return false;
    }
    return true;
}

function changeProductQuayntity(element, className, printed = '0') {
    if (printed === '1') {
        alertify.error('Not allowed to change. Item printed!');
        return;
    }
    let type = element.dataset.type;
    let inputField = (type === 'plus') ? element.previousElementSibling : element.nextElementSibling;
    let value = parseInt(inputField.value);
    let minValue = parseInt(inputField.min);
    let ancestor = '#' + makeOrderGlobals.checkoutModal;
    let isOrdered = element.closest(ancestor);
    if (!isOrdered) {
        ancestor = '#' + makeOrderGlobals.posMakeOrderId;
        isOrdered = element.closest(ancestor);
    }

    if (value <= 0) {
        value = minValue;
        return
    }
    if (type === 'minus' && value > minValue) {
        value = value - 1;
    }

    if (type === 'plus') {
        value = value + 1;
    }

    inputField.value = value;
    changeAddonInputAttributes(element, value, className, isOrdered);

    if (isOrdered) {
        let itemId = element.parentElement.parentElement.parentElement.parentElement.id;
        populateShoppingCart(itemId);
        let incerase = (type === 'plus') ? true : false;
        let showValue = showHtmlQuantity(inputField, incerase, false);
        if (showValue === 0) {
            element.parentElement.parentElement.parentElement.parentElement.remove();
            // alertify.success('Product removed from list');
        }
        resetTotal();
    }
}

function isProductOrdered(containerId, inputField) {
    let checkoutContainer = document.getElementById(containerId);
    return (checkoutContainer && checkoutContainer.contains(inputField)) ? true : false; 
}

function changeAddonInputAttributes(element, quantity, className, isOrdered) {
    if (!element.parentElement.parentElement.nextElementSibling) return;
    let ancestorBuyer = '#' + makeOrderGlobals.checkoutModal;
    let ancestorPos = '#' + makeOrderGlobals.posMakeOrderId;
    let classParent = element.parentElement.parentElement.nextElementSibling;
    let addonInputs = classParent.getElementsByClassName(className);
    let addonInputsLength = addonInputs.length;
    let i;

    for (i = 0; i < addonInputsLength; i++) {
        let addonInput = addonInputs[i];
        let toggleDisabled = false;
        if (addonInput.closest(ancestorBuyer) === isOrdered || addonInput.closest(ancestorPos) === isOrdered) {
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
            addonInput.value = newValue;

            // INTILAT ALLOWED CHOICES
            // let newAlloweChoices = parseInt(addonInput.dataset.allowedChoices) * newStep;
            // addonInput.setAttribute('data-allowed-choices', newAlloweChoices);

            if (toggleDisabled) {
                addonInput.disabled = true;
            }
        }
    }
}

function calculateQuantity(element) {
    
}

function changeAddonQuayntity(element, printed = '0') {
    if (printed === '1') {
        alertify.error('Not allowed to change. Item printed!');
        return;
    }
    let type = element.dataset.type;
    let inputField = (type === 'plus') ? element.previousElementSibling : element.nextElementSibling;

    let container = element.parentElement.parentElement;
    let allowedChoices = parseInt(inputField.dataset.allowedChoices);
    let addonTypeId = inputField.dataset.addonTypeId;

    if (allowedChoices > 0 && type === 'plus' && !checkQuantity(container, allowedChoices, addonTypeId)) return;

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

    inputField.value = value;

    if (isOrdered(element)) {
        let itemId = element.parentElement.parentElement.parentElement.parentElement.parentElement.id;
        populateShoppingCart(itemId);
    }
}

function isOrdered(element) {
    let ancestor = '#' + makeOrderGlobals.checkoutModal;
    let isOrdered = element.closest(ancestor);

    if (!isOrdered) {
        ancestor = '#' + makeOrderGlobals.posMakeOrderId;
        isOrdered = element.closest(ancestor);
    }

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
    let randomId = productContainerId + '_' + date.getTime() + '_' + Math.floor(Math.random() * 100000);

    checkoutHtmlHeader(orderContainer, randomId, element);
    productContainer.removeAttribute('id');
    clone = $(productContainer).clone();
    productContainer.setAttribute('id', productContainerId);
    resetAddons(productContainer);
    resetRemarks(productContainer);
    let newOrdered = document.getElementById(randomId);
    clone.appendTo(newOrdered);
    resetTotal();
    setMinToZero(newOrdered);
    showHtmlQuantity(populateShoppingCart(randomId), true, true);
}

function checkoutHtmlHeader(orderContainer, randomId, element) {
    let htmlCheckout = '';
    // htmlCheckout +=  '<div id="' + randomId + '" class="orderedProducts ' + element.dataset.productId + '" style="margin-bottom: 30px; padding-left:0px; position:relative; top:50px">';
    htmlCheckout +=  '<div id="' + randomId + '" class="orderedProducts ' + element.dataset.productId + '" >';
    htmlCheckout +=      '<div class="alert alert-dismissible" style="padding-left: 0px; margin-bottom: 10px;">';
    htmlCheckout +=          '<a href="javascript:void(0)" onclick="removeOrdered(\'' + randomId + '\')" class="close removeOrdered_' + element.dataset.productId + '" data-dismiss="alert" aria-label="close">&times;</a>';
    htmlCheckout +=          '<h4 class="productName">' + element.dataset.productName + ' (&euro;' + element.dataset.productPrice + ')';
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
    // let html = '';
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

    // html += '<div class="shopping-cart__single-item ' + randomId + '" data-ordered-id="' + randomId + '">';
    // html +=     '<div class="shopping-cart__single-item__details">';
    // html +=         '<p style="text-align:left">';
    // html +=             '<span class="shopping-cart__single-item__quantity">' + product.value + '</span>';
    // html +=             ' x ';
    // html +=             '<span class="shopping-cart__single-item__name">' + product.dataset.name + '</span>';
    // html +=         '</p>';
    // html +=         '<p class="shopping-cart__single-item__additional"  style="text-align:left">' + aditionalList.join(', ') + '</p>';
    // html +=         '<p>&euro; <span class="shopping-cart__single-item__price">' + price.toFixed(2) +'</span></p>';
    // html +=     '</div>';
    // html +=     '<div class="shopping-cart__single-item__remove" onclick="focusOnOrderItem(\'modal__checkout__list\', \'' + randomId + '\')">';
    // html +=         '<i class="fa fa-info-circle" aria-hidden="true"></i>';
    // html +=     '</div>';
    // html += '</div>';
    // data-toggle="modal" data-target="#checkout-modal"
    // $('#' + makeOrderGlobals.shoppingCartList).append(html);
    return product;
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
        product.value = '1';
    }
    for (i = 0; i < addonsLength; i++) {
        let addon = addons[i];
        addon.checked = false;

        let addonInput = addon.parentElement.parentElement.nextElementSibling.children[1];

        addonInput.min = addonInput.dataset.min;
        addonInput.max = addonInput.dataset.max;
        addonInput.value = '1';
        addonInput.step = '1';

        toggleElement(addon);
    }
}

function removeOrdered(elementId) {
    let inputField = document.querySelectorAll('#' + elementId + ' [data-order-quantity-value]');
    if (inputField) {
        inputField = inputField[0];
    }
    document.getElementById(elementId).remove();
    // document.querySelectorAll('#' + makeOrderGlobals.shoppingCartList + ' [data-ordered-id = "' + elementId + '"]')[0].remove();
    resetTotal();
    showHtmlQuantity(inputField, false, true);
    // alertify.success('Product removed from list');
}

function focusOnOrderItem(containerId, itemId) {
    $('#checkout-modal').modal('show');
    let items = document.getElementById(containerId).children;
    let itemsLength = items.length;
    if (itemsLength) {
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
}

function focusOnOrderItems(itemClass) {
    let checkoutModal = document.getElementById('checkout-modal');
    let items = checkoutModal.getElementsByClassName('orderedProducts');
    let itemsLength = items.length;

    if (itemsLength) {
        let showModal = false;        
        let i;
        for (i = 0; i < itemsLength; i++) {
            let item = items[i];
            if (item.classList.contains(itemClass)) {
                if (!showModal) {
                    $('#checkout-modal').modal('show');
                    showModal = true;
                }
                item.style.display = 'initial';
            } else {
                item.style.display = 'none';
            }
        }
        if (!showModal) {
            alertify.error('Product is not in order list!');
        }
    } else {
        alertify.error('No products in order list!');
        
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

function checkout(pos) {
    let send = prepareSendData(pos);
    if (!send) {
        alertify.error('No product(s) in order list');
        return;
    }
    let urlPart ='checkout_order?';
    sendOrderAjaxRequest(send, urlPart);
    return;
}

function sendOrderAjaxRequest(send, urlPart = '') {
    $.ajax({
        url: globalVariables.ajax + 'setOrderSession',
        data: send,
        type: 'POST',
        success: function (data) {
            let response = JSON.parse(data);            
            if (response['status'] === '1' || response === '1') {
                if (urlPart) {
                    window.location.href =  globalVariables.baseUrl + urlPart + makeOrderGlobals.orderDataGetKey + '=' + response['orderRandomKey'];
                }                
            } else {
                alertify.error('Process failed! Check order details')
            }
        },
        error: function (err) {
            console.dir(err);
        }
    });
}

function prepareSendData(pos) {
    let orderedProducts = document.getElementsByClassName(makeOrderGlobals.orderedProducts);
    let orderedProductsLength = orderedProducts.length;

    if (!orderedProductsLength) {
        return false;
    }

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
            'allergies': product.dataset.allergies,
            'categorySlide' : product.dataset.categorySlide,
            'print' : product.dataset.printed,
            'addons' : {}
        };
        
        if (product.dataset.allergies) {
            post[i][product.dataset.productExtendedId]['allergies']  = product.dataset.allergies;
        }

        if (product.dataset['remarkId'] !== '0') {
            let productRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-product-remark-id="' + product.dataset.remarkId + '"]')[0].value;
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
                        'addonProductId' : addon.dataset.addonProductId,
                        'allergies' : addon.dataset.allergies,
                        'productType' : addon.dataset.productType,
                        'isBoolean' : addon.dataset.isBoolean,
                        'allowedChoices' : addon.dataset.allowedChoices,
                        'addonTypeId' : addon.dataset.addonTypeId,
                        'print' : product.dataset.printed
                    }
                    if (addon.dataset['remarkId'] !== '0') {
                        let addonRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-addon-remark-id="' + addon.dataset.remarkId + '"]')[0].value;
                        post[i][product.dataset.productExtendedId]['addons'][addon.dataset.addonExtendedId]['remark'] = addonRemark;
                    }
                }
            }
        }
    }

    let send = {
        'data' : post,
        'vendorId' : makeOrderGlobals.vendorId,
        'spotId' : makeOrderGlobals.spotId,
        'orderDataRandomKey' : makeOrderGlobals.orderDataRandomKey,
        'pos' : pos,
    }
    if (makeOrderGlobals.openCategory) {
        send['openCategory'] = makeOrderGlobals.openCategory;
    }
    return send;
}


function resetRemarks(productContainer) {
    let remarks = productContainer.getElementsByClassName('remarks');
    let remarksLength = remarks.length;
    if (remarksLength) {
        let i;
        for (i = 0; i < remarksLength; i++) {
            let remark = remarks[i];
            remark.value = '';
        }
    }
}

function returnInteger(number) {
    return number ? parseInt(number) : 0;
}

function getLastNode(element) {
    let lastChild =  element.lastChild;
    if (lastChild.nodeType === 3) {
        return returnInteger(lastChild.nodeValue)
    } else {
        return getLastNode(lastChild);
    }
}

function showHtmlQuantity(inputField, increase, element) {
    let value = parseInt(inputField.value)
    if (inputField.dataset.orderQuantityValue) {
        let showQuantity = document.getElementById(inputField.dataset.orderQuantityValue);
        let showQuantityValue = getLastNode(showQuantity);
        if (increase) {
            if (value === 2) {
                inputField.setAttribute('min', '1');
            }
            if (element) {
                showQuantityValue += value;
            } else {
                showQuantityValue++;
            }
        } else {
            if (element) {
                showQuantityValue = showQuantityValue - value;
            } else {
                showQuantityValue--;
            }
        }
        showQuantity.innerHTML = showQuantityValue;
        return (showQuantityValue > 0) ? value : showQuantityValue;
    }
    return;
}

function triggerModalClick(modalButtonId) {
    $('#' + modalButtonId).trigger('click');
}

function trigerRemoveOrderedClick(className) {
    let ordered = document.getElementsByClassName(className) 
    if (ordered.length) {
        $(ordered[0]).trigger('click')
    }
}

function countOrdered(countOrdered) {
    if (typeof makeOrderGlobals === 'undefined') return;
    let orderedProducts = document.getElementsByClassName(makeOrderGlobals.orderedProducts);
    if (orderedProducts && orderedProducts.length) {
        let searchOrdered =  document.getElementsByClassName(countOrdered);
        let searchOrderedLength  = searchOrdered.length;
        let i;
        for (i = 0; i < searchOrderedLength; i++) {
            let id =  searchOrdered[i].id;
            if (id) {
                let orderQuanities = document.querySelectorAll('[data-ordered="' + id + '"]');
                let orderQuanitiesLength = orderQuanities.length;
                if (orderQuanitiesLength) {
                    let j;
                    let value = 0;
                    for (j = 0; j < orderQuanitiesLength; j++) {
                        let orderedValue = parseInt(orderQuanities[j].value);
                        if (orderedValue) {
                            value += orderedValue;
                        }
                    }
                    if (value) {
                        searchOrdered[i].innerHTML = value;
                    }
                }
            }
        }
    }
}

function setMinToZero(newOrdered) {
    let inputs = newOrdered.getElementsByTagName('input');
    let inputsLength = inputs.length;
    let i;
    for (i = 0; i < inputsLength; i++) {
        let input = inputs[i];
        input.setAttribute('min', '0');
    }
    return;
}

function goToSlide(index) {
    let slider = $('.items-slider');
    slider[0].slick.slickGoTo(parseInt(index));
}

function checkCategoryCode(openKey, categoryId, categoryIndex)  {
    let url = globalVariables.ajax + 'checkCategoryCode';
    let post = {
        'openKey' : openKey,
        'categoryId' : categoryId,
        'categoryIndex' : categoryIndex,
        'vendorId' : makeOrderGlobals.vendorId,
        'spotId' : makeOrderGlobals.spotId,
    }

    sendAjaxPostRequest(post, url, 'checkCategoryCode', redirectToUnlcokCategory);
}

function redirectToUnlcokCategory(data) {
    console.dir(data);
    // redirectToNewLocation(url); orderDataGetKey
    let url = globalVariables.baseUrl + 'make_order';
    url += '?vendorid=' + data['vendorId'];
    url += '&spotid=' + data['spotId'];
    url += '&category=' + data['categoryIndex'];
    url += '&' + makeOrderGlobals.orderDataGetKey + '=' + data['randomKey'];

    window.location.href =  url;
}
