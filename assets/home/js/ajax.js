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

function sendAjaxPostRequestImproved(post, url, callFunction = null, functionArg = []) {
    $.ajax({
        url: url,
        data: post,
        type: 'POST',
        success: function (response) {
            let data = JSON.parse(response);
            if (callFunction) {
                functionArg.push(data);
                callFunction(...functionArg);
            }
        },
        error: function (err) {
            console.dir(err);
        }
    });
}

function sendFormAjaxRequestImproved(form, url, callFunction = null, functionArg = []) {
    let formData = new FormData(form);
    sendFormDataAjaxRequestImproved(formData, url, callFunction, functionArg);
}

function sendFormDataAjaxRequestImproved(formData, url, callFunction = null, functionArg = []) {
    $.ajax({
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (response) {
            let data = JSON.parse(response);
            if (callFunction) {
                functionArg.push(data);
                callFunction(...functionArg);
            }
        },
        error: function (err) {
            console.dir(err);
        }
    });
}

function sendUrlRequest(url, callBack, callFunction = null, functionArg = []) {
    $.ajax({
        url: url,
        type: 'GET',
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

function sendGetRequest(url, callFunction = null, functionArg = []) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            let data = JSON.parse(response);
            if (callFunction) {
                functionArg.push(data);
                callFunction(...functionArg);
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
        fetchOrders: function(callFunction) {
            if (this) {
                callFunction(this);
            }
        },
        changeStatus: function(callFunction) {
            if (this) {
                alertify.success('Order status updated');
                callFunction();
            } else {
                alertify.error('Order status update failed');
            }
        },
        sendSms: function(callFunction, functionArg) {
            if (this) {
                functionArg.push(this);
                callFunction(...functionArg);
                alertify.success('SMS send');
            } else {
                alertify.error('SMS not send');
            }
        },
        updatePhoneNumber: function() {
            if (this) {
                alertify.success('Mobile number updated');
                // callFunction();
            } else {
                alertify.error('Mobile number not updated');
            }
        },
        ajaxUpdateSession: function(callFunction) {
            // no action
        },
        checkSpotId: function(callFunction, functionArg) {
            if (this) {
                functionArg.push(this.url);
                callFunction(...functionArg);
            } else {
                alertify.error('Unknown spot name! Please check');
            }
        },
        updateCategoriesOrder: function() {
            if (this) {
                alertify.success('Categories sorted');
            } else {
                alertify.error('Categories sorting failed!');
            }
        },
        updateProductSpotStatus: function() {
            if (this) {
                alertify.success('Update success');
            } else {
                alertify.error('Update failed!');
            }
        },
        unsetSessionOrderElement: function(callFunction, functionArg) {
            if (this == '1') {
                callFunction(...functionArg);
            } else {
                alertify.error('Product(s) did not remove from list');
            }
        },
        updateSessionOrderAddon: function() {

        },
        updateSessionOrderMainProduct: function() {

        },
        saveBusyTime: function(callFunction) {
            if (this) {
                callFunction();
                alertify.success('Busy time updated');
            } else {
                alertify.error('Update failed!');
            }
        },
        checkUserNewsLetter: function(callFunction) {
            let newsLetter = this == 1 ? true : false;
            callFunction(newsLetter);
        },
        voucherPay: function(callFunction) {
            callFunction(this);
        },
        confirmOrderAction: function(callFunction) {
            callFunction(this);
        },
        getDistance: function(callFunction, functionArg) {
            if (this) {
                functionArg.push(this);
            }
            callFunction(...functionArg);
        },
        getLocation: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        calculateDistance: function(callFunction, functionArg) {
            if (parseFloat(this)) {
                functionArg.push(this);
                callFunction(...functionArg);
            }            
        },
        submitForm: function(callFunction) {
            callFunction(this);
        },
        submitBuyerDetails: function(callFunction) {
            callFunction(this);
        },
        saveDesign: function(callFunction) {
            callFunction(this);
        },
        saveIrame: function() {            
        },
        generateCategoryKey: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        checkCategoryCode: function(callFunction) {
            callFunction(this);
        },
        posPayOrder: function(callFunction, functionArg) {
            if (this) {
                functionArg.push(this);
            }
            callFunction(...functionArg);
        },
        checkIfsUserExists:  function(callFunction) {
            callFunction(this);
        },
        uploadViewBgImage: function(callFunction) {
            callFunction(this);
        },
        removeBgImage: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        saveAnalytics:  function(callFunction) {
            callFunction(this);
        },
        actviateApiRequest: function(callFunction) {
            callFunction(this);
        },
        sendReportPrintRequest: function(callFunction) {
            callFunction(this);
        },
        updateApiName: function(callFunction) {
            callFunction(this);
        },
        lockPos: function(callFunction) {
            callFunction(this);
        },
        fetchSavedOrder: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        deletePosOrder: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        checkIsIframeOrderPaid: function(callFunction) {
            callFunction(this);
        },
        createEmailTemplate: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        payNlRegistration: function(callFunction) {
            callFunction(this);
        },
        uploadDocumentsForPayNl: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        insertAllPaymentMethods: function(callFunction) {
            callFunction(this);
        },
        updatePaymentMethodCost: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        registerAmbasador: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        posVoucherPay: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
        refundMoney: function(callFunction, functionArg) {
            functionArg.push(this);
            callFunction(...functionArg);
        },
    };
    return methods;
})();
