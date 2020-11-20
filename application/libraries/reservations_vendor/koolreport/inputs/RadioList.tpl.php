<?php
foreach($this->data as $item)
{
    $value = $item["value"];
    $text = $item["text"];
?>
    <div class="<?php echo $this->display=="vertical"?"radio":"radio-inline"; ?>">
        <label>
            <input type="radio" name="<?php echo $this->name; ?>" value="<?php echo $value ?>" <?php echo($this->value==$value)?"checked":""; ?>>
            <span><?php echo $text; ?></span>
        </label>
    </div>
<?php
}
?>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new RadioList("<?php echo $this->name; ?>");
    <?php
    if($this->clientEvents)
    {
    foreach($this->clientEvents as $eventName=>$function)
    {
    ?>
        <?php echo $this->name; ?>.on('<?php echo $eventName; ?>',<?php echo $function; ?>);
    <?php
    }    
    }
    ?>
    <?php $this->clientSideReady();?>
});
</script>