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
    #$design['bgImage'] = '1190_1598545539.png';
?>
<?php if (!empty($design['bgImage'])) { ?>
    <style>
        #selectTypeBody,
        #selectSpotContainer,
        #makeOrderView,
        #goOrder,
        #buyerDetailsContainer,
        #closedContainer,
        #spotClosed,
        .payOrderBackgroundColor:first-child {
            background-image: url("<?php echo base_url(); ?>assets/images/backGroundImages/<?php echo $design['bgImage']; ?>");
            background-size: cover;
            background-position: center center;
        }
    </style>
<?php } ?>