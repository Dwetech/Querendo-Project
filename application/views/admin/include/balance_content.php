<div class="page-header">
    <h1>Log de balanço
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><i class="glyphicon glyphicon-usd"></i> Log de balanço</li>
</ul>

<?php if(!empty($balance)){ ?>
    <table class="table">
        <thead class="tableHead">
        <th>Quantidade</th>
        <th>Data</th>
        <th width="200px"></th>
        </thead>
        <tbody>
        <?php foreach($balance as $r){ ?>
            <tr>
                <td><b>$<?php echo $r->amount; ?></b></td>
                <td><?php echo date("d M, Y", strtotime($r->created)) . ' at ' . date("g:i a", strtotime($r->created)); ?></td>
                <td class="text-center"><a class="btn btn-primary" href="<?php echo base_url() ?>admin/balance/view/<?php echo $r->id; ?>"><i class="glyphicon glyphicon-file"></i> Ver detalhes</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <h4 class="alert alert-info">Não há logs de balanço.</h4>
<?php } ?>

