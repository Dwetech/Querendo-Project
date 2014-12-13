<!doctype html>
<html lang="en-US">
<head>

    <?php $this->load->view('include/head.php'); ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() . 'resources/css/imgareaselect-default.css'; ?>"/>
    <script type="text/javascript" src=<?php echo base_url() . 'resources/js/jquery.imgareaselect.pack.js'; ?>></script>

</head>
<body>

<?php $this->load->view('include/header-loggedIn.php'); ?>
<?php $this->load->view('include/mainMenu-bar-loggedIn.php'); ?>


<section class="user-settings">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h3 class="text-bold">Detalhes da conta</h3>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal settingsForm" role="form"
                  action="<?php echo base_url() . 'user/settings/' . $this->uri->segment('3'); ?>" method="post"
                  enctype="multipart/form-data">

                <div class="col-sm-6 col-sm-offset-1">
                    <?php $this->load->view('include/user-settings-view.php'); ?>
                </div>
                <div class="col-sm-3 noPadding">
                    <?php $this->load->view('include/user-profilePicture-settings-view.php'); ?>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="form-action">
                            <button type="button" class="btn btn-default pull-right"
                                    onclick="window.location.href = '<?php echo base_url('user/view/' . $_SESSION['user_name']); ?>'">
                                Cancelar
                            </button>
                            <button type="submit" name="submit" value="Submit"
                                    class="btn btn-primary pull-right mar-right-small">Atualizar perfil
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>




<?php $this->load->view('include/footer.php'); ?>

</body>
</html>