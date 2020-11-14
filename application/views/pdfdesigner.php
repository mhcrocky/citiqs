<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html>
    <head>

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="">
        <meta charset="UTF-8">
        <title>tiqs | PDF DESIGNER</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/main-style.css">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/how-it-works.css">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/home-page.css">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/grid.css">-->


        <link rel="stylesheet" href="assets/home/styles/main-style.css">
        <link rel="stylesheet" href="assets/home/styles/how-it-works.css">
        <link rel="stylesheet" href="assets/home/styles/home-page.css">
        <link rel="stylesheet" href="assets/home/styles/grid.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>


        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="assets/home/js/vanilla-picker.js"></script>


        <meta charset="utf-8">
        <title>FPDF WYSIWYG Script Generator</title>
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <!-- CDN files jQuery and Bootstrap .js -->
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <!-- third party files .js / all are necessary -->
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <script src="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-contextmenu/jquery.contextmenu.min.js"></script>
        <script src="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-confirm/jquery.confirm.min.js"></script>
        <script src="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-wheelcolorpicker/jquery.wheelcolorpicker-3.0.5.min.js"></script>
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <!-- editor files / all are necessary .js -->
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <script src="<?php base_url(); ?>assets/pdfdesigner/js/fpdf-designer-contextmenus.js"></script>
        <script src="<?php base_url(); ?>assets/pdfdesigner/js/jquery.fpdf-designer.js"></script>


        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <!-- CDN files Bootstrap .css -->
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <!-- third party files .css / all are necessary -->
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <link href="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-contextmenu/jquery.contextmenu.min.css" rel="stylesheet">
        <link href="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-confirm/jquery.confirm.min.css" rel="stylesheet">
        <link href="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-wheelcolorpicker/jquery.wheelcolorpicker.css" rel="stylesheet">
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <!-- editor files / all are necessary .css -->
        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
        <link href="<?php base_url(); ?>assets/pdfdesigner/css/fpdf-designer-style.css" rel="stylesheet">
        <link href="<?php base_url(); ?>assets/pdfdesigner/css/ruler.css" rel="stylesheet">
    </head>

    <body>

        <div class="main-wrapper">
            <br>
            <br>

            <div class="fpdf-designer-body">
                <div class="show-fpdf-editor">
                    <div class="m-0 row">
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- header -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <div id="fpdf_designer_header" class="col-12">
                            WYSIWYG Document Editor
                        </div>
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- menu -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <div id="fpdf_designer_elements" class="col-12 pt-1">
                            <a href="<?php base_url(); ?>PdfDesigner/help_editor" class="btn btn-success fdpf-element">Help</a>
                            <button class="btn btn-primary fdpf-element" id="send_fpdf">Preview</button>
                            <button class="btn btn-danger fdpf-element" id="clear_fpdf">Clear</button>
                            <!--<button class="btn btn-warning fdpf-element" id="save_design">Save</button>
                            <button class="btn btn-warning fdpf-element" id="load_design">Load</button>-->
                            <button class="btn btn-light fdpf-element" data-fpdf="cell" data-is-new-element="true">Cell</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="multicell" data-is-new-element="true">Muliticell</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="text" data-is-new-element="true">Text</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="write" data-is-new-element="true">Write</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="rect" data-is-new-element="true">Rect</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="link" data-is-new-element="true">Link</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="line" data-is-new-element="true">Line</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="image" data-is-new-element="true">Image</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="ln" data-is-new-element="true">Ln</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="setfillcolor" data-is-new-element="true">Fill color</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="setdrawcolor" data-is-new-element="true">Draw color</button>
                            <button class="btn btn-light fdpf-element" data-fpdf="settextcolor" data-is-new-element="true">Text color</button>
                            <!-- <button class="btn btn-primary fdpf-element float-right" id="show_output">Show Output</button> -->
                            <button class="btn btn-primary fdpf-element float-right mr-1" id="show_quickhelp">Show Quick help</button>
                            <button class="btn btn-primary fdpf-element float-right mr-1" id="show_fields_masks">Show Fields Masks</button>
                        </div>
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- ruler grid vertical -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <div class="col ruler-col p-0 d-flex pt-4">
                            <div class="d-flex">
                                <div class="ruler-vertical">
                                    <div class="ruler_cm">
                                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                        <pattern id="cmGrid_vertical" width="15" height="37.79" patternUnits="userSpaceOnUse">
                                            <line x1="0" y1="0" x2="15" y2="0" stroke="black" stroke-width="1" />
                                        </pattern>
                                        </defs>
                                        <rect width="100%" height="100%" fill="url(#cmGrid_vertical)" />
                                        </svg>
                                        <div class="ruler_mm">
                                            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                            <pattern id="mmGrid_vertical" width="3.779" height="3.779" patternUnits="userSpaceOnUse">
                                                <line x1="0" y1="0" x2="20" y2="0" stroke="black" stroke-width="1" />
                                            </pattern>
                                            </defs>
                                            <rect width="100%" height="100%" fill="url(#mmGrid_vertical)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- ruler grid horizontal -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <div class="col p-0">
                            <div>
                                <div class="ruler-horizontal">
                                    <div class="ruler_cm">
                                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                        <pattern id="cmGrid_horizontal" width="37.79" height="15" patternUnits="userSpaceOnUse">
                                            <line x1="0" y1="0" x2="0" y2="15" stroke="black" stroke-width="1" />
                                        </pattern>
                                        </defs>
                                        <rect width="100%" height="100%" fill="url(#cmGrid_horizontal)" />
                                        </svg>
                                        <div class="ruler_mm">
                                            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                            <pattern id="mmGrid_horizontal" width="3.779" height="3.779" patternUnits="userSpaceOnUse">
                                                <line x1="0" y1="0" x2="0" y2="20" stroke="black" stroke-width="1" />
                                            </pattern>
                                            </defs>
                                            <rect width="100%" height="100%" fill="url(#mmGrid_horizontal)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                            <!-- editor -->
                            <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                            <div class="p-4">
                                <div id="fpdf_designer_content">
                                    <div id="fpdf_designer_paper_template" class="align-flex"></div>                                   
                                </div>
                            </div>
                        </div>
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- fields masks container -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <div id="fpdf_designer_templates_list" class="col p-4">
                            <button id="saveTemp" class="btn btn-warning fdpf-element">Save</button>
                            <button id="loadTemp" class="btn btn-warning fdpf-element">Load</button>
                            <button id="deleteTemp" class="btn btn-danger fdpf-element">Delete</button>
                            <button id="defaultTemp" class="btn btn-success fdpf-element">Set Default</button>
                            <p>Saved Templates:</p>
                            <select id="savedTemplates" multiple>
                                <?php foreach ($savedTemplates as $savedTemplate) {
                                    $colorForDefaultClass = "";
                                if($savedTemplate->defaulttemplate == "1"){
                                    $colorForDefaultClass = 'class="blue" ';
                                }
                                    ?>
                                <option <?php $colorForDefaultClass; ?>value="<?php $savedTemplate->templateName; ?>"><?php $savedTemplate->templateName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div id="fpdf_designer_fields_masks" class="col p-4 d-none">
                            <div class="output-header"><span>Fields Masks</span><div class="float-right"><button class="btn btn-link" id="output_fields_masks_hide">Hide Fields Masks</button></div></div>
                            <div>
                                <table class="table">
                                    <thead class="thead-dark">
                                    <th scope="col">Key Code</th>
                                    <th scope="col">Replaced With</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#@ITEM_NAME@#</td>
                                            <td>Item Name</td>
                                        </tr>
                                        <tr>
                                            <td><?php echo base_url(); ?>#@ITEM_PIC@#</td>
                                            <td>Item Picture</td>
                                        </tr>
                                        <tr>
                                            <td>#@ITEM_CAT@#</td>
                                            <td>Item Category</td>
                                        </tr>
                                        <tr>
                                            <td>#@ITEM_DESC@#</td>
                                            <td>Item Description</td>
                                        </tr>
                                        <tr>
                                            <td>#@ITEM_DT_LOST@#</td>
                                            <td>Item Date Lost</td>
                                        </tr>
                                        <tr>
                                            <td>#@ITEM_DT_COL@#</td>
                                            <td>Item Date/Time Collected</td>
                                        </tr>
                                        <tr>
                                            <td colspan=2>To add a QRCODE for the item, add an image with type PNG and provide it this URL as value: <?php echo base_url(); ?>#@QRCODE@#.</td>
                                        </tr>
                                        <tr>
                                            <td colspan=2>Any other text or image will be left as it is.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- output container -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <div id="fpdf_designer_output" class="col p-4 d-none">
                            <div class="output-header"><span>Output Box</span><div class="float-right"><button class="btn btn-link" id="output_hide">Hide Output</button></div></div>
                            <div id="output_content"></div>
                        </div>
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- quick help container -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                        <div id="fpdf_designer_quickhelp" class="col p-4">
                            <div class="output-header"><span>Quick help</span><span class="float-right"><button class="btn btn-link" id="quick_info_hide">Hide Quick help</button></span></div>
                            <div>
                                <small><p class="text-primary"><a href="<?php base_url(); ?>PdfDesigner/help_editor">Note: For help how to use the editor, please click on the green help button or here</a></p>
                                </small>
                                <h2>How to use the editor</h2>
                                <p><strong>Info:</strong> Due to the PDF paper size this should be opened with a desktop PC. This editor is not suitable for cell phones or tablets.</p>
                                <p> The handling is very easy. Simply click on the desired element in the menu to add it.<br>
                                    Then drag and drop to the desired position and right-click on the element to open the context menu with the setting options.</p>
                                <p><strong>1. Step:</strong> Click in the menu on the desired element which you want to insert</p>
                                <p><strong>2. Step:</strong> After the element is added to the editor you can move it by drag and drop. Just move it to the position where you want to place it.</p>
                                <p><strong>3. Step:</strong> Right-click <em>(will open the context menu)</em> on the element to change the current settings.</p>
                                <div><strong>Change value:</strong> To change a the value on an element <em>(Cell, Multicell, Link, Text, Write, Image)</em> right-click and select 'Change value', enter the new value and click 'Set'.<br>
                                    <strong>Delete Element:</strong> You can delete an element on 2 ways:
                                    <ul>
                                        <li>Right-click on the element and then click "Delete" in the context menu</li>
                                        <li>Drag and drop the element out of the editor</li>
                                    </ul>
                                    <strong>Change colors:</strong> There are 3 invisible elements:
                                    <ul>
                                        <li>SetDrawColor: <em>defines the color used for all drawing operations (lines, rectangles and cell borders)</em></li>
                                        <li>SetTextColor: <em>defines the color used for text.</em></li>
                                        <li>SetFillColor: <em>defines the color used for all filling operations (filled rectangles, multicell and cell backgrounds).</em></li>
                                    </ul>
                                    <strong>Change width:</strong> To change the width (except invisble elements) of an element right-click and select 'Change width', enter the new value and click 'Set'.<br>
                                    <strong>Change height:</strong> To change the height (except invisble elements) of an element right-click and select 'Change height', enter the new value and click 'Set'.<br>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                <!-- warning for mobile user -->
                <!-- - - - - - - - - - - - - - - - - - - - - - - -->
                <div class="show-fpdf-editor-display-note">
                    <h2 class="text-center mt-4">WYSIWYG Document Generator</h2>
                    <p  class="text-center">This editor is not suitable for cell phones or tablets. Please open this editor with a desktop PC.</p>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    /* create editor */
    var ajaxData = null,
            fpdf_designer = $('#fpdf_designer_paper_template').fpdf_designer({
        'ajax_url': '<?php base_url(); ?>PdfDesigner/create',
        'save_url': '<?php base_url(); ?>PdfDesigner/save',
        'load_url': '<?php base_url(); ?>PdfDesigner/load'
    });

    $('#clear_fpdf').on('click', function () {
        /* function to clear the editor */
        fpdf_designer.clearEditor();
    });

    $('#send_fpdf').on('click', function () {
        /* function to send elements object per ajax */
        fpdf_designer.sendAjax();
    });

    //$('#save_design').on('click', function () {
    /* function to save design per ajax */
    //fpdf_designer.saveDesign();
    //});

    //$('#load_design').on('click', function () {
    /* function to load design per ajax */
    //fpdf_designer.loadDesign();
    //});

    /* called when saved done */
    fpdf_designer.on('fpdf.save_done', function () {
        alert('Successfully saved');
        updateList();
    });

    /* called when save failed */
    fpdf_designer.on('fpdf.save_failed', function () {
        alert('Save failed');
    });

    /* called when load failed */
    fpdf_designer.on('fpdf.load_failed', function () {
        alert('Design doesn\'t exist');
    });

    /* called when start to send */
    fpdf_designer.on('fpdf.send_start', function () {
        $.confirm({
            title: 'Creating',
            content: 'Please wait while creating PDF',
            buttons: {
                Close: function () {},
            },
            onOpenBefore: function () {
                $('.jconfirm-buttons').hide();
            }
        });
    });

    /* called when send is done */
    fpdf_designer.on('fpdf.send_done', function () {
        var ajaxData = null;

        try {
            ajaxData = $.parseJSON(fpdf_designer.getAjaxData());
        } catch (e) {
            ajaxData = {status: 'failed',
                message: fpdf_designer.getAjaxData()};
        }

        if (ajaxData.status === 'created') {
            $('.jconfirm-content').html('<a href="<?php base_url(); ?>PdfDesigner/download/' + ajaxData.file + '" target="_blank" rel="noopener">Download PDF</a>');
            $('.jconfirm-buttons').show();
        } else {
            $('.jconfirm-content').html(ajaxData.message);
            $('.jconfirm-buttons').show();
        }
    });

    $('#quick_info_hide').on('click', function () {
        $('#fpdf_designer_quickhelp').addClass('d-none');
    });

    $('#output_hide').on('click', function () {
        $('#fpdf_designer_output').addClass('d-none');
    });

    $('#show_quickhelp').on('click', function () {
        $('#fpdf_designer_quickhelp').removeClass('d-none');
    });

    $('#show_output').on('click', function () {
        $('#fpdf_designer_output').removeClass('d-none');
    });

    $('#output_fields_masks_hide').on('click', function () {
        $('#fpdf_designer_fields_masks').addClass('d-none');
    });

    $('#show_fields_masks').on('click', function () {
        $('#fpdf_designer_fields_masks').removeClass('d-none');
    });

    $('#loadTemp').on('click', function () {
        fpdf_designer.loadDesignWithName();
    });
    $('#saveTemp').on('click', function () {
        fpdf_designer.saveDesign();
    });
    $('#defaultTemp').on('click', function () {
        var templateName = $("#savedTemplates option:selected").val();
        if (templateName !== "" && typeof templateName !== "undefined") {
            if (confirm('Are you sure you want to make this template default?')) {
                $.ajax({
                    type: "POST",
                    url: "<?php base_url() . "PdfDesigner/makeTemplateDefault" ?>",
                    data: {
                        templateName: templateName
                    },
                    success: function (response) {
                        alert(response);
                        updateList();
                    },
                    error: function (response) {
                        alert(response);
                    }
                });
            }
        }
    });
    $('#deleteTemp').on('click', function () {
        var templateName = $("#savedTemplates option:selected").val();
        if (templateName !== "" && typeof templateName !== "undefined") {
            if (confirm('Are you sure you want to delete this template?')) {
                $.ajax({
                    type: "POST",
                    url: "<?php base_url() . "PdfDesigner/deleteTemplate" ?>",
                    data: {
                        templateName: templateName
                    },
                    success: function (response) {
                        if (response === 'default') {
                            alert("Template is set as default and cannot be deleted!");
                        } else if (response === 'deleted') {
                            alert("Template successfully deleted.");
                            updateList();
                            fpdf_designer.clearEditor();
                        } else {
                            alert("An error occured! Try again.");
                        }
                    },
                    error: function () {
                        alert("An error occured! Try again.");
                    }
                });
            }
        }
    });
    function updateList() {
        $.ajax({
            type: "POST",
            url: "<?php base_url() . "PdfDesigner/refreshList"; ?>",
            success: function (response) {
                $("#savedTemplates").html(response);
            },
            error: function () {
            }
        });
    }

</script>
