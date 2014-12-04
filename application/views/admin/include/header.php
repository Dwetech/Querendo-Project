<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Querendo</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="<?php echo $page=='dashboard' ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin"><i class="glyphicon glyphicon-dashboard small-margin"></i> Dashboard</a></li>
            <li class="<?php echo $page=='balance' ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/balance"><i class="glyphicon glyphicon-usd small-margin"></i> Balanço</a></li>
            <li class="<?php echo $page=='user' ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user"><i class="glyphicon glyphicon-user small-margin"></i> Usuários</a></li>
            <li class="<?php echo $page=='product' ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/product"><i class="glyphicon glyphicon-gift small-margin"></i> Produtos</a></li>
            <li class="<?php echo $page=='category' ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/category"><i class="glyphicon glyphicon-list small-margin"></i> Categorias</a></li>
            <li class="<?php echo $page=='withdraw' ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/withdraw"><i class="glyphicon glyphicon-export small-margin"></i> Saques</a></li>
            <li class="<?php echo $page=='webSettings' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/website_settings"><i class="glyphicon glyphicon-cog small-margin"></i> Opções do site</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right navbar-user">

            <li class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['admin_email'] ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url() ?>admin/settings"><i class="fa fa-gear"></i> Opções</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url() ?>admin/logout"><i class="fa fa-power-off"></i> Sair</a></li>
                </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>