<div class="page-header">
    <h1>Categorias
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="fa fa-cubes"></i> Categorias</li>
</ul>

<ul class="breadcrumb">
    <li class="active">
        <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/category/add"><i class="fa fa-plus"></i> Adicionar nova categoria</a>
    </li>
</ul>

<?php
echo $this->session->flashdata('success') ? '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>' : '';


if (!empty($category)) {
    ?>
    <table class="table table-striped noBorder">
        <thead>
            <tr class="tableHead">
                <td>Pai</td>
                <td>Nome</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($category as $r) {
                $parent_category = Category_model::getSingleCategory($r->parent_id);
                ?>
                <tr>
                    <td><?php echo !empty($parent_category) ? $parent_category->cat_name : 'Parent'; ?></td>
                    <td><?php echo $r->cat_name ?></td>
                    <td class="text-center" ><a href="<?php echo base_url(); ?>admin/category/edit/<?php echo $r->cat_id ?>"><i class="fa fa-edit"></i> Editar</a></td>
                    <td class="text-center" >
                        <a class="text-danger" onclick="return confirm('Tem certeza que deseja remover esta categoria ?')"  
                           href="<?php echo base_url(); ?>admin/category/remove/<?php echo $r->cat_id; ?>"><i class="fa fa-minus-circle"></i> Remover</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
    <?php
} else {
    ?>
    <p class="alert alert-info text-center">Não há categorias</p>
    <?php
}
?>