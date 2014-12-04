var querendo = querendo || {
    /**
     * 
     * @param {string} profile_photo
     * @param {string} base_url
     * @returns {none}
     * ===================
     * Sending message to client
     */
    send_message: function(product_id, from_id, to_id, message, profile_photo, base_url) {


        var thread_id = $("#thread_id").val();
        var last_insert_id = $("#message_id").val();


        $.ajax({
            url: base_url + 'messages/send_message',
            data: {
                thread_id: thread_id,
                product_id: product_id,
                from_id: from_id,
                to_id: to_id,
                message_id: last_insert_id,
                message: message
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

                /**
                 * Just inserted message is added with "unsent" id and it will be removed when request is success
                 * @type String
                 */
                var conversation = '<div class="chatCon" id="unsent">\n\
                                            <div class="col-md-12">\n\
                                                <div class="col-md-10 col-md-offset-1">\n\
                                                    <div class="chatText">\n\
                                                        <div class="alert alert-info noMargin">' + message + '<span class="msgTime text-small normalAsh">' + formatTimeOfDay() + '</span></div>\n\
                                                        <i class="chatArrowFrom glyphicon glyphicon-play"></i>\n\
                                                    </div>\n\
                                                </div>\n\
                                                <div class="col-md-1 noRpad user_photo">\n\
                                                    <img class="imgAuto" src="' + base_url + 'upload/profile_photo/' + profile_photo + '" alt=""/>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>';


                //Appending the message to the chat window
                $(".chat_box").append(conversation).scrollTop($(".chat_box").get(0).scrollHeight);

            },
            complete: function() {

                //When message send request is complete, message input will be clear and re-focused
                $("#message").val('').focus();
            },
            success: function(rslts) {


                if (rslts.status == 'success') {

                    //Updating notifications
                    querendo.check_message(base_url);


                    //Variables
                    var data = rslts.conversation;
                    var conversation = '';
                    var last_message_id = '0';



                    for (var x in data) {


                        //If fetched from id and logged in user id is same
                        if (data[x].from_id == from_id) {


                            conversation += '<div class="chatCon">\n\
                                                        <div class="col-md-12">\n\
                                                            <div class="col-md-10 col-md-offset-1">\n\
                                                                <div class="chatText">\n\
                                                                    <div class="alert alert-info noMargin">' + data[x].message + '<span class="msgTime text-small normalAsh">' + my_date_format(data[x].create_date)
                                + '</span></div><i class="chatArrowFrom glyphicon glyphicon-play"></i>\n\
                                                                </div>\n\
                                                            </div>\n\
                                                            <div class="col-md-1 noRpad user_photo">';

                            //If profile photo is exist
                            if (data[x].profile_pic == '') {

                                conversation += '<img class="imgAuto" src="' + base_url + 'resources/img/blank.png" alt=""/>';
                            } else {

                                conversation += '<img class="imgAuto" src="' + base_url + 'upload/profile_photo/' + data[x].profile_pic + '" alt=""/>';
                            }

                            conversation += '</div>\n\
                                                </div>\n\
                                            </div>';
                        } else {


                            conversation += '<div class="chatCon">\n\
                                                        <div class="col-md-12">\n\
                                                            <div class="col-md-1 noRpad user_photo">';

                            if (data[x].profile_pic == '') {

                                conversation += '<img class="imgAuto" src="' + base_url + 'resources/img/blank.png" alt=""/>';
                            } else {

                                conversation += '<img class="imgAuto" src="' + base_url + 'upload/profile_photo/' + data[x].profile_pic + '" alt=""/>';
                            }

                            conversation += '</div>\n\
                                                <div class="col-md-10">\n\
                                                    <div class="chatText">\n\
                                                        <div class="alert alert-default noMargin">' + data[x].message + '<span class="msgTime text-small normalAsh">' + my_date_format(data[x].create_date) + '</span></div>\n\
                                                        <i class="chatArrowTo mirror glyphicon glyphicon-play"></i>\n\
                                                    </div>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>';
                        }

                        //Getting last message_id
                        last_message_id = data[x].id;
                    }


                    //Removing last inserted message
                    $("#unsent").remove();
                    //appending chat data and keeping scroll to the bottom
                    $(".chat_box").append(conversation).scrollTop($(".chat_box").get(0).scrollHeight);


                    //Updating message_id
                    $("#message_id").val(last_message_id);
                    //Updating thread_id
                    $("#thread_id").val(rslts.thread_id);

                }
            }
        });
    },
    /**
     * 
     * @param {string} base_url
     * @returns {undefined}
     * ================
     * Fetching message
     */
    fetch_messages: function(product_id, from_id, to_id, base_url) {


        //Fetch message after every 5 seconds automatically
        setInterval(function() {

            var thread_id = $("#thread_id").val();
            var message_id = $("#message_id").val();

            //Trying to get thread_id, If not exist
            if (thread_id == 0) {
                querendo.get_thread_id(base_url, product_id, from_id, to_id);
            }


            $.ajax({
                url: base_url + 'messages/fetch_message',
                data: {
                    thread_id: thread_id,
                    message_id: message_id
                },
                dataType: 'json',
                type: 'POST',
                success: function(rslts) {


                    if (rslts != false) {


                        var conversation = '';


                        for (var x in rslts) {

                            //Updating last_insert_id
                            $("#message_id").val(rslts[x].id);
                            //Updating thread_id
                            $("#thread_id").val(thread_id);


                            if (rslts[x].from_id == from_id) {


                                conversation += '<div class="chatCon"><div class="col-md-12"><div class="col-md-10 col-md-offset-1"><div class="chatText"><div class="alert alert-info noMargin">' + rslts[x].message + '<span class="msgTime text-small normalAsh">' + my_date_format(rslts[x].create_date) + '</span></div><i class="chatArrowFrom glyphicon glyphicon-play"></i></div></div><div class="col-md-1 noRpad user_photo">';

                                if (rslts[x].profile_pic == '') {

                                    conversation += '<img class="imgAuto" src="' + base_url + 'resources/img/blank.png" alt=""/>';
                                } else {

                                    conversation += '<img class="imgAuto" src="' + base_url + 'upload/profile_photo/' + rslts[x].profile_pic + '" alt=""/>';
                                }

                                conversation += '</div></div></div>';
                            } else {


                                conversation += '<div class="chatCon"><div class="col-md-12"><div class="col-md-1 noRpad user_photo">';

                                if (rslts[x].profile_pic == '') {

                                    conversation += '<img class="imgAuto" src="' + base_url + 'resources/img/blank.png" alt=""/>';
                                } else {

                                    conversation += '<img class="imgAuto" src="' + base_url + 'upload/profile_photo/' + rslts[x].profile_pic + '" alt=""/>';
                                }

                                conversation += '</div><div class="col-md-10"><div class="chatText"><div class="alert alert-default noMargin">' + rslts[x].message +
                                        '<span class="msgTime text-small normalAsh">' + my_date_format(rslts[x].create_date) + '</span></div><i class="chatArrowTo mirror glyphicon glyphicon-play"></i></div></div></div></div>';
                            }
                        }
                    }

                    //Appending data
                    $(".chat_box").append(conversation);



                }
            });
        }, 5000);
    },
    /**
     * 
     * @param {string} base_url
     * @param {int} product_id
     * @param {int} user_id
     * @param {int} to_id
     * @returns {undefined}
     * =================
     * Retrieving thread_id
     */
    get_thread_id: function(base_url, product_id, user_id, to_id) {


        $.ajax({
            url: base_url + 'messages/get_thread_id',
            data: {
                product_id: product_id,
                user_id: user_id,
                to_id: to_id
            },
            dataType: 'json',
            type: 'POST',
            success: function(rslt) {

                //Updating thread_id
                if (rslt != '0') {
                    $("#thread_id").val(rslt.thread_id);
                }
            }
        });
    },
    /**
     * 
     * @param {int} product_id
     * @param {int} user_id
     * @param {int} from_id
     * @param {int} rating
     * @param {string} message
     * @param {sting} type
     * @returns {none}
     * =================
     * User rating system
     */
    user_rating: function(product_id, user_id, from_id, rating, message, type) {


        $.ajax({
            url: base_url + 'product/make_review',
            data: {
                product_id: product_id,
                user_id: user_id,
                from_id: from_id,
                rating: rating,
                message: message,
                type: type
            },
            dataType: 'json',
            type: 'post',
            success: function(rslt) {


                $(".hide_it").hide();
                window.location.reload();
            },
            error: function() {

            }
        });
    },
    /**
     * 
     * @param {string} img
     * @param {object} obj
     * @returns {undefined}
     * ==============
     * Cropping image by user interaction
     */
    crop_image: function(img, obj) {

        var image_name = $("#user_photo").attr('data-photo');
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;


        if (thumb_width > 0) {


            $.ajax({
                type: "POST",
                url: '../../user/crop_image/' + image_name,
                cache: false,
                data: {
                    image_name: image_name,
                    width: thumb_width,
                    height: thumb_height,
                    x1: x_axis,
                    y1: y_axis,
                    x2: x2_axis,
                    y2: y2_axis
                },
                success: function(rsponse) {

                    console.log(rsponse);
                }
            });
        } else
            alert("Please select portion..!");
    },
    /**
     * Setting values to make the new chat read
     * =========================
     * Setting product_id, chat sender, chat receiver information 
     * on the modal form
     * @returns {NULL}
     */
    set_chat_values: function(product_id, from_id, to_id, to_name) {
        //Clearing error message, message, enabling button
        $(".error_message").removeClass('alert alert-danger').html('');
        $("#send_msg").attr('disabled', false);
        $("#chat_message").val('');




        $("#product_id").val(product_id);
        $("#from_id").val(from_id);
        $("#to_id").val(to_id);
        $("#to_name").text(to_name);


        $("#chat_message").focus();
    },
    /**
     * Initiating new chat by product owner
     * @returns {NULL}
     */
    initiate_chat: function(base_url) {


        //Getting values
        var product_id = $("#product_id").val();
        var from_id = $("#from_id").val();
        var to_id = $("#to_id").val();
        var message = $("#chat_message").val();

        if (message == '') {

            $(".error_message").addClass('alert alert-danger').html('Please write something to send message!');
            return false;
        }


        $.ajax({
            url: base_url + 'messages/initiate_chat',
            type: 'POST',
            dataType: 'json',
            data: {
                product_id: product_id,
                from_id: from_id,
                to_id: to_id,
                message: message
            },
            beforeSend: function() {

                $("#send_msg").attr('disabled', true);
            },
            complete: function() {


            },
            onerror: function() {


            },
            success: function(rslt) {


                if (rslt != 0) {

                    window.location.href = base_url + 'messages/index/' + rslt;
                } else {

                    $(".error_message").addClass('alert alert-danger').html('Message send failed! Please try again later.');
                }
            }
        });
    },
    /**
     * Check for any new message for user
     * @returns {boolean}
     */
    check_message: function(base_url) {


        setInterval(function() {

            $.ajax({
                url: base_url + 'messages/check_message/',
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {

                },
                complete: function() {

                },
                onerror: function() {

                },
                success: function(rslt) {

                    //rslt[0] returns new message count
                    if (rslt[0] > 0) {

                        //Updating notification number
                        $(".messagesNotifyNumber").html(rslt[0]);

                        var notification = '';

                        for (var x in rslt) {

                            if (rslt[x].count > 0) {

                                if (typeof rslt[x] == 'object') {




                                    //singular or plural check
                                    if (rslt[x].count > 1)
                                        var singularity = 'messages';
                                    else
                                        var singularity = 'message';


                                    notification += '<li>' +
                                            '<a href="' + base_url + 'messages/index/' + rslt[x].thread_id + '">' +
                                            '<div class="notification">' +
                                            '<div class="col-md-1 noPadding">' +
                                            '<div class="notifyUpic">' +
                                            '<img class="imgAuto" src="' + base_url + 'upload/profile_photo/' + rslt[x].profile_pic + '" alt="">' +
                                            '</div>' +
                                            '</div>' +
                                            '<div class="col-md-11">' +
                                            '<p>' +
                                            '<b class="text-blue">' + rslt[x].user_name + '</b>' +
                                            '<span class="normalAsh">' +
                                            ' sent <b>' + rslt[x].count + '</b> ' + singularity + ' to you.' +
                                            '</span>' +
                                            '</p>' +
                                            '</div>' +
                                            '</div>' +
                                            '</a>' +
                                            '</li>';
                                }
                            }
                        }

                        //Appending notification messages
                        $(".msgNotifyBoxMsg").html(notification);
                        $(".msgBoxLink").html('<a class="text-center seeAllNotification" href="' + base_url + 'messages/' + '">See All</a>');


                    }
                }

            });
        }, 5000);

    }
};



function less_more() {

    $('.more-less').on('click', function() {

        var content = $(this).attr('data-content');
        var number = $(this).attr('data-number');
        $('#project-' + number).toggle(100);

        if (content == 'less') {

            $(this).attr('data-content', 'more');
            $(this).html('( More )');
        }

        if (content == 'more') {

            $(this).attr('data-content', 'less');
            $(this).html('( Less )');
        }
    });
}



function showBid() {

    $('.bidOption').toggle();
    $('html, body').stop().animate({scrollTop: 207 + 'px'}, 100);
}



function formatTimeOfDay() {

    var d = new Date(); // for now
    var date = d.getDate();
    var month = d.getMonth();
    var year = 1900 + d.getYear();
    var hours = d.getHours(); // => 9
    var minutes = d.getMinutes(); // =>  30
//    d.getSeconds(); // => 51



    if (hours > 12) {
        hours = hours - 12;
        return  date + " " + dateMonth(month) + ", " + year + " at " + hours + (minutes < 10 ? ":0" : ":")
                + minutes + "pm";
    } else if (hours = 12) {
        return date + " " + dateMonth(month) + ", " + year + " at " + hours + (minutes < 10 ? ":0" : ":")
                + minutes + "pm";
    } else {
        return date + " " + dateMonth(month) + ", " + year + " at " + hours + (minutes < 10 ? ":0" : ":")
                + minutes + "pm";
    }


}

function dateMonth(month) {
    switch (month) {
        case 0 :
            $data = "Jan";
            break;
        case 1 :
            $data = "Feb";
            break;
        case 2 :
            $data = "Mar";
            break;
        case 3 :
            $data = "Apr";
            break;
        case 4 :
            $data = "May";
            break;
        case 5 :
            $data = "Jun";
            break;
        case 6 :
            $data = "Jul";
            break;
        case 7 :
            $data = "Aug";
            break;
        case 8 :
            $data = "Sep";
            break;
        case 9 :
            $data = "Oct";
            break;
        case 10 :
            $data = "Nov";
            break;
        case 11 :
            $data = "Dec";
            break;
    }
    return $data
}


function forgot_password() {

    $('#loginModal').modal('hide');
    $('#forgotPasswordModal').modal('show');
}


function my_date_format(input){
    var d = new Date(Date.parse(input.replace(/-/g, "/")));

    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    var date = d.getDate().toString() + " " + month[d.getMonth().toString()] + ", " +    d.getFullYear().toString();
    var time = d.toLocaleTimeString().toLowerCase().replace(/([\d]+:[\d]+):[\d]+(\s\w+)/g, "$1$2");
    return (date + " at " + time);

}



function already_member() {

    $('#signupModal').modal('hide');
    $('#loginModal').modal('show');
}

function x()
{
    alert('ok');
}



window.fbAsyncInit = function() {

    FB.init({
        appId: '187451928066525',
        version: 'v2.0',
        oauth: true,
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        xfbml: true // parse XFBML
    });

};


var fb_authData = null;


function fb_login() {

    FB.login(function(response) {

        if (response.authResponse) {

            console.log('Welcome!  Fetching your information.... ');
            console.log(response); // dump complete info
            fb_authData = response.authResponse;
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID

            FB.api('/me', function(response) {

                user_email = response.email; //get user email
                // you can store this data into your database
                console.log(response);

                //load the logging in div to the user.....

                var imageSrc = "https://graph.facebook.com/" + response.id + "/picture?width=140&height=140";

                $('.fbLoginWindow .profile_pic').html("<img src=" + imageSrc + ">");

                $('.fbLoginWindow .userName').html(response.name)

                //$('.fbLoginWindow').html("<pre>"+ response.bio +"</pre>");
                $('#loginModal').modal('hide');
                $('#signupModal').modal('hide');
                $('.fbLoginWindow').fadeIn(500);

                // ajax call to check the user is already exist or not...
                // login the user if the user is already exist in database
                // registered the user if the user is not in database.....


                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: baseurl + "ajax/is_user_exist",
                    data: {'email': response.email},
                    beforeSend: function() {
                        $('.loading').show();
                    },
                    complete: function() {
                        //$('#pagewait').hide();
                    },
                    success: function(response) {

                        $('.loading').hide();

                        if (response.status == 'success') {
                            if (response.response == 'false') {
                                $("#fb_register_form").show();
                            } else {
                                registerFbUser();
                            }
                        }
                        //document.location.href = baseurl + 'user/dashboard/';

                    }
                });


            });

        } else {

            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');

        }
    }, {
        scope: 'email,user_location'
    });
}








function registerFbUser(username) {

    var data = fb_authData;

    if (typeof username != 'undefined') {
        data.userName = username;
    }

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: baseurl + "ajax/fbLogin",
        data: data,
        cache: false,
        beforeSend: function() {
            $('.loading').show();
        },
        complete: function() {
            //$('#pagewait').hide();
        },
        success: function(response) {

            $('.loading').hide();

            if (response.status == 'error') {
                if (response.error_type == 'username') {
                    $("#fb_signup_message").html(response.message);
                    $(".usernameFormGroup").addClass('has-error');
                } else {
                    $("#fb_signup_message").html('Something went wrong! Please refresh the browser and try again.');
                    $(".usernameFormGroup").addClass('has-error');
                }
            } else if (response.status == 'success') {
                document.location.href = baseurl + 'user/dashboard/';
            } else {
                $("#fb_signup_message").html('Something went wrong! Please refresh the browser and try again.');
                $(".usernameFormGroup").addClass('has-error');
            }


        }
    });
}



(function(d) {
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement('script');
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
}(document));



function proPic() {
//    profileImg
}





$(function() {
    $("#fb_register_form").submit(function(event) {

        var username = $("#fb_signup_username").val();
        if (username == '') {
            $("#fb_signup_message").html('Please insert a username');
            $(".usernameFormGroup").addClass('has-error');
            return false;
        } else {
            $("#fb_signup_message").html('');
            $(".usernameFormGroup").removeClass('has-error');
        }

        registerFbUser(username);

        event.preventDefault();

    });













    var $menu = $(".browseMenu");

    // jQuery-menu-aim: <meaningful part of the example>
    // Hook up events to be fired on menu row activation.
    $menu.menuAim({
        activate: activateSubmenu,
        deactivate: deactivateSubmenu
    });
    // jQuery-menu-aim: </meaningful part of the example>

    // jQuery-menu-aim: the following JS is used to show and hide the submenu
    // contents. Again, this can be done in any number of ways. jQuery-menu-aim
    // doesn't care how you do this, it just fires the activate and deactivate
    // events at the right times so you know when to show and hide your submenus.
    function activateSubmenu(row) {
        var $row = $(row),
            submenuId = $row.data("submenuId"),
            $submenu = $("#" + submenuId),
            height = $menu.outerHeight(),
            width = $menu.outerWidth();



        // Show the submenu
        $submenu.css({
            display: "block",
            boxShadow: "none",
            top: 0,
            left: width - 3,  // main should overlay submenu
            height: height  // padding for main dropdown's arrow
        });

        // Keep the currently activated row's highlighted look

        $row.find("a").addClass("maintainHover");
    }

    function deactivateSubmenu(row) {
        var $row = $(row),
            submenuId = $row.data("submenuId"),
            $submenu = $("#" + submenuId);

        // Hide the submenu and remove the row's highlighted look
        $submenu.css("display", "none");
        $row.find("a").removeClass("maintainHover");
    }

    // Bootstrap's dropdown menus immediately close on document click.
    // Don't let this event close the menu if a submenu is being clicked.
    // This event propagation control doesn't belong in the menu-aim plugin
    // itself because the plugin is agnostic to bootstrap.
    $(".dropdown-menu li").click(function(e) {
        e.stopPropagation();
    });

    $(document).click(function() {
        // Simply hide the submenu on any click. Again, this is just a hacked
        // together menu/submenu structure to show the use of jQuery-menu-aim.
        $(".popover").css("display", "none");
        $("a.maintainHover").removeClass("maintainHover");
    });


    $('.dropdown').mouseenter(function(){
        $('.dropdown > .mainLink').addClass('onHoverMainMenu');
    });
    $('.dropdown').mouseleave(function(){
        $('.dropdown > .mainLink').removeClass('onHoverMainMenu');
    });


});
