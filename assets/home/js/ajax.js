'use strict';
function sendFormAjaxRequest(form, url, callBack, callFunction = null, functionArg = []) {
    let formData = new FormData(form);
    sendFormDataAjaxRequest(formData, url, callBack, callFunction, functionArg);
}

function sendFormDataAjaxRequest(formData, url, callBack, callFunction = null, functionArg = []) {
    $.ajax({
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (response) {
            let data = JSON.parse(response);
            if (callFunction) {
                callThis[callBack].apply(data, [callFunction, functionArg]);
            } else {
                callThis[callBack].apply(data);
            }
        },
        error: function (err) {
            console.dir(err);
        }
    });
}
function sendAjaxPostRequest(post, url, callBack, callFunction = null, functionArg = []) {
    $.ajax({
        url: url,
        data: post,
        type: 'POST',
        success: function (response) {
            let data = JSON.parse(response);
            if (callFunction) {
                callThis[callBack].apply(data, [callFunction, functionArg]);
            } else {
                callThis[callBack].apply(data);
            }
        },
        error: function (err) {
            console.dir(err);
        }
    });
}
var callThis = (function() {
    let methods = {        
        uploadIdentification: function() {
            let message = ''
            if (this == 1) {
                message = 'Identification successful. Please, continue with the next step.'
                alertify.success(message);
            } else if (this == 0) {
                message = 'Identification NOT successful. Please, try again or contact staff if this problem persist.';
                alertify.error(message);
            } else if (this == 2) {
                message = 'Identification failed. File has invalid format (use jpg, png, tiff or pdf).';
                alertify.error(message);
            }
        },
        uploadUtilityBill: function() {
            if (this == 1) {
                let message = 'Upload of your utility bill was successful. If you\'ve finished all three steps, you can wait and relax. We will contact you by e-mail.';
                alertify.success(message);
            } else {
                alertify.error('Could not save utility bill, try again.');
            }
        },
        labelImageUpload: function(callFunction, functionArg) {
            if (this) {
                functionArg.push(this.image);
                functionArg.push(this.bigImage);
                callFunction(...functionArg);
            }
        },
        uploadImageAndGetCode: function(callFunction, functionArg) {
            if (this) {
                functionArg.push(this);
                callFunction(...functionArg);
            }
        },
        sendItem: function() {       
            if (this.success === 0) {
                alertify.error('Sending process failed! Please refresh page and try again');
            } else if (this.success === 1) {
                $.fancybox.open(this.content);
            }
        },
        saveItemLocation: function(callFunction, functionArg) {
            if (this.success === 1) {
                functionArg.push(this.label.id, this.label.lat, this.label.lng);
                callFunction(...functionArg);
                alertify.success('Location saved');
            } else {
                alertify.error('Update process failed');
            }
        },
        updateLostItem: function(callFunction, functionArg) {
            if (this.success === 1) {
                functionArg.push(this.label.id, this.label.lat, this.label.lng);
                callFunction(...functionArg);
                alertify.success('Location saved');
            } else {
                alertify.error('Update process failed');
            }
        },
        sendInvoice: function() {
            if (this.success === 1) {
                alertify.success('Invoice created');
                window.open(this.inoviceSource)
                
            } else {
                alertify.error('Invoice didn\'t create!');
            }
        },
        uploadFloorPlan: function() {
            if (this.success === 1) {
                alertify.success(this.msg);
            } else {
                alertify.error(this.msg);
            }
        },
        updateSpot: function() {
            if (this === 1) {
                alertify.success('Spot updated');
            } else {
                alertify.error('Update failed');
            }
        },
        fetchOrders: function(callFunction, functionArg) {
            if (this) {
                functionArg.push(this);
                callFunction(...functionArg);
            }
        }
    };
    return methods;
})();