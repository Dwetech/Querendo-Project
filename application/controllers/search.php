<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->auth->logged_in) {
            redirect('login');
        }
    }

    public function index() {


        $this->load->model('product_model');
        $this->load->helper('function_helper');


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {
            

            if (isset($_POST['search'])) {
                
                
                if (!empty($_POST['search'])) {
                    
                    
                    $data['search'] = $_POST['search'];
                    $data['product'] = $this->product_model->searchProduct($data['search']);
                    $data['user'] = $this->user_model->searchUser($data['search']);
                } else {
                    
                    redirect(base_url());
                }
            } else {
                
                redirect(base_url());
            }
        } else {
            
            redirect(base_url());
        }


        $data['current'] = '';
        $this->load->view('search-view', $data);
    }

}
