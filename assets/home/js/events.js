$(document).ready(function() {
    $("#country").on("change", function(){
        var country = $("#country option:selected").val();
        $("#eventCountry").val(country);
    });
    var toolbarOptions = [
        ['bold', 'italic', 'underline'], // toggled buttons
        ['blockquote', 'code-block'],

        [{
            'header': 1
        }, {
            'header': 2
        }], // custom button values
        [{
            'list': 'ordered'
        }, {
            'list': 'bullet'
        }],
        [{
            'indent': '-1'
        }, {
            'indent': '+1'
        }], // outdent/indent
        [{
            'direction': 'rtl'
        }], // text direction

        [{
            'size': ['small', false, 'large', 'huge']
        }], // custom dropdown
        // dropdown with defaults from theme
        [{
            'font': []
        }],
        [{
            'align': []
        }],
        ['link'],
        ['clean'] // remove formatting button
    ];

    var quill = new Quill('#editor', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    });

    var logEl = document.querySelector('#log');
    var addToLog = function(text) {
        var newMsg = document.createElement('div');
        newMsg.innerHTML = text;
        logEl.appendChild(newMsg);
    };
    quill.on('selection-change', function(range, oldRange, source) {
        if (range === null && oldRange !== null) {
            $('.ql-container').removeClass('bg-in');
        } else if (range !== null && oldRange === null)
            $('.ql-container').addClass('bg-in');
    });
    quill.on('text-change', function(delta, source) {
        var content = $(".ql-editor").html();
        $("#eventdescript").val(content);
      });

});
$('<div class="age-nav"><div class="age-button age-up"><i class="fa fa-caret-up" aria-hidden="true"></i></div><div class="age-button age-down"><i class="fa fa-caret-down" aria-hidden="true"></i></div></div>')
    .insertAfter('.age input');
$('.age').each(function() {
    var spinner = $(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.age-up'),
        btnDown = spinner.find('.age-down'),
        min = input.attr('min'),
        max = input.attr('max');

    btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });

    btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });



});
$(function() {
$('.input-date').datepicker({
    format: 'yyyy-mm-dd',
    calendarWeeks: true,
    todayHighlight: true,
    autoclose: true
});
});

$(document).on("click", ".browse", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
  });
  $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
   
  
    var reader = new FileReader();
    reader.onload = function(e) {
      // get loaded data and render thumbnail.
      document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
  });

function imageUpload(el) {

    $('.file-custom').hover(function() {
        $(this).attr('data-content', el.files[0].name);
    });

}

function editImageUpload(el) {

    $('.file-custom').hover(function() {
        $(this).attr('data-content', el.files[0].name);
    });

    $("#imgChanged").val('true');

}
