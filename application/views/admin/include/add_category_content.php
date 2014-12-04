<div class="page-header">
    <h1>Categorias
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><a href="<?php echo base_url(); ?>admin/category"><i class="fa fa-cubes"></i> Categorias</a></li>
    <li class="active"><i class="fa fa-cubes"></i> Adicionar categoria</li>
</ul>


<div class="row">
    <div class="col-md-7 col-md-offset-1">
        <div class="form_content">
            <form class="form-horizontal" role="form" action="<?php echo base_url() ?>admin/category/add" method="post">

                <?php echo isset($error) ? '<div class="alert alert-danger">' . $error . '</div>' : ''; ?>

                <div class="form-group <?php echo form_error("parent_id") ? 'has-error' : ''; ?>">
                    <label for="parent_id" class="col-sm-3 control-label">Pai :</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="parent_id">
                            <option value="0">Nenhum</option>
                            <?php
                            echo $select;
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error("parent_id") ? form_error("parent_id") : ''; ?></span>
                    </div>
                </div>

                <div class="form-group <?php echo form_error("category") ? 'has-error' : ''; ?>">
                    <label for="category" class="col-sm-3 control-label">Nome :</label>
                    <div class="col-sm-9">
                        <input name="category" type="text" class="form-control" id="category" value="<?=set_value('category')?>" placeholder="Nome">
                        <span class="text-danger"><?php echo form_error("category") ? form_error("category") : ''; ?></span>
                    </div>
                </div>

                <div class="form-group <?php echo form_error("url") ? 'has-error' : ''; ?>">
                    <label for="category" class="col-sm-3 control-label">URL :</label>

                    <div class="col-sm-9">
                        <input name="url" value="<?=set_value('category')?>" type="text"
                               class="form-control" id="url" placeholder="URL">
                        <span class="text-danger"><?php echo form_error("url") ? form_error("url") : ''; ?></span>
                    </div>
                </div>
                <script>
                    $("#category").keyup(function(){
                        var ref = $(this).val().toLowerCase().replace(/[^a-z0-9&]+/g,'-');
                        ref = ref.replace(/&/g,'and');
                        $('#url').val(ref);
                    })
                    $("#url").keyup(function(){
                        var ref = $(this).val().toLowerCase().replace(/[^a-z0-9&]+/g,'-');
                        ref = ref.replace(/&/g,'and');
                        $('#url').val(ref);
                    })
                </script>

                <div class="form-group">
                    <div class="form-action">
                        <button onclick="window.location.href = '<?php echo base_url() ?>admin/category'" class="btn btn-danger pull-right" type="button">Cancelar</button>
                        <button type="submit" id="submit" name="submit" value="Submit" class="btn btn-primary pull-right small-margin">Adicionar categoria
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>



