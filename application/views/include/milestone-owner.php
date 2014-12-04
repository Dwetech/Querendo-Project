<?php //echo $this->session->flashdata('error_balance') ? '<div class="alert alert-danger">' . $this->session->flashdata('error_balance') . '</div>' : ''; ?>


<div class="user_milestone">
    <div class="alert alert-info">Converse com o ofertante sobre o produto e o método de pagamento.</div>
<!--
>>>>>>>>>>>>>>>>>>v0.9<<<<<<<<<<<<<<<<<<<
<div class="milestoneHead">
        <h3 class="pull-left">Milestones</h3>
        <a onclick="showMilestone();" id="milestoneTrigger" class="btn btn-primary pull-right"
           style="<?php //echo $this->session->flashdata('error_milestone') ? 'display: none' : ''; ?>">Send Milestone</a>
    </div>-->


    <?php //echo $this->session->flashdata('error_milestone') ? '<div class="alert alert-danger">' . $this->session->flashdata('error_milestone') . '</div>' : ''; ?>

<!--    <div style="<?php //echo $this->session->flashdata('error_milestone') ? '' : 'display:none'; ?>" id="milestoneForm" class="milestoneForm">
        <form method="post" action="<?php //echo base_url() . 'milestone/create'; ?>" >
            <div class="col-md-4">
                <div class="form-group has-feedback <?php //echo $this->session->flashdata('amount') ? 'has-error' : ''; ?>">
                    <label for="">Milestone :</label>
                    <input type="text" placeholder="Amount" id="" class="form-control bidFeed" name="amount" pattern="[0-9]+([\.|,][0-9]+)?">
                    <span class="custom-feedback-left text-feedback">$</span>
                    <span class="custom-feedback-right text-feedback">USD</span>
                    <?php //echo $this->session->flashdata('amount') ? '<span class="text-danger">' . $this->session->flashdata('amount') . '</span>' : '' ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="">Description :</label>
                    <input type="text" placeholder="Description" id="" class="form-control" name="description">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-action">
                        <input type="hidden" value="<?php //echo $product_id; ?>" name="product_id">
                        <input type="hidden" value="<?php //echo $from_id; ?>" name="from_id">
                        <input type="hidden" value="<?php //echo $to_id; ?>" name="to_id">
                        <input type="hidden" value="accepted" name="status">
                        <button type="submit" id="submit" name="submit" value="Submit" class="btn btn-primary">Submit</button>
                        <a onclick="hideMilestone();" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
>>>>>>>>>>>>>>>>v0.9<<<<<<<<<<<<<<<<<<<<<
-->
<!--
>>>>>>>>>>>>>>v0.9<<<<<<<<<<<<<<<<<


    <table class="table table-striped noBorder">
        <thead class="tableHead">
        <th width="80">Amount</th>
        <th>Description</th>
        <th width="60" class="text-center">From</th>
        <th width="100" class="text-center">Status</th>
        <th width="100" class="text-center">Action</th>
        </thead>
        <tbody>
            <?php
            //GET MILESTONE DATA BETWEEN PRODUCT OWNER AND ACCEPTED BIDDER
            //$milestone_data = Milestone_model::get_milestone_by_product_and_user($product_id, $from_id, $to_id);


            //if (!empty($milestone_data)) {


                //foreach ($milestone_data as $milestone) {
                    ?>
                    <tr class="<?php //echo $milestone->status == 'released' ? 'success' : ''; ?>">
                        <td><?php //echo $milestone->amount; ?></td>
                        <td><?php //echo $milestone->description; ?></td>
                        <td><?php //echo $milestone->initiated_by == $_SESSION['user_id'] ? 'You' : 'Bidder'; ?></td>
                        <td class="text-center"><?php //echo ucfirst($milestone->status); ?></td>
                        <td class="text-center">
                            <div class="btn-group">

                                <?php //if ($milestone->status != 'cancelled' && $milestone->status != 'released' && $milestone->status != 'pending') { ?>


                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu mileWidth" role="menu">
                                        <?php //if ($milestone->to_id != $_SESSION['user_id'] && $milestone->status != 'accepted') { ?>
                                            <li class="text-small text-left">
                                                <a onclick="return confirm('Are you sure you want to ACCEPT this milestone?');"
                                                   href="<?php //echo base_url() . 'milestone/accept/' . $milestone->id; ?>">Accept</a>
                                            </li>
                                        <?php //} ?>
                                        <li class="text-small text-left">
                                            <a onclick="return confirm('Are you sure you want to RELEASE this milestone?');" 
                                               href="<?php //echo base_url() . 'milestone/release/' . $milestone->id; ?>">Release</a>
                                        </li>
                                        <li class="text-small text-left">
                                            <?php //if ($milestone->status == 'accepted') { ?>
                                                <a href="#" data-toggle='modal' data-target='#cancel_milestoneModal'>Cancel</a>
                                            <?php //} ?>
                                        </li>
                                    </ul>


                                <?php //} ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                    /*$data['milestone_id'] = $milestone->id;
                    $data['product_id'] = $product_id;
                    $data['awarded_user'] = $awardedUser;
                    $this->load->view('include/cancel_milestone-modal', $data);
                }
            }*/
            ?>
        </tbody>
    </table>
    <hr>
    <div>
        <div>
            <div class="pull-left text-bold" style="width: 80px;">Total:</div>
            <div class="text-bold">$<?php //echo $milestone_sum->milestone_amount ? $milestone_sum->milestone_amount : '0'; ?></div>
        </div>
        <div class="text-success">
            <div class="pull-left text-bold" style="width: 80px;">Released:</div>
            <div class="text-bold">$<?php //echo $released_milestone_sum->released_milestone_amount ? $released_milestone_sum->released_milestone_amount : '0'; ?></div>
        </div>
    </div>
>>>>>>>>>>>>>>>>v0.9<<<<<<<<<<<<<<<<
-->
</div>

<script type="text/javascript">
    /**
    function showMilestone() {
        $('#milestoneForm').show();
        $('#milestoneTrigger').hide();
    }
    function hideMilestone() {
        $('#milestoneForm').hide();
        $('#milestoneTrigger').show();
    }
            **/
</script>