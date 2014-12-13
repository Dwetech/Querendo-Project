<div class="activity-table">
    <table class="table table-striped noBorder">
        <colgroup>
            <col class="col-xs-2">
            <col class="col-xs-6">
        </colgroup>
        <thead>
        </thead>
        <tbody>
        <tr>
            <td><b>Método de envio :</b></td>
            <td><span class="label label-primary"><?php echo $product_data->shipping_method; ?></span></td>
        </tr>
        <tr>
            <td><b>Endereço de e-mail :</b></td>
            <td class="normalAsh"><?php echo $product_data->email; ?></td>
        </tr>
        <tr>
            <td><b>Telefone :</b></td>
            <td class="normalAsh"><?php echo $product_data->contact_number; ?></td>
        </tr>
        <tr>
            <td><b>Endereço :</b></td>
            <td class="normalAsh"><?php echo nl2br($product_data->contact_address); ?></td>
        </tr>
        <tr>
            <td><b>Endereço :</b></td>
            <td class="normalAsh"><?php echo nl2br($product_data->shipping_address); ?></td>
        </tr>
        </tbody>
    </table>
</div>