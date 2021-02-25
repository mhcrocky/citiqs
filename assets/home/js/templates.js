'use strict'
function reloadTable(id) {
    $('#' + id).DataTable().ajax.reload();
}


// used in email templates
function createEmailTemplate(selectTemplateValueId, customTemplateNameId, templateId = 0) {
    let selectTemplate = document.getElementById(selectTemplateValueId);
    let customTemplate = document.getElementById(customTemplateNameId);

    let selectTemplateName = selectTemplate.value.trim();
    let customTemplateName = customTemplate.value.trim();
    let templateHtml = tinyMCE.get(templateGlobals.templateHtmlId).getContent().replaceAll(globalVariables.baseUrl + 'assets/images/qrcode_preview.png', '[QRlink]').trim();
    if (!templateHtml) {
        let message = 'Empty template.'
        alertify.error(message);
        return;
    }

    if (selectTemplateName && customTemplateName) {
        let message = 'Not allowed. Select template or give template custom name.'
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
    };

    sendAjaxPostRequest(post, url, 'createEmailTemplate', createEmailTemplateResponse, [selectTemplate, customTemplate]);
}

function createEmailTemplateResponse(selectTemplate, customTemplate, response) {
    alertifyAjaxResponse(response);

    if (response['status'] === '1') {
        selectTemplate.value = '';
        customTemplate.value = '';
        if (response.update === '0') {
            tinymce.get(templateGlobals.templateHtmlId).setContent('')
        }
    }

    return;
}

function tinyMceInit(textAreaId, templateContent = '') {
    let id = '#' + textAreaId;

    tinymce.init({
        selector: id,
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        images_upload_credentials: true,
        images_upload_url: globalVariables.uploadEmailImageAjax,
        images_upload_base_path: globalVariables.emailImagesFolder,
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount'
        ],
        mobile: {
            theme: 'mobile'
        },
        toolbar: 'insert | undo redo | formatselect | bold italic underline backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | copy | cut | paste | tags | qrcode | help',
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
                        text: '[buyerEmail]',
                        onclick: function(){editor.insertContent('[buyerEmail]')}
                    },
                    {
                        text: '[buyerMobile]',
                        onclick: function(){editor.insertContent('[buyerMobile]')}
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
                    let html = '<div style="width:100%;display: flex;justify-content: center;">'+
                    '<img class="qr-code-image"  border="0"  align="one_image" style="display:block;max-width:350px;padding:50px;" alt="" src="'+globalVariables.baseUrl+'assets/images/qrcode_preview.png" tabindex="0">'+
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

showTemplates();
