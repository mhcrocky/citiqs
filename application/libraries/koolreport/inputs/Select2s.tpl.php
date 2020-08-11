<select id="<?php echo $this->name; ?>" name="<?php echo $this->name; ?>" <?php
foreach($this->attributes as $name=>$value)
{
    echo " $name='$value'";
}
?> >
<?php
if($this->defaultOption === array())
{
    echo "<option></option>";
}
foreach($this->data as $item)
{
    $value = $item["value"];
    $text = $item["text"];
?>
    <option value="<?php echo $value; ?>" <?php echo ((string)$this->value==(string)$value)?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $('#<?php echo $this->name; ?>');
    let name = <?php echo $this->name; ?>;
    name.select2(<?php echo \koolreport\core\Utility::jsonEncode($this->options);?>);
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $name=>$function)
        {
        ?>
            <?php echo $this->name; ?>.on('<?php echo $name ?>',<?php echo $function; ?>);
        <?php
        }
    }
    ?>
    name.defaultValue =name.val();
    name.reset = function() {
       name.val(<?php echo $this->name; ?>.defaultValue).trigger('change');
    };
    <?php $this->clientSideReady();?>
});
</script>