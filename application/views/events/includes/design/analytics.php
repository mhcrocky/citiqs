<form
    method="post"
    onsubmit="return saveAnalytics(this)"
    id="<?php echo $id; ?>"
    style="margin-top:20px"
>
    <div class="form-group col-sm-12">
        <label style="display:block;">
                Google analytics code
            <input

                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="googleAnalyticsCode"
                value="<?php echo is_null($analytics['googleAnalyticsCode']) ? '' : $analytics['googleAnalyticsCode']; ?>"
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
                Google adwords conversion id
            <input

                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="googleAdwordsConversionId"
                value="<?php echo is_null($analytics['googleAdwordsConversionId']) ? '' : $analytics['googleAdwordsConversionId']; ?>"
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Google adwords conversion label
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="googleAdwordsConversionLabel"
                value="<?php echo is_null($analytics['googleAdwordsConversionLabel']) ? '' : $analytics['googleAdwordsConversionLabel']; ?>"
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
                Google tag manager code
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="googleTagManagerCode"
                value="<?php echo is_null($analytics['googleTagManagerCode']) ? '' : $analytics['googleTagManagerCode']; ?>"
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Facebook pixel id
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="facebookPixelId"
                value="<?php echo is_null($analytics['facebookPixelId']) ? '' : $analytics['facebookPixelId']; ?>"
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <input type="submit" class="btn btn-primary" value="Submit" />
    </div>
</form>
