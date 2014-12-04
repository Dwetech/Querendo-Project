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
        <h2>Deposit Fund</h2>
    </div>

    <div class="col-md-5 alert alert-warning">
        <form id="paypalForm" class="formPadding" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">


            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="<?php echo $this->settings_model->data['paypal_email'] ?>">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="item_name" value="Current Payment">
            <input type="hidden" name="item_number" id="item_number" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="return" id="return_url" value="<?php echo base_url('/payment/success') ?>">
            <input type="hidden" name="cancel_return" id="cancel_return"
                   value="<?php echo base_url('/payment/cancelled') ?>">
            <input type="hidden" name="notify_url" value="<?php echo base_url('/payment/ipn') ?>">


            <div class="bidActionForm">
                <div class="col-md-12">
                    <div class="form-group  has-feedback">
                        <label for="">I'd like to deposit :</label>
                        <input type="text" id="item_price" class="form-control bidFeed"
                               name="amount">

                        <span class="custom-feedback-left text-feedback">$</span>
                        <span class="custom-feedback-right text-feedback">USD</span>
                    </div>
                </div>
            </div>
            <div class="bidActionForm">
                <div class="col-md-12">
                    <div class="form-group noMargin">
                        <div class="form-action noMargin">
                            <input type="hidden" value="3" name="product_id">
                            <button type="submit" id="submit" name="submit" value="Submit"
                                    class="btn btn-primary pull-right">
                                Deposit Money
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>



