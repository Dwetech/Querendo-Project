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

    <div class="page-header">
        <h2>Meus produtos</h2>
    </div>

    <table class="table table-striped noBorder">
        <thead>
            <tr class="tableHead">
                <th>Nome do produto</th>
                <th class="text-center">Total de ofertas</th>
                <th class="text-center">Maior oferta</th>
                <th class="text-center">Menor oferta</th>
                <th class="text-center">Data</th>
                <th class="text-center">Situação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    ?>
                    <tr>
                        <td><a href="<?php echo base_url() . 'product/view/' . $product->product_id; ?>"><?php echo $product->name; ?></a></td>
                        <td class="text-center"><?php
                            $product_count = Bids_model::count_bid_by_product($product->product_id);
                            echo $product_count->count_product;
                            ?></td>
                        <td class="text-center">R$ <?php
                            $average_bid = Bids_model::average_bid_by_product($product->product_id);
                            echo intval($average_bid->avg_bid);
                            ?></td>
                        <td class="text-center">R$ <?php
                            $lowest_bid = Bids_model::lowest_bid_by_product($product->product_id);
                            echo $lowest_bid->min_bid;
                            ?></td>
                        <td class="text-center"><?php echo $product->product_create_date; ?></td>
                        <td class="text-center">
                            <?php
                            if ($product->status == 'completed')
                                $label = 'label label-success';
                            else if ($product->status == 'awarded')
                                $label = 'label label-primary';
                            else if ($product->status == 'waiting')
                                $label = 'label label-warning';
                            else if ($product->status == 'running')
                                $label = 'label label-default';
                            else if ($product->status == 'cancel')
                                $label = 'label label-danger';
                            else if ($product->status == 'processing')
                                $label = 'label label-info';
                            ?>
                            <span class="<?php echo $label; ?>"><?php echo ucfirst($product->status); ?></span>
                        </td>
                    </tr>
                    <?php
                }
            }else {
                ?>
                <tr>
                    <td style="text-align: center" colspan="6"> Nenhum produto encontrado </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
</div>