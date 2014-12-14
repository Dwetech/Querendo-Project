<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/6/14
 * Time: 6:38 PM
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        if ($this->auth->logged_in) {
            redirect('user/dashboard/' . $_SESSION['user_name']);
        }

        $this->load->model('user_model');
        $this->load->library('form_validation');

        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|min_length[6]');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, verifique os seguintes erros!';
            }
            else {
                $username = $this->input->post('email');
                $password = $this->input->post('password');
                $remember_me = $this->input->post('remember_me');
                $remember = $remember_me == 'on' ? true : false;

                $data['user'] = $this->user_model->login_access(array('email' => $username));
                if (!$data['user']) {
                    $data['error'] = "E-mail não encontrado!";
                }
                else {
                    if ($data['user']->email_verify != '1') {
                        $data['error'] = 'Seu e-mail ainda não foi ativado! <a href="' . base_url() . 'login/resend_verification_email/' . $data['user']->email_verify . '/' . urlencode($data['user']->email) . '">Reenviar</a> verificação de e-mail?';
                    }
                    else {
                        if ($this->auth->login($username, $password, $remember)) {

                            redirect('user/dashboard/' . $_SESSION['user_name']);
                        }
                        else {
                            $data['error'] = "E-mail ou senha incorretos!";
                        }
                    }
                }
            }
            $this->load->view('login-view', $data);
        }
        else {

            $this->load->view('login-view');
        }
    }

    public function logout() {
        $this->auth->logout();
    }

    function resend_verification_email($verification_code, $email) {
        $this->load->helper('function');
        $message = 'Clique aqui para ativar sua conta <a href="' . base_url() . 'signup/activate_account/' . $verification_code . '">Ativar conta</a>';


        send_email('noreply@querendo.com.br', urldecode($email), $message, 'Ative sua conta');
        $flashdata = array(
            'success' => 'Nós lhe enviamos um e-mail de verificação!',
            'message' => 'Você deve receber um e-mail contendo um link, por favor, clique neste link para ativar sua conta!',
            'login' => false
        );
        $this->session->set_flashdata($flashdata);
        redirect('signup/success');
    }

}
