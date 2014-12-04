<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<section class="header">
    <div class="container">
        <div class="header-section">
            <div class="col-md-3">
                <div class="websiteName">
                    <h1><a href="<?php echo base_url() ?>">
                            <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/querendo.png"
                                 alt="Querendo"/></a></h1>
                </div>
            </div>
            <div class="col-md-4 pull-right">
                <div class="user-drop-down">
                    <div class="pull-right">
                        <div class="btn-group">
                            <a type="button" class="btn btn-user" style="color: white;text-decoration: none;"
                               href="<?php echo base_url() . 'user/view/' . $_SESSION['user_name']; ?>">
                                   <?php echo $_SESSION['user_name']; ?>
                            </a>
                            <button type="button" class="btn btn-user dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?php echo base_url() . 'user/view/' . $_SESSION['user_name']; ?>">Perfil</a>
                                </li>
                                <li><a href="<?php echo base_url() . 'user/settings/'; ?>">Editar opções</a></li>
                                <li><a href="<?php echo base_url() . 'login/logout'; ?>">Sair</a></li>
                            </ul>
                        </div>
                    </div>


                    <div class="pull-right">
                        <div class="profileImg pull-right">
                            <a href="<?php echo base_url() . 'user/view/' . $_SESSION['user_name']; ?>">
                                <?php if (!empty($this->auth->user_data->profile_pic)) { ?>
                                    <img class="imgAuto"
                                         src="<?php echo base_url() . 'upload/profile_photo/' . $this->auth->user_data->profile_pic; ?>"
                                         alt=""/>
                                         <?php
                                     } else {
                                         ?>
                                    <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
                                <?php } ?>
                            </a>
                        </div>
                    </div>

                    <?php
                    $messages = Message_model::get_message_notification($_SESSION['user_id']);
                    ?>
                    <div class="pull-right">
                        <div class="messagesNotify pull-right">

                            <i class="glyphicon glyphicon-envelope pointer icon-white dropdown-toggle"
                               data-toggle="dropdown"></i>
                            <span
                                class="messagesNotifyNumber"><?php echo $messages['0'] > 0 ? $messages['0'] : ''; ?></span>

                            <div class="msgNitification dropdown-menu" role="menu">
                                <p class="notifyHeader">Masseges</p>
                                <ul class="msgNotifyBoxMsg">
                                    <?php
                                    if ($messages) {
                                        foreach ($messages as $message) {
                                            if ($message['count'] != 0) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'messages/index/' . $message['thread_id']; ?>">
                                                        <div class="notification">
                                                            <div class="col-md-1 noPadding">
                                                                <div class="notifyUpic">
                                                                    <img class="imgAuto"
                                                                         src="<?php echo base_url() . 'upload/profile_photo/' . $message['profile_pic']; ?>"
                                                                         alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <p>
                                                                    <b class="text-blue"><?php echo $message['user_name']; ?></b>
                                                                    <span class="normalAsh">
                                                                        sent <b><?php echo $message['count']; ?></b> <?php echo $message['count'] > 1 ? 'messages' : 'message'; ?>
                                                                        to you.
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                                <div class="msgBoxLink">
                                    <?php if ($messages['0'] == 0) {
                                        ?>
                                        <p class="text-center text-primary noMsg">No Unread Messages</p>
                                    <?php } else {
                                        ?>
                                        <a class="text-center seeAllNotification" href="<?php echo base_url() ?>messages/">See All</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="pull-right">
                                            <div class="notNotify pull-right">
                    
                                                <i class="glyphicon glyphicon-bell pointer icon-white dropdown-toggle" data-toggle="dropdown">
                                                </i>
                                                <span class="messagesNotifyNumber">3</span>
                    
                                                <ul class="msgNotifyBoxNot dropdown-menu" role="menu">
                                                    <p class="notifyHeader"><b>Notifications</b></p>
                                                    <li>
                                                        <a href="#">
                                                            <div class="notification">
                                                                <div class="col-md-1 noPadding">
                                                                    <div class="notifyUpic">
                                                                        <img class="imgAuto" src="http://localhost/querendo/upload/profile_photo/nCxWyxeO.jpg" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-11">
                                                                    <p><b class="text-blue">user_name</b> <span class="normalAsh">send a message to you. </span></p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>-->

                </div>

            </div>
<!--            <div class="col-md-2 pull-right">
                <div class="balance">
                    <?php //$balance = $this->user_model->getBalance($_SESSION['user_id']); ?>
                    <ul>
                        <li class="pull-left">USD</li>
                        <li class="pull-right">$<?php //echo $balance->balance; ?></li>
                    </ul>
                    <a href="<?php //echo base_url('finance/deposit'); ?>">
                        <i id="depositTooltip" data-toggle="tooltip" data-placement="right" title="Deposit Fund"
                           class="glyphicon glyphicon-plus-sign addBalance"></i>
                    </a>
                </div>
            </div>-->
        </div>
    </div>
</section>


<script type="text/javascript">
    $('#depositTooltip').tooltip();
</script>