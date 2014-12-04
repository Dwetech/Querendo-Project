<div class="category_sidebar">
    <div class="categorySidebarList">
        <p>Categorias</p>
        <?php if (!empty($categoryParent)) {
            if ($categoryParent->level != 1) {
                ?>
                <a class="parentCategory"
                   href="<?php echo base_url() . 'product/categories/' . $categoryParent->url ?>"><i class="fa fa-angle-left"></i> 
                       <?php echo $categoryParent->cat_name ?></a>
            <?php }
        } ?>
        <ul>
            <?php
            if (!empty($childCategories)) {
                foreach ($childCategories as $childCategory) {
                    ?>
                    <li>
                        <?php
                        $count = Product_model::count_all_cat_pro($childCategory->cat_name)->product_count;
                        ?>
                        <a href="<?= base_url('product/categories/' . $childCategory->url) ?>"><?=$childCategory->cat_name . ' (' . $count . ')'; ?></a>
                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
</div>