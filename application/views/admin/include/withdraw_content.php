<div class="page-header">
    <h1>Solicitação de saque
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="glyphicon glyphicon-export"></i> Solicitações de saque</li>
</ul>


<?php echo $this->session->flashdata('success') ? '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>' : ''; ?>

<?php if (!empty($withdraw)) { ?>
    <table class="table table-striped noBorder">
        <thead>
        <tr class="tableHead">
            <th width="120px">Solicitado em</th>
            <th width="">Detalhes</th>
            <th width="100px" class="text-center">Quantidade</th>
            <th width="100px" class="text-center">Situação</th>
            <th width="200px" class="text-center">Data de processamento</th>
            <th width="120px" class="text-center">Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($withdraw as $w) {

            $w->status == 'pending' ? $classCss = 'info' : '';
            $w->status == 'success' ? $classCss = 'success' : '';
            $w->status == 'hold' ? $classCss = 'danger' : '';
            $w->status == 'cancel' ? $classCss = 'default' : '';

            ?>
            <tr>
                <td><span class="label label-primary"><?php echo $w->method ?></span></td>
                <td><?php echo $w->details ?></td>
                <td class="text-center"><b>$<?php echo $w->amount ?></b></td>
                <td class="text-center"><span class="label label-<?php echo $classCss ?>"><?php echo $w->status ?></span></td>
                <td class="text-center"><?php echo date("d M, Y", strtotime($w->create_date)) . ' at ' . date("g:i a", strtotime($w->create_date)); ?></td>
                <td class="text-center">
                    <?php if($w->status != 'cancel' && $w->status != 'success'){ ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                Ação <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu custom_action" role="menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/pending/<?php echo $w->withdraw_id; ?>">Pendente</a>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/success/<?php echo $w->withdraw_id; ?>">Sucesso</a>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/hold/<?php echo $w->withdraw_id; ?>">Preso</a>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/cancel/<?php echo $w->withdraw_id; ?>">Cancelar</a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php
} else {
    echo '<h4 class="alert alert-info text-center">Não há solicitações de saque</h4>';
} ?>


