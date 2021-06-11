<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Add Voucher'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
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
            <input type="button" onclick="redirectToTemplates()"
                value="<?php echo $this->language->tline('Email Templates List'); ?>"
                style="background: #a87732 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="redirectToTemplates()" style="background: #275C5D;padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
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
    <!--
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Update Email Templates'); ?>"
                style="background: #3498eb !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal"
                data-target="#editVoucherTemplateModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#editVoucherTemplateModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
        </div>
    </div>
    -->

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Send Vouchers'); ?>"
                style="background: #007bff !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" onclick="vouchersendModal()" 
                data-toggle="modal" data-target="#sendVoucherModal">

            <input type="button"
                value="<?php echo $this->language->tline('Update Email Templates'); ?>"
                style="background: #3498eb !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal"
                data-target="#editVoucherTemplateModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#editVoucherTemplateModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
            </span>
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
            <input type="button" onclick="deleteVouchers()"
                value="<?php echo $this->language->tline('Delete Selected Vouchers'); ?>"
                style="background: #d9534f !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="deleteVouchers()" style="background: #6b1d18; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
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
                    <input type="hidden" id="vendorId" name="vendorId" value="<?php echo $vendorId; ?>" />
                    <input type="hidden" id="active" name="active" value="1" />
                    <div class="form-group row">
                        <label for="productGroup" class="col-md-4 col-form-label text-md-left">Select product
                            group</label>
                        <div class="col-md-6">
                            <select id="productGroup" name="productGroup" class="form-control form-input input-w border-50 field">
                                <option value="">Select option</option>
                                <?php foreach ($productGroups as $group) { ?>
                                <option value="<?php echo $group; ?>"><?php echo $group; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="event-name" class="col-md-4 col-form-label text-md-left">
                            Number of Voucher to make
                        </label>
                        <div class="col-md-6">
                            <input type="number" id="codes" class="input-w border-50 form-control form-input" name="codes"
                                required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-left">
                            Voucher Description
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="description" class="input-w border-50 form-control form-input"
                                name="description" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Voucher Code</label>
                        <div class="col-md-6">
                            <select id="status" onchange="voucherCode()" name="status"
                                class="form-control form-input input-w border-50 field">
                                <option value="" disabled>Select option</option>
                                <option value="unique" selected>Unique</option>
                                <option value="same">Same</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: none" id="voucher_code" class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Code </label>
                        <div class="col-md-6" id="code_input"></div>
                    </div>

                    <div class="form-group row">
                        <label for="percent" class="col-md-4 col-form-label text-md-left">Percent</label>
                        <div class="col-md-6">
                            <input type="number" id="percent" class="input-w border-50 form-control form-input" name="percent"
                                onchange="disabledField(this, 'amount')" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="expire" class="col-md-4 col-form-label text-md-left">Expire</label>
                        <div class="col-md-6">

                            <input type="date" id="expire" class="input-w border-50 form-control form-input" name="expire"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-left">Amount</label>
                        <div class="col-md-6">

                            <input type="number" step="0.01" id="amount" class="input-w border-50 form-control form-input"
                                name="amount" onchange="disabledField(this, 'percent')" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Email Template
                        </label>
                        <div class="col-md-6">
                            <select id="emailId" name="emailId" class="form-control form-input input-w border-50 field">
                                <option value="">Select option</option>
                                <?php foreach($emails as $email): ?>
                                <option value="<?php echo $email['id']; ?>"><?php echo $email['template_name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="productId" class="col-md-4 col-form-label text-md-left">Product Id</label>
                        <div class="col-md-6">


                            <select id="productId" class="js-select2 form-control form-input input-w border-50 w-100"
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
<div class="modal fade" id="editVoucherTemplateModal" tabindex="-1" role="dialog"
    aria-labelledby="editVoucherTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editVoucherTemplateModalLabel">Edit Email
                    Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">Email Template</label>
                    <div class="col-md-6">
                        <select id="emailTemplate" name="emailTemplate" class="form-control input-w border-50 field">
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
                <label for="customTemplateSubject">Subject</label>
                <input type="text" id="customTemplateSubject" name="templateSubject" class="form-control" />
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


<!-- Upload CSV File -->
<div class="modal fade" id="uploadCsvModal" tabindex="-1" role="dialog" aria-labelledby="uploadCsvModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="emailTemplateModalLabel">
                    Import CSV File
                </h5>
                <button type="button" class="close" id="closeEmailTemplate" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="fileForm" action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="form-group">
                                <label for="file" class="sr-only">File</label>
                                <div class="input-group mx-auto">
                                    <input style="height:40px !important;" type="text" id="filename" name="filename"
                                        class="form-control" value="" placeholder="No file selected" readonly="">
                                    <span class="input-group-btn">
                                        <div style="height:40px;border-top-left-radius: 0 !important;border-bottom-left-radius: 0 !important; padding-top: 8px;"
                                            class="btn btn-secondary custom-file-uploader">
                                            <input type="file" id="userfile" name="userfile"
                                                onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''">
                                            Select a file
                                        </div>
                                    </span>
                                </div>
                                <div class="w-100 mt-2 p-1 text-right">
                                    <input type="submit" name="submit" id="upload-file" class="btn btn-success d-none"
                                        value="Upload">
                                    <input type="reset" id="resetUpload" class="btn btn-success d-none" value="Upload">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="w-100 d-none" id="filterFormSection">
                    <form action="#" method="POST" class="w-100" id="filterForm" onsubmit="return import_csv(event)">
                        <div class="w-100" id="DrpDwn">
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="code">Code: </label>
                                <select id="csvcode" name="code" class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="description">Description: </label>
                                <select id="csvdescription" name="description"
                                    class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="code">Amount: </label>
                                <select id="csvamount" name="amount" class="col-md-9 filterSelection form-control">
                                    <<option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="code">Percent: </label>
                                <select id="csvpercent" name="percent" class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="code">Percent Used: </label>
                                <select id="csvpercentUsed" name="percentUsed"
                                    class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="code">Expire: </label>
                                <select id="csvexpire" name="expire" class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="active">Expire: </label>
                                <select id="csvactive" name="active" class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="numberOfTimes">Number Of Times: </label>
                                <select id="csvnumberOfTimes" name="numberOfTimes"
                                    class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="activated">Activated: </label>
                                <select id="csvactivated" name="activated"
                                    class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>

                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="productId">Product Id: </label>
                                <select id="csvproductId" name="productId"
                                    class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>

                            <div class="d-flex col-md-12 align-items-center mb-3">
                                <label class="col-md-3 mr-3" for="emailId">Email Id: </label>
                                <select id="csvemailId" name="emailId" class="col-md-9 filterSelection form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <input type="hidden" name="csv_path" id="csv_path">
                            <input type="submit" id="filterBtn" class="d-none" value="Get Result">
                        </div>

                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="emailTemplateClose"
                        data-dismiss="modal">Close</button>
                    <button type="submit" onclick="uploadCsvFile()" id="uploadCsvFile" class="btn btn-primary">Upload
                        File</button>
                    <button type="submit" onclick="importCsvFile()" id="importCsvFile"
                        class="btn btn-primary d-none">Import CSV File</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Send Voucher Modal -->
<div class="modal fade" id="sendVoucherModal" tabindex="-1" role="dialog" aria-labelledby="sendVoucherModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="sendVoucherModalLabel">Send Vouchers</h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST"
                    onsubmit="return save_vouchersend(event)" novalidate>
                    <button style="display: none;" id="submitForm" type="submit" class="btn btn-primary">Save
                        Voucher</button>
                    <div id="reachedMaxTimes" class="form-group row p-2 mb-3">

                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-left">
                            Name
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="name" class="input-w border-50 form-control form-vouchersend" name="name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-left">
                            Email
                        </label>
                        <div class="col-md-6">

                            <input type="email" id="email" class="input-w border-50 form-control form-vouchersend" name="email" required>
                        </div>
                    </div>


                    <input type="reset" id="resetVoucherSendForm" class="d-none" value="Reset">
                    <input type="submit" class="d-none" id="submitVoucherSend" value="Reset">

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeVoucherSendModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="vouchersendForm()" class="btn btn-primary">Send Vouchers</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
const emailsTemplates = `<?php echo json_encode($emails); ?>`;
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

$(document).ready(function() {
    $("#fileForm").on("submit", function(e) {
        e.preventDefault();
        let filename = $("#filename").val();
        let file = filename.split(".");
        let ext = file[1];
        if (ext != 'csv' && ext != 'CSV') {

            alertify['error']('The filetype you are attempting to upload is not allowed!');
        }

        var formData = new FormData(this);
        formData.append('userfile', $("#userfile")[0].files[0]);

        $.ajax({
            url: globalVariables.baseUrl + "Api/Voucher/upload_csv",
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                data = JSON.parse(data);
                var header = '';
                var html = '';
                var arr = [];
                var arrLen = data.length - 1;
                var csv_path = data[arrLen];

                $('#csv_path').val(csv_path);
                for (var i = 0; i < arrLen; i++) {
                    if (data[i].replaceAll('"', '').length > 0) {
                        html += '<option value="' + i + '">' + data[i].replaceAll('"',
                            '') + '</option>';
                        arr[i] = lcfirst(data[i].replaceAll('"', '').replaceAll(' ',
                            ''));
                    }

                }

                $('.filterSelection').html(html);
                $.each(arr, function(index, value) {
                    console.log(value);
                    $('#csv' + value).val(index);
                });

                $('#fileForm').addClass('d-none');
                $('#filterFormSection').removeClass('d-none');
                $('#uploadCsvFile').addClass('d-none');
                $('#importCsvFile').removeClass('d-none');

            },
            error: function(data) {
                let error = data.responseJSON;
                alertify['error']('Something went wrong!');
            }
        });

    });
});

function lcfirst(str) {
    str += '';
    const f = str.charAt(0).toLowerCase();
    return f + str.substr(1);
}

function uploadCsvFile() {
    $('#upload-file').click();
    return;
}

function importCsvFile() {
    $('#filterBtn').click();
    return;
}

function import_csv(e) {
    e.preventDefault();
    let data = {
        code: $('#csvcode option:selected').val(),
        description: $('#csvdescription option:selected').val(),
        amount: $('#csvamount option:selected').val(),
        percent: $('#csvpercent option:selected').val(),
        percentUsed: $('#csvpercentUsed option:selected').val(),
        expire: $('#csvexpire option:selected').val(),
        active: $('#csvactive option:selected').val(),
        numberOfTimes: $('#csvnumberOfTimes option:selected').val(),
        activated: $('#csvactivated option:selected').val(),
        productId: $('#csvproductId option:selected').val(),
        emailId: $('#csvemailId option:selected').val(),
        csv_path: encodeURI($('#csv_path').val())
    }

    //console.log(data);

    $.post(globalVariables.baseUrl + "Api/Voucher/import_csv", data, function(data) {
        $('#voucher').DataTable().ajax.reload();
        $('#resetUpload').click();
        $('#fileForm').removeClass('d-none');
        $('#filterFormSection').addClass('d-none');
        $('#uploadCsvFile').removeClass('d-none');
        $('#importCsvFile').addClass('d-none');
        $('#uploadCsvModal').modal('toggle');
    });

}
</script>