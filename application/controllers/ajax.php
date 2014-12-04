<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/8/14
 * Time: 1:16 PM
 */
class Ajax extends CI_Controller {

    public function fbLogin() {

        if( !$this->input->post('accessToken') ) {
            $response_data = array(
                'status'    => 'error',
                'error_type'=> 'no_accessTocken',
                'message'   => 'Unable to login with facebook!'
            );
            echo json_encode($response_data);
            return;
        }

        //app credentials
        $fb_config = array(
            'appId'  => $this->config->item('facebook_access_token'),
            'secret' => $this->config->item('facebook_access_secret')
        );

        $this->load->library('fb_sdk/facebook', $fb_config);
        $this->facebook->setAccessToken($this->input->post('accessToken'));

        $fb_user = $this->facebook->api('/me');

        if( !$fb_user ) {
            $response_data = array(
                'status'    => 'error',
                'error_type'=> 'noUserDetails',
                'message'   => 'Unable to login with facebook!'
            );
            echo json_encode($response_data);
            return;
        }

        //load the database model..
        $this->load->model('user_model');

        //check database for existence of user with email....
        $user = $this->user_model->login_access(array(
            'email' => $fb_user['email'],
            'email_verify' => 1
        ));


        // If user not exist - Add him
        if( !$user ) {

            if( $this->input->post('userName') ){
                $username = $this->input->post('userName');

                if( strlen($username) < 3 || strlen($username) > 20 ){
                    $error_response = array(
                        'status'     => 'error',
                        'error_type' => 'username',
                        'message'    => 'Username must be at minimum 3 to maximum 20 characters long'
                    );
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($error_response));
                    return;
                }

                if( !preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $username) ) {
                    $error_response = array(
                        'status'     => 'error',
                        'error_type' => 'username',
                        'message'    => 'Only letters, numbers and -_ are allowed'
                    );
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($error_response));
                    return;
                }

                $usernameCheck = $this->user_model->isUserExist(array('user_name'=>$username));
                if( $usernameCheck ){
                    $error_response = array(
                        'status'     => 'error',
                        'error_type' => 'username',
                        'message'    => 'Username has already been taken. Please try a different one'
                    );
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($error_response));
                    return;
                }
            } else {
                $username = $this->__toUserName($fb_user['first_name']);
            }



            $profile_file_name = random_string('alnum', 8);
            $imageString       = file_get_contents("https://graph.facebook.com/" . $fb_user['id'] . "/picture?width=270&height=270");
            $save              = file_put_contents('upload/profile_photo/'.$profile_file_name.'.jpg',$imageString);

            $bio = isset($fb_user['bio']) ? $fb_user['bio'] : '';

            $userData = array(
                'user_name' => $username,
                'email'     => $fb_user['email'],
                'first_name'=> $fb_user['first_name'],
                'last_name' => $fb_user['last_name'],
                'about'     => $bio,
                'balance'   => '0',
                'profile_pic'=> $profile_file_name.'.jpg',
                'email_verify' => '1',
                'fb_login'  => '1'
            );



            $user_id = $this->user_model->add_user($userData);

        } else
        {
            $user_id = $user->id;
        }

        // Finally log the user in.
        $login = $this->auth->__login($user_id,true);

        if( !$login ) {
            $response_data = array(
                'status'    => 'error',
                'error_type'=> 'login',
                'message'   => 'Unable to login!'
            );
            echo json_encode($response_data);
            return;
        }


        // Login successful, send a success response
        $response_data = array(
            'status'    => 'success',
            'message'   => 'You are logged in successfully'
        );
        echo json_encode($response_data);
        return;



    }


    /**
     * check if a user exist by email address
     */
    public function is_user_exist() {

        if( !$this->input->post('email') ) {
            $error_response = array(
                'status' => 'error',
                'message' => 'No Email Found!'
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($error_response));
            return;
        }

        $this->load->model('user_model');
        $email = $this->input->post('email');

        $user = $this->user_model->isUserExist(array('email'=>$email));
        if( !$user ) {
            $response = array(
                'status' => 'success',
                'response' => 'false',
                'message' => 'No user found with given email address'
            );

        } else {
            $response = array(
                'status' => 'success',
                'response' => 'true',
                'message' => 'User already exist with given email address'
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        return;


    }

    function test(){
        echo preg_replace('/^\w{5,}$/', '', 'à¦®à§à¦¹à¦¾à¦®à§à¦®à¦¦ à¦¤à¦¾à¦°à¦¿à¦• à¦¹à¦¾à¦¸à¦¾à¦¨');
    }




    /**
     * Convert any string (actually users full name) into a unique username
     * ====================================================================
     * This function remove all special characters, spaces and turn them into
     * username. this also make sure that the user name is unique by checking it
     * to database.
     * If a match found - it adds numbers at the end to make it unique.
     *
     * @param $name
     * @return mixed|string
     */
    private function __toUserName($name){

        $this->load->model('user_model');

        $name = strtolower($name);
        $username = $name = preg_replace("/[^a-zA-Z0-9\-\_]/", "", $name);

        while( $this->user_model->isUserExist(array('user_name'=>$username)) == true ) {
            $username = $name.'_'.mt_rand(1,9999);
        }

        return $username;

    }

}
