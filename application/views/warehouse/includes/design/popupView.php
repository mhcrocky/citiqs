<div class="col-lg-12" style="margin:10px 0px; text-align:left">
    <h3 style="margin: 15px 0px 20px 0px">Popup</h3>
    <div class="form-group" style="margin-top:30px">
        <label for="iframeId" onclick='copyToClipboard("popupContent")' style="text-align:left; display:block">
            Copy to clipboard:
            <textarea class="form-control w-100 h-100" id="popupContent" readonly rows="4"
                style="height:60px;width: 200px;">
                <div class="btn-container">
                    <button class="btn btn-primary" id="iframe-popup-open" onclick="popup()">
                        Click here to make reservation
                    </button>
                </div>

                <div class="iframe-popup hide" id="iframe-popup">
                    <div class="iframe-popup__close" onclick="closeIframe()" id="popup-close"></div>
                    <div class="iframe-popup__content">
                        <iframe src="<?php echo base_url(); ?>make_order?vendorid=<?php echo $this->session->userdata('userId');?>" frameborder="0"
                            style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"
                            id="iframe-wrapper"></iframe>
                    </div>
                </div>

                <script type="text/javascript" src="<?php echo base_url(); ?>assets/home/js/popup-alfred.js"></script>
            </textarea>
        </label>
    </div>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Background color:
        <input data-jscolor="" class="form-control b-radius jscolor" id="button_background" name="button_background"
            onchange="buttonStyle(this,'background-color')" />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Text color:
        <input data-jscolor="" class="form-control b-radius jscolor" id="button_text" name="button_text"
            onchange="buttonStyle(this,'color')" />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Border color:
        <input data-jscolor="" class="form-control b-radius jscolor" id="button_border" name="button_border"
            onchange="buttonStyle(this,'border-color')" />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Button Text:
        <input type="text" class="form-control b-radius" id="button_text_content" name="button_text_content"
            onchange="buttonText(this,'color')" />
    </label>
</div>

<div class="form-group col-sm-12">
    <label style="display:block;">
        <button class="btn btn-primary" onclick="saveButtonStyle()">Save</button>
    </label>
</div>


<div id="root">
    <div class="btn-container">
        <button class="btn btn-primary" id="iframe-popup-open" onclick="popup()">
            Click here to make reservation
        </button>
    </div>

    <div class="iframe-popup hide" id="iframe-popup">
        <div class="iframe-popup__close" onclick="closeIframe()" id="popup-close"></div>
        <div class="iframe-popup__content">
            <iframe src="<?php echo base_url(); ?>make_order?vendorid=<?php echo $this->session->userdata('userId');?>&spotid=1342" frameborder="0"
                style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" id="iframe-wrapper"></iframe>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/home/js/popup-alfred.js"></script>

</div>
