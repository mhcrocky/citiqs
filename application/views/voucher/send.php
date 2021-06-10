<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Send Voucher'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#addVoucherModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#addVoucherModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="vouchersend" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>



<!-- Add Voucher Modal -->
<div class="modal fade" id="addVoucherModal" tabindex="-1" role="dialog" aria-labelledby="addVoucherModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addVoucherModalLabel">Send Voucher</h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form
                    name="my-form"
                    id="my-form"
                    class="needs-validation"
                    action="#"
                    method="POST"
                    onsubmit="return save_vouchersend(event)"
                    novalidate
                >
                    <button style="display: none;" id="submitForm" type="submit" class="btn btn-primary">Save
                        Voucher</button>


                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-left">
                            Name
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="name" class="input-w border-50 form-control"
                                name="name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-left">
                            Email
                        </label>
                        <div class="col-md-6">

                            <input type="email" id="email" class="input-w border-50 form-control"
                                name="email" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Voucher
                        </label>
                        <div class="col-md-6">
                            <select id="voucherId" name="voucherId" class="form-control input-w border-50 field">
                                <?php if(isset($vouchers) && is_array($vouchers)): ?>
                                <?php foreach($vouchers as $voucher): ?>
                                <option
                                    id="option_<?php echo $voucher['id']; ?>"
                                    value="<?php echo $voucher['id']; ?>"
                                    data-times="<?php echo intval($voucher['numberOfTimes']) - intval($voucher['voucherused']); ?>"
                                >
                                    <?php echo $voucher['description']; ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?> 
                            </select>
                        </div>
                    </div>

                    <input type="reset" id="resetForm" class="d-none" value="Reset">
                    <input type="submit" class="d-none" id="submitVoucherSend" value="Reset">

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeAddVoucherModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="vouchersendForm()" class="btn btn-primary">Save Voucher</button>
            </div>
        </div>
    </div>
</div>
