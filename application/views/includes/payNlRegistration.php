<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="modal" id="setPayNlServiceId" tabindex="-1" role="dialog" aria-labelledby="setPayNlServiceIdTitle" aria-hidden="true">
    <form method="post" onsubmit="return payNlRegistration(this)">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPayNlServiceIdTitle">Register for paynl</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <legend>Merchant</legend>
                        <div class="form-group">
                            <label for="cocNumber">Chamber of Commerce (COC) number of the company</label>
                            <input
                                class="form-control"
                                type="text"
                                id="cocNumber"
                                name="merchant[coc]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="Chamber of Commerce number of the company is requried"
                            />
                        </div>
                        <div class="form-group">
                            <label for="cocNumberName">Chamber of Commerce name</label>
                            <input
                                class="form-control"
                                type="text"
                                id="cocNumberName"
                                name="merchant[name]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="Chambet of commerce name is requried"
                            />
                        </div>
                        <div class="form-group">
                            <label for="vatNumber">VAT number</label>
                            <input
                                class="form-control"
                                type="text"
                                id="vatNumber"
                                name="user[vat_number]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="VAT number is required"
                            />
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Account information</legend>
                        <div class="form-group">
                            <label for="accountEmail">Email</label>
                            <input
                                class="form-control"
                                type="email"
                                id="accountEmail"
                                name="accounts[email]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="Email is requried"
                            />
                        </div>
                        <div class="form-group">
                            <label for="accountFirstName">First name</label>
                            <input
                                class="form-control"
                                type="text"
                                id="accountFirstName"
                                name="accounts[firstname]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="First name is requried"
                            />
                        </div>
                        <div class="form-group">
                            <label for="accountLastName">Last name</label>
                            <input
                                class="form-control"
                                type="text"
                                id="accountLastName"
                                name="accounts[lastname]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="Last name is requried"
                            />
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="male" name="accounts[gender]" class="custom-control-input" checked />
                                <label class="custom-control-label" for="male">Male</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="female" name="accounts[gender]" class="custom-control-input" />
                                <label class="custom-control-label" for="female">Female</label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Bank account</legend>
                        <div class="form-group">
                            <label for="bankAccountOwner">Owner's name of the bankaccount</label>
                            <input
                                class="form-control"
                                type="text"
                                id="bankAccountOwner"
                                name="bankAccount[bankAccountOwner]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="Bankaccount owner name is requried"
                            />
                        </div>
                        <div class="form-group">
                            <label for="bankAccountNumber">Bank account number (should be an IBAN)</label>
                            <input
                                class="form-control"
                                type="text"
                                id="bankAccountNumber"
                                name="bankAccount[bankAccountNumber]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="Bank account number is requried"
                            />
                        </div>
                        <div class="form-group">
                            <label for="bankAccountBIC">BIC or SWIFT code</label>
                            <input
                                class="form-control"
                                type="text"
                                id="bankAccountBIC"
                                name="bankAccount[bankAccountBIC]"
                                class="form-control"
                                data-form-check='1'
                                data-min-length="1"
                                data-error-message="BIC or SWIFT code is requried"
                            />
                        </div>
                    </fieldset>
                </div>
                <div id="errorContainer"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary"  value="Register" />
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function payNlRegistration(form) {
        if (!validateFormData(form)) return false;

        let url = globalVariables.ajax + 'payNlRegistration';

        sendFormAjaxRequest(form, url, 'payNlRegistration', payNlRegistrationResposne)

        return false;
    }

    function payNlRegistrationResposne(response) {
        if (response['status'] === '1') {
            $('#setPayNlServiceId').modal('hide');
            alertifyAjaxResponse(response);
        } else {
            showMessagesInContainer('errorContainer', response);
        }
    }

    $(document).ready(function(){
        // $('#setPayNlServiceId').modal('show');
        $('.alert').alert();
    });

</script>
