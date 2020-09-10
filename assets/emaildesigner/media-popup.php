<?php
$folder=  'images'.DIRECTORY_SEPARATOR;          //nome della cartella da cui prendere le immagini
$sitoweb=getFullUrl();
$sitoweb=str_replace("admin/editor","",$sitoweb);

$immagini = isset($_GET['immagini']) ? $_GET['immagini'] : '';
$op = isset($_GET['op']) ? $_GET['op'] : '';


if($op=="newfile"){
    $ds          = DIRECTORY_SEPARATOR;  //1
    $storeFolder = 'images';   //2
    if (!empty($_FILES)) {

        $filename = basename($_FILES['nomefile']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpeg") || ($ext == "jpg") || ($ext == "JPG") || ($ext == "gif") || ($ext == "GIF") || ($ext == "png") || ($ext == "PNG")) {

            $tempFile = $_FILES['nomefile']['tmp_name'];          //3
            $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
            $targetFile =  $targetPath. $_FILES['nomefile']['name'];  //
            move_uploaded_file($tempFile,$targetFile); //6

        }
    }
}


if($immagini==1){
//apre la directory della variabile $folder e mette tutti i file letti in un array
$i=0;
$handle=opendir($folder);
while ($file = readdir ($handle)){
    if ($file != "." && $file != ".."  && $file != ".DS_Store")     {

//        if(strlen($nome)>0){
//            if(trovaStringa($file,$nome)){
//                $files[$i] = $file;
//                $i++;
//            }
//        }else{
            $files[$i] = $file;
            $i++;
//        }

    }
}
closedir($handle);

    $folder2=str_replace("../../","",$folder);
    echo "<table class=\"table table-bordered\" width=\"100%\">\n";

    echo "<tr>\n";
    $i=1;
    for($s=0;$s<count($files);$s++){

        echo "
         <td style=\"background:#ffffff;margin:5px\">
            <center>
            <img src=\"$folder/".$files[$s]."\" width=\"100\" height=\"100\" border=0 >
            </center>

            <span style=\"font-size:11px\">".substr($files[$s],0,25)."</span>
            <br>
            <a href=\"javascript:void(0);\" onclick=\"inserisci(this);\" class=\"insert-image\" data-image=\"{$sitoweb}/{$folder2}/{$files[$s]}\"><span class=\"glyphicon glyphicon-download\"></span></a>
            <br>

         </td>\n
     ";
        if($i==3){$i=0;echo"</tr><tr>";}
        $i++;

    }
    echo "</tr>";
    echo"</table>";

}else{
?>


<!--

  <input type="text" name="nome" value="<?php echo $nome;?>" placeholder="name of images"><input class="btn btn-info" type="submit" value="search">

-->

<div id="contenutoimmagini"></div>



<form enctype="multipart/form-data" id="form-id">
    <input name="nomefile" type="file" />
    <input class="button" type="button" value="Upload" />
</form>
<progress value="0"></progress>

    <br>

<script>
    $(document).ready(function(){

    //html5 uploader
    $('.button').click(function(){
        var formx = document.getElementById('form-id');
        var formData = new FormData(formx);
        $.ajax({
            url: 'media-popup.php?op=newfile',  //Server script to process data
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            //Ajax events
            success: completeHandler,
            error: errorHandler,
            // Form data
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });

        function completeHandler(){
            loadimages();
        }
        function errorHandler(){
            alert('errore caricamento');
        }
        function progressHandlingFunction(e){
            if(e.lengthComputable){
                $('progress').attr({value:e.loaded,max:e.total});
            }
        }
    });

        loadimages();

    });

    function inserisci(elemento){
        var link = $(elemento);
        var image = link.data('image');
        $('#image-url').val(image);


        var id= $('#image-url').data('id');
        $('#'+id).attr('src', $('#image-url').val()) ;
        $('#'+id).attr('width', $('#image-w').val()) ;
        $('#'+id).attr('height', $('#image-h').val()) ;

        $('#previewimg').modal('hide');
    }

    function loadimages(){

        var request = $.ajax({
            url: "media-popup.php?immagini=1",
            method: "POST",
            data: { nome : '' },
            dataType: "html"
        });

        request.done(function( msg ) {
            $( "#contenutoimmagini" ).html( msg );
        });

    }
</script>


<?php }   //else di immagini=1    ?>


<?php

function trovaStringa($text,$wordToSearch)
{
    $offset=0;
    $pos=0;
    while (is_integer($pos)){
        $pos = strpos($text,$wordToSearch,$offset);
        if (is_integer($pos)) {
            $arrPos[] = $pos;
            $offset = $pos+strlen($wordToSearch);
        }
    }
    if (isset($arrPos)) {
        return 1;
    }
    else {
        return 0;
    }
}

function makeSafe( $file ) {
    return str_replace( '..', '', urldecode( $file ) );
}


function getFullUrl() {
    if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])){
        $https = strlen($_SERVER['HTTPS']) != 0 && $_SERVER['HTTPS'] !== 'off';
    }$https="";
    return
        ($https ? 'https://' : 'http://').
        (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
        ($https && $_SERVER['SERVER_PORT'] === 443 ||
        $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
        substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
}
?>
