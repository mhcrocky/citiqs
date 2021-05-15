'use strict';

function sendReportPrintRequest(element) {
    let timePickkerId = element.dataset.timepickerId
    let timePickerValue = document.getElementById(timePickkerId).value;
    let url = globalVariables.ajax + 'sendReportPrintRequest';
    let times = timePickerValue.split(' - ');
    let post = {
        'dateTimeFrom' : times[0],
        'dateTimeTo' : times[1],
        'report': element.dataset.report
    }
 
    sendAjaxPostRequest(post, url, 'sendReportPrintRequest', alertifyReportsResponse);
}

function alertifyReportsResponse(response) {
    if (response.hasOwnProperty('printer')) {
        alertifyAjaxResponse(response['printer']);
    }
    if (response.hasOwnProperty('email')) {
        alertifyAjaxResponse(response['email']);
    }
}

function refundMoney(refundOrderId, totalAmountId, amountId, freeAmountId, descriptionId) {
    let amountEl = document.getElementById(amountId);
    let freeAmountEl = document.getElementById(freeAmountId);
    let orderId = document.getElementById(refundOrderId).value;
    let decription = document.getElementById(descriptionId).value;
    let totalAmountValue = parseFloat(document.getElementById(totalAmountId).value);
    let amountValue = getAmountValue(amountEl);
    let freeAmountValue = parseFloat(freeAmountEl.value);
    let refundAmount =  Math.abs(amountValue) + Math.abs(freeAmountValue);

    if (!validateAmount(amountValue, freeAmountValue, totalAmountValue, refundAmount)) {
        amountEl.style.border = '1px solid #f00';
        freeAmountEl.style.border = '1px solid #f00';
        return;
    }

    amountEl.style.border = 'initial';
    freeAmountEl.style.border = 'initial';

    let url = globalVariables.ajax + 'refundOrderMoney/' + orderId;
    let post = {
        'amount' : refundAmount,
        'decription' : decription
    }

    sendAjaxPostRequest(post, url, 'refundMoney', refundMoneyResponse, [amountEl, freeAmountEl]);
    return;
}

function refundMoneyResponse(amountEl, freeAmountEl, response) {
    alertifyAjaxResponse(response);
    amountEl.value = 0;
    freeAmountEl.value = 0;
}

function validateAmount(amountValue, freeAmountValue, totalAmountValue, refundAmount) {
    if (!amountValue && !freeAmountValue) {
        let message = 'Select free amount or amount';
        alertify.error(message);
        return false;
    }

    if (refundAmount > totalAmountValue) {
        let message = 'Refund amount can not be bigger than total order amount!';
        alertify.error(message);
        return false;
    }

    return true;
}

function getAmountValue(amountEl) {
    let amount = amountEl.value;
    amount = amount.replace('€', '');
    return amount ? parseFloat(amount) : 0;
}
