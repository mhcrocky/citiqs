<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    if (isset($design[$viewName])) {
        $viewDesign = $design[$viewName];


        $css = '';
        if(isset($design['hover'])){
            $css .=   '.select__list__item .custom_style:hover { background-color:' . $design['hover']['select__list__item'] . ' !important; }';
         }
        if(isset($design['checked'])){
            $css .=   '.select__list__item label::before { background-color:' . $design['checked']['select__list__item'] . ' !important; }';
         }
         if(isset($design['checkmark'])){
            $css .=   '.select__list__item input:checked ~ .checkmark { background-color:' . $design['checkmark']['color'] . ' !important;border-color:' . $design['checkmark']['color'] . ' !important; }';
         }
         if(isset($design['paymentContainer'])){
            $css .=   '#area-container .payment-container a.paymentMethod:hover { background-color:' . $design['paymentContainer']['hover'] . ';border-radius: ' . $design['paymentContainer']['border-radius'] . '; color: ' . $design['paymentContainer']['color'] . ' }';
         }
         if(isset($design['makeOrderNew']['class']['slick-prev'])){
            $css .=   '.slick-next:hover, slick-prev:hover { background:' . $design['makeOrderNew']['class']['slick-prev']['background'] . ';border-radius: ' . $design['makeOrderNew']['class']['slick-prev']['border-radius'] . '; }';
         }

        

        foreach($viewDesign as $cssSelector => $selectorData) {
            $selector = ($cssSelector == 'id') ? '#' : '.';
            foreach($selectorData as $selectorValue => $cssDeclaration) {
                $css .=  $selector . $selectorValue . ' {';
                foreach ($cssDeclaration as $cssProperty => $value) {
                    $css .=   $cssProperty . ' : ' . $value . ' !important;';
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
