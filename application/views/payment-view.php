<!doctype html>
<html lang="en-US">
<head>
    <?php $this->load->view('include/head.php'); ?>

</head>
<body>

<?php
if( $this->auth->logged_in ) {
    $this->load->view('include/header-loggedIn.php');
    $this->load->view('include/mainMenu-bar-loggedIn.php');
} else {
    $this->load->view('include/header.php');
    $this->load->view('include/mainMenu-bar.php');
}
?>


<section class="dashboard">
    <div class="container">
        <div class="dashboard-section">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?php if($payment == 'success'){ ?>
                        <div class="alert alert-success text-bold text-center">
                            <h3>Payment Success</h3>
                            <p>Thank you for your payment.</p>
                        </div>
                    <?php } ?>
                    <?php if($payment == 'cancelled'){ ?>
                        <div class="alert alert-danger text-bold text-center"> Your payment is cancelled. </div>
                        <a href="<?php echo base_url('invoice') ?>" class="btn btn-default"> <span class="glyphicon glyphicon-arrow-left"></span> Back to Invoice</a>
                    <?php } ?>
                    <?php if($payment == 'ipn'){ ?>
                        <div class="alert alert-success text-bold text-center"> Your Paypal deposit is successfully completed. </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $this->load->view('include/footer.php'); ?>



</body>
</html>