<?php
    if (isset($design[$viewName])) {
        $viewDesign = $design[$viewName];


        $css = '';
        foreach($viewDesign as $cssSelector => $selectorData) {
            $selector = ($cssSelector === 'id') ? '#' : '.';
            foreach($selectorData as $selectorValue => $cssDeclaration) {
                $css .=  $selector . $selectorValue . ' {';
                foreach ($cssDeclaration as $cssProperty => $value) {
                    $css .=  $cssProperty . ' : ' . $value . ' !important;';
                }
                $css .= '}';
            }
        }
        echo '<style>' . $css . '</style>';
    }
