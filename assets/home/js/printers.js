'use strict';

function checkPrintersConnection() {
    let prinetrs = document.getElementsByClassName(printerGlobals.errClass);
    let printersLength = prinetrs.length;
    let i;
    let url = globalVariables.ajax + 'checkPrintersConnection/';

    for (i = 0; i < printersLength; i++) {
        let printer = prinetrs[i];
        if (printer.dataset.active === '1') {
            let printerId = printer.dataset.printerId
            let urlFinal = url + printerId;
            $.get(urlFinal, function(data, status){
                let response = JSON.parse(data);
                printer.style.visibility = (response.status === '1') ? 'hidden' : 'visible';
            });
        }
    }
}

checkPrintersConnection();

setInterval(function(){
    checkPrintersConnection();
}, 10000);