<select id="<?php echo $this->name; ?>" multiple name="<?php echo $this->name; ?>[]" <?php
foreach($this->attributes as $name=>$value)
{
    echo " $name='$value'";
}
?> >
<?php
foreach($this->data as $item)
{
    $value=$item["value"];
    $text=$item["text"];
?>
    <option value="<?php echo $value; ?>" <?php echo in_array($value,$this->value)?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
<input type="hidden" name="__<?php echo $this->name; ?>" value='<?php echo json_encode($this->value);?>' />
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $("#<?php echo $this->name; ?>");
    <?php echo $this->name ?>.on('change',function(){
        $('input[name=__<?php echo $this->name ?>]').val(JSON.stringify($('#<?php echo $this->name; ?>').val()));
    });
    <?php
    foreach($this->clientEvents as $name=>$function)
    {
    ?>
        <?php echo $this->name ?>.on('<?php echo $name ?>',<?php echo $function; ?>);
    <?php
    }
    ?>
    var name = <?php echo $this->name; ?>;
    name.reset = function() {
        var options = name[0].querySelectorAll('option');
        for (var i=0; i<options.length; i+=1) {
            options[i].selected = options[i].defaultSelected;
        }
    };
    <?php $this->clientSideReady();?>
});
</script>