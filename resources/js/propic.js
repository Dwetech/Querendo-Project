$(window).load(function(){
    var height = $('.user-sidebar').width();
    $('.profile-picture').css({
        'height' : height+'px',
        'display' : 'inline-block',
        'overflow' : 'hidden'
    });


    var height = $('.profileImg').width();
    $('.profileImg').css({
        'height' : height+'px',
        'display' : 'inline-block',
        'overflow' : 'hidden'
    });

    var height = $('.profile-picture-img').width();
    $('.profile-picture-img').css({
        'height' : height+'px',
        'display' : 'inline-block',
        'overflow' : 'hidden'
    });

    var height = $('.profilePic').width();
    $('.profilePic').css({
        'height' : height+'px',
        'display' : 'inline-block',
        'overflow' : 'hidden'
    });
});
