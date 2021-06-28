<div class="row mt-5 p-4">

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button"  value="<?php echo $this->language->tLine('Create Campaign List'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#createCampaignListModal">
            <span style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3" data-toggle="modal" data-target="#createCampaignListModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
            </span>
        </div>
    </div>

</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="campaignslists" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>




<!-- Create Campaign Modal -->
<div class="modal fade" id="createCampaignListModal" tabindex="-1" role="dialog" aria-labelledby="createCampaignListModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <form id="campaign-list-form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="createCampaignListModalLabel"><?php echo $this->language->tLine('Create Campaign'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group row">
                        <label for="campaignId" class="col-md-4 col-form-label text-md-left">
                            Campaign
                        </label>
                        <div class="col-md-6">

                            <select id="campaignId" name="campaignId"
                                class="form-control input-w" required>
                                <option value="">Select option</option>
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

                    <div class="form-group row">
                        <label for="listId" class="col-md-4 col-form-label text-md-left">
                            List
                        </label>
                        <div class="col-md-6">

                            <select id="listId" name="listId"
                                class="form-control input-w" required>
                                <option value="">Select option</option>
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
                <button type="submit" class="btn btn-primary">Save Campaign List</button>
            </div>
        </div>
    </form>
    </div>
</div>