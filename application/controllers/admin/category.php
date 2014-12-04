<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/26/14
 * Time: 5:22 PM
 */
class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->auth->checkAdminLogin())
            redirect(base_url() . 'admin/login');

        $this->load->model('category_model');
    }

    function index() {

        /* Pagination */
        $this->load->library('pagination');
        $data['count'] = $this->category_model->count_ProductCategory();
        $config['base_url'] = base_url() . 'admin/category/index/';
        $config['total_rows'] = $data['count'];
        $config['uri_segment'] = 4;
        $config['per_page'] = 15;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;

        //Calculating offset
        if ($this->uri->segment(4) > 0) {

            $offset = $this->uri->segment(4) * $config['per_page'] - $config['per_page'];
        } else {

            $offset = $this->uri->segment(4);
        }
        $this->pagination->initialize($config);
        /* Pagination */


        $data['category'] = $this->category_model->getProductCategory($config['per_page'],$offset);

        $data['page'] = 'category';
        $this->load->view('admin/category_view', $data);
    }

    function add() {

        $this->load->library('form_validation');
        $this->load->helper('function');

        //$data['category'] = $this->category_model->getProductCategory();
        $data['categories'] = $this->category_model->generateCategories(0);
        $data['select'] = $this->generate_category_recursive($data['categories']);

        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {

            $this->form_validation->set_rules('parent_id', 'Parent Category', 'required|xss_clean');
            $this->form_validation->set_rules('category', 'Category', 'required|xss_clean');
            $this->form_validation->set_rules('url', 'URL', 'required|xss_clean|is_unique[product_category.url]');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Please check following error(s)!';
            } else {
                $category = $this->input->post('category');
                $parent_id = $this->input->post('parent_id');
                $url = $this->input->post('url');
                $url = strToUrl($url);

                $categoryLevel = $this->category_model->createCategoryLevel($parent_id);

                $insert_data = array(
                    'url' => $url,
                    'cat_name' => $category,
                    'parent_id' => $parent_id,
                    'level' => $categoryLevel
                );
                $insertCat = $this->category_model->insertCategory($insert_data);
                if ($insertCat) {
                    $this->session->set_flashdata('success', 'A new category inserted successfully');
                    redirect(base_url() . 'admin/category');
                } else {
                    $data['error'] = "Please check following error(s)!";
                }
            }
        }



        $data['page'] = 'category';
        $this->load->view('admin/add_category_view', $data);
    }

    function edit($cat_id) {

        if (!$this->uri->segment(4))
            redirect(base_url() . 'admin/category');

        $this->load->library('form_validation');
        $this->load->helper('function');


        $data['cat_id'] = $this->uri->segment(4);


        $data['category'] = $this->category_model->getSingleCategory($cat_id);
        $data['categories'] = $this->category_model->generateCategories(0);
        $category = $this->category_model->getSingleCategory($data['cat_id']);
        $data['select'] = $this->generate_category_recursive($data['categories'], $category->parent_id);


        if (isset($_POST['submit']) && trim($_POST['submit']) == "Submit") {


            $this->form_validation->set_rules('parent_id', 'Parent Category', 'required|xss_clean');
            $this->form_validation->set_rules('category', 'Category', 'required|xss_clean');
            $this->form_validation->set_rules('url', 'Url', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = 'Please check following error(s)!';
            } else {
                $category = $this->input->post('category');
                $parent_id = $this->input->post('parent_id');
                $url = $this->input->post('url');
                $url = strToUrl($url);

                $update_data = array(
                    'cat_name' => $category,
                    'parent_id' => $parent_id,
                    'url' => $url
                );
                $updatedCat = $this->category_model->updateCategory($update_data, $cat_id);
                if ($updatedCat) {
                    $this->session->set_flashdata('success', 'A category has been updated successfully');
                    redirect(base_url() . 'admin/category');
                } else {
                    $data['error'] = "something";
                }
            }
        } else {
            $data['submitError'] = "error";
        }


        $data['page'] = 'category';
        $this->load->view('admin/edit_category_view', $data);
    }

    function remove($cat_id) {


        if (!$this->uri->segment(4))
            redirect(base_url() . 'admin/product');

        $remove = $this->category_model->remove_category($cat_id);

        if ($remove) {
            $this->session->set_flashdata('success', 'A category has been removed successfully');
            redirect(base_url() . 'admin/category');
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

                $select_generator .= '<option value="' . $cat["cat_id"] . '" ' . $selected . '>' . $child . '|-' . $cat["cat_name"] . '</option>';

                if (!empty($cat['child'])) {


                    $child_sign .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $select_generator .= $this->generate_category_recursive($cat['child'], $cat_parent_id);
                } else {
                    $child_sign = substr_replace('&nbsp;&nbsp;&nbsp;&nbsp;', '', 0, strlen($child_sign));
                }
            }
            return $select_generator;
        } else {

            return '<option>No Category</option>';
        }
    }

}
