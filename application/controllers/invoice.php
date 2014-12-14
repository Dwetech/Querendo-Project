<?php

/*
  Created on : Aug 9, 2014, 6:27:27 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Invoice extends CI_Controller {

    public function __construct() {
        parent::__construct();


        if (!$this->auth->logged_in)
            redirect('login');
        if (!$this->auth->is_active)
            redirect('user/inactive');


        $this->load->model('invoice_model');
    }

    /**
     * Viewing all invoices of a specific user(logged in user)
     */
    function index() {

        /* Pagination */
        $this->load->library('pagination');
        $data['count'] = $this->invoice_model->count_invoices_by_user($_SESSION['user_id']);
        $config['base_url'] = base_url() . 'invoice/index/';
        $config['total_rows'] = $data['count'];
        $config['uri_segment'] = 3;
        $config['per_page'] = 30;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;

        //Calculating offset
        if ($this->uri->segment(3) > 0) {

            $offset = $this->uri->segment(3) * $config['per_page'] - $config['per_page'];
        } else {

            $offset = $this->uri->segment(3);
        }
        $this->pagination->initialize($config);
        /* Pagination */

        $data['invoice_data'] = $this->invoice_model->get_invoices_by_user($_SESSION['user_id'], $config['per_page'], $offset);


        //Current active menu name
        $data['current'] = 'invoice';
        $this->load->view('invoice_view', $data);
    }

    function pay($invoice_id) {
        if( !isset($invoice_id) ) {
            redirect('invoice');
        }

        $invoice = $this->invoice_model->getFullDetails($invoice_id);

        if( !$invoice ) {
            redirect('invoice');
        }

        //Current active menu name
        $data['current'] = 'invoice';
        $data['invoice'] = $invoice;
        $this->load->view('invoice_payment_form', $data);

    }

}
