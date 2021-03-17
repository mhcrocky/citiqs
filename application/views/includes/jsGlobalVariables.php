<script>
    'use strict';
    var globalVariables = (function(){
        let globals = {
            "win" : window,
            "doc" : document,
            baseUrl : '<?php echo base_url(); ?>',
            ajax : '<?php echo base_url() . 'Ajax/'; ?>',
            FC_PATH : '<?php echo str_replace('\\', '\\\\', FCPATH); ?>',

            'uploadEmailImageAjax' : '<?php echo base_url() . 'Ajax' . DIRECTORY_SEPARATOR . 'uploadEmailImage' . DIRECTORY_SEPARATOR; ?>',
            'emailImagesFolder' : '<?php echo $this->config->item('emailImagesFolder') ?>',
        }
        Object.freeze(globals);
        return globals;
    }());
</script>