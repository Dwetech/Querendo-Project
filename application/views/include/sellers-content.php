<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/3/14
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

?>

<div class="sellers-content">
    <div class="page-header">
        <h2>Vendedores</h2>
    </div>

    <div class="searchOption">
        <div class="col-md-6">
            <form class="form-horizontal" role="form" action="" method="post">
                <div class="form-group">
                    <div class="col-md-12">
                        <select name="country" id="" class="form-control">
                            <option value="">Todos</option>
                            <?php
                            if (!empty($country)) {
                                foreach ($country as $c) {
                                    ?>
                                    <option
                                        value="<?php echo $c->country_id ?>" <?php echo $current_country == $c->country_id ? 'selected' : '' ?>><?php echo $c->name ?></option>
                                <?php
                                }
                            } ?>
                        </select>
                    </div>
                </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-md-10 noPadding">
                    <input value="<?php echo $current_search; ?>" name="searchData" type="text" class="form-control" id="inputEmail3" placeholder="Buscar vendedores">
                </div>
                <div class="col-md-2 noPadding">
                    <button type="submit" name="submit" value="Submit" class="btn btn-success pull-right">Buscar</button>
                </div>
            </div>

            </form>
        </div>
    </div>

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
                            <a href="<?php echo base_url(); ?>user/view/<?php echo $r->user_name ?>"><b><?php echo $r->user_name ?></b> <span
                                    class="sellerMap flag flag-<?php echo !empty($countryCode->iso_code_2) ? strtolower($countryCode->iso_code_2) : ''; ?> pull-right"></span></a>
                        </div>
                        <div class="sellerName">
                            <input id="input-21e"
                                   value="<?php echo $r->seller_review; ?>" class="rating rating_star"
                                   min="0" max="5" step="1" data-size="xs" data-disabled="true" data-show-caption="false" data-show-clear="false">
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



