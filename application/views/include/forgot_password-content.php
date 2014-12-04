<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>

<div class="login-content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="login-content-data">

                <?php
                if (isset($send_mail)) {
                    ?>

                    <p class="alert alert-success text-center">
                        Check your mail to change your password.
                    </p>


                <?php
                } else {
                    ?>
                    <div class="form-login">
                        <div class="col-md-10 col-md-offset-1">
                            <div style="margin-bottom: 50px" class="page-header">
                                <h3 class="text-bold">Forgot Password</h3>
                            </div>

                            <?php echo isset($error) ? '<div class="alert alert-danger">' . $error . '</div>' : ''; ?>
                            <?php echo isset($user) ? '<div class="alert alert-danger">' . $user . '</div>' : ''; ?>
                            <form role="form" action="<?php echo base_url(); ?>user_settings/forgot_password"
                                  method="post">
                                <div class="form-group <?php echo isset($error) ? 'has-error' : ''; ?>">
                                    <input type="email" name="email" class="form-control" id="email"
                                           placeholder="Email Address">
                                </div>

                                <div class="form-group">
                                    <div class="form-action">
                                        <button type="button" class="btn btn-default pull-right"
                                                onclick="window.location.href = '<?php echo base_url(); ?>'">
                                            Cancel
                                        </button>
                                        <button type="submit" id="submit" name="submit" value="Submit"
                                                class="btn btn-primary pull-right mar-right-small">Send Email
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>
    </div>
</div>



