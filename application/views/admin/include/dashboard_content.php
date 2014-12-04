<div class="page-header">
    <h1>Dashboard
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</li>
</ul>

<?php if (!empty($withdraw)) { ?>
    <div class="page-header">
        <h3>Pending Withdraw Request
        </h3>
    </div>
    <table class="table table-striped noBorder">
        <thead>
        <tr class="tableHead">
            <th width="120px">Requested at</th>
            <th width="">Details</th>
            <th width="100px" class="text-center">Amount</th>
            <th width="100px" class="text-center">Status</th>
            <th width="200px" class="text-center">Processing Date</th>
            <th width="120px" class="text-center">Action</th>
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
                <td class="text-center"><span
                        class="label label-<?php echo $classCss ?>"><?php echo $w->status ?></span></td>
                <td class="text-center"><?php echo date("d M, Y", strtotime($w->create_date)) . ' at ' . date("g:i a", strtotime($w->create_date)); ?></td>
                <td class="text-center">
                    <?php if ($w->status != 'cancel' && $w->status != 'success') { ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu custom_action" role="menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/pending/<?php echo $w->withdraw_id; ?>">Pending</a>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/success/<?php echo $w->withdraw_id; ?>">Success</a>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/hold/<?php echo $w->withdraw_id; ?>">Hold</a>
                                    <a href="<?php echo base_url(); ?>admin/withdraw/change_status/cancel/<?php echo $w->withdraw_id; ?>">Cancel</a>
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
}  ?>
