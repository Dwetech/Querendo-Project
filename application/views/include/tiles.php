<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */
?>


<section class="tiles">
    <div class="container">
        <div class="tiles-section">
            <div class="tiles-head">
                <h2 class="text-center">Produtos que os usuários estão querendo.</h2>
            </div>
            <div class="tiles-pattern">

                <?php
                if (!empty($products)) {
                    foreach ($products as $product) {
                        if($product->product_status == 'running'){
                            ?>
                            <div class="col-md-3">
                                <div class="tiles-body">
                                    <div class="body-content text-center">
                                        <?php if (!empty($product->product_photo)) { ?>
                                            <img class=""
                                                 src="<?php echo base_url() . 'upload/product_photo/' . $product->product_photo; ?>"
                                                 alt="Querendo Banner Logo"/>
                                        <?php } else { ?>
                                            <img class=""
                                                 src="<?php echo base_url(); ?>resources/img/no_image.gif"
                                                 alt="Querendo Banner Logo"/>
                                        <?php } ?>
                                    </div>
                                    <div class="body-link">
                                        <a href="<?php echo base_url(); ?>product/view/<?php echo $product->product_id ?>"
                                           class="btn btn-warning">Detalhes</a>
                                    </div>
                                </div>
                                <div class="tiles-info">
                                    <h4>
                                        <a href="<?php echo base_url(); ?>product/view/<?php echo $product->product_id ?>"><?php echo $product->name; ?></a>
                                    </h4>

                                    <p>Por <?php echo $product->user_name; ?></p>

                                    <h3 class="price-tag">R$<?php echo number_format((float)$product->fixed_budget, 2, '.', ''); ?></h3>
                                </div>
                            </div>
                        <?php }
                    }
                }
                else{ ?>

                    <h2 class="alert alert-info">Não há produtos disponíveis para dar lance.</h2>

                <?php }
                ?>

            </div>

        </div>
    </div>
</section>