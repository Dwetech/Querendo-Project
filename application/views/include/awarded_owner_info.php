<?php

$sellerData = $this->user_model->get_user_by_id($awardedUser);

?>


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
            <td><b>Método de pagamento :</b></td>
            <td><span class="label label-primary"><?php echo $product_data->shipping_method; ?></span></td>
        </tr>
        <tr>
            <td><b>Endereço de e-mail :</b></td>
            <td class="normalAsh"><?php echo $sellerData->email; ?></td>
        </tr>
        <tr>
            <td><b>Telefone :</b></td>
            <td class="normalAsh"><?php echo $sellerData->contact_number; ?></td>
        </tr>
        <tr>
            <td><b>Endereço :</b></td>
            <td class="normalAsh"><?php echo nl2br($sellerData->contact_address); ?></td>
        </tr>
        </tbody>
    </table>
</div>