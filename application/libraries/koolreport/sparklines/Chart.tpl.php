<?php
/**
 * This file contains Chart view
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */
    use \koolreport\core\Utility;
?>
<span id="<?php echo $this->name; ?>" class="sparkline"></span>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $('#<?php echo $this->name; ?>'); 
    <?php echo $this->name; ?>.sparkline(<?php echo json_encode($this->data); ?>,<?php echo Utility::jsonEncode($this->options); ?>);
    <?php $this->clientSideReady();?>
});
</script>