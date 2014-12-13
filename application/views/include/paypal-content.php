<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>


<div class="finance_content">
    <div class="page-header">
        <h2>Paypal Withdrawal</h2>
    </div>

    <div class="col-md-6 alert alert-warning">

        <form class="form-horizontal formPadding" role="form" action="" method="post">
            <?php echo !empty($error) ? '<div class="alert alert-danger">' . $error . '</div>' : ''; ?>

            <?php echo $this->session->flashdata('lessBalance') ? '<div class="alert alert-danger">' . $this->session->flashdata('lessBalance') . '</div>' : ''; ?>
            <?php echo $this->session->flashdata('fatal') ? '<div class="alert alert-danger">' . $this->session->flashdata('fatal') . '</div>' : ''; ?>

            <div class="bidActionForm">
                <div class="form-group <?php echo form_error('email') ? 'has-error' : '' ?> noMargin">
                    <label for="email" class="col-sm-4 control-label">Paypal Email</label>

                    <div class="col-sm-8">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Paypal Email">
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                </div>
            </div>

            <div class="bidActionForm">
                <div class="form-group <?php echo form_error('amount') ? 'has-error' : '' ?> noMargin">
                    <label for="amount" class="col-sm-4 control-label">Amount</label>

                    <div class="col-sm-8">
                        <input type="amount" name="amount" class="form-control" id="amount" placeholder="Amount">
                        <span class="text-danger"><?php echo form_error('amount'); ?></span>
                    </div>
                </div>
            </div>

            <div class="bidActionForm">
                <div class="form-group noMargin">
                    <div class="col-md-12">
                        <div class="form-action">
                            <button onclick="window.location.href = '<?php echo base_url(); ?>finance/withdraw'"
                                    class="btn btn-default pull-right" type="button">Cancel
                            </button>
                            <button class="btn btn-primary pull-right mar-right-small" value="Submit" name="submit"
                                    type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>




