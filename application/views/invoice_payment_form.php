<!doctype html>
<html>
<head>
    <?php $this->load->view('include/head.php'); ?>

</head>
<body>

<?php $this->load->view('include/header-loggedIn.php'); ?>
<?php $this->load->view('include/mainMenu-bar-loggedIn.php'); ?>


<section class="dashboard">
    <div class="container">

        <div class="col-md-10 col-md-offset-1 noPadding">
            <div class="dashboard-section">
                <div class="page-header">
                    <h2>Pay Invoice</h2>
                </div>
            </div>

            <form class="form-horizontal" id="paypalForm" action="https://www.paypal.com/cgi-bin/webscr" method="post" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Invoice ID</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo $invoice->invoice_id ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Product Name</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo $invoice->name ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Invoice Date</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo $invoice->create_date ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Amount</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">R$ <?php echo toCurrency($invoice->payment) ?></p>
                    </div>
                </div>



                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="<?php echo $this->settings_model->data['paypal_email'] ?>">
                <input type="hidden" name="currency_code" value="BRL">
                <input type="hidden" name="item_name" value="Invoice - <?php echo $invoice->invoice_id ?>">
                <input type="hidden" name="item_number" id="item_number" value="<?php echo $invoice->invoice_id ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="return" id="return_url" value="<?php echo base_url('/payment/success') ?>">
                <input type="hidden" name="cancel_return" id="cancel_return"
                       value="<?php echo base_url('/payment/cancelled') ?>">
                <input type="hidden" name="notify_url" value="<?php echo base_url('/payment/ipn') ?>">
                <input type="hidden" value="3" name="product_id">
                <input type="hidden" id="item_price" value="<?php echo $invoice->payment ?>" name="amount">

                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button type="submit" id="submit" name="submit" value="Submit"
                                class="btn btn-primary">
                            Pay Invoice
                        </button>
                    </div>
                </div>


            </form>


        </div>

    </div>
</section>


<?php $this->load->view('include/footer.php'); ?>



</body>
</html>