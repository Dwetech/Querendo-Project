<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Logout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $this->load->model('admin_model');

        $this->admin_model->logout();

        redirect(base_url().'admin');
    }
}