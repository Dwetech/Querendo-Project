<?php
/**
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
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
                                <li><a href="<?php echo base_url() . 'product/create'; ?>">Quero comprar</a></li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle mainLink" href="<?php echo base_url() ?>product/category">Quero vender</a>
                                    <ul class="browseMenu dropdown-menu" role="menu">

                                        <?php
                                        $CI = get_instance();
                                        $CI->load->model("category_model");
                                        $categories = $CI->category_model->get2LevelCategories();
                                        if(!empty($categories)){
                                            foreach( $categories as $category ) {
                                                ?>
                                                <li class="browseMenuList" data-submenu-id="submenu-menu<?=$category['cat_id']?>">
                                                    <a class="subList" href="#"><span class="customLeft"><?php echo $category['cat_name'] ?></span><i class="glyphicon glyphicon-chevron-right pull-right"></i></a>
                                                    <div id="submenu-menu<?=$category['cat_id']?>" class="popover browseSubMenuDiv">
                                                        <h3 class="popover-title"><?php echo $category['cat_name'] ?></h3>
                                                        <ul class="browseSubMenu">
                                                            <?php

                                                            if( isset($category['child']) ){
                                                                foreach( $category['child'] as $childs ) {
                                                                    echo '<li><a href="'.base_url('product/categories/'.$childs['url']).'" class="lastSub">'.$childs['cat_name'].'</a></li>';
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
                                            <button class="btn btn-default" type="submit" name="submit" value="Submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </span>
                                        </div>
                                    </form>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="user-menu">
                    <ul>
                        <li class="<?php echo $current=='dashboard' ? 'current' : ''; ?>"><a href="<?php echo base_url() . 'user/dashboard/' . $_SESSION['user_name']; ?>">Dashboard</a></li>
                        <li class="<?php echo $current=='myProduct' ? 'current' : ''; ?>"><a href="<?php echo base_url() . 'user/product/' ?>">Produtos</a></li>
                        <li class="<?php echo $current=='bidList' ? 'current' : ''; ?>"><a href="<?php echo base_url() . 'user/bids/' ?>">Ofertas</a></li>
                        <!--                        <li class="<?php //echo $current=='finance' ? 'current' : ''; ?>">
                            <a href="<?php //echo base_url(); ?>finance">Finance</a>
                            <ul style="display: none" class="user-menu_drop">
                                <li><a href="<?php //echo base_url(); ?>finance/deposit"><i class="glyphicon glyphicon-plus-sign mar-right-small"></i> Deposit Fund </a></li>
                                <li><a href="<?php //echo base_url(); ?>finance/withdraw"><i class="glyphicon glyphicon-minus-sign mar-right-small"></i> Withdraw</a></li>
                            </ul>
                        </li>-->
                        <li class="<?php echo $current=='profile' ? 'current' : ''; ?>"><a href="<?php echo base_url() . 'user/view/' . $_SESSION['user_name']; ?>">Perfil</a></li>
                        <li class="<?php echo $current=='inbox' ? 'current' : ''; ?>"><a href="<?php echo base_url(); ?>messages">Mensagens</a></li>
                        <li class="<?php echo $current=='invoice' ? 'current' : ''; ?>"><a href="<?php echo base_url(); ?>invoice">Faturas</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    $('.user-menu li').mouseenter(function(){
        $(this).find('.user-menu_drop').stop().show();
    });
    $('.user-menu_drop').mouseenter(function(){
        $(this).find('.user-menu_drop').stop().show();
    });
    $('.user-menu li').mouseleave(function(){
        $(this).find('.user-menu_drop').stop().hide();
    });
    $('.user-menu_drop').mouseleave(function(){
        $(this).find('.user-menu_drop').stop().hide();
    });
</script>