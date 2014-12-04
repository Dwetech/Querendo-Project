<?php
/*
  Created on : Jun 5, 2014, 2:26:51 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */
?>


<div class="bidList">

    <div class="bidListDetails">

        <?php $this->load->view('include/owner_awarded_bid') ?>
        <?php $this->load->view('include/owner_waiting_bid') ?>
        <?php $this->load->view('include/owner_regular_bid'); ?>

    </div>
</div>


<!-- MESSAGE MODAL -->
<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Enviar mensagem</h4>
            </div>
            <div class="modal-body">
                <div style="width: 100%;">
                    <label>To :</label>
                    <label class="label label-info" id="to_name"></label>
                </div>

                <label class="reviewText" for="">Mensagem :</label>
                <textarea class="form-control" type="text" id="chat_message" name="message"></textarea>
                <input type="hidden" id="product_id" name="product_id" value=""/>
                <input type="hidden" id="from_id" name="from_id" value=""/>
                <input type="hidden" id="to_id" name="to_id" value=""/>

                <div class="error_message"></div>
            </div>
            <div class="modal-footer">
                <button id="send_msg" name="send_msg" value="Send" type="button" class="btn btn-info"
                        onclick="querendo.initiate_chat('<?php echo base_url(); ?>')">Enviar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>