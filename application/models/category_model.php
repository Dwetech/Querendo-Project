<?php

/**
 * User: AbdullahAlJahid
 * Date: 7/14/14
 * Time: 4:35 PM
 */
class Category_model extends CI_Model {

    public function generateCategories($parent_id) {

        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where("parent_id", $parent_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result_array();

            if ($categories) {


                $data = array();

                for ($x = 0; $x < count($categories); $x++) {

                    $data[$x] = $categories[$x];
                    $data[$x]['child'] = $this->generateCategories($categories[$x]['cat_id']);
                }
                return $data;
            }
        } else {
            return false;
        }
    }

    public function getProductCat() {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->order_by("cat_id", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getProductCategory($limit,$offset) {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->order_by("cat_id", "desc");
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function count_ProductCategory() {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->order_by("cat_id", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function getSingleCategory($cat_id) {
        $this->db->select('*');
        $this->db->where('cat_id', $cat_id);
        $this->db->from('product_category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function isExistCategory($cat_name) {
        $this->db->select('*');
        $this->db->where('cat_name', $cat_name);
        $this->db->from('product_category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function remove_category($cat_id) {
        try {
            $this->db->where('cat_id', $cat_id);
            $this->db->delete('product_category');
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    public function insertCategory($data) {
        try {
            $this->db->insert('product_category', $data);
            return $this->db->insert_id();
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function updateCategory($data, $cat_id) {
        try {
            $this->db->where('cat_id', $cat_id);
            $this->db->update('product_category', $data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function get2LevelCategories() {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where("parent_id", 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result_array();


            if ($categories) {

                $data = array();

                for ($x = 0; $x < count($categories); $x++) {

                    $data[$x] = $categories[$x];

                    $this->db->select('*');
                    $this->db->from('product_category');
                    $this->db->where("parent_id", $categories[$x]['cat_id']);
                    $query = $this->db->get();
                    if ($query->num_rows() > 0) {
                        $data[$x]['child'] = $query->result_array();
                    }
                }
                return $data;
            }
        } else {
            return false;
        }
    }

    /**
     * Get a category item by its url
     *
     * @param $url
     * @return bool
     */
    public function getCategoryByUrl($url) {
        $this->db->select('*');
        $this->db->where('url', $url);
        $this->db->from('product_category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function check_category_id($cat_id) {
        $query = $this->db->select('cat_id')
                ->from('product_category')
                ->where('cat_id', $cat_id)
                ->get();
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return false;
    }

    public function createCategoryLevel($parent_id) {
        if ($parent_id == 0) {
            $level = 1;
            return $level;
        } else {
            $this->db->select('level');
            $this->db->from('product_category');
            $this->db->where('cat_id', $parent_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return (($query->row()->level) + 1);
            } else {
                return false;
            }
        }
    }

    /**
     * Get current child categories of $parentId category
     *
     * @param $parentId
     * @return bool
     */
    public function getChildCategories($parentId) {
        $query = $this->db->get_where('product_category', array('parent_id' => $parentId));

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getCategoryParent($cat_id) {

        $catData = $this->getSingleCategory($cat_id);

        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('cat_id',$catData->parent_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function insert_product_category_list($data) {
        try {
            $this->db->insert('product_category_list', $data);
            return $this->db->insert_id();
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function get_parent_id_by_category($category_id) {
        $query = $this->db->select('parent_id, level')
                ->from('product_category')
                ->where('cat_id', $category_id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

}
