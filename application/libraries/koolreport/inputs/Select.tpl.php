<select id="<?php echo $this->name; ?>" name="<?php echo $this->name; ?>" <?php
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
    <option value="<?php echo $value; ?>" <?php echo ((string)$this->value==(string)$value)?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $("#<?php echo $this->name; ?>");
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