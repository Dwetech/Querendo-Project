<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Website_settings extends CI_Controller{

    public function __construct() {
        parent::__construct();

        if (!$this->auth->checkAdminLogin()) {
            redirect(base_url().'admin/login');

        }

    }

    function index(){
        $data['settings'] = $this->settings_model->getAllSettings('website');
        $data['page'] = 'webSettings';
        $this->load->view('admin/settings_view' , $data);
    }

    function edit(){

        $this->load->library('form_validation');



            $this->form_validation->set_rules('website_name', 'Website Name', 'required|xss_clean');
            $this->form_validation->set_rules('website_email', 'Website Email', 'required|xss_clean|valid_email');
            $this->form_validation->set_rules('fee_percent', 'Fee Percent', 'required|xss_clean');
            $this->form_validation->set_rules('paypal_email', 'Paypal Email', 'required|xss_clean|valid_email');


            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Please check following error(s)!';
            } else {
                $keyword = $this->input->post('keyword');
                $description = $this->input->post('description');
                $website_email = $this->input->post('website_email');
                $website_name = $this->input->post('website_name');
                $copyright = $this->input->post('copyright');
                $paypal_email = $this->input->post('paypal_email');
                $fee_percent = $this->input->post('fee_percent');

                if (!$this->settings_model->change_website_settings($keyword, $description, $website_name, $website_email, $copyright, $paypal_email,$fee_percent)) {
                    $this->session->set_flashdata('updateError', '');
                    redirect(base_url().'admin/website_settings');
                } else {
                    $this->session->set_flashdata('success', 'Website settings updated successfully');
                    redirect(base_url().'admin/website_settings');
                }
            }


            $data['page'] = 'webSettings';
            $this->load->view('admin/edit_settings_view' , $data);
    }
}