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
