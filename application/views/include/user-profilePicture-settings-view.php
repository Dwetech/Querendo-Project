<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ridwanul Hafiz
 * Date: 5/4/14
 * Time: 7:40 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="user-profilePicture-settings-section">
    <div class="profile-picture online">
        <?php if (!empty($this->auth->user_data->profile_pic)) { ?>
            <img id="user_photo" class="imgAuto" src="<?php echo base_url() . 'upload/profile_photo/' . $user->profile_pic; ?>?<?php echo Time(); ?>" alt="" 
                 data-photo="<?php echo $user->profile_pic; ?>"/>
            <?php
        } else {
            ?>
            <img class="imgAuto" src="<?php echo base_url() . 'resources/img/blank.png'; ?>" alt=""/>
        <?php } ?>
    </div>
    <div class="changePicture">
        <b>Alterar foto</b>
        <input type="file" class="changePictureInput" name="userfile" id="userfile" multiple accept='image/*'>
        <span class="help-block">* Largura da imagem não deve ser maior que 600px<br/>
            * Tamanho máximo de imagem: 2MB
        </span>
    </div>
</div>

<script>

    $(document).ready(function() {

        $('img#user_photo').imgAreaSelect({
            aspectRatio: '1:1',
            onSelectEnd: querendo.crop_image
        });
    });
</script>