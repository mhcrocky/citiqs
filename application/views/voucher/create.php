<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="background: none;" class="card p-4">

                    <div class="card-body">
                        <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST"
                            onsubmit="return saveVoucher(event)" novalidate>
                            <div class="form-group row">
                                <label for="full_name" class="col-md-4 col-form-label text-md-left">
                                    <h3>
                                        <strong>Create vouchers</strong>
                                    </h3>
                                </label>
                                <div class="col-md-6">

                                </div>
                            </div>

                            <input type="hidden" id="vendorId" name="vendorId" value="<?php echo $vendorId; ?>">
                            <input type="hidden" id="active" name="active" value="1">


                            <div class="form-group row">
                                <label for="event-name" class="col-md-4 col-form-label text-md-left">
                                    Number of Voucher to make</label>
                                <div class="col-md-6">

                                    <input type="number" id="codes" class="input-w border-50 form-control" name="codes"
                                        required>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-left">
                                    Voucher Description
                                </label>
                                <div class="col-md-6">

                                    <input type="text" id="description" class="input-w border-50 form-control"
                                        name="description" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-left">Voucher Code
                                </label>
                                <div class="col-md-6">
                                    <select id="status" onchange="voucherCode()" name="status"
                                        class="form-control input-w border-50 field">
                                        <option value="" disabled>Select option</option>
                                        <option value="unique" selected>Unique</option>
                                        <option value="same">Same</option>
                                    </select>
                                </div>
                            </div>

                            <div style="display: none" id="voucher_code" class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-left">Code
                                </label>
                                <div class="col-md-6" id="code_input">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="percent" class="col-md-4 col-form-label text-md-left">Percent</label>
                                <div class="col-md-6">

                                    <input type="number" id="percent" class="input-w border-50 form-control"
                                        name="percent" onchange="disabledField(this, 'amount')" required>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="percentUsed" class="col-md-4 col-form-label text-md-left">Percent
                                    Used</label>
                                <div class="col-md-6">
                                    <select id="percentUsed" name="percentUsed"
                                        class="form-control input-w border-50 field">
                                        <option value="" disabled>Select option</option>
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="expire" class="col-md-4 col-form-label text-md-left">Expire</label>
                                <div class="col-md-6">

                                    <input type="date" id="expire" class="input-w border-50 form-control" name="expire"
                                        required>

                                </div>
                            </div>

                            <!--
                            <div class="form-group row">
                                <label for="active" class="col-md-4 col-form-label text-md-left">Active
                                </label>
                                <div class="col-md-6">
                                    <select id="active" name="active" class="form-control input-w border-50 field">
                                        <option value="" disabled>Select option</option>
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            -->


                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-left">Amount</label>
                                <div class="col-md-6">

                                    <input type="number" id="amount" class="input-w border-50 form-control"
                                        name="amount" onchange="disabledField(this, 'percent')" required>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="productId" class="col-md-4 col-form-label text-md-left">Product Id</label>
                                <div class="col-md-6">


                                    <select id="productId" class="js-select2 form-control input-w border-50"
                                        name="productId">
                                        <option value="" disabled selected>Select product</option>
                                        <?php foreach($products as $product): ?>
                                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">&nbsp</label>
                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary btn-block text-center border-50 p-2">
                                        Save Voucher
                                    </button>

                                </div>
                            </div>


                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('.js-select2').select2({
            placeholder: "Select product",
            allowClear: true,
        });

        $('b[role="presentation"]').hide();
        $('.select2-selection__arrow').append('<i class="fa fa-sort-desc"></i>');
    });

    function voucherCode() {
        let val = $('#status option:selected').val();
        if (val != 'unique') {
            $("#code_input").append(
                '<input type="text" id="code" class="input-w border-50 form-control" name="code" required>');
            $("#voucher_code").fadeIn("slow", function() {
                $('#voucher_code').show();
            });

        } else {
            $("#voucher_code").fadeIn("slow", function() {
                $('#voucher_code').hide();
                $("#code_input").empty()
            });
        }
    }

    function saveVoucher(e) {
        e.preventDefault();
        if ($('.form-control:invalid').length > 0) {
            return;
        }

        let data = {
            vendorId: $('#vendorId').val(),
            codes: $('#codes').val(),
            description: $('#description').val(),
            status: $('#status option:selected').val(),
            percentUsed: $('#percentUsed option:selected').val(),
            expire: $('#expire').val(),
            active: $('#active').val(),
            productId: $('#productId').find(':selected').val(),
        }

        if ($('#code').length > 0) {
            data.code = $('#code').val();
        }

        let amount = $('#amount').val();
        let productId = $('#productId').find(':selected').val();

        if (amount === "") {
            data.percent = $('#percent').val();
        } else {
            data.amount = $('#amount').val();
        }

        if (productId !== "") {
            data.productId = $('#productId').find(':selected').val();
        }

        $.post('<?php echo base_url(); ?>Api/Voucher/create', data, function(data) {
            // alertify[data.status](data.message);
            return;
        }).fail(function(response) {
            response = JSON.parse(response.responseText);
            // alertify[response.status](response.message);
            return;
        });

    }

    function disabledField(el, field) {
        let value = $(el).val();
        $('#' + field).attr('required', true);
        if (value != '') {
            $('#' + field).attr('disabled', true);
            $('#' + field).attr('required', false);
            $('.form-control:disabled').attr('style', 'background-color: rgb(233, 236, 239) !important;');
        } else {
            $('#' + field).attr('disabled', false);
            $('#' + field).attr('required', true);
            $('#' + field).attr('style', 'background-color: #fff');
        }
    }
    </script>
