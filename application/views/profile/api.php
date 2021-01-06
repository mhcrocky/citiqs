<div class="main-wrapper" style="text-align:center">
    <div class="col-lg-6 col-sm-12" style="text-align:left">
        <form method="post" onsubmit="return actviateApiRequest(this)">
            <div class="form-group">
                <label for="apikey">API key: </label>
                <input type="number" name="userId" value="<?php echo $apiUser['userid']; ?>" readonly requried hidden />
                <input
                    type="text"
                    id="apikey"
                    name="apikey"
                    class="form-control"
                    value="<?php echo $apiUser['apikey']; ?>"
                    disabled
                    readonly
                />
            </div>
            <div class="form-group">
                <?php if ($apiUser['access'] === '0') { ?>
                    <input type="submit" class="btn btn-primary" value="Send activation request" />
                <?php } else { ?>
                    <p>Key is active</p>
                <?php } ?>
            </diV>
        </form>
    </div>
</div>