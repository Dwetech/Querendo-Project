<?php

/* 
    Created on : Jun 5, 2014, 3:42:18 PM
    Author        : me@rafi.pro
    Name         : Mohammad Faozul Azim Rafi
*/

?>
<?php
/*
  Created on : Jun 5, 2014, 1:28:21 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */
?>
<?php echo $this->session->flashdata('error') ? '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>' : ''; ?>
<div style="display: none" class="bidOption">
    
    
    
    <div class="col-md-12">
        <form action="<?php echo base_url('bid/update/'.$this->uri->segment('3')); ?>" enctype="multipart/form-data" method="POST">
            <div class="bidForm">
                <input type="hidden" name="product_id" value="<?php echo $this->uri->segment('3'); ?>"/>
                <input type="hidden" name="bid_id" value="<?php echo $my_bid->id; ?>"/>
                <input type="hidden" name="product_image" value="<?php echo $my_bid->product_image; ?>"/>
                <div class="bidActionForm">
                    <div class="col-md-3">
                        <div class="form-group <?php echo $this->session->flashdata('bid_amount') ? 'has-error' : '' ?> has-feedback">
                            <label for="">Valor :</label>
                            <input pattern="\d*" type="text" name="bid_amount" class="form-control bidFeed" id="bid"
                                   placeholder="Pago à você" value="<?php echo $my_bid->bid_amount ? $my_bid->bid_amount : ''; ?>">

                            <span class="custom-feedback-left text-feedback">R$</span>
                            <span class="custom-feedback-right text-feedback">Reais</span>
                        </div>
                        <?php echo $this->session->flashdata('bid_amount') ? '<span class="text-danger">' . $this->session->flashdata('bid_amount') . '</span>' : '' ?>
                    </div>
                    <div class="col-md-2">
                        <div
                            class="form-group <?php echo $this->session->flashdata('delivery_time') ? 'has-error' : '' ?> has-feedback">
                            <label for="">Entrega em :</label>
                            <input type="text" name="delivery_time" class="form-control" id="deliver" value="<?php echo $my_bid->delivery_time ? $my_bid->delivery_time : ''; ?>">
                            <span class="custom-feedback-right text-feedback">Dias</span>
                        </div>
                        <?php echo $this->session->flashdata('delivery_time') ? '<span class="text-danger">' . $this->session->flashdata('delivery_time') . '</span>' : '' ?>
                    </div>
                    <div class="col-md-3">
                        <div
                            class="form-group <?php echo $this->session->flashdata('product_condition') ? 'has-error' : '' ?>">
                            <label>Condição do produto :</label>
                            <select name="product_condition" class="form-control">
                                <option value="New" <?php echo $my_bid->product_condition == 'New' ? 'selected="selected"' : ''; ?>>Novo</option>
                                <option value="Old" <?php echo $my_bid->product_condition == 'Old' ? 'selected="selected"' : ''; ?>>Usado</option>
                                <option value="Any" <?php echo $my_bid->product_condition == 'Any' ? 'selected="selected"' : ''; ?>>Qualquer</option>
                            </select>
                        </div>
                        <?php echo $this->session->flashdata('product_condition') ? '<span class="text-danger">' . $this->session->flashdata('product_condition') . '</span>' : '' ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Imagem do produto :</label>
                            <input class="btn btn-default" type="file" name="userfile"/>
                        </div>
                    </div>
                </div>
                <div class="bidActionForm">
                    <div class="col-md-5">
                        <div class="alert alert-warning percentageBid">
                            <div class="form-group noMargin <?php echo $this->session->flashdata('milestone_request') ? 'has-error' : '' ?> has-feedback">
                                <label for="">
                                    <span
                                        data-original-title="Seu pagamento"
                                        data-content="O Querendo cobra uma comissão de 10% do valor da negociação concretizada."
                                        title="" data-placement="right" data-toggle="popover"
                                        class="glyphicon glyphicon-info-sign info_data mar-right-small">

                                    </span>
                                    Você receberá :
                                    <span class="normalAsh mar-left-small">R$<span id="milePercent"><?php echo ($my_bid->bid_amount-$my_bid->bid_amount*(0.1)); ?></span> Reais</span>

                                </label>
                                <input type="hidden" name="querendo" id="querendo" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div
                            class="form-group <?php echo $this->session->flashdata('proposal_text') ? 'has-error' : '' ?>">
                            <label>Descrição da proposta :</label>
                            <textarea name="proposal_text" class="form-control"><?php echo $my_bid->proposal_text ? $my_bid->proposal_text : ''; ?></textarea>
                        </div>
                        <?php echo $this->session->flashdata('proposal_text') ? '<span class="text-danger">' . $this->session->flashdata('proposal_text') . '</span>' : '' ?>
                    </div>
                    <div class="col-md-2">
                        <div class="profile-picture">
                            <?php if ($my_bid->product_image) { ?>
                                <img class="imgAuto" src="<?php echo base_url() . 'upload/bid_photo/' . $my_bid->product_image; ?>" />
                            <?php } else { ?>
                                <img class="imgAuto" src="<?php echo base_url() . 'resources/img/no_image.gif'; ?>" />
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-action">
                    <input type="hidden" name="product_id" value="<?php echo $this->uri->segment('3'); ?>"/>
                    <button class="btn btn-primary" value="Submit" name="submit" id="submit" type="submit">
                        Ofertar
                    </button>
                    <a class="btn btn-default" onclick="showBid();">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    $(".info_data").popover({
        'trigger':'hover'
    });


    $('#deliver').keyup(function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });
    $('#deliver').on('change',function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });

    $('#bid').keyup(function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');

        var bid = $('#bid').val();
        var check = bid.length;
        if (check > 8) {
            $('#bid').val('');
            bid = 0;
        }

        var percent = bid * (10 / 100);
        var paid = bid - percent;

        $('#milePercent').empty().html(paid);
        $('#querendo').val(percent);
    });
    $('#bid').on('change',function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');

        var bid = $('#bid').val();
        var check = bid.length;
        if (check > 8) {
            $('#bid').val('');
            bid = 0;
        }

        var percent = bid * (10 / 100);
        var paid = bid - percent;

        $('#milePercent').empty().html(paid);
        $('#querendo').val(percent);
    });


</script>