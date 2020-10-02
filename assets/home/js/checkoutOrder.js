'use strict';
function changeQuantity(plus, price, quantityId, amountId, serviceFeeId, totalAmountId, orderExtendedId, productExId, serviceFeePercent, serviceFeeAmount, mainExtendedId = null) {
    let quantityElement = document.getElementById(quantityId);
    let quantityElementValue = parseInt(quantityElement.innerHTML);

    let amountElement = document.getElementById(amountId);
    let amountElementValue = parseFloat(amountElement.innerHTML.replace(',','.'));

    let orderExtendedInput = document.getElementById(orderExtendedId);
    let orderExtendedInputValue = parseInt(orderExtendedInput.value);
    
    let newQuantity;
    let newPrice;
    let newQuantityValue;

    if (plus) {
        newQuantity = quantityElementValue + 1;
        newPrice = (amountElementValue + price);
        newQuantityValue = orderExtendedInputValue + 1;

        quantityElement.innerHTML = newQuantity;
        amountElement.innerHTML = newPrice.toFixed(2);
        orderExtendedInput.setAttribute('value', newQuantityValue);
        orderExtendedInput.disabled = (newQuantityValue === 0) ? true : false;

        changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId, serviceFeePercent, serviceFeeAmount);
        ajaxUpdateSession(productExId, newPrice, newQuantityValue, mainExtendedId);
    }

    if (!plus && quantityElementValue > 0 && amountElementValue > 0) {
        newQuantity = quantityElementValue - 1;
        newPrice = (amountElementValue - price);
        newQuantityValue = orderExtendedInputValue - 1;

        quantityElement.innerHTML = newQuantity;
        amountElement.innerHTML = newPrice.toFixed(2);
        orderExtendedInput.setAttribute('value', newQuantityValue);
        orderExtendedInput.disabled = (newQuantityValue === 0) ? true : false;

        changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId, serviceFeePercent, serviceFeeAmount);
        
        ajaxUpdateSession(productExId, newPrice, newQuantityValue, mainExtendedId);
    }

    
}

function ajaxUpdateSession(productExId, newPrice = null, newQuantityValue = null, mainExtendedId) {
    let post = {
        'productExId' : productExId,
    }
    if (mainExtendedId) {
        post['mainExtendedId'] = mainExtendedId;
    }

    if (newPrice && newQuantityValue)  {
        post['newPrice'] = newPrice;
        post['newQuantityValue'] = newQuantityValue;
    }
    let url = globalVariables.ajax + 'ajaxUpdateSession';

    sendAjaxPostRequest(post, url, 'ajaxUpdateSession');
}

function changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId, serviceFeePercent, serviceFeeAmount) {
    let serviceFee = document.getElementById(serviceFeeId);
    let serviceFeeValue = parseFloat(serviceFee.innerHTML);

    let totalAmount = document.getElementById(totalAmountId);
    let totalAmountValue = parseFloat(totalAmount.innerHTML);

    let amount = totalAmountValue - serviceFeeValue;
    if (plus) {
        amount = amount + price;
    } else {
        amount = amount - price;
    }

    serviceFeeValue = calcualteServiceFee(amount, serviceFeePercent, serviceFeeAmount);
    serviceFee.innerHTML = serviceFeeValue;

    totalAmountValue = amount + parseFloat(serviceFeeValue);
    totalAmount.innerHTML = totalAmountValue.toFixed(2);

    if (amount >= 0 && serviceFeeValue >= 0 ) {
        document.getElementById('serviceFeeInput').setAttribute('value', serviceFeeValue);
        document.getElementById('orderAmountInput').setAttribute('value', amount);
    }
}

function calcualteServiceFee(amount, serviceFeePercent, serviceFeeAmount) {
    let userAmount = parseFloat(serviceFeeAmount);
    let serviceFee = amount * parseFloat(serviceFeePercent) / 100  + checkoutOrdedGlobals.minimumOrderFee;
    if (serviceFee > userAmount) {
        serviceFee = userAmount;
    }

    if (serviceFee === checkoutOrdedGlobals.minimumOrderFee) {
        serviceFee = 0;

    }

    return serviceFee.toFixed(2);
}

function removeElement(thisElement) {
    let amountToRemove = parseFloat(document.getElementById(thisElement.dataset.amountId).innerHTML);
    let element = document.getElementById(thisElement.dataset.elementId);
    let chidrenClass = 'children_' + thisElement.dataset.elementId;
    let children = document.getElementsByClassName(chidrenClass);
    let childrenLength = children.length;
    let j;
    if (childrenLength > 0) {
        for (j = (childrenLength - 1); j >= 0; j--) {
            let child = children[j];
            child.click(child);
        }
    }
    element.remove();

    let counterElement;
    let counterElements = document.getElementsByClassName(thisElement.dataset.counterClass);
    let counterElementsLength = counterElements.length;
    let i;
    let count;

    for (i = 0; i < counterElementsLength; i++) {
        counterElement = counterElements[i];
        count = i + 1;
        counterElement.innerHTML = count + '.';
    }

    changeServiceFeeAndTotal(false, amountToRemove, thisElement.dataset.serviceFee, thisElement.dataset.totalAmount, thisElement.dataset.serviceFeePercent, thisElement.dataset.serviceFeeAmount);
    ajaxUpdateSession(thisElement.dataset.productExId);
    calculateTip();
}

function submitForm(formId, serviceFeeInputId, orderAmountInputId) {
    let serviceFee = parseFloat(document.getElementById(serviceFeeInputId).value);
    let orderTotal = parseFloat(document.getElementById(orderAmountInputId).value);
    if (serviceFee > 0 || orderTotal > 0 || checkoutOrdedGlobals.thGroup) {
        document.getElementById(formId).submit();
    }
}

function buyerSelectTime(value, containerDivId, inputElementId) {
    let div = document.getElementById(containerDivId);
    let input = document.getElementById(inputElementId);
    if (!value) {
        div.style.display = 'none';
        input.disabled = true;
    } else {
        div.style.display = 'initial';
        input.disabled = false;
        let times = value.split(' ');
        $('#' +  inputElementId).timepicker('destroy');
        returnTimePicker(inputElementId, times);
       
    }
    return;
    
}

function returnTimePicker(elementId, times) {
    $('#' + elementId).timepicker({
        'timeFormat' : 'HH:mm',
        'interval': 5,
        'minTime': times[1],
        'maxTime': times[2],
        'startTime': times[1],
        'defaultTime': times[1],
    });
}

//new vesrion
function changeQuantityAndPriceById(quantityId, type) {
    let quantityInput = document.getElementById(quantityId);
    changeQuantityAndPrice(quantityInput, type);
}

function changeQuantityAndPrice(quantityInputElement, type) {
    let quantityInput = quantityInputElement;
    let quantityElement = document.getElementById(quantityInput.dataset.quantityElementId);
    let priceElement = document.getElementById(quantityInput.dataset.priceElementId);
    let quantityInputNewValue;
    let newPrice = 0;

    if (type === '+')  {
        quantityInputNewValue = parseInt(quantityInput.value) + parseInt(quantityInput.step);
    } else if (type === '-') {
        quantityInputNewValue = parseInt(quantityInput.value) - parseInt(quantityInput.step);
    }

    if (
        quantityInput.dataset.productType === 'addon'
        && quantityInputNewValue >= parseInt(quantityInput.min)
        && quantityInputNewValue <= parseInt(quantityInput.max)
    ) {
        newPrice = quantityInputNewValue * parseFloat(quantityInput.dataset.price);
        quantityInput.setAttribute('value', quantityInputNewValue);
        quantityElement.innerHTML = quantityInputNewValue;
        priceElement.innerHTML = newPrice.toFixed(2);
        updateSessionOrderAddon(quantityInput);
    } else if (quantityInput.dataset.productType === 'main' && quantityInputNewValue >= parseInt(quantityInput.min)) {
        newPrice = quantityInputNewValue * parseFloat(quantityInput.dataset.price);
        quantityInput.setAttribute('value', quantityInputNewValue);
        quantityElement.innerHTML = quantityInputNewValue;
        priceElement.innerHTML = newPrice.toFixed(2);
        updateSessionOrderMainProduct(quantityInput);
        changeAddons(quantityInput.id, quantityInputNewValue)
    }

    calculateTotal(checkoutOrdedGlobals.calculateTotalClass);
    calculateTip();
}

function changeAddons(mainProductId, quantity) {
    let addons = document.querySelectorAll('[data-main-product-id="' + mainProductId + '"]');
    let addonsLenght = addons.length;
    let i;

    if (addonsLenght) {
        for (i = 0; i < addonsLenght; i++) {
            let addonInput = addons[i];


            let newStep = parseFloat(quantity);
            addonInput.setAttribute('step', newStep);

            let newMin =  parseInt(newStep) * parseInt(addonInput.dataset.initialMin);
            addonInput.setAttribute('min', newMin);

            let newMax = parseInt(newStep) * parseInt(addonInput.dataset.initialMax);
            addonInput.setAttribute('max', newMax);

            addonInput.setAttribute('value', newMin);

            document.getElementById(addonInput.dataset.quantityElementId).innerHTML = newMin;
            document.getElementById(addonInput.dataset.priceElementId).innerHTML = (newMin * parseFloat(addonInput.dataset.price)).toFixed(2);

            updateSessionOrderAddon(addonInput, mainProductId);
        }
    }
}

function calculateTotal(className) {
    let totalOrders = 0;
    let serviceFee = 0;
    let total = 0;
    let totalInputs = document.getElementsByClassName(className);
    let totalInputsLength = totalInputs.length;
    let i;

    for (i = 0; i < totalInputsLength; i++) {
        let input = totalInputs[i];
        totalOrders += parseFloat(input.value) * parseFloat(input.dataset.price);
    }

    serviceFee = totalOrders * checkoutOrdedGlobals.serviceFeePercent / 100 + checkoutOrdedGlobals.minimumOrderFee;
    if (serviceFee > checkoutOrdedGlobals.serviceFeeAmount) {
        serviceFee = checkoutOrdedGlobals.serviceFeeAmount;
    }

    total = (totalOrders + serviceFee).toFixed(2);
    serviceFee = serviceFee.toFixed(2);

    document.getElementById(checkoutOrdedGlobals.serviceFeeSpanId).innerHTML = serviceFee + '&nbsp;&euro;';
    document.getElementById(checkoutOrdedGlobals.totalAmountSpanId).innerHTML = total + '&nbsp;&euro;';
    document.getElementById(checkoutOrdedGlobals.serviceFeeInputId).setAttribute('value', serviceFee);
    document.getElementById(checkoutOrdedGlobals.orderAmountInputId).setAttribute('value', totalOrders);
}

function unsetSessionOrderElement(dataset) {
    let url = globalVariables.ajax + 'unsetSessionOrderElement';
    let post = {
        'orderSessionIndex' : dataset.orderSessionIndex
    };
    if (dataset.addonExtendedId && dataset.productExtendedId) {
        post['addonExtendedId'] = dataset.addonExtendedId;
        post['productExtendedId'] = dataset.productExtendedId;
    }
    sendAjaxPostRequest(post, url, 'unsetSessionOrderElement', removeOrderElements, [dataset]);
}

function removeOrderElements(data) {
    if (data.class) {
        $('.' + data.class).remove();
    } else if (data.addonId) {
        document.getElementById(data.addonId).remove();
    }
    calculateTotal(checkoutOrdedGlobals.calculateTotalClass);
    setNewOrder();
    calculateTip();
}

function setNewOrder() {
    let products = document.getElementsByClassName('productCount');
    let productsLength = products.length;
    let i;
    if (productsLength) {
        for (i = 0; i < productsLength; i++) {
            let product = products[i];
            product.innerHTML = (i + 1);
        }
    }
}

function updateSessionOrderAddon(element, isMainChild = false) {
    let url = globalVariables.ajax + 'updateSessionOrderAddon';
    let amount = (parseInt(element.value) * parseFloat(element.dataset.price)).toFixed(2);
    let mainProductQuantity = isMainChild ? document.getElementById(isMainChild).value : '0';

    let post = {
        'orderSessionIndex' : element.dataset.orderSessionIndex,
        'quantity' : element.value,
        'amount' : amount,
        'addonExtendedId': element.dataset.addonExtendedId,
        'productExtendedId': element.dataset.productExtendedId,
        'initialMin': element.dataset.initialMin,
        'initialMax': element.dataset.initialMax,
        'mainProductQuantity' : mainProductQuantity
    };

    sendAjaxPostRequest(post, url, 'updateSessionOrderAddon');
}

function updateSessionRemarkAddon(element) {
    let url = globalVariables.ajax + 'updateSessionOrderAddon';
    let post = {
        'orderSessionIndex' : element.dataset.orderSessionIndex,
        'addonExtendedId': element.dataset.addonExtendedId,
        'productExtendedId': element.dataset.productExtendedId,
        'remark' : element.value,
    };

    sendAjaxPostRequest(post, url, 'updateSessionOrderAddon');
}

function updateSessionOrderMainProduct(element) {
    let url = globalVariables.ajax + 'updateSessionOrderMainProduct';
    let amount = (parseInt(element.value) * parseFloat(element.dataset.price)).toFixed(2);
    let post = {
        'orderSessionIndex' : element.dataset.orderSessionIndex,
        'productExtendedId' : element.dataset.productExtendedId,
        'quantity' : element.value,
        'amount' : amount,
    };

    sendAjaxPostRequest(post, url, 'updateSessionOrderMainProduct');
}

function updateSessionRemarkMainProduct(element) {
    let url = globalVariables.ajax + 'updateSessionOrderMainProduct';
    let post = {
        'orderSessionIndex' : element.dataset.orderSessionIndex,
        'productExtendedId' : element.dataset.productExtendedId,
        'remark' : element.value,
    };

    sendAjaxPostRequest(post, url, 'updateSessionOrderMainProduct');
}

function checkUserNewsLetter(emailInputId) {
    let email = document.getElementById(emailInputId);
    if(!email) return;
    email = email.value;
    if (email.includes('@')) {
        let emailParts = email.split('@');
        if (!emailParts[1].includes('.')) return;
        let post = {
            'email' : email
        }
        let url = globalVariables.ajax + 'checkUserNewsLetter';
        sendAjaxPostRequest(post, url, 'checkUserNewsLetter', setNewsletterRadioButtons);
    }
}

function setNewsletterRadioButtons(newsLetter) {
    let newsLetterYes = document.getElementById('newsLetterYes');
    let newsLetterNo = document.getElementById('newsLetterNo');
    if (newsLetterYes && newsLetterNo) {
        newsLetterYes.checked = newsLetter
        newsLetterNo.checked = !newsLetter
    }
}

function toogleDisable(element, id) {
    let checked = element.checked
    let waiterTip = document.getElementById(id);
    if (checked) {
        waiterTip.disabled = false;
        waiterTip.hidden = false;
        waiterTip.classList.add("form-control");
    } else {
        waiterTip.disabled = true;
        waiterTip.hidden = true;
        waiterTip.classList.remove("form-control");
    }
    return;
}

function addTip(waiterTip) {
    let tip = parseFloat(waiterTip.value);
    if (tip >= 0) {
        let orderValue = document.getElementById('orderAmountInput').value;
        let serviceFeeValue = document.getElementById('serviceFeeInput').value;
        let totalWithTip = tip + parseFloat(orderValue) + parseFloat(serviceFeeValue);
        document.getElementById('totalWithTip').value = totalWithTip.toFixed(2);
    }
}

function addTotalWithTip(totalWithTip) {
    let totalWithTipValue = parseFloat(totalWithTip.value);
    let min = parseFloat(totalWithTip.min);
    if (totalWithTipValue > min) {    
        let tip = totalWithTipValue - min;        
        document.getElementById('waiterTip').value = tip.toFixed(2);
    } else {
        document.getElementById('waiterTip').value = 0;
    }
}

function checkValue(totalWithtip) {
    let min = parseFloat(totalWithtip.min);
    let value = parseFloat(totalWithtip.value);
    if (min > value) {
        totalWithtip.value = min;
    } else {
        totalWithtip.value = value.toFixed(2);
    }
}


function redirectToMakeOrder(url) {
    window.location.href = url;
}

function calculateTip() {
    let totalWithTip = document.getElementById('totalWithTip');
    
    if (totalWithTip) {
        let orderValue = parseFloat(document.getElementById('orderAmountInput').value);
        let serviceFeeValue = parseFloat(document.getElementById('serviceFeeInput').value);
        let waiterTip = parseFloat(document.getElementById('waiterTip').value);

        let newMin = orderValue + serviceFeeValue;
        let newValue = waiterTip + newMin;

        totalWithTip.min = newMin.toFixed(2);
        totalWithTip.value = newValue.toFixed(2);
    }    
}

checkUserNewsLetter('emailAddressInput');
