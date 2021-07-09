'use strict';
function redirect(element) {
    if (element.value !== window.location.href) {
        window.location.href = element.value;
    }
}
$(document).ready(function(){
    $("#sortableCategories").sortable({
        update: function(event,ui) {
            updateCategoriesOrder('listCategories');

        }
    });
});

function updateCategoriesOrder(listCategories) {
    let categories = document.getElementsByClassName(listCategories);
    let categoriesLength = categories.length;
    let i;
    let category;
    let post = {};
    let url = globalVariables.ajax + 'updateCategoriesOrder';

    for (i = 0; i < categoriesLength; i++) {
        category = categories[i];
        post[category.dataset.categoryId] = i + 1;
    }

    sendAjaxPostRequest(post, url, 'updateCategoriesOrder');
}

function generateCategoryKey(venodrId, className) {
    let post = {
        'venodrId' : venodrId
    }
    let url = globalVariables.ajax + 'generateCategoryKey';
    sendAjaxPostRequest(post, url, 'generateCategoryKey', displayOpenKey, [className]);
}

function displayOpenKey(className, response) {

    let elements = document.getElementsByClassName(className);
    let elementsLength = elements.length;
    let i;
    for (i = 0; i < elementsLength; i++) {
        let element = elements[i];
        element.innerHTML = 'Category key: ' + response.key;
    }
    alertify.success('Key created');
    return;
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
    element +=  '<div>';``
    element +=      '<label>From: ';
    element +=          '<input type="time" name="categoryTime[' + day + '][from][]" />';
    element +=      '</label>';
    element +=      '<label>To: ';
    element +=          '<input type="time" name="categoryTime[' + day + '][to][]" />';
    element +=      '</label>';
    element +=      '<span class="fa-stack fa-2x" onclick="removeParent(this)">';
    element +=          '<i class="fa fa-times"></i>';
    element +=      '</span>';
    element +=  '</div>';
    $( "#" + timeDiv).append(element);
}

$(document).ready(function(){
    $('input.timepicker').timepicker({
        'timeFormat' : 'HH:mm',
        'interval' : '5'
    });
});
