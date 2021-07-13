
<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Add Input'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#addEventInputModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#addEventInputModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="inputs" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>


<!-- Add Event Input Modal -->
<div class="modal fade" id="addEventInputModal" tabindex="-1" role="dialog" aria-labelledby="addEventInputModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addEventInputModalLabel">Add Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST" novalidate>
                    <button id="submitForm" type="submit" class="btn btn-primary d-none">
                        Save Input
                    </button>

                    <input type="hidden" id="eventId" value="<?php echo $eventId; ?>">

                    <div class="form-group row">
                        <label for="fieldName" class="col-md-4 col-form-label text-md-left">
                        Input Name
                        </label>
                        <div class="col-md-6">

                            <input style="border-radius: 0px;" type="text" id="fieldName" class="input-w border-50 form-control" name="fieldName"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fieldLabel" class="col-md-4 col-form-label text-md-left">
                        Input Label
                        </label>
                        <div class="col-md-6">

                            <input style="border-radius: 0px;" type="text" id="fieldLabel" class="input-w border-50 form-control" name="fieldLabel"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fieldType" class="col-md-4 col-form-label text-md-left">
                        Input Type
                        </label>
                        <div class="col-md-6">

                        <select id="fieldType" name="fieldType"
                            class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="text" selected>Text</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="requiredField" class="col-md-4 col-form-label text-md-left">
                        Required
                        </label>
                        <div class="col-md-6">

                        <select id="requiredField" name="requiredField"
                            class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="1">Yes</option>
                            <option value="0" selected>No</option>
                        </select>
                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeTagModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="saveInput(this)" class="btn btn-primary">Save Input</button>
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
                <h5 class="modal-title font-weight-bold text-dark" id="editEventTagModalLabel">Edit Input</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST" novalidate>

                    <input type="hidden" id="id" name="id">

                    <div class="form-group row">
                        <label for="editFieldName" class="col-md-4 col-form-label text-md-left">
                        Input Name
                        </label>
                        <div class="col-md-6">

                            <input style="border-radius: 0px !important;" type="text" id="editFieldName" class="input-w border-50 form-control" name="editFieldName"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editFieldLabel" class="col-md-4 col-form-label text-md-left">
                        Input Label
                        </label>
                        <div class="col-md-6">

                            <input style="border-radius: 0px;" type="text" id="editFieldLabel" class="input-w border-50 form-control" name="editFieldLabel"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editFieldType" class="col-md-4 col-form-label text-md-left">
                        Input Type
                        </label>
                        <div class="col-md-6">

                        <select id="editFieldType" name="editFieldType"
                            class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="text" selected>Text</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editRequiredField" class="col-md-4 col-form-label text-md-left">
                        Required
                        </label>
                        <div class="col-md-6">

                        <select id="editRequiredField" name="editRequiredField"
                            class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="1">Yes</option>
                            <option value="0" selected>No</option>
                        </select>
                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeEditEventTagModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="updateInput(this)" class="btn btn-primary">Save Input</button>
            </div>
        </div>
    </div>
</div>