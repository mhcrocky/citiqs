<script>
<?php
    $fail =  $this->session->flashdata('fail');
    if($fail) {
?>
    alertify.error('<?php echo $fail; ?>');
<?php 
    }
    $error = $this->session->flashdata('error');
    if($error) {
?>
    alertify.error('<?php echo $error; ?>');
<?php
    }
    $success = $this->session->flashdata('success');
    if($success){
?>
    alertify.success('<?php echo $success; ?>');
<?php 
    }
?>
</script>