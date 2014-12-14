<?php

/*
  Created on : Jul 7, 2014, 12:48:02 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Milestone extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('milestone_model');
    }

    /**
     * Creating payment and Updating payment
     */
//    function create() {
//
//        if (!$this->auth->logged_in)
//            redirect('login');
//        if (!$this->auth->is_active)
//            redirect('user/inactive');
//
//        $this->load->helper('function');
//
//        if (isset($_POST['submit']) && trim($_POST['submit']) == 'Submit') {
//
//            $product_id = $this->input->post('product_id');
//            $this->load->library('form_validation');
//
//            $this->form_validation->set_rules('amount', 'Milestone Amount', 'required|xss_clean|numeric|strip_tags');
//            $this->form_validation->set_rules('description', 'Description', 'required|xss_clean|strip_tags');
//
//            if ($this->form_validation->run() === FALSE) {
//
//                $this->session->set_flashdata('error_milestone', 'Please check following error(s)!');
//                if (form_error('amount')) {
//                    $this->session->set_flashdata('amount', 'The Amount field is required and it should be numeric!');
//                }
//            } else {
//
//                $amount = $this->input->post('amount');
//                $description = $this->input->post('description');
//                $from_id = $this->input->post('from_id');
//                $to_id = $this->input->post('to_id');
//                $status = $this->input->post('status');
//
//
//                $insert_data = array(
//                    'product_id' => $product_id,
//                    'from_id' => $from_id,
//                    'to_id' => $to_id,
//                    'initiated_by' => $_SESSION['user_id'],
//                    'amount' => $amount,
//                    'description' => $description,
//                    'status' => $status
//                );
//
//                $this->load->model('product_model');
//
//
//
//                //Checking user eligibility
//                $credentials = array(
//                    'user_id' => $_SESSION['user_id'],
//                    'product_id' => $product_id,
//                    'status' => 'completed'
//                );
//                $check_product = $this->product_model->check_product_data($credentials);
//                if (!$check_product)
//                    redirect('product/view/' . $product_id);
//
//
//
//
//
//
//
//
//                /** IF THE PRODUCT OWNER IS CREATING THE MILESTONE,
//                 * BALANCE AVAILABILITY IS TO BE CHECKED
//                 */
//                $product_data = $this->product_model->getProductData($product_id);
//
//                if ($product_data && $product_data->user_id == $_SESSION['user_id']) {
//
//                    $payment_status = $this->_check_payment($_SESSION['user_id'], $amount);
//
//                    if ($payment_status === FALSE) {
//
//                        $this->session->set_flashdata('error_balance', 'You do not have enough balance to perform this transaction!');
//                        redirect('product/view/' . $product_id);
//                    }
//                }
//                /* ================================ */
//
//
//
//
//
//
//                //Updating payment data
//                if (isset($_POST['milestone_id']) && $_POST['milestone_id'] != '') {
//
//                    $check = array(
//                        'id' => $this->input->post('milestone_id')
//                    );
//                    $result = $this->milestone_model->update_milestone($insert_data, $check);
//                } else {//Inserting payment data
//                    $result = $this->milestone_model->insert_milestone($insert_data);
//                }
//
//
//
//
//
//                /** IF THE PRODUCT OWNER IS CREATING THE MILESTONE,
//                 * MILESTONE STATUS WILL BE accepted AND THE AMOUNT
//                 * WILL BE DEDUCTED
//                 */
//                //Deducting and updating balance of user
//                if ($status == 'accepted') {
//
//                    $status = $this->_deduct_payment($from_id, $amount, $product_id, $from_id, 'accept');
//                }
//                /* ================================ */
//            }
//
//
//            if ($status == "requested") {
//
//
//                $toData = $this->user_model->get_user_by_id($from_id);
//                $fromData = $this->user_model->get_user_by_id($to_id);
//                $productData = $this->product_model->getProductData($product_id);
//
//
//                //Sending email
//                $message = $fromData->user_name . ' has requested a payment $' . $amount . ' for <a href="' . base_url() . 'product/view/' . $product_id . '">' . $productData->name . '</a> <br> <b>Payment Description : </b>' . $description;
//                $subject = 'Requested Milestone';
//                send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);
//            } else if ($status == "accepted") {
//
//
//                $toData = $this->user_model->get_user_by_id($to_id);
//                $fromData = $this->user_model->get_user_by_id($from_id);
//                $productData = $this->product_model->getProductData($product_id);
//                //Sending email
//                $message = $fromData->user_name . ' has accepted a payment $' . $amount . ' for <a href="' . base_url() . 'product/view/' . $product_id . '">' . $productData->name . '</a> <br> <b>Milestone Description : </b>' . $description;
//                $subject = 'Accepted Milestone';
//                send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);
//            }
//
//
//            redirect('product/view/' . $product_id);
//        } else {
//            redirect(base_url());
//        }
//    }

    function submit_cancel() {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');

        if (isset($_POST['submit']) && trim($_POST['submit']) == 'Submit') {

            $email = strip_tags($this->input->post('message'));
            $user_type = $this->input->post('user_type');
            $milestone_id = $this->input->post('milestone_id');
            $product_id = $this->input->post('product_id');
            $awarded_user = $this->input->post('awarded_user');
            $this->_cancel($user_type, $milestone_id, $product_id, $awarded_user, $email);
        } else {
            redirect('/');
        }
    }

    /**
     * Cancelling a payment by product owner/bidder
     * ============================
     * @param type $user_type string
     * @param type $milestone_id integer
     * @param type $product_id integer
     * @param type $message string
     */
    private function _cancel($user_type, $milestone_id, $product_id, $awarded_user = '', $email = '') {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');
        
        
        
        $condition = array(
            'product.user_id' => $_SESSION['user_id'],
            'milestone.id' => $milestone_id,
            'milestone.status' => 'accepted'
        );
        //getting payment details
        $milestone_data = $this->milestone_model->get_milestne_product($condition);
        if ($milestone_data === FALSE) {
            redirect('/');
            exit();
        }



        if ($user_type == 'bidder') {

            $status = 'cancelled';
        } else if ($user_type == 'owner') {


            //if email is empty that mean product owner is cancelling the requested payment
            if ($email == '') {
                $status = 'cancelled';

                //if email is not empty that mean product owner is cancelling the accepted payment
            } else if ($email != '') {
                $status = 'pending';
            }
        }
        $where = array(
            'id' => $milestone_id
        );
        $update_data = array(
            'status' => $status
        );

        $result = $this->milestone_model->update_milestone($update_data, $where); //updating payment

        if (!$result) {
            $this->session->set_flashdata('error_milestone', 'Payment cancel failed! Please try again.');
        } else {

            $this->load->helper('function');
            $url = base_url() . 'product/view/' . $product_id;
            $subject = 'Payment Cancelled';
            $this->load->model('product_model');

            //email for product owner
            if ($user_type == 'bidder') {


                //after payment has been cancelled, product owner/bidder will receive email about it
                $productData = $this->product_model->getProductData($product_id);
                $toData = $this->user_model->get_user_by_id($productData->user_id);

                $message = '<a href="' . base_url() . 'user/view/' . $_SESSION['user_name'] . '">' . $_SESSION['user_name'] . '</a> has CANCELLED the payment on <a href="' . base_url() . 'product/view/' . $productData->product_id . '">' . $productData->name . '</a>';

                send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);
            } else if ($user_type == 'owner') {
                

                //email for bidder
                //after payment has been cancelled, product owner/bidder will receive email about it
                $data['user'] = $this->user_model->get_user_by_id($awarded_user);


                $productData = $this->product_model->getProductData($product_id);
                $toData = $this->user_model->get_user_by_id($awarded_user);

                $message = '<a href="' . base_url() . 'user/view/' . $_SESSION['user_name'] . '">' . $_SESSION['user_name'] . '</a> has CANCELLED the payment on <a href="' . base_url() . 'product/view/' . $productData->product_id . '">' . $productData->name . '</a>';

                send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject); //email from admin to bidder
                
                
                //email for admin of the site by product owner
                if ($email != '') {

                    $data['product'] = $this->product_model->get_product_by_id($product_id);
                    $data['user'] = $this->user_model->get_user_by_id($data['product']->user_id);
                    $message = $email;
                    //email from product owner to admin
                    send_email($data['user']->email, $this->settings_model->data['website_email'], $message, $subject);
                }
            }
        }
        redirect('product/view/' . $product_id);
    }
    
    function accept($milestone_id) {
        
        $this->_accept($milestone_id);
    }

    private function _accept($milestone_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        $condition = array(
            'product.user_id' => $_SESSION['user_id'],
            'milestone.id' => $milestone_id,
            'milestone.status' => 'requested'
        );
        //getting payment details
        $milestone_data = $this->milestone_model->get_milestne_product($condition);
        if ($milestone_data === FALSE) {
            redirect('/');
            exit();
        }


        $check_data = $this->_check_payment($_SESSION['user_id'], $milestone_data->amount); //checking user balance availability
        //if balance is available
        if ($check_data) {


            //deducting payment amount from product poster
            $status = $this->_deduct_payment($_SESSION['user_id'], $milestone_data->amount, $milestone_data->product_id, 'accept');


            //if any database error occurs
            if (!$status) {
                $this->session->set_flashdata('error_balance', 'Balance deduction failed! Please try again.');
                redirect('product/view/' . $milestone_data->product_id);
            }

            $where = array(
                'id' => $milestone_id
            );
            $update_data = array(
                'status' => 'accepted'
            );
            //updating payment
            $result = $this->milestone_model->update_milestone($update_data, $where);

            //If updating success
            if ($result) {

                $this->load->model('product_model');
                $this->load->helper('function');
                $url = base_url() . 'product/view/' . $milestone_data->product_id;
                $subject = 'Payment Accepted';



                //$productData = $this->product_model->getProductData($milestone_data->product_id);
                $toData = $this->user_model->get_user_by_id($milestone_data->to_id);
                $fromData = $this->user_model->get_user_by_id($milestone_data->from_id);

                //SENDING EMAIL
                $message = '<a href="' . base_url() . 'user/view/' . $fromData->user_name . '">' . $fromData->user_name . '</a> has ACCEPTED the payment on <a href="' . base_url() . 'product/view/' . $milestone_data->product_id . '">' . $milestone_data->name . '</a>';
                send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);
            }
        } else {//if balance is not available
            $this->session->set_flashdata('error_balance', 'You do not have enough balance to perform this transaction!');
        }


        redirect('product/view/' . $milestone_data->product_id);
    }
    
    function release($milestone_id) {
        $this->_release($milestone_id);
    }

    private function _release($milestone_id) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        $condition = array(
            'product.user_id' => $_SESSION['user_id'],
            'milestone.id' => $milestone_id,
            'milestone.status !=' => 'released'
        );
        //getting payment details
        $milestone_data = $this->milestone_model->get_milestne_product($condition);
        if ($milestone_data === FALSE) {
            redirect('/');
            exit();
        }

        /**
         * if the payment status is requested,
         * then product owner will be deducted with the amount of bidder's payment amount first
         */
        if ($milestone_data->status == 'requested') {


            //checking user balance availability
            $check_data = $this->_check_payment($_SESSION['user_id'], $milestone_data->amount);


            //if balance is available
            if ($check_data) {


                //deducting payment amount from product poster
                $status = $this->_deduct_payment($_SESSION['user_id'], $milestone_data->amount, $milestone_data->product_id, 'release');

                //if any database error occurs
                if (!$status) {


                    $this->session->set_flashdata('error_balance', 'Balance deduction failed! Please try again.');
                    redirect('product/view/' . $milestone_data->product_id);
                }

                $where = array(
                    'id' => $milestone_id
                );
                $update_data = array(
                    'status' => 'accepted'
                );
                $result = $this->milestone_model->update_milestone($update_data, $where); //updating payment
                //if balance is not available
            } else {


                $this->session->set_flashdata('error_balance', 'You do not have enough balance to perform this transaction!');
                redirect('product/view/' . $milestone_data->product_id);
            }
        }



        //adding payment amount to bidder account
        $status = $this->_add_payment($milestone_data->to_id, $milestone_data->amount, $milestone_data->product_id, $milestone_data->from_id, 'release');

        // Take fee
        $this->_takeFee($milestone_data->to_id, $milestone_data->amount, $milestone_data->product_id, $milestone_id);


        if (!$status) {
            $this->session->set_flashdata('error_balance', 'Balance adding failed! Please try again.');
            redirect('product/view/' . $milestone_data->product_id);
        }


        $where = array(
            'id' => $milestone_id
        );
        $update_data = array(
            'status' => 'released'
        );
        $result = $this->milestone_model->update_milestone($update_data, $where); //updating payment

        if ($result) {

            $this->load->model('product_model');
            $this->load->helper('function');
            $url = base_url() . 'product/view/' . $milestone_data->product_id;
            $subject = 'Payment Released';

            //$productData = $this->product_model->getProductData($milestone_data->product_id);
            $toData = $this->user_model->get_user_by_id($milestone_data->to_id);
            $fromData = $this->user_model->get_user_by_id($_SESSION['user_id']);

            $message = '<a href="' . base_url() . 'user/view/' . $fromData->user_name . '">' . $fromData->user_name . '</a> has released the payment $' . $milestone_data->amount . ' for <a href="' . base_url() . 'product/view/' . $milestone_data->product_id . '">' . $milestone_data->name . '</a>';
            send_email($this->settings_model->data['website_email'], $toData->email, $message, $subject);
        }
        //$this->output->enable_profiler(TRUE);


        redirect('product/view/' . $milestone_data->product_id);
    }

    /**
     * Take Product fee from the user
     * ============================
     * Take product fee from user balance and add that balance to
     * Admin balance.
     *
     * @param $user
     * @param $amount
     * @param $product_id
     * @param $milestone_id
     * @return bool
     */
    private function _takeFee($user, $amount, $product_id, $milestone_id) {
        $this->load->model('admin_balance_model');
        $this->load->model('product_model');

        $product = $this->product_model->get_product_by_id($product_id);

        $percent = $this->settings_model->getSettings('fee_percent');
        $balance = ($amount * $percent) / 100;


        $this->db->trans_start();
        $addBalance = $this->balance_model->addBalance(array(
            'user_id' => $user,
            'amount' => $balance,
            'type' => 'debit',
            'description' => 'Fee taken for <a href="' . base_url('product/view/' . $product_id) . '">' . $product->name . '</a>'
        ));
        $this->admin_balance_model->add($product_id, $milestone_id, $percent , $user, $balance);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check a specific user's balance of
     * specific amount whether it is available or not
     * =================
     * @param type $user_id
     * @param type $balance
     * @return type data
     */
    private function _check_payment($user_id, $balance) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');

        $check = array(
            'id' => $user_id,
            'balance >=' => $balance
        );
        $balance_status = $this->user_model->check_balance_by_user($check);
        return $balance_status;
    }

    /**
     * Deducting balance from user of specific amount
     * ================
     * @param type $user_id
     * @param type $balance
     * @return type boolean
     */
    private function _deduct_payment($user_id, $balance, $product_id, $type) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');

        $this->load->model('balance_model');

        $this->db->trans_start();
        $description = $this->balance_model->create_balance_description_data($product_id, $user_id, $type);

        $balance_data = array(
            'user_id' => $user_id,
            'amount' => $balance,
            'type' => 'debit',
            'description' => $description
        );
        $this->balance_model->addBalance($balance_data);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Adding balance to user of specific amount
     * ================
     * @param type $user_id
     * @param type $balance
     * @return type boolean
     */
    private function _add_payment($user_id, $balance, $product_id, $product_owner_id, $type) {

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');

        $this->load->model('balance_model');


        $this->db->trans_start();
        $description = $this->balance_model->create_balance_description_data($product_id, $product_owner_id, $type);
        $balance_data = array(
            'user_id' => $user_id,
            'amount' => $balance,
            'type' => 'credit',
            'description' => $description
        );
        $this->balance_model->addBalance($balance_data);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            return false;
        } else {
            return true;
        }
    }

}
