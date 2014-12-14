<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->auth->logged_in) {
            redirect('login');
        }
    }

    public function index() {

        $this->load->model(array('balance_model'));
        $this->load->helper('function');

        $data['balanceCredit'] = $this->balance_model->getUserBalanceList($_SESSION['user_id'], 'credit');
        $data['balanceDebit'] = $this->balance_model->getUserBalanceList($_SESSION['user_id'], 'debit');

        /* Pagination */
        $this->load->library('pagination');
        $data['count'] = $this->balance_model->countTotalBalance($_SESSION['user_id']);
        $config['base_url'] = base_url() . 'finance/index/';
        $config['total_rows'] = $data['count'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 30;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;

        //Calculating offset
        if ($this->uri->segment(3) > 0) {

            $offset = $this->uri->segment(3) * $config['per_page'] - $config['per_page'];
        } else {

            $offset = $this->uri->segment(3);
        }
        $this->pagination->initialize($config);
        /* Pagination */


        $data['balance'] = $this->balance_model->getTotalBalance($_SESSION['user_id'], $config['per_page'], $offset);

        $data['current'] = 'finance';
        $this->load->view('finance-view', $data);
    }

    public function deposit() {

        if (!$this->auth->is_active)
            redirect('user/inactive');


        $data['current'] = 'finance';
        $this->load->view('deposit_view', $data);
    }

    public function withdraw() {

        if (!$this->auth->is_active)
            redirect('user/inactive');


        $this->load->model('withdraw_model');
        $data['withdraw'] = $this->withdraw_model->getWithdrawList($_SESSION['user_id']);
        $data['current'] = 'finance';
        $this->load->view('withdraw-view', $data);
    }

    public function paypal() {

        if (!$this->auth->is_active)
            redirect('user/inactive');


        $this->load->model('balance_model');
        $this->load->library('form_validation');


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('email', 'Paypal Email', 'required|xss_clean|valid_email');
            $this->form_validation->set_rules('amount', 'amount', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Please check following error(s)!';
            } else {


                $email = $this->input->post('email');
                $amount = $this->input->post('amount');


                $userData = $this->user_model->get_user_by_id($_SESSION['user_id']);

                if ($amount > $userData->balance) {
                    $this->session->set_flashdata('lessBalance', 'You have not enough balance to withdraw.');
                    redirect(base_url() . 'finance/paypal');
                } else {
                    $data = array(
                        'user_id' => $_SESSION['user_id'],
                        'status' => 'pending',
                        'amount' => $amount,
                        'method' => 'Paypal',
                        'details' => $email
                    );
                    $insert = $this->balance_model->addWithdraw($data);
                    if ($insert) {
                        $data = array(
                            'user_id' => $_SESSION['user_id'],
                            'amount' => $amount,
                            'type' => 'debit',
                            'description' => 'Withdraw request of ' . $amount . '$ (Request No : ' . $insert . ') '
                        );
                        $insert = $this->balance_model->addBalance($data);
                        if ($insert) {
                            $this->session->set_flashdata('success', 'Money Withdraw request sent successfully.');
                            redirect(base_url() . 'finance/withdraw');
                        } else {
                            $this->session->set_flashdata('fatal', 'Fatal Error! Database Not Found.');
                            redirect(base_url() . 'finance/paypal');
                        }
                    } else {
                        $this->session->set_flashdata('fatal', 'Fatal Error! Database Not Found.');
                        redirect(base_url() . 'finance/paypal');
                    }
                }
            }
        } else {

            $data['current'] = 'finance';
            $this->load->view('paypal-view', $data);
        }
    }

    public function wire_transfer() {

        if (!$this->auth->is_active)
            redirect('user/inactive');


        $this->load->model('balance_model');
        $this->load->library('form_validation');


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('amount', 'Amount', 'required|xss_clean');
            $this->form_validation->set_rules('account', 'Account Name', 'required|xss_clean');
            $this->form_validation->set_rules('swift', 'Bank Swift Code', 'required|xss_clean');
            $this->form_validation->set_rules('details', 'Bank details', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Please check following error(s)!';
            } else {


                $amount = $this->input->post('amount');
                $account = $this->input->post('account');
                $swift = $this->input->post('swift');
                $details = $this->input->post('account');

                $withdrawDetails = "<b>Account Name : </b>" . $account . "<br> <b>Bank Swift Code : </b>" . $swift . "<br> <b>Bank Address : </b>" . $details;

                $userData = $this->user_model->get_user_by_id($_SESSION['user_id']);

                if ($amount > $userData->balance) {
                    $this->session->set_flashdata('lessBalance', 'You have not enough balance to withdraw.');
                    redirect(base_url() . 'finance/wire_transfer');
                } else {
                    $data = array(
                        'user_id' => $_SESSION['user_id'],
                        'status' => 'pending',
                        'amount' => $amount,
                        'method' => 'Wire Transfer',
                        'details' => $withdrawDetails
                    );
                    $insert = $this->balance_model->addWithdraw($data);
                    if ($insert) {
                        $data = array(
                            'user_id' => $_SESSION['user_id'],
                            'amount' => $amount,
                            'type' => 'debit',
                            'description' => 'Withdraw request of ' . $amount . '$ (Request No : ' . $insert . ') '
                        );
                        $insert = $this->balance_model->addBalance($data);
                        if ($insert) {

                            $this->session->set_flashdata('success', 'Money Withdraw request sent successfully.');
                            redirect(base_url() . 'finance/withdraw');
                        } else {
                            $this->session->set_flashdata('fatal', 'Fatal Error! Database Not Found.');
                            redirect(base_url() . 'finance/wire_transfer');
                        }
                    } else {
                        $this->session->set_flashdata('fatal', 'Fatal Error! Database Not Found.');
                        redirect(base_url() . 'finance/wire_transfer');
                    }
                }
            }
        } else {

            $data['current'] = 'finance';
            $this->load->view('wire-transfer-view', $data);
        }
    }

}
