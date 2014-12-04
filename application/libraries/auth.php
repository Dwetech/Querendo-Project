<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 1/9/14
 * Time: 5:12 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    private $error;
    var $logged_in;
    var $url;
    var $user_data = array();
    var $is_active;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model(array('user_model', 'message_model'));
        $this->ci->load->model('admin_model');
        session_start();






        if (isset($_SESSION['timeout'])) {
            $this->time = $_SESSION['timeout'];
        }




        $this->is_active = $this->isActive();
        $this->logged_in = $this->isLoggedIn();

        if ($this->logged_in) {
            
            $this->user_data = $user_data = $this->ci->user_model->get_user_auth_data(array('email' => $_SESSION['user_email']));

            //If user has already set timezone
            if ($user_data->timezone != 0 &&  $user_data->timezone != NULL) {
                
                $timezone = $this->ci->user_model->get_timezone(array('id' => $user_data->timezone));
                date_default_timezone_set($timezone->timezone);
                $this->ci->db->query("SET SESSION time_zone = '" . $timezone->value . "'");
            } else {
                
                date_default_timezone_set("UTC");
                $this->ci->db->query("SET SESSION time_zone = '+00:00'");
            }
        } else {
            
            date_default_timezone_set("UTC");
            $this->ci->db->query("SET SESSION time_zone = '+00:00'");
        }

        if (!isset($_SESSION['login_referer'])) {
            $this->referrer = "/";
        }
        $this->url = $_SESSION['url'] = current_url();
        $_SESSION['timeout'] = time();
    }

    function login($email, $password, $remember = false) {

        $password = hash("sha256", $password);

        $where = array(
            'email' => $email,
            'email_verify' => 1
        );


        $user_info = $this->ci->user_model->login_access($where);

        if ($user_info) {

            if ($password == $user_info->password) {
                return $this->__login($user_info->id,$remember);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    function __login($user_id,$remember = false) {

        $user = $this->ci->user_model->get_user_by_id($user_id);
        if( !$user ) {
            return false;
        }

        if ($remember == 1) {

            $cookie_key = random_string('alnum', 20);

            setcookie('cookie_key', $cookie_key, time() + 60 * 60 * 24 * 60, '/');
            $this->isTimeOut(time() + 60 * 60 * 24 * 60);
        } else {

            setcookie('cookie_key', '', time() - 3600, '/');
        }

        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name']  = $user->user_name;

        return true;
    }

    function checklogin() {
        if (!$this->isLoggedIn()) {
            return false;
        } else {
            return true;
        }
    }

    function isActive() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $where = array(
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email']
            );
            $value['data'] = $this->ci->user_model->login_access($where);
            if ($value['data'] && $value['data']->status == '1') {
                return true;
            }
            return false;
        }
    }

    function isLoggedIn() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

            if (!$this->isTimeOut()) {
                return false;
            }

            $where = array(
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email']
            );
            $value['data'] = $this->ci->user_model->login_access($where);

            if ($value['data'] != FALSE && $_SESSION['user_id'] == $value['data']->id && $_SESSION['user_email'] == $value['data']->email) {

                return true;
            }
            /*
              username or userlevel not exist or s_ecryption session invalid
              User not logged in.
             */ else {
                return false;
            }
        }
        /**
         * cookie check for user login
         */
        /* else if (isset($_COOKIE['cookie_key']) && $_COOKIE['cookie_key'] != '') {

          $cookie_key = $_COOKIE['cookie_key'];
          $where = array(
          'cookie_key' => $cookie_key
          );
          $user_data = $this->ci->user_model->login_access($where);

          if (!empty($user_data)) {
          $_SESSION['user_id'] = $user_data->id;
          $_SESSION['user_email'] = $user_data->email;
          $_SESSION['user_name'] = $user_data->user_name;

          return true;
          }
          } */ else {
            return false;
        }
    }

    public function AdminLogin($email, $password) {

        $admin_details = $this->ci->admin_model->checkAdminLogin($email);

        if ($admin_details === FALSE) {
            return false;
        }

        $new_password = hash("sha256", $password);



        if ($admin_details->password == $new_password) {

            $_SESSION['logged_in'] = TRUE;
            $_SESSION['admin_user_id'] = $admin_details->user_id;
            $_SESSION['admin_email'] = $admin_details->email;


            return true;
        }
    }

    public function checkAdminLogin() {


        if (!isset($_SESSION['admin_user_id']) || !isset($_SESSION['admin_email'])) {
            return false;
        }


        //check whether the user is exist in the database if he is in session
        $login_data = array(
            'user_id' => $_SESSION['admin_user_id']
        );
        if ($admin_data = $this->ci->admin_model->login_access($login_data)) {
            if ($admin_data->email == $_SESSION['admin_email']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function isTimeOut($timeout = '5000') {

        if (isset($this->time)) {

            if ((time() - $this->time) > $timeout) {

                $this->logout();
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    function logout() {
        setcookie('cookie_key', "", time() - 3600, '/');

        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        $this->logged_in = false;
        redirect('login');
    }

}
