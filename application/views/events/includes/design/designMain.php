<div class="row">
    <div class="col-lg-6">


           


                <div class="row" id="controls">
                <div class="col-md-6">
                    <div>
                        <input type="number" id="iframeWidthDevice" value="414" hidden readonly required />
                    </div>
                    <div>
                        <input type="number" id="iframeHeightDevice" value="896" hidden readonly required />
                    </div>
                    <div>
                        <input style="display: none;" type="checkbox" id="iframePerspective" checked="true" />
                    </div>
                </div>
                <div class="col-md-6">
                    <select style="border-radius: 50px" id="device" class="form-control">
                        <?php foreach($devices as $device): ?>
                        <option
                            value="<?php echo $device['width']."x".$device['height']; ?>"><?php echo $device['device']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="views">
                        <button style="border-radius: 50px" onclick="return false" value="3">View 1 - Front</button>
                        <button style="border-radius: 50px" onclick="return false" value="1">View 2 - Laying</button>
                        <button style="border-radius: 50px" onclick="return false" value="2">View 3 - Side</button>
                    </div>
                </div>
            </div>
                <?php
                    include_once FCPATH . 'application/views/events/includes/design/selectTypeView.php';
                    include_once FCPATH . 'application/views/events/includes/design/ticketsView.php';
                ?>
                <input type="submit" class="btn btn-primary" value="submit" />
            </form>

    </div>
    <div class="col-lg-6">

            <div id="wrapper" style="position:fixed; top:3%">
                <div class="phone view_1" id="phone_1" style="margin:auto; width:80%;">
                    <iframe id="iframe" src="<?php echo $iframeSrc; ?>" width="420px" height="650px"></iframe>
                </div>
            </div>
     
    </div>
</div>
