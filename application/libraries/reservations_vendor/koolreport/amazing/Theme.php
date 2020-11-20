<?php

namespace koolreport\amazing;

trait Theme
{
    public function __constructAmazingTheme()
    {
        $this->theme = new AmazingTheme($this);
    }
}