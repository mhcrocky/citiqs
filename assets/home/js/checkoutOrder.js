'use strict';
function changeQuantity(plus, price, quantityId, amountId, serviceFeeId, totalAmountId, orderExtendedId, productExId) {
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

        changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId);
        ajaxUpdateSession(productExId, newPrice, newQuantityValue);
    }

    if (!plus && quantityElementValue > 0 && amountElementValue > 0) {
        newQuantity = quantityElementValue - 1;
        newPrice = (amountElementValue - price);
        newQuantityValue = orderExtendedInputValue - 1;

        quantityElement.innerHTML = newQuantity;
        amountElement.innerHTML = newPrice.toFixed(2);
        orderExtendedInput.setAttribute('value', newQuantityValue);
        orderExtendedInput.disabled = (newQuantityValue === 0) ? true : false;

        changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId);
        ajaxUpdateSession(productExId, newPrice, newQuantityValue);
    }

    
}

function ajaxUpdateSession(productExId, newPrice = null, newQuantityValue = null) {
    let post = {
        'productExId' : productExId,
    }

    if (newPrice && newQuantityValue)  {
        post['newPrice'] = newPrice;
        post['newQuantityValue'] = newQuantityValue;
    }
    let url = globalVariables.ajax + 'ajaxUpdateSession';

    sendAjaxPostRequest(post, url, 'ajaxUpdateSession');
}


function changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId) {
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

    serviceFeeValue = calcualteServiceFee(amount);
    serviceFee.innerHTML = serviceFeeValue;

    totalAmountValue = amount + parseFloat(serviceFeeValue);
    totalAmount.innerHTML = totalAmountValue.toFixed(2);

    if (amount >= 0 && serviceFeeValue >= 0 ) {
        document.getElementById('serviceFeeInput').setAttribute('value', serviceFeeValue);
        document.getElementById('orderAmountInput').setAttribute('value', amount);
    }
}

function calcualteServiceFee(amount) {
    let serviceFee = amount * 0.045;
    if (serviceFee > 3.50) {
        serviceFee = 3.50;
    }
    return serviceFee.toFixed(2);
}

function removeElement(elementId, counterClass, amountId, serviceFee, totalAmount, productExId) {
    let amountToRemove = parseFloat(document.getElementById(amountId).innerHTML)
    let element = document.getElementById(elementId);
    element.remove();

    let counterElement;
    let counterElements = document.getElementsByClassName(counterClass);
    let counterElementsLength = counterElements.length;
    let i;
    let count;

    for (i = 0; i < counterElementsLength; i++) {
        counterElement = counterElements[i];
        count = i + 1;
        counterElement.innerHTML = count + '.';
    }

    changeServiceFeeAndTotal(false, amountToRemove, serviceFee, totalAmount);
    ajaxUpdateSession(productExId);
}

function submitForm(formId, serviceFeeInputId, orderAmountInputId) {
    let serviceFee = parseFloat(document.getElementById(serviceFeeInputId).value);
    let orderTotal = parseFloat(document.getElementById(orderAmountInputId).value);

    if (serviceFee > 0 && orderTotal > 0 ) {
        document.getElementById(formId).submit();
    }
}