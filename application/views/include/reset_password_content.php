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
        <div class="col-md-8 col-md-offset-2">
            <div class="login-content-data">


                <div class="form-login">
                    <div class="col-md-10 col-md-offset-1">
                        <div style="margin-bottom: 50px" class="page-header">
                            <h3 class="text-bold">Reset Password</h3>
                        </div>
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <label for="new" class="col-sm-4 control-label">New Password</label>

                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="new" id="new" placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="con" class="col-sm-4 control-label">Confirm Password</label>

                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="con" id="con" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-action">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>"/>
                                    <button type="button" class="btn btn-default pull-right"
                                            onclick="window.location.href = '<?php echo base_url(); ?>'">
                                        Cancel
                                    </button>
                                    <button type="submit" id="submit" name="submit" value="Submit"
                                            class="btn btn-primary pull-right mar-right-small">Login Now
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



