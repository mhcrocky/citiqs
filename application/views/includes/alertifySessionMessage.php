
<?php
    $fail =  $this->session->flashdata('fail');  
    if($fail) {
?>
    <script>alertify.error('<?php echo $fail; ?>');</script>
<?php 
    }
    $error = $this->session->flashdata('error');
    if($error) {
?>
    <script>alertify.error('<?php echo $error; ?>');</script>
<?php
    }
    $success = $this->session->flashdata('success');
    if($success){
?>
    <script>alertify.success('<?php echo $success; ?>');</script>
<?php 
    }
?>
