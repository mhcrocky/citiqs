<?php
/**
 * This file contains Morris chart view
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */
?>
<div id='<?php echo $this->chartId; ?>' style="width:<?php echo $this->width; ?>;height:<?php echo $this->height; ?>"></div>
<script type="text/javascript">
    KoolReport.widget.init(
        <?php echo json_encode($this->getResources()); ?>,
        function() {
            Morris.<?php echo $this->type; ?>(<?php echo \koolreport\core\Utility::jsonEncode($options); ?>);  
        }
    );
</script>