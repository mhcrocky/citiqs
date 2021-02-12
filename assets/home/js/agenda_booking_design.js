'use strict';
/*Only needed for the controls*/
var phone = document.getElementById("phone_1"),
    iframe = document.getElementById("frame_1");

/*Events*/
document.getElementById("controls").addEventListener("change", function() {
    updateIframe();
});

document.getElementById("views").addEventListener("click", function(evt) {
    updateView(evt.target.value);
});

var popup_open = document.getElementById('iframe-popup-open');
var popup_close = document.getElementById('popup-close');
var popup_close_2 = document.getElementById('popup-close_2');
var iframe_popup = document.getElementById('iframe-popup');

popup_open.addEventListener('click', function() {
    iframe_popup.classList.add('show')
});

popup_close.addEventListener('click', function() {
    iframe_popup.classList.remove('show');
});

popup_close_2.addEventListener('click', function() {
    iframe_popup.classList.remove('show');
});

/*View*/
function updateView(view) {
    if (view) {
        phone.className = "phone view_" + view;
    }
}

/*Controls*/
function updateIframe() {
    iframe.src = document.getElementById("iframeURL").value;

    phone.style.width = document.getElementById("iframeWidth").value + "px";
    phone.style.height = document.getElementById("iframeHeight").value + "px";

    /*Idea by /u/aerosole*/
    document.getElementById("wrapper").style.perspective = (
        document.getElementById("iframePerspective").checked ? "1000px" : "none"
    );
}
updateIframe();


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
    let url = (form.id !== 'undefined') ? globalVariables + 'agenda_booking/saveDesign/' : globalVariables + 'agenda_booking/saveDesign/';
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

function iframeWidth(el){
    let width = $(el).val();
    console.log(width);
    $('#iframe-popup').width(width+'px');
}

function iframeHeight(el){
    let height = $(el).val();
    $('#iframe-popup').height(height);
    $('#iframe-popup').css('height', height+'px !important');
}

function changeThisIframe(widthId, heightId, iframeId) {
    let iframe  = $('#'+iframeId);
    let iframeSrc = designGlobals.iframe;
    let newIframe = '';
    
    let width   = $('#iframeThisWidth').val();
    let height  = $('#iframeThisHeight').val();
    console.log(width);
    console.log(height);
    newIframe += '<iframe frameborder="0" ';
    newIframe += 'style="width:' + width + 'px; height:' + height + 'px;" ';
    newIframe += 'src="' + iframeSrc + '"></iframe>';

    iframe.html(newIframe);
    console.log(newIframe);

}
// https://tiqs.com/alfred/places

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
})