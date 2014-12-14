<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->auth->checkAdminLogin()) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index() {

        $this->load->model(array('product_model', 'category_model'));


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {


            if (isset($_POST['category']) || isset($_POST['searchData'])) {

                if (!empty($_POST['category']) && !empty($_POST['searchData'])) {

                    $data['category_id'] = $_POST['category'];
                    $data['searchData'] = $_POST['searchData'];
                    $data['product'] = $this->product_model->getAllDataByCatSearch($_POST['searchData'], $_POST['category']);
                } else if (empty($_POST['category']) && !empty($_POST['searchData'])) {

                    $data['category_id'] = '';
                    $data['searchData'] = $_POST['searchData'];
                    $data['product'] = $this->product_model->getAllDataBySearch($_POST['searchData']);
                } else if (!empty($_POST['category']) && empty($_POST['searchData'])) {

                    $data['category_id'] = $_POST['category'];
                    $data['searchData'] = '';
                    $data['product'] = $this->product_model->getAllDataByCat($_POST['category']);
                } else {
                    $data['category_id'] = '';
                    $data['searchData'] = '';
                    $data['product'] = $this->product_model->getProductList();
                }
            } else {
                $data['category_id'] = '';
                $data['searchData'] = '';
                $data['product'] = $this->product_model->getProductList();
            }
        } else {
            $data['category_id'] = '';
            $data['searchData'] = '';
            $data['product'] = $this->product_model->getProductList();
        }


//        echo $data['category'];exit();

        $data['category'] = $this->category_model->getProductCat();
        $data['trashProduct'] = $this->product_model->getTrashProductList();

        $data['page'] = 'product';
        $this->load->view('admin/product_view', $data);
    }

    function confirm_remove($product_id) {

        if (!$this->uri->segment(2)) {
            redirect(base_url() . 'admin/product');
        }
        $this->load->model('product_model');

        $product_image = $this->product_model->getAllImages('product', 'product_photo', $product_id);
        $bid_image = $this->product_model->getAllImages('bids', 'product_image', $product_id);


        $removeProduct = $this->product_model->remove_product($product_id);
        $removeBids = $this->product_model->remove_product_bid($product_id);

        if ($removeProduct && $removeBids) {
            unlink(base_url() . 'upload/product_phote/' . $product_image->product_photo);

            foreach ($bid_image as $img) {
                unlink(base_url() . 'upload/bid_photo' . $img->product_image);
            }
        }


        if ($removeProduct && $removeBids) {
            redirect(base_url() . 'admin/product');
        }
    }

    function remove($product_id) {

        if (!$this->uri->segment(2)) {
            redirect(base_url() . 'admin/product');
        }
        $this->load->model('product_model');


        $update_data = array(
            'activity' => '0'
        );
        $removeProduct = $this->product_model->trash_product($product_id, $update_data);


        if ($removeProduct) {
            redirect(base_url() . 'admin/product');
        }
    }

    function restore($product_id) {

        if (!$this->uri->segment(2)) {
            redirect(base_url() . 'admin/product');
        }
        $this->load->model('product_model');


        $update_data = array(
            'activity' => '1'
        );
        $removeProduct = $this->product_model->trash_product($product_id, $update_data);


        if ($removeProduct) {
            redirect(base_url() . 'admin/product');
        }
    }

}
