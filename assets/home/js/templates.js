'use strict'
function reloadTable(id) {
    $('#' + id).DataTable().ajax.reload();
}


// used in email templates
function createEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId = 0) {
    let selectTemplate = document.getElementById(selectTemplateValueId);
    let customTemplate = document.getElementById(customTemplateNameId);
    let customTemplateSubject = document.getElementById(customTemplateSubjectId);
    console.log(customTemplateSubjectId);
    let customTemplateType = document.getElementById(customTemplateTypeId);

    let selectTemplateName = selectTemplate.value.trim();
    let customTemplateName = customTemplate.value.trim();
    let templateSubject = customTemplateSubject.value.trim();
    let templateType = customTemplateType.value.trim();
    let templateHtml = tinyMCE.get(templateGlobals.templateHtmlId).getContent().replaceAll(globalVariables.baseUrl + 'assets/images/qrcode_preview.png', '[QRlink]').trim();
    if (!templateHtml) {
        let message = 'Empty template.'
        alertify.error(message);
        return;
    }

    if (selectTemplateName && customTemplateName) {
        let message = 'Not allowed. Select template or give template custom name.';
        alertify.error(message);
        selectTemplate.style.border = '1px solid #f00';
        customTemplate.style.border = '1px solid #f00';
        return;
    }

    if (!selectTemplateName && !customTemplateName) {
        alertify.error('Select template or give template custom name');
        selectTemplate.style.border = '1px solid #f00';
        customTemplate.style.border = '1px solid #f00';
        return;
    }

    selectTemplate.style.border = 'initial';
    customTemplate.style.border = 'initial';

    let templateName = (selectTemplateName) ? selectTemplateName : customTemplateName;
    let url = globalVariables.ajax + 'createEmailTemplate';
    let post = {
        'templateName' : templateName,
        'templateHtml' : templateHtml,
        'templateId' : templateId,
        'templateType' : templateType,
        'templateSubject' : templateSubject,
    };

    sendAjaxPostRequest(post, url, 'createEmailTemplate', createEmailTemplateResponse, [selectTemplate, customTemplateSubject, customTemplate]);
}

function createEmailTemplateResponse(selectTemplate, customTemplate, response) {
    alertifyAjaxResponse(response);

    if (response['status'] === '1') {
        selectTemplate.value = '';
        customTemplateSubject.value = '';
        customTemplate.value = '';
        if (response.update === '0') {
            tinymce.get(templateGlobals.templateHtmlId).setContent('');
        }
    }

    return;
}

function tinyMceInit(textAreaId, templateContent = '') {
    let id = '#' + textAreaId;

	// selector: 'textarea',  // change this value according to your HTML
	// 	plugins: 'fullpage',
	// 	menubar: 'file',
	// 	toolbar: 'fullpage'

    tinymce.init({
        selector: id,
		resize: 'both',
        relative_urls : false,
        remove_script_host : false,
        convert_urls : false,
        images_upload_credentials: true,
        images_upload_url: globalVariables.uploadEmailImageAjax,
        images_upload_base_path: globalVariables.baseUrl + globalVariables.emailImagesFolder,
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount',
			'fullpage',
			'preview',
			'fullscreen',
			'pagebreak',
			'media',
        ],
		width: '100%',
		valid_children : '+body[style]',
        mobile: {
            theme: 'mobile'
        },
        toolbar: 'insert | undo redo | styleselect | fontselect | fontsizeselect | formatselect | bold italic underline backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code | copy | cut | paste | pagebreak | media | tags | qrcode | help | fullpage | preview | fullscreen ',
		pagebreak_split_block: true,
		content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ],
        setup: function(editor) {
            editor.on('init', function (e) {
                editor.setContent(templateContent.replaceAll('[QRlink]', globalVariables.baseUrl+'assets/images/qrcode_preview.png'));
            }),
            editor.addButton('tags', {
                type: 'menubutton',
                text: 'Tags',
                icon: false,
                menu: [
                    {
                        text: '[buyerName]',
                        onclick: function(){editor.insertContent('[buyerName]')}
                    },
                    {
                        text: '[buyerEmail]',
                        onclick: function(){editor.insertContent('[buyerEmail]')}
                    },
                    {
                        text: '[buyerMobile]',
                        onclick: function(){editor.insertContent('[buyerMobile]')}
                    },
                    {
                        text: '[customer]',
                        onclick: function(){editor.insertContent('[customer]')}
                    },
                    {
                        text: '[reservationId]',
                        onclick: function(){editor.insertContent('[reservationId]')}
                    },
                    {
                        text: '[spotId]',
                        onclick: function(){editor.insertContent('[spotId]')}
                    },
                    {
                        text: '[spotLabel]',
                        onclick: function(){editor.insertContent('[spotLabel]')}
                    },
                    {
                        text: '[spotLabel]',
                        onclick: function(){editor.insertContent('[spotLabel]')}
                    },
                    {
                        text: '[numberOfPersons]',
                        onclick: function(){editor.insertContent('[numberOfPersons]')}
                    },
                    {
                        text: '[startTime]',
                        onclick: function(){editor.insertContent('[startTime]')}
                    },
                    {
                        text: '[endTime]',
                        onclick: function(){editor.insertContent('[endTime]')}
                    },
                    {
                        text: '[price]',
                        onclick: function(){editor.insertContent('[price]')}
                    },
                    {
                        text: '[eventName]',
                        onclick: function(){editor.insertContent('[eventName]')}
                    },
                    {
                        text: '[eventDate]',
                        onclick: function(){editor.insertContent('[eventDate]')}
                    },
                    {
                        text: '[eventVenue]',
                        onclick: function(){editor.insertContent('[eventVenue]')}
                    },
                    {
                        text: '[eventAddress]',
                        onclick: function(){editor.insertContent('[eventAddress]')}
                    },
                    {
                        text: '[eventCity]',
                        onclick: function(){editor.insertContent('[eventCity]')}
                    },
                    {
                        text: '[eventCountry]',
                        onclick: function(){editor.insertContent('[eventCountry]')}
                    },
                    {
                        text: '[eventZipcode]',
                        onclick: function(){editor.insertContent('[eventZipcode]')}
                    },
                    {
                        text: '[ticketDescription]',
                        onclick: function(){editor.insertContent('[ticketDescription]')}
                    },
                    {
                        text: '[ticketPrice]',
                        onclick: function(){editor.insertContent('[ticketPrice]')}
                    },
                    {
                        text: '[ticketQuantity]',
                        onclick: function(){editor.insertContent('[ticketQuantity]')}
                    },
                ],
            });

            editor.addButton('qrcode', {
                text: 'QRCode',
                onclick: function(){
                    let html = '<div style="width:100%;">'+
                    '<img class="qr-code-image"  border="0"  align="one_image" style="display:block;width:150px;padding:50px;" alt="" src="'+globalVariables.baseUrl+'assets/images/qrcode_preview.png" tabindex="0">'+
                    '</div>';
                    editor.insertContent(html);
                }
            });
        }
    });

}

function showTemplates() {
    if (templateGlobals['templateContent']) {
        tinyMceInit(templateGlobals.templateHtmlId, templateGlobals['templateContent']);
    } else if(templateGlobals.templateHtmlId){
        tinyMceInit(templateGlobals.templateHtmlId);
    }
}

function customUpdateEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId = 0){
    createEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId);
    setTimeout(() => {
        window.location.reload();
    }, 1200);
}

function checkiIsLandingPage(element, landingPage, emailElements, landingPageElemenst) {
    if (element.value === landingPage) {
        $('.' + emailElements).hide();
        $('.' + landingPageElemenst).show();
    } else {
        $('.' + emailElements).show();
        $('.' + landingPageElemenst).hide();
    }
}

function createLandingPage(productGroupId, landingPageId, landingTypeId, ladningPageNameId, ladningPageUrlId) {
    let post = validateAndGetLandingPageData(productGroupId, landingPageId, landingTypeId, ladningPageNameId, ladningPageUrlId);

    if (post) {
        let url = globalVariables.ajax + 'manageLandingPage';
        sendAjaxPostRequestImproved(post, url, createLandingPageResponse, [productGroupId, landingPageId, landingTypeId, ladningPageNameId, ladningPageUrlId]);
    }

    return;
}

function validateAndGetLandingPageData(productGroupId, landingPageId, landingTypeId, ladningPageNameId, ladningPageUrlId) {
    let productGroup = document.getElementById(productGroupId);
    let landingPage = document.getElementById(landingPageId);
    let landingType = document.getElementById(landingTypeId);
    let ladningPageName = document.getElementById(ladningPageNameId);
    let ladningPageUrl = document.getElementById(ladningPageUrlId);
    let errors = 0;
    let post = {
        'productGroup' : productGroup.value,
        'landingPage' : landingPage.value,
        'landingType' : landingType.value,
        'name' : ladningPageName.value.trim()
    }

    if (post['landingType']  === templateGlobals.urlType) {
        post['value'] = ladningPageUrl.value.trim();
    } else {
        post['value'] = tinyMCE.get(templateGlobals.templateHtmlId).getContent().replaceAll(globalVariables.baseUrl + 'assets/images/qrcode_preview.png', '[QRlink]').trim();
    }

    if (!post['value']) {
        let message = post['landingType']  === templateGlobals.urlType ? 'Empty lanidng page url.' : 'Empty template.';
        alertify.error(message);
        errors++;
        if (post['landingType']  === templateGlobals.urlType) {
            ladningPageUrl.style.border = '1px solid #f00';
        }
    } else {
        if (post['landingType']  === templateGlobals.urlType) {
            ladningPageUrl.style.border = 'initial';
        }
    }

    if (!post['productGroup']) {
        let message = 'Select prodcut group.';
        alertify.error(message);
        productGroup.style.border = '1px solid #f00';
        errors++;
    } else {
        productGroup.style.border = 'initial';
    }

    if (!post['landingPage']) {
        let message = 'Select landing page.';
        alertify.error(message);
        landingPage.style.border = '1px solid #f00';
        errors++;
    } else {
        landingPage.style.border = 'initial';
    }

    if (!post['landingType']) {
        let message = 'Select landing type.';
        alertify.error(message);
        landingType.style.border = '1px solid #f00';
        errors++;
    } else {
        landingType.style.border = 'initial';
    }

    if (!post['name']) {
        let message = 'Landing page name is requried.';
        alertify.error(message);
        ladningPageName.style.border = '1px solid #f00';
        errors++;
    } else {
        ladningPageName.style.border = 'initial';
    }

    return errors ? false : post;

}

function switchTypeELement(element, templateHtmlClass, ladningPageUrlClass) {
    if (element.value === templateGlobals.urlType) {
        $('.' + templateHtmlClass).hide();
        $('.' + ladningPageUrlClass).show();
    } else {
        $('.' + templateHtmlClass).show();
        $('.' + ladningPageUrlClass).hide();
    }
}

function createLandingPageResponse(productGroupId, landingPageId, landingTypeId, ladningPageNameId, ladningPageUrlId, response) {
    if (response['status'] === '1') {
        let i;
        let argumentsLength = arguments.length;
        for (i = 0; i < argumentsLength; i++) {
            let argument = arguments[i];
            if (typeof argument === 'string') {
                document.getElementById(argument).value = '';
            }
        }

        // if (response.update === '0') {
            tinymce.get(templateGlobals.templateHtmlId).setContent('');
        // }
    }
    alertifyAjaxResponse(response);
    
    // $('#' + templateGlobals.templateHtmlId).empty();
}
showTemplates();
