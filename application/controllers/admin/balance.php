<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Balance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->auth->checkAdminLogin()) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index()
    {
        $this->load->model('admin_balance_model');
        $data['balance'] = $this->admin_balance_model->getAllAdminBalance();
        $data['page'] = 'balance';
        $this->load->view('admin/balance_view', $data);
    }

    function view($balance_id)
    {
        $this->load->model(array('admin_balance_model','product_model','user_model'));
        if (!$this->admin_balance_model->existBalane($balance_id)) {
            redirect(base_url() . 'admin/balance');
        }

        $data['balance'] = $this->admin_balance_model->getBalanceDetails($balance_id);

        $data['milestone'] = $this->admin_balance_model->getMilestoneDetails($data['balance']->milestone_id);
        $data['product'] = $this->product_model->getProductData($data['balance']->product_id);
        $data['user'] = $this->user_model->get_user_by_id($data['balance']->fee_taken_from);

        $data['page'] = 'balance';
        $this->load->view('admin/balance_details_view', $data);
    }


}