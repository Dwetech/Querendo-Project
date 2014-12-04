<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Home extends CI_Controller{

    public function __construct() {
        parent::__construct();

        if (!$this->auth->checkAdminLogin()) {
            redirect(base_url().'admin/login');

        }

    }

    function index(){
        $this->load->model('withdraw_model');

        $data['withdraw'] = $this->withdraw_model->getStatusWithdraw('pending');
        $data['page'] = 'dashboard';
        $this->load->view('admin/home_view' , $data);
    }
}