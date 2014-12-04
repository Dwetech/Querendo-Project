<div class="col-md-10 col-md-offset-1 noPadding">
    <div class="dashboard-section">
        <div class="page-header">
            <h2>
                Balance Log
            </h2>
        </div>
    </div>

    <?php
    if (!empty($balance)) {
        ?>
        <table class="table table-striped noBorder">

            <thead class="tableHead">
            <th width="80px">Type</th>
            <th width="100px">Amount</th>
            <th width="150px">Total Balance</th>
            <th>Description</th>
            <th width="200px" class="text-center">Date</th>
            </thead>

            <tbody>
            <?php foreach($balance as $log){ ?>
                <tr>
                    <td><span class="label <?php echo $log->type == 'credit' ? 'label-success' : 'label-danger'; ?>"><?php echo $log->type ?></span></td>
                    <td><b>$<?php echo $log->amount ?></b></td>
                    <td><b>$<?php echo $log->currentBalance ?></b></td>
                    <td><?php echo $log->description ?></td>
                    <td class="text-center"><?php echo date("d M, Y", strtotime($log->created)) . ' at ' . date("g:i a", strtotime($log->created)); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
    <?php } else { ?>
        <h4 class="alert alert-info text-center">There is no balance log at all.</h4>
    <?php } ?>

</div>
