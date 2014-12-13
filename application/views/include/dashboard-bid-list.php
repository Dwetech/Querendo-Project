<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/4/14
 * Time: 7:40 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="dashboard-activity">
    <div class="dashboard-activity-data">

        <div class="noBorder">
            <table class="table table-striped noBorder">
                <thead>
                <tr class="tableHead">
                    <th>Nome do produto</th>
                    <th class="text-center">Total Bid</th>
                    <th class="text-center">Average Bid</th>
                    <th class="text-center">Highest Bid</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($bids)) {
                    foreach ($bids as $bid) {
                        ?>
                        <tr>
                            <td><a href="<?php echo base_url() . 'product/view/' . $bid->product_id; ?>"><?php echo $bid->name; ?></a></td>
                            <td class="text-center"><?php
                                $product_count = Bids_model::count_bid_by_product($bid->product_id);
                                echo $product_count->count_product;
                                ?></td>
                            <td class="text-center"><?php
                                $average_bid = Bids_model::average_bid_by_product($bid->product_id);
                                echo number_format((float)intval($average_bid->avg_bid), 2, '.', '');
                                ?></td>
                            <td class="text-center"><?php
                                $highest_bid = Bids_model::highetst_bid_by_product($bid->product_id);
                                echo number_format((float)$highest_bid->max_bid, 2, '.', '');
                                ?></td>
                            <td class="text-center"><?php echo $bid->product_create_date; ?></td>
                            <td class="text-center">
                                <div class="label label-success"><?php echo $bid->status; ?></div>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td style="text-align: center" colspan="6"> No Data </td>
                    </tr>
                <?php
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>