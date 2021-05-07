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

    const CLASS_RULER = "document-ruler";
const RULER_PAGEBREAK_CLASS = "mce-ruler-pagebreak";
const RULER_SHORTCUT = "Meta+Q";
const PX_RULER = 3.78; // 3.779527559
const PADDING_RULER = 13; // in millimeters
const FORMAT = { width: 210, height: 297 }; // A4 210, 297
const HEIGHT = FORMAT.height * PX_RULER;
const STYLE_RULER = `
 html.${CLASS_RULER}{
   background: #b5b5b5;
   padding: 0;
   background-image: url(data:image/svg+xml;utf8,%3Csvg%20width%3D%22100%25%22%20height%3D%22${
     FORMAT.height
   }mm%22%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cline%20x1%3D%220%22%20y1%3D%22${
  FORMAT.height
}mm%22%20x2%3D%22100%25%22%20y2%3D%22${
  FORMAT.height
}mm%22%20stroke%3D%22%23${"737373"}%22%20height%3D%221px%22%2F%3E%3C%2Fsvg%3E);
   background-repeat: repeat-y;
   background-position: 0 0;
 }
 html.${CLASS_RULER} body{
   padding: 0 ${PADDING_RULER}mm !important;
   padding-top: ${PADDING_RULER}mm !important;
   margin: 0 auto !important;
   background-image: url(data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22${
     FORMAT.width
   }mm%22%20height%3D%22${FORMAT.height}mm%22%3E%3Crect%20width%3D%22${
  FORMAT.width
}mm%22%20height%3D%22${
  FORMAT.height
}mm%22%20style%3D%22fill%3A%23fff%22%2F%3E%3Cline%20x1%3D%220%22%20y1%3D%22100%25%22%20x2%3D%22100%25%22%20y2%3D%22100%25%22%20stroke%3D%22%23737373%22%20height%3D%221px%22%2F%3E%3Cline%20x1%3D%22${PADDING_RULER}mm%22%20y1%3D%220%22%20x2%3D%22${PADDING_RULER}mm%22%20y2%3D%22100%25%22%20stroke%3D%22%230168e1%22%20height%3D%221px%22%20stroke-dasharray%3D%225%2C5%22%2F%3E%3Cline%20x1%3D%22${FORMAT.width -
  PADDING_RULER}mm%22%20y1%3D%220%22%20x2%3D%22${FORMAT.width -
  PADDING_RULER}mm%22%20y2%3D%22100%25%22%20stroke%3D%22%230168e1%22%20height%3D%221px%22%20stroke-dasharray%3D%225%2C5%22%2F%3E%3Cline%20x1%3D%220%22%20y1%3D%22${PADDING_RULER}mm%22%20x2%3D%22100%25%22%20y2%3D%22${PADDING_RULER}mm%22%20stroke%3D%22%230168e1%22%20height%3D%221px%22%20stroke-dasharray%3D%225%2C5%22%2F%3E%3Cline%20x1%3D%220%22%20y1%3D%22${FORMAT.height -
  PADDING_RULER}mm%22%20x2%3D%22100%25%22%20y2%3D%22${FORMAT.height -
  PADDING_RULER}mm%22%20stroke%3D%22%230168e1%22%20height%3D%221px%22%20stroke-dasharray%3D%225%2C5%22%2F%3E%3C%2Fsvg%3E);
   background-repeat: repeat-y;
   background-position: 0 0;
   width: ${FORMAT.width}mm;
   min-height: ${FORMAT.height}mm !important;
   box-sizing: border-box;
   box-shadow: 4px 4px 13px -3px #3c3c3c;
   -webkit-box-shadow: 4px 4px 13px -3px #3c3c3c;
 }
 html.${CLASS_RULER} .${RULER_PAGEBREAK_CLASS}{
   margin-top: ${PADDING_RULER}mm;
   margin-bottom: ${PADDING_RULER}mm;
   margin-left: -${PADDING_RULER}mm;
   width: calc(100% + ${2 * PADDING_RULER}mm);
   border: 0;
   height: 1px;
   background: #5a8ecb;
 }

 @media print {
    @page {
        size: ${FORMAT.width}mm ${FORMAT.height}mm;
        margin: 0mm !important;
        counter-increment: page
      }

      html.${CLASS_RULER}, html.${CLASS_RULER} body {
        background: transparent;
        box-shadow: none
      }
      html.${CLASS_RULER} body {
        padding: 0 !important;
        margin: ${PADDING_RULER}mm !important;
        width: 100%;
        font-size: 13px;
        font-family: Helvetica,Arial,sans-serif !important;
        font-style: normal;
        letter-spacing: 0
      }
   html.${CLASS_RULER} .${RULER_PAGEBREAK_CLASS}{
     margin: 0 !important;
     height: 0 !important
   }
 }
`;

function debounce(fn, wait = 250, immediate) {
  let timeout;

  function debounced(/* ...args */) {
    const later = () => {
      timeout = void 0;
      if (immediate !== true) {
        fn.apply(this, arguments);
      }
    };

    clearTimeout(timeout);
    if (immediate === true && timeout === void 0) {
      fn.apply(this, arguments);
    }
    timeout = setTimeout(later, wait);
  }

  debounced.cancel = () => {
    clearTimeout(timeout);
  };

  return debounced;
}

function createStyle(style, doc) {
  const tag = doc.createElement("style");
  tag.innerHTML = style;
  doc.head.appendChild(tag);
}
const pluginManager = tinymce.util.Tools.resolve("tinymce.PluginManager");

function pluginRuler(editor) {
  if (editor.settings.ruler !== true) {
    return void 0;
  }
  const tinyEnv = window.tinymce.util.Tools.resolve("tinymce.Env");

  const FilterContent = {
    getPageBreakClass() {
      return RULER_PAGEBREAK_CLASS;
    },
    getPlaceholderHtml() {
      return (
        '<img src="' +
        tinyEnv.transparentSrc +
        '" class="' +
        this.getPageBreakClass() +
        '" data-mce-resize="false" data-mce-placeholder />'
      );
    }
  };

  const Settings = {
    getSeparatorHtml() {
      return editor.getParam("pagebreak_separator", "<!-- ruler-pagebreak -->"); // <!-- pagebreak -->
    },
    shouldSplitBlock() {
      return editor.getParam("pagebreak_split_block", false);
    }
  };

  const separatorHtml = Settings.getSeparatorHtml(editor);
  var pageBreakSeparatorRegExp = new RegExp(
    separatorHtml.replace(/[\?\.\*\[\]\(\)\{\}\+\^\$\:]/g, function(a) {
      return "\\" + a;
    }),
    "gi"
  );
  editor.on("BeforeSetContent", function(e) {
    e.content = e.content.replace(
      pageBreakSeparatorRegExp,
      FilterContent.getPlaceholderHtml()
    );
  });
  editor.on("PreInit", function() {
    editor.serializer.addNodeFilter("img", function(nodes) {
      var i = nodes.length,
        node,
        className;
      while (i--) {
        node = nodes[i];
        className = node.attr("class");
        if (
          className &&
          className.indexOf(FilterContent.getPageBreakClass()) !== -1
        ) {
          const parentNode = node.parent;
          if (
            editor.schema.getBlockElements()[parentNode.name] &&
            Settings.shouldSplitBlock(editor)
          ) {
            parentNode.type = 3;
            parentNode.value = separatorHtml;
            parentNode.raw = true;
            node.remove();
            continue;
          }
          node.type = 3;
          node.value = separatorHtml;
          node.raw = true;
        }
      }
    });
  });

  editor.on("ResolveName", function(e) {
    if (
      e.target.nodeName === "IMG" &&
      editor.dom.hasClass(e.target, FilterContent.getPageBreakClass())
    ) {
      e.name = "pagebreak";
    }
  });

  editor.addCommand("mceRulerPageBreak", function() {
    if (editor.settings.pagebreak_split_block) {
      editor.insertContent("<p>" + FilterContent.getPlaceholderHtml() + "</p>");
    } else {
      editor.insertContent(FilterContent.getPlaceholderHtml());
    }
  });

  editor.addCommand("mceRulerRecalculate", function() {
    const $document = editor.getDoc();
    const $breaks = $document.querySelectorAll(`.${RULER_PAGEBREAK_CLASS}`);
    for (let i = 0; i < $breaks.length; i++) {
      const $element = $breaks[i];
      const $parent = $element.parentElement;
      const offsetTop = $element.offsetTop;
      const top = HEIGHT * (i + 1);
      if (top >= offsetTop) {
        $parent.style.marginTop =
          ~~(top - (offsetTop - $parent.style.marginTop.replace("px", ""))) +
          "px";
      }
    }
  });

  editor.addShortcut(RULER_SHORTCUT, "", "mceRulerPageBreak");

  editor.on("init", e => {
    const $document = editor.getDoc();
    createStyle(STYLE_RULER, $document);
    const documentElement = $document.documentElement;
    const hasRuler = documentElement.classList.contains(CLASS_RULER);

    if (hasRuler === false) {
      documentElement.classList.add(CLASS_RULER);
    }
  });

  const recalculate = debounce(() => {
    editor.execCommand("mceRulerRecalculate");
  }, 100);

  editor.on("NodeChange", e => {
    recalculate();
  });
}

tinymce.PluginManager.add("ruler", pluginRuler);






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
          "advlist",
          "autolink",
          "lists",
          "link",
          "image",
          "charmap",
          "preview",
          "anchor",
          "textcolor",
          "searchreplace",
          "visualblocks",
          "code",
          "fullscreen",
          "insertdatetime",
          "media",
          "table",
          "contextmenu",
          "paste",
          "help",
          "wordcount",
          "print",
          "ruler",
			"table"
        ],
        ruler: true,
        toolbar:
          "insert | undo redo | formatselect | bold italic underline backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | copy | cut | paste | tags | qrcode | help | print",
        contextmenu: "image imagetools table", // No usar link, porque no funcionará con spellchecker
        content_css: [
          "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
          "//www.tiny.cloud/css/codepen.min.css"
        ],
        content_style: `
        .mce-content-body p {
          margin: 0
        }
        #tinymce.mce-content-body {
          font-size: 13px;
          font-family: Helvetica,Arial,sans-serif !important;
          font-style: normal;
          letter-spacing: 0;
          color: #262626;
          margin: 8px
        }
        figure {
          outline: 3px solid #dedede;
          position: relative;
          display: inline-block
        }
        figure:hover {
          outline-color: #ffc83d
        }
        figure > figcaption {
          color: #333;
          background-color: #f7f7f7;
          text-align: center
        }
        `,
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
                    {
                      text: '[voucherID]',
                      onclick: function(){editor.insertContent('[voucherID]')}
                    },
                    {
                      text: '[currentDate]',
                      onclick: function(){editor.insertContent('[currentDate]')}
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

function customUpdateEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId = 0){
  createEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId);
  setTimeout(() => {
    window.location.reload();
  }, 1500);
}

function showTemplates() {
    if (templateGlobals['templateContent']) {
        tinyMceInit(templateGlobals.templateHtmlId, templateGlobals['templateContent']);
    } else if(templateGlobals.templateHtmlId){
        tinyMceInit(templateGlobals.templateHtmlId);
    }
}

showTemplates();
