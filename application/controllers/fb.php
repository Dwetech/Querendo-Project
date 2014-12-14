<?php

/*
  Created on : May 24, 2014, 3:46:39 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Fb extends CI_Controller {

    public function __construct() {

        parent::__construct();
    }

    /**
     * Login with facebook integration
     * @return type
     */
    function auth($join = false) {

        //app credentials
        $fb_config = array(
            'appId'  => $this->config->item('facebook_access_token'),
            'secret' => $this->config->item('facebook_access_secret')
        );

        $this->load->library('fb_sdk/facebook', $fb_config);
        print_r($this->facebook->getApplicationAccessToken());
        exit();

        //tryign to get logged in facebook user
        $user = $this->facebook->getUser();

        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
            }
            catch (FacebookApiException $e) {
                $user = null;
            }
        }
        //id,email,first_name,last_name,middle_name,name,username----scopes

        if ($user) {
            $data['logout_url'] = $_SESSION['logout_url'] = $this->facebook->getLogoutUrl();
        } else {
            $login_uri_params = array(
                'scope' => 'email'
            );
            $data['login_url'] = $this->facebook->getLoginUrl($login_uri_params);
            redirect($data['login_url']);
        }


        /*
         * checking user already exist or not
         * ====================
         * if registered already, user will be logged in
         * and if not, user will be registered
         */
        if (isset($data['user_profile']) && $data['user_profile']) {
            $this->login($data, 'facebook');
        }
        return $data;
    }

    function login($data, $social_type) {

        $this->load->helper('auth');
        $this->load->model('social_login_model');

        $query = array(
            'social_login.social_id' => $data['user_profile']['id']
        );

        //checking whether user is exist or not
        $check_user_result = $this->social_login_model->check_user($query);

        //User exist, log him in
        if ($check_user_result !== false) {

            // Check user status
            $user = $this->user_model->getUserDetailsByUserID($check_user_result->user_id);
            if (!$user) {
                $this->session->set_flashdata('error', 'Your account is disabled!');
                redirect('login');
            }

            $user_data = array(
                'social_type' => $social_type,
                'user_id' => $check_user_result->user_id,
                'social_id' => $check_user_result->social_id,
                'user_name' => $check_user_result->user_name
            );
            login_social_user($user_data);
        }
        //User not exist, sign-up new account for him
        else {

            $email = isset($data['user_profile']['email']) && $data['user_profile']['email'] != '' ? $data['user_profile']['email'] : '';

            //check for user existence in both user table and social_login table
            $check_result = check_social_user_existence('email', $email, $data['user_profile']['id'], 'facebook');

            //if user is already exist
            if ($check_result !== false) {
                $this->session->set_flashdata('error', $check_result);
                redirect('login');
                exit();
            }
            //if user is not exist
            else {

                //Registering new user
                $fb_email = isset($data['user_profile']['email']) && $data['user_profile']['email'] != '' ? $data['user_profile']['email'] : '';
                $fb_user_data = array(
                    'email' => $fb_email,
                    'first_name' => $data['user_profile']['first_name'],
                    'last_name' => $data['user_profile']['last_name'],
                    'social_id' => $data['user_profile']['id'],
                    'user_name' => toUserName($data['user_profile']['first_name'] . ' ' . $data['user_profile']['last_name'])
                );
                $user_id = register_social_user($fb_user_data, 'facebook');

                //After successful registration, user is being logged in
                $user_data = array(
                    'social_type' => 'facebook',
                    'user_id' => $user_id,
                    'social_id' => $data['user_profile']['id'],
                    'user_name' => $fb_user_data['user_name']
                );
                login_social_user($user_data);
                
                
                redirect('userhome/home');
            }
        }
    }

}
