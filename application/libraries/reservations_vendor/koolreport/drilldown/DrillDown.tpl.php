<?php use \koolreport\core\Utility; ?>
<div id="<?php echo $this->name; ?>" style="<?php echo Utility::get($this->css,"panel"); ?>" class="drilldown panel <?php echo Utility::get($this->cssClass,"panel","panel-default");?>">
    <div style="<?php echo Utility::get($this->css,"header"); ?>" class="panel-heading <?php echo Utility::get($this->cssClass,"header");?>">
        <div class="pull-right">
            <?php
            if($this->btnBack)
            {
            ?>
            <button style="<?php echo Utility::get($this->css,"btnBack"); ?>" type="button" onclick="<?php echo $this->name ?>.back()" class="btnBack <?php echo Utility::get($this->btnBack,"class",Utility::get($this->cssClass,"btnBack","btn btn-xs btn-primary")); ?>"><?php echo Utility::get($this->btnBack,"text","Back") ?></button>
            <?php    
            }
            ?>
        </div>
        <span class="drilldown-title <?php echo Utility::get($this->cssClass,"title");?>" style="<?php echo Utility::get($this->css,"title"); ?>"><?php echo $this->title; ?></span>
    </div>
    <div class="panel-body drilldown-body <?php echo Utility::get($this->cssClass,"body");?>" style="<?php echo Utility::get($this->css,"body"); ?>">
        <?php
        if($this->showLevelTitle)
        {
        ?>
            <ol class="breadcrumb <?php echo Utility::get($this->cssClass,"levelTitle");?>"  style="<?php echo Utility::get($this->css,"levelTitle"); ?>"></ol>
        <?php    
        }
        ?>        
        <?php
        for($i=0;$i<count($this->levels);$i++)
        {
        ?>
        <div class="drilldown-level drilldown-level-<?php echo $i; ?>"<?php echo ($levelIndex==$i)?"":" style='display:none'"; ?>>
            <?php
            if($levelIndex==$i)
            {
                $this->renderCurrentLevel();
            }
            ?>
        </div>
        <?php    
        }
        ?>
    </div>
</div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new KoolReport.drilldown.DrillDown("<?php echo $this->name; ?>",<?php echo json_encode($options); ?>);
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