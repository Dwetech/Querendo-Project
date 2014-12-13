<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>

<div class="login-content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="login-content-data">

                <div class="facebook-login">
                    <div class="col-md-10 col-md-offset-1">
                        <a onclick="fb_login();" href="#" class="btn btn-block btn-facebook text-bold facebookData">
                            <img class="imgAuto facebookDataLogo"
                                 src="<?php echo base_url(); ?>resources/img/facebook.png" alt=""/>
                            Entrar com Facebook
                        </a>

                        <div class="modal_hr">
                            <div class="inner">ou</div>
                        </div>
                    </div>
                </div>


                <div class="form-login">
                    <div class="col-md-10 col-md-offset-1">
                        <?php echo !empty($error) ? '<div class="alert alert-danger">'.$error.'</div>' : ''; ?>

                        <form method="post" action="<?php site_url('login') ?>" role="form">
                            <div class="form-group <?php echo form_error('email') ? 'has-error' : '' ?>">
                                <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" value="<?php echo set_value('email'); ?>" >
                                <span class="text-danger"><?php echo form_error('email'); ?></span>
                            </div>
                            <div class="form-group <?php echo form_error('password') ? 'has-error' : '' ?>">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Senha" value="<?php echo set_value('password'); ?>">
                                <span class="text-danger"><?php echo form_error('password'); ?></span>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember_me" type="checkbox"> Lembrar-me
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="form-action">
                                    <a href="<?php echo base_url(); ?>user_settings/forgot_password" class="pull-left pointer forgot_password_link">Esqueceu sua senha?</a>
                                    <button type="button" class="btn btn-default pull-right"
                                            onclick="window.location.href = '<?php echo base_url(); ?>'">
                                        Cancelar
                                    </button>
                                    <button type="submit" id="submit" name="submit" value="Submit"
                                            class="btn btn-primary pull-right mar-right-small">Entrar agora
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



