
<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Create QRCode'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#addQRCodeModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#addQRCodeModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="qrcode" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>



<!-- Add Voucher Modal -->
<div class="modal fade" id="addQRCodeModal" tabindex="-1" role="dialog" aria-labelledby="addQRCodeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addQRCodeModalLabel"><?php echo $this->language->tline('Add QRCode'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST"
                    onsubmit="return save_qrcode(event)" novalidate>

                    <div class="form-group row">
                        <label for="spot" class="col-md-4 col-form-label text-md-left">
                            QRCode ID
                        </label>
                        <div class="col-md-6">

                            <input type="text" id="qr_codeId" class="input-w border-50 form-control"
                                name="qrcodeId">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spot" class="col-md-4 col-form-label text-md-left">Spot
                        </label>
                        <div class="col-md-6">
                            <select id="spot" name="spot" class="form-control input-w border-50 field">
                                <option value="">Select option</option>
                                <?php foreach($spots as $spot): ?>
                                <option value="<?php echo $spot['spotId']; ?>" >
                                <?php echo $spot['spotName']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

<!--                    <div class="form-group row">-->
<!--                        <label for="affiliate" class="col-md-4 col-form-label text-md-left">-->
<!--                            Affiliate-->
<!--                        </label>-->
<!--                        <div class="col-md-6">-->
<!---->
<!--                            <input type="text" id="affiliate" class="input-w border-50 form-control"-->
<!--                                name="affiliate">-->
<!--                        </div>-->
<!--                    </div>-->



                    <input type="reset" id="resetForm" class="d-none" value="Reset">
                    <input type="submit" class="d-none" id="submitQrcode" value="Submit">

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeaddQRCodeModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="qrcodeForm()" class="btn btn-primary">Save QRCode</button>
            </div>
        </div>
    </div>
</div>



<!-- Edit Qrcode Spot Modal -->
<div class="modal fade" id="editQRCodeModal" tabindex="-1" role="dialog" aria-labelledby="editQRCodeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editQRCodeModalLabel">Edit QRCode Spot</h5>
                <button type="button" class="close" id="closeEditModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST">

                    <div class="form-group row">
                        <label for="editspot" class="col-md-4 col-form-label text-md-left">Spot
                        </label>
                        <div class="col-md-6">
                            <input type="hidden" id="qrcodeId" name="id">
                            <select id="editspot" name="spot" class="form-control input-w border-50 field">
                                <option value="">Select option</option>
                                <?php foreach($spots as $spot): ?>
                                <option value="<?php echo $spot['spotId']; ?>" >
                                <?php echo $spot['spotName']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeaddQRCodeModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="update_qrcode()" class="btn btn-primary">Save QRCode</button>
            </div>
        </div>
    </div>
</div>
