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
    let templateHtml = tinyMCE.get(templateGlobals.templateHtmlId).getContent().trim();

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
        toolbar: 'insert | undo redo | formatselect | bold italic underline backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | copy | cut | paste | tags | help',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ],
        setup: function(editor) {
            editor.on('init', function (e) {
                editor.setContent(templateContent);
            }),
            editor.addButton('tags', {
                type: 'menubutton',
                text: 'Tags',
                icon: false,
                menu: [
                    {
                        text: '[userFirstName]',
                        onclick: function(){editor.insertContent('[buyerFirstName]')}
                    },
                    {
                        text: '[userLastName]',
                        onclick: function(){editor.insertContent('[buyerFirstName]')}
                    },
                ],
            });
        }
    });

}

function showTemplates() {
    if (templateGlobals['templateContent']) {
        tinyMceInit(templateGlobals.templateHtmlId, templateGlobals['templateContent']);
    } else {
        tinyMceInit(templateGlobals.templateHtmlId);
    }
}

showTemplates();
