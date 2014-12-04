<div class="page-header">
    <h1>Detalhes de balanço
    </h1>
</div>


<ul class="breadcrumb">
    <li class="active"><a href="<?php echo base_url(); ?>admin/balance"><i class="glyphicon glyphicon-usd"></i> Log de balanço</a></li>
    <li class="active"><i class="glyphicon glyphicon-file"></i> Detalhes de balanço</li>
</ul>


<?php if (!empty($balance)) { ?>

    <div class="col-md-12">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead class="tableHead">
                <tr>
                    <th width="150px">Detalhes de balanço</th>
                    <th width="150px" class="text-center">Taxa %</th>
                    <th width="200px" class="text-center">Taxa quantidade</th>
                    <th>Detalhes</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>ID de pagamento - <?php echo $milestone->id; ?></b></td>
                    <td class="text-center text-large"><span class="label label-primary">$<?php echo $balance->fee_percent; ?></span></td>
                    <td class="text-center text-large"><span class="label label-success">$<?php echo $balance->amount; ?></span></td>
                    <td>
                        Um pagamento de <b><a target="_blank"
                                             href="<?php echo base_url() ?>user/view/<?php echo $milestone->from_name; ?>"><?php echo $milestone->from_name; ?></a></b>
                        para <b><a target="_blank"
                                 href="<?php echo base_url() ?>user/view/<?php echo $milestone->to_name ?>"><?php echo $milestone->to_name ?></a></b>

                        de <b>$<?php echo $milestone->amount; ?></b> <?php echo $milestone->status; ?> by <b><a
                                target="_blank"
                                href="<?php echo base_url() ?>user/view/<?php echo $milestone->initiated_name; ?>"><?php echo $milestone->initiated_name; ?></a></b>

                        sobre o produto <b><a
                                href="<?php echo base_url() ?>product/view/<?php echo $milestone->product_name_id ?>"><?php echo $milestone->product_name ?></a></b>

                        <br>
                        <br>
                        <p class="text-right normalAsh noMargin text-small"><?php echo date("d M, Y", strtotime($milestone->create_date)) . ' at ' . date("g:i a", strtotime($milestone->create_date)); ?></p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <table class="table noBorder table-striped">
                <colgroup>
                    <col class="col-xs-4">
                    <col class="col-xs-6">
                </colgroup>
                <thead class="tableHead">
                <tr>
                    <th>Detalhes do usuário</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>Nome completo</b></td>
                    <td><?php echo $user->first_name." ".$user->last_name; ?></td>
                </tr>
                <tr>
                    <td><b>Usuário</b></td>
                    <td><a target="_blank" href="<?php echo base_url(); ?>user/view/<?php echo $user->user_name;?>"><?php echo $user->user_name;?></a></td>
                </tr>
                <tr>
                    <td><b>E-mail</b></td>
                    <td><?php echo $user->email;?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-striped noBorder">
                <colgroup>
                    <col class="col-xs-4">
                    <col class="col-xs-6">
                </colgroup>
                <thead class="tableHead">
                <tr>
                    <th>Detalhes do produto</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>Nome do produto</b></td>
                    <td>
                        <a href="<?php echo base_url() ?>product/view/<?php echo $product->product_id ?>"><?php echo $product->name ?></a>
                    </td>
                </tr>
                <tr>
                    <td><b>Orçamento</b></td>
                    <td>
                        <b>$<?php echo $product->fixed_budget; ?></b>
                    </td>
                </tr>
                <tr>
                    <td><b>Data</b></td>
                    <td>
                        <?php echo date("d M, Y", strtotime($product->create_date)) . ' at ' . date("g:i a", strtotime($product->create_date)); ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Descrição</b></td>
                    <td>
                        <p class="text-small_custom lessDescription">
                            <?php
                            if (strlen($product->description) > 100) {
                                echo substr($product->description, 0, 100) . ' ... ... ... <a class="expand text-info pointer pull-right"><b>(mais)</b></a>';
                            } else {
                                echo $product->description;
                            }
                            ?>
                        </p>

                        <p style="display: none" class="text-small_custom fullDescription">
                            <?php echo nl2br($product->description) . '<br><a class="defeat text-info pointer pull-right"><b>(menos)</b></a>' ?>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <h4 class="alert alert-danger">Detalhes indisponíveis!</h4>
<?php } ?>


<script type="text/javascript">

    $('.expand').click(function () {
        $(this).parent('.lessDescription').hide();
        $(this).parent('.lessDescription').next('.fullDescription').show();
    });

    $('.defeat').click(function () {
        $(this).parent('.fullDescription').hide();
        $(this).parent('.fullDescription').prev('.lessDescription').show();
    });
</script>


