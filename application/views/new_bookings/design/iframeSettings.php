<div class="col-lg-12" style="margin:10px 0px; text-align:left">
    <h3 style="margin: 15px 0px 20px 0px">Iframe Settings</h3>
    <div class="form-inline">
        <label for="iframeWidth" style="margin-right:30px">
            Iframe width:&nbsp;&nbsp;
            <input
                type="number"
                id="iframeThisWidth"
                onchange="iframeWidth(this)"
                min="1"
                step="1"
                value="540"
                placeholder="Set iframe width"
                class="form-control"
                style="width:80px"
            />
            &nbsp;px
        </label>
        <label for="iframeHeight"  style="margin-right:30px">
            Iframe height:&nbsp;&nbsp;
            <input
                type="number"
                id="iframeThisHeight"
                onchange="iframeHeight(this)"
                min="0"
                step="1"
                value="400"
                placeholder="Set iframe height"
                class="form-control"
                style="width:80px"
                oninput="changeThisIframe('iframeWidth', 'iframeHeight', 'iframeId')"
            />
            &nbsp;px
        </label>
        
    </div>    
    <div class="form-group" style="margin-top:30px">
        <label for="iframeId" onclick='copyToClipboard("iframeId")' style="text-align:left; display:block">
            Copy to clipboard:
            <textarea
                class="form-control"
                id="iframeId"
                readonly
                rows="4"
                style="height:60px;width: 200px;"
            ><?php
                    #$iframe  = htmlentities('<script src="' . base_url() . 'assets/js/iframeResizer.js"></script>');
                    $iframe = htmlentities('<iframe frameborder="0" style="width:400px; height:600px;" src="' . $iframeSrc . '"></iframe>');
                    #$iframe .= htmlentities('<script>iFrameResize({ scrolling: true, sizeHeight: true, sizeWidth: true, maxHeight:700, maxWidth:400, })</script>');
                    echo $iframe;
            ?></textarea>
        </label>
    </div>
</div>
