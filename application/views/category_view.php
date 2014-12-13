<!doctype html>
<html lang="en-US">
<head>
    <?php $this->load->view('include/head.php'); ?>

    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/isotope.min.js"></script>
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
                <div class="col-md-10 col-md-offset-1">
                    <?php $this->load->view('include/category-content'); ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $this->load->view('include/footer.php'); ?>



</body>
<script type="text/javascript">
    var $container = $('.categoryList');
    // init
    $container.isotope({
        // options
        itemSelector: '.ami'
//            layoutMode: 'fitRows'
    });
</script>
</html>


