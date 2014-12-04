<div class="page-header">
    <h1>Opções
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="glyphicon glyphicon-cog"></i> Configurações</li>
</ul>

<ul class="breadcrumb">
    <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/settings/change_email"><i class="glyphicon glyphicon-edit"></i> Alterar e-mail</a>
    <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/settings/change_password"><i class="glyphicon glyphicon-edit"></i> Alterar senha</a>
</ul>

<?php echo $this->session->flashdata('success') ? '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>' : ''; ?>



<table class="table table-striped noBorder">
    <colgroup>
        <col class="col-xs-2">
        <col class="col-xs-6">
    </colgroup>
    <thead>
    <tr class="tableHead">
        <th>Nome</th>
        <th>Valor</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><b>E-mail</b></td>
        <td><?php echo $admin_data->email; ?></td>
    </tr>
    <tr>
        <td><b>Senha</b></td>
        <td><b>************************</b></td>
    </tr>
    </tbody>
</table>
