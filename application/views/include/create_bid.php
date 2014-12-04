<?php
/*
  Created on : Jun 5, 2014, 1:28:21 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */
?>
<?php echo $this->session->flashdata('error') ? '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>' : ''; ?>
<div
    class="bidOption" <?php echo $this->session->flashdata('error') ? 'style="display:inline-block;"' : 'style="display:none;"'; ?>>


    <div class="col-md-12">
        <form action="<?php echo base_url('bid/create/' . $this->uri->segment('3')); ?>" enctype="multipart/form-data"
              method="POST">
            <div class="bidForm">
                <div class="bidActionForm">
                    <div class="col-md-3">
                        <div
                            class="form-group <?php echo $this->session->flashdata('bid_amount') ? 'has-error' : '' ?> has-feedback">
                            <label for="">Valor da oferta :</label>
                            <input pattern="\d*" type="text" name="bid_amount" class="form-control bidFeed" id="bid"
                                   placeholder="Preço">

                            <span class="custom-feedback-left text-feedback">R$</span>
                            <span class="custom-feedback-right text-feedback">Reais</span>
                        </div>
                        <?php echo $this->session->flashdata('bid_amount') ? '<span class="text-danger">' . $this->session->flashdata('bid_amount') . '</span>' : '' ?>
                    </div>
                    <div class="col-md-2">
                        <div
                            class="form-group <?php echo $this->session->flashdata('delivery_time') ? 'has-error' : '' ?> has-feedback">
                            <label for="">Entrega em :</label>
                            <input type="text" name="delivery_time" class="form-control" id="deliver">
                            <span class="custom-feedback-right text-feedback">Dias</span>
                        </div>
                        <?php echo $this->session->flashdata('delivery_time') ? '<span class="text-danger">' . $this->session->flashdata('delivery_time') . '</span>' : '' ?>
                    </div>
                    <div class="col-md-3">
                        <div
                            class="form-group <?php echo $this->session->flashdata('product_condition') ? 'has-error' : '' ?>">
                            <label>Condição do produto :</label>
                            <select name="product_condition" class="form-control">
                                <option value="New">Novo</option>
                                <option value="Old">Usado</option>
                                <option value="Any">Qualquer</option>
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
                                        data-content="O Querendo cobra uma comissão de <?php echo $this->settings_model->getSettings('fee_percent') ?>% do valor da negociação concretizada."
                                        title="" data-placement="right" data-toggle="popover"
                                        class="glyphicon glyphicon-info-sign info_data mar-right-small">

                                    </span>
                                    Você receberá :
                                    <span class="normalAsh mar-left-small">R$<span id="milePercent">0.00</span> Reais</span>

                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div
                            class="form-group <?php echo $this->session->flashdata('proposal_text') ? 'has-error' : '' ?>">
                            <label>Descrição da proposta :</label>
                            <textarea name="proposal_text" class="form-control"></textarea>
                        </div>
                        <?php echo $this->session->flashdata('proposal_text') ? '<span class="text-danger">' . $this->session->flashdata('proposal_text') . '</span>' : '' ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-action noMargin">
                    <input type="hidden" name="product_id" value="<?php echo $this->uri->segment('3'); ?>"/>
                    <button class="btn btn-primary" value="Submit" name="submit" id="submit" type="submit">
                        Ofertar
                    </button>
                    <a class="btn btn-default" onclick="showBid();">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>


<script>
    $(".info_data").popover({
        'trigger': 'hover'
    });


    $('#deliver').keyup(function () {
        if(!this.value.match(/^-?\d*\.?\d+$/)){
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }

    });
    $('#deliver').on('change', function () {
        if(!this.value.match(/^-?\d*\.?\d+$/)){
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    $('#bid').keyup(changeGetPaidValue);
    $('#bid').on('change', changeGetPaidValue);

    function changeGetPaidValue() {

        if(!this.value.match(/^-?\d*\.?\d+$/)){
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }

        var bid = $('#bid').val();
        var check = bid.length;
        if (check > 8) {
            $('#bid').val('');
            bid = 0;
        }

        var fee_percent = <?php echo $this->settings_model->getSettings('fee_percent') ?>;
        var percent = bid * (fee_percent / 100);
        var paid = bid - percent;

        $('#milePercent').empty().html(paid);
    }


</script>