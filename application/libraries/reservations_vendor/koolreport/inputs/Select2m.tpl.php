<?php use \koolreport\core\Utility; ?>
<select id="<?php echo $this->name; ?>" multiple name="<?php echo $this->name; ?>[]" <?php
foreach($this->attributes as $name=>$value)
{
    echo " $name='$value'";
}
?> >
<?php
foreach($this->data as $item)
{
    $value = $item["value"];
    $text = $item["text"];
?>
    <option value="<?php echo $value; ?>" <?php echo in_array($value,$this->value)?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
<input type="hidden" name="__<?php echo $this->name; ?>" value='<?php echo json_encode($this->value);?>' />
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $('#<?php echo $this->name; ?>');
    let name = <?php echo $this->name; ?>;
    name.select2(<?php echo Utility::jsonEncode($this->options);?>);
    name.on('change',function(){
        $('input[name=__<?php echo $this->name; ?>]').val(JSON.stringify(name.val()));
    });
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $name=>$function)
        {
        ?>
        name.on('<?php echo $name ?>',<?php echo $function; ?>);
        <?php
        }
    }
    ?>
    name.defaultValue = name.val();
    name.reset = function() {
       name.val(<?php echo $this->name; ?>.defaultValue).trigger('change');
    };
    <?php $this->clientSideReady();?>
});    
</script>