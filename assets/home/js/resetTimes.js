'use strict';
function confirmResetProductTimes(restFormId, timeFromId, timeToId) {
    alertify.confirm(
		'Do you really want to reset product times?', 
		function(){
            let timeFrom = document.getElementById(timeFromId).value.trim();
            let timeTo = document.getElementById(timeToId).value.trim();

            if (!timeFrom && !timeTo) {
                alertify.error('No time selected');
            } else {
                let post = {}
                if (timeFrom) {
                    post['timeFrom'] = timeFrom;
                }
                if (timeTo) {
                    post['timeTo'] = timeTo;
                }
                resetTimesAction(post);
            }
		},
		function(){
			alertify.error('Cancel')
		}
	)
}

function resetTimesAction(post) {
    let url = globalVariables.ajax + 'resetProductTimes';
    console.dir(post);
    sendAjaxPostRequestImproved(post, url, alertifyAjaxResponse);
}

