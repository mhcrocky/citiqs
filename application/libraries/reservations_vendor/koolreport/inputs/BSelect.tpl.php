<select id="<?php echo $this->name; ?>" <?php if($this->multiple) echo 'multiple="multiple"'; ?> name="<?php echo $this->name.($this->multiple?"[]":""); ?>"
<?php
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
    <option value="<?php echo $value; ?>" <?php echo (($this->multiple)?in_array($value,$this->value):($value==$this->value))?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
<input type="hidden" name="__<?php echo $this->name; ?>" value='<?php echo json_encode($this->value);?>' />
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $('#<?php echo $this->name;?>');
    var name = <?php echo $this->name; ?>;
    name.on('change',function(){
        $('input[name=__<?php echo $this->name; ?>]').val(JSON.stringify(name.val()));    
    });
    name.multiselect(<?php echo \koolreport\core\Utility::jsonEncode($this->options); ?>);
    name.defaultValue = name.val();
    name.reset = function() {
        var values = name.val();
        name.multiselect('deselect', values);
        name.multiselect('select', name.defaultValue);
    };
    <?php $this->clientSideReady();?>
});
</script>