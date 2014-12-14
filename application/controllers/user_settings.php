<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function forgot_password() {

        if ($this->auth->logged_in) {
            redirect('user/dashboard/' . $_SESSION['user_name']);
        }

        $this->load->library('form_validation');
        $this->load->helper('function');

        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, cheque o(s) seguinte(s) erro(s)!';
            } else {
                $email = $this->input->post('email');
                $check_email = array(
                    'email' => $email
                );
                if ($user_data = $this->user_model->login_access($check_email)) {


                    $hash = md5(date(time()) . $email . $user_data->id);
                    $message = 'Cliqui neste link para alterar sua senha <a href="' . base_url() . 'user_settings/reset_password/' . $user_data->id . '/' . $hash . '">Alterar senha</a>';

                    $update_data = array(
                        'forgotPassword' => $hash
                    );

                    $update_user = $this->user_model->update_user('user', $update_data, $user_data->id);

                    if ($update_user) {
                        $subject = '';
                        $send_mail = send_email('admin@dwetech.com', $email, $message, $subject);
                        if ($send_mail) {
                            $data['send_mail'] = "";
                        }
                    } else {
                        $data['fatal'] = "Fatal Error!";
                    }
                } else {
                    $data['user'] = "Usuário inexistente";
                }
            }

            $this->load->view('forgot_password-view', $data);
        } else {
            $this->load->view('forgot_password-view');
        }
    }

    public function reset_password() {
        
        if ($this->auth->logged_in) {
            redirect('user/dashboard/' . $_SESSION['user_name']);
        }

        $this->load->library('form_validation');

        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('new', 'Nova senha', 'required|xss_clean');
            $this->form_validation->set_rules('con', 'Confirmar senha', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, cheque o(s) seguinte(s) erro(s)!';
            } else {
                $newPass = $this->input->post('new');
                $conPass = $this->input->post('con');
                $user_id = $this->input->post('user_id');
                if ($newPass == $conPass) {

                    $update_data = array(
                        'password' => hash('sha256', $conPass)
                    );

                    $update_user = $this->user_model->update_user('user', $update_data, $user_id);
                    if ($update_user) {
                        $remove_data = array(
                            'forgotPassword' => ''
                        );

                        $remove_user = $this->user_model->update_user('user', $remove_data, $user_id);
                        if ($remove_user) {
                            redirect(base_url() . 'login');
                        } else {
                            $data['fatal'] = 'Fatal Error!';
                        }
                    } else {
                        $data['fatal'] = 'Fatal Error!';
                    }
                } else {
                    $data['match'] = 'Por favor, cheque o(s) seguinte(s) erro(s)!';
                }
            }
            $this->load->view('reset_password_view', $data);
        } else {
            $user_id = $this->uri->segment(3);
            $forgotPassword = $this->uri->segment(4);

            empty($user_id) || empty($forgotPassword) ? redirect(base_url()) : '';

            $user_array = array(
                'id' => $user_id
            );
            $user_data = $this->user_model->login_access($user_array);

            if (!empty($user_data)) {
                if ($forgotPassword == $user_data->forgotPassword) {
                    $data['user_id'] = $user_id;
                    $this->load->view('reset_password_view', $data);
                } else {
                    redirect(base_url());
                }
            } else {
                redirect(base_url());
            }
        }
    }

}
