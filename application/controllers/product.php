<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('product_model');
    }

    /**
     * View product details
     * @param int $product_id
     */
    public function view($product_id) {

        if (!$this->product_model->isExist($product_id))
            redirect(base_url());
        if (!$this->product_model->isActive($product_id))
            redirect(base_url());


        $this->load->helper(array('date', 'function_helper'));
        $this->load->model(array('country_model', 'bids_model', 'invoice_model'));


        //Getting invoice details if it is made already
        $data['invoice_data'] = $this->invoice_model->check_invoice_by_product_id($product_id);
        //Getting product details
        $data['product_data'] = $this->product_model->getTotalProductData($product_id);
        //Getting bid count, bid amoun average
        $data['bid_details'] = $this->bids_model->get_product_bid_count_and_average($product_id);
        //Getting bid details
        $data['bids'] = $this->bids_model->get_all_bids_by_product_id($product_id);
        /* $data['milestone_sum'] = $this->milestone_model->sum_milestone_by_product_id($product_id);
          $data['released_milestone_sum'] = $this->milestone_model->sum_released_milestone_by_product_id($product_id); */
        $condition = array(
            'product_id' => $product_id,
            'status' => 'Completed'
        );
        $data['awarded_bid'] = $this->bids_model->get_awarded_bid_details($condition);

        if ($this->auth->logged_in) {

            $credentials = array(
                'product_id' => $product_id,
                'user_id' => $_SESSION['user_id'],
                'status' => 'Completed'
            );
            $data['bid_status'] = $this->bids_model->check_bid_status_by_user($credentials);
            //print_r($data['bid_status']);return;
            $condition = array(
                'product_id' => $product_id,
                'user_id' => $_SESSION['user_id']
            );
            $data['my_bid'] = $this->bids_model->check_bid_status_by_user($condition);
        }


        $data['current'] = '';
        $this->load->view('product-details-view', $data);
    }

    /**
     * Updating product 
     */
    public function update_product_transaction_status($status, $product_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        if (!$this->product_model->isExist($product_id))
            redirect(base_url());
        if (!$this->product_model->isActive($product_id))
            redirect(base_url());


        $product_data = $this->product_model->get_product_bid_by_product_id($product_id);
        $this->load->helper('function');


        if ($status == 'payment_sent' || $status == 'product_received') {

            //Checking user eligibility 
            $product_credentials = array(
                'user_id' => $_SESSION['user_id'],
                'product_id' => $product_id,
                'status' => 'awarded'
            );
            $data['check_product'] = $this->product_model->check_product_data($product_credentials);
            //if logged in user is the product owner
            if ($data['check_product']) {
                $update_data = array(
                    'transaction_status' => $status
                );
                $update_status = $this->product_model->update_product_transaction_status($product_id, $update_data);
                if (!$update_status)
                    $this->session->set_flashdata('error', 'Transaction status update failed!');
                else {


                    //Sending email
                    if ($status == 'payment_sent') {
                        $sent_status = 'sent you a payment for the';
                        $subject = 'Payment Sent';
                    } else if ($status == 'product_received') {
                        $sent_status = 'received your';
                        $subject = 'Product Received';
                    }
                    $toData = $this->user_model->get_user_by_id($product_data->bid_user_id);
                    $message = $_SESSION['user_name'] . ' has ' . $sent_status . ' product <a href="' . base_url() . 'product/view/' . $product_id . '">' . $product_data->name . '</a>';
                    send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);


                    if ($status == 'product_received') {
                        $this->complete($product_id);
                        return;
                    }
                }
            }
        }



        if ($status == 'payment_received' || $status == 'product_sent') {

            $this->load->model('bids_model');
            $bid_credentials = array(
                'product_id' => $product_id,
                'user_id' => $_SESSION['user_id'],
                'status' => 'Awarded'
            );
            $data['bid_status'] = $this->bids_model->check_bid_status_by_user($bid_credentials);
            //if logged in user is the bid owner
            if ($data['bid_status']) {
                $update_data = array(
                    'transaction_status' => $status
                );
                $update_status = $this->product_model->update_product_transaction_status($product_id, $update_data);
                if (!$update_status)
                    $this->session->set_flashdata('error', 'Transaction status update failed!');
                else {

                    //Sending email
                    if ($status == 'payment_received') {
                        $sent_status = 'received your payment for the';
                        $subject = 'Payment Received';
                    } else if ($status == 'product_sent') {
                        $sent_status = 'sent your desired';
                        $subject = 'Product Sent';
                    }
                    $toData = $this->user_model->get_user_by_id($product_data->bid_user_id);
                    $message = $_SESSION['user_name'] . ' has ' . $sent_status . ' product <a href="' . base_url() . 'product/view/' . $product_id . '">' . $product_data->name . '</a>';
                    send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);
                }
            }
        }


        redirect(base_url('product/view/' . $product_id));
    }

    /*
     * Posting a new product
     */

    public function create() {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');

        $this->load->model('category_model');
        $this->load->library('form_validation');
        $data['categories'] = $this->category_model->generateCategories(0);
        $data['select'] = $this->generate_category_recursive($data['categories']);

        $data['cat_id'] = $this->uri->segment('3');
        if ($data['cat_id'] && $data['cat_id'] != 0) {

            $cat_id = $this->category_model->check_category_id($this->uri->segment('3'));
            if ($cat_id === False) {
                redirect(base_url() . 'product/create');
            }
        }

        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('name', 'Nome do produto', 'required|xss_clean|strip_tags');
            if (!$data['cat_id'])
                $this->form_validation->set_rules('category', 'Categoria do produto', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('details', 'Detalhes do produto', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('budget', 'Orçamento', 'required|xss_clean|numeric|strip_tags|max_length[7]');
            $this->form_validation->set_rules('shipping_method', 'Método de envio', 'xss_clean|strip_tags');
            $this->form_validation->set_rules('shipping_cost', 'Custo de envio', 'xss_clean|numeric|strip_tags');
            $this->form_validation->set_rules('product_condition', 'Condição do produto', 'required|xss_clean|strip_tags');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, corrija o(s) erro(s) abaixo!';
            } else {

                $name = $this->input->post('name');
                $category = $data['cat_id'] ? $data['cat_id'] : $this->input->post('category');
                $details = $this->input->post('details');
                $budget = $this->input->post('budget');
                $shipping_method = $this->input->post('shipping_method');
                $shipping_cost = $this->input->post('shipping_cost');
                $product_condition = $this->input->post('product_condition');


                $product_data = array(
                    'user_id' => $_SESSION['user_id'],
                    'name' => $name,
                    'category_id' => $category,
                    'description' => $details,
                    'shipping_method' => $shipping_method,
                    'shipping_cost' => $shipping_cost,
                    'product_condition' => $product_condition,
                    'budget_type' => 'fixed',
                    'fixed_budget' => $budget,
                );

                if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) {

                    $file_name = random_string('alnum', 8);

                    $dir = 'upload/product_photo/';
                    $config['file_name'] = $file_name . '.jpg';
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '5120';

                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;

                    if ($this->upload->do_upload()) {

                        $product_data['product_photo'] = $config['file_name'];
                    } else {
                        $data['error'] = $this->upload->display_errors();
                    }
                }//end of file upload
                //insert data
                $insert_product = $this->product_model->insert_product('product', $product_data);
                if ($insert_product) {
                    $this->create_product_category_list($insert_product, $category);
                    redirect(base_url() . 'product/view/' . $insert_product);
                } else {
                    $data['fatal'] = 'fatal error!';
                }
            }
            //if error is exist
            if (array_key_exists('error', $data)) {
                $this->load->view('product-create-view', $data);
            }
        } else {
            $this->load->view('product-create-view', $data);
        }
    }

    /**
     * Editing a posted product details
     * @param int $product_id
     */
    public function edit($product_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');

        if (!$this->product_model->isExist($product_id))
            redirect(base_url());
        if (!$this->product_model->isActive($product_id))
            redirect(base_url());

        $this->load->model('category_model');
        $this->load->library('form_validation');
        $data['product'] = $this->product_model->getProductData($product_id);
        $data['categories'] = $this->category_model->generateCategories(0);
        $category = $this->category_model->getSingleCategory($data['product']->category_id);
        $data['select'] = $this->generate_category_recursive($data['categories'], $category->cat_id);



        //Checking user eligibility 
        $credentials = array(
            'user_id' => $_SESSION['user_id'],
            'product_id' => $product_id,
            'status' => 'running'
        );
        $check_product = $this->product_model->check_product_data($credentials);
        if (!$check_product)
            redirect('product/view/' . $product_id);



        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('name', 'Nome do produto', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('category', 'Categoria do produto', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('details', 'Detalhes do produto', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('budget', 'Orçamento', 'required|numeric|xss_clean|strip_tags|max_length[7]');
            $this->form_validation->set_rules('shipping_method', 'Método de envio',  'xss_clean|strip_tags');
            $this->form_validation->set_rules('shipping_cost', 'Custo de envio', 'xss_clean|numeric|strip_tags');
            $this->form_validation->set_rules('product_condition', 'Condição do produto', 'required|xss_clean|strip_tags');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Por favor, corrija o(s) erro(s) abaixo!';
            } else {

                $name = $this->input->post('name');
                $category = $this->input->post('category');
                $details = $this->input->post('details');
                $budget = $this->input->post('budget');
                $shipping_method = $this->input->post('shipping_method');
                $shipping_cost = $this->input->post('shipping_cost');
                $product_condition = $this->input->post('product_condition');


                $product_data = array(
                    'name' => $name,
                    'category_id' => $category,
                    'description' => $details,
                    'shipping_method' => $shipping_method,
                    'shipping_cost' => $shipping_cost,
                    'product_condition' => $product_condition,
                    'budget_type' => 'fixed',
                    'fixed_budget' => $budget,
                );

                if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) {

                    $file_name = random_string('alnum', 8);

                    $dir = 'upload/product_photo/';
                    $config['file_name'] = $file_name . '.jpg';
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '5120';

                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;

                    if ($this->upload->do_upload()) {

                        @unlink($dir . $data['product']->product_photo);
                        $product_data['product_photo'] = $config['file_name'];
                    } else {
                        $data['error'] = $this->upload->display_errors();
                    }
                }//end of file upload
                //insert data
                $update_product = $this->product_model->update_product($product_data, $product_id);
                if ($update_product) {
                    $this->create_product_category_list($product_id, $category);
                    redirect(base_url() . 'product/view/' . $product_id);
                } else {
                    $data['fatal'] = 'fatal error!';
                }
            }
            if (array_key_exists('error', $data)) {
                $this->load->view('product-edit-view', $data);
            }
        } else {
            $this->load->view('product-edit-view', $data);
        }
    }

    //deleting a product
    function delete($product_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        if (!$this->product_model->isExist($product_id))
            redirect(base_url());
        if (!$this->product_model->isActive($product_id))
            redirect(base_url());



        //Checking user eligibility 
        $credentials = array(
            'user_id' => $_SESSION['user_id'],
            'product_id' => $product_id,
            'status' => 'running'
        );
        $check_product = $this->product_model->check_product_data($credentials);
        if (!$check_product)
            redirect('product/view/' . $product_id);



        $this->load->model('bids_model');

        //getting all bids of a single product
        $bid_data = $this->bids_model->get_bids_by_product_id($product_id);
        //deleting all bids of a product
        foreach ($bid_data as $bid) {
            $this->bids_model->delete_bid(array('id' => $bid->id));
            @unlink('upload/bid_photo/' . $bid->product_image);
        }

        //deleting product details
        if ($this->product_model->remove_product($product_id)) {
            @unlink('upload/product_photo/' . $check_product->product_photo);
            redirect('/');
        } else {
            $this->session->set_flashdata('error', 'Product delete failed! Please try again.');
            redirect('product/view/' . $product_id);
        }
    }

    //completing a product/project
    function complete($product_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        if (!$this->product_model->isExist($product_id))
            redirect(base_url());
        if (!$this->product_model->isActive($product_id))
            redirect(base_url());


        //Checking user eligibility 
        $credentials = array(
            'user_id' => $_SESSION['user_id'],
            'product_id' => $product_id,
            'status' => 'awarded'
        );
        $check_product = $this->product_model->check_product_data($credentials);
        if (!$check_product)
            redirect('product/view/' . $product_id);


        $this->load->model('bids_model');
        $credential = array(
            'product_id' => $product_id,
            'status' => 'Awarded'
        );
        $bid_data = $this->bids_model->check_bid_status_by_user($credential);


        //Checking bidder's status
        $where = array(
            'id' => $bid_data->user_id,
        );
        $value['data'] = $this->user_model->login_access($where);
        if ($value['data'] && $value['data']->status != '1')
            redirect('product/view/' . $product_id);


        /* //Checking whether released payment is greater than wanted payment
          $data['released_milestone_sum'] = $this->milestone_model->sum_released_milestone_by_product_id($product_id);
          if ($data['released_milestone_sum']->released_milestone_amount < $bid_data->bid_amount) {
          redirect('product/view/' . $product_id);
          } */




        $update_data = array(
            'status' => 'completed'
        );
        //deleting product details
        if ($this->product_model->update_product($update_data, $product_id) && $this->bids_model->update_bid($bid_data->id, $update_data)) {
            $this->generate_invoice($product_id);
            redirect('product/view/' . $product_id);
        } else {
            $this->session->set_flashdata('error', 'Product update failed! Please try again.');
            redirect('product/view/' . $product_id);
        }
    }

    public function generate_invoice($product_id) {


        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        if (!$this->product_model->isExist($product_id))
            redirect(base_url());
        if (!$this->product_model->isActive($product_id))
            redirect(base_url());


        /**
         * Checking that whether the logged_in user is product owner
         * and the product status is completed
         */
        $product_credentials = array(
            'user_id' => $_SESSION['user_id'],
            'product_id' => $product_id,
            'status' => 'completed'
        );
        $data['check_product'] = $this->product_model->check_product_data($product_credentials);
        if (!$data['check_product'])
            return false;


        /**
         * Checking that whether the bid status is completed
         * of the given product_id
         */
        $this->load->model('bids_model');
        $bid_credentials = array(
            'product_id' => $product_id,
            'status' => 'Completed'
        );
        $data['bid_status'] = $this->bids_model->check_bid_status_by_user($bid_credentials);
        if (!$data['bid_status'])
            return false;



        /**
         * Checking whether an invoice has already been made with the
         * given product_id
         */
        $this->load->model('invoice_model');
        $check_invoice = $this->invoice_model->check_invoice_by_product_id($product_id);
        if ($check_invoice)
            return false;


        /*
         * Calculating payable amount to the site owner
         */
        $fee_percent = $this->settings_model->getSettings('fee_percent');
        $payment = ($fee_percent / 100) * $data['bid_status']->bid_amount;
        $insert_data = array(
            'user_id' => $data['bid_status']->user_id,
            'product_id' => $product_id,
            'payment' => $payment,
            'status' => 'unpaid'
        );


        /**
         * Creating invoice
         */
        $insert_status = $this->invoice_model->insert_invoice($insert_data);
        if ($insert_status)
            return true;
        else
            return false;
    }

    public function category() {
        $this->load->model('category_model');

        $data['product_category'] = $this->category_model->get2LevelCategories();

        $data['current'] = '';
        $this->load->view('category_view', $data);
    }

    public function categories($category) {

        $this->load->model('category_model');

        if (!isset($category))
            redirect(base_url('prodcut/category'));

        if (!($data['category'] = $this->category_model->getCategoryByUrl($category)))
            redirect(base_url() . 'product/category');

        $data['childCategories'] = $this->category_model->getChildCategories($data['category']->cat_id);
        $data['categoryParent'] = $this->category_model->getCategoryParent($data['category']->cat_id);

        $data['all_cat_pro'] = $this->product_model->get_all_cat_pro($data['category']->cat_id);

        $data['current'] = '';
        $this->load->view('category_product_view', $data);
    }

    //Creating user review
    function make_review() {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        $product_id = $this->input->post('product_id');
        $user_id = $this->input->post('user_id');
        $from_id = $this->input->post('from_id');
        $rating = $this->input->post('rating');
        $message = $this->input->post('message');
        $type = $this->input->post('type');


        //Checking user's status
        $where = array(
            'id' => $user_id,
        );
        $value['data'] = $this->user_model->login_access($where);
        if ($value['data'] && $value['data']->status != '1')
            redirect('product/view/' . $product_id);



        $this->load->model('review_model');
        //Checking user eligibility
        $check_review = $this->review_model->check_review_eligibility($product_id, $user_id, $from_id);
        if (!$check_review)
            redirect('product/view/' . $product_id);



        //Inserting data into review table
        $insert_data = array(
            'product_id' => $product_id,
            'user_id' => $user_id,
            'from_id' => $from_id,
            'rating' => $rating,
            'message' => $message,
            'type' => $type
        );


        $result = $this->review_model->make_review($insert_data);



        //Getting all review data of the user who is getting the review
        $review_data = $this->review_model->get_review_by_user($user_id, $type);

        //Calculating review rating average
        $rating_val = 0;
        $count = 0;
        if (!empty($review_data)) {
            foreach ($review_data as $data) {
                $rating_val += $data->rating;
                $count++;
            }
            $rating_avg = $rating_val / $count;
        }

        //Creating update array to update user table
        if ($type == 'buyer') {
            $update_data['buyer_review'] = $rating_avg;
            $update_data['buyer_review_count'] = $count;
        } else if ($type == 'seller') {
            $update_data['seller_review'] = $rating_avg;
            $update_data['seller_review_count'] = $count;
        }

        //Updating user review rating of specific type
        $this->user_model->update_user('user', $update_data, $user_id);

        $toData = $this->user_model->get_user_by_id($user_id);
        $productData = $this->product_model->getProductData($product_id);



        //Sending email
        $this->load->helper('function');
        $message = $_SESSION['user_name'] . ' has given a review of rating ' . $rating . ' out of 5 for <a href="' . base_url() . 'product/view/' . $product_id . '">' . $productData->name . '</a>';
        $subject = 'Review Given';
        send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);

        echo json_encode($result);
    }

    function create_product_category_list($product_id, $category_id) {

        $this->load->model('category_model');
        $cat_data = $data = $this->category_model->get_parent_id_by_category($category_id);
        $this->category_model->insert_product_category_list(array('product_id' => $product_id, 'product_category_id' => $category_id));

        if ($data->level > 1) {

            $this->category_model->insert_product_category_list(array('product_id' => $product_id, 'product_category_id' => $data->parent_id));

            for ($x = 1; $x < ($data->level - 1); $x++) {

                $cat_data = $this->category_model->get_parent_id_by_category($cat_data->parent_id);
                $this->category_model->insert_product_category_list(array('product_id' => $product_id, 'product_category_id' => $cat_data->parent_id));
            }
        }
    }

    function generate_category_recursive($category_array, $cat_parent_id = false) {

        global $child_sign;

        if (!empty($category_array)) {

            $select_generator = '';
            $child = $child_sign;



            foreach ($category_array as $cat) {

                //Checking if there is any category id to make selected
                if ($cat_parent_id !== false && $cat["cat_id"] == $cat_parent_id)
                    $selected = 'selected';
                else
                    $selected = '';

                if ($cat["parent_id"] == 0) {

                    $select_generator .= '<optgroup label="' . $cat["cat_name"] . '">';
                } else {
                    $select_generator .= '';
                }

                if ($cat["parent_id"] != 0) {
                    $select_generator .= '<option value="' . $cat["cat_id"] . '" ' . $selected . '>' . $child . '|-' . $cat["cat_name"] . '</option>';
                }


                if (!empty($cat['child'])) {


                    $child_sign .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $select_generator .= $this->generate_category_recursive($cat['child'], $cat_parent_id);
                } else {
                    $child_sign = substr_replace('&nbsp;&nbsp;&nbsp;&nbsp;', '', 0, strlen($child_sign));
                }
                if ($cat["parent_id"] == 0) {

                    $select_generator .= '</optgroup>';
                } else {
                    $select_generator .= '';
                }
            }


            return $select_generator;
        } else {

            return '<option>No Category</option>';
        }
    }

}
