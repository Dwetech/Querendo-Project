<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Withdraw extends CI_Controller
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

        $this->load->model('withdraw_model');

        $data['withdraw'] = $this->withdraw_model->getAllWithdraw();

        $data['page'] = 'withdraw';
        $this->load->view('admin/withdraw_view', $data);
    }

    function change_status($status, $withdraw_id)
    {

        $this->load->model(array('withdraw_model', 'balance_model'));

        if (!$status || !$withdraw_id) {
            redirect(base_url() . 'admin/withdraw');
        }

        if (!$this->withdraw_model->existWithdraw($withdraw_id)) {
            redirect(base_url() . 'admin/withdraw');
        } else {

            if ($status == "cancel") {

                $data = array(
                    'status' => $status
                );
                $updateWithdrawStatus = $this->withdraw_model->updateWithdrawStatus($withdraw_id, $data);
                if (!$updateWithdrawStatus) {
                    $this->session->set_flashdata('fatal', 'Fatal Error! Database Not Found');
                    redirect(base_url() . 'admin/withdraw');
                } else {
                    $withdrawData = $this->withdraw_model->getWithdrawData($withdraw_id);
                    $data = array(
                        'user_id' => $withdrawData->user_id,
                        'amount' => $withdrawData->amount,
                        'type' => 'credit',
                        'description' => 'Withdraw cancellation refund (cancelled Withdraw ID : ' . $withdraw_id . ') '
                    );
                    $insert = $this->balance_model->addBalance($data);
                    if (!$insert) {
                        $this->session->set_flashdata('fatal', 'Fatal Error! Database Not Found');
                        redirect(base_url() . 'admin/withdraw');
                    } else {
                        $this->session->set_flashdata('success', 'Withdraw request successfully changed.');
                        redirect(base_url() . 'admin/withdraw');
                    }
                }


            } else {
                $data = array(
                    'status' => $status
                );
                $updateWithdrawStatus = $this->withdraw_model->updateWithdrawStatus($withdraw_id, $data);
                if (!$updateWithdrawStatus) {
                    $this->session->set_flashdata('fatal', 'Fatal Error! Database Not Found');
                    redirect(base_url() . 'admin/withdraw');
                } else {
                    $this->session->set_flashdata('success', 'Withdraw request successfully changed.');
                    redirect(base_url() . 'admin/withdraw');
                }
            }
        }


    }

}