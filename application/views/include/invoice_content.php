<div class="col-md-10 col-md-offset-1 noPadding">
    <div class="dashboard-section">
        <div class="page-header">
            <h2>Faturas</h2>
        </div>
    </div>

    <?php
    if (!empty($invoice_data)) {
        ?>
        <table class="table table-striped noBorder">

            <thead class="tableHead">
                <tr>
                    <th width="320px">Nome do produto</th>
                    <th>Valor</th>
                    <th>Situação</th>
                    <th width="220px" class="text-center">Data</th>
                    <th width="150px"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($invoice_data as $log) { ?>
                    <tr>
                        <td><span class=""><a href="<?php echo base_url('product/view/' . $log->product_id); ?>"><?php echo $log->name; ?></a></span></td>
                        <td><b>R$ <?php echo $log->payment; ?></b></td>
                        <td><span class="label <?php echo $log->status == 'unpaid' ? 'label-warning' : 'label-success'; ?>"><?php echo ucfirst($log->status); ?></span></td>
                        <td><b><?php echo date("d M, Y", strtotime($log->create_date)) . ' at ' . date("g:i a", strtotime($log->create_date)); ?></b></td>
                        <td><button class="btn btn-info" <?php echo $log->status == 'unpaid' ? '' : 'disabled'; ?>><?php echo $log->status == 'unpaid' ? 'Pagar agora' : 'Pago'; ?></button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="pagination"><?php echo $this->pagination->create_links();   ?></div>
    <?php } else { ?>
        <h4 class="alert alert-info text-center">Não há faturas disponíveis.</h4>
    <?php } ?>

</div>
