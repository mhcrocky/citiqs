document.addEventListener('DOMContentLoaded', function() {
    new Splide('#splide', {
        type: 'slide',
        perPage: 3,
        focus: 'center',
        autoplay: false,
        interval: 8000,
        flickMaxPages: 3,
        updateOnMove: true,
        pagination: false,
        padding: '10%',
        throttle: 300,
        breakpoints: {
            1440: {
                perPage: 1,
                padding: '30%'
            }
        }
    }).mount();
    
});

(function() {
    if (typeof globalTime === 'undefined' && $('#shop').length == 0) {
        window.location.href = globalVariables.baseUrl + "booking_reservations/clear_reservations?order=" + globalKey.orderRandomKey;
    } else if(typeof globalTime !== 'undefined' && dayjs(globalTime.time) < dayjs()){
        window.location.href = globalVariables.baseUrl + "booking_reservations/clear_reservations?order=" + globalKey.orderRandomKey;
    }
    
    if($('.ticket_item').length > 0){
        $('#payForm').show();
    }

}());


$(document).ready(function(){
    $('body').show();
    if (typeof globalTime !== 'undefined') {
        let time = globalTime.time;
        var countDownDate = moment(time);
        var now = moment();
        var distance = countDownDate - now;
        countDownTimer(distance);
    }
    if ($('#first_element').val()) {
        let id = $('#first_element').val();
        let date = $('#first_element').attr('data-date');
        getSpotsView(id, date, true);
    }
    setInterval(() => {
        var CurrentDate = moment().format();
        $(".current_time").val(CurrentDate);

    }, 1000);

    $(document).on('click', '.quantity-up', function() {
        let id = $(this).data("embellishmentid");
        let price = $("#price_"+id).val();
        let ticketFee = $("#price_"+id).attr('data-ticketfee');
        addTicket(id,  50, price, ticketFee, 'totalBasket');
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
    $('#pay').click();
    return ;
}

function getSpotsView(agendaId, date, first = false) {
    let isAjax = true;
    $('div.bg-light').removeClass('bg-light').addClass('bg-white');
    $("#event_" + agendaId).addClass('bg-light').removeClass('bg-white');
    let img_src = $('#background_img_' + agendaId).val();
    $.post(globalVariables.baseUrl + "booking_reservations/spots/" + date + "/" + agendaId, {
        isAjax: isAjax,
        order: globalKey.orderRandomKey
    }, function(data) {
        $("#spots").empty();
        $("#main-content").after(data);
        if(img_src == ''){
            $("#background-image").attr("src", globalVariables.baseUrl + "assets/images/events/default_background.webp");
        } else {
            $("#background-image").attr("src", globalVariables.baseUrl + "assets/home/images/" + img_src);
        }
        $("#spots").fadeIn("slow", function() {
            if (first) {
                return;
            }

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#spots").offset().top
            }, 1000);
        });
    });


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
                window.location.href = globalVariables.baseUrl + "booking_reservations/clear_reservations?order=" + globalKey.orderRandomKey;
            }, 500);
        }
        if (distance < 0) {
            clearInterval(x);
            window.location.href = globalVariables.baseUrl + "booking_reservations/clear_reservations?order=" + globalKey.orderRandomKey;
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
    let totalBasket = $(".totalBasket").text();
    quantityValue = parseInt(quantityValue);
    totalBasket = parseFloat(totalBasket);
    price = parseFloat(price);
    ticketFee = parseFloat(ticketFee);
    totalBasket = totalBasket - quantityValue*(price + ticketFee);
    $(".ticketQuantityValue_" + id).val(0);
    let current_time = $('#exp_time').val();
    let list_items = ($('.ticket_item').length > 1) ? 1 :0;

    let data = {
        id: id,
        current_time: current_time,
        totalBasket: totalBasket,
        list_items: list_items
    }
    $.post(globalVariables.baseUrl + "booking_reservations/delete_reservation", data, function(data){
		$( ".ticket_"+id ).fadeOut( "slow", function() {
            $( ".ticket_"+id ).remove();
            $(".totalBasket").text(totalBasket.toFixed(2));
            $('#totalBasket').text(totalBasket.toFixed(2));
            if($('.ticket_item').length < 1) {
                $('#payForm').hide();
                $('.timer').empty();
            }
        });
	})
}


function clearTotal(el, price, totalClass){
	var quantity = $(el).val();
	var totalBasket = $("."+totalClass).text();
	totalBasket = parseInt(totalBasket);
	quantity = parseInt(quantity);
	price = parseInt(price);
	totalBasket = totalBasket - quantity*price;
	return $("."+totalClass).text(totalBasket.toFixed(2));
}

function removeTicket(id, agendaId, spotId, price, reservationFee) {
    $('#payForm').show();
    var quantityValue = $(".ticketQuantityValue_" + id).val();
    var totalBasket = $(".totalBasket").text();
    var fromtime = $(".ticketQuantityValue_" + id).attr('data-fromtime');
    var totime = $(".ticketQuantityValue_" + id).attr('data-totime');
    var numberofpersons = $(".ticketQuantityValue_" + id).attr('data-numberofpersons');
    totalBasket = parseFloat(totalBasket);
    quantityValue = parseInt(quantityValue);
    price = parseFloat(price);
    reservationFee = parseFloat(reservationFee);
    if(quantityValue == 1){
        return;
    }
    if (quantityValue == 0) {
        return;
    }
    quantityValue--;
    var oldTotalBasket = totalBasket;
    totalBasket = parseFloat(totalBasket) - parseFloat(price) - parseFloat(reservationFee);
    
    $(".ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    $(".totalBasket").text(parseFloat(totalBasket).toFixed(2));
    let current_time = $(".current_time").val();

    let data = {
        agendaId: agendaId,
        spotId: spotId,
        timeslotId: id,
        price: price,
        reservationFee: reservationFee.toFixed(2),
        quantity: quantityValue,
        fromtime: encodeURI(fromtime),
        totime: encodeURI(totime),
        numberofpersons: numberofpersons,
        time: current_time,
        order: globalKey.orderRandomKey,
        remove: 1
    };
    $.post(globalVariables.baseUrl + "booking_reservations/add_to_basket", data, function(data){
        if(data == 'error'){
            iziToast.error({
                title: '',
                message: 'You have reached the maximum number of reservations!',
                position: 'topRight'
            });
            $(".totalBasket").text(oldTotalBasket.toFixed(2));
            return ;
        }
        data = JSON.parse(data);
        //console.log(data);
        var fromtime = data['fromtime'];
        var totime = data['totime'];
        var numberofpersons = data['numberofpersons'];
        var first_booking = data['first_booking'];
        var eventDate = data['eventDate'];
        let html = '<div class="menu-list__item ticket_item ticket_'+id+'">'+
        '<div class="menu-list__name">'+
            '<b class="menu-list__title">Description</b>'+
            '<div>'+
                '<p class="menu-list__ingredients descript_'+id+'"><i class="fa fa-calendar" aria-hidden="true"></i> '+eventDate+'&nbsp - &nbsp <i class="fa fa-clock-o" aria-hidden="true"></i> '+ fromtime +' - '+totime+'</p>'+
            '</div>'+
        '</div>'+
        '<div class="menu-list__left-col ml-auto">'+
            '<div class="menu-list__price mx-auto">'+
                '<b class="menu-list__price--discount mx-auto">'+price.toFixed(2)+'€  ('+reservationFee.toFixed(2)+'€)</b>'+
            '</div>'+
            '<div class="quantity-section mx-auto mb-2">'+
                '<button type="button" class="quantity-button" onclick="removeTicket(\''+id+'\', \''+agendaId+'\', \''+spotId+'\', \''+price+'\', \''+reservationFee+'\')">-</button>'+
                '<input type="text" value="'+quantityValue+'" placeholder="0" onfocus="clearTotal(this, \''+price+'\', \'totalBasket\')" onblur="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" onchange="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" oninput="absVal(this);"' +
                +' data-fromtime="'+fromtime+'" data-totime="'+totime+'" data-numberofpersons="'+numberofpersons+'" disabled="" class="quantity-input ticketQuantityValue_'+id+'">'+
                '<button type="button" class="quantity-button"  onclick="addTicket(\''+id+'\', \''+agendaId+'\', \''+spotId+'\', \''+price+'\', \''+reservationFee+'\')" >+</button>'+
            '</div>'+
            '<b class="menu-list__type mx-auto">'+
                '<button onclick="deleteTicket(\''+id+'\',\''+price+'\', \''+reservationFee.toFixed(2)+'\')" type="button" class="btn btn-danger bg-light color-secondary">'+
                    '<i class="fa fa-trash mr-2" aria-hidden="true"></i>'+
                    'Delete</button>'+
            '</b>'+
        '</div>'+
        '</div>';

        


         if($('.ticket_'+id).length > 0){
            return $('.ticket_'+id).replaceWith(html);
        }

        if(first_booking == 1){
            countDownTimer(600000);
        }
         $('#checkout-list').prepend(html);
    });
    
}

function addTicket(id, agendaId, spotId, price, reservationFee, limit=2) {
    $('#payForm').show();
    var quantityValue = $(".ticketQuantityValue_" + id).val();
    var oldQuantityValue = quantityValue;
    var totalBasket = $(".totalBasket").text();
    var fromtime = $(".ticketQuantityValue_" + id).attr('data-fromtime');
    var totime = $(".ticketQuantityValue_" + id).attr('data-totime');
    var numberofpersons = $(".ticketQuantityValue_" + id).attr('data-numberofpersons');
    totalBasket = parseFloat(totalBasket);
    quantityValue = parseInt(quantityValue);
    price = parseFloat(price);
    reservationFee = parseFloat(reservationFee);
    limit = parseInt(limit);
    if (quantityValue == limit) {
        return;
    }
    quantityValue++;
    var oldTotalBasket = totalBasket;
    totalBasket = parseFloat(totalBasket) + parseFloat(price) + parseFloat(reservationFee);
    
    $(".ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    $(".totalBasket").text(parseFloat(totalBasket).toFixed(2));
    let current_time = $(".current_time").val();

    let data = {
        agendaId: agendaId,
        spotId: spotId,
        timeslotId: id,
        price: price,
        reservationFee: reservationFee.toFixed(2),
        quantity: quantityValue,
        fromtime: encodeURI(fromtime),
        totime: encodeURI(totime),
        numberofpersons: numberofpersons,
        time: current_time,
        order: globalKey.orderRandomKey
    };
    $.post(globalVariables.baseUrl + "booking_reservations/add_to_basket", data, function(data){
        if(data == 'error'){
            $(".ticketQuantityValue_" + id).val(oldQuantityValue);
            iziToast.error({
                title: '',
                message: 'You have reached the maximum number of reservations!',
                position: 'topRight'
            });
            $(".totalBasket").text(oldTotalBasket.toFixed(2));
            return ;
        }
        data = JSON.parse(data);
        //console.log(data);
        var fromtime = data['fromtime'];
        var totime = data['totime'];
        var first_booking = data['first_booking'];
        var eventDate = data['eventDate'];
        let html = '<div class="menu-list__item ticket_item ticket_'+id+'">'+
        '<div class="menu-list__name">'+
            '<b class="menu-list__title">Description</b>'+
            '<div>'+
                '<p class="menu-list__ingredients descript_'+id+'"><i class="fa fa-calendar" aria-hidden="true"></i> '+eventDate+'&nbsp - &nbsp <i class="fa fa-clock-o" aria-hidden="true"></i> '+ fromtime +' - '+totime+'</p>'+
            '</div>'+
        '</div>'+
        '<div class="menu-list__left-col ml-auto">'+
            '<div class="menu-list__price mx-auto">'+
                '<b class="menu-list__price--discount mx-auto">'+price.toFixed(2)+'€  ('+reservationFee.toFixed(2)+'€)</b>'+
            '</div>'+
            '<div class="quantity-section mx-auto mb-2">'+
                '<button type="button" class="quantity-button" onclick="removeTicket(\''+id+'\', \''+agendaId+'\', \''+spotId+'\', \''+price+'\', \''+reservationFee+'\')">-</button>'+
                '<input type="text" value="'+quantityValue+'" placeholder="0" onfocus="clearTotal(this, \''+price+'\', \'totalBasket\')" onblur="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" onchange="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" oninput="absVal(this);" disabled="" class="quantity-input ticketQuantityValue_'+id+'">'+
                '<button type="button" class="quantity-button"  onclick="addTicket(\''+id+'\', \''+agendaId+'\', \''+spotId+'\', \''+price+'\', \''+reservationFee+'\')" >+</button>'+
            '</div>'+
            '<b class="menu-list__type mx-auto">'+
                '<button onclick="deleteTicket(\''+id+'\',\''+price+'\', \''+reservationFee.toFixed(2)+'\')" type="button" class="btn btn-danger bg-light color-secondary">'+
                    '<i class="fa fa-trash mr-2" aria-hidden="true"></i>'+
                    'Delete</button>'+
            '</b>'+
        '</div>'+
        '</div>'+
        '<input type="hidden" id="price_'+id+'" value="'+price+'" data-ticketfee="'+reservationFee+'">';
        


         if($('.ticket_'+id).length > 0){
            return $('.ticket_'+id).replaceWith(html);
        }

        if(first_booking == 1){
            countDownTimer(600000);
        }
         $('#checkout-list').prepend(html);
    });
    
}

function addMultiReservations(id, inputId, agendaId, spotId, price, reservationFee, fromtime, totime, limit=2) {
    $('#payForm').show();
    var quantityValue = $(".ticketQuantityValue_" + inputId).val();

    var totalBasket = $(".totalBasket").text();
    totalBasket = parseFloat(totalBasket);
    quantityValue = parseInt(quantityValue);
    price = parseFloat(price);
    reservationFee = parseFloat(reservationFee);
    limit = parseInt(limit);
    if (quantityValue == limit) {
        return;
    }
    quantityValue++;
    var oldTotalBasket = totalBasket;
    totalBasket = totalBasket + price + reservationFee;
    
    $(".ticketQuantityValue_" + inputId).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    $(".totalBasket").text(totalBasket.toFixed(2));
    let current_time = $(".current_time").val();

    let data = {
        agendaId: agendaId,
        spotId: spotId,
        inputId: inputId,
        timeslotId: id,
        price: price,
        reservationFee: reservationFee.toFixed(2),
        fromtime: fromtime,
        totime: totime,
        quantity: quantityValue,
        time: current_time,
        order: globalKey.orderRandomKey
    };
    $.post(globalVariables.baseUrl + "booking_reservations/add_to_basket", data, function(data){
        if(data == 'error'){
            iziToast.error({
                title: '',
                message: 'You have reached the maximum number of reservations!',
                position: 'topRight'
            });
            $(".totalBasket").text(oldTotalBasket.toFixed(2));
            return ;
        }
        data = JSON.parse(data);
        //console.log(data);
        var fromtime = data['fromtime'];
        var totime = data['totime'];
        var first_booking = data['first_booking'];
        var eventDate = data['eventDate'];
        let html = '<div class="menu-list__item ticket_item ticket_'+id+'">'+
        '<div class="menu-list__name">'+
            '<b class="menu-list__title">Description</b>'+
            '<div>'+
                '<p class="menu-list__ingredients descript_'+id+'"><i class="fa fa-calendar" aria-hidden="true"></i> '+eventDate+'&nbsp - &nbsp <i class="fa fa-clock-o" aria-hidden="true"></i> '+ fromtime +' - '+totime+'</p>'+
            '</div>'+
        '</div>'+
        '<div class="menu-list__left-col ml-auto">'+
            '<div class="menu-list__price mx-auto">'+
                '<b class="menu-list__price--discount mx-auto">'+price.toFixed(2)+'€  ('+reservationFee.toFixed(2)+'€)</b>'+
            '</div>'+
            '<div class="quantity-section mx-auto mb-2">'+
                '<button type="button" class="quantity-button" onclick="removeTicket(\''+id+'\', \''+agendaId+'\', \''+spotId+'\', \''+price+'\', \''+reservationFee+'\')">-</button>'+
                '<input type="text" value="'+quantityValue+'" placeholder="0" onfocus="clearTotal(this, \''+price+'\', \'totalBasket\')" onblur="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" onchange="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" oninput="absVal(this);" disabled="" class="quantity-input ticketQuantityValue_'+id+'">'+
                '<button type="button" class="quantity-button"  onclick="addTicket(\''+id+'\', \''+agendaId+'\', \''+spotId+'\', \''+price+'\', \''+reservationFee+'\')" >+</button>'+
            '</div>'+
            '<b class="menu-list__type mx-auto">'+
                '<button onclick="deleteTicket(\''+id+'\',\''+price+'\', \''+reservationFee.toFixed(2)+'\')" type="button" class="btn btn-danger bg-light color-secondary">'+
                    '<i class="fa fa-trash mr-2" aria-hidden="true"></i>'+
                    'Delete</button>'+
            '</b>'+
        '</div>'+
        '</div>'+
        '<input type="hidden" id="price_'+id+'" value="'+price+'" data-ticketfee="'+reservationFee+'">';
        


         if($('.ticket_'+id).length > 0){
            return $('.ticket_'+id).replaceWith(html);
        }

        if(first_booking == 1){
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
    var totalBasket = $("."+totalClass).text();
    quantityValue = parseInt(quantityValue);
    totalBasket = parseFloat(totalBasket);
    price = parseFloat(price);
    ticketfee = parseFloat(ticketfee);
    totalBasket = totalBasket + quantityValue*(price + ticketFee);
    $(el).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    return $("."+totalClass).text(totalBasket.toFixed(2));
}
