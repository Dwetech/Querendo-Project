<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->auth->checkAdminLogin()) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index()
    {

        $this->load->model('user_model');

        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {
            if (isset($_POST['searchData'])) {
                if (!empty($_POST['searchData'])) {
                    $data['page'] = 'user';
                    $data['searchData'] = $_POST['searchData'];
                    $data['user'] = $this->user_model->getAllDataBySearch($data['searchData']);

                } else {
                    $data['searchData'] = '';
                    $data['user'] = $this->user_model->getAllDataBySearch($data['searchData']);
                    $data['page'] = 'user';
                }
            } else {
                $data['searchData'] = '';
                $data['user'] = $this->user_model->getAllDataBySearch($data['searchData']);
                $data['page'] = 'user';
            }
        } else {
            $data['searchData'] = '';
            $data['user'] = $this->user_model->getAllDataBySearch($data['searchData']);
            $data['page'] = 'user';
        }

        $this->load->view('admin/user_view', $data);
    }

    function activity($user_id)
    {

        if (!$this->uri->segment(4)) {
            redirect(base_url() . 'admin/user');
        }

        $this->load->model('user_model');
        $status = $this->user_model->activity($user_id);
        $status == 1 ? $activity = 0 : $activity = 1;


        $data = array(
            'status' => "$activity"
        );
        $remove = $this->user_model->activityAction($user_id, $data);
        if ($remove) {
            redirect(base_url() . 'admin/user');
        } else {
            redirect(base_url() . 'admin/user');
        }
    }
}