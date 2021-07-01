<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="main-content w-100 container" style="margin-top:20px; border-width: 0px">
    <ul class="nav nav-tabs" style="border-bottom: none" role="tablist">
        <li class="nav-item">
            <a style="border-radius: 50px" onclick="nav_link(this)" class="nav-link nav_link active" data-toggle="tab"
                href="#design">Design</a>
        </li>
        <li class="nav-item">
            <a style="border-radius: 50px" onclick="nav_link(this)" class="nav-link nav_link" data-toggle="tab"
                href="#iframeSettings">Iframe</a>
        </li>
        <li class="nav-item">
            <a style="border-radius: 50px" onclick="nav_link(this)" class="nav-link nav_link" data-toggle="tab"
                href="#analytics">Analytics</a>
        </li>
    </ul>
 
    <div class="tab-content" style="border-radius: 50px; margin-left: -10px">
        <form action="<?php echo base_url(); ?>events/save_design/<?php echo $eventId; ?>" method="POST" enctype="multipart/form-data">
            <div id="design" class="container tab-pane active" style="background: none;">
                <?php include_once FCPATH . 'application/views/events/includes/design/designMain.php'; ?>
            </div>
            <div id="iframeSettings" class="container tab-pane" style="background: none;display:none;">
                <?php include_once FCPATH . 'application/views/events/includes/design/iframeSettings.php'; ?>
            </div>
            <div id="analytics" class="container tab-pane" style="background: none;">
                <?php include_once FCPATH . 'application/views/events/includes/design/analytics.php'; ?>
            </div>
        </form>
 

    </div>
</main>

<script>
var designGlobals = (function() {
    let globals = {
        'id': '<?php echo $id; ?>',
        'iframe': '<?php echo $iframeSrc; ?>',
        'iframeId': 'iframe',
        'showClass': 'showFieldsets',
        'hideClass': 'hideFieldsets',
        'shopView': 'shopView',
        'ticketsView': 'ticketsView',
        'iframeWidthDeviceId': 'iframeWidthDevice',
        'iframeHeightDeviceId': 'iframeHeightDevice',
        'phone': document.getElementById('phone_1'),
        'designBackgroundImageClass': 'designBackgroundImage',
        'checkUrl': function(url) {
            if (url.includes('shop')) {
                return this['shopView'];
            } else if (url.includes('tickets')) {
                return this['ticketsView'];
            }

            return false;
        }
    }
    return globals;
}());


</script>