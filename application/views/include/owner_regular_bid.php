<?php if (!empty($bids)) { ?>

    <table class="table" style="margin-top: 100px;">

        <thead>
        <tr class="tableHead">
            <th>Ofertas no produto</th>
            <th width="170px" class="text-center">Valor</th>
            <th width="100px"></th>
        </tr>
        </thead>

        <tbody>
        <?php
        $awardedUser = '';

        foreach ($bids as $bid) {

            //IF BID STATUS IS NOT AWARDED AND WAITING
            if ($bid->status == 'Regular') {
                $awardedUser = $bid->user_id; //GETTING AWARDED USER
                ?>
                <tr>
                    <td>
                        <div class="col-md-11 noPadding">
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
                                <?php } ?>

                                <a class="text-small text-center" href="#"><?php echo $bid->seller_review_count; ?> Avaliações</a>
                                <input id="input-21e"
                                       value="<?php echo $bid->seller_review; ?>" class="rating rating_star"
                                       min="0" max="5" step="1" data-size="xs" data-disabled="true" data-show-caption="false" data-show-clear="false">
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
                                    <?php echo $bid->proposal_text.'<br><a class="defeat text-info pointer"><b>(menos)</b></a>'; ?>
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
                        <h4 class="text-bold noMargin">R$<?php echo $bid->bid_amount; ?></h4>
                        <p class="noPadding normalAsh">Em <b><?php echo $bid->delivery_time; ?></b> dia(s)</p>

                        <?php
                        //IF USER IS LOGGED IN AND STATUS IS ACTIVE
                        if ($this->auth->logged_in && $this->auth->is_active) {

                            /**
                             * IF THE OWNER OF THE PRODUCT BIDDER IS THE LOGGED IN USER THE FOLLOWING,
                             * PART WILL BE VISIBLE
                             */
                            if ($bid->bidder_id == $_SESSION['user_id'] || $product_data->user_id == $_SESSION['user_id']) {


                                if ($product_data->product_status == 'running') {


                                    //BID STATUS REGULAR
                                    if ($bid->status == 'Regular') {
                                        ?>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url() . 'bid/accept/' . $bid->bid_id; ?>"
                                           onclick="return confirm('Tem certeza que deseja aceitar esta oferta?')"><i class="glyphicon glyphicon-ok"></i> Aceitar</a>


                                    <?php } else if ($bid->status == 'Waiting') { ?>


                                        <a class="btn btn-warning pull-left">Aguardando</a>
                                        <a class="btn btn-default"
                                           href="<?php echo base_url() . 'bid/cancel/' . $bid->bid_id; ?>"
                                           onclick="return confirm('Tem certeza que deseja rejeitar esta oferta ?')">Rejeitar</a>


                                    <?php
                                    } else {
                                        ?>
                                        <div class="label label-success">Aceito</div>


                                    <?php
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

                                //IF THE OWNER OF THE PRODUCT BIDDER IS THE LOGGED IN USER THE FOLLOWING
                                //PART WILL BE VISIBLE
                                if ($bid->bidder_id == $_SESSION['user_id'] || $product_data->user_id == $_SESSION['user_id']) {


                                    if ($product_data->product_status == 'running') {


                                        /*//BID STATUS REGULAR
                                        if ($bid->status == 'Regular') {
                                            
                                        } else if ($bid->status == 'Waiting') {
                                            
                                            
                                        } else {
                                            
                                            
                                        }*/
                                        ?>

                                        <a data-placement="right" title="Rejeitar" data-toggle="tooltip" class="bidRemove pull-right btn btn-danger mar-left-small" 
                                           onclick="return confirm('Tem certeza que deseja rejeitar esta oferta?')"
                                           href="<?php echo base_url() . 'bid/delete/' . $bid->bid_id; ?>">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>


                                    <?php
                                    }
                                    ?>
                                    <a data-placement="right" title="Enviar mensagem" class="chatSend pull-right btn btn-info sendMsg" href="#msgModal" data-toggle="modal"
                                       onclick="querendo.set_chat_values('<?php echo $product_data->product_id; ?>', '<?php echo $_SESSION['user_id']; ?>', '<?php echo $bid->bidder_id; ?>', '<?php echo $bid->user_name; ?>')"><i class="glyphicon glyphicon-comment"></i></a>
                                <?php
                                }
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
else {
    ?>
    <p class="alert alert-info text-center"> Não há ofertas para este produto </p>
<?php
}
?>
