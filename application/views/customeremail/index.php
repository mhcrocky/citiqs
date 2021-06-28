<div class="row mt-5 p-4">

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button"  value="<?php echo $this->language->tLine('Send Emails Campaign'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#sendEmailsToCampaign" >
            <span style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope" data-toggle="modal" data-target="#sendEmailsToCampaign" ></i>
            </span>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button"  value="<?php echo $this->language->tLine('Go To Email Lists'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" onclick="goToEmailLists()" >
            <span style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope" onclick="goToEmailLists()" ></i>
            </span>
        </div>
    </div>

</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="customeremail" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>

<div class="row mt-5 p-4">

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" onclick="saveEmailsListModal()"
                value="<?php echo $this->language->tLine('Save Emails To List'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="saveEmailsListModal()" style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
            </span>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" onclick="sendMultipleEmailsModal()"
                value="<?php echo $this->language->tLine('Send Multiple Emails'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="sendMultipleEmailsModal()" style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
            </span>
        </div>
    </div>


    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button"  value="<?php echo $this->language->tLine('Import Emails'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#importEmailsModal">
            <span style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3" data-toggle="modal" data-target="#importEmailsModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
            </span>
        </div>
    </div>

</div>


<!-- Import Excel File Modal -->
<div class="modal fade text-left" id="importEmailsModal" tabindex="-1" role="dialog" aria-labelledby="importEmailsModalLabel"
    aria-hidden="true">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row d-flex justify-content-left mr-auto mb-0 pb-0 border-0">
                <div class="tabs show" id="tab01">
                    <h6 class="text-muted">Import</h6>
                </div>


            </div>
            <div class="line"></div>
            <div class="modal-body p-0">

                <fieldset class="show" id="tab011">


                    <form id="fileForm" action="" method="post" class="mt-5 upload-excel-file" enctype="multipart/form-data">
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
                                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                    onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''">
                                                Select a file
                                            </div>
                                        </span>
                                    </div>
                                    <div class="w-100 mt-2 p-1 text-right">
                                        <input type="submit" name="submit" id="upload-file"
                                            class="btn btn-success d-none" value="Upload">
                                        <input type="reset" id="resetUpload" class="btn btn-success d-none"
                                            value="Upload">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="w-100 filterFormSection d-none" id="filterFormSection">
                        <form action="#" method="POST" class="w-100" id="filterForm"
                            onsubmit="return import_csv(event)">
                            <div class="w-100 mt-5" id="DrpDwn">
                                <div class="d-flex col-md-10 align-items-center mb-3 mx-auto">
                                    <label class="col-md-3 mr-3" for="importName">Name: </label>
                                    <select id="importName" name="importName"
                                        class="col-md-9 filterSelection form-control">
                                        <option value="">Select Option</option>
                                    </select>
                                </div>
                                <div class="d-flex col-md-10 align-items-center mb-3 mx-auto">
                                    <label class="col-md-3 mr-3" for="importEmail">Email: </label>
                                    <select id="importEmail" name="importEmail"
                                        class="col-md-9 filterSelection form-control">
                                        <option value="">Select Option</option>
                                    </select>
                                </div>

                            </div>

                        </form>


                    </div>

                    <pre class="d-none" id="jsonData"></pre>


                </fieldset>
            </div>
            <div class="line"></div>
            <div class="modal-footer">
                <fieldset class="show" id="tab022">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="uploadExcel" class="btn btn-primary upload-excel-file">Upload
                        File</button>
                    <button type="button" onclick="goBackToUpload()"
                        class="btn btn-warning filterFormSection d-none">Go Back</button>
                    <button type="submit" onclick="importExcelFile()" id="importExcelFile"
                        class="btn btn-primary filterFormSection d-none">Import Excel File</button>
                </fieldset>
            </div>
        </div>
    </div>
</div> 


<!-- Send Emails Modal -->
<div class="modal fade" id="sendEmailsModal" tabindex="-1" role="dialog" aria-labelledby="sendEmailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="sendEmailsModalLabel"><?php echo $this->language->tLine('Send Multiple Emails'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-left">
                            Campaign
                        </label>
                        <div class="col-md-6">

                            <select id="campaignId" name="campaignId" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w">
                                <option value="0">Select option</option>
                                <?php if(is_array($campaigns) && count($campaigns) > 0): ?>
                                <?php foreach($campaigns as $campaign): ?>
                                <option value="<?php echo $campaign['id']; ?>">
                                    <?php echo $campaign['campaign']; ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="closeEmailModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="sendMultipleEmails()" class="btn btn-primary">Send Email</button>
            </div>
        </div>
    </div>
</div>



<!-- Send Emails Modal -->
<div class="modal fade" id="sendEmailsToCampaign" tabindex="-1" role="dialog" aria-labelledby="sendEmailsToCampaignLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="sendEmailsToCampaignLabel"><?php echo $this->language->tLine('Send Emails To Campaign'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-left">
                            Campaign
                        </label>
                        <div class="col-md-6">

                            <select id="campaign" name="campaign" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w">
                                <option value="0">Select option</option>
                                <?php if(is_array($campaigns) && count($campaigns) > 0): ?>
                                <?php foreach($campaigns as $campaign): ?>
                                <option value="<?php echo $campaign['id']; ?>">
                                    <?php echo $campaign['campaign']; ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="closeEmailModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="sendCampaignEmails()" class="btn btn-primary">Send Email</button>
            </div>
        </div>
    </div>
</div>



<!-- Save Emails List Modal -->
<div class="modal fade" id="saveEmailsListModal" tabindex="-1" role="dialog" aria-labelledby="saveEmailsListModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="saveEmailsListModalLabel"><?php echo $this->language->tLine('Create Emails List'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group row">
                        <label for="list" class="col-md-4 col-form-label text-md-left">
                            List
                        </label>
                        <div class="col-md-6">

                            <select id="listId" name="listId" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w">
                                <option value="0">Select option</option>
                                <?php if(is_array($lists) && count($lists) > 0): ?>
                                <?php foreach($lists as $list): ?>
                                <option value="<?php echo $list['id']; ?>">
                                    <?php echo $list['list']; ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="closeEmailModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="saveEmailsList()" class="btn btn-primary">Save Emails List</button>
            </div>
        </div>
    </div>
</div>


