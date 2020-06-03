/**
 * FPDF WYSIWYG Script Generator / Editor 2.1.1
 * Created by MklProgi on 09/10/2018.
 * Copyright 2018 MklProgi
 * Sales platform Codecanyon.net
 */

;
(function($) {

    $.fn.fpdf_designer = function(options) {

        var defaults = {
            paper_width: 210,
            paper_height: 290,
            px_per_cm: 37.79,
            px_per_mm: 3.779,
            px_per_point: 1.33,
            decimals: 0,
            body_offset: 0,
            pdf_top_margin: 10,
            pdf_right_margin: 10,
            pdf_left_margin: 10,
            pdf_default_fontsize: 12,
            promt_text_save: 'Enter name for your design',
            promt_text_load: 'Enter the design name you want to load',
            use_promt: true,
            ajax_url: '',
            save_url: '',
            load_url: '',
            debug: false,
            output_container: '#output_content',
            standard_font: 'DejaVu',
            fpdf_headers: ["AddPage('P', 'A4')", "SetAutoPageBreak(true, 10)", "SetFont('Arial', '', 12)"],
            fonts: {
                'removefont-element': { 'name': 'Remove' },
                'font-Arial': { 'name': 'Arial' },
                'font-Courier': { 'name': 'Courier' },
                'font-Times': { 'name': 'Times' },
                'font-Symbol': { 'name': 'Symbol' },
                'font-ZapfDingbats': { 'name': 'ZapfDingbats' },
                'font-DejaVu': { 'name': 'DejaVu' }
            },
            fontsizes: {
                'fontsize-8': { 'name': 8 },
                'fontsize-9': { 'name': 9 },
                'fontsize-10': { 'name': 10 },
                'fontsize-12': { 'name': 12 },
                'fontsize-14': { 'name': 14 },
                'fontsize-18': { 'name': 18 },
                'fontsize-20': { 'name': 20 },
                'fontsize-24': { 'name': 24 },
                'fontsize-28': { 'name': 28 },
                'fontsize-32': { 'name': 32 },
                'fontsize-36': { 'name': 36 },
                'fontsize-40': { 'name': 40 }
            }
        };

        var fpdf_designer = this,
            fpdf_designer_area,
            opt = { config: null },
            in_elements = {},
            in_elements_count = 0,
            paper_offset_x_start = 0,
            paper_offset_x_end = 0,
            paper_offset_y_start = 0,
            paper_offset_y_end = 0,
            show_helper = true,
            show_invisible = true,
            orientation_lines = true,
            resizer_mouse_is_in = false,
            ajax_data = null;

        /* --------------------------------------------------- */
        /* binding function to get elements object - $(SELECTOR).getElements(); */
        /* --------------------------------------------------- */
        fpdf_designer.getElements = function() {
            var ordered_object = reorder_elements(in_elements);
            return { 'all_elements': ordered_object };
        };

        /* --------------------------------------------------- */
        /* binding function to send elements object by ajax - $(SELECTOR).sendAjax(); */
        /* --------------------------------------------------- */
        fpdf_designer.sendAjax = function() {
            var ordered_object = reorder_elements(in_elements);
            fpdf_designer.trigger('fpdf.send_start');

            setTimeout(function() {
                $.ajax({
                    url: opt.config.ajax_url,
                    method: "POST",
                    data: { 'all_elements': ordered_object },
                    success: function(data) {
                        ajax_data = data;
                        if (opt.config.debug) { console.log(ajax_data); }
                        fpdf_designer.trigger('fpdf.send_done');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        ajax_data = textStatus;
                        if (opt.config.debug) { console.log(ajax_data); }
                        fpdf_designer.trigger('fpdf.send_failed');
                    }
                });
            }, 500);
        };

        /* --------------------------------------------------- */
        /* binding function to get data from ajax request - $(SELECTOR).getAjaxData(); */
        /* --------------------------------------------------- */
        fpdf_designer.getAjaxData = function() {
            return ajax_data;
        };

        /* --------------------------------------------------- */
        /* binding function to save design - $(SELECTOR).saveDesign(); */
        /* --------------------------------------------------- */
        fpdf_designer.saveDesign = function() {
            var content = fpdf_designer.html(),
                b64 = btoa(encodeURIComponent(content)),
                design_content = {};

            design_content.front = b64;
            design_content.back = in_elements;
            if (opt.config.use_promt) {
                var design_name = prompt(opt.config.promt_text_save, $("#savedTemplates option:selected").val());

                if (design_name === '') {
                    if (opt.config.debug) { console.log('No design name'); }
                    fpdf_designer.trigger('fpdf.save_failed');
                } else {
                    save_design(design_content, design_name);
                }
            } else {
                save_design(design_content, '');
            }
        };

        function save_design(design_content, design_name) {
            var code_to_save = {};
            code_to_save.code = btoa(encodeURIComponent($(".code-fpdf").html().replace(/\<br\>/g, "  ")));
            var received_data;
            $.ajax({
                url: opt.config.save_url,
                method: "POST",
                data: { 'content_to_save': JSON.stringify(design_content), 'design_name': design_name, 'code_to_save': JSON.stringify(code_to_save) },
                success: function(data) {
                    if (opt.config.debug) { console.log(data); }
                    received_data = JSON.parse(data);

                    if (received_data.status === 'success') {
                        fpdf_designer.trigger('fpdf.save_done');
                    } else {
                        if (opt.config.debug) { console.log(data); }
                        fpdf_designer.trigger('fpdf.save_failed');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (opt.config.debug) { console.log(textStatus); }
                    fpdf_designer.trigger('fpdf.save_failed');
                }
            });
        }

        /* --------------------------------------------------- */
        /* binding function to load design - $(SELECTOR).loadDesign(); */
        /* --------------------------------------------------- */
        fpdf_designer.loadDesign = function() {
            in_elements = {};
            in_elements_count = 0;

            if (opt.config.use_promt) {
                var design_name = prompt(opt.config.promt_text_load, '');

                if (design_name === '') {
                    fpdf_designer.trigger('fpdf.load_failed');
                } else {
                    load_design(design_name);
                }
            } else {
                load_design('');
            }
        };
        
        /* --------------------------------------------------- */
        /* binding function to load design - on list selection */
        /* --------------------------------------------------- */
        fpdf_designer.loadDesignWithName = function() {
                var design_name = $("#savedTemplates option:selected").val();
                if (design_name === '') {
                    fpdf_designer.trigger('fpdf.load_failed');
                } else {
                    load_design(design_name);
                }
        };

        function load_design(design_name) {
            var loaded_content,
                received_data,
                front_content;

            $.ajax({
                url: opt.config.load_url,
                method: "POST",
                data: { 'design_name': design_name },
                success: function(data) {
                    if (opt.config.debug) { console.log(data); }
                    received_data = JSON.parse(data);

                    if (received_data.status === 'success') {
                        var lastEntry;
                        loaded_content = received_data.design;
                        fpdf_designer.trigger('fpdf.load_done');

                        loaded_content = JSON.parse(loaded_content);
                        front_content = decodeURIComponent(atob(loaded_content.front));

                        fpdf_designer.html(front_content);
                        fpdf_designer_area = $('#fpdf_designer_area');

                        in_elements = loaded_content.back;
                        Object.keys(in_elements).forEach(function(key) {
                            lastEntry = in_elements[key].editorid;
                        });
                        in_elements_count = lastEntry;

                        after_add();
                    } else {
                        if (opt.config.debug) { console.log(data); }
                        fpdf_designer.trigger('fpdf.load_failed');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (opt.config.debug) { console.log(textStatus); }
                    fpdf_designer.trigger('fpdf.load_failed');
                }
            });
        }

        /* --------------------------------------------------- */
        /* binding function to clear the editor - $(SELECTOR).clearEditor(); */
        /* --------------------------------------------------- */
        fpdf_designer.clearEditor = function() {
            in_elements = {};
            in_elements_count = 0;
            fpdf_designer.trigger('fpdf.cleared');
            setup();
        };

        /* --------------------------------------------------- */
        /* binding function to update x/y coordinates e.g. window resize - $(SELECTOR).updateEditorXY(); */
        /* --------------------------------------------------- */
        fpdf_designer.updateEditorXY = function() {
            paper_offset_x_start = fpdf_designer.offset().left - opt.config.body_offset;
            paper_offset_x_end = parseFloat(paper_offset_x_start) + parseFloat(fpdf_designer.innerWidth());

            paper_offset_y_start = fpdf_designer.offset().top - opt.config.body_offset;
            paper_offset_y_end = parseFloat(paper_offset_y_start) + parseFloat(fpdf_designer.innerHeight());
        };

        /* --------------------------------------------------- */
        /* init editor */
        /* --------------------------------------------------- */
        var init = function() {
            opt.config = $.extend({}, defaults, options);

            fpdf_designer.unbind();

            $('.fdpf-element').each(function() {
                if ($(this).data('is-new-element')) {
                    $(this).on('click', function() {
                        add_element($(this).data('fpdf'));
                    });
                }
            });

            setup();
            return true;
        };

        /* --------------------------------------------------- */
        /* start to setup */
        /* --------------------------------------------------- */
        var setup = function() {
            fpdf_designer.html('');
            $('#fpdf_options_box').remove();

            fpdf_designer.before('<div class="text-center" id="fpdf_options_box"><input type="checkbox" checked id="show_helper"> Show helper &nbsp;<input type="checkbox" checked id="show_invisible"> Show invisible elements &nbsp;<input type="checkbox" checked id="use_lines"> Use orientation lines</div>');
            fpdf_designer.css({
                'width': (opt.config.paper_width * opt.config.px_per_mm) + 'px',
                'height': (opt.config.paper_height * opt.config.px_per_mm) + 'px',
                'padding-top': parseFloat(opt.config.pdf_top_margin * opt.config.px_per_mm).toFixed(opt.config.decimals) + 'px',
                'padding-left': parseFloat(opt.config.pdf_left_margin * opt.config.px_per_mm).toFixed(opt.config.decimals) + 'px',
                'padding-right': parseFloat(opt.config.pdf_right_margin * opt.config.px_per_mm).toFixed(opt.config.decimals) + 'px',
                'padding-bottom': parseFloat(opt.config.pdf_top_margin * opt.config.px_per_mm).toFixed(opt.config.decimals) + 'px'
            });

            fpdf_designer.html('<div id="fpdf_designer_area"></div>');
            fpdf_designer_area = $('#fpdf_designer_area');

            $('body').append('<div id="vertical_helper_line" class="d-none"></div>');
            $('body').append('<div id="horizontal_helper_line" class="d-none"></div>');

            /* --------------------------------------------------- */
            /* checkbox show orientation lines on change */
            /* --------------------------------------------------- */
            $('#use_lines').on('change', function() {
                if ($(this).is(':checked')) {
                    orientation_lines = true;
                } else {
                    orientation_lines = false;
                }
            });

            paper_offset_x_start = fpdf_designer.offset().left - opt.config.body_offset;
            paper_offset_x_end = parseFloat(paper_offset_x_start) + parseFloat(fpdf_designer.innerWidth());

            paper_offset_y_start = fpdf_designer.offset().top - opt.config.body_offset;
            paper_offset_y_end = parseFloat(paper_offset_y_start) + parseFloat(fpdf_designer.innerHeight());

            create_script_output(in_elements);
        };

        /* --------------------------------------------------- */
        /* add fpdf elements by data-fpdf identifier from elements menu */
        /* --------------------------------------------------- */
        function add_element(element_type) {

            in_elements_count++;
            in_elements[in_elements_count] = {};

            var hide_helper_class = show_helper ? '' : 'element-hide';
            var hide_invisible_class = show_invisible ? '' : 'element-hide';

            var old_background = null;

            switch (element_type) {
                /* --------------------------------------------------- */
                /* fpdf cell */
                /* --------------------------------------------------- */
                case 'cell':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_cell" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="cell" data-isdraggable="true" style="right:' + (opt.config.pdf_right_margin * opt.config.px_per_mm) + 'px"><span id="fpdf_element_content__' + in_elements_count + '" class="d-block">Cell</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Cell'; // fpdf identifier
                    in_elements[in_elements_count].font = ''; // font for fpdf
                    in_elements[in_elements_count].fontsize = 0; // fontsize in points for fpdf
                    in_elements[in_elements_count].temp_fontsize = opt.config.pdf_default_fontsize; // for intern css calculation
                    in_elements[in_elements_count].setfill = false; // fill out or not
                    in_elements[in_elements_count].border = 0; // set border 'TLRB'
                    in_elements[in_elements_count].value = 'Cell'; // value for fpdf
                    in_elements[in_elements_count].height = 5; // height in mm for fpdf
                    in_elements[in_elements_count].autoheight = true; // calculate height bei fontsize
                    in_elements[in_elements_count].width = 0; // width in mm for fpdf
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    in_elements[in_elements_count].textalign = 'L'; // text align for fpdf LCR
                    in_elements[in_elements_count].fontstyle = null; // fontstyle for fpdf I, B, BI
                    in_elements[in_elements_count].fillcolor = []; // fill color
                    in_elements[in_elements_count].drawcolor = []; // draw color
                    in_elements[in_elements_count].textcolor = []; // textcolor
                    element_type = 'cell';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf text */
                    /* --------------------------------------------------- */
                case 'text':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_text" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="text" data-isdraggable="true" style="margin-top:-' + opt.config.pdf_default_fontsize * opt.config.px_per_point + 'px;top:' + opt.config.pdf_default_fontsize * opt.config.px_per_point + 'px;"><span id="fpdf_element_content__' + in_elements_count + '">Text</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Text'; // fpdf identifier
                    in_elements[in_elements_count].value = 'Text';
                    in_elements[in_elements_count].font = '';
                    in_elements[in_elements_count].fontsize = 0;
                    in_elements[in_elements_count].fontstyle = null;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    in_elements[in_elements_count].textcolor = []; // textcolor
                    element_type = 'text';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf write */
                    /* --------------------------------------------------- */
                case 'write':
                    fpdf_designer_area.append('<div class="fpdf_in_element fpdf_write" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="write" data-isdraggable="true"><span id="fpdf_element_content__' + in_elements_count + '">Write</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Write'; // fpdf identifier
                    in_elements[in_elements_count].value = 'Write';
                    in_elements[in_elements_count].font = '';
                    in_elements[in_elements_count].fontsize = 0;
                    in_elements[in_elements_count].fontstyle = null;
                    in_elements[in_elements_count].height = 5;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    in_elements[in_elements_count].textcolor = []; // textcolor
                    element_type = 'write';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf line */
                    /* --------------------------------------------------- */
                case 'line':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_line" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="line" data-isdraggable="true"><hr><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Line'; // fpdf identifier
                    in_elements[in_elements_count].height = 0;
                    in_elements[in_elements_count].width = 50;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    in_elements[in_elements_count].drawcolor = []; // draw color
                    element_type = 'line';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf link */
                    /* --------------------------------------------------- */
                case 'link':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_link" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="link" data-isdraggable="true" onclick="return false;"><span id="fpdf_element_content__' + in_elements_count + '">Link</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Link'; // fpdf identifier
                    in_elements[in_elements_count].font = '';
                    in_elements[in_elements_count].fontsize = 0;
                    in_elements[in_elements_count].value = 'Link';
                    in_elements[in_elements_count].height = 5;
                    in_elements[in_elements_count].width = 0;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    in_elements[in_elements_count].fontstyle = null;
                    in_elements[in_elements_count].textcolor = []; // textcolor
                    element_type = 'link';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf multicell */
                    /* --------------------------------------------------- */
                case 'multicell':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_multicell" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="multicell" data-isdraggable="true" style="right:' + (opt.config.pdf_right_margin * opt.config.px_per_mm) + 'px"><span id="fpdf_element_content__' + in_elements_count + '" class="d-block">MultiCell</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'MultiCell'; // fpdf identifier
                    in_elements[in_elements_count].font = '';
                    in_elements[in_elements_count].fontsize = 0;
                    in_elements[in_elements_count].temp_fontsize = opt.config.pdf_default_fontsize; // for intern css calculation
                    in_elements[in_elements_count].border = 0;
                    in_elements[in_elements_count].setfill = false;
                    in_elements[in_elements_count].value = 'MultiCell';
                    in_elements[in_elements_count].height = 5;
                    in_elements[in_elements_count].autoheight = true; // calculate height bei fontsize
                    in_elements[in_elements_count].width = 0;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    in_elements[in_elements_count].textalign = 'L';
                    in_elements[in_elements_count].fontstyle = null;
                    in_elements[in_elements_count].fillcolor = []; // fill color
                    in_elements[in_elements_count].drawcolor = []; // draw color
                    in_elements[in_elements_count].textcolor = []; // textcolor
                    element_type = 'multicell';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf image */
                    /* --------------------------------------------------- */
                case 'image':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_image" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="image" data-isdraggable="true"><span id="fpdf_element_content__' + in_elements_count + '">Url / Path</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Image'; // fpdf identifier
                    in_elements[in_elements_count].imagetype = '';
                    in_elements[in_elements_count].value = 'Image';
                    in_elements[in_elements_count].height = 39;
                    in_elements[in_elements_count].width = 50;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    element_type = 'image';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf ln */
                    /* --------------------------------------------------- */
                case 'ln':
                    fpdf_designer_area.append('<div class="fpdf_in_element fpdf_ln invisible-element ' + hide_invisible_class + '" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="ln" data-isdraggable="true"><span id="fpdf_element_content__' + in_elements_count + '">Ln &ldsh;</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Ln'; // fpdf identifier
                    in_elements[in_elements_count].height = 5;
                    in_elements[in_elements_count].top = 0 + opt.config.pdf_top_margin; // top in mm
                    in_elements[in_elements_count].left = 0 + opt.config.pdf_left_margin; // left in mm
                    element_type = 'ln';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf rect */
                    /* --------------------------------------------------- */
                case 'rect':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_rect" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="rect" data-isdraggable="true"><span id="fpdf_element_content__' + in_elements_count + '"></span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'Rect'; // fpdf identifier
                    in_elements[in_elements_count].height = 20;
                    in_elements[in_elements_count].width = 30;
                    in_elements[in_elements_count].style = 'D';
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    in_elements[in_elements_count].fillcolor = []; // fill color
                    in_elements[in_elements_count].drawcolor = []; // draw color
                    element_type = 'rect';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf setfillcolor */
                    /* --------------------------------------------------- */
                case 'setfillcolor':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_setfillcolor invisible-element ' + hide_invisible_class + '" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="setfillcolor" data-isdraggable="true"><span id="fpdf_element_content__' + in_elements_count + '">SetFillColor &rarr; </span><span id="color_info_box__' + in_elements_count + '">( 255, 255, 255 )</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'SetFillColor'; // fpdf identifier
                    in_elements[in_elements_count].r = 255;
                    in_elements[in_elements_count].g = 255;
                    in_elements[in_elements_count].b = 255;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    element_type = 'setfillcolor';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf setdrawcolor */
                    /* --------------------------------------------------- */
                case 'setdrawcolor':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_setdrawcolor invisible-element ' + hide_invisible_class + '" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="setdrawcolor" data-isdraggable="true"><span id="fpdf_element_content__' + in_elements_count + '">SetDrawColor &rarr; </span><span id="color_info_box__' + in_elements_count + '">(0)</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'SetDrawColor'; // fpdf identifier
                    in_elements[in_elements_count].r = 0;
                    in_elements[in_elements_count].g = null;
                    in_elements[in_elements_count].b = null;
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    element_type = 'setdrawcolor';
                    break;
                    /* --------------------------------------------------- */
                    /* fpdf settextcolor */
                    /* --------------------------------------------------- */
                case 'settextcolor':
                    fpdf_designer.append('<div class="fpdf_in_element fpdf_settextcolor invisible-element ' + hide_invisible_class + '" id="fpdf_element__' + in_elements_count + '" data-id="' + in_elements_count + '" data-type="settextcolor" data-isdraggable="true"><span id="fpdf_element_content__' + in_elements_count + '">SetTextColor &rarr; </span><span id="color_info_box__' + in_elements_count + '">(0)</span><div class="element-helper ' + hide_helper_class + '" id="fpdf_element_helper__' + in_elements_count + '">' + in_elements_count + '</div></div>');
                    in_elements[in_elements_count].editorid = in_elements_count; // id for html elements in editor
                    in_elements[in_elements_count].type = 'SetTextColor'; // fpdf identifier
                    in_elements[in_elements_count].r = 0; // red
                    in_elements[in_elements_count].g = null; // green
                    in_elements[in_elements_count].b = null; // blue
                    in_elements[in_elements_count].top = 0; // top in mm
                    in_elements[in_elements_count].left = 0; // left in mm
                    element_type = 'settextcolor';
                    break;

            }

            after_add();
        }

        function after_add() {
            var old_background;

            $('.fpdf_in_element').off();
            $('.fpdf_in_element').unbind();

            $('#show_helper').off();
            $('#show_helper').unbind();

            $('#show_invisible').off();
            $('#show_invisible').unbind();

            /* --------------------------------------------------- */
            /* checkbox show helper on change */
            /* --------------------------------------------------- */
            $('#show_helper').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.element-helper').removeClass('element-hide');
                    show_helper = true;
                } else {
                    $('.element-helper').addClass('element-hide');
                    show_helper = false;
                }
            });

            /* --------------------------------------------------- */
            /* checkbox show invisible elements on change */
            /* --------------------------------------------------- */
            $('#show_invisible').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.invisible-element').removeClass('element-hide');
                    show_invisible = true;
                } else {
                    $('.invisible-element').addClass('element-hide');
                    show_invisible = false;
                }
            });

            /* --------------------------------------------------- */
            /* add mouseevents to each element in editor */
            /* --------------------------------------------------- */
            $('.fpdf_in_element').each(function() {
                $(this).unbind();
                if ($(this).data('isdraggable')) {
                    $(this).mousedown(handle_drag_and_drop);
                }
                $(this).on('mouseenter', function() {
                    old_background = $(this).css('background-color');
                });
                $(this).on('mouseover', function() {
                    $(this).css({ 'background-color': 'rgba(200,200,200, .3)' });
                });
                $(this).on('mouseleave', function() {
                    $(this).css({ 'background-color': old_background });
                });
            });

            $('.fpdf_multicell, .fpdf_cell, .fpdf_rect, .fpdf_image, .fpdf_link').each(function() {
                $(this).on('mouseenter', function() {
                    set_resizer($(this));
                });
                $(this).on('mouseleave', function() {
                    remove_resizer($(this));
                });
            });


            right_click_handle();
            create_script_output(in_elements);
        }

        /* --------------------------------------------------- */
        /* resize handler */
        /* --------------------------------------------------- */
        function set_resizer(element) {
            var fpdf_resizer = '';
            element.addClass('fpdf_resizable');

            fpdf_resizer += "<div class='resizers' id='fpdf_element_resizer__" + element.data('id') + "'>";
            fpdf_resizer += "<div class='resizer bottom-right'></div>";
            fpdf_resizer += "</div>";

            if (element.find('.resizers').length === 0) {
                element.prepend(fpdf_resizer);
            }

            handle_resizing('#fpdf_element__' + element.data('id'));

        }

        function remove_resizer(element) {
            if (!resizer_mouse_is_in) {
                element.removeClass('fpdf_resizable');
                $('#fpdf_element_resizer__' + element.data('id')).remove();
            }
        }

        function handle_resizing(div) {
            var element = $(div);
            var resizers = $(div + ' .resizer');
            var original_width = 0,
                original_height = 0,
                original_x = 0,
                original_y = 0,
                original_mouse_x = 0,
                original_mouse_y = 0;

            //for (var i = 0;i < resizers.length; i++) {
            resizers.each(function() {
                var currentResizer = $(this);
                currentResizer.on('mousedown', function(e) {
                    //e.preventDefault();
                    resizer_mouse_is_in = true;

                    original_width = element.width();
                    original_height = element.height();
                    original_x = element.offset().left;
                    original_y = element.offset().top;
                    original_mouse_x = e.pageX;
                    original_mouse_y = e.pageY;

                    $('body')
                        .on('mouseup', stopResize)
                        .on('mousemove', resize);
                });

                function resize(e) {
                    if (currentResizer.hasClass('bottom-right')) {
                        var resize_width = original_width + (e.pageX - original_mouse_x);
                        var max_to_right = parseFloat(fpdf_designer.offset().left + fpdf_designer.outerWidth());

                        resize_width = (original_x + resize_width) > max_to_right ? max_to_right - original_x : resize_width;

                        element.css({
                            'width': resize_width + 'px',
                            'height': original_height + (e.pageY - original_mouse_y) + 'px'
                        });
                    } else if (currentResizer.hasClass('bottom-left')) {
                        element.css({
                            'width': original_width - (e.pageX - original_mouse_x) + 'px',
                            'height': original_height + (e.pageY - original_mouse_y) + 'px',
                            'left': original_x + (e.pageX - original_mouse_x) + 'px'
                        });
                    } else if (currentResizer.hasClass('top-right')) {
                        element.css({
                            'width': original_width + (e.pageX - original_mouse_x) + 'px',
                            'height': original_height - (e.pageY - original_mouse_y) + 'px',
                            'top': original_y + (e.pageY - original_mouse_y) + 'px'
                        });
                    } else {
                        element.css({
                            'width': original_width - (e.pageX - original_mouse_x) + 'px',
                            'height': original_height - (e.pageY - original_mouse_y) + 'px',
                            'top': original_y + (e.pageY - original_mouse_y) + 'px',
                            'left': original_x + (e.pageX - original_mouse_x) + 'px'
                        });
                    }

                    element.css({ 'line-height': element.height() + 'px' });
                }

                function stopResize() {
                    $('body')
                        .off('mousemove', resize)
                        .off('mouseup', stopResize);

                    in_elements[element.data('id')].height = (element.height() / opt.config.px_per_mm).toFixed(opt.config.decimals);
                    in_elements[element.data('id')].width = ((element.width() / opt.config.px_per_mm) + 2).toFixed(opt.config.decimals);
                    in_elements[element.data('id')].autoheight = false;


                    var css_height = element.height(),
                        line_height = css_height,
                        text_content = $('#fpdf_element_content__' + element.data('id')).html(),
                        row_count = text_content.split(/\r\n|\r|\n|\u00AD/g).length;

                    css_height = row_count === 0 ? css_height : css_height * row_count;

                    if (in_elements[element.data('id')].type === 'MultiCell') {
                        css_height = (element.outerHeight() + 10) < element[0].scrollHeight ? element[0].scrollHeight : css_height;
                    }
                    element.css({ 'height': css_height + 'px' });

                    element.css({ 'line-height': line_height + 'px' });

                    resizer_mouse_is_in = false;
                    remove_resizer(element);
                    create_script_output(in_elements);
                }
            });
        }

        /* --------------------------------------------------- */
        /* drag and drop handler */
        /* --------------------------------------------------- */
        function handle_drag_and_drop(e) {
            var current_tops = [],
                current_lefts = [];

            fpdf_designer.updateEditorXY();

            /* init if left mouse button */
            if (e.which === 1 && $(e.target).hasClass('resizer') === false) {
                var my_dragging = {};
                my_dragging.pageX0 = e.pageX;
                my_dragging.pageY0 = e.pageY;
                my_dragging.elem = this;
                my_dragging.offset0 = $(this).offset();
                my_dragging.currentleft = $(my_dragging.elem).offset().left;
                my_dragging.currenttop = $(my_dragging.elem).offset().top;

                /* --------------------------------------------------- */
                /* use orientation lines if activated */
                /* --------------------------------------------------- */
                if (orientation_lines) {
                    $('#vertical_helper_line').css({ 'left': my_dragging.offset0.left.toFixed(0) + 'px' });
                    $('#horizontal_helper_line').css({ 'top': my_dragging.offset0.top.toFixed(0) - $(document).scrollTop() + 'px' });

                    $('#vertical_helper_line').removeClass('d-none');
                    $('#horizontal_helper_line').removeClass('d-none');

                    fpdf_designer.find('.fpdf_in_element').not(this).each(function() {
                        current_tops.push($(this).offset().top.toFixed(0));
                        current_lefts.push($(this).offset().left.toFixed(0));
                    });

                    current_tops = current_tops.filter(function(x, i, a) {
                        return a.indexOf(x) === i;
                    });

                    current_lefts = current_lefts.filter(function(x, i, a) {
                        return a.indexOf(x) === i;
                    });

                    if (current_lefts.indexOf(my_dragging.offset0.left.toFixed(0)) >= 0) {
                        $('#vertical_helper_line').css({ 'left': my_dragging.currentleft.toFixed(0) + 'px' });
                        $('#vertical_helper_line').css({ 'background-color': '#ff0000' });
                        $('#vertical_helper_line').css({ 'width': '2px' });
                    } else {
                        $('#vertical_helper_line').css({ 'background-color': '#333' });
                        $('#vertical_helper_line').css({ 'width': '1px' });
                    }

                    if (current_tops.indexOf(my_dragging.offset0.top.toFixed(0)) >= 0) {
                        $('#horizontal_helper_line').css({ 'top': my_dragging.currenttop.toFixed(0) - $(document).scrollTop() + 'px' });
                        $('#horizontal_helper_line').css({ 'background-color': '#ff0000' });
                        $('#horizontal_helper_line').css({ 'height': '2px' });
                    } else {
                        $('#horizontal_helper_line').css({ 'background-color': '#333' });
                        $('#horizontal_helper_line').css({ 'height': '1px' });
                    }
                } else {
                    $('#vertical_helper_line').addClass('d-none');
                    $('#horizontal_helper_line').addClass('d-none');
                }

                $('body')
                    .on('mouseup', handle_mouseup)
                    .on('mousemove', handle_dragging);
            }

            /* dragging handler */
            function handle_dragging(e) {

                my_dragging.currentleft = my_dragging.offset0.left + (e.pageX - my_dragging.pageX0);
                my_dragging.currenttop = my_dragging.offset0.top + (e.pageY - my_dragging.pageY0);

                if ($(my_dragging.elem).data('type') === 'ln' ||
                    $(my_dragging.elem).data('type') === 'setfillcolor' ||
                    $(my_dragging.elem).data('type') === 'setdrawcolor' ||
                    $(my_dragging.elem).data('type') === 'settextcolor' ||
                    $(my_dragging.elem).data('type') === 'write') {
                    my_dragging.currentleft = my_dragging.offset0.left;
                    $(my_dragging.elem).offset({ top: my_dragging.currenttop, left: my_dragging.currentleft });
                } else {

                    /* --------------------------------------------------- */
                    /* use orientation lines if activated */
                    /* --------------------------------------------------- */
                    if (orientation_lines) {
                        $('#vertical_helper_line').css({ 'left': my_dragging.currentleft.toFixed(0) + 'px' });
                        $('#horizontal_helper_line').css({ 'top': my_dragging.currenttop.toFixed(0) - $(document).scrollTop() + 'px' });

                        if (current_lefts.indexOf(my_dragging.currentleft.toFixed(0)) >= 0) {
                            $('#vertical_helper_line').css({ 'background-color': '#ff0000' });
                            $('#vertical_helper_line').css({ 'width': '2px' });
                        } else {
                            $('#vertical_helper_line').css({ 'background-color': '#333' });
                            $('#vertical_helper_line').css({ 'width': '1px' });
                        }

                        if (current_tops.indexOf(my_dragging.currenttop.toFixed(0)) >= 0) {
                            $('#horizontal_helper_line').css({ 'background-color': '#ff0000' });
                            $('#horizontal_helper_line').css({ 'height': '2px' });
                        } else {
                            $('#horizontal_helper_line').css({ 'background-color': '#333' });
                            $('#horizontal_helper_line').css({ 'height': '1px' });
                        }
                    }

                    if ($(my_dragging.elem).data('type') === 'text') {
                        $(my_dragging.elem).offset({ top: my_dragging.currenttop, left: my_dragging.currentleft });
                    } else {
                        $(my_dragging.elem).offset({ top: my_dragging.currenttop, left: my_dragging.currentleft });
                    }
                }
            }

            /*mouse up handler */
            function handle_mouseup(e) {
                if ((my_dragging.currentleft < paper_offset_x_start || my_dragging.currentleft > paper_offset_x_end) ||
                    (my_dragging.currenttop < paper_offset_y_start || my_dragging.currenttop > paper_offset_y_end)) {
                    delete in_elements[$(my_dragging.elem).data('id')];
                    $(my_dragging.elem).remove();
                } else {
                    in_elements[$(my_dragging.elem).data('id')].top = ($(my_dragging.elem).position().top / opt.config.px_per_mm).toFixed(opt.config.decimals);
                    in_elements[$(my_dragging.elem).data('id')].left = ($(my_dragging.elem).position().left / opt.config.px_per_mm).toFixed(opt.config.decimals);
                }

                $('body')
                    .off('mousemove', handle_dragging)
                    .off('mouseup', handle_mouseup);

                $('#horizontal_helper_line').addClass('d-none');
                $('#vertical_helper_line').addClass('d-none');

                create_script_output(in_elements);
            }
        }

        /* --------------------------------------------------- */
        /* right click context menu handler */
        /* --------------------------------------------------- */
        function right_click_handle() {
            var parent_context = this;
            $.contextMenu("destroy");

            $.contextMenu({
                selector: '.fpdf_in_element',
                build: function($triggerElement, e) {
                    var item_list = parent_context['contextmenu_' + $('#' + $triggerElement[0].id).data('type')](opt);
                    return {
                        callback: function(key, options) {
                            var current_element = $('#' + options.$trigger[0].id),
                                current_element_id = current_element.data('id');
                            var values = key.split("-");

                            var val_key = values[0],
                                val_value = values[1];

                            /* --------------------------------------------------- */
                            /* switch between key from context menu
                               e.g. var menu = 	{
                            			"delete-element": {"name": "Delete"},
                            			"setheight-element": {"name": "Change height"}
                            		};
                               in this case delete and setheight are keys*/
                            /* --------------------------------------------------- */
                            switch (val_key) {
                                /* --------------------------------------------------- */
                                /* click on font */
                                /* --------------------------------------------------- */
                                case 'font':
                                    current_element.css({ 'font-family': val_value });
                                    in_elements[current_element_id].font = val_value;
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on setfill */
                                    /* --------------------------------------------------- */
                                case 'setfill':
                                    in_elements[current_element_id].setfill = val_value === 'yes' ? true : false;
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on colors */
                                    /* --------------------------------------------------- */
                                case 'elemcolor':
                                    switch (val_value) {
                                        case 'setfillcolor':
                                            set_element_colors(current_element, 'setfillcolor');
                                            break;
                                        case 'setdrawcolor':
                                            set_element_colors(current_element, 'setdrawcolor');
                                            break;
                                        case 'settextcolor':
                                            set_element_colors(current_element, 'settextcolor');
                                            break;
                                        case 'remove':
                                            in_elements[current_element_id].fillcolor = [];
                                            in_elements[current_element_id].drawcolor = [];
                                            in_elements[current_element_id].textcolor = [];
                                            create_script_output(in_elements);
                                            break;
                                    }
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on removefont */
                                    /* --------------------------------------------------- */
                                case 'removefont':
                                    current_element.css({ 'font-family': 'inherit' });
                                    current_element.css({ 'font-size': (12 * opt.config.px_per_point) + 'px' });
                                    current_element.css({ 'font-style': 'normal' });
                                    current_element.css({ 'font-weight': 'normal' });
                                    in_elements[current_element_id].font = '';
                                    in_elements[current_element_id].fontsize = 0;
                                    in_elements[current_element_id].fontstyle = null;
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on fontsize */
                                    /* --------------------------------------------------- */
                                case 'fontsize':
                                    current_element.css({ 'font-size': (val_value * opt.config.px_per_point) + 'px' });

                                    var css_height = current_element.height();
                                    var line_height = css_height;

                                    if (in_elements[current_element.data('id')].type === 'Cell' ||
                                        in_elements[current_element.data('id')].type === 'MultiCell') {
                                        var text_content = $('#fpdf_element_content__' + current_element.data('id')).html();
                                        var row_count = text_content.split(/\r\n|\r|\n/).length;

                                        css_height = row_count === 0 ? css_height : css_height * row_count;
                                        current_element.css({ 'height': css_height + 'px' });

                                        if (in_elements[current_element.data('id')].autoheight) {
                                            current_element.css({ 'line-height': 1 });
                                        } else {
                                            current_element.css({ 'line-height': line_height + 'px' });
                                        }
                                    }

                                    if (in_elements[current_element.data('id')].type === 'Text') {
                                        current_element.css({ 'margin-top': '-' + (val_value * opt.config.px_per_point) + 'px' });
                                    }

                                    in_elements[current_element_id].fontsize = val_value;
                                    in_elements[current_element_id].temp_fontsize = val_value;
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on imageformat */
                                    /* --------------------------------------------------- */
                                case 'imageformat':
                                    if (val_value === 'remove') {
                                        in_elements[current_element_id].imagetype = '';
                                    } else {
                                        in_elements[current_element_id].imagetype = val_value.toString().toUpperCase();
                                    }
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on delete */
                                    /* --------------------------------------------------- */
                                case 'delete':
                                    delete in_elements[current_element.data('id')];
                                    current_element.remove();
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on rectstyle */
                                    /* --------------------------------------------------- */
                                case 'rectstyle':
                                    in_elements[current_element_id].style = val_value;
                                    switch (val_value) {
                                        case 'D':
                                            current_element.css({ 'border': '1px solid #333' });
                                            break;
                                        case 'F':
                                            current_element.css({ 'border': 'none' });
                                            break;
                                        case 'DF':
                                            current_element.css({ 'border': '1px solid #333' });
                                            break;
                                    }
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on setvalue */
                                    /* --------------------------------------------------- */
                                case 'setvalue':
                                    change_value(current_element);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on setmulticellvalue */
                                    /* --------------------------------------------------- */
                                case 'setmulticellvalue':
                                    change_multicell_value(current_element);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on setlink */
                                    /* --------------------------------------------------- */
                                case 'setlink':
                                    change_value(current_element);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on setheight */
                                    /* --------------------------------------------------- */
                                case 'setheight':
                                    change_height(current_element);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on setwidth */
                                    /* --------------------------------------------------- */
                                case 'setwidth':
                                    change_width(current_element);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on greyscale */
                                    /* --------------------------------------------------- */
                                case 'setgreyscale':
                                    change_greyscale(current_element);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on setrgb */
                                    /* --------------------------------------------------- */
                                case 'setrgb':
                                    change_rgb(current_element);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on border */
                                    /* --------------------------------------------------- */
                                case 'border':
                                    switch (val_value) {
                                        case 'remove':
                                            current_element.css({
                                                'border-top': 'none',
                                                'border-bottom': 'none',
                                                'border-right': 'none',
                                                'border-left': 'none'
                                            });
                                            in_elements[current_element_id].border = 0;
                                            break;
                                        case 'all':
                                            current_element.css({
                                                'border-top': '1px solid #333',
                                                'border-bottom': '1px solid #333',
                                                'border-right': '1px solid #333',
                                                'border-left': '1px solid #333'
                                            });
                                            in_elements[current_element_id].border = 1;
                                            break;
                                        case 'top':
                                            set_different_borders(current_element, current_element_id, 'T');
                                            break;
                                        case 'bottom':
                                            set_different_borders(current_element, current_element_id, 'B');
                                            break;
                                        case 'right':
                                            set_different_borders(current_element, current_element_id, 'R');
                                            break;
                                        case 'left':
                                            set_different_borders(current_element, current_element_id, 'L');
                                            break;
                                    }
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on textalign */
                                    /* --------------------------------------------------- */
                                case 'textalign':
                                    switch (val_value) {
                                        case 'left':
                                            current_element.css({ 'text-align': 'left' });
                                            in_elements[current_element_id].textalign = 'L';
                                            break;
                                        case 'center':
                                            current_element.css({ 'text-align': 'center' });
                                            in_elements[current_element_id].textalign = 'C';
                                            break;
                                        case 'right':
                                            current_element.css({ 'text-align': 'right' });
                                            in_elements[current_element_id].textalign = 'R';
                                            break;
                                    }
                                    create_script_output(in_elements);
                                    break;
                                    /* --------------------------------------------------- */
                                    /* click on fontstyle */
                                    /* --------------------------------------------------- */
                                case 'fontstyle':
                                    switch (val_value) {
                                        case 'normal':
                                            current_element.css({ 'font-style': 'normal', 'font-weight': 'normal' });
                                            in_elements[current_element_id].fontstyle = '';
                                            break;
                                        case 'bold':
                                            current_element.css({ 'font-style': 'normal', 'font-weight': 'bold' });
                                            in_elements[current_element_id].fontstyle = 'B';
                                            break;
                                        case 'normalitalic':
                                            current_element.css({ 'font-style': 'italic', 'font-weight': 'normal' });
                                            in_elements[current_element_id].fontstyle = 'I';
                                            break;
                                        case 'bolditalic':
                                            current_element.css({ 'font-style': 'italic', 'font-weight': 'bold' });
                                            in_elements[current_element_id].fontstyle = 'BI';
                                            break;
                                    }
                                    create_script_output(in_elements);
                                    break;
                            }
                        },
                        items: item_list
                    };
                }
            });
        }

        /* --------------------------------------------------- */
        /* set border styles to html elements by fpdf indicators TBRL */
        /* --------------------------------------------------- */
        function set_different_borders(current_element, current_element_id, border_position) {
            var current_border = (in_elements[current_element_id].border).toString(),
                has_top = false,
                has_bottom = false,
                has_right = false,
                has_left = false;

            current_border = current_border.replace('1', '');
            current_border = current_border.replace('0', '');

            current_border = current_border.indexOf(border_position) < 0 ? current_border + border_position : current_border;

            current_element.css({ 'border': 'none' });

            if (current_border.indexOf('T') < 0) {
                current_element.css({ 'border-top': 'none' });
            } else {
                current_element.css({ 'border-top': '1px solid #333' });
                has_top = true;
            }

            if (current_border.indexOf('B') < 0) {
                current_element.css({ 'border-bottom': 'none' });
            } else {
                current_element.css({ 'border-bottom': '1px solid #333' });
                has_bottom = true;
            }

            if (current_border.indexOf('R') < 0) {
                current_element.css({ 'border-right': 'none' });
            } else {
                current_element.css({ 'border-right': '1px solid #333' });
                has_right = true;
            }

            if (current_border.indexOf('L') < 0) {
                current_element.css({ 'border-left': 'none' });
            } else {
                current_element.css({ 'border-left': '1px solid #333' });
                has_left = true;
            }

            current_border = has_top && has_bottom && has_right && has_left ? 1 : current_border;
            in_elements[current_element_id].border = current_border;
        }

        /* --------------------------------------------------- */
        /* set value of fpdf element */
        /* --------------------------------------------------- */
        function change_value(current_element) {
            $.confirm({
                title: 'Change value',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>New value</label>' +
                    '<input type="text" placeholder="New value" class="newvalue form-control" value="' + $('#fpdf_element_content__' + current_element.data('id')).html() + '"/>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Set',
                        btnClass: 'btn-blue',
                        action: function() {
                            var newvalue = this.$content.find('.newvalue').val();
                            if (newvalue.trim() === '') {
                                newvalue = '{empty}';
                            }
                            $('#fpdf_element_content__' + current_element.data('id')).html(newvalue.replace(/\r\n|\r|\n/g, "<br />"));
                            in_elements[current_element.data('id')].value = newvalue;
                            create_script_output(in_elements);
                        }
                    },
                    cancel: function() {},
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        }

        /* --------------------------------------------------- */
        /* change/set grey scale of fpdf element */
        /* --------------------------------------------------- */
        function change_greyscale(current_element) {
            $.confirm({
                title: 'Set grey scale',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>New grey scale</label>' +
                    '<input type="text" placeholder="New grey scale" class="newvalue form-control" />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Set',
                        btnClass: 'btn-blue',
                        action: function() {
                            var newvalue = this.$content.find('.newvalue').val();
                            newvalue = newvalue === '' ? 0 : parseInt(newvalue, 10);
                            newvalue = newvalue < 0 ? 0 : newvalue;
                            newvalue = newvalue > 255 ? 255 : newvalue;
                            in_elements[current_element.data('id')].r = newvalue;
                            in_elements[current_element.data('id')].g = null;
                            in_elements[current_element.data('id')].b = null;
                            $('#color_info_box__' + current_element.data('id')).text('( ' + newvalue + ' )');
                            create_script_output(in_elements);
                        }
                    },
                    cancel: function() {},
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('.newvalue').on('input', function() {
                        var match = (/(\d{0,10})/g).exec(this.value.replace(/[^\d.]/g, ''));
                        this.value = match[1];
                        this.value = this.value === '' ? '' : this.value;
                    });
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        }

        /* --------------------------------------------------- */
        /* change/set rgb value of fpdf element */
        /* --------------------------------------------------- */
        function change_rgb(current_element) {
            $.confirm({
                columnClass: 'col-6',
                title: 'Set/change color',
                content: '' +
                    '<label class="w-100">New color</label>' +
                    '<div class="row">' +
                    '<div class="col-7">' +
                    '<p><input type="text" class="colorpicker hidden-color-box"></p>' +
                    '</div>' +
                    '<div class="col-5">' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label class="w-100 p-0 m-0"><small>Red</small></label>' +
                    '<input type="text" placeholder="R" class="val-r form-control rgb" />' +
                    '<label class="w-100 p-0 m-0"><small>Green</small></label>' +
                    '<input type="text" placeholder="G" class="val-g form-control rgb" />' +
                    '<label class="w-100 p-0 m-0"><small>Blue</small></label>' +
                    '<input type="text" placeholder="B" class="val-b form-control rgb" />' +
                    '</div>' +
                    '</form>' +
                    '</div>',
                onOpen: function() {
                    $(function() {
                        $('.jQWCP-wWheel').off('click');
                        $('.colorpicker').off('slidermove');

                        $('.colorpicker').wheelColorPicker({
                            layout: 'block',
                            format: 'rgb'
                        });
                        $('.jQWCP-wWheel').on('click', function() {
                            var colors = $('.colorpicker').wheelColorPicker('getValue', 'hex');
                            var rgb_values = hex2rgb(colors);

                            $('.val-r').val(rgb_values[0]);
                            $('.val-g').val(rgb_values[1]);
                            $('.val-b').val(rgb_values[2]);
                        });
                        $('.colorpicker').on('slidermove', function() {
                            var colors = $('.colorpicker').wheelColorPicker('getValue', 'hex');
                            var rgb_values = hex2rgb(colors);

                            $('.val-r').val(rgb_values[0]);
                            $('.val-g').val(rgb_values[1]);
                            $('.val-b').val(rgb_values[2]);
                        });
                        $('.val-r, .val-g, .val-b').on('input', function() {
                            var cur_r = $('.val-r').val() === '' ? 0 : $('.val-r').val();
                            var cur_g = $('.val-g').val() === '' ? 0 : $('.val-g').val();
                            var cur_b = $('.val-b').val() === '' ? 0 : $('.val-b').val();

                            $('.colorpicker').wheelColorPicker('setValue', 'rgb(' + cur_r + ',' + cur_g + ',' + cur_b + ')');
                        });
                    });
                },
                buttons: {
                    formSubmit: {
                        text: 'Set',
                        btnClass: 'btn-blue',
                        action: function() {
                            var val_r = this.$content.find('.val-r').val();
                            var val_g = this.$content.find('.val-g').val();
                            var val_b = this.$content.find('.val-b').val();

                            val_r = val_r === '' ? 0 : parseInt(val_r, 10);
                            val_r = val_r < 0 ? 0 : val_r;
                            val_r = val_r > 255 ? 255 : val_r;

                            val_g = val_g === '' ? 0 : parseInt(val_g, 10);
                            val_g = val_g < 0 ? 0 : val_g;
                            val_g = val_g > 255 ? 255 : val_g;

                            val_b = val_b === '' ? 0 : parseInt(val_b, 10);
                            val_b = val_b < 0 ? 0 : val_b;
                            val_b = val_b > 255 ? 255 : val_b;

                            in_elements[current_element.data('id')].r = val_r;
                            in_elements[current_element.data('id')].g = val_g;
                            in_elements[current_element.data('id')].b = val_b;
                            $('#color_info_box__' + current_element.data('id')).text('( ' + val_r + ', ' + val_g + ', ' + val_b + ' )');

                            $('.colorpicker').wheelColorPicker('destroy');
                            create_script_output(in_elements);
                        }
                    },
                    cancel: function() {},
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('.rgb').on('input', function() {
                        var match = (/(\d{0,10})/g).exec(this.value.replace(/[^\d.]/g, ''));
                        this.value = match[1];
                        this.value = this.value === '' ? 0 : this.value;
                    });
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        }

        /* --------------------------------------------------- */
        /* set colors of fpdf element */
        /* --------------------------------------------------- */
        function set_element_colors(current_element, color_type) {
            $.confirm({
                columnClass: 'col-6',
                title: 'Set/change color',
                content: '' +
                    '<label class="w-100">Set fill color</label>' +
                    '<div class="row">' +
                    '<div class="col-7">' +
                    '<p><input type="text" class="colorpicker hidden-color-box"></p>' +
                    '</div>' +
                    '<div class="col-5">' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label class="w-100 p-0 m-0"><small>Red</small></label>' +
                    '<input type="text" placeholder="R" class="val-r form-control rgb" />' +
                    '<label class="w-100 p-0 m-0"><small>Green</small></label>' +
                    '<input type="text" placeholder="G" class="val-g form-control rgb" />' +
                    '<label class="w-100 p-0 m-0"><small>Blue</small></label>' +
                    '<input type="text" placeholder="B" class="val-b form-control rgb" />' +
                    '</div>' +
                    '</form>' +
                    '</div>',
                onOpen: function() {
                    $(function() {
                        $('.jQWCP-wWheel').off('click');
                        $('.colorpicker').off('slidermove');

                        $('.colorpicker').wheelColorPicker({
                            layout: 'block',
                            format: 'rgb'
                        });
                        $('.jQWCP-wWheel').on('click', function() {
                            var colors = $('.colorpicker').wheelColorPicker('getValue', 'hex');
                            var rgb_values = hex2rgb(colors);

                            $('.val-r').val(rgb_values[0]);
                            $('.val-g').val(rgb_values[1]);
                            $('.val-b').val(rgb_values[2]);
                        });
                        $('.colorpicker').on('slidermove', function() {
                            var colors = $('.colorpicker').wheelColorPicker('getValue', 'hex');
                            var rgb_values = hex2rgb(colors);

                            $('.val-r').val(rgb_values[0]);
                            $('.val-g').val(rgb_values[1]);
                            $('.val-b').val(rgb_values[2]);
                        });
                        $('.val-r, .val-g, .val-b').on('input', function() {
                            var cur_r = $('.val-r').val() === '' ? 0 : $('.val-r').val();
                            var cur_g = $('.val-g').val() === '' ? 0 : $('.val-g').val();
                            var cur_b = $('.val-b').val() === '' ? 0 : $('.val-b').val();

                            $('.colorpicker').wheelColorPicker('setValue', 'rgb(' + cur_r + ',' + cur_g + ',' + cur_b + ')');
                        });
                    });
                },
                buttons: {
                    formSubmit: {
                        text: 'Set',
                        btnClass: 'btn-blue',
                        action: function() {
                            var val_r = this.$content.find('.val-r').val();
                            var val_g = this.$content.find('.val-g').val();
                            var val_b = this.$content.find('.val-b').val();

                            val_r = val_r === '' ? 0 : parseInt(val_r, 10);
                            val_r = val_r < 0 ? 0 : val_r;
                            val_r = val_r > 255 ? 255 : val_r;

                            val_g = val_g === '' ? 0 : parseInt(val_g, 10);
                            val_g = val_g < 0 ? 0 : val_g;
                            val_g = val_g > 255 ? 255 : val_g;

                            val_b = val_b === '' ? 0 : parseInt(val_b, 10);
                            val_b = val_b < 0 ? 0 : val_b;
                            val_b = val_b > 255 ? 255 : val_b;

                            if (color_type === 'setfillcolor') {
                                in_elements[current_element.data('id')].fillcolor = [val_r, val_g, val_b];
                            }

                            if (color_type === 'setdrawcolor') {
                                in_elements[current_element.data('id')].drawcolor = [val_r, val_g, val_b];
                            }

                            if (color_type === 'settextcolor') {
                                in_elements[current_element.data('id')].textcolor = [val_r, val_g, val_b];
                            }

                            $('.colorpicker').wheelColorPicker('destroy');
                            create_script_output(in_elements);
                        }
                    },
                    cancel: function() {},
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('.rgb').on('input', function() {
                        var match = (/(\d{0,10})/g).exec(this.value.replace(/[^\d.]/g, ''));
                        this.value = match[1];
                        this.value = this.value === '' ? 0 : this.value;
                    });
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        }

        /* --------------------------------------------------- */
        /* set value of fpdf element multicell */
        /* --------------------------------------------------- */
        function change_multicell_value(current_element) {
            $.confirm({
                title: 'Change value',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>New value</label>' +
                    '<textarea type="text" placeholder="New value" class="newvalue form-control">' + $('#fpdf_element_content__' + current_element.data('id')).html() + '</textarea>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Set',
                        btnClass: 'btn-blue',
                        action: function() {
                            var newvalue = this.$content.find('.newvalue').val();
                            if (newvalue.trim() === '') {
                                newvalue = '{empty}';
                            }
                            var css_height = current_element.height(),
                                line_height = in_elements[current_element.data('id')].height * opt.config.px_per_mm, //css_height,
                                text_content = newvalue,
                                row_count = text_content.split(/\r\n|\r|\n/).length;

                            css_height = row_count === 0 ? css_height : css_height * row_count;

                            if (in_elements[current_element.data('id')].autoheight) {
                                current_element.css({ 'line-height': 1 });
                            } else {
                                current_element.css({ 'line-height': line_height + 'px' });
                            }

                            $('#fpdf_element_content__' + current_element.data('id')).text(newvalue);

                            css_height = (current_element.outerHeight() + 10) < current_element[0].scrollHeight ? current_element[0].scrollHeight : css_height;
                            current_element.css({ 'height': css_height + 'px' });

                            in_elements[current_element.data('id')].value = newvalue;
                            create_script_output(in_elements);
                        }
                    },
                    cancel: function() {},
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        }

        /* --------------------------------------------------- */
        /* change/set height of fpdf element */
        /* --------------------------------------------------- */
        function change_height(current_element) {
            $.confirm({
                title: 'Change height',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>New height (0 = auto height)</label>' +
                    '<input type="text" placeholder="New height" class="newvalue form-control" />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Set',
                        btnClass: 'btn-blue',
                        action: function() {
                            var newvalue = this.$content.find('.newvalue').val();
                            newvalue = newvalue === '' ? 0 : parseFloat(this.$content.find('.newvalue').val());
                            if (newvalue === '' || newvalue === 0) {
                                current_element.css({ 'height': 'auto' });
                                $('#fpdf_element_content__' + current_element.data('id')).css({ 'margin-top': '0' });
                                in_elements[current_element.data('id')].height = 0;
                                in_elements[current_element.data('id')].autoheight = true;

                                if (in_elements[current_element.data('id')].type === 'Cell' ||
                                    in_elements[current_element.data('id')].type === 'MultiCell') {
                                    current_element.css({ 'line-height': 1 });
                                }

                            } else {
                                var css_height = newvalue * opt.config.px_per_mm;
                                var line_height = css_height;

                                current_element.css({ 'height': css_height + 'px' });

                                if (in_elements[current_element.data('id')].type === 'Cell' ||
                                    in_elements[current_element.data('id')].type === 'MultiCell') {
                                    var text_content = $('#fpdf_element_content__' + current_element.data('id')).html();
                                    var row_count = text_content.split(/\r\n|\r|\n/).length;

                                    css_height = row_count === 0 ? css_height : css_height * row_count;
                                    current_element.css({ 'height': css_height + 'px' });
                                    current_element.css({ 'line-height': line_height + 'px' });
                                }

                                in_elements[current_element.data('id')].height = newvalue;
                                in_elements[current_element.data('id')].autoheight = false;
                            }
                            create_script_output(in_elements);
                        }
                    },
                    cancel: function() {},
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('.newvalue').on('input', function() {
                        var match = (/(\d{0,10})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
                        this.value = match[1] + match[2];
                        this.value = this.value === '' ? '' : this.value;
                    });
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        }

        /* --------------------------------------------------- */
        /* change/set width of fpdf element */
        /* --------------------------------------------------- */
        function change_width(current_element) {
            $.confirm({
                title: 'Change width',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>New width</label>' +
                    '<input type="text" placeholder="New width" class="newvalue form-control" />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Set',
                        btnClass: 'btn-blue',
                        action: function() {
                            var newvalue = this.$content.find('.newvalue').val();
                            newvalue = newvalue === '' ? 0 : parseFloat(this.$content.find('.newvalue').val());
                            if (newvalue < 1) {

                                if (in_elements[current_element.data('id')].type === 'Cell' ||
                                    in_elements[current_element.data('id')].type === 'MultiCell') {
                                    current_element.css({ 'right': (opt.config.pdf_right_margin * opt.config.px_per_mm) + 'px', 'width': 'auto' });
                                } else {
                                    current_element.css({ 'right': 0, 'width': 'auto' });
                                }

                                in_elements[current_element.data('id')].width = 0;
                            } else {
                                newvalue = newvalue < 3 ? 3 : newvalue;
                                current_element.css({ 'width': (newvalue * opt.config.px_per_mm) + 'px' });

                                if (in_elements[current_element.data('id')].type === 'MultiCell') {
                                    var css_height = current_element.height();
                                    css_height = (current_element.outerHeight() + 10) < current_element[0].scrollHeight ? current_element[0].scrollHeight : css_height;
                                    current_element.css({ 'height': css_height + 'px' });
                                    in_elements[current_element.data('id')].autoheight = false;
                                    in_elements[current_element.data('id')].height = (css_height / opt.config.px_per_mm).toFixed(opt.config.decimals);
                                }
                                in_elements[current_element.data('id')].width = newvalue;
                            }
                            create_script_output(in_elements);
                        }
                    },
                    cancel: function() {},
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('.newvalue').on('input', function() {
                        var match = (/(\d{0,10})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
                        this.value = match[1] + match[2];
                        this.value = this.value === '' ? '' : this.value;
                    });
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        }

        /* --------------------------------------------------- */
        /* reorder elements array by top position */
        /* --------------------------------------------------- */
        function reorder_elements(elements_object) {
            var obj_array = [],
                new_object = {},
                object_count = 0;


            $.each(elements_object, function(key, elem) {
                obj_array[key] = [];
                obj_array[key].key = key;
                obj_array[key].top = elem.top;
            });

            obj_array.sort(function(a, b) { return a.top - b.top; });

            obj_array.forEach(function(entry) {
                new_object[object_count] = elements_object[entry.key];
                object_count++;
            });

            return new_object;
        }

        /* --------------------------------------------------- */
        /* screen script output function */
        /* reorder and update editors ccs styles */
        /* generate the php script and output it on the screen */
        /* --------------------------------------------------- */
        function create_script_output(elements_object) {
            $(opt.config.output_container).html('');

            var output_container = $(opt.config.output_container),
                pre_container = $('<pre class="pre-fpdf"></pre>'),
                code_container = $('<code class="code-fpdf"></code>'),
                ordered_object = {},
                set_font = false,
                set_size = false,
                last_fontsize = 12,
                last_font = opt.config.standard_font,
                last_fontstyle = '',
                last_fillcolor_r = 255,
                last_fillcolor_g = 255,
                last_fillcolor_b = 255,
                last_drawcolor_r = 0,
                last_drawcolor_g = 0,
                last_drawcolor_b = 0,
                last_textcolor_r = 0,
                last_textcolor_g = 0,
                last_textcolor_b = 0,
                css_fontstyle = {},
                set_cell_height = {},
                set_r,
                set_g,
                set_b;

            pre_container.append(code_container);
            output_container.append(pre_container);

            code_container.append("&lt;?PHP<br><br>");
            code_container.append("require(APPPATH.'libraries/fpdf/fpdf.php');<br><br>");
            code_container.append("$pdf = new FPDF();<br>");

            opt.config.fpdf_headers.forEach(function(entry) {
                code_container.append("$pdf->" + entry + ";<br>");
            });

            code_container.append("$pdf->SetTopMargin(" + opt.config.pdf_top_margin + ");<br>");
            code_container.append("$pdf->SetLeftMargin(" + opt.config.pdf_left_margin + ");<br>");
            code_container.append("$pdf->SetRightMargin(" + opt.config.pdf_right_margin + ");<br>");

            code_container.append("<br><br>");

            ordered_object = reorder_elements(elements_object);

            $.each(ordered_object, function(key, elem) {
                var element_type = elem.type,
                    element_value;

                /* --------------------------------------------------- */
                /* set font size, style and family to editor elements */
                /* display rules are the same as fpdf */
                /* --------------------------------------------------- */
                last_fontsize = typeof elem.fontsize !== 'undefined' && elem.fontsize !== '' && elem.fontsize > 0 ? elem.fontsize : last_fontsize;
                last_font = typeof elem.font !== 'undefined' && elem.font !== '' ? elem.font : last_font;
                last_fontstyle = typeof elem.fontstyle !== 'undefined' && elem.fontstyle !== null ? elem.fontstyle : last_fontstyle;

                if (element_type === 'Cell' ||
                    element_type === 'MultiCell' ||
                    element_type === 'Link' ||
                    element_type === 'Text' ||
                    element_type === 'Write') {

                    if (last_fontstyle.trim() === '') {
                        css_fontstyle = { 'font-weight': 'normal', 'font-style': 'normal' };
                    } else if (last_fontstyle.trim() === 'I') {
                        css_fontstyle = { 'font-weight': 'normal', 'font-style': 'italic' };
                    } else if (last_fontstyle.trim() === 'B') {
                        css_fontstyle = { 'font-weight': 'bold', 'font-style': 'normal' };
                    } else if (last_fontstyle.trim() === 'BI') {
                        css_fontstyle = { 'font-weight': 'bold', 'font-style': 'italic' };
                    }

                    var font_add_type = last_font === 'DejaVu' ? ', sans-serif' : '';

                    $('#fpdf_element__' + elem.editorid).css({ 'font-size': (last_fontsize * opt.config.px_per_point).toFixed(2) + 'px' });
                    $('#fpdf_element__' + elem.editorid).css({ 'font-family': last_font + font_add_type });
                    $('#fpdf_element__' + elem.editorid).css(css_fontstyle);

                    if (element_type === 'Text') {
                        $('#fpdf_element__' + elem.editorid).css({ 'margin-top': '-' + (last_fontsize * opt.config.px_per_point).toFixed(2) + 'px' });
                    }

                }

                /* --------------------------------------------------- */
                /* set fill color, draw color and text color to editor elements */
                /* display rules are the same as fpdf */
                /* --------------------------------------------------- */
                if (element_type === 'SetFillColor') {
                    last_fillcolor_r = typeof elem.r !== 'undefined' && elem.r !== null ? elem.r : 255;
                    last_fillcolor_g = typeof elem.g !== 'undefined' && elem.g !== null ? elem.g : last_fillcolor_r;
                    last_fillcolor_b = typeof elem.b !== 'undefined' && elem.b !== null ? elem.b : last_fillcolor_r;
                }

                if (element_type === 'SetDrawColor') {
                    last_drawcolor_r = typeof elem.r !== 'undefined' && elem.r !== null ? elem.r : 0;
                    last_drawcolor_g = typeof elem.g !== 'undefined' && elem.g !== null ? elem.g : last_drawcolor_r;
                    last_drawcolor_b = typeof elem.b !== 'undefined' && elem.b !== null ? elem.b : last_drawcolor_r;
                }

                if (element_type === 'SetTextColor') {
                    last_textcolor_r = typeof elem.r !== 'undefined' && elem.r !== null ? elem.r : 0;
                    last_textcolor_g = typeof elem.g !== 'undefined' && elem.g !== null ? elem.g : last_textcolor_r;
                    last_textcolor_b = typeof elem.b !== 'undefined' && elem.b !== null ? elem.b : last_textcolor_r;
                }

                elem.setfill = typeof elem.setfill !== 'undefined' ? elem.setfill : false;

                /* update fill color */
                if ((element_type === 'Cell' && elem.setfill) ||
                    (element_type === 'MultiCell' && elem.setfill) ||
                    (element_type === 'Rect' && (elem.style === 'F' || elem.style === 'DF'))) {
                    if (last_fillcolor_r !== null && parseFloat(last_fillcolor_r) >= 0) {
                        $('#fpdf_element__' + elem.editorid).css({ 'background-color': 'rgba(' + last_fillcolor_r + ',' + last_fillcolor_g + ',' + last_fillcolor_b + ', 1)' });
                    }
                } else if ((element_type === 'Cell' && !elem.setfill) ||
                    (element_type === 'MultiCell' && !elem.setfill) ||
                    (element_type === 'Rect' && (elem.style !== 'F' && elem.style !== 'DF'))) {
                    $('#fpdf_element__' + elem.editorid).css({ 'background-color': 'transparent' });
                }

                /* update draw color */
                if ((element_type === 'Cell') ||
                    (element_type === 'MultiCell') ||
                    (element_type === 'Rect' && (elem.style === 'D' || elem.style === 'DF'))) {
                    if (last_drawcolor_r !== null && last_drawcolor_r >= 0) {
                        $('#fpdf_element__' + elem.editorid).css({ 'border-color': 'rgba(' + last_drawcolor_r + ',' + last_drawcolor_g + ',' + last_drawcolor_b + ', 1)' });
                    }
                }

                if (element_type === 'Line') {
                    if (last_drawcolor_r !== null && last_drawcolor_r >= 0) {
                        $('#fpdf_element__' + elem.editorid).find('hr').css({ 'background-color': 'rgba(' + last_drawcolor_r + ',' + last_drawcolor_g + ',' + last_drawcolor_b + ', 1)' });
                    }
                }

                /* update text color */
                if (element_type === 'Cell' ||
                    element_type === 'MultiCell' ||
                    element_type === 'Text' ||
                    element_type === 'Write' ||
                    element_type === 'Link') {
                    if (last_textcolor_r !== null && last_textcolor_r >= 0) {
                        if (last_textcolor_g !== null && last_textcolor_b !== null) {
                            $('#fpdf_element__' + elem.editorid).css({ 'color': 'rgba(' + last_textcolor_r + ',' + last_textcolor_g + ',' + last_textcolor_b + ', 1)' });
                        } else {
                            $('#fpdf_element__' + elem.editorid).css({ 'color': 'rgba(' + last_textcolor_r + ',' + last_textcolor_r + ',' + last_textcolor_r + ', 1)' });
                        }
                    }
                }

                /* --------------------------------------------------- */
                /* prepare script output */
                /* --------------------------------------------------- */
                if (typeof elem.value !== 'undefined') {
                    var has_php = elem.value.indexOf('{:') > -1 ? true : false;

                    element_value = "'" + elem.value + "'";

                    if (has_php) {
                        element_value = elem.value.replace(/\{:(.+?):}/g, function(m, label) {
                            return "'." + label + ".'";
                        });
                        element_value = "'" + element_value + "'";
                    }

                    element_value = element_value.replace(/(\n|\r|\n\r)/g, function(m, label) {
                        return "'.\"&bsol;n\".'";
                    });

                    element_value = element_value.replace(/\.''/g, function(m, label) {
                        return '';
                    });

                    element_value = element_value.replace(/''\./g, function(m, label) {
                        return '';
                    });

                    element_value = element_value.replace(/({empty})/g, function(m, label) {
                        return '';
                    });

                    element_value = element_value.replace(/(["]\.["])/g, function(m, label) {
                        return '';
                    });

                }

                if ((typeof elem.fontstyle !== 'undefined' && elem.fontstyle !== null && elem.fontstyle !== '') &&
                    (typeof elem.font === 'undefined' || elem.font === '')) {
                    elem.font = '::standard::'; // or set opt.config.standard_font instead of standard;
                    elem.fontsize = typeof elem.fontsize !== 'undefined' && elem.fontsize !== '' && elem.fontsize > 0 ? elem.fontsize : 12;
                }

                set_font = typeof elem.font !== 'undefined' && elem.font !== '' ? true : false;
                set_size = typeof elem.fontsize !== 'undefined' && elem.fontsize !== '' && elem.fontsize > 0 ? true : false;

                if (set_font && (typeof elem.fontsize === 'undefined' || elem.fontsize === '' || elem.fontsize < 1)) {
                    elem.fontsize = last_fontsize;
                }

                if (set_font && elem.font === '::standard::') {
                    elem.font = '';
                }

                var fontstyle_to_show = elem.fontstyle === null ? last_fontstyle === null ? '' : last_fontstyle : elem.fontstyle;

                if (typeof elem.temp_fontsize !== 'undefined') {
                    elements_object[elem.editorid].temp_fontsize = last_fontsize;
                }

                /* --------------------------------------------------- */
                /* script output */
                /* --------------------------------------------------- */
                switch (element_type) {
                    case 'Cell':
                        code_container.append("/* --- Cell --- */<br>");
                        if (elem.autoheight) {
                            set_cell_height = elem.fontsize === 0 ? last_fontsize / opt.config.px_per_mm * opt.config.px_per_point : elem.fontsize / opt.config.px_per_mm * opt.config.px_per_point;
                            elem.height = parseFloat(set_cell_height).toFixed(opt.config.decimals);
                        }
                        if (elem.textcolor.length > 0) {
                            $('#fpdf_element__' + elem.editorid).css({ 'color': 'rgba(' + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetTextColor(" + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ");<br>");
                        }
                        if (elem.fillcolor.length > 0 && elem.setfill) {
                            $('#fpdf_element__' + elem.editorid).css({ 'background-color': 'rgba(' + elem.fillcolor[0] + ',' + elem.fillcolor[1] + ',' + elem.fillcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetFillColor(" + elem.fillcolor[0] + ',' + elem.fillcolor[1] + ',' + elem.fillcolor[2] + ");<br>");
                        }
                        if (elem.drawcolor.length > 0 && elem.border === 1) {
                            $('#fpdf_element__' + elem.editorid).css({ 'border-color': 'rgba(' + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetDrawColor(" + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ");<br>");
                        }

                        elem.border = elem.border === 1 || elem.border === 0 ? elem.border : "'" + (elem.border.replace(/'/g, "")) + "'";
                        code_container.append("$pdf->SetXY(" + elem.left + ", " + elem.top + ");<br>");
                        if (set_font) { code_container.append("$pdf->SetFont('" + elem.font + "', '" + fontstyle_to_show + "', " + elem.fontsize + ");<br>"); }
                        if (!set_font && set_size) { code_container.append("$pdf->SetFontSize(" + elem.fontsize + ");<br>"); }
                        code_container.append("$pdf->Cell(" + elem.width + ", " + elem.height + ", " + element_value + ", " + elem.border + ", 1, '" + elem.textalign + "', " + elem.setfill + ");<br>");

                        if (elem.textcolor.length > 0) {
                            if (last_textcolor_r === last_textcolor_g && last_textcolor_r === last_textcolor_b) {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ',' + last_textcolor_g + ',' + last_textcolor_b + ");<br>");
                            }
                        }

                        if (elem.fillcolor.length > 0 && elem.setfill) {
                            if (last_fillcolor_r === last_fillcolor_g && last_fillcolor_r === last_fillcolor_b) {
                                code_container.append("$pdf->SetFillColor(" + last_fillcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetFillColor(" + last_fillcolor_r + ',' + last_fillcolor_g + ',' + last_fillcolor_b + ");<br>");
                            }
                        }

                        if (elem.drawcolor.length > 0 && elem.border === 1) {
                            if (last_drawcolor_r === last_drawcolor_g && last_drawcolor_r === last_drawcolor_b) {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ',' + last_drawcolor_g + ',' + last_drawcolor_b + ");<br>");
                            }
                        }

                        break;
                    case 'MultiCell':
                        code_container.append("/* --- MultiCell --- */<br>");
                        if (elem.autoheight) {
                            set_cell_height = elem.fontsize === 0 ? last_fontsize / opt.config.px_per_mm * opt.config.px_per_point : elem.fontsize / opt.config.px_per_mm * opt.config.px_per_point;
                            elem.height = parseFloat(set_cell_height).toFixed(opt.config.decimals);
                        }
                        if (elem.textcolor.length > 0) {
                            $('#fpdf_element__' + elem.editorid).css({ 'color': 'rgba(' + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetTextColor(" + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ");<br>");
                        }
                        if (elem.fillcolor.length > 0 && elem.setfill) {
                            $('#fpdf_element__' + elem.editorid).css({ 'background-color': 'rgba(' + elem.fillcolor[0] + ',' + elem.fillcolor[1] + ',' + elem.fillcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetFillColor(" + elem.fillcolor[0] + ',' + elem.fillcolor[1] + ',' + elem.fillcolor[2] + ");<br>");
                        }
                        if (elem.drawcolor.length > 0 && elem.border === 1) {
                            $('#fpdf_element__' + elem.editorid).css({ 'border-color': 'rgba(' + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetDrawColor(" + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ");<br>");
                        }

                        elem.border = elem.border === 1 || elem.border === 0 ? elem.border : "'" + (elem.border.replace(/'/g, "")) + "'";
                        code_container.append("$pdf->SetXY(" + elem.left + ", " + elem.top + ");<br>");
                        if (set_font) { code_container.append("$pdf->SetFont('" + elem.font + "', '" + fontstyle_to_show + "', " + elem.fontsize + ");<br>"); }
                        if (!set_font && set_size) { code_container.append("$pdf->SetFontSize(" + elem.fontsize + ");<br>"); }
                        code_container.append("$pdf->MultiCell(" + elem.width + ", " + elem.height + ", " + element_value + ", " + elem.border + ", '" + elem.textalign + "', " + elem.setfill + ");<br>");

                        if (elem.textcolor.length > 0) {
                            if (last_textcolor_r === last_textcolor_g && last_textcolor_r === last_textcolor_b) {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ',' + last_textcolor_g + ',' + last_textcolor_b + ");<br>");
                            }
                        }

                        if (elem.fillcolor.length > 0 && elem.setfill) {
                            if (last_fillcolor_r === last_fillcolor_g && last_fillcolor_r === last_fillcolor_b) {
                                code_container.append("$pdf->SetFillColor(" + last_fillcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetFillColor(" + last_fillcolor_r + ',' + last_fillcolor_g + ',' + last_fillcolor_b + ");<br>");
                            }
                        }

                        if (elem.drawcolor.length > 0 && elem.border === 1) {
                            if (last_drawcolor_r === last_drawcolor_g && last_drawcolor_r === last_drawcolor_b) {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ',' + last_drawcolor_g + ',' + last_drawcolor_b + ");<br>");
                            }
                        }

                        break;
                    case 'Text':
                        code_container.append("/* --- Text --- */<br>");

                        if (elem.textcolor.length > 0) {
                            $('#fpdf_element__' + elem.editorid).css({ 'color': 'rgba(' + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetTextColor(" + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ");<br>");
                        }

                        if (set_font) { code_container.append("$pdf->SetFont('" + elem.font + "', '" + fontstyle_to_show + "', " + elem.fontsize + ");<br>"); }
                        if (!set_font && set_size) { code_container.append("$pdf->SetFontSize(" + elem.fontsize + ");<br>"); }
                        code_container.append("$pdf->Text(" + elem.left + ", " + elem.top + ", " + element_value + ");<br>");

                        if (elem.textcolor.length > 0) {
                            if (last_textcolor_r === last_textcolor_g && last_textcolor_r === last_textcolor_b) {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ',' + last_textcolor_g + ',' + last_textcolor_b + ");<br>");
                            }
                        }

                        break;
                    case 'Write':
                        code_container.append("/* --- Write --- */<br>");

                        if (elem.textcolor.length > 0) {
                            $('#fpdf_element__' + elem.editorid).css({ 'color': 'rgba(' + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetTextColor(" + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ");<br>");
                        }

                        code_container.append("$pdf->SetY(" + elem.top + ");<br>");
                        if (set_font) { code_container.append("$pdf->SetFont('" + elem.font + "', '" + fontstyle_to_show + "', " + elem.fontsize + ");<br>"); }
                        if (!set_font && set_size) { code_container.append("$pdf->SetFontSize(" + elem.fontsize + ");<br>"); }
                        code_container.append("$pdf->Write(" + elem.height + ", " + element_value + ");<br>");

                        if (elem.textcolor.length > 0) {
                            if (last_textcolor_r === last_textcolor_g && last_textcolor_r === last_textcolor_b) {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ',' + last_textcolor_g + ',' + last_textcolor_b + ");<br>");
                            }
                        }

                        break;
                    case 'Line':
                        code_container.append("/* --- Line --- */<br>");

                        if (elem.drawcolor.length > 0) {
                            $('#fpdf_element__' + elem.editorid + ' hr').css({ 'border-color': 'rgba(' + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetDrawColor(" + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ");<br>");
                        }

                        var temp_end_x = (parseFloat(elem.left) + parseFloat(elem.width)).toFixed(opt.config.decimals);
                        var temp_end_y = (parseFloat(elem.top) + parseFloat(elem.height)).toFixed(opt.config.decimals);

                        code_container.append("$pdf->Line(" + elem.left + ", " + elem.top + ", " + temp_end_x + ", " + temp_end_y + ");<br>");

                        if (elem.drawcolor.length > 0) {
                            if (last_drawcolor_r === last_drawcolor_g && last_drawcolor_r === last_drawcolor_b) {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ',' + last_drawcolor_g + ',' + last_drawcolor_b + ");<br>");
                            }
                        }

                        break;
                    case 'Link':
                        code_container.append("/* --- Link --- */<br>");

                        if (elem.textcolor.length > 0) {
                            $('#fpdf_element__' + elem.editorid).css({ 'color': 'rgba(' + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetTextColor(" + elem.textcolor[0] + ',' + elem.textcolor[1] + ',' + elem.textcolor[2] + ");<br>");
                        }

                        if (set_font) { code_container.append("$pdf->SetFont('" + elem.font + "', '" + fontstyle_to_show + "', " + elem.fontsize + ");<br>"); }
                        if (!set_font && set_size) { code_container.append("$pdf->SetFontSize(" + elem.fontsize + ");<br>"); }
                        code_container.append("$pdf->Link(" + elem.left + ", " + elem.top + ", " + elem.width + ", " + elem.height + ", " + element_value + ");<br>");

                        if (elem.textcolor.length > 0) {
                            if (last_textcolor_r === last_textcolor_g && last_textcolor_r === last_textcolor_b) {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetTextColor(" + last_textcolor_r + ',' + last_textcolor_g + ',' + last_textcolor_b + ");<br>");
                            }
                        }

                        break;
                    case 'Image':
                        code_container.append("/* --- Image --- */<br>");
                        var image_type = elem.imagetype === '' ? '' : ", '" + elem.imagetype + "'";
                        code_container.append("$pdf->Image(" + element_value + ", " + elem.left + ", " + elem.top + ", " + elem.width + ", " + elem.height + image_type + ");<br>");
                        break;
                    case 'Ln':
                        code_container.append("/* --- Ln --- */<br>");
                        code_container.append("$pdf->SetY(" + elem.top + ");<br>");
                        code_container.append("$pdf->Ln(" + elem.height + ");<br>");
                        break;
                    case 'Rect':
                        code_container.append("/* --- Rect --- */<br>");

                        if (elem.fillcolor.length > 0 && (elem.style === 'F' || elem.style === 'DF')) {
                            $('#fpdf_element__' + elem.editorid).css({ 'background-color': 'rgba(' + elem.fillcolor[0] + ',' + elem.fillcolor[1] + ',' + elem.fillcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetFillColor(" + elem.fillcolor[0] + ',' + elem.fillcolor[1] + ',' + elem.fillcolor[2] + ");<br>");
                        }
                        if (elem.drawcolor.length > 0 && (elem.style === 'D' || elem.style === 'DF')) {
                            $('#fpdf_element__' + elem.editorid).css({ 'border-color': 'rgba(' + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ', 1)' });
                            code_container.append("$pdf->SetDrawColor(" + elem.drawcolor[0] + ',' + elem.drawcolor[1] + ',' + elem.drawcolor[2] + ");<br>");
                        }

                        code_container.append("$pdf->Rect(" + elem.left + ", " + elem.top + ", " + elem.width + ", " + elem.height + ", '" + elem.style + "');<br>");

                        if (elem.fillcolor.length > 0 && (elem.style === 'F' || elem.style === 'DF')) {
                            if (last_fillcolor_r === last_fillcolor_g && last_fillcolor_r === last_fillcolor_b) {
                                code_container.append("$pdf->SetFillColor(" + last_fillcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetFillColor(" + last_fillcolor_r + ',' + last_fillcolor_g + ',' + last_fillcolor_b + ");<br>");
                            }
                        }

                        if (elem.drawcolor.length > 0 && (elem.style === 'D' || elem.style === 'DF')) {
                            if (last_drawcolor_r === last_drawcolor_g && last_drawcolor_r === last_drawcolor_b) {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ");<br>");
                            } else {
                                code_container.append("$pdf->SetDrawColor(" + last_drawcolor_r + ',' + last_drawcolor_g + ',' + last_drawcolor_b + ");<br>");
                            }
                        }

                        break;
                    case 'SetFillColor':
                        code_container.append("/* --- SetFillColor --- */<br>");
                        set_r = elem.r;
                        set_g = elem.g === null ? '' : ", " + elem.g;
                        set_b = elem.b === null ? '' : ", " + elem.b;
                        code_container.append("$pdf->SetFillColor(" + set_r + set_g + set_b + ");<br>");
                        break;
                    case 'SetDrawColor':
                        code_container.append("/* --- SetDrawColor --- */<br>");
                        set_r = elem.r;
                        set_g = elem.g === null ? '' : ", " + elem.g;
                        set_b = elem.b === null ? '' : ", " + elem.b;
                        code_container.append("$pdf->SetDrawColor(" + set_r + set_g + set_b + ");<br>");
                        break;
                    case 'SetTextColor':
                        code_container.append("/* --- SetTextColor --- */<br>");
                        set_r = elem.r;
                        set_g = elem.g === null ? '' : ", " + elem.g;
                        set_b = elem.b === null ? '' : ", " + elem.b;
                        code_container.append("$pdf->SetTextColor(" + set_r + set_g + set_b + ");<br>");
                        break;
                }
            });
            code_container.append("<br><br>$pdf->Output('Created.pdf','I');<br>");
            code_container.append("?&gt;<br>");
            fpdf_designer.trigger('fpdf.changed');
        }



        function hex2rgb(hex) {
            return ['0x' + hex[0] + hex[1] | 0, '0x' + hex[2] + hex[3] | 0, '0x' + hex[4] + hex[5] | 0];
        }



        init();

        return this;
    };
})(window.jQuery);