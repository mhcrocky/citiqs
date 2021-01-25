$(document).ready(function() {

    $('.input').focus(function() {
        $(this).parent().find(".label-txt").addClass('label-active');
    });

    $(".input").focusout(function() {
        if ($(this).val() == '') {
            $(this).parent().find(".label-txt").removeClass('label-active');
        };
    });
    $("#email").on("keyup", function() {
        $(".email .line-box").css("background", "#BCBCBC");
    });
    $("#address").on("keyup", function() {
        $(".address .line-box").css("background", "#BCBCBC");
    });
    $("#pay").on("click", function() {
        let email = $("#email").val();
        let address = $("#address").val();
        if (email == "" && address == "") {
            $(".email .line-box").css("background", "#df4759");
            $(".address .line-box").css("background", "#df4759");

        } else if (address == "") {
            $(".address .line-box").css("background", "#df4759");

        } else if (email == "") {
            $(".email .line-box").css("background", "#df4759");
        }
    });

});