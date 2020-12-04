$.fn.extend({
    filedrop: function (options) {
        var defaults = {
            callback: null
        }
        options = $.extend(defaults, options)
        return this.each(function () {
            var files = []
            var $this = $(this)

            // Stop default browser actions
            $this.bind('dragover dragleave', function (event) {
                event.stopPropagation()
                event.preventDefault()
            })

            // Catch drop event
            $this.bind('drop', function (event) {
                // Stop default browser actions
                event.stopPropagation();
                event.preventDefault();

                // Get all files that are dropped
                files = event.originalEvent.target.files || event.originalEvent.dataTransfer.files

                // Convert uploaded file to data URL and pass trought callback
                if (options.callback) {
                    var reader = new FileReader()
                    reader.onload = function (event) {
                        options.callback(event.target.result)
                    }
                    reader.readAsDataURL(files[0])
                }
                return false
            })
        })
    }
})

jQuery.fn.extend({
    getPath: function () {
        var path, node = this;
        while (node.length) {
            var realNode = node[0], name = realNode.localName;
            if (!name)
                break;
            name = name.toLowerCase();

            var parent = node.parent();

            var sameTagSiblings = parent.children(name);
            if (sameTagSiblings.length > 1) {
                allSiblings = parent.children();
                var index = allSiblings.index(realNode) + 1;
                if (index > 1) {
                    name += ':nth-child(' + index + ')';
                }
            }

            path = name + (path ? '>' + path : '');
            node = parent;
        }

        return path;
    }
});

$.cssHooks.backgroundColor = {
    get: function (elem) {

        $('#imageproperties').hide();
        if (elem.currentStyle)
            var bg = elem.currentStyle["background-color"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem,
                    null).getPropertyValue("background-color");
        if (bg.search("rgb") == -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            //return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
        }
    }
}

$.cssHooks.fontColor = {
    get: function (elem) {
        if (elem.currentStyle)
            var bg = elem.currentStyle["color"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem,
                    null).getPropertyValue("color");
        if (bg.search("rgb") == -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
        }
    }
}




var selector = null;


function handleSaveLayout() {
    var e = $(".demo").html();
}
/* this generate the id of item */
function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
}


/* give the attribute id to item and build the function on event onclick */

function showSettings() {
    var settings = $('#settings');
    var elements = $('#elements');

    if (settings.hasClass('hide')) {
        elements.slideUp(300);
        settings.removeClass('hide');
        settings.slideDown(300);
    }
}

function showElements() {
    var settings = $('#settings');
    var elements = $('#elements');
    if (!settings.hasClass('hide')) {
        settings.slideUp(300);
        settings.addClass('hide');
        elements.slideDown(300);
    }

}

function handleHeader() {

    var self = $('#header');
    self.bind('click', function () {


        $('#path').val('header');
        $('div.row').removeClass('active');

        $('#ptop').val(self.find('tr td').css('padding-top'));
        $('#pbottom').val(self.find('tr td').css('padding-bottom'));
        $('#pleft').val(self.find('tr td').css('padding-left'));
        $('#pright').val(self.find('tr td').css('padding-right'));

        self.parent("div.row").addClass('active');

        $('form#font-settings').hide();
        $('form#editor').hide();
        $('#buttons').hide();
        $('#imageproperties').hide();
        $('#social-links').hide();
        $('form#editorlite').hide();

        var fontcolor = $('#' + $('#path').val()).find('tr td.header h1').css('fontColor');
        var text = $('#' + $('#path').val()).find('tr td.header h1').html();
        var fontsize = $('#' + $('#path').val()).find('tr td.header h1').css('font-size');
        var fontfamily = $('#' + $('#path').val()).find('tr td.header h1').css('font-family');
        var background = $('#' + $('#path').val()).css('background-color');


        $('#selector').val('tr td.header h1');
        $('form#font-settings').show();
        $('form#editorlite').show();
        $('form#font-settings').show();
        storeValues(self, fontcolor, text, fontsize, fontfamily, background);
        showSettings();

    });

}


function handleFooter() {

    var self = $('#footer');
    self.bind('click', function () {


        $('#path').val('footer');
        $('div.row').removeClass('active');

        $('#ptop').val(self.find('tr td').css('padding-top'));
        $('#pbottom').val(self.find('tr td').css('padding-bottom'));
        $('#pleft').val(self.find('tr td').css('padding-left'));
        $('#pright').val(self.find('tr td').css('padding-right'));

        self.parent("div.row").addClass('active');

        $('form#font-settings').hide();
        $('form#editor').hide();
        $('#buttons').hide();
        $('#imageproperties').hide();
        $('#social-links').hide();
        $('form#editorlite').hide();

        var fontcolor = $('#' + $('#path').val()).find('tr td').css('fontColor');
        var text = $('#' + $('#path').val()).find('tr td').html();
        var fontsize = $('#' + $('#path').val()).find('tr td').css('font-size');
        var fontfamily = $('#' + $('#path').val()).find('tr td').css('font-family');
        var background = $('#' + $('#path').val()).css('background-color');

        $('#selector').val('tr td.header h1');

        storeValues(self, fontcolor, text, fontsize, fontfamily, background);
        showSettings();

    });

}

function handleObjects() {

    $(".demo .column .lyrow").each(function (i) {

        $(this).removeClass('dragitem');
        $(this).css('display', 'block');

        var self = $(this).find('div.row table.main'); // tabella
        var id = self.attr('id');

        if (typeof id === typeof undefined || id === false) {
            id = guid();
            self.attr('id', id);
        }
            self.hide();
            self.unbind('click');

            self.bind('click', function () {

                $('div.row').removeClass('active');
                self.parent("div.row").addClass('active');
                $('#path').val(id);
                var t = self.data('type');

                $('#ptop').val(self.find('td').css('padding-top'));
                $('#pbottom').val(self.find('td').css('padding-bottom'));
                $('#pleft').val(self.find('td').css('padding-left'));
                $('#pright').val(self.find('td').css('padding-right'));
                $('form#font-settings').hide();
                $('form#editor').hide();
                $('#buttons').hide();
                $('#imageproperties').hide();
                $('#social-links').hide();
                $('form#editorlite').hide();
                $('#qr-code-properties').hide();


                $('#common-settings').show();
                switch (t) {
                    case 'title':

                        var titolo = self.find('h1');
                        var subtitolo = self.find('h4');

                        titolo.unbind('click');
                        titolo.bind('click', function (e) {
                            $('.selected-item').removeClass('selected-item').css('border', 'none');

                            var fontcolor = $(this).css('fontColor');
                            var text =        $(this).html();
                            var fontsize =    $(this).css('font-size');
                            var fontfamily =  $(this).css('font-family');
                            var background =  $(this).css('background-color');

                            $('#selector').val('h1');
                            $(this).addClass('selected-item');
                            $(this).css('border','1px dotted red');


                            storeValues(self, fontcolor, text, fontsize, fontfamily, background);

                        });

                        subtitolo.unbind('click');
                        subtitolo.bind('click', function (e) {
                            $('.selected-item').removeClass('selected-item').css('border', 'none');

                            var fontcolor = $(this).css('fontColor');
                            var text =        $(this).html();
                            var fontsize =    $(this).css('font-size');
                            var fontfamily =  $(this).css('font-family');
                            var background =  $(this).css('background-color');

                            $('#selector').val('h4');

                            $(this).addClass('selected-item');
                            $(this).css('border','1px dotted red');

                            storeValues(self, fontcolor, text, fontsize, fontfamily, background);

                        });


                         $('form#font-settings').show();
                         $('form#editorlite').show();
                         $('form#font-settings').show();
                        /*
                         var fontcolor = $('#' + $('#path').val()).find('h1').css('fontColor');
                         var text = $('#' + $('#path').val()).find('h1').html();
                         var fontsize = $('#' + $('#path').val()).find('h1').css('font-size');
                         var fontfamily = $('#' + $('#path').val()).find('h1').css('font-family');
                         var background = $('#' + $('#path').val()).css('background-color');

                         $('#selector').val('h1');

                         $('form#font-settings').show();
                         $('form#editorlite').show();
                         $('form#font-settings').show();
                         storeValues(self, fontcolor, text, fontsize, fontfamily, background);*/
                        break;

                    case 'text-block' :
                        $('.selected-item').removeClass('selected-item').css('border', 'none');
                        var fontcolor = $('#' + $('#path').val() + ' tbody tr td').css('fontColor');
                        var text = $('#' + $('#path').val()).find('p').html();
                        var fontsize = $('#' + $('#path').val()).find('p').css('font-size');
                        var fontfamily = $('#' + $('#path').val()).find('p').css('font-family');
                        var background = $('#' + $('#path').val()).css('backgroundColor');
                        $('#selector').val('p');
                        $('form#font-settings').show();
                        $('form#editor').show();
                        storeValues(self, fontcolor, text, fontsize, fontfamily, background);
                        break;

                    case 'image':
                        $('.selected-item').removeClass('selected-item').css('border', 'none');
                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        var img = self.find('img');
                        var imageid = img.attr('id');

                        if (typeof imageid === typeof undefined || imageid === false) {
                            img.attr('id', guid());
                            imageid = img.attr('id');
                        }
                        $('#imageid').val(imageid);
                        $('#image-url').val(img.attr('src'));
                        $('#image-url').data('id', imageid );

                        $('#image-w').val(img.css('width'));
                        $('#image-h').val(img.css('height'));

                        $('#imageproperties').show();

                        /*
                        img.filedrop({
                            callback: function (fileEncryptedData) {
                                img.hide();
                                img.attr('src', fileEncryptedData);
                                img.show('puff', {}, 500);
                            }
                        });
                                                   */
                        break;
                    case 'qr-code-type':
                        $('.selected-item').removeClass('selected-item').css('border', 'none');
                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        var img = self.find('img');
                        var imageid = img.attr('id');

                        if (typeof imageid === typeof undefined || imageid === false) {
                            img.attr('id', guid());
                            imageid = img.attr('id');
                        }

                        $('#imageid').val(imageid);
                        $('#image-url').val(img.attr('src'));
                        $('#image-url').data('id', imageid );

                        $('#qr-code-properties #image-w').val(img.css('width'));
                        $('#qr-code-properties #image-h').val(img.css('height'));

                        $('#qr-code-properties').removeClass('hide');
                        $('#qr-code-properties').show();

                        break;
                    case 'imgtxtcol':
                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        var textElement = self.find('tbody tr td p');
                        var img = self.find('tbody tr td table tbody tr td img');

                        var imageid = img.attr('id');
                        if (typeof imageid === typeof undefined || imageid === false) {
                            img.attr('id', guid());
                            imageid = img.attr('id');
                        }
                        $('#imageid').val(imageid);

                        $('#imageid').val(imageid);
                        $('#image-url').val(img.attr('src'));
                        $('#image-url').data('id', imageid );

                        $('#image-w').val(img.css('width'));
                        $('#image-h').val(img.css('height'));

                        $('#imageproperties').show();

                        /*
                        img.filedrop({
                            callback: function (fileEncryptedData) {
                                img.hide();
                                img.attr('src', fileEncryptedData);
                                img.show('puff', {}, 500);
                            }
                        });
                         */
                        textElement.unbind('click');
                        textElement.bind('click', function () {
                            $('#selector').val('tbody tr td p');
                            $('.selected-item').removeClass('selected-item').css('border', 'none');
                            textElement.css('border', '1px dotted red');
                            $(this).addClass('selected-item');

                            var fontcolor = textElement.css('fontColor');
                            var text = textElement.html();
                            var fontsize = textElement.css('font-size');
                            var fontfamily = textElement.css('font-family');
                            var background = $('#' + $('#path').val()).css('background-color');
                            $('#selector').val('tbody tr td p');
                            storeValues($('#' + $('#path').val()), fontcolor, text, fontsize, fontfamily, background);


                        })
                        $('form#font-settings').show();
                        $('form#editor').show();
                        $('form#font-settings').show();
                        break;
                    case 'imgtxtincol':

                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        var textElement = self.find('td.text p');

                        var imgs = self.find('td.image img');

                        imgs.each(function (i) {
                            var img = $(this);
                            var imageid = img.attr('id');

                            if (typeof imageid === typeof undefined || imageid === false) {
                                img.attr('id', guid());

                            }
                            img.unbind('click');
                            img.bind('click', function () {
                                $('.selected-item').removeClass('selected-item').css('border', 'none');
                                imageid = $(this).attr('id');
                                $('#imageid').val(imageid);
                                $(this).css('border', '1px dotted red');
                                $(this).addClass('selected-item');

                                $('#image-url').val($(this).attr('src'));
                                $('#image-url').data('id', imageid );

                                $('#image-w').val($(this).css('width'));
                                $('#image-h').val($(this).css('height'));


                            });




                            $('#imageproperties').show();
                            /*
                            img.filedrop({
                                callback: function (fileEncryptedData) {
                                    img.hide();
                                    img.attr('src', fileEncryptedData);
                                    img.show('puff', {}, 500);
                                }
                            });
                            */

                        });


                        textElement.each(function (index) {
                            $(this).unbind('click');
                            $(this).bind('click', function () {
                                $('#selector').val('tbody tr td.text:eq(' + index + ') p');
                                $('.selected-item').removeClass('selected-item').css('border', 'none');
                                $(this).css('border', '1px dotted red');
                                $(this).addClass('selected-item');

                                var fontcolor = $(this).css('fontColor');
                                var text = $(this).html();
                                var fontsize = $(this).css('font-size');
                                var fontfamily = $(this).css('font-family');
                                var background = $('#' + $('#path').val()).css('background-color');
                                storeValues($('#' + $('#path').val()), fontcolor, text, fontsize, fontfamily, background);

                            })

                        });


                        $('form#font-settings').show();
                        $('form#editor').show();
                        $('form#font-settings').show();
                        break;
                    case 'imgtxt':
                        //    $('#'+$('#path').val()).unbind('click');
                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        var titleElement = self.find('tbody tr td h2');
                        var textElement = self.find('tbody tr td p');
                        var img = self.find('tbody tr td table tbody tr td img');
                        // devi mettere un each perchè ci sono piu di un immagine.


                        var imageid = img.attr('id');

                        if (typeof imageid === typeof undefined || imageid === false) {
                            img.attr('id', guid());
                            imageid = img.attr('id');
                        }
                        $('#imageid').val(imageid);

                        $('#imageid').val(imageid);
                        $('#image-url').val(img.attr('src'));
                        $('#image-url').data('id', imageid );

                        $('#image-w').val(img.css('width'));
                        $('#image-h').val(img.css('height'));

                        $('#imageproperties').show();

                       /*
                        img.filedrop({
                            callback: function (fileEncryptedData) {
                                img.hide();
                                img.attr('src', fileEncryptedData);
                                img.show('puff', {}, 500);
                            }
                        });
                        */


                        titleElement.unbind('click');
                        titleElement.bind('click', function () {
                            $('#selector').val('tbody tr td h2');
                            $('.selected-item').removeClass('selected-item').css('border', 'none');
                            titleElement.css('border', '1px dotted red');
                            $(this).addClass('selected-item');

                            var fontcolor = titleElement.css('fontColor');
                            var text = titleElement.html();
                            var fontsize = titleElement.css('font-size');
                            var fontfamily = titleElement.css('font-family');
                            var background = $('#' + $('#path').val()).css('background-color');

                            storeValues($('#' + $('#path').val()), fontcolor, text, fontsize, fontfamily, background);
                        });

                        textElement.unbind('click');
                        textElement.bind('click', function () {
                            $('#selector').val('tbody tr td p');
                            $('.selected-item').removeClass('selected-item').css('border', 'none');
                            textElement.css('border', '1px dotted red');
                            $(this).addClass('selected-item');

                            var fontcolor = textElement.css('fontColor');
                            var text = textElement.html();
                            var fontsize = textElement.css('font-size');
                            var fontfamily = textElement.css('font-family');
                            var background = $('#' + $('#path').val()).css('background-color');
                            $('#selector').val('tbody tr td p');
                            storeValues($('#' + $('#path').val()), fontcolor, text, fontsize, fontfamily, background);


                        })
                        $('form#font-settings').show();
                        $('form#editor').show();
                        $('form#font-settings').show();

                        break;

                    case 'line':
                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        $('.selected-item').removeClass('selected-item').css('border', 'none');
                        break;

                    case 'button':
                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        $('.selected-item').removeClass('selected-item').css('border', 'none');
                        handleButtons(self);
                        break;

                    case 'social-links':

                        $('#bgcolor').css('backgroundColor', $('#' + $('#path').val()).css('backgroundColor'));
                        $('.selected-item').removeClass('selected-item').css('border', 'none');
                        $('#selector').val('tr td');


                        if (self.find('a.facebook').is(":visible")) {
                            $('input.social-check :eq(0)').prop('checked', true);
                        } else {
                            $('input.social-check :eq(0)').prop('checked', false);
                        }

                        if (self.find('a.twitter').is(":visible")) {
                            $('input.social-check :eq(1)').prop('checked', true);
                        } else {
                            $('input.social-check :eq(1)').prop('checked', false);
                        }

                        if (self.find('a.linkedin').is(":visible")) {
                            $('input.social-check :eq(2)').prop('checked', true);
                        } else {
                            $('input.social-check :eq(2)').prop('checked', false);
                        }

                        if (self.find('a.youtube').is(":visible")) {
                            $('input.social-check :eq(3)').prop('checked', true);
                        } else {
                            $('input.social-check :eq(3)').prop('checked', false);
                        }


                        $('input.social-input [name="facebook"]').val(self.find('a.facebook').attr('href'));

                        $('input.social-input [name="twitter"]').val(self.find('a.twitter').attr('href'));

                        $('input.social-input [name="linkedin"]').val(self.find('a.linkedin').attr('href'));

                        $('input.social-input [name="youtube"]').val(self.find('a.youtube').attr('href'));

                        $('#social-links').show();


                        break;

                    default:
                        console.log(t);
                        break;
                }
                // end of bind click function
                showSettings();

            });

            self.fadeIn(800);


    });
}


function addhttp(url) {
    if (url.substr(0, 7) != 'http://') {
        url = 'http://' + url;
    }
    if (url.substr(url.length - 1, 1) != '/') {
        url = url + '/';
    }
    return url;
}
function handleButtons(obj) {
    var buttons = obj.find('table tbody tr td a');
    $('#buttons').show();
    var btn_settings = $('#buttonslist li');
    var ul = $('#buttonslist');
    btn_settings.each(function () {
        if (!$(this).hasClass('hide')) {
            $(this).detach();
        }
    });

    buttons.each(function () {
        var clone = ul.find('li:first').clone(true);
        // clone.next('div.form-group > input[value="btn_title"]').val("wsu");

        var btn = $(this);

        // if (btn.data('default') !== '1') {

        clone.find('div.form-group > input[name="btn_title"]').val(btn.html())
                .change(function () {
                    btn.html($(this).val());
                });
        //}

        clone.find('div.input-group > input[name="btn_link"]').val(btn.attr('href'))
                .change(function () {
                    btn.attr('href', addhttp($(this).val()));
                    btn.unbind('click');
                    btn.bind('click', function (e) {
                        e.preventDefault()
                    });
                });

        clone.find('div.buttonStyle').popover({
            title: 'Button Style',
            html: true,
            content: clone.find('div.stylebox').html()
        }).css('backgroundColor', btn.css('backgroundColor')).css('color', btn.css('fontColor'));

        clone.find('.trashbutton').css('cursor', 'pointer').click(function () {
            if ($('#buttonslist li').length !== 2) {
                $(this).parent('li').slideUp(500);
                $(this).parent('li').detach();
                btn.parent('td').detach();
                $('#add-button').show();
            } else {
                alert('You can\'t remove this element');
            }
        });

        clone.appendTo(ul).removeClass('hide');

    });
}

function storeValues(obj, fontcolor, text, fontsize, fontfamily, background) {
    // tinyMCE.activeEditor.setContent(text);
    //var theeditor = tinyMCE.get('html5editor');
    //var editorlite = tinyMCE.get('html5editorlite');
    if(text != ''){
        $('#editor').empty();
    $('#editor').append('<div class="panel panel-body panel-default html5editor" id="html5editor"></div>');
    ClassicEditor
        .create( document.querySelector( '#html5editor' ) )
        .then( editor => {
            editor.setData(text);
            editor.model.document.on( 'change:data', () => {
                $('#' + $('#path').val()).find($('#selector').val()).html(editor.getData());
            } );
        } )
        .catch( error => {
            console.error( error );
        } );

    }


    $('p').on('click', function(e){
        var textValue = $(this).html();

    $('#editor').empty();
    $('#editor').append('<div class="panel panel-body panel-default html5editor" id="html5editor"></div>');
    ClassicEditor
        .create( document.querySelector( '#html5editor' ) )
        .then( editor => {
            editor.setData(textValue);
            editor.model.document.on( 'change:data', () => {
                //$(this).empty()
                //$('#' + $('#path').val()).find($('#selector').val()).eq(0).empty();
                $(this).html(editor.getData());
                //$('#' + $('#path').val()).find($('#selector').val()).html(editor.getData());
            } );
        } )
        .catch( error => {
            console.error( error );
        } );

    });
    


    $('#bgcolor').css('backgroundColor', background);
    obj.data('fontcolor', fontcolor);
    obj.data('text', text);
    obj.data('fontsize', fontsize);
    obj.data('fontfamily', fontfamily);
    obj.data('background', background);

}

function gridSystemGenerator() {
    $(".lyrow .preview input").bind("keyup", function () {
        var e = 0;
        var t = "";
        var n = false;
        var r = $(this).val().split(" ", 12);
        $.each(r, function (r, i) {
            if (!n) {
                if (parseInt(i) <= 0)
                    n = true;
                e = e + parseInt(i);
                t += '<div class="col-md-' + i + ' column"></div>'
            }
        });
        if (e == 12 && !n) {
            $(this).parent().next().children().html(t);
            $(this).parent().prev().show()
        } else {
            $(this).parent().prev().hide()
        }
    })
}


function configurationElm(e, t) {

    $(".demo").delegate(".configuration > a", "click", function (e) {
        e.preventDefault();
        var t = $(this).parent().parent();
        var clone = t.clone();
        //t.css('border', '4px solid red');

        clone.find('table.main').removeAttr('id');
        $(clone).insertAfter(t);
        handleObjects();
    });

}

function subtitle(el) {

    var textValue = $(el).html();
    console.log(el);
    $('#editorlite').empty();
    $('#editorlite').append('<div class="panel panel-body panel-default html5editor" id="html5editorlite"></div>');
    ClassicEditor
        .create( document.querySelector( '#html5editorlite' ) )
        .then( editor => {
            editor.setData(textValue);
            editor.model.document.on( 'change:data', () => {
                //$(this).empty()
                //$('#' + $('#path').val()).find($('#selector').val()).eq(0).empty();
                $(el).html(editor.getData());
                //$('#' + $('#path').val()).find($('#selector').val()).html(editor.getData());
            } );
            editor.model.change( writer => {
                const insertPosition = editor.model.document.selection.getFirstPosition();
                writer.insertText( 'foo', insertPosition );
            } );
        } )
        .catch( error => {
            console.error( error );
        } );

}

function maintitle(el) {

    var textValue = $(el).html();
    $('#editorlite').empty();
    $('#editorlite').append('<div class="panel panel-body panel-default html5editor" id="html5editorlite"></div>');
    ClassicEditor
        .create( document.querySelector( '#html5editorlite' ) )
        .then( editor => {
            editor.setData(textValue);
            editor.model.document.on( 'change:data', () => {
                //$(this).empty()
                //$('#' + $('#path').val()).find($('#selector').val()).eq(0).empty();
                $(el).html(editor.getData());
                //$('#' + $('#path').val()).find($('#selector').val()).html(editor.getData());
            } );
            editor.model.change( writer => {
                const insertPosition = editor.model.document.selection.getFirstPosition();
                writer.insertText( 'foo', insertPosition );
            } );
        } )
        .catch( error => {
            console.error( error );
        } );

}


function addCol() {
    $('.demo').delegate('.addcol', 'click', function (e) {
        e.preventDefault();
        var c = $(this).parent().find("[data-clonable='true']").first().clone();
        $(this).parent().find("[data-clonable='true']").parent().append(c);
    });
}

function removeElm() {
    $(".demo").delegate(".remove", "click", function (e) {
        if(confirm('are you sure?')){
          //conta elem con lyrow
              if($('#tosave .lyrow').length>2){
                e.preventDefault();
                $(this).parent().remove();
                showElements();
              }else{
                
                alert('you cannot remove all elements');
              }
        }
    })
}


function removeMenuClasses() {
    $("#menu-layoutit li button").removeClass("active")
}
function changeStructure(e, t) {
    $("#download-layout ." + e).removeClass(e).addClass(t)
}
function cleanHtml(e) {
    $(e).parent().append($(e).children().html())
}

function cleanHtml(e) {
    $(e).parent().append($(e).children().html());
    $(e).remove();
}

function downloadLayoutSrc() {
    var e = "";
    $("#download-layout").html($("#tosave").html());
    var t = $("#download-layout");
    t.find(".preview, .configuration, .drag, .remove").remove();
    // applica le proprietà al bottone;
    t.find("a.button-1").each(function () {

        $(this).attr('href', $(this).data('href'));
    });

    var clone = t.find('td#primary').parent().parent().parent();

    console.log(clone);

    var preheader = t.find('td#primary .lyrow .view .row table.preheader').parent().html();
    var header = ""; //t.find('td#primary .lyrow .view .row table#header').parent().html();    <-- se si vogliono mettere header statici
    var body = '';


    t.find('div.column .lyrow .view .row').each(function () {
        var self = $(this);
        body += self.html();
    });

    var footer = "";  //t.find('table#footer').parent().html();   <-- se si vogliono mettere footer statici

    clone.find('td#primary').html(preheader + header + body + footer);

    $("#download").val(clone.parent().html());

}


var currentDocument = null;
var timerSave = 2e3;
var demoHtml = $(".demo").html();
$(window).resize(function () {
    $("body").css("min-height", $(window).height() - 90);
    $(".demo").css("min-height", $(window).height() - 160);
});


function getIndex(itm, list) {
    var i;
    for (i = 0; i < list.length; i++) {
        if (itm[0] === list[i])
            break;
    }
    return i >= list.length ? -1 : i;
}

$(document).ready(function () {

                 /*
    var featherEditor = new Aviary.Feather({
        apiKey: '*cf5d8b90e5ef44de9abacb415ed29b3d',
        apiVersion: 3,
        tools: 'all',
        theme: 'light', // Check out our new 'light' and 'dark' themes!
        onSave: function (imageID, newURL) {
            $('#' + $('#imageid').val()).attr('src', newURL);
            $('#' + $('#imageid').val()).hide();
            featherEditor.close();
            $('#' + $('#imageid').val()).show('puff', {}, 500);
        },
        onError: function (errorObj) {
            alert(errorObj.message);
        }
    });                            */

    $('#change-image').on('click', function(e){
        var id= $('#image-url').data('id');
        $('#'+id).attr('src', $('#image-url').val()) ;
        $('#'+id).attr('width', $('#image-w').val()) ;
        $('#'+id).attr('height', $('#image-h').val()) ;
    });

    $('#change-qr-code-image').on('click', function(e){
        var id= $('#image-url').data('id');
        $('#'+id).attr('src', $('#image-url').val()) ;
        $('#'+id).attr('width', $('#qr-code-properties #image-w').val()) ;
        $('#'+id).attr('height', $('#qr-code-properties #image-h').val()) ;
    });
                       /*
    $('#editimage').on('click', function (e) {
        e.preventDefault();
        featherEditor.launch({
            image: $('#' + $('#imageid').val()),
            url: $('#' + $('#imageid').val()).attr('src')
        });
    });
              */
    // paddings functions;
    $(document).on('change', '#ptop,#pbottom,#pleft,#pright', function (e) {

        $('#' + $('#path').val()).data('ptop', $('#' + $('#path').val()).css('padding-top'));
        $('#' + $('#path').val()).data('pbottom', $('#' + $('#path').val()).css('padding-bottom'));
        $('#' + $('#path').val()).data('pleft', $('#' + $('#path').val()).css('padding-left'));
        $('#' + $('#path').val()).data('pright', $('#' + $('#path').val()).css('padding-right'));

        $('#' + $('#path').val()).find('td').css('padding-top', $('#ptop').val());
        $('#' + $('#path').val()).find('td').css('padding-left', $('#pleft').val());
        $('#' + $('#path').val()).find('td').css('padding-right', $('#pright').val());
        $('#' + $('#path').val()).find('td').css('padding-bottom', $('#pbottom').val());

    });


    var indexBefore = -1;


    $('#buttonslist').sortable({
        handle: '.orderbutton',
        start: function (event, ui) {
            indexBefore = getIndex(ui.item, $('#buttonslist li')) - 1;

        },
        stop: function (event, ui) {
            var indexAfter = getIndex(ui.item, $("#buttonslist li")) - 1;
            // var td = $('#' + $('#path').val()).find('table tbody tr td');

            if (indexBefore < indexAfter) {
                $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexBefore + ')')).insertAfter(
                        $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexAfter + ')')));
            }
            else {
                $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexBefore + ')')).insertBefore(
                        $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexAfter + ')')));
            }

        }
    });


    $('#add-button').click(function () {
        //$('#buttonslist').first();

        var obj = $('#' + $('#path').val());

        var ul = $('#buttonslist');
        var nn = ul.children().length;

        if (nn !== 5) {
            var button = obj.find('table tbody tr td:first').clone(true);
            button.find('a').html('default');
            button.appendTo(obj.find('table tbody tr'));

            handleButtons(obj);


        } else {
            $(this).hide();
        }
    });


    $('#fontstyle').on('shown.bs.popover', function () {
        // carico le propieta dell'oggetto dal selettore.
        var obj = $('#' + $('#path').val());

        $('#colortext').val(obj.data('fontcolor'));
        $('#colortext').next('span.input-group-addon').css('backgroundColor', obj.data('fontcolor'));
        $('#fonttext').val(obj.data('fontfamily'));
        $('#sizetext').val(obj.data('fontsize'));


    });

    $('div#buttons .form-group select.form-control').change(function (e) {
        e.preventDefault();
        $('#' + $('#path').val()).find('table.button').attr('align', $(this).val());
    });


    $('div.buttonStyle').on('shown.bs.popover', function () {
        // carico le propieta dell'oggetto dal selettore.
        var self = $(this);

        var index = getIndex($(this).parent().parent(), $('#buttonslist li')) - 1;

        var bg = $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') > a').css('background-color');
        var font_color = $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('color');
        var font_size = $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('font-size');
        var btn_size = $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('width');

        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div.background span.picker').css('backgroundColor', bg);
        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div.fontcolor span.picker').css('backgroundColor', font_color);
        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div input[name="FontSize"]').val(font_size);
        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div input[name="ButtonSize"]').val(btn_size);

        // font size

        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div input[name="FontSize"]').change(function (e) {
            var fontSize = parseInt($(this).val());
            $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('font-size', fontSize);
        });


        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div span.font i.fa-plus').click(function (e) {
            var fontSize = parseInt($(this).parent().next('input').val());
            fontSize = fontSize + 1 + "px";
            $(this).parent().next('input').val(fontSize);
            $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('font-size', fontSize);
        });

        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div span.font i.fa-minus').click(function (e) {
            var fontSize = parseInt($(this).parent().prev('input').val());
            fontSize = fontSize - 1 + "px";
            $(this).parent().prev('input').val(fontSize);
            $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('font-size', fontSize);
        });

        // button size

        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div input[name="ButtonSize"]').change(function (e) {
            var btnsize = parseInt($(this).val());
            $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('width', btnsize);
        });


        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div span.button i.fa-plus').click(function (e) {
            var btnsize = parseInt($(this).parent().next('input').val());
            btnsize = btnsize + 1 + "px";
            $(this).parent().next('input').val(btnsize);
            $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('width', btnsize);
        });

        $('#buttonslist li:eq(' + getIndex($(this).parent().parent(), $('#buttonslist li')) + ') div div div span.button i.fa-minus').click(function (e) {
            var btnsize = parseInt($(this).parent().prev('input').val());
            btnsize = btnsize - 1 + "px";
            $(this).parent().prev('input').val(btnsize);
            $('#' + $('#path').val()).find('table tbody tr td:eq(' + index + ') a').css('width', btnsize);
        });



        $(this).parent().find('div div.text a').click(function () {
            self.popover('hide');
        });

    });


    // social links

    $(document).on('change', '.social-input', function (e) {
        e.preventDefault();
        var name = $(this).attr('name');
        $('#' + $('#path').val()).find($('#selector').val() + ' a.' + name).attr('href', 'http://' + $(this).val()).attr('target', '_blank');
    });

    $(document).on('change', '.social-check', function (e) {
        e.preventDefault();
        var name = $(this).attr('name');
        if ($(this).is(':checked')) {
            $('#' + $('#path').val()).find($('#selector').val() + ' a.' + name).show();
        } else {
            $('#' + $('#path').val()).find($('#selector').val() + ' a.' + name).hide();
        }

    });

    /*settings functions*/

    $(document).on('click', '#saveElement', function (e) {
        
        e.preventDefault();
        /*
         * must apply element properties
         */
        /*  e.data('fontcolor');
         e.data('text');
         e.data('fontsize');
         e.data('fontfamily');
         e.data('background');
         */
        $('div.row').removeClass('active');
        $('.selected-item').removeClass('selected-item').css('border', 'none');
        showElements();
    });



    $(document).on("click", "#fonttext", function (e) {
        e.preventDefault();
        $('#mainfontproperties').hide('slow');
        $('#fontselector').removeClass('hide').toggle();
        $('#fontselector').slideDown();
    });


    $(document).on('click', '#fontselector ul li', function (e) {
        var selectedFont = $(this).text();
        $('#fontselector').slideUp();
        $('#fonttext').css('font-family', selectedFont).val(selectedFont);
        $('#mainfontproperties').show('slow');
    });

    $(document).on('click', '#fontselector ul li', function (e) {
        var selectedFont = $(this).text();
        $('#fontselector').slideUp();
        $('#fonttext').css('font-family', selectedFont).val(selectedFont);
        $('#mainfontproperties').show('slow');
    });


    $(document).on("click", ".minus", function (e) {
        e.preventDefault();
        var val = $(this).parent().find('input').val();
        if (val === '') {
            val = 0;
        }
        var value = parseInt(val) - 1;
        if (value < 4) {
            return;
        }
        $(this).parent().find('input').val(value + 'px');
    });

    $(document).on("click", ".plus", function (e) {
        e.preventDefault();
        var val = $(this).parent().find('input').val();
        if (val === '') {
            val = 0;
        }
        var value = parseInt(val) + 1;
        if (value > 74) {
            return;
        }

        $(this).parent().find('input').val(value + 'px');
    });

    $(document).on("click", '#confirm-font-properties', function (e) {
        e.preventDefault();

        var obj = $('#' + $('#path').val()).find($('#selector').val());

        // applying font properties

        obj.css('font-family', $('#fonttext').val());
        obj.css('color', $('#colortext').val());
        obj.css('font-size', $('#sizetext').val());

        $('#fontstyle').popover('hide');


    });
    $('#fontstyle').on('hide.bs.popover', function () {
        $('.popover').css('z-index', '-1');
    });
    $('#fontstyle').on('shown.bs.popover', function () {
        $('.popover').css('z-index', '25000');
    });
    $('#fontstyle').popover({
        html: true,
        trigger: "click",
        placement: "right",
        title: "Font Style",
        content: function () {
            return  $('#font-style').html();
        }
    });


    $("body").css("min-height", $(window).height() - 90);
    $(".demo").css("min-height", $(window).height() - 160);
    $(".demo .column").sortable({connectWith: ".column", opacity: .35, handle: ".drag"});
    $(".sidebar-nav .lyrow").draggable({connectToSortable: ".column", helper: 'clone',
        stop: function (e, t) {
            handleObjects();
            $(".demo .column").sortable({opacity: .35, connectWith: ".column"});
            $(".demo .column .lyrow").find('.drag').removeClass('hide');
        }});

    var clickSave = 0;
    $('#save').on('click', function(){
         if($('#template_name').val().length == 0){
            $('#required').css('visibility', 'visible');
            $('#template_name').css('border-color', '#dc3545');
            return ; 
        }
        if(template_id){
            saveTemplate();
            return ;
        }

        if(clickSave == 0){
            $.post(path + 'ajaxdorian/check_template_exists', {template_name: $('#template_name').val()}, function (data) {
                if(data == 'true'){
                    alertify['error']('This template name already exists!');
                    return ;
                } else {
                    saveTemplate();
                }      
            });
        } else {
            saveTemplate();
        }
        clickSave++;
    });


    function saveTemplate() {
        downloadLayoutSrc();

        var save = $('#tosave'); 
        $.post(path + 'ajaxdorian/saveemailtemplatesource', {
            html: save.html(),
            data : save.data(),
            user_id: user_id,
            template_id: template_id,
            template_name: $('#template_name').val()
        }, function (data) {
            response = $.parseJSON(data)
            alertify[response.status](response.msg);
        }, 'html');
    }

    $("#edit").click(function () {
        $("body").removeClass("devpreview sourcepreview");
        $("body").addClass("edit");
        removeMenuClasses();
        $(this).addClass("active");
        return false;
    });

    $("#previewModal").on("show.bs.modal", function () {
        $('div.previewActions a').click(function (e) {
            e.preventDefault();
            var t = $(this).text();
            $('div.previewActions a').removeClass('active');
            $(this).addClass('active');

            $('#previewFrame').removeClass('iphone');
            $('#previewFrame').removeClass('ipad');
            $('#previewFrame').removeClass('smalltablet');

            $('#previewFrame').addClass(t);
            var w = parseInt($('#previewFrame').css('width')) + 50;
            $("#previewModal").find(".modal-content").css("width", w);

        });


        var w = parseInt($('#previewFrame').css('width')) + 50;
        $("#previewModal").find(".modal-content").css("width", w);
    });

    $("#sourcepreview").click(function (i) {
        i.preventDefault();
        downloadLayoutSrc();
        $.post(path + 'ajaxdorian/saveemailtemplate', {html: $('#download').val(), id: $('#tosave').data('id')}, function (data) {
            $('#httphref').val(data);
            $('#previewFrame').attr('src', data);
        }, 'html');

        $('#previewModal').modal('show');
        return false;
    });

    $('#edittamplate').click(function () {
        $('#common-settings').hide();
        $('#font-settings').hide();
        $('#editor').hide();
        $('#editimage').hide();
        $('#editorlite').hide();
        $('#social-links').hide();
        $('#buttons').hide();
        $('#path').val('tosave table:first');

        $('#bgcolor').css('background-color', $('#tosave table').css('backgroundColor'));

        showSettings();
    });

    /*
     $(".nav-header").click(function () {
     $(".sidebar-nav .boxes, .sidebar-nav .rows").hide();
     $(this).next().slideDown()
     });
     */
    addCol();
    handleObjects();
    removeElm();
    handleHeader();
    handleFooter();
    configurationElm();
    //  configurationElm();
    ///  gridSystemGenerator();
    /*  setInterval(function () {
     handleSaveLayout()
     }, timerSave)*/


});
