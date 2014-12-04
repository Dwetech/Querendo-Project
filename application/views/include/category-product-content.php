<div class="category-content">
    <div class="page-header">
        <h1>
            <span><?php echo $category->cat_name; ?></span>
            <a class="pull-right btn btn-primary" href="<?php echo base_url() ?>product/create/<?php echo $category->cat_id ?>"><b>Adicionar produto</b></a></h1>
    </div>

    <?php
    if (!empty($all_cat_pro)) {
        ?>

        <table class="table table-striped noBorder">
            <thead>
                <tr class="tableHead">
                    <td>Nome do produto</td>
                    <td>Descrição</td>
                    <td class="text-center">Ofertas</td>
                    <td class="text-center">Iniciado</td>
                    <td class="text-center">Orçamento</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($all_cat_pro as $p) {
                    ?>
                    <tr>
                        <td width="200px"><a
                                href="<?php echo base_url(); ?>product/view/<?php echo $p->product_id; ?>"><?php echo $p->name; ?></a>
                        </td>
                        <td class="text-small-custom">
                            <p class="text-small_custom lessDescription">
                                <?php
                                if (strlen($p->description) > 100) {
                                    echo substr($p->description, 0, 100) . ' ... ... ... <a class="expand text-info pointer"><b>(mais)</b></a>';
                                } else {
                                    echo $p->description;
                                }
                                ?>
                            </p>

                            <p style="display: none" class="text-small_custom fullDescription">
                                <?php echo nl2br($p->description) . '<br><a class="defeat text-info pointer"><b>(menos)</b></a>' ?>
                            </p>

                        </td>
                        <td width="100px" class="text-center">

                            <?php
                            if (isset($_SESSION['user_id'])) {

                                if ($this->product_model->userBidExist($_SESSION['user_id'], $p->product_id)) {
                                    ?>

                                    <span class="bidOk label label-success" data-placement="left" title="Você já ofertou neste produto"
                                          data-toggle="tooltip">
                                        <i
                                            class="glyphicon glyphicon-ok-sign"></i> Ofertar
                                    </span>
                                    <?php
                                } else if ($this->product_model->userProductExist($_SESSION['user_id'], $p->product_id)) {
                                    ?>

                                    <span class="bidOk label label-primary" data-placement="left" title="Você já ofertou neste produto"
                                          data-toggle="tooltip">
                                        <i
                                            class="glyphicon glyphicon-ok-sign"></i> Dono
                                    </span>
                                    <?php
                                } else {
                                    echo $this->product_model->bidCount($p->product_id);
                                }
                            } else {
                                echo $this->product_model->bidCount($p->product_id);
                                ?>
                            <?php } ?>
                        </td>
                        <td width="150px" class="text-center"><?php echo $p->create_date; ?></td>
                        <td width="150px" class="text-center">
                            <?php if ($p->budget_type == 'fixed') { ?>
                                <b><?php echo "R$ " . $p->fixed_budget; ?></b></td>
                        <?php } else { ?>
                    <b><?php echo "R$ " . $p->min_budget . " - $" . $p->max_budget; ?></b></td>
                <?php } ?>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <?php
    } else {
        ?>
        <p class="alert alert-info text-center">
            There is no product in this category.
        </p>
        <p class="text-center">
            <a class="btn btn-warning" href="<?php base_url(); ?>product/category">Go Back</a>
        </p>
    <?php }
    ?>
</div>


<script type="text/javascript">

    $('.bidOk').tooltip();

    $('.expand').click(function() {
        $(this).parent('.lessDescription').hide();
        $(this).parent('.lessDescription').next('.fullDescription').show();
    });

    $('.defeat').click(function() {
        $(this).parent('.fullDescription').hide();
        $(this).parent('.fullDescription').prev('.lessDescription').show();
    });
</script>