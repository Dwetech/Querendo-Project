<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sellers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->auth->logged_in) {
            redirect('login');
        }
    }

    public function index() {


        $this->load->helper('function_helper');


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            if (isset($_POST['country']) || isset($_POST['searchData'])) {

                if (!empty($_POST['country']) && !empty($_POST['searchData'])) {


                    $data['current_country'] = $_POST['country'];
                    $data['current_search'] = $_POST['searchData'];
                    $data['user'] = $this->user_model->getAllDataByCountrySearch($_POST['searchData'], $_POST['country']);
                } else if (empty($_POST['country']) && !empty($_POST['searchData'])) {


                    $data['current_country'] = '';
                    $data['current_search'] = $_POST['searchData'];
                    $data['user'] = $this->user_model->getAllDataBySearch($_POST['searchData']);
                } else if (!empty($_POST['country']) && empty($_POST['searchData'])) {


                    $data['current_country'] = $_POST['country'];
                    $data['current_search'] = '';
                    $data['user'] = $this->user_model->getAllDataByCountry($_POST['country']);
                } else {


                    $data['current_country'] = '';
                    $data['current_search'] = '';
                    $data['user'] = $this->user_model->getAllUserData();
                }
            } else {


                $data['current_country'] = '';
                $data['current_search'] = '';
                $data['user'] = $this->user_model->getAllUserData();
            }
        } else {


            $data['current_country'] = '';
            $data['current_search'] = '';
            $data['user'] = $this->user_model->getAllUserData();
        }

        $data['country'] = $this->user_model->getAllData('country');


        $data['current'] = '';
        $this->load->view('sellers-view', $data);
    }

}