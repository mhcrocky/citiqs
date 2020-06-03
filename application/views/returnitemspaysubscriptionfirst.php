<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

<style type="text/css">
    .thumbnail-file{
        width: 100px;
        height: 100px;
    }
    .thumbnail-file img{
        width: 100%;
        height: 100%;
        min-height: 100%;
        min-width: 100%;
        object-fit: cover;
    }
    .file_form input[type="file"], .file_form button{
        position: absolute;
        z-index: -1;
    }
</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>

      </h1>
    </section>

    <section class="content">

        <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error){
            ?>
            <div id="mydivs1">
                <div class="alert alert-danger alert-dismissable" id="mydivs">
                    <button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
            </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success){
            ?>
            <div class="alert alert-success alert-dismissable" id="mydivs2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>
            </div>
        <?php } ?>



    </section>
</div>

<form id="paysubscriptionfirst" action="" method="post" style="display: none;width:100%;max-width:400px;">
    <h2 class="mb-3">
        Good news! Your lost item has been found and it can be returned it to you.
    </h2>
    <p>
        However, you don't have a subscription yet. Please, press the link below to subscribe for 1 year its only € 1,50 a month.
    <p />After your payment, you can proceed to return the item to you.
    <p></p>
    <a href="<?php echo base_url() ?>/pay/3/<?php echo($email); ?>">Pay for your subscription</a>
    <p></p>
    <p class="mb-0 text-right">
        <input data-fancybox-close type="button" class="btn btn-primary" value="Close" />
    </p>
</form>


<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript">

    $(function() {
        $.fancybox.open({
            src: '#paysubscriptionfirst',
            type: 'inline'
        });
    });

</script>
<?php
if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
    unset($_SESSION['success']);
}
if(isset($_SESSION['message'])){
    unset($_SESSION['message']);
}
?>