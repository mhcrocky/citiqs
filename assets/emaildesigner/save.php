<?php
    require 'config.php';


    $html         = ( get_magic_quotes_gpc() ) ? stripslashes($_POST['html']) : $_POST['html'];
    //$option       = ( $_POST['option']=='' ) ? $_POST['option'] : 'template';

    /*
     *  QUANDO SI SALVA LA SORGENTE ADESSO SI PUO AVERE ACCESSO A TUTTI I PARAMETRI 'data'
     *  DEL DIV CON ID='tosave';
     */

    $config = array();
    if (isset($_POST['data'])) {
        foreach ($_POST['data'] as $param=>$value) {    $config[$param] = $value; }
    }

    /*
     * IN $config TROVI I VALORI DELLE VARIABILI PER INDICE
     */

    $filename     = dirname(__FILE__).'/tmp/'.time().'.html';
    $templateFile = file_get_contents('template.html');
    // saving the file
    //$templateFile = str_replace('{title}', $title, $templateFile);
    $templateFile = str_replace('{body}', $html, $templateFile);

    if (  file_put_contents($filename, $templateFile) ) {
         echo str_replace(dirname(__FILE__), 'http://'.$_SERVER['HTTP_HOST'].$path ,$filename);
    }


?>
