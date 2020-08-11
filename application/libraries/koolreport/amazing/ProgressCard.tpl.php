<?php
use \koolreport\core\Utility;

$cardStyle = Utility::get($this->cssStyle, "card");
$valueStyle = Utility::get($this->cssStyle, "value");
$titleStyle = Utility::get($this->cssStyle, "title");
$iconStyle = Utility::get($this->cssStyle, "icon");
$infoTextStyle = Utility::get($this->cssStyle, "infoText");

$cardClass = Utility::get($this->cssClass, "card");
$valueClass = Utility::get($this->cssClass, "value");
$iconClass = Utility::get($this->cssClass, "icon", "");
$titleClass = Utility::get($this->cssClass, "title");
$infoTextClass = Utility::get($this->cssClass, "infoText");
$progressClass = Utility::get($this->cssClass, "progress");

$indicatorTitle = null;
$infoText = null;

if ($this->baseValue) {
    $indicatorValue = $this->calculateIndicator($this->value, $this->baseValue, $this->indicatorMethod);

    $indicatorTitle = str_replace("{baseValue}", $this->formatValue($this->baseValue, $this->valueFormat), $this->indicatorTitle);
    $indicatorTitle = str_replace("{value}", $this->formatValue($this->value, $this->valueFormat), $indicatorTitle);
    $indicatorTitle = str_replace("{indicatorValue}", $this->formatValue($indicatorValue, $this->indicatorFormat), $indicatorTitle);

    $infoText = str_replace("{baseValue}", $this->formatValue($this->baseValue, $this->valueFormat), $this->infoText);
    $infoText = str_replace("{value}", $this->formatValue($this->value, $this->valueFormat), $infoText);
    $infoText = str_replace("{indicatorValue}", $this->formatValue($indicatorValue, $this->indicatorFormat), $infoText);
}

$href = $this->getHref();
if ($href) {
    $cardStyle ="cursor:pointer;$cardStyle";
}

?>
<div <?php echo ($href)?$href:""; ?>class="card<?php echo $this->preset?" text-white bg-$this->preset":""; ?><?php echo($cardClass)?" $cardClass":""; ?>"<?php echo ($cardStyle)?" style='$cardStyle'":""; ?>>
    <div class="card-body">
        <i class="float-right mt-1<?php echo $iconClass?" $iconClass":""; ?>"<?php echo $iconStyle?" style='$iconStyle'":""; ?>></i>
        <div class="h4 m-0"<?php echo $this->baseValue?" title='$indicatorTitle'":""; ?>><?php echo $this->formatValue($this->value, $this->valueFormat); ?></div>
        <p <?php echo $titleClass?"class='$titleClass'":""; ?> <?php echo $titleStyle?"style='$titleStyle'":""; ?>><?php echo $this->title; ?></p>
        <?php if ($this->baseValue) : ?>
            <div title="<?php echo $this->formatValue($indicatorValue, $this->indicatorFormat); ?>" class="progress progress-xs my-3<?php echo $this->preset?" progress-white":""; ?>">
                <div class="progress-bar<?php echo ($progressClass)?" $progressClass":""; ?>" role="progressbar" style="width: <?php echo $indicatorValue; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        <?php endif; ?>
        <small class="text-muted<?php echo ($infoTextClass)?" $infoTextClass":"" ?>"<?php echo $infoTextStyle?" style='$infoTextStyle'":""; ?>><?php echo $infoText; ?></small>
    </div>
</div>