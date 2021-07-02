
<?php
    $fail =  $this->session->flashdata('fail');  
    if ($fail) {
?>
    <script>alertify.error('<?php echo $fail; ?>');</script>
<?php 
    }
    $error = $this->session->flashdata('error');
    if ($error) {
?>
    <script>alertify.error('<?php echo $error; ?>');</script>
<?php
    }
    $success = $this->session->flashdata('success');
    if ($success) {
?>
    <script>alertify.success('<?php echo $success; ?>');</script>
<?php 
    }
    if (!empty($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    if (!empty($_SESSION['fail'])) {
        unset($_SESSION['fail']);
    }
    if (!empty($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
?>
