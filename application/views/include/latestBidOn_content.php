<?php if (!empty($bidOn)) { ?>
    <div class="activity-table">
        <table class="table table-striped noBorder">
            <thead>
            <tr class="tableHead">
                <td>Product Name</td>
                <td class="text-center">Started</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bidOn as $r) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url(); ?>product/view/<?php echo $r->product_id; ?>"><?php echo $r->name; ?></a>
                    </td>
                    <td width="150px" class="text-center"><?php echo $r->create_date; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>



