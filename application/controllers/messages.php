<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Messages extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');
    }

    /**
     * Message Process
     * ==========
     * 1. 
     */
    public function index() {

        $this->load->helper('function');

        $data['user_list'] = $this->message_model->getMyUser($_SESSION['user_id']);

        $thread_id = $this->uri->segment('3');
        //Check thread and user relation existence
        if ($thread_id) {

            $thread_status = $this->message_model->get_thread_by_user($_SESSION['user_id'], $thread_id);
            if ($thread_status === false)
                redirect('messages');


            $data['thread'] = $this->message_model->get_thread_by_id($thread_id, $_SESSION['user_id']);
            $data['product_id'] = $data['thread']->product_id;
            $data['from_id'] = $_SESSION['user_id'];
            $data['to_id'] = $data['thread']->from_id == $_SESSION['user_id'] ? $data['thread']->to_id : $data['thread']->from_id;
            $data['conversation'] = $this->message_model->get_conversation($thread_id, 0);
            //set all message as "read" received till this page reload
            $this->message_model->update_status($thread_id, $_SESSION['user_id'], array('status' => 'read'));
            //$this->output->enable_profiler(true);
        }

        $data['current'] = 'inbox';
        $this->load->view('messages-view', $data);
    }

    /**
     * Fetching message
     */
    function fetch_message() {

        $thread_id = $this->input->post('thread_id');
        $message_id = $this->input->post('message_id');

        $conversation = $this->message_model->get_conversation($thread_id, $message_id);
        echo json_encode($conversation);
    }

    /**
     * Sending message
     * ================
     * Message conversation between bidder and product poster,
     * after a bid is accepted
     */
    function send_message() {

        $thread_id = $this->input->post('thread_id');
        $product_id = $this->input->post('product_id');
        $from_id = $this->input->post('from_id');
        $to_id = $this->input->post('to_id');
        $message_id = $this->input->post('message_id');
        $message = $this->input->post('message');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('message', 'Message', 'required|xss_clean|strip_tags');

        if ($this->form_validation->run() === FALSE) {
            $message = array(
                'status' => 'error',
                'message' => 'Please input valid data!'
            );
            echo json_encode($message);
        } else {


            //If no thread is created yet
            if (!$thread_id && $thread_id == '0') {

                //Checking whether thread is already created or not by other user
                $thread = $this->message_model->fetch_thread_id($product_id, $from_id, $to_id);
                if (!$thread) {

                    //Creating new thread
                    $insert_thread = array(
                        'product_id' => $product_id,
                        'from_id' => $from_id,
                        'to_id' => $to_id
                    );
                    $thread_id = $this->message_model->insert_thread($insert_thread);
                } else {
                    $thread_id = $thread->thread_id;
                }
            }

            //Inserting data into message table
            $insert_message = array(
                'thread_id' => $thread_id,
                'message' => $message,
                'from_id' => $from_id,
                'status' => 'unread'
            );
            $message_data = $this->message_model->insert_message($insert_message);

            //Fetching conversation
            $conversation = $this->message_model->get_conversation($thread_id, $message_id);

            //If no conversation is found, use last inserted message id to fetch conversation
            if (!$conversation) {

                $conversation = $this->message_model->get_conversation($thread_id, $message_data);
            } else {

                //If conversation is found, it will be marked as read
                $this->message_model->update_status($thread_id, $from_id, array('status' => 'read')/* , $message_id */);
            }

            if ($message_id === FALSE) {
                $message = array(
                    'status' => 'error',
                    'message' => 'Message send failed!'
                );
                echo json_encode($message);
            } else {
                $message = array(
                    'thread_id' => $thread_id,
                    'conversation' => $conversation,
                    'message' => 'Message sent!',
                    'status' => 'success'
                );
                echo json_encode($message);
            }
        }
    }

    //Getting thread id when it is not available
    function get_thread_id() {

        $product_id = $this->input->post('product_id');
        $user_id = $this->input->post('user_id');
        $to_id = $this->input->post('to_id');
        $thread = $this->message_model->fetch_thread_id($product_id, $user_id, $to_id);
        if ($thread) {
            echo json_encode($thread);
        } else {
            echo '0';
        }
    }

    /**
     * Send/Initiate new chat conversation
     */
    function initiate_chat() {

        $product_id = $this->input->post('product_id');
        $from_id = $this->input->post('from_id');
        $to_id = $this->input->post('to_id');
        $message = $this->input->post('message');

        $thread_data = array(
            'product_id' => $product_id,
            'from_id' => $from_id,
            'to_id' => $to_id
        );

        /**
         * Check to see if conversation with this user
         * in this product has already been created
         */
        $chat_status = $this->message_model->fetch_thread_id($product_id, $from_id, $to_id);

        //If conversation exist, return the thread_id
        if ($chat_status) {

            $message_data = array(
                'thread_id' => $chat_status->thread_id,
                'message' => $message,
                'from_id' => $from_id,
                'status' => 'unread'
            );
            $message_status = $this->message_model->insert_message($message_data);

            echo json_encode($chat_status->thread_id);
            exit();
        }




        /**
         * If conversation not exist, 
         * reate thread and insert message
         */
        $thread_id = $this->message_model->insert_thread($thread_data);
        if ($thread_id === FALSE) {

            echo '0';
            exit();
        }


        $message_data = array(
            'thread_id' => $thread_id,
            'message' => $message,
            'from_id' => $from_id,
            'status' => 'unread'
        );
        $message_status = $this->message_model->insert_message($message_data);
        if ($message_status) {

            echo json_encode($thread_id);
            exit();
        } else {

            echo '0';
        }
    }

    public function check_message() {

        $messages = $this->message_model->get_message_notification($_SESSION['user_id']);
        echo json_encode($messages);
        exit();
    }

}
