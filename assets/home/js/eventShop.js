(function() {
    if (typeof globalTime === 'undefined' && $('#shop').length == 0) {
        window.location.href = globalVariables.baseUrl + "booking_events/clear_tickets";
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
        getTicketsView(id, true);
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

function getTicketsView(eventId, first = false) {
    let isAjax = true;
    $('div.bg-light').removeClass('bg-light').addClass('bg-white');
    $("#event_" + eventId).addClass('bg-light').removeClass('bg-white');
    $.post(globalVariables.baseUrl + "events/tickets/" + eventId, {
        isAjax: isAjax
    }, function(data) {
        $("#my-form").remove();
        $("#main-content").after(data);
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

function countDownTimer(distance){

    var x = setInterval(function() {
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    $('#exp_time').val(distance);
    if($('.ticket_item').length > 0) {
        $(".timer").text("Expiration time: " + addZero(minutes) + ":" + addZero(seconds) + "");
        if (minutes == 0 && seconds == 0) {
            setTimeout(() => {
                window.location.href = globalVariables.baseUrl + "booking_events/clear_tickets";
            }, 500);
        }
        if (distance < 0) {
            clearInterval(x);
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
    totalBasket = parseFloatNum(totalBasket);
    price = parseFloatNum(price);
    ticketFee = parseFloatNum(ticketFee);
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
    $.post(globalVariables.baseUrl + "booking_events/delete_ticket", data, function(data){
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
	var totalBasket = $("."+totalClass).html();
    
	totalBasket = parseInt(totalBasket);
	quantity = parseInt(quantity);
	price = parseInt(price);
	totalBasket = Math.round((totalBasket - quantity*price) * 1e12) / 1e12;
	return $("."+totalClass).text(totalBasket.toFixed(2));
}

function removeTicket(id, price, ticketFee, totalClass) {
    var quantityValue = $(".ticketQuantityValue_" + id).val();
    if(quantityValue < 1){ return; }
    if(quantityValue < 2){
        $(".ticketQuantityValue_" + id).val(0);
        deleteTicket(id, price, ticketFee);
        return;
    }
    var totalBasket = $("."+totalClass).html();
    quantityValue = parseInt(quantityValue);
    totalBasket = parseFloatNum(totalBasket);
    price = parseFloatNum(price);
    ticketFee = parseFloatNum(ticketFee);
    var priceVal = price;
    
    quantityValue--;
    totalBasket = Math.round((totalBasket - price - ticketFee) * 1e12) / 1e12;
    $(".ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    $("."+totalClass).text(totalBasket.toFixed(2));
    let current_time = $(".current_time").val();
    
    let descript = $(".descript_"+id).html();
    let ticket_available = $("#ticketQuantityValue_" + id).attr('data-available');
    let data = {
        id: id,
        quantity: quantityValue,
        price: price.toFixed(2),
        ticketFee: ticketFee.toFixed(2),
        descript:  descript,
        time: current_time,
        ticket_available: ticket_available

    }

    $.post(globalVariables.baseUrl + "booking_events/add_to_basket", data, function(data){
        data = JSON.parse(data);
        var descript_data = data['descript'];
        var price_data = data['price'];
        var ticketFee_data = data['ticketFee'];
        var first_ticket = data['first_ticket'];
        var eventName = data['eventName'];
        let html = '<div class="menu-list__item ticket_item ticket_'+id+'">'+
        '<div class="menu-list__name">'+
            '<b class="menu-list__title">Description</b>'+
            '<div>'+
                '<p class="menu-list__ingredients descript_'+id+'">'+eventName+' - '+descript_data+'</p>'+
            '</div>'+
        '</div>'+
        '<div class="menu-list__left-col ml-auto">'+
            '<div class="menu-list__price mx-auto">'+
                '<b class="menu-list__price--discount mx-auto">'+price.toFixed(2)+'€ ('+ticketFee.toFixed(2)+'€)</b>'+
            '</div>'+
            '<div class="quantity-section mx-auto mb-2">'+
                '<button type="button" class="quantity-button quantity-down" data-embellishmentid="'+id+'">-</button>'+
                '<input type="text" value="'+quantityValue+'" placeholder="0" onfocus="clearTotal(this, \''+price+'\', \''+ticketFee+'\', \'totalBasket\')" onblur="ticketQuantity(this,\''+id+'\', \''+price+'\', \''+ticketFee+'\', \'totalBasket\')" onchange="ticketQuantity(this,\''+id+'\', \''+price+'\', \''+ticketFee+'\', \'totalBasket\')" oninput="absVal(this);" disabled="" class="quantity-input ticketQuantityValue_'+id+'">'+
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

function addTicket(id, limit, price, ticketfee, totalClass) {
    $('#payForm').show();
    var quantityValue = $(".ticketQuantityValue_" + id).val();
    var totalBasket = $("."+totalClass).html();
    quantityValue = parseInt(quantityValue);
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
   
    totalBasket = Math.round((totalBasket + price + ticketfee) * 1e12) / 1e12;
    
    $(".ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    $("."+totalClass).text(totalBasket.toFixed(2));
    
    
    
    let current_time = $(".current_time").val();
    let descript = $(".descript_"+id).first().html();
    let ticket_available = $("#ticketQuantityValue_" + id).attr('data-available');
    let data = {
        id: id,
        quantity: quantityValue,
        price: price.toFixed(2),
        ticketFee: ticketfee.toFixed(2),
        descript:  descript,
        time: current_time,
        ticket_available: ticket_available
    };
    $.post(globalVariables.baseUrl + "booking_events/add_to_basket", data, function(data){
        
        if(data == 'error'){
            $(".ticketQuantityValue_" + id).val(limit);
            iziToast.error({
                title: 'SOLD OUT!',
                message: '',
                position: 'topRight'
            });
            return ;
        }

        data = JSON.parse(data);
        var descript_data = data['descript'];
        var price_data = data['price'];
        var ticketFee_data = data['ticketFee'];
        var first_ticket = data['first_ticket'];
        var eventName = data['eventName'];
        let html = '<div class="menu-list__item ticket_item ticket_'+id+'">'+
        '<div class="menu-list__name">'+
            '<b class="menu-list__title">Description</b>'+
            '<div>'+
                '<p class="menu-list__ingredients descript_'+id+'">'+eventName+' - '+descript_data+'</p>'+
            '</div>'+
        '</div>'+
        '<div class="menu-list__left-col ml-auto">'+
            '<div class="menu-list__price mx-auto">'+
                '<b class="menu-list__price--discount mx-auto">'+price.toFixed(2)+'€  ('+ticketfee.toFixed(2)+'€)</b>'+
            '</div>'+
            '<div class="quantity-section mx-auto mb-2">'+
                '<button type="button" class="quantity-button quantity-down" data-embellishmentid="'+id+'">-</button>'+
                '<input type="text" value="'+quantityValue+'" placeholder="0" onfocus="clearTotal(this, \''+price+'\', \'totalBasket\')" onblur="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" onchange="ticketQuantity(this,\''+id+'\', \''+price+'\', \'totalBasket\')" oninput="absVal(this);" disabled="" class="quantity-input ticketQuantityValue_'+id+'">'+
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
    var totalBasket = $("."+totalClass).html();
    quantityValue = parseInt(quantityValue);
    totalBasket = parseFloatNum(totalBasket);
    price = parseFloatNum(price);
    ticketfee = parseFloatNum(ticketfee);
    totalBasket = Math.round((totalBasket + quantityValue*(price + ticketFee)) * 1e12) / 1e12;
    $(el).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    return $("."+totalClass).text(totalBasket.toFixed(2));
}


function parseFloatNum(num){
    if(!$.isNumeric( num )){
        return 0;
    }

    return parseFloat(num);
    
}