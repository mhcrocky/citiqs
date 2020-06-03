/**
 * @author Kishor Mali
 */

$(document).ready(function () {

    $(document).on("click", ".deleteUser", function () {
        var userId = $(this).data("userid"),
                hitURL = baseURL + "deleteUser",
                currentRow = $(this);

        var confirmation = confirm("Are you sure to delete this label?");

        if (confirmation)
        {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: {userId: userId}
            }).done(function (data) {
                console.log(data);
                currentRow.parents('tr').remove();
                if (data.status == true) {
                    alert("label successfully deleted");
                } else if (data.status == false) {
                    alert("label deletion failed");
                } else {
                    alert("Access denied..!");
                }
            });
        }
    });

jQuery(document).on("click", ".deleteAppointment", function () {
        var appointmentid = $(this).data("appointmentid"),
                hitURL = baseURL + "deleteAppointment",
                currentRow = $(this);
        var confirmation = confirm("Are you sure to delete this appointment?");

        if (confirmation)
        {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: {appointmentid: appointmentid}
            }).done(function (data) {
                console.log(data);
                currentRow.parents('tr').remove();
                if (data.status == true) {
                    alert("appointment successfully deleted");
                } else if (data.status == false) {
                    alert("appointment deletion failed");
                } else {
                    alert("Access denied..!");
                }
            });
        }
    });

    jQuery(document).on("click", ".searchList", function () {

    });

});
