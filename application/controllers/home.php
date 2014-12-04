<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ($this->auth->logged_in)
            redirect('user/dashboard/' . $_SESSION['user_name']);
    }

    public function index() {

        $this->load->model('product_model');
        $data['products'] = $this->product_model->get_products();
        $this->load->view('home-view', $data);
    }

    //view page for forgot password
    public function forgot_password() {
        $this->load->view('forgot_password-view');
    }

}
