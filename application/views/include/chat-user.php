<div class="chat_box">
    <?php
    $message_id = '0';
    $thread_id = '0';

    if (!empty($conversation)) {


        foreach ($conversation as $conversation) {


            $message_id = $conversation->id;
            $thread_id = $conversation->thread_id;


            //Displaying messages from this side
            if ($conversation->from_id != $from_id) {
                ?>
                <div class="chatCon">
                    <div class="col-md-12">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="chatText">
                                <div class="alert alert-info noMargin">
                                    <?php echo $conversation->message; ?>
                                    <span class="msgTime text-small normalAsh"><?php echo date("d M, Y", strtotime($conversation->create_date)) . ' at ' . date("g:i a", strtotime($conversation->create_date)); ?></span>
                                </div>
                                <i class="chatArrowFrom glyphicon glyphicon-play"></i>
                            </div>
                        </div>
                        <div class="col-md-1 noRpad user_photo">
                            <?php if (empty($conversation->profile_pic)) { ?>
                                <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
                            <?php } else { ?>
                                <img class="imgAuto" src="<?php echo base_url() . 'upload/profile_photo/' . $conversation->profile_pic; ?>" alt=""/>
                            <?php } ?>
                        </div>
                    </div>
                </div>


            <?php } else {//Displaying message form other side  ?>


                <div class="chatCon">
                    <div class="col-md-12">
                        <div class="col-md-1 noRpad">
                            <?php if (empty($conversation->profile_pic)) { ?>
                                <img class="imgAuto" src="<?php echo base_url(); ?>resources/img/blank.png" alt=""/>
                            <?php } else { ?>
                                <img class="imgAuto" src="<?php echo base_url() . 'upload/profile_photo/' . $conversation->profile_pic; ?>" alt=""/>
                            <?php } ?>
                        </div>
                        <div class="col-md-10">
                            <div class="chatText">
                                <div class="alert alert-default noMargin">
                                    <?php echo $conversation->message; ?>
                                    <span class="msgTime text-small normalAsh"><?php echo date("d M, Y", strtotime($conversation->create_date)) . ' at ' . date("g:i a", strtotime($conversation->create_date)); ?></span>
                                </div>
                                <i class="chatArrowTo mirror glyphicon glyphicon-play"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    }
    ?>
</div>


<form class="chatForm" action="<?php echo base_url() . 'product/send_message'; ?>" method="post" name="send_message">
    <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_data->product_id; ?>"/>
    <input type="hidden" id="from_id" name="from_id" value="<?php echo $_SESSION['user_id']; ?>"/>
    <input type="hidden" id="to_id" name="to_id" value="<?php echo $product_data->user_id; ?>"/>
    <input type="hidden" id="message_id" name="message_id" value="<?php echo $message_id; ?>" />
    <input type="hidden" id="thread_id" name="thread_id" value="<?php echo $thread_id; ?>" />
    <input type="text" id="message" class="form-control chatInput" name="message"/>
    <button class="btn btn-primary pull-right chatSubmit" id="send_message" type="submit" name="submit" value="send">Enviar</button>
</form>
<script>
    $(document).ready(function() {


        //after sending a message, the scroller will be at bottom
        $(".chat_box").scrollTop($(".chat_box").get(0).scrollHeight);


        var base_url = '<?php echo base_url(); ?>';
        var product_id = $("#product_id").val();
        var from_id = $("#from_id").val();
        var to_id = $("#to_id").val();
        var profile_photo = $(".user_photo img").attr('src');


        //send message
        $('.chatForm').submit(function() {
            var message = $("#message").val();
            if (message  == '')
                return false;

            querendo.send_message(product_id, from_id, to_id, message, profile_photo, base_url);
            return false;
        });

        //Fetching message
        querendo.fetch_messages(product_id, from_id, to_id, base_url);
    });


</script>