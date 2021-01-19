var countDownDate = moment(globalTime.time);


var x = setInterval(function() {

    var now = moment();

    var distance = countDownDate - now;

    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("timer").innerHTML =
        "Expiration time: " + addZero(minutes) + ":" + addZero(seconds) + "";
    if (minutes == 0 && seconds == 0) {
        window.location.href = globalVariables.baseUrl + "events/your_tickets";
    }
    $('.limiter').css('visibility', 'visible');

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "EXPIRED";
    }
}, 1000);

function addZero(num) {
    let i = parseInt(num);
    if (i < 10) {
        num = "0" + num;
        return num;
    }
    return num;
}