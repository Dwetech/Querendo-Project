<div class="page-header">
    <h1>Alterar senha
    </h1>
</div>


<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/settings"><i class="glyphicon glyphicon-cog"></i> Configurações</a>
    </li>
    <li class="active"><i class="glyphicon glyphicon-edit"></i> Alterar senha</li>
</ul>


<div class="col-md-8 col-md-offset-1">
    <form class="form-horizontal" role="form" action="" method="post">



        <div class="form-group">
            <label for="oldPass" class="col-sm-4 control-label">Senha atual :</label>

            <div class="col-sm-8">
                <input type="password" name="oldPass"
                       class="form-control" id="keyword">
            </div>
        </div>

        <div class="form-group">
            <label for="newPass" class="col-sm-4 control-label">Nova senha :</label>

            <div class="col-sm-8">
                <input type="password" name="newPass"
                       class="form-control" id="keyword">
            </div>
        </div>
        <div class="form-group">
            <label for="conPass" class="col-sm-4 control-label">Confirmar nova senha :</label>

            <div class="col-sm-8">
                <input type="password" name="conPass"
                       class="form-control" id="keyword">
            </div>
        </div>


        <div class="form-group">
            <div class="form-action">
                <a onclick="window.location.href = '<?php echo base_url() ?>admin/settings'"
                   class="btn btn-danger pull-right">Cancelar</a>
                <button type="submit" id="submit" name="submit" value="Submit"
                        class="btn btn-primary pull-right small-margin">
                    Salvar alterações
                </button>
            </div>
        </div>
    </form>
</div>
