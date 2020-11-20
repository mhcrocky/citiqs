<?php
use \koolreport\core\Utility;

$cardStyle = Utility::get($this->cssStyle, "card");
$valueStyle = Utility::get($this->cssStyle, "value");
$titleStyle = Utility::get($this->cssStyle, "title");
$iconStyle = Utility::get($this->cssStyle, "icon");

$cardClass = Utility::get($this->cssClass, "card");
$valueClass = Utility::get($this->cssClass, "value");
$iconClass = Utility::get($this->cssClass, "icon", "");
$titleClass = Utility::get($this->cssClass, "title");

$indicatorValue = 0;
$indicatorTitle = null;
$infoText = null;

if ($this->baseValue) {
    $indicatorValue = $this->calculateIndicator($this->value, $this->baseValue, $this->indicatorMethod);
    $indicatorTitle = str_replace("{baseValue}", $this->formatValue($this->baseValue, $this->valueFormat), $this->indicatorTitle);
    $indicatorTitle = str_replace("{value}", $this->formatValue($this->value, $this->valueFormat), $indicatorTitle);

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
    <div class="card-header">
        <div class="font-weight-bold">
            <span <?php echo $titleClass?"class='$titleClass'":""; ?> <?php echo $titleStyle?"style='$titleStyle'":""; ?>><?php echo $this->title; ?></span>
            <span class="float-right"><?php echo $this->formatValue($this->value, $this->valueFormat); ?></span>
        </div>
        <div>
            <span>
                <small><?php echo $infoText?$infoText:"&nbsp"; ?></small>
            </span>
            <?php if ($this->baseValue): ?>
                <span class="float-right" title="<?php echo $indicatorTitle; ?>">
                    <small>
                    <?php 
                        echo $indicatorValue>=0?"+":"";
                        echo $this->formatValue($indicatorValue, $this->indicatorFormat);
                    ?>
                    </small>
                </span>
            <?php endif ?>
        </div>
        <?php
        if ($this->chartDataStore && $this->chartDataStore->count()>0) {            
            echo "<div class='chart-wrapper' style='height:38px;'>";
            echo $this->drawChart(
                strtolower($this->chartType),
                $this->chartDataStore,
                $this->chartColumns,
                "38px",
                ($this->getPresetBackgroundColor()=="#fff")?
                    "rgba(0,0,0,0.3)" : "rgba(255,255,255,.55)"
            );
            echo "</div>";
        }

        if ($this->secondChartDataStore && $this->secondChartDataStore->count()>0) {
            echo "<div class='chart-wrapper' style='height:38px;'>";
            echo $this->drawChart(
                strtolower($this->secondChartType),
                $this->secondChartDataStore,
                $this->secondChartColumns,
                "38px",
                "rgba(0,0,0,0.3)"
            );
            echo "</div>";
        }
        ?>
    </div>
</div>