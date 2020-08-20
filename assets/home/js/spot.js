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
    element +=      '<label>From: ';
    element +=          '<input type="time" class="day_' + day + '" name="' + day + '[timeFrom][]" />';
    element +=      '</label>';
    element +=      '<label>To: ';
    element +=          '<input type="time" class="' + timeDiv + '"  name="' + day + '[timeTo][]" />';
    element +=      '</label>';
    element +=      '<span class="fa-stack fa-2x" onclick="removeParent(this)">';
    element +=          '<i class="fa fa-times"></i>';
    element +=      '</span>';
    element +=  '</div>';
    $( "#" + timeDiv).append(element);
}
