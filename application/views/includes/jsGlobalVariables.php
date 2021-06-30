<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    $baseUrl = base_url();
?>
<script>
    'use strict';
    var globalVariables = (function(){
        let globals = {
            "win" : window,
            "doc" : document,
            baseUrl : '<?php echo $baseUrl; ?>',
            ajax : '<?php echo $baseUrl . 'Ajax/'; ?>',
            FC_PATH : '<?php echo str_replace('\\', '\\\\', FCPATH); ?>',
            'uploadEmailImageAjax' : '<?php echo $baseUrl . 'Ajax' . DIRECTORY_SEPARATOR . 'uploadEmailImage' . DIRECTORY_SEPARATOR; ?>',
            'emailImagesFolder' : '<?php echo $this->config->item('emailImagesFolder') ?>',
            bootstrapTinymceKey : '<?php echo BOOTSTRAP_TINYMCE_KEY; ?>'
        }
        Object.freeze(globals);
        return globals;
    }());
</script>
