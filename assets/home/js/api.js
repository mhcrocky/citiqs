'use stritc';

function actviateApiRequest(form) {
    let url = globalVariables.ajax + 'actviateApiRequest';
    sendFormAjaxRequest(form, url, 'actviateApiRequest', alertifyAjaxResponse)
    return false;
}

function updateApiName(element) {
    let post = {
        'name' : element.value.trim()
    };

    if (post['name'] && post['name'] !== element.dataset.name) {
        let url = globalVariables.ajax + 'updateApiName/' + element.dataset.id;
        sendAjaxPostRequest(post, url, 'updateApiName', alertifyAjaxResponse);
    }
}