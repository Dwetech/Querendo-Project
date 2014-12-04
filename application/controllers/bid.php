<?php

/*
  Created on : Jul 7, 2014, 12:43:26 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Bid extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('bids_model');
    }

    /**
     * Creating a bid on a product
     */
    public function create() {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        $product_id = $this->uri->segment('3');
        if (!$product_id)
            redirect('/');


        $this->load->model('product_model');
        $condition = array(
            'product.product_id' => $product_id,
            'product.status' => 'running',
            'product.activity' => 1,
            'user.status' => 1
        );
        $productData = $this->product_model->check_product_status($condition);
        if (!$productData)
            redirect('/');

        //Checking bidder's status
        $where = array(
            'id' => $productData->user_id,
        );
        $value['data'] = $this->user_model->login_access($where);
        if ($value['data'] && $value['data']->status != '1')
            redirect('product/view/' . $product_id);



        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->load->library('form_validation');

            $this->form_validation->set_rules('bid_amount', 'Bid Amount', 'required|xss_clean|numeric|strip_tags');
            $this->form_validation->set_rules('delivery_time', 'Delivery Time', 'required|xss_clean|numeric|strip_tags');
            $this->form_validation->set_rules('proposal_text', 'Proposal Text', 'xss_clean|strip_tags');
            $this->form_validation->set_rules('product_condition', 'Product Condition', 'xss_clean|required|strip_tags');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please check following error(s)!');
                if (form_error('bid_amount')) {
                    $this->session->set_flashdata('bid_amount', 'The Bid Amount field is required and it should be numeric!');
                }
                if (form_error('delivery_time')) {
                    $this->session->set_flashdata('delivery_time', 'The Delivery Time field is required and it should be numeric!');
                }
                if (form_error('proposal_text')) {
                    $this->session->set_flashdata('proposal_text', 'The Proposal Text should not have any html tags!');
                }
                if (form_error('product_condition')) {
                    $this->session->set_flashdata('product_condition', 'The Product Condition field is required!');
                }

                redirect('product/view/' . $product_id . '#bid');
            } else {
                
                $bid_amount         = $this->input->post('bid_amount');
                $delivery_time      = $this->input->post('delivery_time');
                $proposal_text      = $this->input->post('proposal_text');
                $product_condition  = $this->input->post('product_condition');
                $product_id         = $this->input->post('product_id');
                $user_id            = $_SESSION['user_id'];

                $bid_data = array(
                    'product_id'    => $product_id,
                    'user_id'       => $user_id,
                    'bid_amount'    => $bid_amount,
                    'delivery_time' => $delivery_time,
                    'status'        => 'Regular',
                    'proposal_text' => $proposal_text,
                    'product_condition'     => $product_condition

                );

                if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) {

                    $file_name = random_string('alnum', 8);
                    $dir = 'upload/bid_photo/';
                    $config['file_name'] = $file_name . '.jpg';
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '5120';

                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;

                    if ($this->upload->do_upload()) {
                        $bid_data['product_image'] = $config['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                    }
                }


                $insert_bid = $this->bids_model->insert_bid($bid_data);
                if (!$insert_bid) {
                    $this->session->set_flashdata('error', 'fatal error!');
                    redirect('product/view/' . $product_id . '#bid');
                } else {


                    //after bid has been made, product owner will receive email about it
                    $this->load->helper('function');

                    $toData = $this->user_model->get_user_by_id($productData->user_id);

                    $subject = 'A Bid Has Been Made';
                    $message = '<a href="' . base_url() . 'user/view/' . $_SESSION['user_name'] . '">' . $_SESSION['user_name'] . '</a> has made a bid on <a href="' . base_url() . 'product/view/' . $product_id . '">' . $productData->name . '</a>';
                    send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);


                    redirect('product/view/' . $product_id);
                }
            }
        } else {
            redirect("product/view/$product_id");
        }
    }

    /**
     * updating a bid details as long as the product status
     * is Regular and bid status is running
     */
    public function update() {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');

        $product_id = $this->uri->segment('3');
        if (!$product_id)
            redirect('/');


        $this->load->model('product_model');
        $condition = array(
            'product.product_id' => $product_id,
            'product.status' => 'running',
            //'bids.status' => 'Regular',
            'product.activity' => 1,
            'user.status' => 1
        );
        $productData = $this->product_model->check_product_status($condition);
        if (!$productData)
            redirect('/');
        
        
        //Checking bidder's status
        $where = array(
            'id' => $productData->user_id,
        );
        $value['data'] = $this->user_model->login_access($where);
        if ($value['data'] && $value['data']->status != '1')
            redirect('product/view/' . $product_id);


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {


            $bid_id = $this->input->post('bid_id');
            //Checking user eligibility to update the bid
            $credentials = array(
                'user_id' => $_SESSION['user_id'],
                'id' => $bid_id
            );
            $data['bid'] = $this->bids_model->check_bid_status_by_user($credentials);
            if ($data['bid'] === false)
                redirect('product/view/' . $product_id);

            $this->load->library('form_validation');


            $this->form_validation->set_rules('bid_amount', 'Bid Amount', 'required|xss_clean|numeric|strip_tags');
            $this->form_validation->set_rules('delivery_time', 'Delivery Time', 'required|xss_clean|numeric|strip_tags');
            $this->form_validation->set_rules('proposal_text', 'Proposal Text', 'xss_clean|strip_tags');
            $this->form_validation->set_rules('product_condition', 'Product Condition', 'xss_clean|required|strip_tags');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please check following error(s)!');
                if (form_error('bid_amount')) {
                    $this->session->set_flashdata('bid_amount', 'The Bid Amount field is required and it should be numeric!');
                }
                if (form_error('delivery_time')) {
                    $this->session->set_flashdata('delivery_time', 'The Delivery Time field is required and it should be numeric!');
                }
                if (form_error('proposal_text')) {
                    $this->session->set_flashdata('proposal_text', 'The Proposal Text should not have any html tags!');
                }
                if (form_error('product_condition')) {
                    $this->session->set_flashdata('product_condition', 'The Product Condition field is required!');
                }

                redirect('product/view/' . $product_id . '#bid');
            } else {

                $bid_id = $this->input->post('bid_id');
                $bid_amount = $this->input->post('bid_amount');
                $delivery_time = $this->input->post('delivery_time');
                $proposal_text = $this->input->post('proposal_text');
                $product_condition = $this->input->post('product_condition');
                $product_id = $this->input->post('product_id');
                $product_image = $this->input->post('product_image');
                $user_id = $_SESSION['user_id'];

                $bid_data = array(
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'bid_amount' => $bid_amount,
                    'delivery_time' => $delivery_time,
                    'proposal_text' => $proposal_text,
                    'product_condition' => $product_condition
                );

                if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) {

                    $file_name = random_string('alnum', 8);
                    $dir = 'upload/bid_photo/';
                    $config['file_name'] = $file_name . '.jpg';
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '5120';

                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;

                    if ($this->upload->do_upload()) {
                        $bid_data['product_image'] = $config['file_name'];
                        @unlink($dir . $product_image);
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                    }
                }


                $insert_bid = $this->bids_model->update_bid($bid_id, $bid_data);
                if (!$insert_bid) {
                    $this->session->set_flashdata('error', 'fatal error!');
                    redirect('product/view/' . $product_id . '#bid');
                } else {
                    redirect('product/view/' . $product_id);
                }
            }
        } else {
            redirect("product/view/$product_id");
        }
    }

    /**
     * Deleting a bid by both bidder and product poster
     * @param int $bid_id
     */
    function delete($bid_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');



        //Checking user eligibility to update the bid
        $this->load->model('product_model');
        $bid_status = $this->product_model->check_cancel_bid_data($bid_id, $_SESSION['user_id'], 'running', 'regular');
        if (!$bid_status)
            redirect('/');



        $this->bids_model->delete_bid(array('id' => $bid_id));
        @unlink('upload/bid_photo/' . $bid_status->product_image);


        redirect('product/view/' . $bid_status->product_id);
    }

    /**
     * Accept a bid by product poster
     * @param int $bid_id
     */
    function accept($bid_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');



        /**
         * Getting bid and product data
         * -------------------------------
         * Checking whether bidders status is active, product and bid status
         * is running/regular
         */
        $this->load->model('product_model');
        $bid_status = $this->product_model->check_product_bid_data($bid_id, $_SESSION['user_id'], 'running', 'regular');
        if (!$bid_status) {
            redirect('/');
        }



        //Updating product and bid status
        $this->bids_model->update_bid($bid_status->bid_id, array('status' => 'Waiting'));
        $this->product_model->update_product(array('status' => 'Waiting'), $bid_status->product_id);


        /*         * ******* */
        //Sending email
        /*         * ******* */
        $this->load->helper('function');
        $productData = $this->product_model->getProductData($bid_status->product_id);
        $toData = $this->user_model->get_user_by_id($bid_status->bidder_id);

        $message = 'Your bid has been accepted by <a href="' . base_url() . 'user/view/' . $_SESSION['user_name'] . '">' . $_SESSION['user_name'] . '</a> on <a href="' . base_url() . 'product/view/' . $productData->product_id . '">' . $productData->name . '</a> in querendo and waiting for your confirmation.';
        $subject = 'Bid Accepted';
        send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);


        redirect('product/view/' . $bid_status->product_id);
    }

    /**
     * Cancelling a bid by both bidder and product poster
     * @param int $bid_id
     */
    function cancel($bid_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        //Checking user eligibility to update the bid
        $this->load->model('product_model');
        $bid_status = $this->product_model->check_cancel_bid_data($bid_id, $_SESSION['user_id'], 'waiting', 'waiting');
        if (!$bid_status)
            redirect('/');


        //Updating product and bid status
        $this->bids_model->update_bid($bid_status->bid_id, array('status' => 'Regular'));
        $this->product_model->update_product(array('status' => 'running'), $bid_status->product_id);

        redirect('product/view/' . $bid_status->product_id);
    }

    /**
     * Accepted product by product poster will have to be confirmed
     * by bidder user
     * @param int $bid_id
     */
    function confirm($bid_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        //Checking whether user can confirm the bid
        $this->load->model('product_model');
        $bid_status = $this->product_model->check_confirm_bid_data($bid_id, $_SESSION['user_id'], 'waiting', 'waiting');
        if (!$bid_status)
            redirect('/');


        /*
         * //Preparing data to insert into milestone table
        $insert_milestone_data = array(
            'product_id' => $bid_status->product_id,
            'from_id' => $bid_status->product_owner_id,
            'to_id' => $bid_status->bidder_id,
            'initiated_by' => $_SESSION['user_id'],
            'amount' => $bid_status->bid_amount,
            'description' => 'Bid Accepted and Confirmed',
            'status' => 'requested'
        );


        $this->load->model('milestone_model');
        $this->milestone_model->insert_milestone($insert_milestone_data);
         */
        $this->bids_model->update_bid($bid_id, array('status' => 'Awarded'));
        $this->product_model->update_product(array('status' => 'awarded'), $bid_status->product_id);


        //Sending email
        $this->load->helper('function');
        $toData = $this->user_model->get_user_by_id($bid_status->product_owner_id);
        //Sending email
        $message = 'The bid you have accepted in <a href="' . base_url() . 'product/view/' . $bid_status->product_id . '">' . $bid_status->name . '</a> has been confirmed by <a href="' . base_url() . 'user/view/' . $_SESSION['user_name'] . '">' . $_SESSION['user_name'] . '</a>';
        $subject = 'Bid Confirmed';
        send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);

        redirect('product/view/' . $bid_status->product_id);
    }

}
