'use strict';
function removeParent(element) {
    let parent = element.parentElement;
    let ancestor = parent.parentElement;
    ancestor.removeChild(parent);
}
function submitForm(formId) {
	let form = document.getElementById(formId);
	form.submit();
}
function toogleElementClass(elementId, className) {
	$("#" + elementId).toggleClass(className);
}

function toogleAllElementClasses(elementId, className) {
	let elements = document.getElementsByClassName(className);
	if (elements) {
		let i;
		let elementsLength = elements.length;
		for (i = 0; i < elementsLength; i++) {
			$("#" + elements[i].id).toggleClass(className);
		}
		// document.getElementsByClassName(className).style.visibility = 'hidden';
	}
	$("#" + elementId).toggleClass(className);
}

function deleteObject(element, action) {
	alertify.confirm(
		'Do you really want to delete this?', 
		function(){
			$.get(action, function(resposne, status){
				let data = JSON.parse(resposne);
				if (data.status == '1') {
					removeParent(element.parentElement);
					alertify.success('Data deleted');
				} else {
					alertify.error('Data didn\'t delete');
				}
			});
		},
		function(){
			alertify.error('Cancel')
		}
	)
}

function updateIsDeleted(element, isDeleted, action) {
	let post = {
		'isDeleted' : isDeleted
	};
	$.post(action, post, function(response, status){
		if (response === '1') {
			removeParent(element.parentElement);
			alertify.alert('Label hidden');
		} else {
			alertify.alert('Label status didn\'t change');
		}
	})
}

function emailEmployee(employeeId, action) {
	$.post(action, {'employeeid': employeeId}, function(response){
		let data = JSON.parse(response);
		let message = (data.status == '1') ? 'Email sent' : 'Email didn\'t send';
		alertify.alert(message);
	});
}
