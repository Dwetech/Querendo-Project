<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    //product view page
    public function view($user_name) {

        //Getting user data
        $data['user'] = $this->user_model->get_user_auth_data(array('user_name' => $user_name));

        if ($data['user'] === FALSE)//if user not found
            redirect('/');


        //Function from function helper is used inside view
        $this->load->helper('function_helper');

        //Getting user review
        $data['review'] = $this->user_model->getAllReviewWithProduct($data['user']->id);

        if ($this->uri->segment(4)) {
            $data['completeWork'] = $this->user_model->completeWorkBuyer($data['user']->id);
            $data['work_count'] = $this->user_model->count_completeWork_by_buyer($data['user']->id);

            $data['runningWork'] = $this->user_model->runningWorkBuyer($data['user']->id);
            $data['runningWork_count'] = $this->user_model->count_runningWorkBuyer($data['user']->id);

            $data['userCat'] = "buyer";
        } else {
            $data['completeWork'] = $this->user_model->completeWorkSeller($data['user']->id);
            $data['work_count'] = $this->user_model->count_completeWork_by_seller($data['user']->id);

            $data['runningWork'] = $this->user_model->runningWorkSeller($data['user']->id);
            $data['runningWork_count'] = $this->user_model->count_runningWorkSeller($data['user']->id);

            $data['bidOn'] = $this->user_model->currentBidOn($data['user']->id);
            $data['bidOn_count'] = $this->user_model->count_currentBidOn($data['user']->id);

            $data['userCat'] = "seller";
        }

        $data['current'] = 'profile';
        $this->load->view('user-details-view', $data);
    }

    //user profile update page
    public function settings() {
        
        if (!$this->auth->logged_in)
            redirect('login');

        $this->load->helper('function_helper');
        $user_name = $_SESSION['user_name'];

        $this->load->model(array('timezones_model', 'country_model'));
        $data['country'] = $this->country_model->get_countries();
        $data['user'] = $this->user_model->get_user_data(array('user.user_name' => $user_name));

        if ($data['user'] === false)
            redirect('/');

        $data['timezones'] = $this->timezones_model->get_timezones();

        if (isset($_POST['submit']) && trim($_POST['submit'] == 'Submit')) {

            $this->load->library('form_validation');

            $this->form_validation->set_rules('first_name', 'Nome', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('last_name', 'Sobrenome', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('contact_address', 'Endereço de contato', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('shipping_address', 'Endereço do cobrança', 'xss_clean|strip_tags');
            $this->form_validation->set_rules('city', 'Cidade', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('state', 'Estado', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('postal_code', 'Código postal', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('country', 'País', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('company', 'Empresa', 'xss_clean|strip_tags');
            $this->form_validation->set_rules('time_zone', 'Fuso horário', 'xss_clean|strip_tags');
            $this->form_validation->set_rules('about', 'Sobre mim', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('contact_number', 'Telefone de contato', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('fax', 'Fax', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('profile_pic', 'Imagem', 'required|trim|xss_clean|strip_tags');


            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, cheque o(s) seguinte(s) erro(s)!';
            } else {

                $update_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'contact_address' => $this->input->post('contact_address'),
                    'shipping_address' => $this->input->post('shipping_address'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'postal_code' => $this->input->post('postal_code'),
                    'country' => $this->input->post('country'),
                    'company' => $this->input->post('company'),
                    'timezone' => $this->input->post('time_zone'),
                    'about' => $this->input->post('about'),
                    'contact_number' => $this->input->post('contact_number'),
                    'fax' => $this->input->post('fax')
                );

                $result = $this->user_model->updateUserDataByUserId($_SESSION['user_id'], $update_data);
                if ($result) {
                    $data['success'] = 'Perfil atualizado com sucesso!';
                } else {
                    $data['error'] = 'Ocorreu um erro! Por favor, tente novamente.';
                }

                //Uploading profile photo
                if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) {

                    $dir = 'upload/profile_photo/';
                    $file_name = random_string('alnum', 8);

                    $config['file_name'] = $file_name . '.jpg';
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '2048';

                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;

                    if ($this->upload->do_upload()) {


                        /**                         * ******* */
                        //Resizing image
                        /**                         * ******* */
                        $image_heightWidth = getimagesize($_FILES['userfile']['tmp_name']);
                        if ($image_heightWidth[0] < $image_heightWidth[1]) {
                            $leftover_y_start = (($image_heightWidth[1] - $image_heightWidth[0]) / 2);
                            $height = ($image_heightWidth[1] - ($leftover_y_start * 2));
                            $leftover_x_start = 0;
                            $width = $image_heightWidth[0];
                        } else {
                            $leftover_x_start = (($image_heightWidth[0] - $image_heightWidth[1]) / 2);
                            $width = ($image_heightWidth[0] - ($leftover_x_start * 2));
                            $leftover_y_start = 0;
                            $height = $image_heightWidth[1];
                        }

                        /* resizing image */
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $dir . $file_name . '.jpg';
                        $config['new_image'] = $dir . $file_name . '.jpg';
                        $config['maintain_ratio'] = TRUE;
                        $config['overwrite'] = TRUE;
                        $config['quality'] = '80%';
                        $config['width'] = 650;
                        $config['height'] = 600;
                        
                        /* ini_set('gd.jpeg_ignore_warning', 1); */
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($config);
                        
                        if ($this->image_lib->resize()) {
                            
                            
                            $this->image_lib->clear();

                            /* creating thumbnail image */
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $dir . $file_name . '.jpg';
                            $config['new_image'] = $dir . 'thumb/thumb_' . $file_name . '.jpg';
                            $config['maintain_ratio'] = FALSE;
                            $config['quality'] = '80%';
                            $config['width'] = 200;
                            $config['height'] = 200;
                            /* ini_set('gd.jpeg_ignore_warning', 1); */
                            $this->image_lib->initialize($config);
                            
                            
                            if ($this->image_lib->resize()) {
                                
                                $this->image_lib->clear();
                            }
                        }
                        /* ================= */


                        if (is_dir($dir . $data['user']->profile_pic) && file_exists($dir . $data['user']->profile_pic))
                            @unlink($dir . $data['user']->profile_pic);
                        if (is_dir($dir . 'thumb/thumb_' . $data['user']->profile_pic) && file_exists($dir . 'thumb/thumb_' . $data['user']->profile_pic))
                            @unlink($dir . 'thumb/thumb_' . $data['user']->profile_pic);

                        $profile_pic = array(
                            'profile_pic' => $config['file_name']
                        );
                        $result = $this->user_model->updateUserDataByUserId($_SESSION['user_id'], $profile_pic);
                        if ($result) {
                            $data['success'] = 'Profile updated successfully!';
                        } else {
                            $data['error'] = 'Some error occured! Please try again.';
                        }
                    } else {
                        $data['error'] = $this->upload->display_errors();
                    }
                }
            }
        }
        $data['user'] = $this->user_model->get_user_data(array('user.user_name' => $user_name));
        $data['current'] = '';
        $this->load->view('user-settings-view', $data);
    }

    //page for bidding product
    function bids() {

        if (!$this->auth->logged_in)
            redirect('login');

        $this->load->model(array('country_model', 'product_model', 'bids_model'));

        $data['country'] = $this->country_model->get_country_by_user($_SESSION['user_id']);

        $condition = '';
        $data['filter'] = isset($_POST['status']) ? $_POST['status'] : '';
        $where = array();

        if (isset($_POST['submit']) && trim($_POST['submit'] == 'Submit')) {

            if ($_POST['status'] == 'All') {

                $condition = '';
                $where = array();
            } else {

                $condition = 'AND bids.status = "' . $_POST['status'] . '"'; //Condition for count query
                $where = array(
                    'bids.status' => $_POST['status']
                ); //Condition for getting data query
            }
        }

        /* Pagination */
        $this->load->library('pagination');
        $data['count'] = $this->bids_model->count_bids($_SESSION['user_id'], $condition);
        $config['base_url'] = base_url() . 'user/bids/';
        $config['total_rows'] = $data['count']->numrows;
        $config['uri_segment'] = 3;
        $config['per_page'] = 15;
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


        //Getting data
        $data['bids'] = $this->bids_model->get_bids_by_user($_SESSION['user_id'], $where, $config['per_page'], $offset);

        $data['current'] = 'bidList';
        $this->load->view('user-bids-view', $data);
    }

    public function dashboard() {

        if (!$this->auth->logged_in)
            redirect('login');

        $this->load->model('product_model');
        $data['user_news'] = $this->product_model->get_user_activities($_SESSION['user_id']);
        $data['giveReview'] = $this->product_model->getProductByReview($_SESSION['user_id']);
        $data['profile_complete'] = $this->user_model->check_profile_complete($_SESSION['user_id']);

        $data['current'] = 'dashboard';
        $this->load->view('user-dashboard-view', $data);
    }

    public function product() {

        if (!$this->auth->logged_in)
            redirect('login');
        
        $this->load->model(array('product_model', 'bids_model'));

        /* Pagination */
        $this->load->library('pagination');
        $data['count'] = $this->product_model->count_products_by_user($_SESSION['user_id']);
        $config['base_url'] = base_url() . 'user/product/';
        $config['total_rows'] = $data['count'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 15;
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
        
        $data['products'] = $this->product_model->get_products_by_user($_SESSION['user_id'], $config['per_page'], $offset);

        $data['current'] = 'myProduct';
        $this->load->view('user-product-view', $data);
    }

    /**
     * getting user details by user_name
     * ------------------------------------
     * json format data will be returned and 
     * is intended to use like api call
     */
    function get_user_data() {
        
        if (!$this->auth->logged_in)
            redirect('login');

        $user_name = $this->input->post('user_name');
        if ($user_name != $_SESSION['user_name'])
            return false;

        $credentials = array(
            'email_verify' => 1,
            'user_name' => $_SESSION['user_name']
        );
        $user_data = $this->user_model->get_user_auth_data($credentials);
        if ($user_data === false)
            return false;

        echo json_encode($user_data);
    }

    /**
     * updating user data by user_name
     * -----------------------------------
     * this is intended to use like api call
     */
    function update_user_data() {
        
        if (!$this->auth->logged_in)
            redirect('login');
        
        
        $user_about = $this->input->post('about');
        $user_name = $this->input->post('user_name');

        if ($_SESSION['user_name'] != $user_name)
            return false;

        $update_data = array(
            'about' => $user_about
        );
        $result = $this->user_model->update_an_user($_SESSION['user_id'], $update_data);
        if ($result === true)
            echo 1;
        else
            echo 0;
    }

    function inactive() {
        $data['current'] = '';
        $this->load->view('inactive_user_view', $data);
    }

    function crop_image($image_name) {

        $this->load->helper('function_helper');
        image_resize($image_name);
    }

}
