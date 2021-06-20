<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
    $fail =  $this->session->flashdata('fail');
    if($fail) {
?>
    <div>
        <div class="alert alert-danger alert-dismissable">
            <span onclick="removeParent(this)">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </span>
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
            <span onclick="removeParent(this)">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </span>
            <?php echo $error; ?>
        </div>
    </div>
<?php
    }
    $success = $this->session->flashdata('success');
    if($success){
?>
    <div>
        <div class="alert alert-success alert-dismissable" >
            <span onclick="removeParent(this)">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </span>
            <?php echo $success; ?>
        </div>
    </div>
<?php 
    }
?>
<?php
    $warning =  $this->session->flashdata('warning');
    if($warning) {
?>
    <div>
        <div class="alert alert-warning alert-dismissable">
            <span onclick="removeParent(this)">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </span>
            <?php echo $warning; ?>
        </div>
    </div>
<?php 
    }
?>