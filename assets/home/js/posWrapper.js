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