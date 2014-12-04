<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>

<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog login-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Forgot Password</h3>
            </div>
            <form role="form" action="<?php echo base_url(); ?>user_settings/forgot_password" method="post">
            <div class="modal-body">
                <div class="form-login">
                    <div class="col-md-10 col-md-offset-1">

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
                            </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" name="submit" value="Submit" class="btn btn-primary">Send Email</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
