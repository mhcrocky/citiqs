<?php
use \koolreport\core\Utility;

$cardStyle = Utility::get($this->cssStyle, "card");
$valueStyle = Utility::get($this->cssStyle, "value");
$indicatorStyle = Utility::get($this->cssStyle, "indicator");
$titleStyle = Utility::get($this->cssStyle, "title");
$negativeStyle = Utility::get($this->cssStyle, "negative");
$positiveStyle = Utility::get($this->cssStyle, "positive");

$cardClass = Utility::get($this->cssClass, "card");
$valueClass = Utility::get($this->cssClass, "value");
$indicatorClass = Utility::get($this->cssClass, "indicator");
$titleClass = Utility::get($this->cssClass, "title");
$upIconClass = Utility::get($this->cssClass, "upIcon", "fa fa-arrow-circle-o-up");
$downIconClass = Utility::get($this->cssClass, "downIcon", "fa fa-arrow-circle-o-down");
$negativeClass = Utility::get($this->cssClass, "negative", "text-danger");
$positiveClass = Utility::get($this->cssClass, "positive", "text-success");

$indicatorValue = 0;
$indicatorTitle = null;

if ($this->baseValue!==null) {
    
    $indicatorValue = $this->calculateIndicator($this->value, $this->baseValue, $this->indicatorMethod);
    $indicatorStyle .= (($indicatorStyle)?";":"").
                    (($indicatorValue<0)?$negativeStyle:$positiveStyle);
    $indicatorTitle = str_replace("{baseValue}", $this->formatValue($this->baseValue, $this->valueFormat), $this->indicatorTitle);
    $indicatorTitle = str_replace("{value}", $this->formatValue($this->value, $this->valueFormat), $indicatorTitle);
}

$href = $this->getHref();
if ($href) {
    $cardStyle ="cursor:pointer;$cardStyle";
}

?>
<div <?php echo ($href)?$href:""; ?>class="card<?php echo ($cardClass)?" $cardClass":"" ?>"<?php echo ($cardStyle)?" style='$cardStyle'":""; ?>>
    <div class="card-body">
        <div class="card-title text-center h6 mt-3<?php echo($titleClass)?" $titleClass":""; ?>"><?php echo $this->title; ?></div>
        <div class="gaugejs-wrap">
            <canvas id="<?php echo $this->name."gauge"; ?>" class="gaugejs"></canvas>
        </div>
    </div>
    <div class="card-footer">
        <?php if ($this->showValue) { ?>
        <strong><?php echo $this->formatValue($this->value, $this->valueFormat); ?></strong>
		<?php } ?>
		<?php if ($this->showBaseValue) { ?>
        <strong><?php echo $this->formatValue($this->baseValue, $this->valueFormat); ?></strong>
		<?php } ?>

        <?php if ($this->baseValue!==null) :?>
        <span title="<?php echo $indicatorTitle; ?>" class="float-right<?php echo ($indicatorClass)?" $indicatorClass":""; ?>">
            <i class="<?php echo ($indicatorValue<$this->indicatorThreshold)?$downIconClass:$upIconClass; ?> <?php echo ($indicatorValue<$this->indicatorThreshold)?$negativeClass:$positiveClass; ?>"></i>
            <?php echo $this->formatValue($indicatorValue, $this->indicatorFormat); ?>
        </span>
        <?php endif ?>
    </div>
</div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    var gauge = new Gauge(document.getElementById('<?php echo $this->name."gauge"; ?>'));
    gauge.setOptions(<?php echo Utility::jsonEncode($this->gauge); ?>);
    gauge.minValue = <?php echo $this->minValue; ?>;
    gauge.maxValue = <?php echo $this->maxValue; ?>;
    gauge.animationSpeed = <?php echo isset($this->gauge["animationSpeed"])?$this->gauge["animationSpeed"]:32; ?>;
    gauge.set(<?php echo $this->calculateIndicator($this->value, $this->baseValue, $this->indicatorMethod); ?>);
});
</script>