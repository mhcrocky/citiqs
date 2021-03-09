<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="background: none;" class="card p-4">

                    <div class="card-body">
                        <form name="my-form" id="my-form" class="needs-validation"
                            action="#" method="POST" onsubmit="return saveVoucher(event)" novalidate>
                            <div class="form-group row">
                                <label for="full_name" class="col-md-4 col-form-label text-md-left">
                                    <h3>
                                        <strong>Create voucher</strong>
                                    </h3>
                                </label>
                                <div class="col-md-6">

                                </div>
                            </div>

                            <input type="hidden" id="vendorId" name="vendorId" value="<?php echo $vendorId; ?>">


                            <div class="form-group row">
                                <label for="event-name" class="col-md-4 col-form-label text-md-left">Voucher Code</label>
                                <div class="col-md-6">

                                    <input type="text" id="code" class="input-w border-50 form-control"
                                        name="code" required>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="percent" class="col-md-4 col-form-label text-md-left">Percent</label>
                                <div class="col-md-6">

                                    <input type="number" id="percent" class="input-w border-50 form-control"
                                        name="percent" required>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="percentUsed" class="col-md-4 col-form-label text-md-left">Percent Used</label>
                                <div class="col-md-6"> 
                                    <select id="percentUsed" name="percentUsed" class="form-control input-w border-50 field">
                                        <option value="" disabled>Select option</option>
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="expire" class="col-md-4 col-form-label text-md-left">Expire</label>
                                <div class="col-md-6">

                                    <input type="date" id="expire" class="input-w border-50 form-control"
                                        name="expire" required>

                                </div>
                            </div>

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

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-left">Amount</label>
                                <div class="col-md-6">

                                    <input type="number" id="amount" class="input-w border-50 form-control"
                                        name="amount" required>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="productId" class="col-md-4 col-form-label text-md-left">Product Id</label>
                                <div class="col-md-6">

                                    <input type="number" id="productId" class="input-w border-50 form-control"
                                        name="productId">

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
    </div>










<script>
function saveVoucher(e){
    e.preventDefault();
    if ($('.form-control:invalid').length > 0) {
        return ;
    }

    let data = {
        vendorId: $('#vendorId').val(),
        code: $('#code').val(),
        percent: $('#percent').val(),
        percentUsed: $('#percentUsed option:selected').val(),
        expire: $('#expire').val(),
        active: $('#active option:selected').val(),
        amount: $('#amount').val(),
        productId: $('#productId').val()
    }

    $.post('<?php echo base_url(); ?>api/voucher/create', data, function(data){
        alertify[data.status](data.message);
        return ;
    }).fail(function(response) {
        response = JSON.parse(response.responseText);
        alertify[response.status](response.message);
        return ;
    });

}
</script>