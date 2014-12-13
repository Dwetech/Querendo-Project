<?php
$bid_status = '';
$data['awardedUser'] = $awardedUser = '';
$product_owner_id = '';

//check whether the product is already awarded or not
$waitingCheck = $this->product_model->checkStatus($product_data->product_id, 'Waiting');


if (!empty($bids)) {

    //if the product is already awarded
    if ($waitingCheck) {
        ?>

        <table class="table awarded">
        <thead>
        <tr class="tableHead">
            <th>Ofertante</th>
            <th width="170px" class="text-center">Valor</th>
            <th width="100px"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($bids as $bid) {


            if ($bid->status == 'Waiting') {

                //Getting awarded user
                $data['awardedUser'] = $awardedUser = $bid->user_id;
                $bid_status = $bid->status;
                $bid_id = $bid->bid_id;
                $product_owner_id = $product_data->user_id;
                ?>
                <tr>
                    <td>
                        <div class="col-sm-11 noPadding">
                            <div class="col-sm-2 noPadding text-center">
                                <?php if (!empty($bid->profile_pic)) { ?>
                                    <div class="profile-picture-img">
                                        <img class="imgAuto bid_list_profile_pic "
                                             src="<?php echo base_url() . 'upload/profile_photo/' . $bid->profile_pic; ?>"
                                             alt=""/>
                                    </div>
                                <?php
                                } else {
                                    ?>
                                    <div class="profile-picture-img">
                                        <img class="imgAuto bid_list_profile_pic"
                                             src="<?php echo base_url() . 'resources/img/blank.png' ?>" alt=""/>
                                    </div>
                                <?php
                                }
                                ?>
                                <a class="text-small text-center" href="#"><?php echo $bid->seller_review_count; ?>
                                    Avaliações</a>
                                <input id="input-21e"
                                       value="<?php echo $bid->seller_review; ?>" class="rating rating_star"
                                       min="0" max="5" step="1" data-size="xs" data-disabled="true"
                                       data-show-caption="false" data-show-clear="false">
                            </div>
                            <div class="col-sm-9">
                                <a href="<?php echo base_url() ?>user/view/<?php echo $bid->user_name; ?>"
                                   class="text-bold"><?php echo $bid->user_name; ?>
                                    <span data-toggle="tooltip"
                                          title="<?php echo!empty($country->iso_code_2) ? $country->name : ''; ?>"
                                          data-placement="left"
                                          class="sellerMap flag flag-<?php echo!empty($country->iso_code_2) ? strtolower($country->iso_code_2) : ''; ?>"></span>
                                </a>

                                <p class="text-small noPadding lightAsh"><?php echo timespan(mysql_to_unix($bid->create_date)); ?>
                                    ago</p>

                                <p class="text-small_custom lessDescription">
                                    <?php
                                    if (strlen($bid->proposal_text) > 100) {
                                        echo substr($bid->proposal_text, 0, 100) . ' ... ... ... <a class="expand text-info pointer"><b>(more)</b></a>';
                                    } else {
                                        echo $bid->proposal_text;
                                    }
                                    ?>
                                </p>

                                <p style="display: none" class="text-small_custom fullDescription">
                                    <?php echo $bid->proposal_text . '<br><a class="defeat text-info pointer"><b>(less)</b></a>'; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-1 noPadding">
                            <?php if (!empty($bid->product_image)) { ?>
                                <a href="<?php echo base_url() . 'upload/bid_photo/' . $bid->product_image; ?>" class="image-popup-vertical-fit">
                                    <img data-toggle="tooltip" data-placement="right" title="Clique para ampliar" class="imgAuto productImage"
                                         src="<?php echo base_url() . 'upload/bid_photo/' . $bid->product_image; ?>">
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url() . 'resources/img/no_image.gif'; ?>" class="image-popup-vertical-fit">
                                    <img data-toggle="tooltip" data-placement="right" title="Clique para ampliar" class="imgAuto productImage"
                                         src="<?php echo base_url() . 'resources/img/no_image.gif'; ?>">
                                </a>
                            <?php } ?>
                        </div>
                    </td>
                    <td class="text-center removeRelative" id="acceptBid">
                        <h4 class="text-bold noMargin">$<?php echo number_format((float)$bid->bid_amount, 2, '.', ''); ?></h4>

                        <p class="noPadding normalAsh">Em <b><?php echo $bid->delivery_time; ?></b> dia(s)</p>


                        <?php
                        //IF USER IS LOGGED IN AND STATUS IS ACTIVE
                        if ($this->auth->logged_in && $this->auth->is_active) {

                            /**
                             * IF THE OWNER OF THE PRODUCT IS THE LOGGED IN USER,
                             * THE FOLLOWING PART WILL BE VISIBLE
                             */
                            if ($bid->bidder_id == $_SESSION['user_id'] || $product_data->user_id == $_SESSION['user_id']) {


                                //IF THE PRODUCT STATUS IS COMPLETED
                                if ($product_data->product_status == 'completed') {
                                    ?>
                                    <span class="label label-info">Projeto completo</span>

                                    <?php
                                    //IF THE PRODUCT STATUS IS NOT COMPLETED
                                } else {


                                    /**
                                     * IF THE BIDDER GETS ALL THE MONEY HE/SHE WANTED DURING BIDDING,
                                     * IT WILL BE POSSIBLE TO MARK THIS PROJECT AS COMPLETED
                                     */
                                    /* if ($released_milestone_sum->released_milestone_amount >= $bid->bid_amount) {
                                      ?>
                                      <a onclick="return confirm('Are you sure you want to mark this project as COMPLETED?');"
                                      href="<?php echo base_url() . 'product/complete/' . $product_data->product_id; ?>"
                                      class="pull-right btn btn-success text-bold">Complete Project</a>
                                      <?php
                                      //IF THE BIDDER STILL NOT HAVE THE BIDDING PRICE
                                      } else { */

                                    if ($product_data->transaction_status == 'none') {


                                        //IF THE BID STATUS IS REGULAR
                                        if ($bid->status == 'Regular') {
                                            ?>
                                            <a class="btn btn-primary" href="<?php echo base_url() . 'bid/accept/' . $bid->bid_id; ?>"
                                               onclick="return confirm('Tem certeza que deseja aceitar esta oferta?')">Aceitar</a>


                                            <?php
                                            //IF THE PRODUCT OWNER HAS CHOSEN A BIDDER AND WAITING FOR THE CONFIRMATION
                                        } else if ($bid->status == 'Waiting') {
                                            ?>


                                            <label class="label label-warning">Aguardando</label>
                                        <?php
                                        } else {
                                            ?>
                                            <div class="label label-success">Aceita</div>
                                        <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </td>
                    <td class="removeRelative">
                        <div class="actionButton">
                            <?php
                            //IF USER IS LOGGED IN AND STATUS IS ACTIVE
                            if ($this->auth->logged_in && $this->auth->is_active) {

                                /**
                                 * IF THE OWNER OF THE PRODUCT IS THE LOGGED IN USER THE FOLLOWING,
                                 * PART WILL BE VISIBLE
                                 */
                                if ($bid->bidder_id == $_SESSION['user_id'] || $product_data->user_id == $_SESSION['user_id']) {


                                    /*//IF THE PRODUCT STATUS IS COMPLETED
                                    if ($product_data->product_status == 'completed') {


                                        //IF THE PRODUCT STATUS IS NOT COMPLETED
                                    } else {


                                        //IF THE BIDDER GETS ALL THE MONEY HE/SHE WANTED DURING BIDDING
                                          //IT WILL BE POSSIBLE TO MARK THIS PROJECT AS COMPLETED
                                          //if ($released_milestone_sum->released_milestone_amount >= $bid->bid_amount) {

                                          //IF THE BIDDER STILL NOT HAVE THE BIDDING PRICE
                                          //} else {
                                        if ($product_data->transaction_status == 'none') {


                                            //IF THE BID STATUS IS REGULAR
                                            if ($bid->status == 'Regular') {



                                                //IF THE PRODUCT OWNER HAS CHOSEN A BIDDER AND WAITING FOR THE CONFIRMATION
                                            } else if ($bid->status == 'Waiting') {

                                            } else {

                                            }
                                        }
                                    }*/
                                    ?>

                                    <a data-placement="right" title="Deletar" data-toggle="tooltip"
                                       class="bidRemove btn btn-danger pull-right mar-left-small"
                                       onclick="return confirm('Tem certeza que deseja deletar esta oferta?')"
                                       href="<?php echo base_url() . 'bid/delete/' . $bid->bid_id; ?>">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                <?php
                                }
                                ?>
                                <a data-placement="right" title="Enviar mensagem" class="chatSend btn btn-info sendMsg pull-right" href="#msgModal" data-toggle="modal"
                                   onclick="querendo.set_chat_values('<?php echo $product_data->product_id; ?>', '<?php echo $_SESSION['user_id']; ?>', '<?php echo $bid->bidder_id; ?>', '<?php echo $bid->user_name; ?>')">
                                    <i class="glyphicon glyphicon-comment"></i></a>
                            <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
        </tbody>
        </table>

    <?php
    }
}



/**
 * User Interaction and Message Display
 */
if ($this->auth->logged_in) {

    if ($product_owner_id == $_SESSION['user_id']) {

        if ($bid_status == 'Waiting') {
            ?>
            <div class="alert alert-info noMargin alert-block">
                <p>
                    Você selecionou um vendedor para o seu produto, agora aguarde a confirmação. Você pode cancelar sua escolha e selecionar outro ofertante.
                </p>
                <p>
                    <a class="btn btn-default" href="<?php echo base_url() . 'bid/cancel/' . $bid_id; ?>" onclick="return confirm('Tem certeza que deseja cancelar a oferta?')">Cancelar</a>
                </p>
            </div>
        <?php
        }
    }
}
?>