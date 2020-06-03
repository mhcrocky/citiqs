'use strict';
function returnUserIds() {
    return ['username', 'address', 'addressa', 'zipcode', 'city', 'country'];
}

function toogleIds(ids, display) {
    let idsLength = ids.length;
    let i;    
    for (i = 0; i < idsLength; i++) {
        globalVariables.doc.getElementById(ids[i]).style.display = display;
        if (display === 'block') {
            globalVariables.doc.getElementById(ids[i]).disabled = false;
            if (ids[i] !== 'addressa') {
                globalVariables.doc.getElementById(ids[i]).required = true;
            }
        } else {
            globalVariables.doc.getElementById(ids[i]).disabled = true;
            globalVariables.doc.getElementById(ids[i]).required = false;
        }
    }
}

function checkEmail(element) {
    let displayCss;
    if (element.value) {
        let ajax = globalVariables.ajax + 'users/';
        $.get(ajax + encodeURIComponent(element.value), function(data) {
            let result = JSON.parse(data);
            displayCss = result.username ? 'block' : 'none';
            toogleIds(returnUserIds(), displayCss);
            return;
        });
    }
    toogleIds(returnUserIds(), 'none');
    return;
}