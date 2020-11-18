'use strict';
function showCategory(element, categoryId, categoriesClass) {
    let categories = document.getElementsByClassName(categoriesClass);
    let categoriesLength = categories.length;
    let i;
    for (i = 0; i < categoriesLength; i++) {
        let category = categories[i];			
        if (category.id !== categoryId) {
            let categoryButton = document.querySelector('[data-id="' + category.id + '"]');
            category.style.display = 'none';
            categoryButton.classList.remove(makeOrderGlobals.activeClass);
        } else {
            category.style.display = 'block';				
        }
    }
    element.classList.add(makeOrderGlobals.activeClass);
}


function posTriggerModalClick(modalButtonId) {
    triggerModalClick(modalButtonId);
}

function cancelPosOrder(orderDataRandomKey,) {
    if (orderDataRandomKey) {
        $('#confirmCancel').modal('show');
    } else {
        document.getElementById(makeOrderGlobals.modalCheckoutList).innerHTML = '';
        resetTotal();
    }
}

function deleteOrder(spotId, orderDataRandomKey) {
    window.location.href =  globalVariables.baseUrl + 'pos/delete/' + orderDataRandomKey + '/' +  spotId;
}


function holdOrder(spotId, saveNameId) {
    let saveName = document.getElementById(saveNameId).value;
    if (!saveName.trim()) {
        alertify.error('Order name is required');
    } else {
        let pos = 1;
        let urlPart ='pos?spotid=' + spotId + '&';
        let send = prepareSendData(pos);
        if (!send) {
            alertify.error('No product(s) in order list');
        }
        send['posOrder'] = {
            'saveName' : saveName,
            'spotId' : spotId
        }
        sendOrderAjaxRequest(send, urlPart);
    }
}

function posTriggerModalClick(modalButtonId) {
    triggerModalClick(modalButtonId);
    // setRemarkIds();
}

resetTotal();
countOrdered('countOrdered');

function setRemarkIds() {
    let container = document.getElementById(makeOrderGlobals.posMakeOrderId);
    let remarks = container.getElementsByClassName('remarks');
    let remarksLenght = remarks.length;
    let i;
    for (i = 0; i < remarksLenght; i++) {
        let remark = remarks[i];
        let remarkId = i + '_';
        if (!remark.id) {
            
            if (remark.dataset.productRemarkId) {
                remarkId += remark.dataset.productRemarkId;
            }
            if (remark.dataset.addonRemarkId) {
                remarkId = remark.dataset.addonRemarkId;
            }
            remark.id = remarkId;
            $(keyboardHtml(remarkId)).insertAfter(remark)
        }
    }
}

function keyboardHtml(targetId) {
    
    let keyboard =
        `<div
            class="virtual-keyboard-hook"
            data-target-id="${targetId}"
            data-keyboard-mapping="qwerty"
            style="text-align: center; font-size: 20px;"
        >
            <i class="fa fa-keyboard-o" aria-hidden="true"></i>
        </div>`;
    return keyboard;
}