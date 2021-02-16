<div class="col-lg-12" style="margin:10px 0px; text-align:left">
    <h3 style="margin: 15px 0px 20px 0px">Popup</h3>
    <div class="form-group" style="margin-top:30px">
        <label for="iframeId" onclick='copyToClipboard("popupContent")' style="text-align:left; display:block">
            Copy to clipboard:
            <textarea class="form-control w-100 h-100" id="popupContent" readonly rows="4"
                style="height:60px;width: 200px;">#</textarea>
        </label>
    </div>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Background color:
        <input data-jscolor="" class="form-control b-radius jscolor" name="button_background"
            onchange="buttonStyle(this,'background-color')" />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Text color:
        <input data-jscolor="" class="form-control b-radius jscolor" name="button_text" onchange="buttonStyle(this,'color')" />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Border color:
        <input data-jscolor="" class="form-control b-radius jscolor" name="button_border"
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


<div id="root"></div>