<!doctype html>
<html lang="en-US">
<head>
    <?php $this->load->view('include/head.php'); ?>

</head>
<body>

<?php $this->load->view('include/header-loggedIn.php'); ?>
<?php $this->load->view('include/mainMenu-bar-loggedIn.php'); ?>


<section class="dashboard">
    <div class="container">
        <div class="dashboard-section">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?php $this->load->view('include/messages-content'); ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $this->load->view('include/footer.php'); ?>



</body>
</html>