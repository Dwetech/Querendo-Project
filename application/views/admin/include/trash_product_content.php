<?php if(!empty($trashProduct)){ ?>
<table class="table table-striped noBorder">
    <thead>
    <tr class="tableHead">
        <td width="200px">Nome do produto</td>
        <td width="100px">Categoria</td>
        <td>Descrição</td>
        <td width="150px" class="text-center">Orçamento (min)</td>
        <td width="150px" class="text-center">Orçamento (max)</td>
        <td></td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($trashProduct as $r){ ?>
        <tr>
            <td><a target="_blank" href="<?php echo base_url().'product/view/'.$r->product_id ?>"><?php echo $r->name ?></a></td>
            <td><?php echo $r->cat_name ?></td>
            <td><?php echo substr($r->description, 0, 100); ?></td>
            <td class="text-center" width="150px"><?php echo $r->min_budget ?></td>
            <td class="text-center" width="150px"><?php echo $r->max_budget ?></td>
            <td class="text-center" width="100px"><a class="text-success" onclick="return confirm('Tem certeza que deseja restaurar este produto?')"  href="<?php echo base_url(); ?>admin/product/restore/<?php echo $r->product_id; ?>"><i class="fa fa-plus-circle"></i> Restore</a></td>
            <?php if($r->status != 'awarded'){ ?>
            <td class="text-center" width="100px"><a class="text-danger" onclick="return confirm('Tem certeza que deseja remover este produto?')"  href="<?php echo base_url(); ?>admin/product/confirm_remove/<?php echo $r->product_id; ?>"><i class="fa fa-minus-circle"></i> Remove</a></td>
            <?php } ?>
            </tr>
    <?php } ?>
    </tbody>
</table>
<?php } else { ?>
    <p class="alert alert-info text-center">Não há produtos na lixeira</p>
<?php } ?>


