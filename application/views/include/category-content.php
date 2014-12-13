<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="category-content">
    <div class="page-header">
        <h1>Encontre aqui os compradores</h1>
    </div>

    <div class="categoryList">

        <?php
        if (!empty($product_category)) {

            foreach ($product_category as $parentCategory) {
                ?>
                <div class="col-md-4 ami">
                    <h4><?php echo $parentCategory['cat_name']; ?></h4>

                    <?php
                    if (isset($parentCategory['child'])) {


                        foreach ($parentCategory['child'] as $childCategory) {


                            $count = Product_model::count_all_cat_pro($childCategory['url'])->product_count; //Counting products


                            $productCount = $this->product_model->getNumberOfProduct($childCategory['cat_id']);
                            ?>
                            <a href="<?php echo base_url(); ?>product/categories/<?php echo $childCategory['url'] ?>"><i
                                    class="iconCat glyphicon glyphicon-play mar-right-small"></i> <?php echo $childCategory['cat_name'] ?>
                                (<?php echo $count; ?>)</a>
                        <?php
                        }
                    }
                    ?>


                </div>

            <?php
            }
        }
        ?>

    </div>

</div>