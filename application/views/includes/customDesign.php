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
         if (!empty($design['bgImage'])) { 
            $css .=
                '.designBackgroundImage {
                    background-image: url("' . base_url() . 'assets/images/backGroundImages/' . $design['bgImage'] . '");
                    background-size: cover;
                    background-position: center center;
                }';
         }

        echo '<style>' . $css . '</style>';
    }
    #$design['bgImage'] = '1190_1598545539.png';
?>
