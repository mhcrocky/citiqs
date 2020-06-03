'use strict';
function redirectToInovice(action, valueId, message) {
    let value = document.getElementById(valueId).value;
    console.dir(value);
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