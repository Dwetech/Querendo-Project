<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>


<?php echo $this->session->flashdata('success') ? '<h3 class="alert alert-success text-center">'.$this->session->flashdata('success').'</h3>' : ''; ?>

<div class="finance_content">

    <div class="page-header">
        <h1>Withdrawal Request Method</h1>
    </div>
    <table class="table table-striped noBorder">
        <thead class="tableHead">
        <th width="200px">Method</th>
        <th>Description</th>
        <th width="200px" class="text-center">Fee</th>
        </thead>
        <tbody>
        <tr>
            <td><a href="<?php echo base_url(); ?>finance/paypal"><b>Paypal</b></a></td>
            <td>Withdraw funds to your Paypal account.</td>
            <td class="text-center">No Fee</td>
        </tr>
        <tr>
            <td><a href="<?php echo base_url(); ?>finance/wire_transfer"><b>Wire Transfer</b></a></td>
            <td>Withdraw funds directly to your bank account. For countries where  Express Withdrawal is unavailable.</td>
            <td class="text-center">No Fee</td>
        </tr>
        </tbody>
    </table>

</div>

<div class="finance_content">
    <div class="page-header">
        <h3>Withdrawal Request </h3>
    </div>

    <?php if(!empty($withdraw)){ ?>
    <table class="table table-striped noBorder">
        <thead class="tableHead">
        <th>Requested at</th>
        <th>Amount</th>
        <th width="400px">Details</th>
        <th class="text-center">Status</th>
        <th class="text-center">Processing Date</th>
        </thead>
        <tbody>
        <?php foreach($withdraw as $w){


        $w->status == 'pending' ? $classCss = 'info' : '';
        $w->status == 'success' ? $classCss = 'success' : '';
        $w->status == 'hold' ? $classCss = 'danger' : '';
        $w->status == 'cancel' ? $classCss = 'default' : '';
        ?>
            <tr>
                <td><span class="label label-info"><?php echo $w->method ?></span></td>
                <td><b>$<?php echo $w->amount ?></b></td>
                <td><?php echo $w->details ?></td>
                <td class="text-center"><span class="label label-<?php echo $classCss ?>"><?php echo $w->status ?></span></td>
                <td class="text-center"><?php echo date("d M, Y", strtotime($w->create_date)) . ' at ' . date("g:i a", strtotime($w->create_date)); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else {
        echo '<h4 class="alert alert-info text-center">There is no withdrawal request</h4>';
    } ?>

</div>



