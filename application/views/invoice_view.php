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

                <?php $this->load->view('include/invoice_content'); ?>
            </div>
        </section>


        <?php $this->load->view('include/footer.php'); ?>



    </body>
</html>