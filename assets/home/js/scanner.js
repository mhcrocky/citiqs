'use strict';
function onChangeCallback(event) {
    let orderId = event.target.value;
    let url = globalVariables.baseUrl + 'receipts/' + orderId + '-email.png';
    window.open(url, '_blank').focus();
}

scannerGlobals['order'].addEventListener('change', onChangeCallback);


// Execute a function when the user releases a key on the keyboard
// scannerGlobals['order'].addEventListener("keyup", function(event) {
//     // Number 13 is the "Enter" key on the keyboard
//     if (event.keyCode === 13) {
//         // Cancel the default action, if needed
//         event.preventDefault();

//         alert(document.getElementById('order').value);
//     }
// });


