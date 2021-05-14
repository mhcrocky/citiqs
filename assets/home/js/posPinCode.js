'use strict';
function fetchValue(value, element) {
	let code = posGlobals['pinCodeELement'];
	let codeValue = code.value;
	let newValue = codeValue + value;
	code.value = newValue;
	code.setAttribute('value', newValue);
}

function clearCode() {
	let code = posGlobals['pinCodeELement'];
	let clearValue = '';
	code.value = clearValue;
	code.setAttribute('value', clearValue);
}
