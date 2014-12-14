<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $this->load->model('admin_model');
        $this->load->library('form_validation');

        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {


            $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|min_length[6]');


            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, verifique o seguinte erro(s)!';
            } else {
                $email = $this->input->post('email');
                $password = $this->input->post('password');


//                $remember_me = $this->input->post('remember_me');
//                $remember = $remember_me == 'on' ? true : false;



                $data['user'] = $this->user_model->admin_login_access(array('email' => $email));

                if (!$data['user']) {
                    $data['error'] = "E-mail não encontrado!";
                } else {

                    if ($this->auth->AdminLogin($email, $password)) {

                        redirect(base_url().'admin');
                    } else {
                        $data['error'] = "E-mail ou senha incorretos!";
                    }
                }
            }
        }

        $this->load->view('admin/login_view');
    }
}