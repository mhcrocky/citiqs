
<!-- end booking form results -->
</div>
<!-- end booking form -->



<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>

<!-- datepicker -->

<script>
(function() {
    customDesignLoad();
    var url = '<?php echo current_url(); ?>';
    url = url.split('/');

    if (url.includes('spots')) {
        $("#spot-active").addClass('booking-active');
    } else if (url.includes('time_slots')) {
        $("#timeslot-active").addClass('booking-active');
    } else if (url.includes('pay')) {
        $("#personal-active").addClass('booking-active');
        $('#booking-footer').removeClass('d-none');
    } else {
        $("#agenda-active").addClass('booking-active');
    }
})();



/* get number of persons on click */
$('#person-input .form-check-label').on('click', function() {
    $('#selected-persons').text($(this).siblings('input').val());
    $('.step-2').removeClass('active');
    $('.step-3').addClass('active');
});

/* get time slot on click */
$('#time-input .form-check-label').on('click', function() {
    //$('#selected-time').text($(this).siblings('input').val());
    $('.step').removeClass('active');
    $('.step-4').addClass('active');
});

/* show value when input field lose focus */
$('#name-input').blur(function() {
    $('#personal-name').text($(this).val());
})

$('#email-input').blur(function() {
    $('#personal-email').text(', ' + $(this).val());
})

$('#phone-input').blur(function() {
    $('#personal-phone').text(', ' + $(this).val());
})



/* go back button */
$('.go-back-button').click(function() {
    $(this).parents('.step').removeClass('active');
    $(this).parents('.step').prev().addClass('active')
})

function displayView(id){
    $('.agenda').removeClass('d-none');
    $('.agenda').hide();
    $('#'+id).fadeIn( "slow", function() {
        $('#'+id).show();
    });
    
}
</script>

</body>

</html>