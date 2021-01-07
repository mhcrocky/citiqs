'use strict';

function checkPrintersConnection() {
    let prinetrs = document.getElementsByClassName(printerGlobals.errClass);
    let printersLength = prinetrs.length;
    let i;
    let url = globalVariables.ajax + 'checkPrintersConnection/';

    
    for (i = 0; i < printersLength; i++) {
        let printer = prinetrs[i];
        let printerId = printer.dataset.printerId
        let urlFinal = url + printerId;
        
        $.get(urlFinal, function(data, status){
              let response = JSON.parse(data);
              console.dir(response);
            if (response.status === '1') {
                printer.style.visibility = 'hidden'; 
            } else {
                printer.style.visibility = 'visible'; 
            }
        });
        
    }
}

checkPrintersConnection();

setInterval(function(){
    checkPrintersConnection();
}, 10000);