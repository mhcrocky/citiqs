<div class="row mt-5 p-4">

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button"  value="<?php echo $this->language->tLine('Create Campaign'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#createCampaignModal">
            <span style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3" data-toggle="modal" data-target="#createCampaignModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
            </span>
        </div>
    </div>

</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="campaigns" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>




<!-- Create Campaign Modal -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" role="dialog" aria-labelledby="createCampaignModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <form id="campaign-form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="createCampaignModalLabel"><?php echo $this->language->tLine('Create Campaign'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group row">
                        <label for="campaign" class="col-md-4 col-form-label text-md-left m">
                            Campaign
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="campaign" name="campaign" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="campaign" class="col-md-4 col-form-label text-md-left">
                            Description
                        </label>
                        <div class="col-md-6">
                            <textarea rows="2" class="form-control" id="description" name="description">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="active" class="col-md-4 col-form-label text-md-left">
                            Active
                        </label>
                        <div class="col-md-6">

                            <select id="active" name="active"
                                class="form-control input-w">
                                <option value="" disabled>Select option</option>
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-left">
                            Email Template
                        </label>
                        <div class="col-md-6">

                            <select id="templateId" name="templateId"
                                class="form-control input-w" required>
                                <option value="">Select option</option>
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
                <button type="submit" class="btn btn-primary">Save Campaign</button>
            </div>
        </div>
    </form>
    </div>
</div>