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
    let addons;
    for (i = 0; i < elementsLenght; i++ ) {
        element = elements[i];
        element.innerHTML = string;
        if (element.dataset.addons) {
            addons = element.dataset.addons.split(',');
            let elementChildren = element.children;
            let childrenLength = elementChildren.length;
            let j;
            for (j = 0; j < childrenLength; j++) {
                let child;
                let input;
                child = elementChildren[j];
                input = child.children[0];
                if (addons.includes(input.dataset.extendedId)) {
                    input.checked = true;
                }
            }
        }
    }
}


function toogleProducts(elementl) {
    let allProducts = document.getElements
    let selected = element.selectedOptions;
    let selectedLength = selected.length;
    let j;
    let selectedNames = [];
    for (j = 0; j < selectedLength; j++) {
        selectedIds.push(selected[j].value);
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
