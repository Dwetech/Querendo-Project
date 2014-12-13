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


<section class="user-details">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 noPadding">
                <div class="sector">

                    <div role="toolbar" class="btn-toolbar">
                        <div class="btn-group btn-group-lg pull-right">
                            <a href="<?php echo base_url(); ?>user/view/<?php echo $user->user_name; ?>" class="btn  <?php echo $userCat == 'seller' ? 'btn-default active' : 'btn-info' ?>" type="button">Visão de vendedor</a>
                            <a href="<?php echo base_url(); ?>user/view/<?php echo $user->user_name; ?>/buyer" class="btn  <?php echo $userCat == 'buyer' ? 'btn-default active' : 'btn-info' ?>" type="button">Visão de comprador</a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 noPadding">
                <?php $this->load->view('include/user-sidebar.php'); ?>
                <?php $this->load->view('include/user-details.php'); ?>
            </div>
        </div>
    </div>
</section>



<?php $this->load->view('include/footer.php'); ?>


</body>
</html>