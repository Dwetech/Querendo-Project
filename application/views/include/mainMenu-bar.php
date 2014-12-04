<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>

<section class="mainMenu-bar">
    <div class="container">
        <div class="mainMenu-bar-section">
            <div class="col-md-10 col-md-offset-1">


                <div class="topMenu">

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="mainMenu">
                                <li><a href="<?php echo base_url(); ?>product/create">Quero comprar</a></li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle mainLink" data-toggle="dropdown"
                                       href="<?php echo base_url() ?>product/category">Quero vender</a>
                                    <ul class="browseMenu dropdown-menu" role="menu">

                                        <?php
                                        $CI = get_instance();
                                        $CI->load->model("category_model");
                                        $categories = $CI->category_model->get2LevelCategories();
                                        if (!empty($categories)) {
                                            foreach ($categories as $category) {
                                                ?>
                                                <li class="browseMenuList"
                                                    data-submenu-id="submenu-menu<?= $category['cat_id'] ?>">
                                                    <a class="subList" href="#"><span
                                                            class="customLeft"><?php echo $category['cat_name'] ?></span><i
                                                            class="glyphicon glyphicon-chevron-right pull-right"></i></a>

                                                    <div id="submenu-menu<?= $category['cat_id'] ?>"
                                                         class="popover browseSubMenuDiv">
                                                        <h3 class="popover-title"><?php echo $category['cat_name'] ?></h3>
                                                        <ul class="browseSubMenu">
                                                            <?php

                                                            if (isset($category['child'])) {
                                                                foreach ($category['child'] as $childs) {
                                                                    echo '<li><a href="' . base_url('product/categories/' . $childs['url']) . '" class="lastSub">' . $childs['cat_name'] . '</a></li>';
                                                                }
                                                            }

                                                            ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php
                                            }
                                        }

                                        ?>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url() ?>sellers">Buscar vendedor</a></li>
                                <li><a href="#">Ajuda</a></li>
                                <div class="searchInput">
                                    <form class="" action="<?php echo base_url(); ?>search" method="post">
                                        <div class="input-group">
                                            <input name="search" type="text" class="form-control">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit" name="submit" value="Submit">
                                                <i class="glyphicon glyphicon-search"></i></button>
                                        </span>
                                        </div>
                                    </form>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

