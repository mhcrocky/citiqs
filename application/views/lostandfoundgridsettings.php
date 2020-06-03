<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/main-style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/how-it-works.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/home-page.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/grid.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
        <style>
            .flatpickr-calendar {
                font-family: 'caption-light', sans-serif !important;
            }
            .flatpickr-input {
                border: 1px solid #ccc;
                padding: 5px 10px;
                border-radius: var(--button-radius);
                width: 100%;
                font-family: 'caption-light', sans-serif;
                outline: none;
            }
            .grid-wrapper {
                background-color: <?php echo $datasettings->backgroundcolor; ?>;
            }
            .grid-wrapper .grid-item {
                background-color: <?php echo $datasettings->griditembackground; ?>;
                border-radius: <?php echo $datasettings->griditemborderradius; ?>px;
                border-color: <?php echo $datasettings->bordercolor; ?>;
            }
            .grid-wrapper .grid-item .grid-button {
                border-radius: <?php echo $datasettings->buttonborderradius; ?>px;
                background-color: <?php echo $datasettings->buttonbackgroundcolor; ?>;
                color: <?php echo $datasettings->buttontextcolor; ?>
            }
            .grid-wrapper .grid-item p {
                font-size: <?php echo $datasettings->textsize; ?>px;
                color: <?php echo $datasettings->textcolor; ?>;
            }
        </style>
    </head>
    <body>
        <div class="main-wrapper theme-editor-wrapper">
            <div class="theme-editor">
                <div class="theme-editor-header d-flex justify-content-between">
                    <div>
                        <img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">
                    </div>
                    <div class='theme-editor-header-buttons'>
                        <input 
                            id="updateSettings"
                            type="button" 
                            class="grid-button button theme-editor-header-button" 
                            value="Submit"
                            onclick="updateSettings('<?php echo base_url() . 'lostandfoundgridsettings/usersettings'; ?>', <?php echo $datasettings->id; ?>);"
                        />
                        <button class='grid-button-cancel button theme-editor-header-button'>Cancel</button>
                    </div>
                </div>
                <div class="theme-editor-content">
                    <div class="theme-editor-item">
                        <p>Background Color:</p>
                        <div class='color-picker'>
                            <a href="#" id="background-color" class="popup-parent" style="background-color:<?php echo $datasettings->backgroundcolor; ?>"></a>
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Border Color:</p>
                        <div class='color-picker'>
                            <a href="#" id="border-color" class="popup-parent" style="background-color:<?php echo $datasettings->bordercolor; ?>"></a>
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Button Background Color:</p>
                        <div class='color-picker'>
                            <a href="#" id="button-bgColor" class="popup-parent" style="background-color:<?php echo $datasettings->buttonbackgroundcolor; ?>"></a>
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Button text Color:</p>
                        <div class='color-picker'>
                            <a href="#" id="button-text-color" class="popup-parent" style="background-color:<?php echo $datasettings->buttontextcolor; ?>"></a>
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Text Color:</p>
                        <div class='color-picker'>
                            <a href="#" id="text-color" class="popup-parent" style="background-color:<?php echo $datasettings->textcolor; ?>"></a>
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Grid Item Background:</p>
                        <div class='color-picker'>
                            <a href="#" id="grid-item-background" class="popup-parent" style="background-color:<?php echo $datasettings->griditembackground; ?>"></a>
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Button Border Radius:</p>
                        <div class='number-picker'>
                            <input type="tel" id='button-radius' value="<?php echo $datasettings->buttonborderradius; ?>">
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Grid Item Border Radius:</p>
                        <div class='number-picker'>
                            <input type="tel" id='grid-item-radius' value="<?php echo $datasettings->griditemborderradius; ?>">
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <p>Text Size:</p>
                        <div class='number-picker'>
                            <input type="tel" id='text-size' maxlength="2" value="<?php echo $datasettings->textsize; ?>">
                        </div><!-- end color picker -->
                    </div><!-- end editor item -->

                    <div class="theme-editor-item">
                        <label class="custom-checkbox" id='show-search-bar'>
                            <input  type="checkbox" id="showSearchBar" <?php if ($datasettings->showsearchbar === '1') echo 'checked="checked"'; ?>><span class="checkmark"></span>Show Search Bar
                        </label>
                    </div><!-- end editor item -->
                </div>
                <div class='theme-editor-footer'>
                    <div>
                        <h3 onclick='copyToClipboard("iframe-placeholder")'>Iframe Settings<small>Copy to clipboard</small></h3>
                        <textarea name="" id="iframe-placeholder" readonly><?php
                            $iframe  = htmlentities('<script src="' . base_url() . 'assets/js/iframeResizer.js"></script>');
                            $iframe .= htmlentities('<iframe id="iFrameResizer" frameborder="0" style="width:400px; height:600px;" src="' . base_url() . 'location/' . $userHash . '"></iframe>');
                            $iframe .= htmlentities('<script>iFrameResize({ scrolling: true, sizeHeight: true, sizeWidth: true, maxHeight:700, maxWidth:400, })</script>');
                            echo $iframe;
                            ?></textarea>
                    </div>
                    <div>
                        <input type="text" value='' id='iframe-settings' style='display:none'>
                        <button class='grid-button button edit-buttons-hide-desktop'>Submit</button>
                        <button class='grid-button-cancel button edit-buttons-hide-desktop'>Cancel</button>
                        <input type="hidden" value='Iframe Settings' id='footer-text' >
                    </div>
                </div>
            </div><!-- end theme editor -->
            <div class="grid-wrapper">
                <div class="grid-list">
                    <div class="grid-list-header row">
                        <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                            <button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit" id='button-theme-editor' style="margin-right: 10px">CUSTOMIZE GRID</button>
                        </div>
                    </div><!-- end grid header -->
                    <div class="grid-item">
                        <div class="item-header">
                            <p class="item-date">2019-10-01 09:41:01</p>
                            <p class="item-code">G-S5DPRArG</p>
                            <div class="grid-image">
                                <form id="addUser_316" class="file_form" action="<?php echo base_url(); ?>userLabelImageCreate" method="post" role="form" enctype="multipart/form-data">
                                    <img src="<?php echo base_url(); ?>uploads/LabelImages/1-G-S5DPRArG-1576063192.jpg">
                                    <label for="file-upload" class="custom-file-upload btn btn-primary">
                                        Click Here to upload an image
                                    </label>
                                    <input type="file" id="file-upload" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'/ >
                                    <!--<input type="file" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'>-->
                                    <input type="hidden" value="316" name="id" id="id">
                                    <button type="submit" name="labelimage" value="Submit" class='btn btn-success iconWrapper'>
                                    <span class="fa-stack fa-2x">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    </button>
                                </form>
                            </div>
                            <p class="item-description">Just for testing</p>
                            <p class="item-category">The passport</p>
                        </div>

                        <div class="grid-footer">
                            <!-- <a class="btn btn-sm btn-info btn-edit-item" href="javascript:void(0)" title="Edit">Edit</a>-->
                            <!--<a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="316" title="Delete">delete</a>-->
                            <div class='iconWrapper'>
                                <span class="fa-stack fa-2x edit-icon btn-edit-item">
                                    <i class="far fa-edit"></i>
                                </span>
                            </div>
                            <div class='iconWrapper delete-icon-wrapper'>
                                <span class="fa-stack fa-2x delete-icon">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                            <div class='iconWrapper'>
                                <span class="fa-stack fa-2x print-icon">
                                    <i class="fas fa-print"></i>
                                </span>
                            </div>
                            <!--<a class="btn btn-sm btn-info print" href="#" data-userid="316" title="Print">Print</a>-->
                        </div>

                        <div class="item-editor theme-editor">
                            <div class="theme-editor-header d-flex justify-content-between">
                                <div>
                                    <img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">
                                </div>
                                <div class="theme-editor-header-buttons">
                                    <button class="grid-button button theme-editor-header-button">Submit</button>
                                    <button class="grid-button-cancel button theme-editor-header-button">Cancel</button>
                                </div>
                            </div>
                            <div class="edit-signle-item-container">
                                <h3>Item Heading</h3>
                                <form action="" class='form-inline'>
                                    <div>
                                        <label for="category">Category</label>
                                        <select name="category" id="" class='form-control'>
                                            <option value="">lorem ipsum</option>
                                            <option value="">lorem ipsum</option>
                                            <option value="">lorem ipsum</option>
                                            <option value="">lorem ipsum</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="description">Description</label>
                                        <input type="text" class='form-control'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end grid item -->
                    <div class="grid-item">
                        <div class="item-header">
                            <p class="item-date">2019-10-01 09:41:01</p>
                            <p class="item-code">G-S5DPRArG</p>
                            <div class="grid-image">
                                <form id="addUser_316" class="file_form" action="<?php echo base_url(); ?>userLabelImageCreate" method="post" role="form" enctype="multipart/form-data">
                                    <img src="<?php echo base_url(); ?>uploads/LabelImages/1-G-S5DPRArG-1576063192.jpg">
                                    <label for="file-upload" class="custom-file-upload btn btn-primary">
                                        Click Here to upload an image
                                    </label>
                                    <input type="file" id="file-upload" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'/ >
                                    <!--<input type="file" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'>-->
                                    <input type="hidden" value="316" name="id" id="id">
                                    <button type="submit" name="labelimage" value="Submit" class='btn btn-success'>Submit</button>
                                </form>
                            </div>
                            <p class="item-description">Just for testing</p>
                            <p class="item-category">The passport</p>
                        </div>
                        <div class="grid-footer">
                            <a class="btn btn-sm btn-info btn-edit-item" href="javascript:void(0)" title="Edit">Edit</a>
                            <a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="316" title="Delete">delete</a>
                            <a class="btn btn-sm btn-info print" href="#" data-userid="316" title="Print">Print</a>
                        </div>
                        <div class="item-editor theme-editor">
                            <div class="theme-editor-header d-flex justify-content-between">
                                <div>
                                    <img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">
                                </div>
                                <div class="theme-editor-header-buttons">
                                    <button class="grid-button button theme-editor-header-button">Submit</button>
                                    <button class="grid-button-cancel button theme-editor-header-button">Cancel</button>
                                </div>
                            </div>
                            <div class="edit-signle-item-container">
                                <h3>Item Heading</h3>
                                <form action="" class='form-inline'>
                                    <div>
                                        <label for="category">Category</label>
                                        <select name="category" id="" class='form-control'>
                                            <option value="">lorem ipsum</option>
                                            <option value="">lorem ipsum</option>
                                            <option value="">lorem ipsum</option>
                                            <option value="">lorem ipsum</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="description">Description</label>
                                        <input type="text" class='form-control'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- end grid item -->
                    <div class="grid-item">
                        <div class="item-header">
                            <p class="item-date">2019-10-01 09:41:01</p>
                            <p class="item-code">G-S5DPRArG</p>
                            <div class="grid-image">
                                <form id="addUser_316" class="file_form" action="<?php echo base_url(); ?>userLabelImageCreate" method="post" role="form" enctype="multipart/form-data">
                                    <img src="<?php echo base_url(); ?>uploads/LabelImages/1-G-S5DPRArG-1576063192.jpg">
                                    <label for="file-upload" class="custom-file-upload btn btn-primary">
                                        Click Here to upload an image
                                    </label>
                                    <input type="file" id="file-upload" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'/ >
                                    <!--<input type="file" name="imgfile" id="file_316" accept="image/jpg, image/jpeg, image/png" class='upload-image'>-->
                                    <input type="hidden" value="316" name="id" id="id">
                                    <button type="submit" name="labelimage" value="Submit" class='btn btn-success'>Submit</button>
                                </form>
                            </div>
                            <p class="item-description">Just for testing</p>
                            <p class="item-category">The passport</p>
                        </div>
                        <div class="grid-footer">
                            <a class="btn btn-sm btn-info btn-edit-item" href="<?php echo base_url(); ?>editOldlabel/316" title="Edit">Edit</a>
                            <a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="316" title="Delete">delete</a>
                            <a class="btn btn-sm btn-info print" href="#" data-userid="316" title="Print">Print</a>
                        </div>
                    </div>


                </div><!-- end grid list -->
            </div><!-- end grid wrapper -->
        </div><!-- end main wrapper -->
        <!-- lightbox for image -->
        <div id="lightbox-modal">
            <div class='lightbox-modal-content'>
                <img src="" alt="" id='lightbox-image'>
                <span id="close-lightbox">×</span>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="assets/home/js/vanilla-picker.js"></script>
        <script>
            "use strict";
            function lightBoxModal(){
                lightboxImageURL = this.getAttribute("src");
                lightboxImage.setAttribute('src', lightboxImageURL);
                lightboxModal.classList.add('active-modal');
            }

            /*global Picker*/
            function $(selector, context) {
                return (context || document).querySelector(selector);
            }

            // Copy to clipboard
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

            function updateSettings(url, id) {
                let action = url + '/' + id;
                let postData = {
                    backgroundcolor : document.getElementById('background-color').style.backgroundColor,
                    bordercolor : document.getElementById('border-color').style.backgroundColor,
                    textcolor : document.getElementById('text-color').style.backgroundColor,
                    griditembackground : document.getElementById('grid-item-background').style.backgroundColor,
                    buttonbackgroundcolor : document.getElementById('button-bgColor').style.backgroundColor,
                    buttontextcolor : document.getElementById('button-text-color').style.backgroundColor,
                    buttonborderradius : document.getElementById('button-radius').value,
                    griditemborderradius : document.getElementById('grid-item-radius').value,
                    textsize : document.getElementById('text-size').value,
                }
                postData['showsearchbar'] = checked ? '1' : '0';
                jQuery.ajax({
                    url: action,
                    data: postData,
                    type: 'POST',
                    success: function(data) {
                        let message = (data === '1') ? 'Setting updated' : 'Setting didn\'t update';
                        alert(message);
                    },        
                    error: function (err) {
                        console.dir(err);
                    }
                });
            }



            var lightboxLink = document.getElementsByClassName('lightbox-open');
            var lightboxModal = document.getElementById('lightbox-modal');
            var lightboxImage = document.getElementById('lightbox-image');
            var span = document.getElementById("close-lightbox");
            var lightboxImageURL;

            for(let i = 0; i < lightboxLink.length; i++){
                lightboxLink[i].addEventListener('click', lightBoxModal)
            }


            span.onclick = function() {
                lightboxModal.classList.remove('active-modal');
            }

            window.onclick = function(event) {
                if (event.target == lightboxModal) {
                    lightboxModal.classList.remove('active-modal');
                }
            };

            // grid-wrapper background color
            var backgroundColor = $('#background-color');
            var popupBasic = new Picker({
                    parent: $('#background-color'),
                    color:'#fff',
                });
            popupBasic.onChange = function(color) {
                let value = color.rgbaString;
                document.getElementById('background-color').style.backgroundColor = value;
                document.querySelectorAll('.grid-wrapper')[0].style.backgroundColor = value;
            };

            // grid-item background
            var gridItemBackground = $('#grid-item-background');
            var popupBasic = new Picker({
                parent: gridItemBackground,
                color:'#333333',
            });
            popupBasic.onChange = function(color) {
                let value = color.rgbaString;
                let allGrids = document.querySelectorAll(".grid-item");
                document.getElementById('grid-item-background').style.backgroundColor = value;
                allGrids.forEach( el => el.style.backgroundColor = value);
            };

            // grid-item border color
            var borderColor = $('#border-color'),
                popupBasic = new Picker({
                    parent: borderColor,
                    color:'#e25f2a',
                });
            popupBasic.onChange = function(color) {
                let value = color.rgbaString;
                let allGrids = document.querySelectorAll(".grid-item");
                document.getElementById('border-color').style.backgroundColor = value;
                allGrids.forEach( el => el.style.borderColor = value);
            };

            // grid-item border radius
            document.getElementById('grid-item-radius').addEventListener('input', function(){
                let value = document.getElementById('grid-item-radius').value + 'px';
                let allGrids = document.querySelectorAll(".grid-item");
                allGrids.forEach( el => el.style.borderRadius = value);
            })

            // button radius
            document.getElementById('button-radius').addEventListener('input', function(){
                let value = document.getElementById('button-radius').value + 'px';
                let allButtons = document.querySelectorAll('.grid-item .grid-button');
                allButtons.forEach( el => el.style.borderRadius = value);
            })

            // button background color
            var buttonBgColor = $('#button-bgColor');
            var popupBasic = new Picker({
                    parent: buttonBgColor,
                    color:'#e25f2a',
                });
            popupBasic.onChange = function(color) {
                let value = color.rgbaString;
                let allButtons = document.querySelectorAll('.grid-item .grid-button');                
                document.getElementById('button-bgColor').style.backgroundColor = value;
                allButtons.forEach( el => el.style.backgroundColor = value);
            };

            // button text color
            var buttonTextColor = $('#button-text-color');
            var popupBasic = new Picker({
                    parent: buttonTextColor,
                    color:'#fff',
                });
            popupBasic.onChange = function(color) {
                let value = color.rgbaString;
                let allButtons = document.querySelectorAll('.grid-item .grid-button');
                document.getElementById('button-text-color').style.backgroundColor = value;
                allButtons.forEach( el => el.style.color = value);
            };

            // text color
            var textColor = $('#text-color');
            var popupBasic = new Picker({
                parent: textColor,
                color:'#333333',
            });
            popupBasic.onChange = function(color) {                
                let value = color.rgbaString;
                let allGridsParagraphs = document.querySelectorAll(".grid-item p");
                document.getElementById('text-color').style.backgroundColor = value;
                allGridsParagraphs.forEach( el => el.style.color = value);
            };

            // text size
            document.getElementById('text-size').addEventListener('input', function(){
                let value = document.getElementById('text-size').value + 'px';
                let allGridsParagraphs = document.querySelectorAll(".grid-item p");
                allGridsParagraphs.forEach( el => el.style.fontSize = value);
            })


            // show search bar TO DO REFACTOR THIS
            var showSearchBar = document.getElementById('show-search-bar');
            var checked = '<?php echo $datasettings->showsearchbar; ?>' === '1' ? true : false;
            showSearchBar.addEventListener('change', function(){
                let search = document.querySelectorAll('.filter-options');
                console.dir(search);
                if(checked) {
                    checked = false;
                    search.forEach(el => el.style.visibility = "hidden");                    
                } else {
                    checked = true;
                    search.forEach(el => el.style.visibility = "visible");
                    
                }
            });

            var grid_editor = document.getElementsByClassName('theme-editor')[0];
            var grid_button_open_editor = document.getElementById('button-theme-editor');
            var grid_header = document.getElementsByClassName('grid-list-header')[0];
            var grid_edit_item_button = document.querySelectorAll('.btn-edit-item');
            var grid_item_editor = document.getElementsByClassName('item-editor')[0];

            grid_button_open_editor.addEventListener('click', function(){
                grid_editor.classList.add('display');
            })

            document.querySelectorAll('.theme-editor-header-button').forEach(item => {
                item.addEventListener('click', event => {
                    grid_editor.classList.remove('display');
                    grid_item_editor.classList.remove('display');
                })
            })

            grid_edit_item_button.forEach(item => {
                item.addEventListener('click', event => {
                    grid_editor.classList.remove('display');
                    grid_item_editor.classList.add('display');
                })
            })
        </script>
        <scripT>
            // date picker            
            $(".flatpickr").flatpickr();
            $(".flatpickr-to").flatpickr();
        </script>
    </body>
</html>
