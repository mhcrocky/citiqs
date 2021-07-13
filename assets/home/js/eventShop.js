(function() {
    //lazyload();
    if (typeof globalTime === 'undefined' && $('#shop').length == 0) {
        window.location.href = globalVariables.baseUrl + "booking_events/clear_tickets?order=" + globalKey.orderRandomKey;
    } else if(typeof globalTime !== 'undefined' && dayjs(globalTime.time) < dayjs()){
        window.location.href = globalVariables.baseUrl + "booking_events/clear_tickets?order=" + globalKey.orderRandomKey;
    }

    if($('.ticket_item').length > 0){
        $('#payForm').show();
    }

    if(document.getElementsByClassName('single-item__image').length == 1){
        var x = window.matchMedia("(max-width: 770px)");
        hideEventElement(x);
    }

    if ($('#first_element').val()) {
        let id = $('#first_element').val();
        getBackgroundImage(id);
        //getTicketsView(id, true);
    }

}());

window.onresize = onResizeEventElement;

$(document).ready(function(){
    $('body').show();
    if (typeof globalTime !== 'undefined') {
        let time = globalTime.time;
        var countDownDate = moment(time);
        var now = moment();
        var distance = countDownDate - now;
        countDownTimer(distance);
    }
    
    setInterval(() => {
        var CurrentDate = moment().format();
        $(".current_time").val(CurrentDate);

    }, 1000);

    $(document).on('click', '.quantity-up', function() {
        let id = $(this).data("embellishmentid");
        let price = $("#price_"+id).val();
        let ticketFee = $("#price_"+id).attr('data-ticketfee');
        let groupId = $("#ticketQuantityValue_" + id).attr('data-groupid');
        let bundleMax = $('.quantity-input_'+groupId).attr('data-bundlemax');
        addTicket(id,  50, price, ticketFee, 'totalBasket', bundleMax);
      });

    $(document).on('click', '.quantity-down', function() {
        let id = $(this).data("embellishmentid");
        let quantity = parseInt($(".ticketQuantityValue_" + id).val());
        if(quantity == 1){
            return ;
        }
        let price = $("#price_"+id).val();
        let ticketFee = $("#price_"+id).attr('data-ticketfee');
        removeTicket(id, price, ticketFee, 'totalBasket');
      });

      $(document).on('input', '.input100-error', function() {
        $(this).closest("div").removeClass('input100-error');
      });

      $(document).on('change', '.emails', function() {
        let email = $("#email").val();
        email = email.toLowerCase();
        let repeatEmail = $("#repeatEmail").val();
        repeatEmail = repeatEmail.toLowerCase();
        if(validateEmail(email) && validateEmail(repeatEmail) && (email != repeatEmail)){
            $("#email").closest("div").addClass('input100-error');
            $("#repeatEmail").closest("div").addClass('input100-error');
            $('#emailMatchError').removeClass('d-none');
            let input = document.getElementById('email');
            input.select();
        } else {
            $("#email").closest("div").removeClass('input100-error');
            $("#repeatEmail").closest("div").removeClass('input100-error');
            $('#emailMatchError').addClass('d-none');
        }
      });

      

});

$("#next").on('click', function(e) {
    e.preventDefault();
    let total = $(".totalBasket").text();
    if (total != '00.00') {
        $("#my-form").submit();
    }
    return;
});

function payFormSubmit() {
    validatePayForm();
    let email = $("#email").val();
    email = email.toLowerCase();
    let repeatEmail = $("#repeatEmail").val();
    repeatEmail = repeatEmail.toLowerCase();
    if(validateEmail(email) && validateEmail(repeatEmail) && (email != repeatEmail)){
        $("#email").closest("div").addClass('input100-error');
        $("#repeatEmail").closest("div").addClass('input100-error');
        $('#emailMatchError').removeClass('d-none');
        let input = document.getElementById('email');
        input.select();
        return ;
    }
    
    $('#pay').click();
    return ;
}

function validatePayForm() {
    $('input:required').each(function(index){

        if($(this).val() == ''){
            $(this).closest("div").addClass('input100-error');

            
        } else {

            if($(this).is(':checkbox')){
                $('input:checkbox').closest("div").removeClass('input100-error');
                $('.success-check').addClass('terms-error');
            }
            $(this).closest("div").removeClass('input100-error');
            if($(this).attr('name') == 'email'){
                let email = $(this).val();
                validateEmail(email) ? '' : $(this).closest("div").addClass('input100-error');
            }
        }
        
    })
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function getTicketsView(eventId, first = false) {
    let isAjax = true;
    $('div.bg-light').removeClass('bg-light').addClass('bg-white');
    $("#event_" + eventId).addClass('bg-light').removeClass('bg-white');
    var img_src = $('#background_img_' + eventId).val();
    var isSquared = $('#background_img_' + eventId).attr('data-isSquared');
    var isShowed = $('#background_img_' + eventId).attr('data-isShowed');
    $.post(globalVariables.baseUrl + "events/tickets/" + eventId, {
        isAjax: isAjax,
        order: globalKey.orderRandomKey
    }, function(data) {
        $("#my-form").remove();
        $("#main-content").after(data);
        if(img_src == ''){
            $("#background-image").attr("src", globalVariables.baseUrl + "assets/images/events/default_background.webp");
        } else {
            $("#background-image").attr("src", globalVariables.baseUrl + "assets/images/events/" + img_src);
        }

        var visibility = (isShowed == '0') ? 'hidden' : 'visible';

        if(isSquared == '1'){
            
            $('.hero__background').attr('style', 'clip-path: none !important;width: 100%;max-width: 65%; height: auto !important;visibility:'+visibility);
        } else {
            $('.hero__background').attr('style', 'visibility:'+visibility);
        }
        
        $("#tickets").fadeIn("slow", function() {
            if (first) {
                return;
            }

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#tickets").offset().top
            }, 1000);
        });
    });


}

function getBackgroundImage(eventId) {
    var img_src = $('#background_img_' + eventId).val();
    var isSquared = $('#background_img_' + eventId).attr('data-isSquared');
    var isShowed = $('#background_img_' + eventId).attr('data-isShowed');
    var visibility = (isShowed == '0') ? 'hidden' : 'visible';

    if(img_src == ''){
        $("#background-image").attr("src", globalVariables.baseUrl + "assets/images/events/default_background.webp");
    } else {
        $("#background-image").attr("src", globalVariables.baseUrl + "assets/images/events/" + img_src);
    }
    
    if(isSquared == '1'){
        $('.hero__background').attr('style', 'clip-path: none !important;width: 100%;max-width: 65%; height: auto !important;visibility:'+visibility);
    } else {
        $('.hero__background').attr('style', 'visibility:'+visibility);
    }


}

function countDownTimer(distance){

    var x = setInterval(function() {
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    $('#exp_time').val(distance);
    if($('.ticket_item').length > 0) {
        $(".timer").text("Expiration time: " + addZero(minutes) + ":" + addZero(seconds) + "");
        if (minutes == 0 && seconds == 0) {
            setTimeout(() => {
                window.location.href = globalVariables.baseUrl + "booking_events/clear_tickets?order=" + globalKey.orderRandomKey;
            }, 500);
        }
        if (distance < 0) {
            clearInterval(x);
            window.location.href = globalVariables.baseUrl + "booking_events/clear_tickets?order=" + globalKey.orderRandomKey;
            $(".timer").text("EXPIRED");
        }
    } else {
        clearInterval(x);
    }
    distance = distance - 1000;
}, 1000);


}

function addZero(num) {
    let i = parseInt(num);
    if (i < 10) {
        num = "0" + num;
        return num;
    }
    return num;
}

function absVal(el) {
    let value = $(el).val();
    let absVal = Math.abs(value);
    return $(el).val(absVal);
}

function deleteTicket(id, price, ticketFee) {
    let quantityValue = $(".ticketQuantityValue_" + id).val();
    var totalBasket = $("#totalBasketAmount").val();
    let totalTicketFee = $("#ticketFee").val();
    quantityValue = parseInt(quantityValue);
    totalBasket = parseFloatNum(totalBasket);
    price = parseFloatNum(price);
    ticketFee = parseFloatNum(ticketFee);
    totalBasket = totalBasket - quantityValue*(price + ticketFee);
    $(".ticketQuantityValue_" + id).val(0);
    let current_time = $('#exp_time').val();
    let list_items = ($('.ticket_item').length > 1) ? 1 :0;
    totalTicketFee = parseFloatNum(totalTicketFee) - quantityValue*(ticketFee);

    let data = {
        id: id,
        current_time: current_time,
        totalBasket: totalBasket,
        list_items: list_items,
        order: globalKey.orderRandomKey 
    }
    $.post(globalVariables.baseUrl + "booking_events/delete_ticket", data, function(data){
		$( ".ticket_"+id ).fadeOut( "slow", function() {
            $( ".ticket_"+id ).remove();
            $(".totalBasket").text(totalBasket.toFixed(2));
            $('#totalBasket').text(totalBasket.toFixed(2));
            $("#totalBasketAmount").val(totalBasket.toFixed(2));
            $("#ticketFee").val(totalTicketFee.toFixed(2));
            $("#ticketFeeAmount").text(totalTicketFee.toFixed(2) + '€');
            if($('.ticket_item').length < 1) {
                $('#payForm').hide();
                $('.timer').empty();
                $('#ticketFeeRow').hide();
            }
        });
	})
}


function clearTotal(el, price, totalClass){
	var quantity = $(el).val();
	var totalBasket = $("#totalBasketAmount").val();
    
	totalBasket = parseInt(totalBasket);
	quantity = Math.abs(parseInt(quantity));
	price = parseInt(price);
	totalBasket = Math.round((totalBasket - quantity*price) * 1e12) / 1e12;
    $("#totalBasketAmount").val(totalBasket.toFixed(2));
	return $("."+totalClass).text(totalBasket.toFixed(2));
}

function removeTicket(id, price, ticketFee, totalClass) {
    var quantityValue = $(".ticketQuantityValue_" + id).val();
    if(quantityValue < 1){ return; }
    if(quantityValue < 2){
        deleteTicket(id, price, ticketFee);
        $(".ticketQuantityValue_" + id).val(0);
        return;
    }
    var totalBasket = $("#totalBasketAmount").val();
    var totalTicketFee = $("#ticketFee").val();
    quantityValue = Math.abs(parseInt(quantityValue));
    totalBasket = parseFloatNum(totalBasket);
    price = parseFloatNum(price);
    ticketFee = parseFloatNum(ticketFee);
    var priceVal = price;
    
    quantityValue--;
    totalBasket = Math.round((totalBasket - price - ticketFee) * 1e12) / 1e12;
    totalTicketFee = parseFloatNum(totalTicketFee) - parseFloatNum(ticketFee);
    $(".ticketQuantityValue_" + id).val(Math.abs(quantityValue));
    $("#quantity_" + id).val(Math.abs(quantityValue));
    $("#totalBasketAmount").val(totalBasket.toFixed(2));
    $("."+totalClass).text(totalBasket.toFixed(2));
    $("#ticketFee").val(totalTicketFee.toFixed(2));
    $("#ticketFeeAmount").text(totalTicketFee.toFixed(2) + '€');
    let current_time = $(".current_time").val();

    let data = {
        id: id,
        quantity: quantityValue,
        order: globalKey.orderRandomKey,
        time: current_time

    }

    $.post(globalVariables.baseUrl + "booking_events/add_to_basket", data, function(data){
        data = JSON.parse(data);
        var descript_data = data['descript'];
        var price_data = data['price'];
        var ticketFee_data = data['ticketFee'];
        var first_ticket = data['first_ticket'];
        var eventName = data['eventName'];
        var groupId = data['groupId'];
        var bundle = data['bundleMax'];
        let descriptionTitle = data['descriptionTitle'];
        let html = '<div class="menu-list__item ticket_item ticket_'+id+'">'+
        '<div class="menu-list__name">'+
            '<b class="menu-list__title">'+descriptionTitle+'</b>'+
            '<div>'+
                '<p class="menu-list__ingredients descript_'+id+'">'+eventName+' - '+descript_data+'</p>'+
            '</div>'+
        '</div>'+
        '<div class="menu-list__left-col ml-auto">'+
            '<div class="menu-list__price mx-auto">'+
                '<b class="menu-list__price--discount mx-auto ticket_price">'+price.toFixed(2)+'€</b>'+
            '</div>'+
            '<div class="quantity-section mx-auto mb-2">'+
                '<button type="button" class="quantity-button quantity-down" data-embellishmentid="'+id+'">-</button>'+
                '<input data-groupid="'+groupId+'" data-bundlemax="'+bundle+'" type="text" value="'+quantityValue+'" placeholder="0" onfocus="clearTotal(this, \''+price+'\', \''+ticketFee+'\', \'totalBasket\')" onblur="ticketQuantity(this,\''+id+'\', \''+price+'\', \''+ticketFee+'\', \'totalBasket\')" onchange="ticketQuantity(this,\''+id+'\', \''+price+'\', \''+ticketFee+'\', \'totalBasket\')" oninput="absVal(this);" disabled="" class="quantity-input quantity-input_'+id+' ticketQuantityValue_'+id+'">'+
                '<button type="button" class="quantity-button quantity-up" data-embellishmentid="'+id+'">+</button>'+
            '</div>'+
            '<b class="menu-list__type mx-auto">'+
                '<button onclick="deleteTicket(\''+id+'\',\''+priceVal+'\', \''+ticketFee.toFixed(2)+'\')" type="button" class="btn btn-danger bg-light color-secondary">'+
                    '<i class="fa fa-trash mr-2" aria-hidden="true"></i>'+
                    'Delete</button>'+
            '</b>'+
        '</div>'+
        '</div>'+
        '<input type="hidden" id="price_'+id+'" value="'+price_data+'" data-ticketfee="'+ticketFee_data+'">';


         if($('.ticket_'+id).length > 0){
            return $('.ticket_'+id).replaceWith(html);
        }
        if(first_ticket == 1){
            countDownTimer(600000);
        }
         $('#checkout-list').append(html);
    });
}

function addTicket(id, limit, price, ticketfee, totalClass, bundleMax) {
    $('#payForm').show();
    var quantityValue = $(".ticketQuantityValue_" + id).val();
    var totalBasket = $("#totalBasketAmount").val();
    var totalTicketFee = $("#ticketFee").val();
    var maxBooking = $(".ticketQuantityValue_" + id).attr('data-maxbooking');
    maxBooking = $.isNumeric(maxBooking) ? parseInt(maxBooking) : '';
    quantityValue = Math.abs(parseInt(quantityValue));
    totalBasket = Math.round((parseFloatNum(totalBasket)* 1e12)) / 1e12;
    price = parseFloatNum(price);
    ticketfee = parseFloatNum(ticketfee);
    limit = parseInt(limit);
    quantityValue++;

    if(limit < quantityValue){
        $(".ticketQuantityValue_" + id).val(limit);
            iziToast.error({
                title: 'SOLD OUT!',
                message: '',
                position: 'topRight'
            });
            return ;
        
    }

    var quantityValues = 0;
    let groupId = $("#ticketQuantityValue_" + id).attr('data-groupid');

    $('.quantity-input_'+groupId).each(function(index) {
        quantityValues = quantityValues + parseInt($(this).val());
 
    });
    

    if(bundleMax <= quantityValues){
        $(".ticketQuantityValue_" + id).val(quantityValue-1);
            iziToast.error({
                title: 'SOLD OUT!',
                message: '',
                position: 'topRight'
            });
            return ;
    }

    if(limit < quantityValue){
        $(".ticketQuantityValue_" + id).val(limit);
            iziToast.error({
                title: 'SOLD OUT!',
                message: '',
                position: 'topRight'
            });
            return ;
        
    }

    if($.isNumeric(maxBooking) && maxBooking < quantityValue){
        $(".ticketQuantityValue_" + id).val(maxBooking);
            iziToast.warning({
                title: '',
                message: 'You have reached the maximum bookings for this ticket!',
                position: 'topRight'
            });
            return ;
        
    }
    
   
    totalBasket = Math.round((totalBasket + price + ticketfee) * 1e12) / 1e12;
    totalTicketFee = parseFloatNum(totalTicketFee) + parseFloatNum(ticketfee);
    
    $(".ticketQuantityValue_" + id).val(Math.abs(quantityValue));
    $("#quantity_" + id).val(Math.abs(quantityValue));
    $("#totalBasketAmount").val(totalBasket.toFixed(2));
    $("#ticketFee").val(totalTicketFee.toFixed(2));
    $("#ticketFeeAmount").text(totalTicketFee.toFixed(2) + '€');
    $("."+totalClass).text(totalBasket.toFixed(2));

    $('#ticketFeeRow').show();
    
    let current_time = $(".current_time").val();
    let data = {
        id: id,
        quantity: quantityValue,
        time: current_time,
        amount: totalBasket.toFixed(2),
        order: globalKey.orderRandomKey
    };
    $.post(globalVariables.baseUrl + "booking_events/add_to_basket", data, function(data){
        data = JSON.parse(data);
        if(data['status'] == 'error'){
            $(".ticketQuantityValue_" + id).val(data['quantity']);
            $("."+totalClass).text(data['amount'].toFixed(2));
            $("#totalBasketAmount").val(data['amount'].toFixed(2));
            iziToast.warning({
                title: '',
                message: data['message'],
                position: 'topRight'
            });

            return ;
        }

        if(data['requiredInfo'] == '1'){
            $('.additionalInfo').each(function(index) {
                let required = $(this).attr('data-required');
                if(required == '1'){
                    $(this).prop('required', true);
                }
            })
        }
        
        var descript_data = data['descript'];
        var price_data = data['price'];
        var ticketFee_data = data['ticketFee'];
        var first_ticket = data['first_ticket'];
        var eventName = data['eventName'];
        var groupId = data['groupId'];
        let bundle = data['bundleMax'];
        let descriptionTitle = data['descriptionTitle'];
        let html = '<div class="menu-list__item ticket_item ticket_'+id+'">'+
        '<div class="menu-list__name">'+
            '<b class="menu-list__title">'+descriptionTitle+'</b>'+
            '<div>'+
                '<p class="menu-list__ingredients descript_'+id+'">'+eventName+' - '+descript_data+'</p>'+
            '</div>'+
        '</div>'+
        '<div class="menu-list__left-col ml-auto">'+
            '<div class="menu-list__price mx-auto">'+
                '<b class="menu-list__price--discount mx-auto ticket_price">'+price.toFixed(2)+'€</b>'+
            '</div>'+
            '<div class="quantity-section mx-auto mb-2">'+
                '<button type="button" class="quantity-button quantity-down" data-embellishmentid="'+id+'">-</button>'+
                '<input data-groupid="'+groupId+'" data-bundlemax="'+bundle+'" type="text" value="'+quantityValue+'" placeholder="0" onfocus="clearTotal(this, \''+price+'\', \'totalBasket\')" onblur="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" onchange="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" oninput="absVal(this);" disabled="" class="quantity-input quantity-input_'+id+' ticketQuantityValue_'+id+'">'+
                '<button type="button" class="quantity-button quantity-up" data-embellishmentid="'+id+'">+</button>'+
            '</div>'+
            '<b class="menu-list__type mx-auto">'+
                '<button onclick="deleteTicket(\''+id+'\',\''+price_data+'\', \''+ticketfee.toFixed(2)+'\')" type="button" class="btn btn-danger bg-light color-secondary">'+
                    '<i class="fa fa-trash mr-2" aria-hidden="true"></i>'+
                    'Delete</button>'+
            '</b>'+
        '</div>'+
        '</div>'+
        '<input type="hidden" id="price_'+id+'" value="'+price_data+'" data-ticketfee="'+ticketFee_data+'">';
        


         if($('.ticket_'+id).length > 0){
            return $('.ticket_'+id).replaceWith(html);
        }

        if(first_ticket == 1){
            countDownTimer(600000);
        }
         $('#checkout-list').prepend(html);
    });
    
}


function ticketQuantity(el, id, price, ticketfee, totalClass) {
    var quantityValue = $(el).val();
    if(quantityValue == 0 || quantityValue == '0'){
        $(el).val(1);
    }
    var totalBasket = $("#totalBasketAmount").val();
    quantityValue = parseInt(quantityValue);
    totalBasket = parseFloatNum(totalBasket);
    price = parseFloatNum(price);
    ticketfee = parseFloatNum(ticketfee);
    totalBasket = Math.round((totalBasket + quantityValue*(price + ticketFee)) * 1e12) / 1e12;
    $(el).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    $("#totalBasketAmount").val(totalBasket.toFixed(2));
    return $("."+totalClass).text(totalBasket.toFixed(2));
}


function parseFloatNum(num){
    if(!$.isNumeric( num )){
        return 0;
    }

    return parseFloat(num);
    
}

function onResizeEventElement(x){
    if(document.getElementsByClassName('single-item__image').length == 1){
        var x = window.matchMedia("(max-width: 770px)");
        hideEventElement(x);   
    }

    return ;
}

function hideEventElement(x){
    if(x.matches){
        document.querySelector('.single-item__grid').style.display = "none";
    } else {
        document.querySelector('.single-item__grid').style.display = "block";
    }

    return ;
}

function paymentMethodRedirect(el){
    var amount = $('.totalBasket').text();
    var paymentFee = $(el).attr('data-paymentFee');
    paymentFee = paymentFee.replace( /^\D+/g, '');
    paymentFee = isNumber(paymentFee) ? paymentFee : 0;
    paymentFee = parseFloat(paymentFee);

    var total = parseFloat(amount) + paymentFee;
    $('.totalBasket').text(total.toFixed(2));

    setTimeout(() => {
        var url = $(el).attr('href');
        window.location.href = url;
    }, 1500);
    
}

function paymentMethodUrl(el){
    var url = $(el).attr('href');
    window.location.href = url +'?order=' + globalKey.orderRandomKey;
}


function backToPaymentMethods(el){
    var amount = $('.totalBasket').text();
    var paymentFee = $(el).attr('data-paymentFee');
    if(isNumber(paymentFee)){
        paymentFee = parseFloat(paymentFee);
        var total = parseFloat(amount) - paymentFee;
        $('.totalBasket').text(total.toFixed(2));
    }
    
}

function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); } 