'use strict';
function showCategory(element, categoryId, categoriesClass) {
    let categories = document.getElementsByClassName(categoriesClass);
    let categoriesLength = categories.length;
    let i;
    for (i = 0; i < categoriesLength; i++) {
        let category = categories[i];			
        if (category.id !== categoryId) {
            let categoryButton = document.querySelector('[data-id="' + category.id + '"]');
            category.style.display = 'none';
            categoryButton.classList.remove(makeOrderGlobals.activeClass);
        } else {
            category.style.display = 'block';				
        }
    }
    element.classList.add(makeOrderGlobals.activeClass);
}


function posTriggerModalClick(modalButtonId) {
    triggerModalClick(modalButtonId);
    
}

function cancelPosOrder(orderDataRandomKey,) {
    if (orderDataRandomKey) {
        $('#confirmCancel').modal('show');
    } else {
        resetPosOrder();
    }
}

function resetPosOrder() {
    document.getElementById(makeOrderGlobals.modalCheckoutList).innerHTML = '';
    countOrderedToZero('countOrdered');
    resetTotal();
}

function deleteOrder(spotId, orderDataRandomKey) {
    window.location.href =  globalVariables.baseUrl + 'pos/delete/' + orderDataRandomKey + '/' +  spotId;
}

function holdOrder(spotId, saveNameId) {
    let saveName = document.getElementById(saveNameId).value;
    if (!saveName.trim()) {
        alertify.error('Order name is required');
    } else {
        let pos = 1;
        let urlPart ='pos?spotid=' + spotId + '&';
        let send = prepareSendData(pos);
        if (!send) {
            alertify.error('No product(s) in order list');
        }
        send['posOrder'] = {
            'saveName' : saveName,
            'spotId' : spotId
        }
        sendOrderAjaxRequest(send, urlPart);
    }
}

function posTriggerModalClick(modalButtonId) {
    let posResponseDiv = document.getElementById(makeOrderGlobals.posResponse);
    let orderContainer = document.getElementById(makeOrderGlobals.posMakeOrderId);
    posResponseDiv.style.display = 'none';
    orderContainer.style.display  = 'block';
    triggerModalClick(modalButtonId);
    // setRemarkIds();
}

function setRemarkIds() {
    let container = document.getElementById(makeOrderGlobals.posMakeOrderId);
    let remarks = container.getElementsByClassName('remarks');
    let remarksLenght = remarks.length;
    let i;
    for (i = 0; i < remarksLenght; i++) {
        let remark = remarks[i];
        let remarkId = i + '_';
        if (!remark.id) {
            if (remark.dataset.productRemarkId) {
                remarkId += remark.dataset.productRemarkId;
            }
            if (remark.dataset.addonRemarkId) {
                remarkId = remark.dataset.addonRemarkId;
            }
            remark.id = remarkId;
            $(keyboardHtml(remarkId)).insertAfter(remark)
        }
    }
}

function keyboardHtml(targetId) {    
    let keyboard =
        `<div
            class="virtual-keyboard-hook"
            data-target-id="${targetId}"
            data-keyboard-mapping="qwerty"
            style="text-align: center; font-size: 20px;"
        >
            <i class="fa fa-keyboard-o" aria-hidden="true"></i>
        </div>`;
    return keyboard;
}

function posPayment(element) {
    let locked = parseInt(element.dataset.locked);
    if (locked) {
        return;
    }

    element.setAttribute('data-locked', '1');

    let orderedProducts = document.getElementsByClassName(makeOrderGlobals.orderedProducts);
    let orderedProductsLength = orderedProducts.length;

    if (!orderedProductsLength) {
        alertify.error('No product(s) in order list');
        element.setAttribute('data-locked', '0');
        return;
    }

    let data = getOrderExtedned(orderedProducts,orderedProductsLength);
    let post = {
        'vendorId' : makeOrderGlobals.vendorId,
        'oneSignalId' : makeOrderGlobals.oneSignalId,
        'spotId' : makeOrderGlobals.spotId,
        'orderDataRandomKey' : makeOrderGlobals.orderDataRandomKey,
        'pos' : '1',
        'user' : {
            'roleid' : makeOrderGlobals.buyerRoleId,
            'usershorturl' : makeOrderGlobals.buyershorturl,
            'salesagent' : makeOrderGlobals.salesagent,
            'username' : 'pos user',
            'email' : 'posusertest@tiqs.com',
            'mobile' : '1234567890',
            'newsletter' : '0',
        },
        'order' : {
            'waiterTip' : 0,
            'serviceFee' : getServiceFee(data['orderAmount']),
            'amount' : data['orderAmount'],
            'remarks' : '',
            'spotId' : makeOrderGlobals.spotId
        },
        'orderExtended' :  data['orderExtended'],
    }

    let url = globalVariables.baseUrl + 'Alfredinsertorder/posPayment'
    if (makeOrderGlobals['orderDataRandomKey']) {
        url += '/' + makeOrderGlobals['orderDataRandomKey'];
    }
    sendAjaxPostRequest(post, url, 'posPayment', manageResponse, [element]);
    return;
}

function getOrderExtedned(orderedProducts, orderedProductsLength) {
    let orderExtended = [];
    let orderAmount = 0;
    let i;
    let j;
    for (i = 0; i < orderedProductsLength; i++) {
        let orderedItem = orderedProducts[i];
        let product = document.querySelectorAll('#' + orderedItem.id + ' [data-add-product-price]')[0];
        let addons = document.querySelectorAll('#' + orderedItem.id + ' [data-addon-price]');
        let addonsLength = addons.length;
        let mainPrductOrderIndex = 0;
        let subMainPrductOrderIndex = 0;
        let productRemark = ''
        let productOrderItem = new Map();
        let productValue = parseInt(product.value);

        //increase order amount
        orderAmount += productValue * parseFloat(product.dataset.addProductPrice);

        if (product.dataset['remarkId'] !== '0') {
            productRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-product-remark-id="' + product.dataset.remarkId + '"]')[0].value;
        }

        productOrderItem = {
            'productsExtendedId' : product.dataset.productExtendedId,
            'quantity' : productValue,
            'remark' : productRemark,
            'mainPrductOrderIndex' : mainPrductOrderIndex,
            'subMainPrductOrderIndex' : subMainPrductOrderIndex,
        }

        if (!addonsLength) {
            if (productRemark.length || !orderExtended.length) {
                orderExtended.push(productOrderItem);
            } else {
                let orderExtendedLength = orderExtended.length;
                let z;

                for (z = 0; z < orderExtendedLength; z++) {
                    if (orderExtended[z]['productsExtendedId'] === productOrderItem['productsExtendedId']) {
                        orderExtended[z]['quantity'] += productOrderItem['quantity']
                        productOrderItem = false;
                        break;
                    }
                }
                if (productOrderItem) {
                    orderExtended.push(productOrderItem);
                }
            }

        } else {
            mainPrductOrderIndex = i + 1;
            productOrderItem['mainPrductOrderIndex'] = mainPrductOrderIndex;
            orderExtended.push(productOrderItem);

            for (j = 0; j < addonsLength; j++) {
                let addon = addons[j];
                if (addon.parentElement.previousElementSibling.children[0].children[0].checked) {
                    //increase order amount
                    orderAmount +=  parseFloat(addon.value) * parseFloat(addon.dataset.addonPrice);

                    let addonOrderItem = {};
                    let addonRemark = '';
                    if (addon.dataset['remarkId'] !== '0') {
                        addonRemark = document.querySelectorAll('#' + orderedItem.id + ' [data-addon-remark-id="' + addon.dataset.remarkId + '"]')[0].value;
                    }

                    addonOrderItem = {
                        'productsExtendedId' : addon.dataset.addonExtendedId,
                        'quantity' : addon.value,
                        'remark' : addonRemark,
                        'subMainPrductOrderIndex' : mainPrductOrderIndex,
                        'mainPrductOrderIndex' : 0,
                    }
                    orderExtended.push(addonOrderItem);
                }
            }
        }
    }

    let returnData = new Map()
    returnData = {
        'orderAmount' : orderAmount,
        'orderExtended' : orderExtended
    }

    return returnData;
}

function manageResponse(element, data) {
    let orderId = data['orderId'];
    unlockPos(element)
    if (!parseInt(orderId)) {
        alertify.error('Order not made');
        return;
    }
    resetPosOrder();
    removeSavedOrder(data['orderRandomKey']);
    showOrderId(orderId);
    sednNotification(orderId);
    printOrder(orderId);
    return;
}

function unlockPos(element) {
    element.setAttribute('data-locked', '0');
}

function showOrderId(orderId) {
    let responseContainer = document.getElementById(makeOrderGlobals.posResponse);
    let orderContainer = document.getElementById(makeOrderGlobals.posMakeOrderId);    
    let html = '<p>Order is done. Order id is: ' + orderId + '</p>';

    orderContainer.style.display = 'none';
    responseContainer.style.display = 'block';
    responseContainer.innerHTML = html;
}

function sednNotification(orderId) {
    if (!posGlobals.venodrOneSignalId) return
    let url = globalVariables.baseUrl + 'Alfredinsertorder/posSendNoticication/' + orderId + '/' + posGlobals.venodrOneSignalId;
    $.get(url, function(data, status) {});
}

function printOrder(orderId) {
    let justPrint = 'http://localhost/tiqsbox/index.php/Cron/justprint/' + orderId;
    $.get(justPrint, function(data, status) {});
}

function printReportes(vendorId, reportType) {
    let url = globalVariables.baseUrl + 'api/report?vendorid=' + vendorId + '&report=' + reportType;
    $.get(url, function(data, status) {
        let response = JSON.parse(data);
        if (response.status === '1') {
            let tiqsBoxPrintReport = 'http://localhost/tiqsbox/index.php/Cron/printreportes/' + vendorId + '/' + reportType;
            $.get(tiqsBoxPrintReport, function(data, status) {});
        }
    });
}


function getServiceFee(orderAmount) {
    let serviceFee = orderAmount * posGlobals.serviceFeePercent / 100 + posGlobals.minimumOrderFee;
    if (serviceFee > posGlobals.serviceFeeAmount) {
        serviceFee = posGlobals.serviceFeeAmount;
    }
    return serviceFee;
}

function countOrderedToZero(countOrdered) {
    let elements =  document.getElementsByClassName(countOrdered);
    let elementsLength  = elements.length;
    let i;
    for (i = 0; i < elementsLength; i++) {
        elements[i].innerHTML = '0';
    }
}

function removeSavedOrder(orderRandomKey) {
    if (!orderRandomKey) return;
    let optionItem = document.getElementById(orderRandomKey);    
    if (optionItem) optionItem.remove();
    document.getElementById('saveHoldOrder').innerHTML = 'Save order'
}

function showLoginModal() {
    if (!posGlobals['unlock']) {
        $('#posLoginModal').modal('show');
    }
}

function posLogin(form) {
    if (!validateFormData(form)) return false;

    let url = globalVariables.ajax + 'posLogin';

    sendFormAjaxRequest(form, url, 'posLogin', posLoginResponse, [form])

    return false;
}

function posLoginResponse(form, response) {
    if (response['status'] === '0') {
        return;
    } else {
        form.reset();
        posGlobals['unlock'] = true;
        $('#posLoginModal').modal('hide');
        posGlobals['checkActivityId'] = checkActivity();
    }
}

function lockPos() {
    let url = globalVariables.ajax + 'lockPos';
    sendUrlRequest(url, 'lockPos', lockPosRespone);
}

function lockPosRespone(response) {
    if (response['status'] === '1') {
        posGlobals['unlock'] = false;
        showLoginModal();
        clearActivtiyInterval();
    } else {
        alertify.error('Pos not locked!');
    }
}

function resetCounter() {
    if (posGlobals['unlock']) {
        posGlobals['counter'] = 0;
        clearInterval(posGlobals['checkActivityId']);
        posGlobals['checkActivityId'] = checkActivity();
    }
}

function checkActivity() {
    return setInterval( function() {
        if (posGlobals['unlock']) {
            posGlobals['counter'] = posGlobals['counter'] + 10;
            if (!(posGlobals['counter'] % 30)) {
                lockPos();
            }
        }
    }, 10000);
}

function clearActivtiyInterval() {
    posGlobals['counter'] = 0;
    clearInterval(posGlobals['checkActivityId']);
}


function runKeyboard() {
    $('.posKeyboard').keyboard({
        // set this to ISO 639-1 language code to override language set by
        // the layout: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
        // language defaults to ["en"] if not found
        language: ['en'],
        rtl: false,
  
        // *** choose layout & positioning ***
        // choose from 'qwerty', 'alpha',
        // 'international', 'dvorak', 'num' or
        // 'custom' (to use the customLayout below)
        layout: 'qwerty',
        customLayout: {
            'default': [
                'd e f a u l t',
                '{meta1} {meta2} {accept} {cancel}'
            ],
            'meta1': [
                'm y m e t a 1',
                '{meta1} {meta2} {accept} {cancel}'
            ],
            'meta2': [
                'M Y M E T A 2',
                '{meta1} {meta2} {accept} {cancel}'
            ]
        },
        // Used by jQuery UI position utility
        position: {
            // null = attach to input/textarea;
            // use $(sel) to attach elsewhere
            of: null,
            my: 'center top',
            at: 'center top',
            // used when "usePreview" is false
            at2: 'center bottom'
        },
  
        // allow jQuery position utility to reposition the keyboard on
        // window resize
        reposition: true,
  
        // true: preview added above keyboard;
        // false: original input/textarea used
        usePreview: true,
  
        // if true, the keyboard will always be visible
        alwaysOpen: false,
  
        // give the preview initial focus when the keyboard
        // becomes visible
        initialFocus: true,
        // Avoid focusing the input the keyboard is attached to
        noFocus: false,
  
        // if true, keyboard will remain open even if
        // the input loses focus.
        stayOpen: false,
  
        // Prevents the keyboard from closing when the user clicks or
        // presses outside the keyboard. The `autoAccept` option must
        // also be set to true when this option is true or changes are lost
        userClosed: false,
  
        // if true, keyboard will not close if you press escape.
        ignoreEsc: false,
  
        // *** change keyboard language & look ***
        display: {
            'meta1': '\u2666', // Diamond
            'meta2': '\u2665', // Heart
  
            // check mark (accept)
            'a': '\u2714:Accept (Shift-Enter)',
            'accept': 'Accept:Accept (Shift-Enter)',
            'alt': 'AltGr:Alternate Graphemes',
            // Left arrow (same as &larr;)
            'b': '\u2190:Backspace',
            'bksp': 'Bksp:Backspace',
            // big X, close/cancel
            'c': '\u2716:Cancel (Esc)',
            'cancel': 'Cancel:Cancel (Esc)',
            // clear num pad
            'clear': 'C:Clear',
            'combo': '\u00f6:Toggle Combo Keys',
            // num pad decimal '.' (US) & ',' (EU)
            'dec': '.:Decimal',
            // down, then left arrow - enter symbol
            'e': '\u21b5:Enter',
            'empty': '\u00a0', // &nbsp;
            'enter': 'Enter:Enter',
            // left arrow (move caret)
            'left': '\u2190',
            // caps lock
            'lock': '\u21ea Lock:Caps Lock',
            'next': 'Next \u21e8',
            'prev': '\u21e6 Prev',
            // right arrow (move caret)
            'right': '\u2192',
            // thick hollow up arrow
            's': '\u21e7:Shift',
            'shift': 'Shift:Shift',
            // +/- sign for num pad
            'sign': '\u00b1:Change Sign',
            'space': '\u00a0:Space',
            // right arrow to bar
            // \u21b9 is the true tab symbol
            't': '\u21e5:Tab',
            'tab': '\u21e5 Tab:Tab',
            // replaced by an image
            'toggle': ' ',
  
            // added to titles of keys
            // accept key status when acceptValid:true
            'valid': 'valid',
            'invalid': 'invalid',
            // combo key states
            'active': 'active',
            'disabled': 'disabled'
  
        },
  
        // Message added to the key title while hovering,
        // if the mousewheel plugin exists
        wheelMessage: 'Use mousewheel to see other keys',
  
        css: {
            // input & preview
            input: 'ui-widget-content ui-corner-all',
            // keyboard container
            container: 'ui-widget-content ui-widget ui-corner-all ui-helper-clearfix',
            // keyboard container extra class (same as container, but separate)
            popup: '',
            // default state
            buttonDefault: 'ui-state-default ui-corner-all',
            // hovered button
            buttonHover: 'ui-state-hover',
            // Action keys (e.g. Accept, Cancel, Tab, etc);
            // this replaces "actionClass" option
            buttonAction: 'ui-state-active',
            // Active keys
            // (e.g. shift down, meta keyset active, combo keys active)
            buttonActive: 'ui-state-active',
            // used when disabling the decimal button {dec}
            // when a decimal exists in the input area
            buttonDisabled: 'ui-state-disabled',
            // {empty} button class name
            buttonEmpty: 'ui-keyboard-empty'
        },
  
        // *** Useability ***
        // Auto-accept content when clicking outside the
        // keyboard (popup will close)
        autoAccept: false,
        // Auto-accept content even if the user presses escape
        // (only works if `autoAccept` is `true`)
        autoAcceptOnEsc: false,
  
        // Prevents direct input in the preview window when true
        lockInput: false,
  
        // Prevent keys not in the displayed keyboard from being
        // typed in
        restrictInput: false,
        // Additional allowed characters while restrictInput is true
        restrictInclude: '', // e.g. 'a b foo \ud83d\ude38'
  
        // Check input against validate function, if valid the
        // accept button is clickable; if invalid, the accept
        // button is disabled.
        acceptValid: true,
        // Auto-accept when input is valid; requires `acceptValid`
        // set `true` & validate callback
        autoAcceptOnValid: false,
  
        // if acceptValid is true & the validate function returns
        // a false, this option will cancel a keyboard close only
        // after the accept button is pressed
        cancelClose: true,
  
        // tab to go to next, shift-tab for previous
        // (default behavior)
        tabNavigation: false,
  
        // enter for next input; shift-enter accepts content &
        // goes to next shift + "enterMod" + enter ("enterMod"
        // is the alt as set below) will accept content and go
        // to previous in a textarea
        enterNavigation: false,
        // mod key options: 'ctrlKey', 'shiftKey', 'altKey',
        // 'metaKey' (MAC only)
        // alt-enter to go to previous;
        // shift-alt-enter to accept & go to previous
        enterMod: 'altKey',
  
        // if true, the next button will stop on the last
        // keyboard input/textarea; prev button stops at first
        // if false, the next button will wrap to target the
        // first input/textarea; prev will go to the last
        stopAtEnd: true,
  
        // Set this to append the keyboard immediately after the
        // input/textarea it is attached to. This option works
        // best when the input container doesn't have a set width
        // and when the "tabNavigation" option is true
        appendLocally: false,
        // When appendLocally is false, the keyboard will be appended
        // to this object
        appendTo: 'body',
  
        // If false, the shift key will remain active until the
        // next key is (mouse) clicked on; if true it will stay
        // active until pressed again
        stickyShift: false,
  
        // Prevent pasting content into the area
        preventPaste: false,
  
        // caret places at the end of any text
        caretToEnd: false,
  
        // caret stays this many pixels from the edge of the input
        // while scrolling left/right; use "c" or "center" to center
        // the caret while scrolling
        scrollAdjustment: 10,
  
        // Set the max number of characters allowed in the input,
        // setting it to false disables this option
        maxLength: false,
        // allow inserting characters @ caret when maxLength is set
        maxInsert: true,
  
        // Mouse repeat delay - when clicking/touching a virtual
        // keyboard key, after this delay the key will start
        // repeating
        repeatDelay: 500,
  
        // Mouse repeat rate - after the repeatDelay, this is the
        // rate (characters per second) at which the key is
        // repeated. Added to simulate holding down a real keyboard
        // key and having it repeat. I haven't calculated the upper
        // limit of this rate, but it is limited to how fast the
        // javascript can process the keys. And for me, in Firefox,
        // it's around 20.
        repeatRate: 20,
  
        // resets the keyboard to the default keyset when visible
        resetDefault: false,
  
        // Event (namespaced) on the input to reveal the keyboard.
        // To disable it, just set it to ''.
        openOn: 'focus',
  
        // Event (namepaced) for when the character is added to the
        // input (clicking on the keyboard)
        keyBinding: 'mousedown touchstart',
  
        // enable/disable mousewheel functionality
        // enabling still depends on the mousewheel plugin
        useWheel: true,
  
        // combos (emulate dead keys)
        // if user inputs `a the script converts it to à,
        // ^o becomes ô, etc.
        useCombos: true,
        // if you add a new combo, you will need to update the
        // regex below
        combos: {
            // uncomment out the next line, then read the Combos
            //Regex section below
            '<': { 3: '\u2665' }, // turn <3 into ♥ - change regex below
            'a': { e: "\u00e6" }, // ae ligature
            'A': { E: "\u00c6" },
            'o': { e: "\u0153" }, // oe ligature
            'O': { E: "\u0152" }
        },
  
        // *** Methods ***
        // Callbacks - attach a function to any of these
        // callbacks as desired
        initialized: function(e, keyboard, el) {},
        beforeVisible: function(e, keyboard, el) {},
        visible: function(e, keyboard, el) {},
        beforeInsert: function(e, keyboard, el, textToAdd) { return textToAdd; },
        change: function(e, keyboard, el) {},
        beforeClose: function(e, keyboard, el, accepted) {},
        accepted: function(e, keyboard, el) {},
        canceled: function(e, keyboard, el) {},
        restricted: function(e, keyboard, el) {},
        hidden: function(e, keyboard, el) {},
  
        // called instead of base.switchInput
        // Go to next or prev inputs
        // goToNext = true, then go to next input;
        //   if false go to prev
        // isAccepted is from autoAccept option or
        //   true if user presses shift-enter
        switchInput: function(keyboard, goToNext, isAccepted) {},
  
        /*
                // build key callback
            buildKey : function( keyboard, data ) {
                  /* data = {
                    // READ ONLY
                    isAction: [boolean] true if key is an action key
                    // name... may include decimal ascii value of character
                    // prefix = 'ui-keyboard-'
                    name    : [string]  key class name suffix
                    value   : [string]  text inserted (non-action keys)
                    title   : [string]  title attribute of key
                    action  : [string]  keyaction name
                    // html includes a <span> wrapping the text
                    html    : [string]  HTML of the key;
                    // DO NOT MODIFY THE ABOVE SETTINGS
  
                    // use to modify key HTML
                    $key    : [object]  jQuery selector of key already added to keyboard
                  }
                  * /
                  data.$key.html('<span class="ui-keyboard-text">Foo</span>');
                  return data;
                  },
                */
  
        // this callback is called just before the "beforeClose"
        // to check the value if the value is valid, return true
        // and the keyboard will continue as it should (close if
        // not always open, etc)
        // if the value is not value, return false and the clear
        // the keyboard value ( like this
        // "keyboard.$preview.val('');" ), if desired
        validate: function(keyboard, value, isClosing) {
          return true;
        }
  
    })
}

$(document).ready(function(){
    if (typeof makeOrderGlobals === 'undefined') return;
    let sumbitFormButton = document.getElementById(makeOrderGlobals.checkoutContinueButton);
    if (sumbitFormButton) {
        sumbitFormButton.click();
    }

    runKeyboard();

});

resetTotal();
countOrdered('countOrdered');
showLoginModal();

posGlobals['checkActivityId'] = checkActivity();

window.onclick = function(e) {    
    showLoginModal();
    resetCounter();
    runKeyboard();
}

window.onmousemove = function(e) {
    resetCounter();
}
