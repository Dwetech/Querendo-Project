<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/4/14
 * Time: 11:33 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<section class="product-create">
    <div class="container">
        <div class="product-create-section">
            <form action="<?php echo base_url() . 'product/edit/' . $this->uri->segment('3'); ?>" role="form" method="post" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-md-8 col-md-offset-2">
                        <div class="modal_hr">
                            <div class="inner">O que você está querendo?</div>
                        </div>
                    </div>

                    <div class="col-md-10 col-md-offset-1">
                        <div class="product-create-content">

                            <?php echo isset($error) ? "<div class='alert alert-danger'>" . $error . "</div>" : ''; ?>
                            <div class="col-md-5">


                                <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
                                    <label for="name">Nome do produto: <span class="glyphicon glyphicon-info-sign info_data" data-toggle="tooltip" data-placement="right" title="" 
                                                                           data-original-title="Entre com o nome do produto desejado"></span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $product->name ? $product->name : set_value('name'); ?>"
                                           placeholder="Nome do produto">
                                           <?php echo form_error('name') ? '<span class="text-danger">' . form_error('name') . '</span>' : '' ?>
                                </div>
                                <div class="form-group <?php echo form_error('category') ? 'has-error' : '' ?>">
                                    <label for="category">Categoria do produto: <span class="glyphicon glyphicon-info-sign info_data" data-toggle="tooltip" data-placement="right" title="" 
                                                                                   data-original-title="Selecione uma categoria que descreva o produto desejado"></span></label>
                                    <select class="form-control" name="category" id="category">
                                        <?php
                                            echo $select;
                                            ?>
                                                <?php echo form_error('category') ? '<span class="text-danger">' . form_error('category') . '</span>' : '' ?>
                                    </select>
                                </div>
                                <div class="form-group <?php echo form_error('shipping_method') ? 'has-error' : '' ?>">
                                    <label for="shipping_method">Método de envio: <span class="glyphicon glyphicon-info-sign info_data" data-toggle="tooltip" data-placement="right" title="" 
                                                                                         data-original-title="Selecione o método de envio"></span></label>
                                    <input type="text" class="form-control" id="shipping_method" name="shipping_method" value="<?php echo $product->shipping_method ? $product->shipping_method : set_value('shipping_method'); ?>"
                                           placeholder="Método de envio" readonly>
                                           <?php echo form_error('shipping_method') ? '<span class="text-danger">' . form_error('shipping_method') . '</span>' : '' ?>
                                </div>
                                <div class="hidden form-group <?php echo form_error('shipping_cost') ? 'has-error' : '' ?>">
                                    <label for="shipping_cost">Custo de envio: <span class="glyphicon glyphicon-info-sign info_data" data-toggle="tooltip" data-placement="right" title="" 
                                                                                     data-original-title="Insira o preço do envio"></span></label>
                                    <input type="text" class="form-control" id="shipping_cost" name="shipping_cost" value="<?php echo $product->shipping_cost ? $product->shipping_cost : set_value('shipping_cost'); ?>"
                                           placeholder="Custo de envio">
                                           <?php echo form_error('shipping_cost') ? '<span class="text-danger">' . form_error('shipping_cost') . '</span>' : '' ?>
                                </div>
                                <div class="form-group <?php echo form_error('product_condition') ? 'has-error' : '' ?>">
                                    <label for="product_condition">Condição do produto: <span class="glyphicon glyphicon-info-sign info_data" data-toggle="tooltip" data-placement="right" title="" 
                                                                                             data-original-title="Selecione a condição do produto desejado"></span></label>
                                    <select class="form-control" name="product_condition" id="category">
                                        <option value="">----Seleciona a condição do produto----</option>
                                        <option value="New"
                                        <?php echo $product->product_condition == 'New' ? 'selected="selected"' : ''; ?>
                                                <?php echo set_select('product_condition', 'New'); ?>>Novo</option>
                                        <option value="Used"
                                        <?php echo $product->product_condition == 'Used' ? 'selected="selected"' : ''; ?>
                                                <?php echo set_select('product_condition', 'Used'); ?>>Usado</option>
                                        <option value="Any"
                                        <?php echo $product->product_condition == 'Any' ? 'selected="selected"' : ''; ?>
                                                <?php echo set_select('product_condition', 'Any'); ?>>Qualquer</option>
                                                <?php echo form_error('product_condition') ? '<span class="text-danger">' . form_error('product_condition') . '</span>' : '' ?>
                                    </select>
                                </div>


                            </div>
                            <div class="col-md-6 pull-right">
                                <div class="well"></div>
                            </div>


                            <div class="col-md-12">


                                <div class="form-group <?php echo form_error('details') ? 'has-error' : '' ?>">
                                    <label for="details">Escreva uma descrição sobre o produto desejado: <span class="glyphicon glyphicon-info-sign info_data" data-toggle="tooltip" data-placement="right" title="" data-original-title="Escreva uma descrição sobre o produto desejado"></span></label>
                                    <textarea rows="7" name="details" id="details" class="form-control"
                                              placeholder="Escreva uma descrição ... ... ..."><?php echo $product->description ? $product->description : set_value('details'); ?></textarea>
                                              <?php echo form_error('details') ? '<span class="text-danger">' . form_error('details') . '</span>' : '' ?>
                                </div>


                            </div>
                            <div class="col-md-12">
                                <div class="well">
                                    <h3>Adicione uma foto do produto desejado:</h3>
                                    <input type="file" class="btn btn-default" name="userfile">
                                </div>
                            </div>
                            <div class="col-md-5">

                                <div class="form-group  has-feedback">
                                    <label for="budget" class="<?php echo form_error('budget') ? 'text-danger' : '' ?>">
                                        Orçamento :
                                        <span class="glyphicon glyphicon-info-sign info_data"
                                            data-toggle="tooltip" data-placement="right"
                                            title="" data-original-title="Especifique seu orçamento">
                                        </span>
                                    </label>
                                    <input type="text" value="<?php echo $product->fixed_budget; ?>" name="budget" class="form-control bidFeed" id="budget">

                                    <span class="custom-feedback-left text-feedback">R$</span>
                                    <span class="custom-feedback-right text-feedback">Reais</span>
                                    <?php echo form_error('budget') ? '<span class="text-danger">' . form_error('budget') . '</span>' : '' ?>
                                </div>

                                <!--
                                <div id="nonCustom" class="form-group <?php echo form_error('budget') ? 'has-error' : '' ?>">

                                    <label for="budget">Budget : <span class="glyphicon glyphicon-info-sign info_data" data-toggle="tooltip"
                                                                       data-placement="right" title="" data-original-title="Select of specify your custom budget"></span>
                                    </label>
                                    <?php
                                    if (($product->min_budget != '11' && $product->min_budget != '21' && $product->min_budget != '51' && $product->min_budget != '501') && ($product->max_budget != '20' && $product->max_budget != '50' && $product->max_budget != '500' && $product->max_budget != '1000')) {
                                        $selected = 'selected="selected"';
                                        $select_value = true;
                                    } else {
                                        $selected = '';
                                        $select_value = false;
                                    }
                                    ?>
                                    <select class="form-control mar-bottom-small" name="budget" id="budget">

                                        <option value="11-20"
                                        <?php echo ($product->min_budget == '11' && $product->max_budget == '20') ? 'selected="selected"' : ''; ?>
                                                <?php echo set_select('budget', '11-20'); ?>>$11-$20</option>

                                        <option value="21-50"
                                        <?php echo ($product->min_budget == '21' && $product->max_budget == '50') ? 'selected="selected"' : ''; ?>
                                                <?php echo set_select('budget', '21-50'); ?>>$21-$50</option>

                                        <option value="51-500"
                                        <?php echo ($product->min_budget == '51' && $product->max_budget == '500') ? 'selected="selected"' : ''; ?>
                                                <?php echo set_select('budget', '51-500'); ?>>$51-$500</option>

                                        <option value="501-1000"
                                        <?php echo ($product->min_budget == '501' && $product->max_budget == '1000') ? 'selected="selected"' : ''; ?>
                                                <?php echo set_select('budget', '501-1000'); ?>>$501-$1000</option>

                                        <option id="customBudget" value="custom"
                                        <?php echo $selected; ?>
                                                <?php echo set_select('budget', 'custom'); ?>>Customize Budget</option>
                                        
                                    </select>
                                    <?php echo form_error('budget') ? '<span class="text-danger">' . form_error('budget') . '</span>' : '' ?>
                                </div>
                                <div id="minCustom" class="form-group <?php echo form_error('min_budget') ? 'has-error' : '' ?> <?php echo (set_select('budget', 'custom') || ($select_value == true)) ? '' : 'hidden'; ?>">
                                    <label for="budget">Minimum Budget :</label>
                                    <input type="text" class="form-control" id="name" name="min_budget" value="<?php echo $product->min_budget ? $product->min_budget : set_value('min_budget'); ?>"
                                           placeholder="Minimum budget of your product">
                                           <?php echo form_error('min_budget') ? '<span class="text-danger">' . form_error('min_budget') . '</span>' : '' ?>
                                </div>
                                <div id="maxCustom" class="form-group <?php echo form_error('max_budget') ? 'has-error' : '' ?> <?php echo (set_select('budget', 'custom') || (isset($select_value) && $select_value == true)) ? '' : 'hidden'; ?>">
                                    <label for="budget">Maxmum Budget :</label>
                                    <input type="text" class="form-control" id="name" name="max_budget" value="<?php echo $product->max_budget ? $product->max_budget : set_value('max_budget'); ?>"
                                           placeholder="Maximum budget of your product">
                                           <?php echo form_error('max_budget') ? '<span class="text-danger">' . form_error('max_budget') . '</span>' : '' ?>
                                    <a id="goToCustom"></a>
                                </div>


                                -->
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            <div class="form-action">
                                                                <button type="submit" id="submit" name="submit" value="Submit"
                                                                        class="btn btn-primary"><span class="text-bold-custom">Salvar alterações</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </section>


                                <script type="text/javascript">

                                    $('#budget').change(function() {
                                        var value = $(this).find(":selected").attr('id');

                                        if (value == 'customBudget') {
                                            //$('#nonCustom').hide();
                                            $('#minCustom').removeClass('hidden');
                                            $('#maxCustom').removeClass('hidden');
                                        } else {
                                            $('#minCustom').addClass('hidden');
                                            $('#maxCustom').addClass('hidden');
                                        }
                                    });

                                    $('.info_data').tooltip();

                                </script>