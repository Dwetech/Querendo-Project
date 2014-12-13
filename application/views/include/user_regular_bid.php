<?php
if (!empty($bids)) {
    ?>


    <table style="margin-top: 100px" class="table">
        <thead>
        <tr class="tableHead">
            <th>Ofertas no produto</th>
            <th width="150px" class="text-center">Valor</th>
            <th width="100px"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($bids as $bid) {

            if ($bid->status == 'Regular') {
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

                                <p class="text-small noPadding lightAsh"><?php echo timespan(mysql_to_unix($bid->create_date)); ?> atrás</p>

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
                        <h3 class="text-bold">R$<?php echo number_format((float)$bid->bid_amount, 2, '.', ''); ?></h3>
                        <?php
                        //IF USER IS LOGGED IN AND STATUS IS ACTIVE
                        if ($this->auth->logged_in && $this->auth->is_active) {

                            if ($product_data->product_status == 'running') {
                                //IF THE OWNER OF THIS BID IS THE LOGGED IN USER
                                /*//IF THE BID STATUS IS REGULAR
                                if ( ($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Regular')) {

                                }*/
                            } else if ($product_data->product_status == 'waiting') {

                                if ( ($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Waiting')) {
                                    ?>
                                    <a class="btn btn-warning"
                                       onclick="return confirm('Tem certeza que deseja ACEITAR a oferta?')"
                                       href="<?php echo base_url() . 'bid/confirm/' . $bid->bid_id; ?>">Confirmar</a>
                                <?php
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
                                if ($product_data->product_status == 'running') {
                                    //IF THE OWNER OF THIS BID IS THE LOGGED IN USER
                                    //IF THE BID STATUS IS REGULAR
                                    if (($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Regular')) {
                                        ?>
                                        <a data-placement="right" title="Cancelar" data-toggle="tooltip" class="bidRemove btn btn-danger pull-right mar-left-small"
                                           onclick="return confirm('Deseja cancelar esta oferta?')"
                                           href="<?php echo base_url() . 'bid/delete/' . $bid->bid_id; ?>">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                        <a data-placement="right" title="Editar" data-toggle="tooltip" class="chatSend btn btn-primary pull-right" onclick="showBid()"
                                           href="#bid">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                                    <?php
                                    }
                                }/* else if ($product_data->product_status == 'waiting') {
                                    if (($bid->bidder_id == $_SESSION['user_id']) && ($bid->status == 'Waiting')) {

                                    }
                                }*/
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
} else {
    ?>
    <div style="text-align: center"> Não há ofertas para este produto </div>
<?php
}
?>