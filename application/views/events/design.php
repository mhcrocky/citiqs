<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="main-content w-100 container" style="margin-top:20px; border-width: 0px">
    <ul class="nav nav-tabs" style="border-bottom: none" role="tablist">
        <li class="nav-item">
            <a style="border-radius: 50px" class="nav-link active" data-toggle="tab" href="#design">Design</a>
        </li>
        <li class="nav-item">
            <a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#iframeSettings">Iframe</a>
        </li>
    </ul>

    <div class="tab-content" style="border-radius: 50px; margin-left: -10px">
    <form action="<?php echo base_url(); ?>events/save_design" method="POST">
        <div id="design" class="container tab-pane active" style="background: none;">                    
            <?php include_once FCPATH . 'application/views/events/includes/design/designMain.php'; ?>
        </div>        
        <div id="iframeSettings" class="container tab-pane" style="background: none;">
            <?php include_once FCPATH . 'application/views/events/includes/design/iframeSettings.php'; ?>
        </div>
        </form>
        
    </div>
</main>

<script>
    var designGlobals = (function() {
        let globals = {
            'id' : "1",
            'iframe'  : '<?php echo $iframeSrc; ?>',
            'iframeId' : 'iframe',
            'showClass' : 'showFieldsets',
            'hideClass' : 'hideFieldsets',
            'selectTypeView' : 'selectTypeView',

            'iframeWidthDeviceId' : 'iframeWidthDevice',
            'iframeHeightDeviceId' : 'iframeHeightDevice',
            'phone' : document.getElementById('phone_1'),
            'designBackgroundImageClass' : 'designBackgroundImage',
            'checkUrl' : function (url) {
                            if (url.includes('events')) {
                                return this['selectTypeView'];
                            }
                           
                            return false;
                        }
        }
        return globals;
    }());
    

</script>

<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jscolor.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/shopdesign.js"></script>