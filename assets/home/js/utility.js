'use strict';
function removeParent(element) {
    element.parentElement.remove();
}
function submitForm(formId) {
    document.getElementById(formId).submit();
}
function inIframe () {
    try {
        if (window.self !== window.top && payOrderGlobals) {
            if (!payOrderGlobals.hasOwnProperty('ticketing')) {
                setInterval(checkIsIframeOrderPaid, 1000);
            } else if(payOrderGlobals.hasOwnProperty('ticketing')){
                setInterval(checkIsIframeTicketingPaid, 1000);
            }
        }
        return window.self !== window.top;
    } catch (e) {
        return false;
    }
}

function checkIsIframeOrderPaid() {
    let url = globalVariables.ajax + 'checkIsIframeOrderPaid?' + payOrderGlobals['orderDataGetKey'] + '=' + payOrderGlobals['orderRandomKey'];
    sendUrlRequest(url, 'checkIsIframeOrderPaid', checkIsIframeOrderPaidResponse);    
}

function checkIsIframeTicketingPaid() {
    var url = globalVariables.baseUrl + 'Ajaxdorian/checkPaidStatus?order=' + payOrderGlobals['orderRandomKey'];
    $.ajax({
        url: url,
        type: 'POST',
        success: function(response){
            response = JSON.parse(response);
            if (response['status'] == 'true') {
                let success = globalVariables.baseUrl + 'ticketing_success?orderid=' + response['transactionId'];
                window.self.location.href = success;
            }
        }
    }); 
}

function checkIsIframeOrderPaidResponse(response) {

    // TO DO 
    //  CHECK PAYMENT PAID
    //      IF ONLINE => WAIT FOR RESPONSE FROM PAYNL
    if (response['status'] === '1') {
        let success = '';
        success += globalVariables.baseUrl + 'success?';
        success += response['orderKey'] + '=' + response['orderRandomKey'];
        success += '&orderid' + '=' + response['id'];
        window.self.location.href = success;
    }
}

function reloadPageIfMinus(element, checkZeroValue = '1') {    
    let inputValue = parseFloat(element.value);
    let checkZero = checkZeroValue === '1' ? true : false;

    if (checkZero && (inputValue <= 0 || isNaN(inputValue))) {
        location.reload();
        return;
    }
    if (!checkZero && (inputValue < 0 || isNaN(inputValue))) {
        location.reload();
        return;
    }
    return;
}

function redirectToNewLocation(location) {
    let newLocation = location.trim();
    if (newLocation) {
        newLocation = globalVariables['baseUrl'] + newLocation
        window.location.href = newLocation;
    }
}

function alertifyMessage(element) {
    alertify[element.dataset.messageType](element.dataset.message)
}

function alertifyErrMessage(element) {
    let inputValue = element.value.trim();
    let minLength = parseInt(element.dataset.minLength);
    if (inputValue.length < minLength) {
        let errMessage = element.dataset.errorMessage;
        alertify.error(errMessage);
        element.style.border = '1px solid #f00'
        return 1;
    } else {
        element.style.border = 'initial'
        return 0;
    }   
}

function validateFormData(form) {
    let inputs = form.querySelectorAll('[data-form-check]')
    let inputsLength = inputs.length;
    let i;
    let countErrors = 0;


    for (i = 0; i < inputsLength; i++) {
        let input = inputs[i];
        countErrors += alertifyErrMessage(input);
    }
    return countErrors ? false : true;
}

function alertifyAjaxResponse(response) {
    let messages = response['messages'];
    let message;
    let action = response.status === '1' ? 'success' : 'error'
    // if (response.status === '1') {
        for (message of messages) {
            alertify[action](message);
        }
    // }
}
function facebookCustom(name, nameValue) {
    if (typeof fbq !== 'undefined') {
        fbq('trackCustom', name , {promotion: nameValue});
    }
}

// used on pos, can be usen in and other view
function runKeyboard(className) {
    $('.' + className).keyboard({
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


function showMessagesInContainer(conatinerId, response) {
    let type = response['status'] === '1' ? 'alert-success' : 'alert-danger';
    let messages = response['messages'];
    let messagesLength = messages.length;
    let content = '';
    let i;

    for (i = 0; i < messagesLength; i++) {
        let message = messages[i];
        content +=  '<div class="alert alert-danger '  + type + ' show" role="alert">';
        content +=      '<strong>' + message  + '</strong>';
        content +=      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        content +=          '<span aria-hidden="true">&times;</span>';
        content +=      '</button>';
        content +=  '</div>';
    }

    $('#' + conatinerId).empty().html(content);
}

// reload jquery datatable
function reloadTable(id) {
    $('#' + id).DataTable().ajax.reload();
}

function submitSwitchAccountForm(element) {
    let elementValue = element.value.trim();
    if (elementValue) {
        element.form.submit();
    }
}
