'use strict'
function reloadTable(id) {
    $('#' + id).DataTable().ajax.reload();
}


// used in email templates
function createEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId, useTinyMce) {
  let selectTemplate = document.getElementById(selectTemplateValueId);
  let customTemplate = document.getElementById(customTemplateNameId);
  let customTemplateSubject = document.getElementById(customTemplateSubjectId);
  let customTemplateType = document.getElementById(customTemplateTypeId);

  let selectTemplateName = selectTemplate.value.trim();
  let customTemplateName = customTemplate.value.trim();
  let templateSubject = customTemplateSubject.value.trim();
  let templateType = customTemplateType.value.trim();

  if (useTinyMce) {
    let templateHtml = tinyMCE.get(templateGlobals.templateHtmlId).getContent().replaceAll(globalVariables.baseUrl + 'assets/images/qrcode_preview.png', '[QRlink]').trim();
    saveTemplate(templateHtml, selectTemplateName, customTemplateName, selectTemplate, customTemplate, templateSubject, templateType, templateId);
  } else {
    unlayer.exportHtml(function(data) {
      let templateHtml = data.html;
      let unlayerDesign = JSON.stringify(data.design);
      saveTemplate(templateHtml, selectTemplateName, customTemplateName, selectTemplate, customTemplate, templateSubject, templateType, templateId, unlayerDesign);
    });
  }
}

function saveTemplate(
  templateHtml,
  selectTemplateName,
  customTemplateName,
  selectTemplate,
  customTemplate,
  templateSubject,
  templateType,
  templateId,
  unlayerDesign = ''
) {
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
      'unlayerDesign' : unlayerDesign
  };

  sendAjaxPostRequest(post, url, 'createEmailTemplate', createEmailTemplateResponse);
}

function createEmailTemplateResponse(response) {
    alertifyAjaxResponse(response);

    if (response['status'] === '1') {
      if (response.update === '0') {
          redirectToNewLocation(response['location']);
      } else {
          setTimeout(() => {
            window.location.reload();
          }, 1500);
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
         /*background: transparent;*/
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
            "advlist",
            "autolink",
            "lists",
            "link",
            "image",
            "charmap",
            "preview",
            "anchor",
            "searchreplace",
            "visualblocks",
            "code",
            "fullscreen",
            "insertdatetime",
            "media",
            "table",
            "paste",
            "help",
            "wordcount",
            "fullpage",
            "pagebreak",
            "print",
            "ruler",
			      "table",
            "emoticons"
        ],
        ruler: true,
        extended_valid_elements: "canvas[*],width[*],height[*],script[*]",
        toolbar: "insert | undo redo | styleselect | fontselect | fontsizeselect | formatselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code | copy | cut | paste | pagebreak | media | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | emoticons | tags | qrcode | help | fullpage | preview | fullscreen | print ",
        contextmenu: "image imagetools table",
        content_css: [
            "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
            "//www.tiny.cloud/css/codepen.min.css"
        ],
        content_style: 
          `.mce-content-body p {
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
          }`,
        setup: function(editor) {
            editor.on('init', function (e) {
                editor.setContent(templateContent.replaceAll('[QRlink]', globalVariables.baseUrl+'assets/images/qrcode_preview.png'));
            });
            editor.on('change', function (e) {
              let color = $('#tox-icon-highlight-bg-color__color').attr('fill');

              if(color == $('#lastColor').val()){
                return ;
              }

              $('#lastColor').val(color);
              
              let content = editor.getContent();

              let firstvariable = '<body';
              let secondvariable = '>';
              let replaceStr = content.match(new RegExp(firstvariable + "(.*)" + secondvariable));
              if(typeof color === 'undefined') {   
                //content = content.replace(replaceStr[0], '<body style="background: #fff">');
                //editor.setContent(content);
                return ;
              }
              content = content.replace(replaceStr[0], '<body style="background: '+ color +'">');
              editor.setContent(content);
            });
            editor.ui.registry.addMenuButton('tags', {
              text: 'Tags',
              fetch: function (callback) {
                let items = templateGlobals.items;
                let itemsLength = items.length;
                let i;
                for (i = 0; i < itemsLength; i++) {
                  let item = items[i];
                  item['onAction'] = function(){editor.insertContent(item['text'])}
                }
                // var items = [
                //   {
                //     type: 'menuitem',
                //     text: '[buyerName]',
                //     onAction: function(){editor.insertContent('[buyerName]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[buyerEmail]',
                //     onAction: function(){editor.insertContent('[buyerEmail]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[buyerMobile]',
                //     onAction: function(){editor.insertContent('[buyerMobile]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[customer]',
                //     onAction: function(){editor.insertContent('[customer]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[reservationId]',
                //     onAction: function(){editor.insertContent('[reservationId]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[spotId]',
                //     onAction: function(){editor.insertContent('[spotId]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[spotLabel]',
                //     onAction: function(){editor.insertContent('[spotLabel]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[numberOfPersons]',
                //     onAction: function(){editor.insertContent('[numberOfPersons]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[startTime]',
                //     onAction: function(){editor.insertContent('[startTime]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[endTime]',
                //     onAction: function(){editor.insertContent('[endTime]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[price]',
                //     onAction: function(){editor.insertContent('[price]')}
                //   },
                //   {
                //       text: '[eventName]',
                //       onAction: function(){editor.insertContent('[eventName]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[eventDate]',
                //     onAction: function(){editor.insertContent('[eventDate]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[eventVenue]',
                //     onAction: function(){editor.insertContent('[eventVenue]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[eventAddress]',
                //     onAction: function(){editor.insertContent('[eventAddress]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[eventCity]',
                //     onAction: function(){editor.insertContent('[eventCity]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[eventCountry]',
                //     onAction: function(){editor.insertContent('[eventCountry]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[eventZipcode]',
                //     onAction: function(){editor.insertContent('[eventZipcode]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[ticketDescription]',
                //     onAction: function(){editor.insertContent('[ticketDescription]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[ticketPrice]',
                //     onAction: function(){editor.insertContent('[ticketPrice]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[ticketQuantity]',
                //     onAction: function(){editor.insertContent('[ticketQuantity]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[orderId]',
                //     onAction: function(){editor.insertContent('[orderId]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[orderAmount]',
                //     onAction: function(){editor.insertContent('[orderAmount]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[VoucherCode]',
                //     onAction: function(){editor.insertContent('[voucherCode]')}
                //   },
                //   {
                //     type: 'menuitem',
                //     text: '[WalletCode]',
                //     onAction: function(){editor.insertContent('[WalletCode]')}
                //   },
                // ];
                callback(items);
              }
            });
            editor.ui.registry.addButton('qrcode', {
                text: 'QRCode',
                onAction: function(){
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
    if (templateGlobals.hasOwnProperty('templateContent')) {
        tinyMceInit(templateGlobals['templateHtmlId'], templateGlobals['templateContent']);
    } else if (templateGlobals['templateHtmlId']) {
        tinyMceInit(templateGlobals['templateHtmlId']);
    }

    if (templateGlobals.hasOwnProperty('unlayerDesign') || !templateGlobals.hasOwnProperty('templateId')) {
      useUnlayer();
      unlayer.loadDesign(templateGlobals['unlayerDesign'])
    }
}

function customUpdateEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId, useTinyMce) {
    createEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, templateId, useTinyMce);
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
        if (templateGlobals.hasOwnProperty('landingPageId')) {
            url += '/' + templateGlobals['landingPageId'];
        }
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

function switchTypeELement(element, templateHtmlClass, editTemplate, ladningPageUrlClass) {
    if (element.value === templateGlobals.urlType) {
        $('.' + templateHtmlClass).hide();
        $('.' + editTemplate).hide();
        $('.' + ladningPageUrlClass).show();
    } else {
        $('.' + templateHtmlClass).show();
        $('.' + editTemplate).show();
        $('.' + ladningPageUrlClass).hide();
    }
}

function createLandingPageResponse(productGroupId, landingPageId, landingTypeId, ladningPageNameId, ladningPageUrlId, response) {
    if (response['status'] === '1' && response.update === '0') {
        let i;
        let argumentsLength = arguments.length;
        for (i = 0; i < argumentsLength; i++) {
            let argument = arguments[i];
            if (typeof argument === 'string') {
                document.getElementById(argument).value = '';
            }
        }
        tinymce.get(templateGlobals.templateHtmlId).setContent('');
    }
    alertifyAjaxResponse(response);
    
    // $('#' + templateGlobals.templateHtmlId).empty();
}

function hideTemplateEditor() {
    if (templateGlobals.hasOwnProperty('hideTemplateEditor')) {
        $('.mce-container').hide();
        $('.editTemplate').hide();
    }
    return;
}

function sendTestEmail(emailId, templateId){
  let email = document.getElementById(emailId);
  let templateHtml = tinyMCE.get(templateId).getContent().trim();
  let url = globalVariables.baseUrl + 'Ajaxdorian/sendTestEmail';
  var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  if(!email.value.match(mailformat))
  {
    alertify['error']("Invalid email address!");
    return false;
  }

  let post = {
    'email' : email.value.trim(),
    'templateHtml' : templateHtml,
  };



  $.post(url, post, function(data) {
    data = JSON.parse(data);
    alertifyAjaxResponse(data);
  });

}

function sendTestEmailResponse(email, response) {
  console.log(response);
  alertifyAjaxResponse(response);
  return;
}



function useUnlayer(settings = null)  {
  if (!settings) {
    settings = {};
  }

  let items = templateGlobals.items;
  let itemsLength = items.length;
  let i;
  settings['mergeTags'] = {};
  for (i = 0; i < itemsLength; i++) {
    let item = items[i];
    let key = item['text'];
    key = key.replace('[','');
    key = key.replace(']','');
    settings['mergeTags'][key] = {
      name : item['name'],
      value : item['text']
    }
  }

  settings['id'] = templateGlobals.templateHtmlIdUnLayer;
  settings['displayMode'] = 'email';
  unlayer.init(settings);


    // Custom Image Upload
    unlayer.registerCallback('image', function(file, done) {
      var data = new FormData()
      data.append('file', file.attachments[0])
    
      fetch(globalVariables.baseUrl +'Ajaxdorian/upload_unlayer_image', {
        method: 'POST',
        headers: {
          'Accept': 'application/json'
        },
        body: data
      }).then(response => {
        if (response.status >= 200 && response.status < 300) {
          return response
        } else {
          var error = new Error(response.statusText)
          error.response = response
          throw error
        }
      }).then(response => {
        return response.json()
      }).then(data => {
        done({ progress: 100, url: data.filelink })
      });
    });

}


showTemplates();
setTimeout(hideTemplateEditor, 1000);

// var design = {...}; // template JSON
// unlayer.loadDesign();