<?php
    use \koolreport\core\Utility;
?>
<div id="<?php echo $this->name; ?>" class="multiview panel <?php echo Utility::get($this->cssClass,"panel","panel-default"); ?>" style="<?php echo Utility::get($this->css,"panel"); ?>">
    <div class="panel-heading <?php echo Utility::get($this->cssClass,"header"); ?>">
        <span style="<?php echo Utility::get($this->css,"title");?>" class="multiview-title <?php echo Utility::get($this->cssClass,"title"); ?>"><?php echo $this->title; ?></span>
    </div>
    <div class="panel-body multiview-body <?php echo Utility::get($this->cssClass,"body"); ?>" style="<?php echo Utility::get($this->css,"body"); ?>">
        <div class="multiview-handler-group <?php echo Utility::get($this->cssClass,"handler-group","text-right"); ?>" style="<?php echo Utility::get($this->css,"handler-group"); ?>">
            <div class="btn-group" data-toggle="buttons">
            <?php
            foreach($this->views as $index=>$view)
            {
            ?>
                <label data-value="<?php echo $index; ?>" style="<?php echo Utility::get($this->css,"handler");?>" class="multiview-handler multiview-handler-<?php echo $index; ?> btn btn-sm <?php echo Utility::get($this->cssClass,"handler","btn-primary") ?><?php echo ($index==$this->viewIndex)?" active":""; ?>">
                    <input  type="radio" autocomplete="off">
                    <?php echo $view["handler"]; ?>
                </label>
            <?php    
            }
            ?>
            </div>        
        </div>
        <div class="multiview-content <?php echo Utility::get($this->cssClass,"content"); ?>" style="<?php echo Utility::get($this->css,"content"); ?>">
        <?php
        foreach($this->views as $index=>$view)
        {
        ?>
            <div class="multiview-widget multiview-widget-<?php echo $index; ?>" style="<?php echo ($index==$this->viewIndex)?"":"display:none;" ?>">
                <?php 
                    $widgets[$index]->render();
                ?>
            </div>
        <?php    
        }
        ?>
        </div>
    </div>
</div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new KoolReport.drilldown.MultiView("<?php echo $this->name; ?>",<?php echo json_encode($settings); ?>)
    <?php
    foreach($this->clientEvents as $event=>$function)
    {
    ?>
        <?php echo $this->name; ?>.on("<?php echo $event ?>",<?php echo $function; ?>);
    <?php
    }
    ?>
    <?php $this->clientSideReady();?>
});
</script>