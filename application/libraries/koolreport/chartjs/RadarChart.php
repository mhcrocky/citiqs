<?php

namespace koolreport\chartjs;
use \koolreport\core\Utility;

class RadarChart extends BarChart
{
    protected $type="radar";

    protected function processOptions()
    {
        return $this->options;
    }
}