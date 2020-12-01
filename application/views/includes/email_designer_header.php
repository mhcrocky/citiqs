<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>editor email</title>

    <!-- styles -->

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/emaildesigner/css/colpick.css" rel="stylesheet"  type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/emaildesigner/css/themes/default.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/emaildesigner/css/template.editor.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/emaildesigner/css/responsive-table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var path = '<?= base_url(); ?>';
        var user_id = <?php echo $user->id; ?>;
        var images_path = '<?php echo $images_path; ?>';
        var template_id = <?php echo (isset($template_id) and $template_id) ? $template_id : 'false'; ?>;
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.2.6/plugins/colorpicker/plugin.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/emaildesigner/js/colpick.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/emaildesigner/js/template.editor.js"></script>


</head>