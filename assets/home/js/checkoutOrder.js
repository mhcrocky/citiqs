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
}

function submitForm(formId, serviceFeeInputId, orderAmountInputId) {
    let serviceFee = parseFloat(document.getElementById(serviceFeeInputId).value);
    let orderTotal = parseFloat(document.getElementById(orderAmountInputId).value);
    if (serviceFee > 0 || orderTotal > 0 ) {
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
        console.dir(times);
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
        'defaultTime': times[2],
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

    } else if (quantityInput.dataset.productType === 'main' && quantityInputNewValue >= parseInt(quantityInput.min)) {

        newPrice = quantityInputNewValue * parseFloat(quantityInput.dataset.price);
        quantityInput.setAttribute('value', quantityInputNewValue);
        quantityElement.innerHTML = quantityInputNewValue;
        priceElement.innerHTML = newPrice.toFixed(2);

        changeAddons(quantityInput.id, quantityInputNewValue)
    }
    
    calculateTotal(checkoutOrdedGlobals.calculateTotalClass);
}

function changeAddons(mainProductId, quantity) {
    let addons = document.querySelectorAll('[data-main-product-id=' + mainProductId + ']');
    let addonsLenght = addons.length;
    let i;

    if (addonsLenght) {
        for (i = 0; i < addonsLenght; i++) {
            let addonInput = addons[i];

            let newStep = quantity;
            addonInput.setAttribute('step', newStep);

            let newMin =  parseInt(newStep) * parseInt(addonInput.dataset.initialMin);
            addonInput.setAttribute('min', newMin);

            let newMax = parseInt(newStep) * parseInt(addonInput.dataset.initialMax);
            addonInput.setAttribute('max', newMax);

            let newValue = parseInt(newStep) * parseInt(addonInput.dataset.initialValue);
            addonInput.setAttribute('value', newValue);

            document.getElementById(addonInput.dataset.quantityElementId).innerHTML = newValue;
            document.getElementById(addonInput.dataset.priceElementId).innerHTML = (newValue * parseFloat(addonInput.dataset.price)).toFixed(2);
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

    document.getElementById(checkoutOrdedGlobals.serviceFeeSpanId).innerHTML = serviceFee;
    document.getElementById(checkoutOrdedGlobals.totalAmountSpanId).innerHTML = total;
    document.getElementById(checkoutOrdedGlobals.serviceFeeInputId).setAttribute('value', total);
    document.getElementById(checkoutOrdedGlobals.orderAmountInputId).setAttribute('value', serviceFee);
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
    console.dir(data);
    if (data.class) {
        $('.' + data.class).remove();
    } else if (data.addonId) {
        document.getElementById(data.addonId).remove();
    }
    calculateTotal(checkoutOrdedGlobals.calculateTotalClass);
}
