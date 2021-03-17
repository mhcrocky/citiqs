<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Add Voucher'); ?>" style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#addVoucherModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#addVoucherModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Add Email Template'); ?>"
                style="background: #3498eb !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal"
                data-target="#emailTemplateModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#emailTemplateModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" onclick="redirectToTemplates()" value="<?php echo $this->language->tline('Email Templates List'); ?>"
                style="background: #a87732 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="redirectToTemplates()" style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-bars"></i>
            </span>
        </div>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="voucher" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>

<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Update Email Templates'); ?>" style="background: #3498eb !important;border-radius:0;height:45px;"
             class="btn btn-primary form-control mb-3 text-left"
             data-toggle="modal" data-target="#editVoucherTemplateModal">
             <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#editVoucherTemplateModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Activated'); ?>"
                style="background: #007bff !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" onclick="updateActivated(1)">
                <input type="button" value="<?php echo $this->language->tline('Deactivate') ?>"
                style="background: #ffc72a !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left text-dark" onclick="updateActivated(0)">
            </span>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" onclick="deleteVouchers()" value="<?php echo $this->language->tline('Delete Selected Vouchers'); ?>"
                style="background: #d9534f !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="deleteVouchers()" style="background: #6b1d18; padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-trash"></i>
            </span>
        </div>
    </div>
</div>


<!-- Add Voucher Modal -->
<div class="modal fade" id="addVoucherModal" tabindex="-1" role="dialog" aria-labelledby="addVoucherModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addVoucherModalLabel">Create Vouchers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST"
                    onsubmit="return saveVoucher(event)" novalidate>
                    <button style="display: none;" id="submitForm" type="submit" class="btn btn-primary">Save
                        Voucher</button>

                    <input type="hidden" id="vendorId" name="vendorId" value="<?php echo $vendorId; ?>">
                    <input type="hidden" id="active" name="active" value="1">


                    <div class="form-group row">
                        <label for="event-name" class="col-md-4 col-form-label text-md-left">Number of Voucher to
                            make</label>
                        <div class="col-md-6">

                            <input type="number" id="codes" class="input-w border-50 form-control" name="codes"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-left">
                            Voucher Description
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="description" class="input-w border-50 form-control"
                                name="description" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Voucher Code
                        </label>
                        <div class="col-md-6">
                            <select id="status" onchange="voucherCode()" name="status"
                                class="form-control input-w border-50 field">
                                <option value="" disabled>Select option</option>
                                <option value="unique" selected>Unique</option>
                                <option value="same">Same</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: none" id="voucher_code" class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Code
                        </label>
                        <div class="col-md-6" id="code_input">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="percent" class="col-md-4 col-form-label text-md-left">Percent</label>
                        <div class="col-md-6">

                            <input type="number" id="percent" class="input-w border-50 form-control" name="percent"
                                onchange="disabledField(this, 'amount')" required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="percentUsed" class="col-md-4 col-form-label text-md-left">Percent
                            Used</label>
                        <div class="col-md-6">
                            <select id="percentUsed" name="percentUsed" class="form-control input-w border-50 field">
                                <option value="" disabled>Select option</option>
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="expire" class="col-md-4 col-form-label text-md-left">Expire</label>
                        <div class="col-md-6">

                            <input type="date" id="expire" class="input-w border-50 form-control" name="expire"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-left">Amount</label>
                        <div class="col-md-6">

                            <input type="number" id="amount" class="input-w border-50 form-control" name="amount"
                                onchange="disabledField(this, 'percent')" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Email Template
                        </label>
                        <div class="col-md-6">
                            <select id="emailId" name="emailId"
                                class="form-control input-w border-50 field">
                                <option value="">Select option</option>
                                <?php foreach($emails as $email): ?>
                                <option value="<?php echo $email['id']; ?>"><?php echo $email['template_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="productId" class="col-md-4 col-form-label text-md-left">Product Id</label>
                        <div class="col-md-6">


                            <select id="productId" class="js-select2 form-control input-w border-50 w-100"
                                name="productId">
                                <option value="" disabled selected>Select product</option>
                                <?php foreach($products as $product): ?>
                                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeAddVoucherModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="voucherForm()" class="btn btn-primary">Save Voucher</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Voucher Email Template Modal -->
<div class="modal fade" id="editVoucherTemplateModal" tabindex="-1" role="dialog" aria-labelledby="editVoucherTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editVoucherTemplateModalLabel">Edit Email Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">Email Template</label>
                    <div class="col-md-6">
                        <select id="emailTemplate" name="emailTemplate"
                                class="form-control input-w border-50 field">
                            <option value="">Select option</option>
                            <?php foreach($emails as $email): ?>
                            <option value="<?php echo $email['id']; ?>"><?php echo $email['template_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeEditVoucherTemplateModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="updateEmailTemplates()" class="btn btn-primary">Save Voucher</button>
            </div>
        </div>
    </div>
</div>


<!-- Email Template Modal -->
<div class="modal fade" id="emailTemplateModal" tabindex="-1" role="dialog" aria-labelledby="emailTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="emailTemplateModalLabel">Choose Email Template
                </h5>
                <button type="button" class="close" id="closeEmailTemplate" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select style="display: none;" id="selectTemplateName" class="form-control">
                    <option value="">Select template</option>
                </select>
                <label for="customTemplateName">Template Name</label>
                <input type="text" id="customTemplateName" name="templateName" class="form-control"
                    value="<?php echo $templateName; ?>" />
                <br />
                <label for="templateType">Template Type</label>
                <select class="form-control w-100" id="templateType" name="templateType">
                    <option value="" disabled>Select type</option>
                    <option value="general">General</option>
                    <option value="reservations">Reservations</option>
                    <option value="tickets">Tickets</option>
                    <option value="vouchers" selected>Vouchers</option>
                </select>
                <br />
                <label for="templateHtml">Edit template</label>
                <textarea id="templateHtml" name="templateHtml"></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="emailTemplateClose"
                    data-dismiss="modal">Close</button>
                <button type="submit" onclick="saveVoucherTemplate();" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

const templateGlobals = (function() {
    let globals = {
        'templateHtmlId': 'templateHtml',
    }
    <?php if (!empty($templateContent)) { ?>
    globals['templateContent'] = `<?php echo $templateContent; ?>`
    <?php } ?>
    <?php if (!empty($templateId)) { ?>
    globals['templateId'] = '<?php echo $templateId; ?>'
    <?php } ?>


    Object.freeze(globals);

    return globals;
}());


</script>