<!doctype html>
<html lang="en-US">
<head>
    <?php $this->load->view('include/head.php'); ?>
    <script src="<?php echo base_url() . 'resources/js/querendo.js'; ?>" type="text/javascript"></script>


    <script src="<?php echo base_url() . 'resources/js/popup.js'; ?>" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>resources/css/popup.css"/>
    <script src="<?php echo base_url() . 'resources/js/popover.js'; ?>" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>resources/css/popover.css"/>

</head>
<body>

<?php
if ($this->auth->logged_in) {
    $this->load->view('include/header-loggedIn.php');
    $this->load->view('include/mainMenu-bar-loggedIn.php');
} else {
    $this->load->view('include/header-link.php');
    $this->load->view('include/mainMenu-bar.php');
}
?>

<?php $this->load->view('include/product-details.php'); ?>



<?php $this->load->view('include/footer.php'); ?>

<!--Modal Section-->


<?php $this->load->view('include/login-modal.php'); ?>
<?php $this->load->view('include/signup-modal.php'); ?>


</body>
<script>
    $(".sellerMap").tooltip();
</script>
</html>