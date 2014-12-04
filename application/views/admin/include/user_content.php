<div class="page-header">
    <h1>Usuários
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="fa fa-cubes"></i> Usuários</li>
</ul>
<ul class="userSearchSection">

    <div class="col-md-4 noPadding">
        <form action="" method="post" role="form">
            <div class="form-group">
                <div class="col-sm-9 noPadding">
                    <input type="text" placeholder="Buscar usuário" id="inputEmail3" class="form-control" name="searchData"
                           value="<?php echo $searchData; ?>">
                </div>
                <div class="col-sm-3 noPadding">
                    <button class="btn btn-success pull-right" value="Submit" name="submit" type="submit">Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>

</ul>

<?php if (!empty($user)) { ?>
    <table class="table table-striped noBorder">
        <thead>
        <tr class="tableHead">
            <td>Nome completo</td>
            <td>Nome de usuário</td>
            <td>Empresa</td>
            <td class="text-center">País</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($user as $r) {
            $activity = $this->user_model->activity($r->id); ?>
            <tr class="<?php echo $activity == 0 ? 'alert alert-danger' : ''; ?>">
                <td><b><?php echo $r->first_name . ' ' . $r->last_name ?></b></td>
                <td><a target="_blank"
                       href="<?php echo base_url() . 'user/view/' . $r->user_name ?>"><?php echo $r->user_name ?> </a></td>
                <td><?php echo $r->company ?></td>

                <?php $buyerCountry = $this->user_model->getCountryCode($r->country); ?>
                <td class="text-center"><span data-placement="left" title="<?php echo !empty($buyerCountry) ? $buyerCountry->name : ''; ?>" data-toggle="tooltip"
                        class="sellerMap flag flag-<?php echo !empty($buyerCountry) ? strtolower($buyerCountry->iso_code_2) : ''; ?>"></span>
                        </span>
                </td>

                <td class="text-center" width="100px">
                    <?php if ($activity == 1) { ?>
                        <a class="btn btn-danger"
                           href="<?php echo base_url(); ?>admin/user/activity/<?php echo $r->id; ?>">
                            <i class="fa fa-minus-circle"></i> Invativar
                        </a>
                    <?php } else { ?>
                        <a class="btn btn-success"
                           href="<?php echo base_url(); ?>admin/user/activity/<?php echo $r->id; ?>">
                            <i class="fa fa-check"></i> Ativar
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="alert alert-info text-center">Não há usuários cadastrados</p>
<?php } ?>

<script type="text/javascript">
    $('.sellerMap').tooltip();
</script>
