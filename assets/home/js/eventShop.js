$(document).ready(function(){
    if (typeof globalTime !== 'undefined') {
        countDownTimer();
      }
    if ($('#first_element').val()) {
        let id = $('#first_element').val();
        getTicketsView(id, true);
    }
    setInterval(() => {
        var CurrentDate = moment().format();
        $(".current_time").val(CurrentDate);

    }, 1000);

});

$("#next").on('click', function(e) {
    e.preventDefault();
    let total = $(".totalPrice").text();
    if (total != '00.00') {
        $("#my-form").submit();
    }
    return;
});

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

function countDownTimer(){
    var countDownDate = moment(globalTime.time);
    var x = setInterval(function() {
    var now = moment();
    var distance = countDownDate - now;
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    $('.exp_sec').val(distance);
    $(".timer").text("Expiration time: " + addZero(minutes) + ":" + addZero(seconds) + "");
    if (minutes == 0 && seconds == 0) {
        setTimeout(() => {
            window.location.href = globalVariables.baseUrl + "events/your_tickets";
        }, 3000);
    }
    $('.limiter').css('visibility', 'visible');

    if (distance < 0) {
        clearInterval(x);
        $(".timer").text("EXPIRED");
    }
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

function deleteTicket(id,price) {
    let quantityValue = $("#ticketQuantityValue_" + id).val();
    let totalPrice = $(".totalBasket").text();
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    totalPrice = totalPrice - price;
    let current_time = $('.exp_sec').val();
    $.post(globalVariables.baseUrl + "booking_events/delete_ticket", {id: id,current_time: current_time}, function(data){
		$( ".ticket_"+id ).fadeOut( "slow", function() {
            $( ".ticket_"+id ).remove();
            $(".totalBasket").text(totalPrice.toFixed(2));
            if(!data){
                window.location.href = globalVariables.baseUrl + "events/your_tickets";
            }
        });
	})
}


function clearTotal(el, price, totalClass){
	var quantity = $(el).val();
	var totalPrice = $("."+totalClass).text();
	totalPrice = parseInt(totalPrice);
	quantity = parseInt(quantity);
	price = parseInt(price);
	totalPrice = totalPrice - quantity*price;
	return $("."+totalClass).text(totalPrice.toFixed(2));
}

function removeTicket(id, price, totalClass) {
    var quantityValue = $("#ticketQuantityValue_" + id).val();
    var totalPrice = $("."+totalClass).text();
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    if (quantityValue == 0) {
        return;
    }
    quantityValue--;
    totalPrice = totalPrice - price;
    $("#ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    return $("."+totalClass).text(totalPrice.toFixed(2));
}

function addTicket(id, limit, price, totalClass) {
    var quantityValue = $("#ticketQuantityValue_" + id).val();
    var totalPrice = $("."+totalClass).text();
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    limit = parseInt(limit);
    if (quantityValue == limit) {
        return;
    }
    quantityValue++;
    totalPrice = totalPrice + price;
    $("#ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    return $("."+totalClass).text(totalPrice.toFixed(2));
}

function ticketQuantity(el, id, price, totalClass) {
    var quantityValue = $(el).val();
    var totalPrice = $("."+totalClass).text();
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    totalPrice = totalPrice + price*quantityValue;
    $(el).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    return $("."+totalClass).text(totalPrice.toFixed(2));
}
