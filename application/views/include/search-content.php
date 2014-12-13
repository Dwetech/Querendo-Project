<div class="col-md-12">

    <div class="page-header">
        <h3>
            Result for " <?php echo $search ?> "
        </h3>
    </div>

    <?php if (!empty($product) || !empty($user)) { ?>

        <div class="awarded-activity">
            <div class="awarded-activity-data">
                <ul class="nav nav-tabs" id="userTab">
                    <li class="<?php echo !empty($product) ? 'active' : ''; ?>"><a data-toggle="tab" href="#product">Product</a>
                    </li>
                    <li class="<?php echo empty($product) && !empty($user) ? 'active' : ''; ?>"><a data-toggle="tab"
                                                                                                   href="#user">User</a>
                    </li>
                </ul>

                <div class="search-table">
                    <div class="tab-content" id="userTabContent">
                        <div id="product" class="tab-pane <?php echo !empty($product) ? 'active' : 'fade'; ?>">
                            <?php if (!empty($product)) { ?>
                                <table class="table table-striped">
                                    <thead>
                                    <tr class="tableHead">
                                        <td>Product Name</td>
                                        <td>Descriotion</td>
                                        <td class="text-center">Bids</td>
                                        <td class="text-center">Started</td>
                                        <td class="text-center">Budget</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($product as $p) { ?>
                                        <tr>
                                            <td width="200px"><a
                                                    href="<?php echo base_url(); ?>product/view/<?php echo $p->product_id; ?>"><?php echo $p->name; ?></a>
                                            </td>
                                            <td class="text-small-custom">
                                                <p class="text-small_custom lessDescription">
                                                    <?php
                                                    if (strlen($p->description) > 100) {
                                                        echo substr($p->description, 0, 100) . ' ... ... ... <a class="expand text-info pointer"><b>(more)</b></a>';
                                                    } else {
                                                        echo $p->description;
                                                    }
                                                    ?>
                                                </p>

                                                <p style="display: none" class="text-small_custom fullDescription">
                                                    <?php echo nl2br($p->description) . '<br><a class="defeat text-info pointer"><b>(less)</b></a>'; ?>
                                                </p>
                                            </td>
                                            <td width="100px" class="text-center">
                                                <?php if ($this->product_model->userBidExist($_SESSION['user_id'], $p->product_id)) { ?>
                                                    <span class="bidOk label label-success" data-placement="left"
                                                          title="Already Bid by you" data-toggle="tooltip">
                                                            <i class="glyphicon glyphicon-ok-sign"></i> Bid
                                                    </span>
                                                <?php
                                                } else {
                                                    echo $this->product_model->bidCount($p->product_id); ?>
                                                <?php } ?>
                                            </td>
                                            <td width="150px" class="text-center"><?php echo $p->create_date; ?></td>
                                            <td width="150px" class="text-center">
                                                <?php if($p->budget_type == 'fixed'){ ?>
                                                <b><?php echo "$" . number_format((float)$p->fixed_budget, 2, '.', ''); ?></b></td>
                                            <?php } else { ?>
                                                <b><?php echo "$" . number_format((float)$p->min_budget, 2, '.', '') . " - $" . number_format((float)$p->max_budget, 2, '.', ''); ?></b></td>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>

                        <div id="user"
                             class="tab-pane <?php echo empty($product) && !empty($user) ? 'active' : 'fade'; ?>">
                            <div class="sellersList">
                                <?php
                                if (!empty($user)) {
                                    foreach ($user as $r) {
                                        $countryCode = $this->user_model->getCountryCode($r->country);

                                        ?>
                                        <div class="sellersDetails">
                                            <div class="col-md-2 noPadding">
                                                <div class="profile-picture">
                                                    <img class="imgAuto"
                                                         src="<?php echo empty($r->profile_pic) ? base_url() . 'resources/img/blank.png' : base_url() . 'upload/profile_photo/' . $r->profile_pic; ?>"
                                                         alt="#"/>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="sellerName">
                                                    <a href="<?php echo base_url(); ?>user/view/<?php echo $r->user_name ?>"><?php echo $r->user_name ?>
                                                        <span
                                                            class="sellerMap flag flag-<?php echo !empty($countryCode->iso_code_2) ? strtolower($countryCode->iso_code_2) : ''; ?>"></span></a>
                                                </div>
                                                <div class="sellerName">
                                                    <p class="descriptionDataSellers">
                                                        <?php echo $r->about ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>

<script type="text/javascript">

    $('.bidOk').tooltip();

    $('.expand').click(function () {
        $(this).parent('.lessDescription').hide();
        $(this).parent('.lessDescription').next('.fullDescription').show();
    });

    $('.defeat').click(function () {
        $(this).parent('.fullDescription').hide();
        $(this).parent('.fullDescription').prev('.lessDescription').show();
    });
</script>