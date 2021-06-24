

<div class="w-100 mt-3 table-responsive p-4">
    <table id="marketing" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>

<div class="row mt-5 p-4">
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
                            Email Template
                        </label>
                        <div class="col-md-6">

                            <select id="templateId" name="templateId" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w">
                                <option value="0">Select option</option>
                                <?php if(is_array($templates) && count($templates) > 0): ?>
                                <?php foreach($templates as $template): ?>
                                <option value="<?php echo $template->id; ?>">
                                    <?php echo $template->template_name; ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                        </div>
                    </div>

                    <div class="d-none" id="reservationIds">
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
