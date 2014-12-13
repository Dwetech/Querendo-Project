<?php
$project = 0;

if (!empty($completeWork)) {


    foreach ($completeWork as $completeWorkList) {


        $project = $project + 1;
        ?>


        <div class="tab-table">
        <div class="complete-list">
        <table class="table">
            <tbody>
            <tr class="success">
                <td class="activity-index">
                    <a href="<?php echo base_url(); ?>product/view/<?php echo $completeWorkList->product_id; ?>"
                        ><b><?php echo $completeWorkList->name; ?></b></a>
                </td>

                <td class="activity-index verticalMiddle text-center">R$ <?php echo number_format((float)$completeWorkList->bid_amount, 2, '.', '') ?> Reais</td>
                <?php
                //If there is any work with completed status
                if ($work_count != 0) {
                    if (!empty($userCat) && $userCat == 'buyer') {
                        $review = $this->user_model->getReviewComplete($completeWorkList->owner_id, $completeWorkList->bidder_id, $completeWorkList->product_id);
                    } else {
                        $review = $this->user_model->getReviewComplete($completeWorkList->bidder_id, $completeWorkList->owner_id, $completeWorkList->product_id);
                    }
                    $user_rating = !empty($review) ? $review->rating : 0;
                    ?>
                    <td width="150px" class="activity-value verticalMiddle text-center">
                        <input id="input-21e" value="<?php echo $user_rating; ?>" class="rating rating_star"
                               min="0" max="5" step="1" data-size="xs" data-disabled="true" data-show-caption="false"
                               data-show-clear="false">
                    </td>
                    <td width="50px"
                        class="activity-index text-bold text-right"><?php echo number_format((float) $user_rating, 2, '.', ''); ?></td>
                <?php } ?>
            </tr>

            </tbody>
        </table>
        <div class="work-info">

        <div class="alert alert-warning noMargin formPadding">
            <?php if ($review ==  FALSE) { ?>
                <div class="quotation mar-top-small">
                    <div class="col-md-1 noPadding">
                        <div class="profile-picture-img">
                            <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
                        </div>
                    </div>
                    <div class="col-md-11 youPadding">
                        <div class="client-comments">
                            <div class="alert alert-info noMargin">

                                <p class="text-red"><b>Avaliação pendente</b>
                                </p>

                            </div>
                            <i class="chatArrowToReview mirror glyphicon glyphicon-play"></i>
                        </div>
                    </div>
                </div>

            <?php
            }
            if (!empty($userCat) && $userCat == 'buyer') {
                ?>

                <?php
                $reviewerMe = $this->user_model->activityComplete($completeWorkList->owner_id, $completeWorkList->bidder_id, $completeWorkList->product_id);
                if (!empty($reviewerMe)) {
                    ?>
                    <div class="quotation mar-top-small">
                        <div class="col-md-1 noPadding">
                            <div class="profile-picture-img">
                                <?php if (!empty($reviewerMe->profile_pic)) { ?>
                                    <img class="imgAuto"
                                         src="<?php echo base_url() ?>upload/profile_photo/<?php echo $reviewerMe->profile_pic ?>"
                                         alt=""/>
                                <?php
                                } else {
                                    ?>
                                    <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png"
                                         alt=""/>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-11 youPadding">
                            <div class="client-comments">
                                <div class="alert alert-info noMargin">
                                    <a href="<?php echo base_url(); ?>user/view/<?php echo $reviewerMe->user_name; ?>"
                                       class="text-bold"><?php echo $reviewerMe->user_name; ?></a><br><br>

                                    <p><b>"</b>

                                        <?php echo $reviewerMe->message; ?>

                                        <b>"</b>
                                    </p>
                                            <span
                                                class="client-comments-date"><?php echo $reviewerMe->date ?></span>

                                </div>
                                <i class="chatArrowToReview mirror glyphicon glyphicon-play"></i>
                            </div>
                        </div>
                    </div>

                <?php
                }

                $reviewerYou = $this->user_model->activityComplete($completeWorkList->bidder_id, $completeWorkList->owner_id, $completeWorkList->product_id);
                if (!empty($reviewerYou)) {
                    ?>
                    <div class="quotation mar-top-small">
                        <div class="col-md-11 mePadding">
                            <div class="client-comments">
                                <div class="alert alert-default noMargin">
                                    <a href="<?php echo base_url(); ?>user/view/<?php echo $reviewerYou->user_name; ?>"
                                       class="text-bold"><?php echo $reviewerYou->user_name; ?></a><br><br>

                                    <p><b>"</b>

                                        <?php echo $reviewerYou->message; ?>

                                        <b>"</b>
                                    </p>
                                            <span
                                                class="client-comments-date"><?php echo $reviewerYou->date ?></span>

                                </div>
                                <i class="chatArrowFromReview glyphicon glyphicon-play"></i>
                            </div>
                        </div>
                        <div class="col-md-1 noPadding">
                            <div class="profile-picture-img">
                                <?php if (!empty($reviewerYou->profile_pic)) { ?>
                                    <img class="imgAuto"
                                         src="<?php echo base_url() ?>upload/profile_photo/<?php echo $reviewerYou->profile_pic ?>"
                                         alt=""/>
                                <?php
                                } else {
                                    ?>
                                    <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png"
                                         alt=""/>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <?php
                $reviewerYou = $this->user_model->activityComplete($completeWorkList->bidder_id, $completeWorkList->owner_id, $completeWorkList->product_id);
                if (!empty($reviewerYou)) {
                    ?>
                    <div class="quotation">
                        <div class="col-md-1 noPadding">
                            <div class="profile-picture-img">
                                <?php if (!empty($reviewerYou->profile_pic)) { ?>
                                    <img class="imgAuto"
                                         src="<?php echo base_url() ?>upload/profile_photo/<?php echo $reviewerYou->profile_pic ?>"
                                         alt=""/>
                                <?php
                                } else {
                                    ?>
                                    <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png"
                                         alt=""/>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-11 youPadding">
                            <div class="client-comments">
                                <div class="alert alert-info noMargin">
                                    <a href="<?php echo base_url(); ?>user/view/<?php echo $reviewerYou->user_name; ?>"
                                       class="text-bold"><?php echo $reviewerYou->user_name; ?></a><br><br>

                                    <p><b>"</b>

                                        <span class="normalAsh"><?php echo $reviewerYou->message; ?></span>

                                        <b>"</b>
                                    </p>
                                            <span
                                                class="client-comments-date"><?php echo $reviewerYou->date ?></span>

                                </div>
                                <i class="chatArrowToReview mirror glyphicon glyphicon-play"></i>
                            </div>
                        </div>
                    </div>
                <?php
                }
                $reviewerMe = $this->user_model->activityComplete($completeWorkList->owner_id, $completeWorkList->bidder_id, $completeWorkList->product_id);
                if (!empty($reviewerMe)) {
                    ?>
                    <div class="quotation mar-top-small">
                        <div class="col-md-11 mePadding">
                            <div class="client-comments">
                                <div class="alert alert-default noMargin">
                                    <a href="<?php echo base_url(); ?>user/view/<?php echo $reviewerMe->user_name; ?>"
                                       class="text-bold"><?php echo $reviewerMe->user_name; ?></a><br><br>

                                    <p><b>"</b>

                                        <span class="normalAsh"><?php echo $reviewerMe->message; ?></span>

                                        <b>"</b>
                                    </p>
                                            <span
                                                class="client-comments-date"><?php echo $reviewerMe->date ?></span>

                                </div>
                                <i class="chatArrowFromReview glyphicon glyphicon-play"></i>
                            </div>
                        </div>
                        <div class="col-md-1 noPadding">
                            <div class="profile-picture-img">
                                <?php if (!empty($reviewerMe->profile_pic)) { ?>
                                    <img class="imgAuto"
                                         src="<?php echo base_url() ?>upload/profile_photo/<?php echo $reviewerMe->profile_pic ?>"
                                         alt=""/>
                                <?php
                                } else {
                                    ?>
                                    <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png"
                                         alt=""/>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>


        <div id="project-<?php echo $project ?>" class="project-description">
            <p><b>Descrição do projeto : </b>
                <?php echo $completeWorkList->description; ?>
            </p>
        </div>
        <?php if ($work_count != 0) { //If there is any work with completed status     ?>
            <a data-content="more" data-number="<?php echo $project; ?>" class="more-less pull-right">( Mais )</a>
        <?php } ?>
        </div>
        </div>
        </div>

    <?php
    }
}
?>