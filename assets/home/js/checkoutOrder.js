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

function submitForm() {
    let serviceFee = parseFloat(document.getElementById(checkoutOrdedGlobals.serviceFeeInputId).value);
    let orderTotal = parseFloat(document.getElementById(checkoutOrdedGlobals.orderAmountInputId).value);
    let errors = 0;
    if (serviceFee > 0 || orderTotal > 0 || checkoutOrdedGlobals.thGroup) {
        if (!checkPrivacyAndTerms()) {
            errors++;
        }
        if (!checkDeliveryLocation()) {
            errors++;
        }
        if (errors === 0) {
            let url =  globalVariables.ajax + 'submitForm';
            let form = document.getElementById(checkoutOrdedGlobals.formId);
            sendFormAjaxRequest(form, url, 'submitForm', redirectSubmit);
        }
    } else {
        alertify.error('No products in order list!');
    }
    return false;
}

function redirectSubmit(data) {
    if (data.status === '0') {
        if (data.message) {
            alertify.error(data.message);
        }
        if (data.pickup) {
            if (data.pickup === '1') {
                $("#modalPickup").modal("show");
            } else if (data.pickup === '0') {
                $("#modalDelivery").modal("show");
            }
        }
        console.dir(data);
    } else {
        let url = globalVariables.baseUrl + data.message;
        window.location.href = url;
    }
}

function buyerSelectTime(value, containerDivId, inputElementId) {
    let div = document.getElementById(containerDivId);
    let input = document.getElementById(inputElementId);
    if (!value) {
        div.style.display = 'none';
        input.disabled = true;
    } else {
        div.style.display = 'block';
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
        'interval': checkoutOrdedGlobals.periodMinutes,
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
        'orderSessionIndex' : dataset.orderSessionIndex,
        'orderRandomKey' :checkoutOrdedGlobals.orderRandomKey
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
        'mainProductQuantity' : mainProductQuantity,
        'orderRandomKey' :checkoutOrdedGlobals.orderRandomKey
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
        'orderRandomKey' :checkoutOrdedGlobals.orderRandomKey
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
        'orderRandomKey' :checkoutOrdedGlobals.orderRandomKey
    };

    sendAjaxPostRequest(post, url, 'updateSessionOrderMainProduct');
}

function updateSessionRemarkMainProduct(element) {
    let url = globalVariables.ajax + 'updateSessionOrderMainProduct';
    let post = {
        'orderSessionIndex' : element.dataset.orderSessionIndex,
        'productExtendedId' : element.dataset.productExtendedId,
        'remark' : element.value,
        'orderRandomKey' :checkoutOrdedGlobals.orderRandomKey
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
    } else {
        waiterTip.value = '0';
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

function submitBuyerDetails() {
    if (checkUserData()) {
        let form = document.getElementById(buyerDetailsGlobals.formId);
        let url = globalVariables.ajax + 'submitBuyerDetails';
        sendFormAjaxRequest(form, url, 'submitBuyerDetails', managBuyerDetailsResponse);
    }
    return false;
}

function openOrderTimeDiv() {
    try {
        if (checkoutOrdedGlobals) {
            let period = document.getElementById(checkoutOrdedGlobals.periodTime);
            if (period) {
                let periodValue = period.value;
                buyerSelectTime(periodValue, checkoutOrdedGlobals.orderTimeDiv, checkoutOrdedGlobals.orderTimeInput);
                return;
            }
        }
    } catch(err) {
        return;
    }
}

function checkUserData() {
    return true;
    let email = document.getElementById(buyerDetailsGlobals.emailId);
    let name = document.getElementById(buyerDetailsGlobals.firstNameId);
    let mobile = document.getElementById(buyerDetailsGlobals.phoneId);
    let errors = 0;

    if (name) {
        if (!checkElementValue(name)) errors++;        
    }
    if (email) {
        if (!checkElementValue(email)) errors++;        
    }
    if (mobile) {
        if (!checkElementValue(mobile)) errors++;        
    }

    return (errors > 0) ? false : true;
}

function checkDeliveryLocation() {
    let city = document.getElementById(checkoutOrdedGlobals.cityId);
    let zipcode = document.getElementById(checkoutOrdedGlobals.zipcodeId);
    let address = document.getElementById(checkoutOrdedGlobals.addressId);
    let errors = 0;

    if (city && zipcode && address) {
        if (!checkElementValue(city)) errors++;
        if (!checkElementValue(zipcode)) errors++;
        if (!checkElementValue(address)) errors++;
        return (errors > 0) ? false : true;
    }
    return true;
}


function checkElementValue(element) {
    let elementValue = element.value;
    if (!elementValue.trim()) {
        let message = 'Order not made! ' + element.dataset.name + ' is required field'
        alertify.error(message);
        element.style.border = '1px solid #f00'
        return false;
    } else {
        element.style.border = '1px solid #ccc'
        return true;
    }
}

function checkPrivacyAndTerms() {
    let privacyPolicy = document.getElementById(checkoutOrdedGlobals.privacyPolicy);
    let termsAndConditions = document.getElementById(checkoutOrdedGlobals.termsAndConditions);
    let errors = 0;
    if (privacyPolicy && termsAndConditions)  {
        if (!termsAndConditions.checked) {
            alertify.error('Order not made. Please confirm that you read and accept the terms and conditions');
            errors++;
        }

        if (!privacyPolicy.checked) {
            alertify.error('Order not made. Please submit  that you took a notice of privacy policy');
            errors++;
        }

        return (errors > 0) ? false : true;
    }
    return true;
}

function managBuyerDetailsResponse(data) {
    if (data.status === '0') {
        let messages = data.messages;
        let messagesLength = messages.length;
        let i;
        for (i = 0; i < messagesLength; i++) {
            let message = messages[i];
            alertify.error(message)
        }
    } else if (data.status === '1') {
        let redirect = globalVariables.baseUrl + data.message;
        window.location.href = redirect;
    }
    return;
}

$(document).ready(function(){
    checkUserNewsLetter('emailAddressInput');
    openOrderTimeDiv();
    $('[data-toggle="popover"]').popover({
        animation : false,
        placement : "right",
        container: 'body'
    });
    $('[data-toggle="pickupPopover"]').popover({
        animation : false,
        placement : "bottom",
        container: 'body'
    });
    $('body').on('click', function (e) {
        $('[data-toggle="pickupPopover"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
});
