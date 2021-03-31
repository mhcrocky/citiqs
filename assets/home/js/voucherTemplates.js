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
        'templateType' : templateType,
        'templateSubject' : templateSubject,
    };

    sendAjaxPostRequest(post, url, 'createEmailTemplate', createEmailTemplateResponse, [selectTemplate, customTemplate]);
}

function createEmailTemplateResponse(selectTemplate, customTemplate, response) {
    alertifyAjaxResponse(response);

    if (response['status'] === '1') {
        selectTemplate.value = '';
        customTemplateSubject.value = '';
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
        convert_urls : false,
        images_upload_credentials: true,
        images_upload_url: globalVariables.uploadEmailImageAjax,
        images_upload_base_path: globalVariables.baseUrl + globalVariables.emailImagesFolder,
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
                        text: '[Name]',
                        onclick: function(){editor.insertContent('[Name]')}
                    },
                    {
                        text: '[Email]',
                        onclick: function(){editor.insertContent('[Email]')}
                    },
                    {
                        text: '[voucherCode]',
                        onclick: function(){editor.insertContent('[voucherCode]')}
                    },
                    {
                        text: '[voucherDescription]',
                        onclick: function(){editor.insertContent('[voucherDescription]')}
                    },
                    {
                        text: '[voucherAmount]',
                        onclick: function(){editor.insertContent('[voucherAmount]')}
                    },
                    {
                        text: '[voucherPercent]',
                        onclick: function(){editor.insertContent('[voucherPercent]')}
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
