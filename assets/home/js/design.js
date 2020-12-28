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
    let url = (form.id !== 'undefined') ? globalVariables.ajax + 'saveDesign/' + form.id : globalVariables.ajax + 'saveDesign/';
    sendFormAjaxRequest(form, url, 'saveDesign', alertifyMessage)
    return false;
}

function alertifyMessage(response) {
    if (response.status === '1') { 
        if (!response.designId) {
            alertify.success(response.message);
        } else {
            let newLocation = 'viewdesign?designid=' + response.designId;
            redirectToNewLocation(newLocation);
        }
    } else if (response.status === '0') { 
        let i = 0;
        let messages = response.message;
        let messagesLength = messages.length;
        for (i = 0; i < messagesLength; i++) {
            alertify.error(messages[i]);
        }
        
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

function copyToClipboard(id) {
    /* Get the text field */
    var copyText = document.getElementById(id);
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/
    /* Copy the text inside the text field */
    document.execCommand("copy");
    /* Alert the copied text */
    alert(copyText.value);
}

function changeIframe(widthId, heightId, iframeId, selectedSpotId, categorySortNumberId, categoryConatinerId) {
    let iframe  = document.getElementById(iframeId);
    let iframeSrc = designGlobals.iframe;
    let newIframe = '';
    let width   = document.getElementById(widthId).value;
    let height  = document.getElementById(heightId).value;
    let spotId =  document.getElementById(selectedSpotId).value;
    let categoryConatiner = document.getElementById(categoryConatinerId);
    

    if (spotId) {
        categoryConatiner.style.display = 'inline-block';
        let categorySortNumber = document.getElementById(categorySortNumberId).value;
        iframeSrc = iframeSrc  + spotId + categorySortNumber;
    } else {
        categoryConatiner.style.display = 'none';
    }

    newIframe += '<iframe frameborder="0" ';
    newIframe += 'style="width:' + width + 'px; height:' + height + 'px;" ';
    newIframe += 'src="' + iframeSrc + '"></iframe>';

    iframe.value = newIframe;

    // saveIrame(width.value, height.value, newIframe)
}

function saveIrame(width, height, iframe) {
    let url = globalVariables.ajax + 'saveIrame/' + designGlobals.id;
    let post = {
        'width' : width,
        'height' : height,
        'iframe' : iframe
    }    
    sendAjaxPostRequest(post, url, 'saveIrame');
}

function updateView(view) {
    if (view) {
        designGlobals.phone.className = "phone view_" + view;
    }
}

/*Controls*/
function updateIframe() {
    let iframeWidthValue = document.getElementById(designGlobals.iframeWidthId).value;
    let iframeHeightValue = document.getElementById(designGlobals.iframeHeightId).value;

    designGlobals.phone.style.width = iframeWidthValue + 'px';
    designGlobals.phone.style.height = iframeHeightValue + 'px';

    /*Idea by /u/aerosole*/
    document.getElementById("wrapper").style.perspective = (
        document.getElementById("iframePerspective").checked ? "1000px" : "none"
    );
}

function screen(width, height) {
    $('#' + designGlobals.iframeWidthId).val(width);
    $('#' + designGlobals.iframeHeightId).val(height);
    updateIframe();
}

$(document).ready(function(){
    let iframe = document.getElementById(designGlobals.iframeId);
    if (iframe) {
        iframeURLChange(iframe, function (newURL) {
            showViewSettings(designGlobals.checkUrl(newURL));
        });
    
        iframe.onload = function () {
            setDesign();
        }
    }

    $('#device').on('change', function() {
        let device = $("#device option:selected").val();
        let px = device.split('x');
        screen(px[0], px[1]);
    });
})

/*Events*/
document.getElementById("controls").addEventListener("change", function() {
    updateIframe();
});

document.getElementById("views").addEventListener("click", function(evt) {
    updateView(evt.target.value);
});

updateIframe();