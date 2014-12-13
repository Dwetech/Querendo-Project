<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>


<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog login-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Entrar</h3>
            </div>
            <div class="modal-body">

                <div class="facebook-login">
                    <div class="col-md-10 col-md-offset-1">
                        <a onclick="fb_login();" href="#" class="btn btn-block btn-primary facebookData">
                            <img class="imgAuto facebookDataLogo" src="<?php echo base_url(); ?>resources/img/facebook.png" alt=""/>
                            Entrar com Facebook
                        </a>

                        <div class="modal_hr">
                            <div class="inner">ou</div>
                        </div>
                    </div>
                </div>


                <form action="<?php echo site_url('login') ?>" method="post" role="form">
                    <div class="form-login">
                        <div class="col-md-10 col-md-offset-1">


                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Senha">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember_me" type="checkbox"> Lembrar-me
                                </label>
                            </div>

                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <a onclick="forgot_password();" class="pull-left pointer">Esqueceu sua senha?</a>
                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Entrar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
            </form>
        </div>
    </div>
</div>


