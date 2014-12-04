<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Settings extends CI_Controller{

    public function __construct() {
        parent::__construct();

        if (!$this->auth->checkAdminLogin()) {
            redirect(base_url().'admin/login');

        }

    }

    function index(){
        $this->load->model('admin_model');
        $data['admin_data'] = $this->admin_model->getAdminData($_SESSION['admin_user_id']);
        $data['page'] = '';
        $this->load->view('admin/admin_settings_view' , $data);
    }

    function change_password(){
        $this->load->model('admin_model');
        $this->load->library('form_validation');


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {
            $this->form_validation->set_rules('oldPass', 'Current Password', 'required|xss_clean');
            $this->form_validation->set_rules('newPass', 'New Password', 'required|xss_clean');
            $this->form_validation->set_rules('conPass', 'Confirm Password', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, cheque o(s) erro(s)!';
            } else {

                $oldPass = $this->input->post('oldPass');
                $newPass = $this->input->post('newPass');
                $conPass = $this->input->post('conPass');

                if($newPass == $conPass){

                    $encrCurrentPass = hash("sha256", $oldPass);
                    $encrConPass = hash("sha256", $conPass);

                    $admin_data = $this->admin_model->getAdminData($_SESSION['admin_user_id']);
                    if($admin_data->password == $encrCurrentPass){
                        $update_data = array(
                            'password' => $encrConPass
                        );
                        $changePassword = $this->admin_model->changePassword($update_data,$_SESSION['admin_user_id']);
                        if(!$changePassword){
                            $this->session->set_flashdata('equalError', 'Confirm New password correctly.');
                            redirect(base_url().'admin/settings/change_password');
                        } else {
                            $this->session->set_flashdata('success', 'Password changed successfully.');
                            redirect(base_url().'admin/settings');
                        }

                    } else {
                        $this->session->set_flashdata('equalError', 'Confirm New password correctly.');
                        redirect(base_url().'admin/settings/change_password');
                    }

                } else{
                    $this->session->set_flashdata('equalError', 'Confirm New password correctly.');
                    redirect(base_url().'admin/settings/change_password');
                }
            }

        } else {

        }

        $data['page'] = '';
        $this->load->view('admin/change_password_view' , $data);
    }

}