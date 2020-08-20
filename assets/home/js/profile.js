'use strict';
function showDay(element, day) {
    let inputTimes = document.getElementsByClassName(day);
    let inputTimesLength = inputTimes.length;
    let i;
    let disableElement;


    if (element.checked) {
        document.getElementById(day).style.display = "initial";
        disableElement = false;
    } else {
        document.getElementById(day).style.display = "none";
        disableElement = true;
    }

    for (i = 0; i < inputTimesLength; i++) {
        inputTimes[i].disabled = disableElement;
    }
}

function addTimePeriod(timeDiv, day) {
    let element = '';
    element +=  '<div>';
    element +=      '<label style="color:#000">From: ';
    element +=          '<input type="time" class="day_' + day + '" name="' + day + '[timeFrom][]" />';
    element +=      '</label>';
    element +=      '<label style="color:#000">To: ';
    element +=          '<input type="time" class="day_' + day + '"  name="' + day + '[timeTo][]" />';
    element +=      '</label>';
    element +=      '<span style="color:#000" class="fa-stack fa-2x" onclick="removeParent(this)">';
    element +=          '<i class="fa fa-times"></i>';
    element +=      '</span>';
    element +=  '</div>';
    $( "#" + timeDiv).append(element);
}

function redirectToInovice(action, valueId, message) {
    let value = document.getElementById(valueId).value;
    if (value) {
        let href = action + document.getElementById(valueId).value;
        location.replace(href);
    } else {
        alertify.error(message);
    }
}

function toogleVolumePeriod(element) {    
    let elememntToShowId = element.value
    let ids = element.dataset;
    let id;
    for (id in ids) {
        if (ids[id] !== elememntToShowId) {
            document.getElementById(ids[id]).style.display = 'none';
        }
    }
    if (elememntToShowId) {
        document.getElementById(elememntToShowId).style.display = 'block';
    }
    
}

$(document).ready(function() {
    $('ul.nav li').click(function(e) {
        $('#error').text("");
        $('#error').removeClass();
        $('#success').text("");
        $('#success').removeClass();
        $('#nomatch').text("");
        $('#nomatch').removeClass();
        $('#validationerrors').text("");
        $('#validationerrors').removeClass();
    });
});