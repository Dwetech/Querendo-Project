<!doctype html>
<html lang="en-US">
    <head>
        <?php $this->load->view('include/head.php'); ?>

    </head>
    <body>

        <?php $this->load->view('include/header-loggedIn.php'); ?>
        <?php $this->load->view('include/mainMenu-bar.php'); ?>

        <?php $this->load->view('include/product-edit.php'); ?>



        <?php $this->load->view('include/footer.php'); ?>

        <!--Modal Section-->


        <?php $this->load->view('include/login-modal.php'); ?>
        <?php $this->load->view('include/signup-modal.php'); ?>


    </body>
</html>