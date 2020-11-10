<main class="container">

    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="form-group">
                <label for='selectSpot'>Select POS spot</label>
                <select onchange="redirectToNewLocation(this.value)"class="form-control">
                    <option value="">Select</option>
                    <?php foreach ($spots as $spot) { ?>
                        <?php if ($spot['spotActive'] !== '1') continue; ?>
                        <option value="pos?spotid=<?php echo $spot['spotId']; ?>"><?php echo $spot['spotName']; ?></option>
                        
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</main>