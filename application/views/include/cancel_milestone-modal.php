<?php
/*
  Created on : Jun 18, 2014, 2:03:02 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

?>


<div class="modal fade" id="cancel_milestoneModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog login-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Why You Want To Cancel The Milestone?</h3>
            </div>
            <div class="modal-body">


                <form action="<?php echo base_url() . 'milestone/submit_cancel'; ?>" method="post" role="form">
                    <div class="form-login">
                        <div class="col-md-10 col-md-offset-1">


                            <div class="form-group">
                                <label>Message to Admin: </label>
                                <textarea class="form-control" name="message" cols="8" rows="5"></textarea>
                                <input type="hidden" value="<?php echo $milestone_id; ?>" name="milestone_id"/>
                                <input type="hidden" value="<?php echo $product_id; ?>" name="product_id"/>
                                <input type="hidden" value="<?php echo $awarded_user; ?>" name="awarded_user"/>
                                <input type="hidden" value="owner" name="user_type"/>
                            </div>

                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" name='submit' value="Submit" class="btn btn-primary">Send Email</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


