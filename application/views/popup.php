<div class="btn-container">
    <button class="btn btn-primary" id="iframe-popup-open" onclick="popup()">
        Click here to make reservation
    </button>
</div>

<div class="iframe-popup hide" id="iframe-popup">
    <div class="iframe-popup__close" onclick="closeIframe()" id="popup-close"></div>
    <div class="iframe-popup__content">
        <iframe src="<?php echo base_url(); ?>agenda_booking/<?php echo $shortUrl; ?>" frameborder="0"
            style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" id="iframe-wrapper"></iframe>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/home/js/popup.js"></script>