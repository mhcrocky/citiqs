'use strict';
function styleELements(element) {
    let selector = getJquerySelector(element.dataset.cssSelector, element.dataset.cssSelectorValue);
    let property = element.dataset.cssProperty;
    let value = element.value;
    let iframeElements = $('iframe').contents().find(selector);
    if (iframeElements) {
        element.setAttribute('data-value', '1');
        let iframeElementsLength = iframeElements.length;
        let i;
        for (i = 0; i < iframeElementsLength; i++) {
            let iframeElement = iframeElements[i];
            if (selector === '.slick-arrow') {
                console.dir($('iframe').contents().find('head')[0]);
                let head = $('iframe').contents().find('head')[0];
                $(head).append('<style>.slick-arrow:before{color:' + value +' !important}</style>');
            } else {
                iframeElement.style.setProperty(property, value, 'important');
            }
        }
    }

}

function getJquerySelector(selector, selectorValue) {
    let jQuerySelector;
    if (selector === 'class') {
        jQuerySelector = '.' + selectorValue;
    } else if (selector === 'id') {
        jQuerySelector = '#' + selectorValue;
    }
    return jQuerySelector;
}

function showViewSettings(filedsetId) {
    if (!filedsetId) return;
    let fieldsets = document.getElementsByTagName('fieldset');
    let fieldsetsLength = fieldsets.length;
    let i;
    for (i = 0; i < fieldsetsLength; i++) {
        let fieldset = fieldsets[i];
        if (fieldset.id === filedsetId) {
            fieldset.classList.add(designGlobals.showClass);
            fieldset.classList.remove(designGlobals.hideClass);            
        } else {
            fieldset.classList.add(designGlobals.hideClass);
            fieldset.classList.remove(designGlobals.showClass);
        }
    }
}

/**
 * src https://gist.github.com/hdodov/a87c097216718655ead6cf2969b0dcfa
 */
function iframeURLChange(iframe, callback) {
    var lastDispatched = null;

    var dispatchChange = function () {
        var newHref = iframe.contentWindow.location.href;

        if (newHref !== lastDispatched) {
            callback(newHref);
            lastDispatched = newHref;
        }
    };

    var unloadHandler = function () {
        // Timeout needed because the URL changes immediately after
        // the `unload` event is dispatched.
        setTimeout(dispatchChange, 0);
    };

    function attachUnload() {
        // Remove the unloadHandler in case it was already attached.
        // Otherwise, there will be two handlers, which is unnecessary.
        iframe.contentWindow.removeEventListener("unload", unloadHandler);
        iframe.contentWindow.addEventListener("unload", unloadHandler);
    }

    iframe.addEventListener("load", function () {
        attachUnload();
        // Just in case the change wasn't dispatched during the unload event...
        dispatchChange();
    });
    attachUnload();
}

function saveDesign(form) {
    let url = globalVariables.ajax + 'saveDesign/' + form.id;
    sendFormAjaxRequest(form, url, 'saveDesign', alertifyMessage)
    return false;
}

function alertifyMessage(response) {
    if (response.status === '1') { 
        alertify.success(response.message);
    } else if (response.status === '0') { 
        alertify.error(response.message);
    }
}

function setDesign() {
    let activeFieldset = document.getElementsByClassName(designGlobals.showClass);
    if (activeFieldset) {
        activeFieldset = activeFieldset[0];
        let inputs = activeFieldset.querySelectorAll('[data-value="1"]');
        let inputsLength = inputs.length;
        let i;
        for (i = 0; i < inputsLength; i++) {
            let input = inputs[i];
            styleELements(input);
        }
    }   
}

var designGlobals = (function() {
    let globals = {
        'iframeId' : 'iframe',
        'showClass' : 'showFieldsets',
        'hideClass' : 'hideFieldsets',
        'selectTypeView' : 'selectTypeView',
        'closed' : 'closed',
        'selectSpotView' : 'selectSpotView',
        'selectedSpotView' : 'selectedSpotView',
        'checkoutOrderView' : 'checkoutOrderView',
        'buyerDetailsView' : 'buyerDetailsView',
        'payOrderView' : 'payOrderView',
        'checkUrl' : function (url) {
                        if (url.includes('make_order?vendorid=') && !url.includes('&typeId=') && !url.includes('&spotid=')) {
                            return this['selectTypeView']
                        }
                        if (url.includes('closed')) {
                            console.dir(url);
                            return this['closed']
                        }
                        if (url.includes('make_order?vendorid=') && url.includes('&typeId=') && !url.includes('&spotid=')) {
                            return this['selectSpotView']
                        }
                        if (url.includes('make_order?vendorid=') && !url.includes('&typeId=') && url.includes('&spotid=')) {
                            return this['selectedSpotView']
                        }
                        if (url.includes('checkout_order?order=')) {
                            return this['checkoutOrderView']
                        }
                        if (url.includes('buyer_details?order=')) {
                            return this['buyerDetailsView']
                        }
                        if (url.includes('pay_order?order=')) {
                            return this['payOrderView']
                        }
                        return false;
                    }
    }
    return globals;
}());

$(document).ready(function(){
    let iframe = document.getElementById(designGlobals.iframeId);
    iframeURLChange(iframe, function (newURL) {
        showViewSettings(designGlobals.checkUrl(newURL));
    });

    iframe.onload = function () {
        setDesign();
    }
})
