<div class="page-header">
    <h1>Configurações do site
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="glyphicon glyphicon-cog"></i> Configurações</li>
</ul>

<ul class="breadcrumb">
    <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/website_settings/edit"><i class="glyphicon glyphicon-edit"></i> Editar configurações</a>
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
        <td><b>Palavra chave</b></td>
        <td><?php echo $this->settings_model->data['keyword'] ?></td>
    </tr>
    <tr>
        <td><b>Descrição</b></td>
        <td><?php echo $this->settings_model->data['description'] ?></td>
    </tr>
    <tr>
        <td><b>E-mail</b></td>
        <td><?php echo $this->settings_model->data['website_email'] ?></td>
    </tr>
    <tr>
        <td><b>Nome</b></td>
        <td><?php echo $this->settings_model->data['website_name'] ?></td>
    </tr>
    <tr>
        <td><b>Direitos autorais</b></td>
        <td><?php echo $this->settings_model->data['copyright'] ?></td>
    </tr>
    <tr>
        <td><b>E-mail do Paypal</b></td>
        <td><?php echo $this->settings_model->data['paypal_email'] ?></td>
    </tr>
    <tr>
        <td><b>Taxa</b></td>
        <td><?php echo $this->settings_model->getSettings('fee_percent') ?>%</td>
    </tr>
    </tbody>
</table>
