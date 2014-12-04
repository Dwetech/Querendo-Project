<?php

/**
 * Created by JetBrains PhpStorm.
 * User: amieami
 * Date: 5/25/14
 * Time: 1:51 PM
 * To change this template use File | Settings | File Templates.
 */
function send_email($from_email, $to_email, $message, $subject) {

    $ci = & get_instance();

    $admin_email = $from_email;
    $ci->load->library('email');
    $ci->load->library('parser');
    $config['mailtype'] = 'html';
    $config['priority'] = '1';
    $ci->email->initialize($config);

    $mail['subject'] = "$subject | Querendo";
    $mail['message'] = $message;
    $html_message = $ci->parser->parse('email_view', $mail, TRUE);

    $ci->email->from($admin_email);
    $ci->email->to($to_email);

    $ci->email->subject($mail['subject']);
    $ci->email->message($html_message);

    $ci->email->send();
    return true;
}

function getUserInfoByIp() {


    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    $user_ip = get_client_ip();
    $contents = json_decode(file_get_contents('http://smart-ip.net/geoip-json/' . $user_ip));

    return $contents;


//    $user_info = array(
//        'host' => $contents->host,
//        'lang' => $contents->lang,
//        'countryCode' => $contents->countryCode,
//        'city' => $contents->city,
//        'region' => $contents->region,
//        'latitude' => $contents->latitude,
//        'longitude' => $contents->longitude
//    );
}

function reviewBar($rating) {

    $width = ($rating / 5) * 100;
    return $width;
}

//// Since Date
function since_time($datetime) {


    $datetime = strtotime($datetime);
    $tTime = date($datetime);
    $getDate = getdate();

    /* echo "current time : ". date($getDate[0])."<br>";
      echo ".....post time : ". date($tTime)."<hr>"; */

    $cTime = $getDate[0];
    $sinceMin = round(($cTime - $tTime) / 60);
    $sinceWeek = $sinceMin / (24 * 7 * 60);
    $sinceMonth = $sinceMin / (24 * 7 * 60);
    $sinceyear = $sinceMonth / 12;
    if ($sinceMin == 0) {
        $sinceSec = round(($cTime - $tTime) / 1000);
        if ($sinceSec < 10)
            $since = 'less than 10 seconds ago';
        else if ($sinceSec < 20)
            $since = 'less than 20 seconds ago';
        else
            $since = 'half a minute ago';
    }
    else if ($sinceMin == 1) {
        $sinceSec = round(($cTime - $tTime) / 1000);
        if ($sinceSec == 30)
            $since = 'half a minute ago';
        else if ($sinceSec < 60)
            $since = 'less than a minute ago';
        else
            $since = '1 minute ago';
    }
    else if ($sinceMin < 45)
        $since = $sinceMin . ' minutes ago';
    else if ($sinceMin > 44 && $sinceMin < 60)
        $since = 'about 1 hour ago';
    else if ($sinceMin < 1440) {
        $sinceHr = round($sinceMin / 60);
        if ($sinceHr == 1)
            $since = 'about 1 hour ago';
        else
            $since = 'about ' . $sinceHr . ' hours ago';
    }
    else if ($sinceMin > 1439 && $sinceMin < 2880)
        $since = '1 day ago';
    else if ($sinceMin > 2880) {
        $sinceDay = round($sinceMin / 1440);
        $since = $sinceDay . ' days ago';
    }

    return $since;
}

function image_resize($image_name) {

    $t_width = 100; // Maximum thumbnail width
    $t_height = 100; // Maximum thumbnail height
    $new_name = 'thumb/' . $image_name; // Thumbnail image name
    $path = "upload/profile_photo/"; // Path to save the thumbnail
    $w = $_POST['width'];
    $h = $_POST['height'];
    $x1 = $_POST['x1'];
    $y1 = $_POST['y1'];
    $x2 = $_POST['x2'];
    $y2 = $_POST['y2'];
    $img = $_POST['image_name'];

    $ratio = ($t_width / $w);
    $nw = ceil($w * $ratio);
    $nh = ceil($h * $ratio);
    $nimg = imagecreatetruecolor($nw, $nh);
    $img_src = imagecreatefromjpeg($path . $img);
    imagecopyresampled($nimg, $img_src, 0, 0, $x1, $y1, $nw, $nh, $w, $h);
    imagejpeg($nimg, $path . $new_name, 90);
    //mysql_query("UPDATE user SET profile_image_small='$new_name' WHERE uid='$session_id'");
    echo $new_name;
    exit;
}

function sortFunction($a, $b) {
    
    return strtotime($b['date_time_string']) - strtotime($a['date_time_string']);
}


function strToUrl ($string)

{

    $string = preg_replace("`\[.*\]`U","",$string);

    $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);

    $string = htmlentities($string, ENT_COMPAT, 'utf-8');

    $string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );

    $string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);

    return strtolower(trim($string, '-'));

}


