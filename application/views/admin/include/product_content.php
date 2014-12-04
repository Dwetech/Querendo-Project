<div class="page-header">
    <h1>Produtos
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="fa fa-cubes"></i> Produtos</li>
</ul>

<div class="searchOption">
    <form method="post" action="" role="form" class="form-horizontal">
        <div class="col-md-2 noPadding">
            <select class="form-control" id="" name="category">
                <option value="">Todos</option>
                <?php foreach($category as $cat){ ?>
                    <option value="<?php echo $cat->cat_id; ?>" <?php echo $cat->cat_id==$category_id  ? "selected" : ""; ?>><?php echo $cat->cat_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-7 noPadding">
            <div class="col-md-6">
                    <div class="col-sm-9">
                        <input type="text" placeholder="Buscar produto" class="form-control"
                               name="searchData" value="<?php echo $searchData; ?>">
                    </div>
                    <div class="col-sm-3 noPadding">
                        <button class="btn btn-success pull-right" value="Submit" name="submit" type="submit">Buscar
                        </button>
                    </div>
            </div>
        </div>
    </form>
</div>

<div class="dashboard-activity-data">
    <ul id="userTab" class="nav nav-tabs">
        <li class="active"><a href="#sell" data-toggle="tab">Lista de produtos </a></li>
        <li class=""><a class="text-danger" href="#buy" data-toggle="tab">Lixeira</a></li>
    </ul>

    <div class="activity-table noBorder">
        <div id="userTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="sell">
                <?php $this->load->view('admin/include/restored_product_content') ?>
            </div>
            <div class="tab-pane fade" id="buy">
                <?php $this->load->view('admin/include/trash_product_content') ?>
            </div>
        </div>
    </div>
</div>









