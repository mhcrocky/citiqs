
<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Add App Settings'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#addAppSettingsModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#addAppSettingsModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="appsettings" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>


<!-- Add App Settings Modal -->
<div class="modal fade" id="addAppSettingsModal" tabindex="-1" role="dialog" aria-labelledby="addAppSettingsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addAppSettingsModalLabel">Create App Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST" novalidate>
                    <button id="submitForm" type="submit" class="btn btn-primary d-none">
                        Save App Settings
                    </button>

                    <div class="form-group row">
                        <label for="merchandise" class="col-md-4 col-form-label text-md-left">
                        Merchandise
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="merchandise" class="input-w border-50 form-control" name="merchandise"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ticketshop" class="col-md-4 col-form-label text-md-left">
                            Ticketshop
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="ticketshop" class="input-w border-50 form-control"
                                name="ticketshop" required>
                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeAppSettingsModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="saveAppSettings(this)" class="btn btn-primary">Save App Settings</button>
            </div>
        </div>
    </div>
</div>



<!-- Edit App Settings Modal -->
<div class="modal fade" id="editAppSettingsModal" tabindex="-1" role="dialog" aria-labelledby="editAppSettingsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editAppSettingsModalLabel">Edit App Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST" novalidate>
                    <button id="submitForm" type="submit" class="btn btn-primary d-none">
                        Save App Settings
                    </button>

                    <input type="hidden" id="id" name="id">

                    <div class="form-group row">
                        <label for="merchandise" class="col-md-4 col-form-label text-md-left">
                        Merchandise
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="editMerchandise" class="input-w border-50 form-control" name="merchandise"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ticketshop" class="col-md-4 col-form-label text-md-left">
                            Ticketshop
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="editTicketshop" class="input-w border-50 form-control"
                                name="ticketshop" required>
                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeEditAppSettingsModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="updateAppSettings(this)" class="btn btn-primary">Save App Settings</button>
            </div>
        </div>
    </div>
</div>