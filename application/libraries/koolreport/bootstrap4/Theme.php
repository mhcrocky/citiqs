<?php 

namespace koolreport\bootstrap4;

trait Theme
{
    protected function __constructBoostrap4Theme()
    {
        $this->theme = new Bootstrap4Theme($this);
    }
}