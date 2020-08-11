<div id="<?php echo $this->name; ?>" <?php
if($this->length && $this->vertical)
{
    echo "style='height:$this->length'";
}
else if($this->length)
{
    echo "style='width:$this->length'";
}
?>></div>
<?php
for($i=0;$i<$this->handles;$i++)
{
?>
    <input value="<?php echo (isset($this->value[$i]))?$this->value[$i]:""; ?>" type="hidden" name="<?php echo $this->name; ?>[]" id="<?php echo $this->name."_handle".$i;?>" />
<?php
}
?>
<script>
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    var slider = document.getElementById("<?php echo $this->name;?>");
    var options = <?php echo json_encode($options); ?>;
    <?php
    if($this->format)
    {
    ?>
    options["format"] = wNumb(<?php echo json_encode($this->format); ?>);
    <?php
    }
    ?>
    noUiSlider.create(slider,options);
    slider.noUiSlider.on('update',function(){
        var values = slider.noUiSlider.get();
        if(typeof values != 'object')
        {
            values = [values];
        }
        values.forEach(function(value,index){
            document.getElementById("<?php echo $this->name; ?>_handle"+index).value = value;
        });
    });
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $eventName=>$function)
        {
        ?>
        slider.noUiSlider.on('<?php echo $eventName; ?>',<?php echo $function; ?>);
        <?php
        }
    }
    ?>
    <?php echo $this->name;?> = slider.noUiSlider;
    <?php $this->clientSideReady();?>
});
</script>