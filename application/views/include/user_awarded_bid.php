<?php
$bid_status = '';
$product_transaction_status = '';
$awardedUser = '';
$bidder_id = '';


if (!empty($bids)) {

    //check whether the product is already awarded or not
    $awardCheck = $this->product_model->checkStatus($product_data->product_id, 'Completed');
    if (!$awardCheck) {

        $awardCheck = $this->product_model->checkStatus($product_data->product_id, 'Awarded');
    }

    //if the product is already awarded
    if ($awardCheck) {
        ?>

        <table class="table awarded">
            <thead>
                <tr class="tableHead">
                    <th>Premiado</th>
                    <th class="text-center" width="170px" class="text-center">Lance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $awardedUser = '';

                foreach ($bids as $bid) {


                    if ($bid->status == 'Completed' || $bid->status == 'Awarded') {

                        //save the awarded user into a variable
                        $awardedUser = $bid->user_id;
                        $product_transaction_status = $product_data->transaction_status;
                        $bid_status = $bid->status;
                        $bidder_id = $bid->bidder_id;
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
                                                     src="<?php echo base_url() . 'upload/profile_photo/' ?>" alt=""/>
                                            </div>
                                        <?php } ?>

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
                                                  class="sellerMap flag flag-<?php echo!empty($country->iso_code_2) ? strtolower($country->iso_code_2) : ''; ?>">
                                            </span>
                                        </a>

                                        <p class="text-small noPadding lightAsh"><?php echo timespan(mysql_to_unix($bid->create_date)); ?>
                                            atrás</p>

                                        <p class="text-small_custom lessDescription">
                                            <?php
                                            if (strlen($bid->proposal_text) > 100) {
                                                echo substr($bid->proposal_text, 0, 100) . ' ... ... ... <a class="expand text-info pointer"><b>(mais)</b></a>';
                                            } else {
                                                echo $bid->proposal_text;
                                            }
                                            ?>
                                        </p>

                                        <p style="display: none" class="text-small_custom fullDescription">
                                            <?php echo $bid->proposal_text . '<br><a class="defeat text-info pointer"><b>(menos)</b></a>'; ?>
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


                            <td class="text-center removeRelative" id="confirmBid">
                                <h3 class="text-bold">R$ <?php echo $bid->bid_amount; ?></h3>

                                <?php
                                //IF USER IS LOGGED IN AND STATUS IS ACTIVE
                                if ($this->auth->logged_in && $this->auth->is_active) {


                                    //IF PRODUCT IS HAVING RUNNING STATUS
                                    if ($product_data->product_status == 'running') {


                                        //IF LOGGED IN USER IS BIDDER OF THIS BID AND BID STATUS IS REGULAR
                                        if (($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Regular')) {
                                            ?>
                                            <a class="btn btn-primary" href="#bid" onclick="showBid()">Editar</a>
                                            <a class="bidRemove" onclick="return confirm('Tem certeza que deseja deletar esse lance?')"
                                               href="<?php echo base_url() . 'bid/delete/' . $bid->bid_id; ?>">
                                                <i class="glyphicon glyphicon-remove text-danger"></i></a>


                                            <?php
                                        }
                                    } else if ($product_data->product_status == 'waiting') {


                                        //IF LOGGED IN USER IS BIDDER OF THIS BID AND BID STATUS IS WAITING
                                        if (($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Waiting')) {
                                            ?>
                                            <a class="btn btn-warning" onclick="return confirm('Tem certeza que deseja ACEITAR este lance?')"
                                               href="<?php echo base_url() . 'bid/confirm/' . $bid->bid_id; ?>">Confirmar</a>
                                            <a class="btn btn-default" href="<?php echo base_url() . 'bid/cancel/' . $bid->bid_id; ?>"
                                               onclick="return confirm('Tem certeza que deseja cancelar este lance?')">Cancelar</a>


                                            <?php
                                        }
                                    } else if ($product_data->product_status == 'awarded') {
                                        ?>


                                        <div class="label label-success">Aceito</div>
                                        <?php
                                        if (($bid->bidder_id == $_SESSION['user_id'])) {

                                            if ($product_transaction_status == 'payment_sent') {
                                                ?>
                                                <div class="label label-info">Pagamento enviado</div>

                                                <?php
                                            }
                                            if ($product_transaction_status == 'payment_received') {
                                                ?>
                                                <div class="label label-info">Pagamento recebido</div>
                                                <?php
                                            }
                                            if ($product_data->transaction_status == 'product_sent') {
                                                ?>
                                                <div class="label label-info">Produto enviado</div>
                                                <?php
                                            }
                                        }
                                        ?>



                                        <?php
                                    } else if ($product_data->product_status == 'completed') {
                                        ?>


                                        <div class="pull-right label label-info" style="height: 30px;padding-top: 9px;">
                                            Projeto completo
                                        </div>


                                        <?php
                                    }
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
        
    if ($bidder_id == $_SESSION['user_id']) {

        if ($bid_status == 'Awarded') {

            if ($product_transaction_status == 'none') {
                ?>
                <div class="alert alert-info noMargin alert-block">
                    <p>
                        Você confirmou o negócio com o vendedor. Por favor, discuta com o comprador sobre o método de pagamento. Você será notificado quando o comprador enviar o pagamento.
                    </p>
                </div>
                <?php
            }


            if ($product_transaction_status == 'payment_sent') {
                ?>
                <div class="alert alert-info noMargin alert-block">
                    <p>
                        O comprador lhe enviou o pagamento. Se você recebeu o pagamento por favor notifique o comprador clicando no botão abaixo.
                    </p>
                    <p>
                        <a class="btn btn-primary" onclick="return confirm('Tem certeza que recebeu o pagamento?');"
                           href="<?php echo base_url() . 'product/update_product_transaction_status/payment_received/' . $product_data->product_id; ?>">
                            Pagamento recebido</a>
                    </p>
                </div>
                <?php
            }


            if ($product_transaction_status == 'product_sent') {
                ?>
                <div class="alert alert-info noMargin alert-block">
                    <p>
                        Você enviou o produto ao comprador. Após o recebimento do produto pelo comprador você será informado.
                    </p>
                </div>
                <?php
            }
        }


        if ($product_transaction_status == 'payment_received') {
            ?>
            <div class="alert alert-info noMargin alert-block">
                <p>
                    Você enviou o produto ao comprador. Este projeto será fechado assim que o comprador confirmar o recebimento do produto.
                </p>
            </div>
            <?php
        }
    }


    if ($product_transaction_status == 'payment_received') {
        ?>
        <div class="alert alert-info noMargin alert-block">
            <p>
                Agora que você recebeu seu pagamento envie o produto ao comprador. Vocês podem discutir sobre o método de envio do produto.
            </p>
            <p>Após enviar o produto por favor clique no botão abaixo para confirmar o envio.</p>
            <p>
                <a class="btn btn-primary" onclick="return confirm('Tem certeza que enviou o produto?');" 
                   href="<?php echo base_url() . 'product/update_product_transaction_status/product_sent/' . $product_data->product_id; ?>">
                    Produto enviado</a>
            </p>
        </div>
        <?php
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
if ($this->auth->logged_in && $this->auth->is_active && $_SESSION['user_id'] == $awardedUser /* && ($product_data->product_status != 'completed') */) {

    $data['from_id'] = $product_data->user_id;
    $data['to_id'] = $_SESSION['user_id'];
    $data['product_id'] = $product_data->product_id;

    $thread = Message_model::fetch_thread_id($data['product_id'], $data['from_id'], $data['to_id']);
    if (!empty($thread)) {
        //Getting product owner and bidder conversation
        $data['conversation'] = Message_model::get_conversation($thread->thread_id, 0);
    }
    ?>
    <div class="awardedSection">
        <div class="col-md-10 col-md-offset-1">
            <div class="awarded-activity">
                <div class="awarded-activity-data">
                    <ul id="userTab" class="nav nav-tabs">
                        <li class="active"><a href="#milestones" data-toggle="tab">Pagamentos</a></li>
                        <li class=""><a href="#info" data-toggle="tab">Informações do comprador</a></li>
                        <!--                        <li class=""><a href="#invoices" data-toggle="tab">Invoices</a></li>-->
                        <li class=""><a href="#messages" data-toggle="tab">Mensagens</a></li>
                        <!--                        <li class=""><a href="#files" data-toggle="tab">Files</a></li>-->
                    </ul>

                    <div class="activity-table noPadding">
                        <div id="userTabContent" class="tab-content">
                            <div class="tab-pane active" id="milestones">
                                <?php $this->load->view('include/milestone-user', $data) ?>
                            </div>
                            <div class="tab-pane fade" id="info">
                                <?php $this->load->view('include/awarded_user_info.php') ?>
                            </div>
                            <!--                            <div class="tab-pane fade" id="invoices"></div>-->
                            <div class="tab-pane fade" id="messages">
                                <?php $this->load->view('include/chat-user', $data) ?>
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
