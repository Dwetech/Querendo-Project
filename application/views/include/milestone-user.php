<?php //echo $this->session->flashdata('error_balance') ? '<div class="alert alert-danger">' . $this->session->flashdata('error_balance') . '</div>' : '';    ?>


<div class="user_milestone">
    <div class="alert alert-info">Converse com o comprador sobre o produto e o método de pagamento</div>
    <div>
        <?php
        if ($invoice_data) {
            ?>
            <div class='alert alert-warning'>
                Você deve pagar R$<?php echo number_format((float)$invoice_data->payment, 2, '.', ''); ?> para o Querendo. Este é o único modo de receber confiança para futuros negócios.
            </div>
            <a href="<?php echo base_url('invoice/pay/'.$invoice_data->invoice_id) ?>" class="btn btn-primary">Pagar agora</a>
        <?php
        }
        ?>
    </div>
    <!--
    >>>>>>>>>>>>>>>>>>v0.9<<<<<<<<<<<<<<<<<<<
    <div class="milestoneHead">
            <h3 class="pull-left">Milestones</h3>
            <a onclick="showMilestone();" id="milestoneTrigger" class="btn btn-primary pull-right" 
               style="<?php //echo $this->session->flashdata('error_milestone') ? 'display: none' : '';    ?>">Request Milestone</a>
        </div>-->


    <?php //echo $this->session->flashdata('error_milestone') ? '<div class="alert alert-danger">' . $this->session->flashdata('error_milestone') . '</div>' : ''; ?>

    <!--    <div style="<?php //echo $this->session->flashdata('error_milestone') ? '' : 'display:none';    ?>" id="milestoneForm" class="milestoneForm">
        <form method="post" action="<?php //echo base_url() . 'milestone/create';    ?>" >
            <div class="col-md-4">
                <div class="form-group has-feedback <?php //echo $this->session->flashdata('amount') ? 'has-error' : '';    ?>">
                    <label for="">Payment :</label>
                    <input type="text" placeholder="Amount" id="milestone_amount" class="form-control bidFeed" name="amount" pattern="[0-9]+([\.|,][0-9]+)?">
                    <span class="custom-feedback-left text-feedback">$</span>
                    <span class="custom-feedback-right text-feedback">USD</span>
    <?php //echo $this->session->flashdata('amount') ? '<span class="text-danger">' . $this->session->flashdata('amount') . '</span>' : '' ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="">Description :</label>
                    <input type="text" placeholder="Description" id="milestone_description" class="form-control" name="description">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-action">
                        <input type="hidden" value="<?php //echo $product_id;    ?>" name="product_id">
                        <input type="hidden" value="<?php //echo $from_id;    ?>" name="from_id">
                        <input type="hidden" value="<?php //echo $to_id;    ?>" name="to_id">
                        <input type="hidden" value="requested" name="status">
                        <input type="hidden" id="milestone_id" value="" name="milestone_id">
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
    >>>>>>>>>>>>v0.9.5<<<<<<<<<<<<<<<<
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
    /* $milestone_data = Milestone_model::get_milestone_by_product_and_user($product_id, $from_id, $to_id);


      if (!empty($milestone_data)) {


      foreach ($milestone_data as $milestone) { */
    ?>
                        <tr class="<?php //echo $milestone->status == 'released' ? 'success' : '';    ?>">
                            <td><?php //echo $milestone->amount;    ?></td>
                            <td><?php //echo $milestone->description;    ?></td>
                            <td><?php //echo $milestone->initiated_by == $_SESSION['user_id'] ? 'You' : 'Owner';    ?></td>
                            <td class="text-center"><?php //echo ucfirst($milestone->status);    ?></td>
    >>>>>>>>v0.9.5<<<<<<<<<<<<<<<<<<<<
    -->
    <!--
    >>>>>>>>>>>>>>v0.9<<<<<<<<<<<<<<<<<
    <td class="text-center">
                                <div class="btn-group">
    
    <?php //if ($milestone->to_id == $_SESSION['user_id'] && $milestone->status == 'requested') { ?>
    
    
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu mileWidth" role="menu">
                                            <li class="text-small text-left">
                                            </li>
                                            <li class="text-small text-left">
                                                <a onclick="updateMilestone(<?php //echo $milestone->id;    ?>);" class="edit_milestone<?php //echo $milestone->id;    ?>" href="javascript: void(0);"
                                                   data-id="<?php //echo $milestone->id;    ?>" data-amount="<?php //echo $milestone->amount;    ?>" 
                                                   data-description="<?php //echo $milestone->description;    ?>">Edit</a>
                                            </li>
                                        </ul>
    <?php //} ?>
                                </div>
                            </td>
    
                        </tr>
    <?php
    /* }
      } */
    ?>
            </tbody>
        </table>
        <hr>
    >>>>>>>>>>>>>>>>v0.9<<<<<<<<<<<<<<<<
    -->
    <!--
    >>>>>>>>>>>>>>v0.9.5<<<<<<<<<<<<<<<
    <div>
        <div>
            <div class="pull-left text-bold" style="width: 80px;">Total:</div>
            <div class="text-bold">$<?php //echo $milestone_sum->milestone_amount ? $milestone_sum->milestone_amount : '0';    ?></div>
        </div>
        <div class="text-success">
            <div class="pull-left text-bold" style="width: 80px;">Released:</div>
            <div class="text-bold">$<?php //echo $released_milestone_sum->released_milestone_amount ? $released_milestone_sum->released_milestone_amount : '0';    ?></div>
        </div>
    </div>
    -->
</div>


<script type="text/javascript">
    /**
     function showMilestone() {
     $('#milestoneForm').show();
     $('#milestoneTrigger').hide();
     }
     function hideMilestone() {
     
     //empty amount and description fields
     $("#milestone_amount").val('');
     $("#milestone_description").val('');
     
     //changing submit type
     $("#milestone_id").val('');
     
     
     $('#milestoneForm').hide();
     $('#milestoneTrigger').show();
     }
     function updateMilestone(milestone_id) {
     
     showMilestone();//make the form visible
     $("#post_type").val('update');
     
     //get data
     var milestone_id = milestone_id;
     var amount = $(".edit_milestone" + milestone_id).attr('data-amount');
     var description = $(".edit_milestone" + milestone_id).attr('data-description');
     
     //put data into fields
     $("#milestone_id").val(milestone_id);
     $("#milestone_amount").val(amount);
     $("#milestone_description").val(description);
     }
     **/
</script>