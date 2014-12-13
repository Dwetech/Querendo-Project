<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel"
     aria-hidden="true">
    <div class="modal-dialog login-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Cadastre-se gratuitament hoje!</h3>
            </div>
            <div class="modal-body">

                <div class="facebook-login">
                    <div class="col-md-10 col-md-offset-1">
                        <a onclick="fb_login();" id="facebookRegi" href="#" class="btn btn-block btn-primary facebookData">
                            <img class="imgAuto facebookDataLogo" src="<?php echo base_url(); ?>resources/img/facebook.png" alt=""/>
                            Cadastrar-se com Facebook
                        </a>

                        <div class="modal_hr">
                            <div class="inner">ou</div>
                        </div>
                    </div>
                </div>


                <form action="<?php echo site_url('signup') ?>" method="post" role="form">
                    <div class="form-login">
                        <div class="col-md-10 col-md-offset-1">


                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Usuário">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Senha">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirmar senha">
                            </div>


                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <a onclick="already_member()" class="pull-left pointer">Já é um membro?</a>
                <button type="submit" class="btn btn-primary" value="Submit" name="submit">Cadastrar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
            </form>
        </div>
    </div>
</div>