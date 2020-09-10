<?php
    require 'config.php';

    /*
     *  QUANDO SI SALVA LA SORGENTE ADESSO SI PUO AVERE ACCESSO A TUTTI I PARAMETRI 'data'
     *  DEL DIV CON ID='tosave';
     */

    $config = array();
    if (isset($_POST['data'])) {
        foreach ($_POST['data'] as $param=>$value) {    $config[$param] = $value; }
    }
  

    $html         = ( get_magic_quotes_gpc() ) ? stripslashes($_POST['html']) : $_POST['html'];
    $filename     = dirname(__FILE__).'/tmp/body_'.time().'.html';

    /*
     * IN $config TROVI I VALORI DELLE VARIABILI PER INDICE
     */

    if (  file_put_contents($filename, $html) ) {
         // echo "File ".$filename.' was created';
          echo str_replace(dirname(__FILE__), 'http://'.$_SERVER['HTTP_HOST'].$path ,$filename);
    }


?>
