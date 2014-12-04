<?php
$bid_status = '';
$bidder_id = '';
if (!empty($bids)) {


    //check whether the product is Waiting or not
    $awardCheck = $this->product_model->checkStatus($product_data->product_id, 'Waiting');


    if ($awardCheck) {
        ?>

        <table class="table awarded">
            <thead>
                <tr class="tableHead">
                    <th>Ofertante</th>
                    <th class="text-center" width="200px" class="text-center">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($bids as $bid) {


                    if ($bid->status == 'Waiting') {


                        $bid_status = $bid->status;
                        $bid_id = $bid->bid_id;
                        $bidder_id = $bid->bidder_id;
                        ?>
                        <tr>
                            <td>
                                <div class="col-sm-11 noPadding">
                                    <div class="col-sm-2 noPadding">
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
                                                     src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
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
                                                  class="sellerMap flag flag-<?php echo!empty($country->iso_code_2) ? strtolower($country->iso_code_2) : ''; ?>"></span>
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
                                            <img data-toggle="tooltip" data-placement="right" title="Clique para ampliar" class="imgAuto productImage" class="imgAuto" 
                                                 src="<?php echo base_url() . 'upload/bid_photo/' . $bid->product_image; ?>">
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url() . 'resources/img/no_image.gif'; ?>" class="image-popup-vertical-fit">
                                            <img data-toggle="tooltip" data-placement="right" title="Clique para ampliar" class="imgAuto productImage" class="imgAuto" 
                                                 src="<?php echo base_url() . 'resources/img/no_image.gif'; ?>">
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                            <td class="text-center removeRelative" id="confirmBid">
                                <h3 class="text-bold">R$<?php echo $bid->bid_amount; ?></h3>


                                <?php
                                //IF USER IS LOGGED IN AND STATUS IS ACTIVE
                                if ($this->auth->logged_in && $this->auth->is_active) {


                                    if ($product_data->product_status == 'running') {


                                        //if the logged in user is the bidder of this bid and bid is having regular status
                                        if (($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Regular')) {
                                            ?>
                                            <a class="btn btn-primary" href="#bid" onclick="showBid()">Editar</a>

                                            <a class="bidRemove"
                                               onclick="return confirm('Tem certeza que deseja cancelar este lance?')"
                                               href="<?php echo base_url() . 'bid/delete/' . $bid->bid_id; ?>">
                                                <i class="glyphicon glyphicon-remove text-danger"></i></a>


                                            <?php
                                        }
                                    }/* else if ($product_data->product_status == 'waiting') {


                                        //if the logged in user is the bidder of this bid and bid is having waiting status
                                        if (($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Waiting')) {
                                            
                                        }
                                    }*/
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
        if ($bid_status == 'Waiting') {
            ?>
            <div class="alert alert-info noMargin alert-block">
                <p>
                    Parabéns! Sua oferta foi premiada. Agora confirme que você concorda em vender seu produto ou cancele sua oferta.
                </p>
                <p>
                    <a class="btn btn-warning" onclick="return confirm('Tem certeza que deseja ACEITAR a oferta?')" 
                       href="<?php echo base_url() . 'bid/confirm/' . $bid_id; ?>">Confirmar</a>
                    <a class="btn btn-default" href="<?php echo base_url() . 'bid/cancel/' . $bid_id; ?>"
                       onclick="return confirm('Tem certeza que quer cancelar esta oferta?')">Cancelar</a>
                </p>
            </div>
            <?php
        }
    }
}
?>