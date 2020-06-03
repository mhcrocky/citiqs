function uploadIdentification(formId) {
    let message = 'Please, don\'t close your browser, don\'t move away from this screen and don\'t touch anything. Identfication will start after your press OK and will take approximately 60 seconds.';
    alertify.alert(message);
    let form = document.getElementById(formId);
    let url = globalVariables.ajax + 'uploadIdentification';
    sendFormAjaxRequest(form, url, 'uploadIdentification');
    form.reset();
    return false;
}

function uploadUtilityBill(formId) {
    let form = document.getElementById(formId);
    let url = globalVariables.ajax + 'uploadUtilityBill';
    sendFormAjaxRequest(form, url, 'uploadUtilityBill');
    form.reset();
    return false;
}


jQuery(document).ready(function () {
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "userReturnitemslisting/" + value);
        jQuery("#searchList").submit();
    });
});

$('input[type=file]').change(function () {
    var fileID = $(this).attr('id');
    if (document.getElementById(fileID).files.length == 0) {
        alertify.alert('No files selected');
    } else {
        $('#' + fileID).parent('form').submit();
    }
});

// $('input[type=radio][name=collectWay]').change(function () {
//     if (this.value == 'dhl') {
//         $("#collectAppointment").addClass("hide");
//         $("#collectDHL").removeClass("hide");
//     } else if (this.value == 'appointment') {
//         $("#collectDHL").addClass("hide");
//         $("#collectAppointment").removeClass("hide");
//     }
// });

$('body').on('change', '#selectappointment', function() {
    let appointment = globalVariables.baseUrl + 'selectAppointment/' + this.value;
    $("#confirmAppointment").attr("data-src",appointment);
});

$("[data-fancybox]").fancybox({
    beforeLoad: function (instance, slide) {

        // check if element had id filled in
        if ($(slide.opts.$orig).attr('id'))
        {   // label id is needed in submit
            $("#ilabelid").val($(slide.opts.$orig).attr('id').substring(3));
            $("#ublabelid").val($(slide.opts.$orig).attr('id').substring(3));
        }

    }
});
