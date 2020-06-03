function returnUserIds() {
    return ['UnkownAddressText', 'username', 'address', 'addressa', 'zipcode', 'city', 'country', 'country1'];
}
function toogleIds(ids, display) {
    let idsLength = ids.length;
    let i;    
    for (i = 0; i < idsLength; i++) {
        globalVariables.doc.getElementById(ids[i]).style.display = display;
        if (display === 'block') {
            globalVariables.doc.getElementById(ids[i]).disabled = false;
            globalVariables.doc.getElementById(ids[i]).required = true;
        } else {
            globalVariables.doc.getElementById(ids[i]).disabled = true;
            globalVariables.doc.getElementById(ids[i]).required = false;
        }
    }
}
function checkElementsValues(element, checkId, message) {
    let checkValue = globalVariables.doc.getElementById(checkId).value;    
    if (element.value !== checkValue) {
        alertify.alert(message);
    }
}
function checkEmail(element) {
    if (element.value) {
        let ajax = globalVariables.ajax + 'users/'        
        $.get(ajax + encodeURIComponent(element.value), function(data) {
            var result = JSON.parse(data);
            if (result.username) {
                toogleIds(returnUserIds(), 'block');
            }
        });
    }
}

function displayButton(element, checkId, buttonId) {
    let checkValue = globalVariables.doc.getElementById(checkId).value;
    if (element.value === checkValue) {
        globalVariables.doc.getElementById(buttonId).disabled = false;
    } else {
        globalVariables.doc.getElementById(buttonId).disabled = true;
    }
}
function checkValuesAndSubmit(formId, firstValue, secondValue) {
    let value = globalVariables.doc.getElementById(firstValue).value;
    let verifyValue = globalVariables.doc.getElementById(secondValue).value;
    if (value && value === verifyValue) {
        let form = globalVariables.doc.getElementById(formId);
        form.submit();
    } else {
        alertify.alert('Emails do not match');
    }
}

function playThisVideo(element) {
    removeShowFromElements('videos')
    let videoDiv = element.parentElement.previousElementSibling;
    let video = videoDiv.firstElementChild.firstElementChild;
    $(videoDiv).toggleClass('show');
    if (videoDiv.classList.contains('show')) {
        video.src += "?autoplay=1";
    } else {
        video.src += "?autoplay";
    }
}

function removeShowFromElements(collection) {
    let elements = document.getElementsByClassName(collection);
    let i;
    let elementsLength = elements.length;
    for (i = 0; i < elementsLength; i++) {
        elements[i].classList.remove('show');
    }
}