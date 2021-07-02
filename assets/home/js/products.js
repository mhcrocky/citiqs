'use strict';
function updateProductSpotStatus(element) {
    let url = globalVariables.ajax + 'updateProductSpotStatus/' + element.dataset.spotProductId;
    let post = {
        'showInPublic' : element.value,
    }
    sendAjaxPostRequest(post, url, 'updateProductSpotStatus');
}

function redirect(element) {
    if (element.value !== window.location.href) {
        window.location.href = element.value;
    }
}

function showDay(element, day) {
    if (element.checked) {
        document.getElementById(day).style.display = "initial";
    } else {
        document.getElementById(day).style.display = "none";
    }
}

function addTimePeriod(timeDiv, day) {
    let element = '';
    element +=  '<div>';
    element +=      '<label>From: ';
    element +=          '<input type="time" name="productTime[' + day + '][from][]" />';
    element +=      '</label>';
    element +=      '<label>To: ';
    element +=          '<input type="time" name="productTime[' + day + '][to][]" />';
    element +=      '</label>';
    element +=      '<span class="fa-stack fa-2x" onclick="removeParent(this)">';
    element +=          '<i class="fa fa-times"></i>';
    element +=      '</span>';
    element +=  '</div>';
    $( "#" + timeDiv).append(element);
}

function populateClassElements(className, string) {
    let elements = document.getElementsByClassName(className);
    let elementsLenght = elements.length;
    let element;
    let i;
    for (i = 0; i < elementsLenght; i++ ) {
        element = elements[i];
        element.innerHTML = string;
        if (element.dataset.addons) {
            let addons = element.dataset.addons.split(',');
            let elementChildren = element.children;
            let childrenLength = elementChildren.length;
            let j;
            for (j = 0; j < childrenLength; j++) {
                let child = elementChildren[j];
                let inputAddon = child.children[0].children[0];
                let inputAddonExtende = inputAddon.dataset.extendedId;
                if (addons.includes(inputAddonExtende)) {
                    let productId = element.dataset.productId;
                    inputAddon.checked = true;
                    child.children[1].children[0].value = productGloabls[productId][inputAddonExtende];
                }
            }
        }
    }
}


function deleteProduct(productId, productName) {
    let message = 'Are you sure you want delete product "' + productName + '" ?' ;
    alertify.confirm(
        message,
        '',
        function(){
            let url = globalVariables.baseUrl + 'warehouse/editProduct/'  + productId + '/1?delete=1';
            window.location.href = url;
        },
        function(){
            alertify.error('Cancel')
        }
    );
}

function downloadPricelist() {
    let url = globalVariables.ajax + 'downloadPriceList';

    sendGetRequest(url, downloadPricelistCallback);
}

function downloadPricelistCallback(response) {
    alertifyAjaxResponse(response);
    if (response['status'] === '1') {
        // window.open(response['csvFile'], '_blank').focus();
        window.open(response['csvFile'], '_blank');
    }
}

$(document).ready(function(){
    $('.productTimePickers').datetimepicker({
        dayOfWeekStart : 1,
    });

    $.ajax({
        url: globalVariables.ajax  + 'getAddonsList/',
        type: 'GET',
        success: function (response) {
            populateClassElements('addOns', response);
        }
    });
});
