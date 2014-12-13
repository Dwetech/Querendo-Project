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

        <div class="page-header">
            <h2>Minhas ofertas</h2>
        </div>

        <div class="noBorder">

            <div class="breadcrumb">
                <form class="form-horizontal submit_bid" role="form" action="" method="post">
                    <div class="form-group noMargin">
                        <label for="inputEmail3" class="col-sm-2 control-label">Filtrar :</label>
                        <div class="col-sm-3">
                            <select name="status" class="form-control bid_filters">
                                <option value="All" <?php echo $filter == 'All' ? 'selected' : ''; ?>>Todos</option>
                                <option value="Completed" <?php echo $filter == 'Completed' ? 'selected' : ''; ?>>Completos</option>
                                <option value="Awarded" <?php echo $filter == 'Awarded' ? 'selected' : ''; ?>>Premiados</option>
                                <option value="Regular" <?php echo $filter == 'Regular' ? 'selected' : ''; ?>>Normais</option>
                                <option value="Waiting" <?php echo $filter == 'Waiting' ? 'selected' : ''; ?>>Aguardando</option>
                            </select>
                            <button style="display: none;" id="submit_button" class="btn btn-success" type="submit" name="submit" value="Submit">GO!</button>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table table-striped noBorder">
                <thead>
                <tr class="tableHead">
                    <th>Produto</th>
                    <th class="text-center">Total de lances</th>
                    <th class="text-center">Lance médio</th>
                    <th class="text-center">Maior lance</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Situação</th>
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
                                echo "R$".number_format((float)intval($average_bid->avg_bid), 2, '.', '');
                                ?></td>
                            <td class="text-center"><?php
                                $highest_bid = Bids_model::highetst_bid_by_product($bid->product_id);
                                echo "R$".number_format((float)$highest_bid->max_bid, 2, '.', '');
                                ?></td>
                            <td class="text-center"><?php echo $bid->bid_create_date; ?></td>
                            <td class="text-center">
                                <?php
                                if ($bid->bid_status == 'Completed')
                                    $label = 'label label-success';
                                else if ($bid->bid_status == 'Awarded')
                                    $label = 'label label-primary';
                                else if ($bid->bid_status == 'Waiting')
                                    $label = 'label label-warning';
                                else if ($bid->bid_status == 'Regular')
                                    $label = 'label label-default';
                                ?>
                                <div class="<?php echo $label; ?>"><?php echo $bid->bid_status; ?></div>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td style="text-align: center" colspan="6"> Não há ofertas </td>
                    </tr>
                <?php }
                ?>

                </tbody>
            </table>
            <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        $(".bid_filters").on('change', function() {
            $("#submit_button").click();
        });
    });
</script>