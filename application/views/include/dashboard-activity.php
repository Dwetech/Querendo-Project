<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/4/14
 * Time: 7:40 PM
 * To change this template use File | Settings | File Templates.
 */
?>


<div class="dashboard-activity">
    <div class="dashboard-activity-data">
        <div class="page-header">
            <h2>DashBoard</h2>
        </div>

        <?php
        /**
         * Checking if use has any review to give and
         * displaying it in the dashboard
         */
        if (!empty($giveReview)) {
            ?>
            <div class="notification alert alert-info">
                <table class="table">
                    <thead>
                        <tr class="tableHead">
                            <th>Avaliação pendente</th>
                            <th class="text-center"></th>
                            <th width="100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($giveReview)) {
                            foreach ($giveReview as $giveReviewList) {
                                ?>
                                <tr>
                                    <td class="verticalMiddle">
                                        <a href="<?php echo base_url() . 'product/view/' . $giveReviewList->product_id; ?>"><?php echo $giveReviewList->name; ?></a>
                                    </td>
                                    <td class="text-center verticalMiddle">
                                        <div class="label label-success"><?php echo $giveReviewList->status; ?></div>
                                    </td>
                                    <td class="verticalMiddle">
                                        <a class="btn btn-danger"
                                           href="<?php echo base_url() . 'product/view/' . $giveReviewList->product_id; ?>">Avaliar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td style="text-align: center" colspan="6"> Sem registros</td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <?php
        }


        //Checking if user's profile details is incomplete
        if ($profile_complete != '') {
            ?>
            <div class="notification alert alert-default">
                <div class="col-sm-1 noPadding">
                    <div class="profile-picture offline">
                        <?php if (!empty($this->auth->user_data->profile_pic)) { ?>
                            <img alt="" src="<?php echo base_url() . 'upload/profile_photo/' . $this->auth->user_data->profile_pic; ?>" class="imgAuto">
                        <?php } else { ?>
                            <img alt="" src="<?php echo base_url() ?>resources/img/blank.png" class="imgAuto">
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-11">
                    <p>
                        <span class="normalAsh">Por favor, complete seu cadastro clicando no link abaixo:</span>
                    </p>

                    <p class="alert alert-danger normalAsh">
                        <em><?php echo '<a href="' . base_url() . 'user/settings/">Edite seu perfil</a>'; ?></em>
                    </p>
                </div>
            </div>
            <?php
        }


        //Displaying user notifications
        if (!empty($user_news)) {


            for ($x = 0; $x < sizeof($user_news); $x++) {


                //If the data belongs to review details
                if ($user_news[$x][0] == 'review') {
                    ?>
                    <div class="notification alert alert-default">
                        <div class="col-sm-1 noPadding">
                            <div class="profile-picture offline">
                                <?php if (!empty($user_news[$x]['profile_pic'])) { ?>
                                    <img alt="" src="<?php echo base_url() . 'upload/profile_photo/' . $user_news[$x]['profile_pic']; ?>" class="imgAuto">
                                <?php } else { ?>
                                    <img alt="" src="<?php echo base_url() ?>resources/img/blank.png" class="imgAuto">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <p>
                                <b><a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['user_name']; ?>"><?php echo $user_news[$x]['user_name']; ?></a></b>
                                <span class="normalAsh">
                                    lhe enviou uma avaliação por
                                    <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['product_name']; ?>
                                    </a>
                                </span>
                                <span class="lightAsh pull-right ">
                                    <?php
                                    $date = strtotime($user_news[$x]['date_time_string']);
                                    echo date("d/m/y", $date) .' <span class="lightAsh">às</span> ' . date("H:i", $date);
                                    ?>
                                </span>
                            </p>

                            <p class="alert alert-info normalAsh">
                                <b>Avaliação de <?php echo $user_news[$x]['user_name']; ?>: </b><br/>
                                <em><?php echo $user_news[$x]['message']; ?></em>
                                <input data-show-clear="false" data-show-caption="false" data-disabled="true" data-size="xs" step="1" max="5" min="0"
                                       class="rating rating_star form-control" value="<?php echo $user_news[$x]['rating']; ?>" id="input-21e"><?php echo $user_news[$x]['rating'] . ' out of 5'; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }


                //If the data belongs to milestone details
                if ($user_news[$x][0] == 'milestone') {

                    if ($user_news[$x]['status'] == 'requested' && $user_news[$x]['product_owner_id'] == $_SESSION['user_id']) {
                        ?>

                        <div class="notification alert alert-default">
                            <div class="col-sm-1 noPadding">
                                <div class="profile-picture offline">
                                    <?php if (!empty($user_news[$x]['profile_pic'])) { ?>
                                        <img alt="" src="<?php echo base_url() . 'upload/profile_photo/' . $user_news[$x]['profile_pic']; ?>" class="imgAuto">
                                    <?php } else { ?>
                                        <img alt="" src="<?php echo base_url() ?>resources/img/blank.png" class="imgAuto">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <p>
                                    <b>
                                        <a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['user_name']; ?>"><?php echo $user_news[$x]['user_name']; ?></a>
                                    </b>
                                    <span class="normalAsh">
                                        <?php echo $user_news[$x]['status']; ?> um pagamento de <b>$<?php echo $user_news[$x]['amount']; ?></b> for 
                                    </span>
                                    <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['name']; ?></a>
                                    <span class="lightAsh pull-right ">
                                        <?php
                                        $date = strtotime($user_news[$x]['date_time_string']);
                                        echo date("d/m/y", $date) . ' às ' . date("H:i");
                                        ?>
                                    </span>
                                </p>

                                <p class="alert alert-info">
                                    <span class="text-info">
                                        <b>Detalhes do pagamento : </b> <?php echo $user_news[$x]['description']; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <?php
                    }

                    if ($user_news[$x]['status'] != 'requested' && $user_news[$x]['product_owner_id'] != $_SESSION['user_id']) {
                        ?>
                        <div class="notification alert alert-default">
                            <div class="col-sm-1 noPadding">
                                <div class="profile-picture offline">
                                    <?php if (!empty($user_news[$x]['profile_pic'])) { ?>
                                        <img alt="" src="<?php echo base_url() . 'upload/profile_photo/' . $user_news[$x]['profile_pic']; ?>" class="imgAuto">
                                    <?php } else { ?>
                                        <img alt="" src="<?php echo base_url() ?>resources/img/blank.png" class="imgAuto">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <p>
                                    <b>
                                        <a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['user_name']; ?>"><?php echo $user_news[$x]['user_name']; ?></a>
                                    </b>
                                    <span class="normalAsh">
                                        <?php echo $user_news[$x]['status']; ?> um pagamento de <b>$<?php echo $user_news[$x]['amount']; ?></b> for 
                                    </span>
                                    <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['name']; ?></a>
                                    <span class="lightAsh pull-right ">
                                        <?php
                                        $date = strtotime($user_news[$x]['date_time_string']);
                                        echo date("d/m/y", $date) . ' às ' . date("H:i");
                                        ?>
                                    </span>
                                </p>

                                <p class="alert alert-info">
                                    <span class="text-info">
                                        <b>Detalhes de pagamento : </b> <?php echo $user_news[$x]['description']; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                }



                //If the data belongs to the product details
                if ($user_news[$x][0] == 'products') {
                    ?>


                    <div class="notification alert alert-default">
                        <div class="col-sm-1 noPadding">
                            <div class="profile-picture offline">
                                <img alt="" src="<?php echo base_url() . 'resources/img/querendo.jpg'; ?>" class="imgAuto">
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <p>
                                <span class="normalAsh">
                                    <b><a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['user_name']; ?>"><?php echo $user_news[$x]['user_name']; ?></a></b>
                                    concordou em negociar com você o  
                                </span>
                                <span class="normalAsh">produto </span>
                                <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['product_name']; ?></a>
                                <span class="lightAsh pull-right">
                                    <?php
                                    $date = strtotime($user_news[$x]['date_time_string']);
                                    echo date("d/m/y", $date) . ' às ' . date("H:i");
                                    
                                    ?>
                                </span>
                            </p>
                            <p class="alert alert-info normalAsh">
                                Por favor, envie o pagamento à
                                <b><?php echo $user_news[$x]['user_name']; ?></b>
                                , referente à <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['product_name']; ?></a>
                            </p>
                        </div>
                    </div>
                    <?php
                }


                //getting product transaction activities
                if ($user_news[$x][0] == 'bidder_transactions') {
                    ?>


                    <div class="notification alert alert-default">
                        <div class="col-sm-1 noPadding">
                            <div class="profile-picture offline">
                                <img alt="" src="<?php echo base_url() . 'resources/img/querendo.jpg'; ?>" class="imgAuto">
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <p>
                                
                                <span class="normalAsh">
                                    <b><a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['owner_name']; ?>"><?php echo $user_news[$x]['owner_name']; ?></a></b>
                                    <?php if ($user_news[$x]['transaction_status'] == 'payment_sent') { ?>
                                        lhe enviou um pagamento de R$<?php echo $user_news[$x]['bid_amount']; ?> referente ao 
                                    <?php } else if ($user_news[$x]['transaction_status'] == 'product_received') { ?>
                                        confirmou o recebimento do 
                                    <?php } ?>
                                </span>
                                <span class="normalAsh">produto </span>
                                <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['product_name']; ?></a>
                                <span class="lightAsh pull-right">
                                    <?php
                                    /* $date = strtotime($user_news[$x]['date_time_string']);
                                      echo date("d M Y", $date) . ' at ' . date("g:i a", $date); */
                                    ?>
                                </span>
                            </p>
                            <p class="alert alert-info normalAsh">
                                <?php
                                if ($user_news[$x]['transaction_status'] == 'payment_sent') {
                                    echo 'Por favor, notifique o comprador caso tenha recebido o pagamento.';
                                } else if ($user_news[$x]['transaction_status'] == 'product_received') {
                                    ?>
                                    Você recebeu uma fatura. Visualize sua <a href="<?php echo base_url('invoice'); ?>">fatura</a> e envie o pagamento.
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }


                //getting product transaction activities
                if ($user_news[$x][0] == 'owner_transactions') {
                    ?>


                    <div class="notification alert alert-default">
                        <div class="col-sm-1 noPadding">
                            <div class="profile-picture offline">
                                <img alt="" src="<?php echo base_url() . 'resources/img/querendo.jpg'; ?>" class="imgAuto">
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <p>
                                <span class="normalAsh">
                                    <b><a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['user_name']; ?>"><?php echo $user_news[$x]['user_name']; ?></a></b>
                                    <?php
                                    if ($user_news[$x]['transaction_status'] == 'payment_received') {
                                        echo ' confirmou o recebimento do seu pagamento referente o ';
                                    } else if ($user_news[$x]['transaction_status'] == 'product_sent') {
                                        echo ' enviou seu produto referente o ';
                                    }
                                    ?>

                                </span>
                                <span class="normalAsh">produto </span>
                                <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['product_name']; ?></a>
                                <span class="lightAsh pull-right">
                                    <?php
                                    /* $date = strtotime($user_news[$x]['date_time_string']);
                                      echo date("d M Y", $date) . ' at ' . date("g:i a", $date); */
                                    ?>
                                </span>
                            </p>
                            <p class="alert alert-info normalAsh">
                                <?php
                                if ($user_news[$x]['transaction_status'] == 'product_sent') {
                                    echo 'Por favor, notifique o vendedor caso tenha recebido o produto. ';
                                } else if ($user_news[$x]['transaction_status'] == 'payment_received') {
                                    ?>
                                    Você pode esperar o vendedor lhe enviar o produto ou 
                                    <a href="<?php echo base_url("product/view/" . $user_news[$x]["product_id"] . "#messages"); ?>" >pedir-lhe</a> para enviar o produto';
                                    <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }




                //If the data belongs to bids details
                if ($user_news[$x][0] == 'bids') {


                    if ($user_news[$x]['bidder_id'] == $_SESSION['user_id']) {


                        if ($user_news[$x]['status'] == 'Completed' || $user_news[$x]['status'] == 'Waiting') {
                            ?>
                            <div class="notification alert alert-default">
                                <div class="col-sm-1 noPadding">
                                    <div class="profile-picture offline">
                                        <img alt="" src="<?php echo base_url() . 'resources/img/querendo.jpg'; ?>" class="imgAuto">
                                    </div>
                                </div>
                                <div class="col-sm-11">
                                    <p>
                                        <?php
                                        if ($user_news[$x]['status'] == 'Completed') {
                                            ?>
                                            <span class="normalAsh">Você <?php echo strtolower($user_news[$x]['status']); ?> </span>
                                            <span class="normalAsh">o produto </span>
                                            <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['product_name']; ?></a>
                                            <span class="normalAsh">de </span>
                                            <b><a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['user_name']; ?>"><?php echo $user_news[$x]['user_name']; ?></a></b>
                                            
                                        <?php } else if ($user_news[$x]['status'] == 'Waiting') { ?>
                                            <b><a href="<?php echo base_url() . 'user/view/' . $user_news[$x]['user_name']; ?>"><?php echo $user_news[$x]['user_name']; ?></a></b>
                                            premiou sua oferta de <b>R$<?php echo $user_news[$x]['bid_amount'] ?></b> pelo projeto <a 
                                                href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>#confirmBid">
                                                <?php echo $user_news[$x]['product_name']; ?></a>
                                        <?php } ?>
                                        <span class="lightAsh pull-right">
                                            <?php
                                            $date = strtotime($user_news[$x]['date_time_string']);
                                            echo date("d M Y", $date) . ' at ' . date("g:i a", $date);
                                            ?>
                                        </span>
                                    </p>
                                    <?php
                                    if ($user_news[$x]['status'] == 'Completed') {
                                        ?>
                                        <p class="alert alert-info normalAsh">
                                            Por favor, dê uma avaliação a
                                            <b><?php echo $user_news[$x]['user_name']; ?></b>
                                            sobre <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>"><?php echo $user_news[$x]['product_name']; ?></a>
                                        </p>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="alert alert-white">

                                            <p class="lessDescription">
                                                <b>Descrição : </b>
                                                <?php
                                                if (strlen($user_news[$x]['description']) > 100) {
                                                    echo substr($user_news[$x]['description'], 0, 100) . ' ... ... ... <a class="expand text-info pointer pull-right"><b>(mais)</b></a>';
                                                } else {
                                                    echo $user_news[$x]['description'];
                                                }
                                                ?>
                                                <br/>
                                                <br/>
                                                Por favor, confirme sua 
                                                <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>#confirmBid">oferta</a>.
                                                <br>
                                                <br>
                                                <span class="label label-success"><i class="glyphicon glyphicon-ok-circle"></i> Oferta aceita </span>
                                            </p>

                                            <p style="display: none" class="fullDescription">
                                                <b>Descrição : </b>
                                                <?php echo $user_news[$x]['description'] . '<br><a class="defeat text-info pointer pull-right"><b>(menos)</b></a>'; ?>
                                                <br/>
                                                <br/>
                                                Por favor, confirme sua 
                                                <a href="<?php echo base_url() . 'product/view/' . $user_news[$x]['product_id']; ?>#confirmBid">oferta</a>.
                                                <br>
                                                <br>
                                                <span class="label label-success"><i class="glyphicon glyphicon-ok-circle"></i> Oferta aceita </span>
                                            </p>


                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            }
        } else {
            ?>
            <h3 class="alert alert-info text-center text-bold">
                <span class="text-info"> Your complete activities will be displayed here. <br> Currently it's empty </span>
            </h3>
        <?php } ?>

    </div>
</div>


<script type="text/javascript">
    $('.expand').click(function() {
        $(this).parent('.lessDescription').hide();
        $(this).parent('.lessDescription').next('.fullDescription').show();
    });

    $('.defeat').click(function() {
        $(this).parent('.fullDescription').hide();
        $(this).parent('.fullDescription').prev('.lessDescription').show();
    });
</script>