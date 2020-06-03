<?php
    $fail =  $this->session->flashdata('fail');
    if($fail) {
?>
    <div>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $fail; ?>
        </div>
    </div>
<?php 
    }
    $error = $this->session->flashdata('error');
    if($error) {
?>
    <div>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error; ?>
        </div>
    </div>
<?php
    }
    $success = $this->session->flashdata('success');
    if($success){
?>
    <div class="alert alert-success alert-dismissable" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $success; ?>
    </div>
<?php 
    }
?>