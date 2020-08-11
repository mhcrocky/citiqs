<?php use \koolreport\core\Utility; ?>
<div id="<?php echo $this->name; ?>" style="<?php echo Utility::get($this->css,"panel"); ?>" class="custom-drilldown panel <?php echo Utility::get($this->cssClass,"panel","panel-default") ?>">
    <div style="<?php echo Utility::get($this->css,"header"); ?>" class="panel-heading <?php echo Utility::get($this->cssClass,"header"); ?>">
        <div class="pull-right">
            <?php
            if($this->btnBack)
            {
            ?>
            <button style="<?php echo Utility::get($this->css,"btnBack"); ?>" type="button" onclick="<?php echo $this->name ?>.back()" class="btnBack <?php echo Utility::get($this->btnBack,"class",Utility::get($this->cssClass,"btnBack","btn btn-xs btn-primary")) ?>"><?php echo Utility::get($this->btnBack,"text","Back") ?></button>
            <?php    
            }
            ?>
        </div>
        <span class="custom-drilldown-title <?php echo Utility::get($this->cssClass,"title"); ?>" style="<?php echo Utility::get($this->css,"title"); ?>"><?php echo $this->title; ?></span>    
    </div>
    <div class="panel-body custom-drilldown-body <?php echo Utility::get($this->cssClass,"body"); ?>" style="<?php echo Utility::get($this->css,"content"); ?>">
        <?php
        if($this->showLevelTitle)
        {
        ?>
            <ol class="breadcrumb <?php echo Utility::get($this->cssClass,"levelTitle"); ?>"  style="<?php echo Utility::get($this->css,"levelTitle"); ?>"></ol>
        <?php    
        }
        ?>        
        <?php $this->report->subReport($this->subReports[0],array_merge($this->scope,array(
            "@drilldown"=>$this->name,
        ))); ?>
        <?php 
        for($i=1;$i<count($this->subReports);$i++)
        {
        ?>
            <sub-report id="<?php echo $this->subReports[$i]; ?>" name="<?php echo $this->subReports[$i]; ?>"></sub-report>
        <?php    
        }
        ?>    
    </div>
</div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new KoolReport.drilldown.CustomDrillDown("<?php echo $this->name; ?>",<?php echo json_encode($options); ?>)
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