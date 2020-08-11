<?php
use \koolreport\core\Utility;
$cardClass = Utility::get($this->cssClass, "card");
$valueClass = Utility::get($this->cssClass, "value");
$iconClass = Utility::get($this->cssClass, "icon");
$titleClass = Utility::get($this->cssClass, "title");

$cardStyle = Utility::get($this->cssStyle, "card");
$valueStyle = Utility::get($this->cssStyle, "value");
$iconStyle = Utility::get($this->cssStyle, "icon");
$titleStyle = Utility::get($this->cssStyle, "title");

$href = $this->getHref();
if ($href) {
    $cardStyle ="cursor:pointer;$cardStyle";
}

?>
<div <?php echo ($href)?$href:""; ?>class="card p-0<?php echo($cardClass)?" $cardClass":""; ?>" <?php echo ($cardStyle)?"style='$cardStyle'":""; ?>>
    <div class="card-body p-0">
        <i class="float-left mr-3 p-4 font-2xl<?php echo ($this->preset)?" bg-$this->preset":" bg-primary"; ?><?php echo($iconClass)?" $iconClass":""; ?>"  <?php echo ($iconStyle)?"style='$iconStyle'":""; ?>></i>
        <div class="h5 mb-0 pt-3<?php echo ($this->preset)?" text-$this->preset":""; ?><?php echo($valueClass)?" $valueClass":""; ?>"  <?php echo ($valueStyle)?"style='$valueStyle'":""; ?>>
            <?php echo $this->formatValue($this->value, $this->valueFormat); ?>
        </div>
        <div class="text-muted text-uppercase font-weight-bold font-xs<?php echo($titleClass)?" $titleClass":""; ?>"  <?php echo ($titleStyle)?"style='$titleStyle'":""; ?>>
            <?php echo $this->title; ?>
        </div>
    </div>
</div>