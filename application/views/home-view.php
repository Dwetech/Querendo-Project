<!doctype html>
<html lang="en">
<head>
    <?php $this->load->view('include/head.php'); ?>
</head>
<body>

<?php $this->load->view('include/header.php'); ?>
<?php $this->load->view('include/mainMenu-bar.php'); ?>
<?php $this->load->view('include/banner.php'); ?>
<?php $this->load->view('include/tiles.php'); ?>
<?php //$this->load->view('include/home-description.php'); ?>




<!--Modal Section-->


<?php $this->load->view('include/login-modal.php'); ?>
<?php $this->load->view('include/signup-modal.php'); ?>
<?php $this->load->view('include/forgot-password-modal.php'); ?>

<?php $this->load->view('include/footer.php'); ?>


</body>
</html>