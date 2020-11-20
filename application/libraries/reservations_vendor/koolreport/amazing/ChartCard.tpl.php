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

$href = $this->getHref();
if ($href) {
    $cardStyle ="cursor:pointer;$cardStyle";
}
?>
<div <?php echo ($href)?$href:""; ?>class="card<?php echo $this->preset?" text-white bg-$this->preset":""; ?><?php echo($cardClass)?" $cardClass":""; ?>"<?php echo ($cardStyle)?" style='$cardStyle'":""; ?>>
    <div class="card-body pb-0">
        <i class="float-right mt-1<?php echo $iconClass?" $iconClass":""; ?>"<?php echo $iconStyle?" style='$iconStyle'":""; ?>></i>
        <h4 class="mb-0"><?php echo $this->formatValue($this->value, $this->valueFormat); ?></h4>
        <p <?php echo $titleClass?"class='$titleClass'":""; ?> <?php echo $titleStyle?"style='$titleStyle'":""; ?>><?php echo $this->title; ?></p>
        
        <?php
        if ($this->chartDataStore && $this->chartDataStore->count()>0) {            
            switch(strtolower($this->chartType))
            {
            case "line":
            case "column":
                echo "<div class='chart-wrapper px-3 pt-1 pb-1'>";
                echo $this->drawChart(
                    "line",
                    $this->chartDataStore,
                    $this->chartColumns,
                    "70px",
                    ($this->getPresetBackgroundColor()=="#fff")?
                        "rgba(0,0,0,0.3)" : "rgba(255,255,255,.55)"
                );
                echo "</div>";
                break;
            case "area":
                echo "<div class='chart-wrapper' style='margin-left:-20px;margin-right:-20px;'>";
                echo $this->drawChart(
                    "area",
                    $this->chartDataStore,
                    $this->chartColumns, 
                    "70px",
                    ($this->getPresetBackgroundColor()=="#fff")?
                        "rgba(0,0,0,0.3)" : "rgba(255,255,255,.55)",
                    ($this->getPresetBackgroundColor()=="#fff")?
                        "rgba(0,0,0,0.2)" : "rgba(255,255,255,.2)"
                );
                echo "</div>";
                break;
            }
        }
        ?>
    </div>
</div>