'use strict';

$(document).on("click", "#img-background", function() {
    var file = $(this).parents().find("#background-file");
    file.trigger("click");
});

$('#background-file').change(function(e) {
    var fileName = e.target.files[0].name;

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("background-preview").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});

$(document).on("click", "#background-img", function() {
    var file = $(this).parents().find("#background-image");
    file.trigger("click");
});

$('#background-image').change(function(e) {
    var fileName = e.target.files[0].name;

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("background-img-preview").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});


function imageUpload(el) {
    $('.img-thumbnail').attr('style', '');
    var img_name = el.files[0].name;
    if (img_name.length > 10) img_name = img_name.substring(0, 10) + '...';
    $('#img-background').hover(function() {
        $(this).attr('data-content', img_name);
    });

}

function backgroundImageUpload(el) {
    $('.img-thumbnail').attr('style', '');
    var img_name = el.files[0].name;
    if (img_name.length > 10) img_name = img_name.substring(0, 10) + '...';
    $('#background-img').hover(function() {
        $(this).attr('data-content', img_name);
    });

    $('#img_delete').val('0');
}

function confirmDelete(id){
  bootbox.confirm({
    message: "Are you sure?",
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
      if(result === false) return ;
      deleteBackgroundImage();
     }
});
}

function deleteBackgroundImage() {
    $('#img_delete').val('1');
    document.getElementById("background-img-preview").src = globalVariables.baseUrl + 'assets/images/img-preview.png';
}

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
    let url = (form.id !== 'undefined') ? globalVariables.ajax + 'events/saveDesign/' : globalVariables.ajax + 'events/saveDesign/';
    sendFormAjaxRequest(form, url, 'saveDesign', alertifyMessage)
    return false;
}

function alertifyMessage(response) {
    if (response.status === '1') { 
        if (!response.designId) {
            alertify.success(response.message);
            let bgImageEl = document.getElementById('bgImage');
            bgImageEl.setAttribute('value', response.bgImage);
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
        if(typeof activeFieldset !== 'undefined'){
            let inputs = activeFieldset.querySelectorAll('[data-value="1"]');
            let inputsLength = inputs.length;
            let i;
            for (i = 0; i < inputsLength; i++) {
                let input = inputs[i];
                styleELements(input);
            }
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
    let iframeWidthValue = document.getElementById(designGlobals.iframeWidthDeviceId).value;
    let iframeHeightValue = document.getElementById(designGlobals.iframeHeightDeviceId).value;

    designGlobals.phone.style.width = iframeWidthValue + 'px';
    designGlobals.phone.style.height = iframeHeightValue + 'px';

    /*Idea by /u/aerosole*/
    document.getElementById("wrapper").style.perspective = (
        document.getElementById("iframePerspective").checked ? "1000px" : "none"
    );
}

function screen(width, height) {
    $('#' + designGlobals.iframeWidthDeviceId).val(width);
    $('#' + designGlobals.iframeHeightDeviceId).val(height);
    updateIframe();
}

function uploadViewBgImage(element) {
    let formData = new FormData();
    if (typeof element.files[0] !== 'undefined') {
        formData.append('bgImage', element.files[0]);
        let url = globalVariables.ajax + 'uploadViewBgImage';
        sendFormDataAjaxRequest(formData, url, 'uploadViewBgImage', manageUploadReponse);
    }
    return false;
}

function manageUploadReponse(response) {
    if (response.status === '1') {
        let bgImage = document.getElementById('bgImage');
        let removeImage = document.getElementById('removeImage');
        let removeBgImageButton = document.getElementById('removeBgImageButton');
        bgImage.setAttribute('value', response.message);
        removeImage.setAttribute('value', '0');
        removeBgImageButton.style.display = 'initial';
        showBgImage(response.message);
    } else if (response.status === '0') {
        alertify.error(response.message);
    }
}

function triggerIdClick(id) {
    $('#' + id).trigger('click');
}

function removeBgImage(element, bgImageId, removeImageId) {
    let bgImageInput = document.getElementById(bgImageId);
    let removeImage = document.getElementById(removeImageId);
    bgImageInput.setAttribute('value', '');
    removeImage.setAttribute('value', '1');
    element.style.display = 'none';
    removeBgImageFromIframe();
}

function borderRadius(el){
    styleELements(el);

    var elVal = $(el).val();
    $("#border-top-left-radius").val(elVal);
    $("#border-bottom-left-radius").val(elVal);
    $("#border-bottom-right-radius").val(elVal);
    
    styleELements(document.getElementById("border-top-left-radius"));
    styleELements(document.getElementById("border-bottom-left-radius"));
    styleELements(document.getElementById("border-bottom-right-radius"));
    
}

function showBgImage(image) {
    let selector = getJquerySelector('class', designGlobals.designBackgroundImageClass);
    let iframeElements = $('iframe').contents().find(selector);
    if (iframeElements) {
        let iframeElementsLength = iframeElements.length;
        let i;
        for (i = 0; i < iframeElementsLength; i++) {
            let iframeElement = iframeElements[i];
            let imgSrc = globalVariables.baseUrl + 'assets/images/backGroundImages/' + image;
            iframeElement.style.backgroundImage = '';
            iframeElement.style.backgroundImage = 'url("' + imgSrc + '")';
            iframeElement.style.backgroundPosition = 'center center';
            iframeElement.style.backgroundSize = 'cover';
        }
    }
}

function nav_link(el){
    

    
    $('.nav_link').each(function(){
        let hide_id = $(this).attr('href');
        console.log(hide_id);
        $(hide_id).hide();
    });
    let show_id = $(el).attr('href');
    console.log(show_id);
    $(show_id).show();
    
}

/*
function checkForBgImage() {
    let bgImage = document.getElementById('bgImage').value;
    if (bgImage) {
        showBgImage(bgImage);
    } else {
        removeBgImageFromIframe();
    }
}


function removeBgImageFromIframe() {

    let selector = getJquerySelector('class', designGlobals.designBackgroundImageClass);
    let iframeElements = $('iframe').contents().find(selector);
    if (iframeElements) {
        let iframeElementsLength = iframeElements.length;
        let styles = ($('iframe').contents().find('style'));
        let stylesLength = styles.length;
        let i;
        let breakLoop = false;
        for (i = 0; i < iframeElementsLength; i++) {
            let iframeElement = iframeElements[i];
            iframeElement.style.backgroundImage = '';
            iframeElement.style.setProperty('backgroundImage', 'none', 'important');
        }

        for (i = 0; i < stylesLength; i++) {            
            let style = styles[i];
            let rules = style.sheet.rules;
            let rule;
            for (rule in rules) {
                if (rules[rule]['selectorText'] === ('.' + designGlobals.designBackgroundImageClass)) {
                    rules[rule].style.backgroundImage = 'none' ;
                    breakLoop = true;
                    break;
                }
                if (breakLoop) break;
            }
        }
    }
}
*/

function saveAnalytics(form) {
    let url = globalVariables.ajax + 'saveAnalytics/' + form.id;
    sendFormAjaxRequest(form, url, 'saveAnalytics', alertifyAnalyticsMessage)
    return false;
}

function alertifyAnalyticsMessage(response) {
    if (response.status === '1') {
        alertify.success(response.message);
    } else if (response.status === '0') { 
        alertify.error(esponse.message);
    }
}

$(document).ready(function(){
    let iframe = document.getElementById(designGlobals.iframeId);
    if (iframe) {
        iframeURLChange(iframe, function (newURL) {
            showViewSettings(designGlobals.checkUrl(newURL));
        });
    
        iframe.onload = function () {
            setDesign();
            //checkForBgImage();
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

jscolor.presets.default = {
	format :'rgba',
	height: 181,
	position: 'bottom',        // position the picker to the right of the target
	previewPosition: 'left', // display color preview on the right side
	previewSize: 80,
	alphaChannel :true,
	borderRadius : 20,
	borderWidth : 3

};
