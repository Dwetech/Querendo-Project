<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/7/14
 * Time: 1:16 PM
 */
class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        if ($this->auth->logged_in) {
            redirect('user/dashboard/' . $_SESSION['user_name']);
        }

        $this->load->library(array('form_validation', 'parser'));
        $this->load->helper(array('string', 'function'));

        if (isset($_POST['submit']) && trim($_POST['submit'])) {

            $this->form_validation->set_message('is_unique', 'Este %s já está registrado!');

            $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|is_unique[user.email]|valid_email');
            $this->form_validation->set_rules('username', 'Username', 'required|xss_clean|is_unique[user.user_name]|min_length[3]|max_length[20]|alpha_dash');
            $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|min_length[6]');
            $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|xss_clean|min_length[6]|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, corrija os seguintes erros!';
            } else {
                $email = $this->input->post('email');
                $user_name = $this->input->post('username');
                $password = $this->input->post('password');
                $verification_code = random_string('alnum', 7);

                $result = $this->user_model->user_registration($user_name, $password, $email, $verification_code);

                if ($result === FALSE) {
                    $data['error'] = 'Ocorreu um problema ao enviar seus dados! Por favor, tente novamente.';
                } else {
                    $message = 'Clique neste link para ativar sua conta <a href="' . base_url() . 'signup/activate_account/' . $verification_code . '">Ativar conta</a>';
                    send_email('noreply@querendo.com.br', $email, $message, 'Ative sua conta');


                    $flashdata = array(
                        'success' => 'Parabéns! Seu cadastro está completo!',
                        'message' => 'Nós o enviamos um link para seu endereço de e-mail. Cheque seu e-mail e clique no link para ativar sua conta.',
                        'login' => false
                    );
                    $this->session->set_flashdata($flashdata);
                    redirect('signup/success');
                }
            }
            $this->load->view('signup-view', $data);
        } else {
            $this->load->view('signup-view');
        }
    }

    //activating new account
    function activate_account() {

        if ($this->auth->logged_in) {
            redirect('user/dashboard/' . $_SESSION['user_name']);
        }


        $key = $this->uri->segment('3');
        $data = $this->user_model->get_user_by_key($key);

        if ($data === FALSE) {
            $flashdata = array(
                'error' => 'Chave inválida!',
                'message' => 'Chave inválida ou já utilizada! Chave de ativação incorreta. Por favor, tente novamente.',
                'login' => FALSE
            );

            $this->session->set_flashdata($flashdata);
            redirect('signup/success');
        }

        $update_data = array(
            'email_verify' => '1'
        );
        $result = $this->user_model->update_an_user($data->id, $update_data);
        if ($result === FALSE) {
            $data['error'] = 'Falha ao ativar conta! Por favor, tente novamente.';
        } else {
            $flashdata = array(
                'success' => 'Sua conta foi ativada com sucesso!',
                'message' => 'Felicidades amigo! Estamos felizes em ter você conosco. Esperamos que se divirta. Divirta-se! Agora você pode <a href="' . base_url() . 'login">Entrar</a>',
                'login' => true
            );
            $this->session->set_flashdata($flashdata);
            redirect('signup/success');
        }
    }

    function success() {
        $this->load->view('success_view');
    }

}
