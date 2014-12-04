<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/4/14
 * Time: 2:52 PM
 * To change this template use File | Settings | File Templates.
 */
?>



<div class="user-sidebar">
    <div class="profile-picture online">
        <?php if (!empty($user->profile_pic)) { ?>
            <img class="imgAuto" src="<?php echo base_url() . 'upload/profile_photo/' . $user->profile_pic; ?>" alt=""/>
            <?php
        }
        else {
            ?>
            <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
        <?php } ?>
    </div>
<!--    <div class="merchant">-->
<!--        <a href="#" class="btn btn-block btn-info text-bold text-large">Buy From Me</a>-->
<!--    </div>-->
<!--    <div class="merchant">-->
<!--        <a href="#" class="btn pull-left btn-default text-bold user-follow">Follow</a>-->
<!--        <a href="#" class="btn pull-right btn-default text-bold user-follow">Invite</a>-->
<!--    </div>-->
<!---->
<!--    <div class="sidebar-menu">-->
<!--        <ul class="nav nav-pills nav-stacked">-->
<!--            <li class="active"><a href="#">Overview <i class="glyphicon glyphicon glyphicon-chevron-right pull-right"></i></a></li>-->
<!--            <li><a href="#">Feedback <i class="glyphicon glyphicon glyphicon-chevron-right pull-right"></i></a></li>-->
<!--            <li><a href="#">Portfolio <i class="glyphicon glyphicon glyphicon-chevron-right pull-right"></i></a></li>-->
<!--            <li><a href="#">RÃ©sumÃ© <i class="glyphicon glyphicon glyphicon-chevron-right pull-right"></i></a></li>-->
<!--            <li><a href="#">Exams & Skills <i class="glyphicon glyphicon glyphicon-chevron-right pull-right"></i></a></li>-->
<!--            <li><a href="#">Badges <i class="glyphicon glyphicon glyphicon-chevron-right pull-right"></i></a></li>-->
<!--        </ul>-->
<!---->
<!--    </div>-->

</div>