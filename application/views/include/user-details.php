<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/4/14
 * Time: 2:52 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="user-information">

    <div class="about-user">
        <div class="about-user-details noMargin">
            <div class="col-md-8">
                <div class="user-info">
                    <div class="user-data">
                        <h1 class="text-bold"><?php echo $user->first_name . ' ' . $user->last_name; ?></h1>

                        <textarea style="width: 100%;height: 150px;" class="hidden edit_about edit_text"></textarea>
                        <button id="submit" class="btn btn-info pull-right hidden edit_about submit_about">Done</button>
                    </div>
                    <div class="user-data">
                        <div class="basic-data">
                            <p class="pull-left noMargin"><b>Usuário: </b> <?php echo $user->user_name; ?></p>
                        </div>
                        <div class="basic-data">
                            <p class="pull-left noMargin"><b>País: </b> <?php echo $user->country_name; ?></p>
                        </div>
                        <div class="basic-data">
                            <p class="pull-left noMargin"><b>Membro desde: </b> <?php echo $user->member_since; ?></p>
                        </div>
                    </div>
                    <div class="user-data">
                        <p class="user-summary">
                            <?php echo nl2br($user->about); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="user-potentian">
                    <h3 class="text-bold">Reputação:</h3>
                    <?php
                    if ($userCat == 'buyer') {
                        $review_avg = $user->buyer_review;
                        $review_count = $user->buyer_review_count;
                    } else {
                        $review_avg = $user->seller_review;
                        $review_count = $user->seller_review_count;
                    }
                    ?>
                    <h1 class="text-bold"><?php echo number_format((float)$review_avg, 2, '.', ''); ?> <span class="text-large">/5</span>
                    </h1>


                    <input id="input-21e" value="<?php echo $review_avg; ?>" class="rating rating_star" min="0"
                           max="5" step="1" data-size="xs" data-disabled="true" data-show-caption="false"
                           data-show-clear="false">


                    <div class="user-review">
                        <a href="#">( <?php echo $review_count; ?> Avaliações )</a>
                    </div>
                    <!--<div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar"
                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                             style="width: 80%">
                            $ 4.00
                        </div>
                    </div>-->
                </div>
            </div>
        </div>

        <!--<div class="about-user-details noMargin">-->
        <!--    <div class="col-md-6">-->
        <!--        <div class="user-activity">-->
        <!--            <h4 class="text-bold">My Activity :</h4>-->
        <!---->
        <!--            <table class="table">-->
        <!--                <tbody>-->
        <!--                <tr>-->
        <!--                    <td class="activity-index">Completion Rate</td>-->
        <!--                    <td class="activity-value">-->
        <!--                        <div class="progress progress-striped active">-->
        <!--                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"-->
        <!--                                 aria-valuemin="0" aria-valuemax="100" style="width: 60%">-->
        <!--                                60%-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </td>-->
        <!--                </tr>-->
        <!--                <tr>-->
        <!--                    <td class="activity-index">On Budget</td>-->
        <!--                    <td class="activity-value">-->
        <!--                        <div class="progress progress-striped active">-->
        <!--                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40"-->
        <!--                                 aria-valuemin="0" aria-valuemax="100" style="width: 40%">-->
        <!--                                40%-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </td>-->
        <!--                </tr>-->
        <!--                <tr>-->
        <!--                    <td class="activity-index">On Time</td>-->
        <!--                    <td class="activity-value">-->
        <!--                        <div class="progress progress-striped active">-->
        <!--                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"-->
        <!--                                 aria-valuemin="0" aria-valuemax="100" style="width: 70%">-->
        <!--                                70%-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </td>-->
        <!--                </tr>-->
        <!--                <tr>-->
        <!--                    <td class="activity-index">Repeat Hire Rate</td>-->
        <!--                    <td class="activity-value">-->
        <!--                        <div class="progress progress-striped active">-->
        <!--                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40"-->
        <!--                                 aria-valuemin="0" aria-valuemax="100" style="width: 30%">-->
        <!--                                30%-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </td>-->
        <!--                </tr>-->
        <!---->
        <!--                </tbody>-->
        <!--            </table>-->
        <!---->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="col-md-6">-->
        <!--        <div class="user-skill">-->
        <!--            <h4 class="text-bold">My Skills :</h4>-->
        <!---->
        <!--            <div class="skill-diagram well">-->
        <!---->
        <!--            </div>-->
        <!---->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <div class="about-user-details">

            <ul class="nav nav-tabs" id="userTab">
                <li class="active"><a data-toggle="tab" href="#complete">Produtos completos (<?php echo $work_count; ?>) </a></li>
                <li class=""><a data-toggle="tab" href="#progress">Produtos em progresso (<?php echo $runningWork_count; ?>)</a></li>
                <?php if($userCat == 'seller'){ ?>
                    <li class=""><a data-toggle="tab" href="#latest">Última oferta em (<?php echo $bidOn_count ?>)</a></li>
                <?php } ?>
            </ul>

            <div class="tab-content" id="userTabContent">
                <div id="complete" class="tab-pane fade active in">
                    <?php echo $this->load->view('include/completeWork_content'); ?>
                </div>
                <div id="progress" class="tab-pane fade">
                    <?php echo $this->load->view('include/productRunning_content'); ?>
                </div>
                <?php if($userCat == 'seller'){ ?>
                    <div id="latest" class="tab-pane fade">
                        <?php echo $this->load->view('include/latestBidOn_content'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    less_more();
</script>