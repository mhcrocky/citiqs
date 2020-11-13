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

function cancelPosOrder(orderDataRandomKey) {
    if (orderDataRandomKey) {
        $('#confirmCancel').modal('show');
    } else {
        document.getElementById(makeOrderGlobals.modalCheckoutList).innerHTML = '';
        resetTotal();
    }
}

function deleteOrder(orderDataRandomKey) {
    window.location.href =  globalVariables.baseUrl + 'pos/delete/' + orderDataRandomKey;
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

resetTotal();
countOrdered('countOrdered');
