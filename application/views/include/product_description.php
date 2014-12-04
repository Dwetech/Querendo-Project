<?php
/*
  Created on : Jun 5, 2014, 2:25:00 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */
?>
<div class="col-md-10 col-md-offset-1 noPadding">

    <?php
    if ($this->session->flashdata('error_balance')) {
        echo '<div class="alert alert-danger">' . $this->session->flashdata('error_balance') . '</div>';
    }
    if ($this->session->flashdata('error')) {
        echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
    }
    ?>

    <!--    <a name="bid"></a>-->

    <div class="productDescription">

        <h1 class="text-bold pull-left"><?php echo $product_data->name; ?></h1>

        <?php
        if ($this->auth->logged_in && $this->auth->is_active) {


            if ($product_data->product_status == 'running') {


                //if user has not made any bid on this product yet and the user is not owner of the product
                if ($my_bid == false && ($product_data->user_id != $_SESSION['user_id'])) {
                    ?>
                    <div class="col-md-5 noPadding pull-right">
                        <a onclick="showBid();" class="Bid_Product pull-right btn btn-success text-bold">Ofertar</a>
                    </div>


                    <?php
                }

                //DELETE||UPDATE PRODUCT
                //if the owner of the product is same as logged in user
                if ($product_data->user_id == $_SESSION['user_id']) {
                    ?>
                    <div class="col-md-5 noPadding pull-right">
                        <a href="<?php echo base_url() . 'product/edit/' . $product_data->product_id; ?>"
                           class="pull-right btn btn-success text-bold">Editar produto</a>
                        <a href="<?php echo base_url() . 'product/delete/' . $product_data->product_id; ?>"
                           onclick="return confirm('Tem certeza que deseja apagar este produto? Isso também deletará todos os lances neste produto.');"
                           class="pull-right btn btn-danger text-bold mar-right-small">Apagar produto</a>
                    </div>


                    <?php
                }
            }/* else if ($product_data->product_status == 'completed') {
              } */
        }
        ?>

        <?php
        if ($this->auth->logged_in && $this->auth->is_active) {


            if ($product_data->user_id == $_SESSION['user_id'] || ($bid_status && $bid_status->user_id == $_SESSION['user_id'])) {


                if ($product_data->product_status == 'completed') {//Giving review while product is completed
                    ?>

                    <div class="pull-right">


                        <?php
                        //If logged in user is product owner
                        if ($_SESSION['user_id'] == $product_data->user_id) {

                            $rating_value = User_model::get_review_by_product($awarded_bid->user_id, $product_data->product_id);
                            ?>


                            <input type="hidden" id="from_id" name="from_id" value="<?php echo $product_data->user_id; ?>"/>
                            <input type="hidden" id="to_id" name="to_id" value="<?php echo $awarded_bid->user_id; ?>"/>
                            <input type="hidden" id="type" name="type" value="seller" />
                            <?php
                            //If logged in user is bidder/bid owner
                        } else if ($_SESSION['user_id'] == $awarded_bid->user_id) {

                            $rating_value = User_model::get_review_by_product($product_data->user_id, $product_data->product_id);
                            ?>


                            <input type="hidden" id="from_id" name="from_id" value="<?php echo $awarded_bid->user_id; ?>"/>
                            <input type="hidden" id="to_id" name="to_id" value="<?php echo $product_data->user_id; ?>"/>
                            <input type="hidden" id="type" name="type" value="buyer" />
                            <?php
                        }
                        ?>
                        <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_data->product_id; ?>"/>






                        <?php
                        if ($invoice_data->status == 'paid') {
                            
                            if (empty($rating_value)) {
                                
                                ?>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#reviewModal">
                                    Avaliar
                                </button>
                                <?php
                            }
                        }
                        ?>


                    </div>

                    <?php
                }
            }
        }
        ?>
    </div>

    <div class="bidBudget well">
        <div class="col-md-7">
            <div class="bidBudgetDetails">
                <div class="activity">
                    <div class="activityInfo text-center">
                        <p class="activityIndex">Qtd. de ofertas<br>
                            <b class="text-blue text-large"><?php echo $bid_details->bid_count; ?></b></p>
                    </div>
                    <div class="activityInfo text-center">
                        <p class="activityIndex">Oferta média<br>
                            <b class="text-blue text-large">R$ <?php echo $bid_details->bid_avg ? number_format((float) $bid_details->bid_avg, 2, '.', '') : 0; ?></b>
                        </p>
                    </div>
                    <div class="activityInfo text-center">
                        <p class="activityIndex">Orçamento<br>
                            <?php if ($product_data->budget_type == 'fixed') { ?>
                                <b class="text-blue text-large">R$<?php echo $product_data->fixed_budget; ?></b>
                            <?php } else { ?>
                                <b class="text-blue text-large">R$<?php echo $product_data->min_budget . ' - R$' . $product_data->max_budget; ?></b>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="bidBudgetDetails dateRunning">
                <div class="activity pull-right">
                    <div class="activityInfo">
                        <p class="activityIndex text-info text-center">
                            <?php echo date('j M, Y', strtotime($product_data->create_date)) . '<span class="normalAsh text-small">(' . since_time($product_data->create_date) . ')</span>'; ?>
                            <br><b class="text-large"><?php echo $product_data->product_status ?></b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if ($this->auth->logged_in && $this->auth->is_active) {


        if (($product_data->user_id != $_SESSION['user_id']) && ($my_bid === False)) {


            $this->load->view('include/create_bid');
        } else if (($product_data->user_id != $_SESSION['user_id']) && ($my_bid !== False)) {


            $this->load->view('include/edit_bid');
        }
    }
    ?>

    <div class="budgetDescription">
        <div class="col-md-7 proDes">
            <div class="descriptionArea">
                <h4><b>Descrição do projeto:</b></h4>

                <p class="mar-top-small">
                    <?php echo nl2br($product_data->description); ?>
                </p>
            </div>
            <div class="descriptionArea">
                <h4><b>Condição do produto:</b></h4>

                <p class="mar-top-small">
                    <span class="label label-info"><?php echo nl2br($product_data->product_condition); ?></span>
                </p>
            </div>
            <div class="descriptionArea">
                <h4><b>Método de envio:</b></h4>

                <p class="mar-top-small">
                    <span class="label label-warning"><?php echo nl2br($product_data->shipping_method); ?></span>
                </p>
            </div>
        </div>
        <div class="col-md-5 proOwn">

            <div class="buyerData">
                <div class="col-md-8 buyDes" style="margin: 0;padding: 0">
                    <?php $buyerCountry = $this->user_model->getCountryCode($product_data->country); ?>
                    <h4><b>Sobre o comprador:</b></h4>

                    <p>
                        <a href="<?php echo base_url() ?>user/view/<?php echo $product_data->user_name; ?>/buyer"><b><?php echo $product_data->user_name; ?></b></a>
                        <span data-toggle="tooltip" title="<?php echo!empty($buyerCountry->iso_code_2) ? $buyerCountry->name : ''; ?>"
                              data-placement="right" class="sellerMap flag flag-<?php echo!empty($buyerCountry->iso_code_2) ? strtolower($buyerCountry->iso_code_2) : ''; ?>">
                        </span>
                    </p>

                    <div class="col-md-3" style="margin: 0;padding: 0">
                        <input id="input-21e" value="<?php echo $product_data->buyer_review; ?>" data-disabled="true" type="number"
                               class="rating rating_star" min="0" max="5" step="1" data-size="xs" data-show-caption="false" data-show-clear="false">
                    </div>

                    <div class="col-md-5 proDetailsReview">
                        <span class="proDetailsReview text-small">(<?php echo $product_data->buyer_review_count; ?> avaliações)</span>
                    </div>
                </div>
                <div class="col-md-4 pull-right noPadding buyImg">
                    <div class="profilePic pull-right">
                        <?php if (!empty($product_data->profile_pic)) { ?>
                            <img class="imgAuto" src="<?php echo base_url() . 'upload/profile_photo/' . $product_data->profile_pic; ?>" alt=""/>
                            <?php
                        } else {
                            ?>
                            <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="product_image">
                <h4><b>Imagens do produto:</b></h4>
                <div class="col-md-3 noPadding proImg">
                    <?php if (!empty($product_data->product_photo)) { ?>

                        <a href="<?php echo base_url() . 'upload/product_photo/' . $product_data->product_photo; ?>" class="image-popup-vertical-fit">
                            <img data-toggle="tooltip" data-placement="right" title="Clique para ampliar" class="imgAuto productImage" 
                                 src="<?php echo base_url() . 'upload/product_photo/' . $product_data->product_photo; ?>">
                        </a>


                    <?php } else { ?>


                        <a href="<?php echo base_url() . 'resources/img/no_image.gif'; ?>" class="image-popup-vertical-fit">
                            <img data-toggle="tooltip" data-placement="right" title="Clique para ampliar" class="imgAuto productImage"
                                 src="<?php echo base_url() . 'resources/img/no_image.gif'; ?>">
                        </a>


                    <?php } ?>
                </div>
            </div>


        </div>


    </div>
</div>


<div class="col-md-10 col-md-offset-1 noPadding">
    <?php
    if ($this->auth->logged_in && $product_data->user_id == $_SESSION['user_id']) {


        $this->load->view('include/owner_bid_view');
    } else {


        $this->load->view('include/user_bid_view');
    }
    ?>
</div>



<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <label for="">Avaliação:</label>
                <div class="review-custom">
                    <input id="input-21e" type="number" value="" class="rating rating_star" min="0" max="5" step="1" data-size="xs" 
                           data-show-caption="false" data-show-clear="True">
                </div>

                <label class="reviewText" for="">Mensagem de avaliação:</label>
                <textarea class="form-control" type="text" id="description" name="description"></textarea>
            </div>
            <div class="modal-footer">
                <button id="submit_rating" name="submit" data-loading-text="Working..." type="button" class="btn btn-info" style="">Avaliar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>



<script>
    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function() {

        /**
         * Updating rating value on rating change
         */
        $(".rating").on('rating.change', function(event, value, caption) {

            $("#input-21e").val(value);
        });

        $("#submit_rating").on('click', function() {

            //$("#submit_rating").attr('disabled', 'true');
            var btn = $(this)
            btn.button('loading');

            $("#input-21e").html();
            var product_id = $("#product_id").val();
            var user_id = $("#to_id").val();
            var from_id = $("#from_id").val();
            var rating = $("#input-21e").val();
            var message = $('#description').val();
            var type = $("#type").val();

            querendo.user_rating(product_id, user_id, from_id, rating, message, type);
        });
    });



    $('.chatSend').tooltip();
    $('.bidRemove').tooltip();
    $('.productImage').tooltip();

    $('.expand').click(function() {
        $(this).parent('.lessDescription').hide();
        $(this).parent('.lessDescription').next('.fullDescription').show();
    });

    $('.defeat').click(function() {
        $(this).parent('.fullDescription').hide();
        $(this).parent('.fullDescription').prev('.lessDescription').show();
    });

    $('.removeRelative').mouseenter(function() {
        $(this).find('.customPopover').stop().show();
    });
    $('.removeRelative').mouseleave(function() {
        $(this).find('.customPopover').stop().hide();
    });

</script>