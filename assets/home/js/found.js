'use strict';
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
                console.dir(returnUserIds());
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

// function myFunction(str, url) {
//     $(document).ready(function() {
//         $.get(url + encodeURIComponent(str), function(data) {
//             var result = JSON.parse(data);
//             $('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
//             if (result.username == true) {
//                 document.getElementById("UnkownAddressText").style.display = "block";
//                 document.getElementById("username").style.display = "block";
//                 document.getElementById("address").style.display = "block";
//                 document.getElementById("addressa").style.display = "block";
//                 document.getElementById("zipcode").style.display = "block";
//                 document.getElementById("city").style.display = "block";
//                 // document.getElementById("country").style.display = "block";
//                 document.getElementById("country1").style.display = "block";
//                 document.getElementById("label1").style.display = "block";
//                 document.getElementById("label2").style.display = "block";
//                 document.getElementById("label3").style.display = "block";
//                 document.getElementById("label4").style.display = "block";
//                 document.getElementById("label5").style.display = "block";
//                 document.getElementById("label6").style.display = "block";
//             }
//         });
//     });
// }

function getVideoLink(e){
    frame.src = e.getAttribute('data-link');
    console.log('frame');
    frame.play();
}


var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
            panel.style.border = 'none';
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
            /* panel.style.border = '1px solid #ffffff4a';
                panel.style.borderTop = 'none';
                panel.borderTopLeftRadius = 0 + 'px';
                panel.borderTopRightRadius = 0 + 'px';*/
        }
    });
}
// TO DO id frame does not exist in html
var frame = document.getElementById('frame');
if (frame) {
    var frame_heigth = frame.offsetHeight;
    document.getElementsByClassName('thumbnail-video')[0].style.maxHeight = frame_heigth + 'px';
    document.getElementsByClassName('section-video')[0].style.maxHeight = frame_heigth + 'px';
}

var video_links = document.getElementsByClassName('video-link');
const buttons = document.getElementsByClassName("video-link")
for (const button of buttons) {
    button.addEventListener('click',function(e){
            frame.src = this.getAttribute('data-link');
            document.getElementById('frame video')
        }
    )
}
$('#show-timeline-video-2').click(function(){
    $('#timeline-video-2').toggleClass('show');
})