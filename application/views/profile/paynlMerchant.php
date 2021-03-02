<div class="main-wrapper" style="text-align:center">
    <?php if (empty($merchant)) { ?>
        <p>No merchant id</p>
    <?php } else { ?>
        <form method="post" onsubmit="return uploadDocumentsForPayNl(this)" enctype="multipart/form-data" >
            <?php foreach ($merchant->documents as $document) { ?>
                <p>Document status: <?php echo $paynlDocumentStatusDesc[$document->status_id]; ?></p>
                <p class="errors" id="<?php echo $document->id; ?>" style="color:#ff6666; font-weight:900"></p>
                <div class="form-group">
                    <label for="<?php echo $document->id; ?>">
                        Upload&nbsp;
                        <?php 
                            if ($document->type_name === 'Kopie rekeningafschrift') {
                                echo 'copy of account statement';
                            } elseif ($document->type_name === 'Overeenkomst') {
                                echo 'agreement';
                            } elseif ($document->type_name === 'KvK uittreksel') {
                                echo 'chamber of Commerce extract';
                            }
                        ?>
                    </label>
                    <input
                        type="file"
                        id="<?php echo $document->id; ?>"
                        name="<?php echo $document->id; ?>"
                        class="form-control"
                    />                        
                </div>
            <?php } ?>
            <input type="submit" value="Submit" class="btn btn-primary" />
        </form>
    <?php } ?>
</div>
