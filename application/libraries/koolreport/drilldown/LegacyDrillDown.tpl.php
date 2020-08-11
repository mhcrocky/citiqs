<?php use \koolreport\core\Utility; ?>
<div id="<?php echo $this->name; ?>" style="<?php echo Utility::get($this->css,"panel"); ?>" class="drilldown panel panel-<?php echo $this->panelStyle; ?>">
    <div class="panel-heading">
        <div class="pull-right">
            <?php
            if($this->btnBack)
            {
            ?>
            <button style="<?php echo Utility::get($this->css,"btnBack"); ?>" type="button" onclick="<?php echo $this->name ?>.back()" class="btnBack <?php echo Utility::get($this->btnBack,"class","btn btn-xs btn-primary") ?>"><?php echo Utility::get($this->btnBack,"text","Back") ?></button>
            <?php    
            }
            ?>
        </div>
        <span class="legacy-drilldown-title" style="<?php echo Utility::get($this->css,"title"); ?>"><?php echo $this->title; ?></span>
    </div>
    <div class="panel-body legacy-drilldown-body" style="<?php echo Utility::get($this->css,"body"); ?>">
        <?php
        if($this->showLevelTitle)
        {
        ?>
            <ol class="breadcrumb"  style="<?php echo Utility::get($this->css,"levelTitle"); ?>"></ol>
        <?php    
        }
        ?>        
        <?php
        for($i=0;$i<count($this->levels);$i++)
        {
        ?>
        <div class="legacy-drilldown-level legacy-drilldown-level-<?php echo $i; ?>"<?php echo ($levelIndex==$i)?"":" style='display:none'"; ?>>
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
    <?php echo $this->name; ?> = new KoolReport.drilldown.LegacyDrillDown("<?php echo $this->name; ?>",<?php echo json_encode($options); ?>);
    <?php echo $this->name; ?>.levelTitle("<?php echo $this->getCurrentLevelTitle(); ?>");    
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