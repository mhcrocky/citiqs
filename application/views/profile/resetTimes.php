<div class="main-wrapper" style="text-align:center">
    
    <div class="col-lg-4">
        <form method="post" id="resetForm" onsubmit="return resetProductTimes(this)">
            <fieldset>
                <legend>Reset product times</legend>
                <div class="form-group">
                    <label for="timeFrom">From:</label>
                    <input
                        type="time"
                        class="form-control"
                        id="timeFrom"
                        name="timeFrom"
                    />
                </div>
                <div class="form-group">
                    <label for="timeTo">To:</label>
                    <input
                        type="time"
                        class="form-control"
                        id="timeTo"
                        name="timeTo"
                    />
                </div>
                <a
                    href="javascript:void(0)"
                    class="btn btn-primary"
                    onclick="confirmResetProductTimes('resetForm', 'timeFrom', 'timeTo')"
                >Reset</a>
            </fieldset>
        </form>
    </div>
</diV>