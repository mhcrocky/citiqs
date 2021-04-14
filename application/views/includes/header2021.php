<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $pageTitle; ?></title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/makeOrder2021.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <?php
            include_once FCPATH . 'application/views/includes/customCss.php';
        ?>
    </head>
    <body>
