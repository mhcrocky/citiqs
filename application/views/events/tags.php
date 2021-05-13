
<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Add Tag'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#addEventTagModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#addEventTagModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="tags" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>


<!-- Add App Settings Modal -->
<div class="modal fade" id="addEventTagModal" tabindex="-1" role="dialog" aria-labelledby="addEventTagModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addEventTagModalLabel">Add Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST" novalidate>
                    <button id="submitForm" type="submit" class="btn btn-primary d-none">
                        Save Tag
                    </button>

                    <div class="form-group row">
                        <label for="tag" class="col-md-4 col-form-label text-md-left">
                        Tag
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="tag" class="input-w border-50 form-control" name="tag"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="userId" class="col-md-4 col-form-label text-md-left">
                            User ID
                        </label>
                        <div class="col-md-6">

                            <input type="number" id="userId" class="input-w border-50 form-control"
                                name="userId" required>
                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeTagModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="saveTag(this)" class="btn btn-primary">Save Tag</button>
            </div>
        </div>
    </div>
</div>



<!-- Edit Tag Modal -->
<div class="modal fade" id="editEventTagModal" tabindex="-1" role="dialog" aria-labelledby="editEventTagModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editEventTagModalLabel">Edit Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST" novalidate>
                    <button id="submitForm" type="submit" class="btn btn-primary d-none">
                        Save Tag
                    </button>

                    <input type="hidden" id="id" name="id">

                    <div class="form-group row">
                        <label for="editTag" class="col-md-4 col-form-label text-md-left">
                        Tag
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="editTag" class="input-w border-50 form-control" name="editTag"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editUserId" class="col-md-4 col-form-label text-md-left">
                            User ID
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="editUserId" class="input-w border-50 form-control"
                                name="editUserId" required>
                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeEditEventTagModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="updateTag(this)" class="btn btn-primary">Save Tag</button>
            </div>
        </div>
    </div>
</div>