<?php
$bid_status = '';
$product_transaction_status = '';
$data['awardedUser'] = $awardedUser = '';
$awardedUser_id = '';
$product_owner_id = '';

//check whether the product is already awarded or not
$awardCheck = $this->product_model->checkStatus($product_data->product_id, 'Completed');
if (!$awardCheck) {

    $awardCheck = $this->product_model->checkStatus($product_data->product_id, 'Awarded');
}


if (!empty($bids)) {

//if the product is already awarded
    if ($awardCheck) {
        ?>

        <table class="table awarded">
            <thead>
            <tr class="tableHead">
                <th>Ofertas do produto</th>
                <th width="170px" class="text-center">Valor</th>
            </tr>
            </thead>
            <tbody>


            <?php
            foreach ($bids as $bid) {


                if ($bid->status == 'Completed' || $bid->status == 'Awarded') {

                    //save the awarded user into a variable
                    $data['awardedUser'] = $awardedUser = $bid->user_id;
                    $product_transaction_status = $product_data->transaction_status;
                    $bid_status = $bid->status;
                    $product_owner_id = $product_data->user_id;
                    ?>
                    <tr>
                        <td>
                            <div class="col-sm-11 noPadding">
                                <div class="col-sm-2 noPadding text-center">
                                    <?php if (!empty($bid->profile_pic)) { ?>
                                        <div class="profile-picture-img">
                                            <img class="imgAuto bid_list_profile_pic"
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
                                    <?php } ?>

                                    <a class="text-small text-center" href="#"><?php echo $bid->seller_review_count; ?> Avaliações</a>
                                    <input id="input-21e" value="<?php echo $bid->seller_review; ?>" class="rating rating_star" min="0" max="5"
                                           step="1" data-size="xs" data-disabled="true" data-show-caption="false" data-show-clear="false">
                                </div>
                                <div class="col-sm-9">
                                    <a href="<?php echo base_url() ?>user/view/<?php echo $bid->user_name; ?>"
                                       class="text-bold"><?php echo $bid->user_name; ?>
                                        <span data-toggle="tooltip" title="<?php echo!empty($country->iso_code_2) ? $country->name : ''; ?>"
                                              data-placement="left" class="sellerMap flag flag-<?php echo!empty($country->iso_code_2) ? strtolower($country->iso_code_2) : ''; ?>">
                                            </span>
                                    </a>

                                    <p class="text-small noPadding lightAsh"><?php echo timespan(mysql_to_unix($bid->create_date)); ?> atrás</p>

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
                            <h4 class="text-bold noMargin">R$<?php echo number_format((float)$bid->bid_amount, 2, '.', ''); ?></h4>
                            <p class="noPadding normalAsh">Em <b><?php echo $bid->delivery_time; ?></b> dia(s)</p>

                            <?php
                            //IF USER IS LOGGED IN AND STATUS IS ACTIVE
                            if ($this->auth->logged_in && $this->auth->is_active) {


                                //IF THE OWNER OF THE PRODUCT IS THE LOGGED IN USER THE FOLLOWING
                                //PART WILL BE VISIBLE
                                //if ($product_data->user_id == $_SESSION['user_id']) {
                                //IF THE PRODUCT STATUS IS COMPLETED
                                if ($product_data->product_status == 'completed') {
                                    ?>
                                    <span class="label label-info">
                                            Projeto completo
                                        </span>

                                    <?php
                                    //IF THE PRODUCT STATUS IS NOT COMPLETED
                                } else {


                                    /* //IF THE BIDDER GETS ALL THE MONEY HE/SHE WANTED DURING BIDDING
                                      //IT WILL BE POSSIBLE TO MARK THIS PROJECT AS COMPLETED
                                     *
                                     *
                                     * THIS PART WOULD BE CHECKED WITH 4 STATUS-->>product_received|product_sent|
                                     * payment_received|payment_sent
                                     * >>>>>>>>>>>>>>v0.9.5<<<<<<<<<<<<<<<
                                     * ================================================
                                      if ($released_milestone_sum->released_milestone_amount >= $bid->bid_amount) {
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


                                            <a class="btn btn-primary"
                                               href="<?php echo base_url() . 'bid/accept/' . $bid->bid_id; ?>"
                                               onclick="return confirm('Tem certeza que deseja aceitar esta oferta?')">Aceitar</a>
                                            <a class="bidRemove"
                                               onclick="return confirm('Tem certeza que deseja rejeitar esta oferta?')"
                                               href="<?php echo base_url() . 'bid/delete/' . $bid->bid_id; ?>"><i
                                                    class="glyphicon glyphicon-remove text-danger"></i></a>


                                            <?php
                                            //IF THE PRODUCT OWNER HAS CHOSEN A BIDDER AND WAITING FOR THE CONFIRMATION
                                        } else if ($bid->status == 'Waiting') {
                                            ?>


                                            <a class="btn btn-warning ">Aguardando</a>
                                            <a class="btn btn-default"
                                               href="<?php echo base_url() . 'bid/cancel/' . $bid->bid_id; ?>"
                                               onclick="return confirm('Tem certeza que deseja rejeitar esta oferta?')">Rejeitar</a>


                                        <?php
                                        } else {
                                            ?>
                                            <div class="label label-success">Aceito</div>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="label label-success">Aceito</div>
                                        <?php
                                        if ($product_data->transaction_status == 'payment_sent') {
                                            ?>
                                            <div class="label label-info">Pagamento enviado</div>

                                        <?php
                                        }
                                        if ($product_transaction_status == 'payment_received') {
                                            ?>
                                            <div class="label label-info">Pagamento recebido</div>
                                        <?php
                                        }
                                        if ($product_transaction_status == 'product_sent') {
                                            ?>
                                            <div class="label label-info">Produto enviado</div>
                                        <?php
                                        }
                                    }

                                }
                                //}
                            }
                            ?>


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

        if ($bid_status == 'Awarded') {

            if ($product_transaction_status == 'none') {
                ?>
                <div class="alert alert-info noMargin alert-block">
                    <p>
                        Por favor, discuta com o vendedor sobre o pagamento. Após enviar o pagamento você deve notificar o vendedor clicando no botão abaixo.

                    </p>
                    <p>
                        <a class="btn btn-primary" onclick="return confirm('Tem certeza que enviou o pagamento?')"
                           href="<?php echo base_url() . 'product/update_product_transaction_status/payment_sent/' . $product_data->product_id; ?>">
                            Pagamento enviado</a>
                    </p>
                </div>
            <?php
            }


            if ($product_transaction_status == 'payment_sent') {
                ?>
                <div class="alert alert-warning noMargin alert-block">
                    <i class="glyphicon glyphicon-info-sign mar-right-small"></i> Pagamento enviado ao vendedor. Você será notificado após o recebimento do pagamento pelo vendedor.
                </div>
            <?php
            }

            if ($product_transaction_status == 'payment_received') {
                ?>
                <div class="alert alert-warning noMargin alert-block">
                    <i class="glyphicon glyphicon-info-sign mar-right-small"></i> O ofertante confirmou o recebimento do pagamento. Agora vocês podem discutir sobre o método de envio do produto. Você será notificado quando o vendedor lhe enviar o produto.
                </div>
            <?php
            }
            if ($product_transaction_status == 'product_sent') {
                ?>
                <div class="alert alert-info noMargin alert-block">
                    <p>
                        O vendedor lhe enviou o produto. Por favor, confirme o recebimento do produto clicando no botão abaixo.
                    </p>
                    <p>
                        <a class="btn btn-primary" onclick="return confirm('Tem certeza que recebeu o produto?');"
                           href="<?php echo base_url() . 'product/update_product_transaction_status/product_received/' . $product_data->product_id; ?>">
                            Produto recebido</a>
                    </p>
                </div>
            <?php
            }
        }
    }
}




/**
 * MILESTONE || INVOICES || MESSAGES || FILES
 * ==========================
 * To see the following part user have to
 * 1. logged in
 * 2. user status have to active
 * 3. Product status and bid status have to be awarded
 * 4. Logged in user have to be the product owner
 * 5. Product status should not be completed
 */
if ($this->auth->logged_in && $this->auth->is_active && $awardCheck/* && ($_SESSION['user_id'] == $product_data->user_id) */) {

    $data['from_id'] = $product_data->user_id;
    $data['to_id'] = $awardedUser ? $awardedUser : '';
    $data['product_id'] = $product_data->product_id;

    $thread = Message_model::fetch_thread_id($data['product_id'], $data['from_id'], $data['to_id']);
    if (!empty($thread)) {
        //Getting product owner and bidder conversation
        $data['conversation'] = Message_model::get_conversation($thread->thread_id, 0);
    }
    ?>
    <div class="awardedSection">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="awarded-activity">
                <div class="awarded-activity-data">
                    <ul id="userTab" class="nav nav-tabs">
                        <li class="active"><a href="#milestones" data-toggle="tab">Pagamentos</a></li>
                        <li class=""><a href="#info" data-toggle="tab">Informações do vendedor</a></li>
                        <!--                        <li class=""><a href="#invoices" data-toggle="tab">Invoices</a></li>-->
                        <li class=""><a href="#messages" data-toggle="tab">Mensagens</a></li>
                        <!--                        <li class=""><a href="#files" data-toggle="tab">Files</a></li>-->
                    </ul>

                    <div class="activity-table noPadding">
                        <div id="userTabContent" class="tab-content">
                            <div class="tab-pane active" id="milestones">
                                <?php $this->load->view('include/milestone-owner', $data); ?>
                            </div>
                            <div class="tab-pane fade" id="info">
                                <?php $this->load->view('include/awarded_owner_info.php') ?>
                            </div>
                            <!--                            <div class="tab-pane fade" id="invoices"></div>-->
                            <div class="tab-pane" id="messages">
                                <?php $this->load->view('include/chat-owner', $data); ?>
                            </div>
                            <!--                            <div class="tab-pane fade" id="files"></div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>