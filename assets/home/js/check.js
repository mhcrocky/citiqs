'use strict';
function myFunctionBrand(str) {
    $(document).ready(function() {
        let ajax = getAjaxUsers()
        $.get(ajax + encodeURIComponent(str), function(data) {
            var result = JSON.parse(data);

            $('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
            if (result.username == true) {
                document.getElementById("brandUnkownAddressText").style.display = "block";
                document.getElementById("brandname").style.display = "block";
                document.getElementById("brandaddress").style.display = "block";
                document.getElementById("brandaddressa").style.display = "block";
                document.getElementById("brandzipcode").style.display = "block";
                document.getElementById("brandcity").style.display = "block";
                document.getElementById("brandzip").style.display = "block";
                document.getElementById("brandcountry").style.display = "block";
                document.getElementById("brandcountry1").style.display = "block";
            }
        });
    });
}

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
    let displayCss;
    if (element.value) {
        let ajax = globalVariables.ajax + 'users/'        
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

function uploadImageAndGetCode(element) {
    let form = element.form;
    let url = globalVariables.ajax + 'labelImageUploadAndGetCode';
    sendFormAjaxRequest(form, url, 'uploadImageAndGetCode', changeHtmlForCode, ['inputManualCode', 'h2Code', 'imageResponseDatabaseName', 'imageResponseFullName', 'labelImg']);
    return false;
}

function changeHtmlForCode(inputField, element, imageDatabaseName, imageFullName, labelImg, data) {
    $("#" + element).html(data.code);
    let inputCode = globalVariables.doc.getElementById(inputField);
    let inputImageDatabaseName = globalVariables.doc.getElementById(imageDatabaseName);
    let inputImageFullName = globalVariables.doc.getElementById(imageFullName);
    let image = globalVariables.doc.getElementById(labelImg);

    inputCode.value = data.code;    
    inputCode.setAttribute('type', 'hidden');
    inputImageDatabaseName.value = data.imageDatabaseName;
    inputImageDatabaseName.setAttribute('type', 'hidden');
    inputImageFullName.value = data.imageFullName;
    inputImageFullName.setAttribute('type', 'hidden');
    image.src = globalVariables.baseUrl + 'uploads/LabelImages/' + data.imageFullName;
}

function triger(inputId) {
    let input = globalVariables.doc.getElementById(inputId);
    input.onchange = function() {
        uploadImageAndGetCode(input);
    }
}

function hideElement(element, elementToHideId) {    
    let elementToHide = globalVariables.doc.getElementById(elementToHideId);
    let displayCss = element.value.trim() ? 'none' : 'block';
    elementToHide.style.display = displayCss;    
}