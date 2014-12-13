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


<section class="user-settings">
    <div class="container">
        <div class="dashboard-section">
            <div class="row">
                <div class="col-md-2 col-md-offset-1">
                    <?php $this->load->view('include/category-product-content_sidebar'); ?>
                </div>
                <div class="col-md-8">
                    <?php $this->load->view('include/category-product-content'); ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $this->load->view('include/footer.php'); ?>



</body>
</html><?php
/**
 * Created by PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 10/28/2014
 * Time: 4:03 AM
 */ 