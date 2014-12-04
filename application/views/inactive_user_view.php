<?php

/* 
    Created on : Jun 15, 2014, 5:40:24 PM
    Author        : me@rafi.pro
    Name         : Mohammad Faozul Azim Rafi
*/

?>
<!doctype html>
<html lang="en-US">
    <head>
        <?php $this->load->view('include/head.php'); ?>

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

        <?php $this->load->view('include/inactive_user_content.php'); ?>



        <?php $this->load->view('include/footer.php'); ?>

        <!--Modal Section-->


        <?php $this->load->view('include/login-modal.php'); ?>
        <?php $this->load->view('include/signup-modal.php'); ?>


    </body>
    <script>
        $(".sellerMap").tooltip();
    </script>
</html>