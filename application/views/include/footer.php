<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amieami
 * Date: 5/10/14
 * Time: 5:48 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="footer">
    <div class="container">
        <div class="footer-section">
            <div class="col-md-12">
                <div class="footer_horizontal_list">
                    <ul>
                        <li><a href="#">Procurar vendedor</a></li>
                        <li><a href="#">Procurar produto</a></li>
                        <li><a href="#">Top produto</a></li>
                        <li><a href="#">Melhor vendedor</a></li>
                        <li><a href="#">Top vendedor</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12">
                <p class="copy_write">Copyright 2014 - Querendo </p>
            </div>

            <div class="col-md-12">
                <div class="footer_terms">
                    <ul>
                        <li><a href="#">Sobre nós</a></li>
                        <li><a href="#"> Privacy Policy</a></li>
                        <li><a href="#">Termos e condições</a></li>
                        <li><a href="#">Fees & Charges</a></li>
                        <li><a href="#">Investor</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fbLoginWindow">
    <div class="profile_pic"></div>
    <div class="welcomeText"> <h3>Entrando como <strong class="userName"></strong></h3>
        <form id="fb_register_form" class="form" style="display:none" method="post" role="form">
            <div class="form-login">
                <div class="col-md-8 col-md-offset-2">

                    <p>Coloque o usuário que você quer por favor</p>

                    <div class="form-group usernameFormGroup">
                        <input type="text" name="username" class="form-control" id="fb_signup_username" placeholder="Usuário">
                        <p id="fb_signup_message" class="help-block"></p>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="fb_register_submit" class="btn-primary">Registrar</button>
                    </div>

                </div>
            </div>

        </form>
        <span class="loading"><img src="<?php echo base_url() ?>/resources/img/loading.gif" alt=""/> </span>
    </div>


</div>
<?php if ($this->auth->logged_in) { ?>
    <script>
        querendo.check_message(baseurl);
    </script>
<?php } ?>

