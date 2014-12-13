<div class="page-header">
    <h1>Editar configurações
    </h1>
</div>


<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/settings"><i class="glyphicon glyphicon-cog"></i> Configurações</a>
    </li>
    <li class="active"><i class="glyphicon glyphicon-edit"></i> Editar configurações</li>
</ul>


<div class="col-md-7 col-md-offset-1">
    <form class="form-horizontal" role="form" action="" method="post">

        <div class="form-group">
            <label for="keyword" class="col-sm-4 control-label">Palavra chave :</label>

            <div class="col-sm-8">
                <input type="text" name="keyword" value="<?php echo set_value('keyword', $this->settings_model->data['keyword']) ?>"
                       class="form-control" id="keyword">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-4 control-label">Descrição:</label>

            <div class="col-sm-8">
                <textarea class="form-control" name="description" id="description"><?php echo $this->settings_model->data['description'] ?></textarea>
            </div>
        </div>
        <div class="form-group <?php echo form_error('website_email') ? 'has-error' : ''?>">
            <label for="website_email" class="col-sm-4 control-label">E-mail:</label>

            <div class="col-sm-8">
                <input type="text" name="website_email" value="<?php echo set_value('website_email', $this->settings_model->data['website_email']) ?>"
                       class="form-control" id="website_email">
                <span class="help-block"><?php echo form_error('website_email') ?></span>
            </div>
        </div>
        <div class="form-group <?php echo form_error('website_name') ? 'has-error' : ''?>">
            <label for="website_name" class="col-sm-4 control-label">Nome:</label>

            <div class="col-sm-8">
                <input type="text" name="website_name" value="<?php echo set_value('website_name', $this->settings_model->data['website_name']) ?>"
                       class="form-control" id="website_name">
                <span class="help-block"><?php echo form_error('website_name') ?></span>

            </div>
        </div>
        <div class="form-group">
            <label for="copyright" class="col-sm-4 control-label">Direitos autorais:</label>

            <div class="col-sm-8">
                <textarea class="form-control" name="copyright" id="copyright"><?php echo $this->settings_model->data['copyright'] ?></textarea>
            </div>
        </div>
        <div class="form-group <?php echo form_error('paypal_email') ? 'has-error' : ''?>">
            <label for="paypal_email" class="col-sm-4 control-label">E-mail do Paypal:</label>

            <div class="col-sm-8">
                <input type="text" name="paypal_email" value="<?php echo set_value('paypal_email', $this->settings_model->data['paypal_email']) ?>"
                       class="form-control" id="paypal_email">
                <span class="help-block"><?php echo form_error('paypal_email') ?></span>
            </div>
        </div>

        <div class="form-group <?php echo form_error('fee_percent') ? 'has-error' : ''?>">
            <label for="fee_percent" class="col-sm-4 control-label">Taxa:</label>


            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" name="fee_percent" value="<?php echo set_value('fee_percent', $this->settings_model->getSettings('fee_percent')) ?>"
                           class="form-control" id="fee_percent">
                    <div class="input-group-addon">%</div>
                </div>
                <span class="help-block"><?php echo form_error('fee_percent') ?></span>

            </div>
        </div>


        <div class="form-group">
            <div class="form-action">

                <div class="col-sm-8 col-md-offset-4">

                    <button type="submit" id="submit" name="submit" value="Submit"
                            class="btn btn-primary">
                        Salvar alterações
                    </button>
                    <a href="<?php echo base_url() ?>admin/website_settings"class="btn">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</div>
