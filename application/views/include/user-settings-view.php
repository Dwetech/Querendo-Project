<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/4/14
 * Time: 7:40 PM
 * To change this template use File | Settings | File Templates.
 */
/*echo "<pre>";
    print_r($user);
    echo "<hr>".$this->auth->user_data->profile_pic;
echo "</pre>";*/
?>

<div class="user-settings-section">

    <div class="user-settings-form">

        <?php echo!empty($error) ? '<div class="alert alert-danger">' . $error . '</div>' : ''; ?>
        <?php echo!empty($success) ? '<div class="alert alert-success">' . $success . '</div>' : ''; ?>


        <div class="form-group <?php echo form_error('first_name') ? 'has-error' : '' ?>">
            <label for="firstName" class="col-sm-4 control-label">Nome: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="first_name" id="firstName" placeholder="Nome"
                       value="<?php echo set_value('first_name') ? set_value('first_name') : $user->first_name; ?>">
                <span class="text-danger"><?php echo form_error('first_name'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('last_name') ? 'has-error' : '' ?>">
            <label for="lastName" class="col-sm-4 control-label">Sobrenome: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Sobrenome"
                       value="<?php echo set_value('last_name') ? set_value('last_name') : $user->last_name; ?>">
                <span class="text-danger"><?php echo form_error('last_name'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('contact_address') ? 'has-error' : '' ?>">
            <label for="address" class="col-sm-4 control-label">Endereço: </label>
            <div class="col-sm-8">
                <textarea class="form-control" name="contact_address" id="address" placeholder="Endereço de contato"
                    ><?php echo set_value('contact_address') ? set_value('contact_address') : $user->contact_address; ?></textarea>
                <span class="text-danger"><?php echo form_error('contact_address'); ?></span>
            </div>
        </div>
        <!--
        <div class="form-group <?php echo form_error('shipping_address') ? 'has-error' : '' ?>">
            <label for="address" class="col-sm-4 control-label">Endereço: </label>
            <div class="col-sm-8">
                <textarea class="form-control" name="shipping_address" id="address" placeholder="Endereço de cobrança"
                          ><?php echo set_value('shipping_address') ? set_value('shipping_address') : $user->shipping_address; ?></textarea>
                <span class="text-danger"><?php echo form_error('shipping_address'); ?></span>
            </div>
        </div>
-->
        <div class="form-group <?php echo form_error('contact_number') ? 'has-error' : '' ?>">
            <label for="contact_number" class="col-sm-4 control-label">Telefone: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Telefone de contato"
                       value="<?php echo set_value('contact_number') ? set_value('contact_number') : $user->contact_number; ?>">
                <span class="text-danger"><?php echo form_error('contact_number'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('fax') ? 'has-error' : '' ?>">
            <label for="fax" class="col-sm-4 control-label">Fax: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="fax" id="fax" placeholder="Fax"
                       value="<?php echo set_value('fax') ? set_value('fax') : $user->fax; ?>">
                <span class="text-danger"><?php echo form_error('fax'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('city') ? 'has-error' : '' ?>">
            <label for="city" class="col-sm-4 control-label">Cidade: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="city" id="city" placeholder="Cidade"
                       value="<?php echo set_value('city') ? set_value('city') : $user->city; ?>">
                <span class="text-danger"><?php echo form_error('city'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('state') ? 'has-error' : '' ?>">
            <label for="state" class="col-sm-4 control-label">Estado: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="state" id="state" placeholder="Estado"
                       value="<?php echo set_value('state') ? set_value('state') : $user->state; ?>">
                <span class="text-danger"><?php echo form_error('state'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('postal_code') ? 'has-error' : '' ?>">
            <label for="postal_code" class="col-sm-4 control-label">Código postal: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Código postal"
                       value="<?php echo set_value('postal_code') ? set_value('postal_code') : $user->postal_code; ?>">
                <span class="text-danger"><?php echo form_error('postal_code'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('country') ? 'has-error' : '' ?>">
            <label for="country" class="col-sm-4 control-label">País: </label>
            <div class="col-sm-8">
                <select name="country" class="form-control">
                    <option value="">----Selecionar país----</option>
                    <?php foreach ($country as $cntry) { ?>
                        <option value="<?php echo $cntry->country_id; ?>" <?php echo set_select('country', $cntry->country_id); ?>
                            <?php echo $user->country == $cntry->country_id ? 'selected="selected"' : ''; ?>><?php echo $cntry->name; ?></option>
                    <?php } ?>
                </select>
                <span class="text-danger"><?php echo form_error('country'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('company') ? 'has-error' : '' ?>">
            <label for="company" class="col-sm-4 control-label">Empresa: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="company" id="company" placeholder="Empresa"
                       value="<?php echo set_value('company') ? set_value('company') : $user->company; ?>">
                <span class="text-danger"><?php echo form_error('company'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('time_zone') ? 'has-error' : '' ?>">
            <label for="time_zone" class="col-sm-4 control-label">Fuso horário: </label>
            <div class="col-sm-8">
                <select class="form-control" name="time_zone" id="time_zone">
                    <option value="">----Selecionar fuso horário----</option>
                    <?php foreach ($timezones as $timezone) { ?>
                        <option value="<?php echo $timezone->id; ?>" <?php echo $timezone->id == $user->timezone ? 'selected="selected"' : ''; ?>
                            ><?php echo $timezone->name; ?></option>
                    <?php } ?>
                </select>
                <span class="text-danger"><?php echo form_error('time_zone'); ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('about') ? 'has-error' : '' ?>">
            <label for="address" class="col-sm-4 control-label">Sobre mim: </label>
            <div class="col-sm-8">
                <textarea class="form-control" rows="5" name="about" id="address" placeholder="Sobre mim"
                    ><?php echo set_value('about') ? set_value('about') : $user->about; ?></textarea>
                <span class="text-danger"><?php echo form_error('about'); ?></span>
            </div>
        </div>




        <div class="mobile_security hidden">
            <div class="col-md-3">
                <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
            </div>
            <div class="col-md-9">
                <h4 class="text-bold">Telefone de segurança:</h4>
                <p>Informe um número de telefone e país para usar como verificação de sua conta.</p>
                <a href="#">Cadastrar número de segurança</a>
            </div>
        </div>

        <div class="form-group hidden">
            <label for="" class="col-sm-3 control-label">Usar dados de: </label>
            <div class="col-sm-9">
                <div class="radio">
                    <label>
                        <input type="radio" name="data_from" id="data_from1" value="1" checked>
                        Facebook
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="data_from" id="data_from2" value="2">
                        Nenhum
                    </label>
                </div>
            </div>
        </div>



    </div>
</div>