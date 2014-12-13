<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/4/14
 * Time: 1:50 PM
 */
class Product_model extends CI_Model {

    function getProductByReview($user_id) {
        $query = $this->db->query(
                "SELECT DISTINCT product.product_id, product.name, product.status, DATE_FORMAT(bids.create_date, '%e %b, %Y') AS product_date "
                . "FROM product "
                . "JOIN bids ON product.product_id = bids.product_id "
                . "JOIN invoice ON invoice.product_id = product.product_id "
                . "WHERE (product.user_id = $user_id OR bids.user_id = $user_id) "
                . "AND product.status = 'Completed' "
                . "AND bids.status = 'Completed' "
                . "AND product.product_id NOT IN (SELECT product_id FROM review WHERE from_id = $user_id) "
                . "AND invoice.status = 'paid' "
                . "ORDER BY bids.create_date DESC "
        );
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchProduct($search) {
        $srting = explode(' ', $search);
        $this->db->select('product.*, DATE_FORMAT(create_date, "%e %b, %Y") AS create_date', FALSE);
        $this->db->from('product');
        $this->db->where('status', 'running');
        foreach ($srting as $val) {
            $this->db->where("(`name` LIKE '%$val%'");
            $this->db->or_where("`description` LIKE '%$val%')");
        }
        $this->db->order_by("create_date", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function checkStatus($product_id, $status) {
        $this->db->where('product_id', $product_id);
        $this->db->where('status', $status);
        $data = $this->db->count_all_results('bids');
        if ($data > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function userBidExist($user_id, $product_id) {
        $this->db->select('id');
        $this->db->from('bids');
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function userProductExist($user_id, $product_id) {
        $this->db->select('product_id');
        $this->db->from('product');
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function exist_category_product($cat_id) {
        $this->db->select('*');
        $this->db->where('category_id', $cat_id);
        $this->db->from('product');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function bidCount($product_id) {
        $this->db->where('product_id', $product_id);
        $query = $this->db->count_all_results('bids');
        if ($query > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    public function get_all_cat_pro($cat_id) {

        $this->db->select('product.*, DATE_FORMAT(product.create_date, "%e %b, %Y") AS create_date', FALSE);
        $this->db->from('product_category_list');
        $this->db->join('product', 'product.product_id = product_category_list.product_id');
        $this->db->where('product_category_list.product_category_id', $cat_id);
        $this->db->where('product.status', 'running');
        $this->db->where('product.activity', 1);
        $this->db->order_by("product.create_date", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }

    public function count_all_cat_pro($cat_url) {

        $this->db->select('COUNT(product.product_id) AS product_count');
        $this->db->from('product_category_list');
        $this->db->join('product', 'product.product_id = product_category_list.product_id');
        $this->db->join('product_category', 'product_category.cat_id = product_category_list.product_category_id');
        $this->db->where('product_category.url', $cat_url);
        $this->db->where('product.status', 'running');
        $this->db->where('product.activity', 1);
        $this->db->order_by('product.create_date', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return false;
    }

    public function getNumberOfProduct($cat_id) {
        $this->db->select('*');
        $this->db->where('category_id', $cat_id);
        $this->db->where('status', 'running');
        $this->db->where('activity', 1);
        $this->db->from('product');
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getProductList() {
        $this->db->select('*');
        $this->db->where('activity', '1');
        $this->db->where('status', 'running');
        $this->db->from('product');
        $this->db->join('product_category', 'product.category_id = product_category.cat_id','LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getTrashProductList() {
        $this->db->select('*');
        $this->db->where('activity', '0');
        $this->db->where('status', 'running');
        $this->db->from('product');
        $this->db->join('product_category', 'product.category_id = product_category.cat_id','LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_products() {
        $this->db->select('*, user.status AS user_status, product.status AS product_status');
        $this->db->from('product');
        $this->db->join('user', 'product.user_id = user.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function insert_product($table, $data) {
        $this->db->set('create_date', 'NOW()', false);
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function update_product($update_data, $product_id) {
        try {
            $this->db->set('complete_date', 'NOW()', FALSE);
            $this->db->where('product_id', $product_id);
            $this->db->update('product', $update_data);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    public function getProductData($product_id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getTotalProductData($product_id) {
        $this->db->select('user.*, product.product_id,product.budget_type,product.fixed_budget, product.user_id, product.status AS product_status, product.name, product.category_id, product.description, product.shipping_method, product.shipping_cost, product.product_condition, product.product_photo, product.min_budget, product.max_budget, product.create_date, product.transaction_status');
        $this->db->from('product');
        $this->db->join('user', 'user.id = product.user_id', 'LEFT');
        $this->db->where('product.product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function isExist($product_id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isActive($product_id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $this->db->where('activity', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllImages($table, $column, $product_id) {
        $this->db->select($table . '.' . $column);
        $this->db->where('product_id', $product_id);
        $this->db->from($table);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function remove_product($product_id) {
        try {
            $this->db->where('product_id', $product_id);
            $this->db->delete('product');
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    public function trash_product($product_id, $update_data) {
        try {
            $this->db->where('product_id', $product_id);
            $this->db->update('product', $update_data);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    public function remove_product_bid($product_id) {
        try {
            $this->db->where('product_id', $product_id);
            $this->db->delete('bids');
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function get_products_by_user($user_id, $limit, $offset) {
        $this->db->select('*, DATE_FORMAT(product.create_date, "%e %b, %Y") AS product_create_date', FALSE);
        $this->db->from('product');
        $this->db->where('product.user_id', $user_id);
        $this->db->where('product.activity', 1);
        $this->db->order_by("product.create_date", "desc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function count_products_by_user($user_id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product.user_id', $user_id);
        $this->db->where('product.activity', 1);
        $this->db->order_by("product.create_date", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function get_product_by_id($product_id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_user_activities($user_id) {

        //Initializing empty array
        $user_news = array();

        //Getting completed/winning bids of user
        $bids = $this->db->select('bids.product_id, bids.status, bids.user_id AS bidder_id, product.complete_date AS date_time_string, product.name AS product_name, product.user_id AS product_owner_id, user.user_name, bids.bid_amount, product.description', FALSE)
                ->from('bids')
                ->join('product', 'product.product_id = bids.product_id', 'LEFT')
                ->join('user', 'user.id = product.user_id', 'LEFT')
                ->where('bids.user_id', $user_id)
                ->where('product.complete_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()')
                ->get();

        if ($bids->num_rows() > 0) {

            $user_news['winning_bids'] = $bids->result_array();

            //Inserting key 'bids' to identify the result of this query later
            for ($x = 0; $x < sizeof($user_news['winning_bids']); $x++) {

                array_push($user_news['winning_bids'][$x], 'bids');
            }
        } else {

            $user_news['winning_bids'] = array();
        }





        //Getting awarded product of user
        $products = $this->db->select('bids.product_id, bids.status, bids.user_id AS bidder_id, product.complete_date AS date_time_string, product.name AS product_name, product.user_id AS product_owner_id, user.user_name', FALSE)
                ->from('product')
                ->join('bids', 'product.product_id = bids.product_id', 'LEFT')
                ->join('user', 'user.id = bids.user_id', 'LEFT')
                ->where('product.user_id', $user_id)
                ->where('product.status', 'Awarded')
                ->where('product.complete_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()')
                ->get();

        if ($products->num_rows() > 0) {

            $user_news['awarded_products'] = $products->result_array();

            //Inserting key 'bids' to identify the result of this query later
            for ($x = 0; $x < sizeof($user_news['awarded_products']); $x++) {

                array_push($user_news['awarded_products'][$x], 'products');
            }
        } else {

            $user_news['awarded_products'] = array();
        }





        //Getting review to user
        $reviews = $this->db->select('review.rating, review.message, review.product_id, review.create_date AS date_time_string, product.name AS product_name, user.user_name, user.profile_pic', FALSE)
                ->from('review')
                ->join('product', 'product.product_id = review.product_id')
                ->join('user', 'user.id = review.from_id')
                ->where('review.user_id', $user_id)
                ->where('review.create_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()')
                ->get();

        if ($reviews->num_rows() > 0) {

            $user_news['my_review'] = $reviews->result_array();

            //Inserting key 'review' to identify the result of this query later
            for ($x = 0; $x < sizeof($user_news['my_review']); $x++) {

                array_push($user_news['my_review'][$x], 'review');
            }
        } else {

            $user_news['my_review'] = array();
        }



        //Getting bidder's product transaction status
        $bidder_transaction_status = $this->db->query('
        SELECT
            product.create_date AS date_time_string,
            product.name AS product_name,
            product.product_id,
            user.user_name AS user_name,
            user.id,
            product.transaction_status,
            bids.bid_amount,
            owner.user_name as owner_name
        FROM product
        JOIN bids
            ON bids.product_id = product.product_id
        JOIN user
            ON user.id = bids.user_id
        JOIN user owner
            ON owner.id = product.user_id
        WHERE
            (
                product.transaction_status = "payment_sent"
                OR product.transaction_status = "product_received"
            )
            AND
            (
                bids.status = "Awarded"
                OR bids.status = "Completed"
            )
            AND
                user.id = '.$user_id
        );
        
        if ($bidder_transaction_status->num_rows() > 0) {
            
            $user_news['bidder_transactions'] = $bidder_transaction_status->result_array();
            
            //Inserting key 'review' to identify the result of this query later
            for ($x = 0; $x < sizeof($user_news['bidder_transactions']); $x++) {

                array_push($user_news['bidder_transactions'][$x], 'bidder_transactions');
            }
        } else {
            $user_news['bidder_transactions'] = array();
        }
        
        
        //Getting product owner's transaction status
        $owner_transaction_status = $this->db->query('SELECT product.create_date AS date_time_string, product.name AS product_name, product.product_id, user.user_name AS user_name, user.id, product.transaction_status FROM product JOIN user ON user.id = product.user_id WHERE (product.transaction_status = "payment_received" OR product.transaction_status = "product_sent") AND (product.status = "awarded" OR product.status = "completed") AND user.id = '.$user_id);
        
        if ($owner_transaction_status->num_rows() > 0) {
            
            $user_news['owner_transactions'] = $owner_transaction_status->result_array();
            
            //Inserting key 'review' to identify the result of this query later
            for ($x = 0; $x < sizeof($user_news['owner_transactions']); $x++) {

                array_push($user_news['owner_transactions'][$x], 'owner_transactions');
            }
        } else {
            $user_news['owner_transactions'] = array();
        }



        /* //Getting milestone to user
          $milestone = $this->db->query('
          (SELECT milestone.amount, milestone.status, milestone.description, milestone.create_date AS date_time_string,
          user.user_name, user.profile_pic, user.id AS milestone_from_id, product.name, product.product_id, product.user_id AS product_owner_id
          FROM (milestone)
          JOIN product ON product.product_id = milestone.product_id
          JOIN user ON user.id = milestone.to_id
          WHERE milestone.from_id = ' . $user_id .
          ' AND product.complete_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW())
          UNION
          (SELECT milestone.amount, milestone.status, milestone.description, milestone.create_date AS date_time_string, user.user_name, user.profile_pic,
          user.id AS milestone_from_id, product.name, product.product_id, product.user_id AS product_owner_id
          FROM (milestone)
          JOIN product ON product.product_id = milestone.product_id
          JOIN user ON user.id = milestone.from_id
          WHERE milestone.to_id = ' . $user_id .
          ' AND product.complete_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
          )');
          if ($milestone->num_rows() > 0) {

          $user_news['my_milestone'] = $milestone->result_array();

          //Inserting key 'milestone' to identify the result of this query later
          for ($x = 0; $x < sizeof($user_news['my_milestone']); $x++) {

          array_push($user_news['my_milestone'][$x], 'milestone');
          }
          } else {

          $user_news['my_milestone'] = array();
          } */

        //Merging 3 arrays into one array
        $data1 = array_merge($user_news['winning_bids'], $user_news['my_review']);
        //$data2 = array_merge($data1, $user_news['my_milestone']);
        $data2 = array_merge($data1, $user_news['bidder_transactions']);
        $data3 = array_merge($data2, $user_news['owner_transactions']);
        $data = array_merge($data3, $user_news['awarded_products']);
        $this->load->helper('function');

        //Sorting array data by datetime
        usort($data, 'sortFunction');
        array_unshift($data, sizeof($data));
        return $data;
    }

    function getAllDataByCatSearch($search, $category) {

        $srting = explode(' ', $search);
        $this->db->select('product.*,product_category.*, DATE_FORMAT(create_date, "%e %b, %Y") AS date', FALSE);
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.cat_id = product.category_id', 'LEFT');

        foreach ($srting as $val) {
            $this->db->where("(`name` LIKE '%$val%'");
            $this->db->or_where("`description` LIKE '%$val%')");
        }
        $this->db->order_by("create_date", "desc");
        $this->db->where('category_id', $category);
        $this->db->where('status', 'running');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getAllDataBySearch($search) {

        $srting = explode(' ', $search);
        $this->db->select('product.*,product_category.*, DATE_FORMAT(create_date, "%e %b, %Y") AS date', FALSE);
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.cat_id = product.category_id', 'LEFT');

        foreach ($srting as $val) {
            $this->db->where("(`name` LIKE '%$val%'");
            $this->db->or_where("`description` LIKE '%$val%')");
        }
        $this->db->where('status', 'running');
        $this->db->order_by("create_date", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getAllDataByCat($category) {

        $this->db->select('product.*,product_category.*, DATE_FORMAT(create_date, "%e %b, %Y") AS date', FALSE);
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.cat_id = product.category_id', 'LEFT');
        $this->db->order_by("create_date", "desc");
        $this->db->where('category_id', $category);
        $this->db->where('status', 'running');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function check_product_data($credentials) {
        $query = $this->db->select('*')
                ->from('product')
                ->where($credentials)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function check_product_status($credentials) {
        $query = $this->db->select('product.*')
                ->from('product')
                ->join('user', 'user.id = product.user_id')
                ->where($credentials)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function check_product_bid_data($bid_id, $user_id, $product_status, $bid_status) {
        $query = $this->db->select('bids.*, bids.id AS bid_id, bids.user_id AS bidder_id, product.*, product.user_id AS product_owner_id')
                ->from('bids')
                ->join('product', 'product.product_id = bids.product_id')
                ->join('user', 'bids.user_id = user.id')
                ->where('bids.id', $bid_id)
                ->where('product.user_id', $user_id)
                ->where('user.status', 1)
                ->where('product.status', $product_status)
                ->where('bids.status', $bid_status)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function check_cancel_bid_data($bid_id, $user_id, $product_status, $bid_status) {
        $query = $this->db->select('bids.*, bids.id AS bid_id, bids.user_id AS bidder_id, product.*, product.user_id AS product_owner_id')
                ->from('bids')
                ->join('product', 'product.product_id = bids.product_id')
                ->where('bids.id', $bid_id)
                ->where("(product.user_id = $user_id OR bids.user_id = $user_id)")
                ->where('product.status', $product_status)
                ->where('bids.status', $bid_status)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function check_confirm_bid_data($bid_id, $user_id, $product_status, $bid_status) {
        $query = $this->db->select('bids.*, bids.id AS bid_id, bids.user_id AS bidder_id, product.*, product.user_id AS product_owner_id')
                ->from('bids')
                ->join('product', 'product.product_id = bids.product_id')
                ->join('user', 'product.user_id = user.id')
                ->where('bids.id', $bid_id)
                ->where('bids.user_id', $user_id)
                ->where('user.status', 1)
                ->where('product.status', $product_status)
                ->where('bids.status', $bid_status)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function check_product_transaction_status($product_id) {
        $query = $this->db->select('product_id')
                ->from('product')
                ->where('product_id', $product_id)
                ->where('transaction_status = "payment_sent" OR transaction_status = "payment_received" OR transaction_status = "product_sent" OR transaction_status = "product_received"')
                ->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_product_bid_by_product_id($product_id) {
        $query = $this->db->select('product.name, product.user_id AS product_user_id, bids.id, bids.user_id AS bid_user_id')
                ->from('product')
                ->join('bids', 'product.product_id = bids.product_id')
                ->where('bids.status', 'Awarded')
                ->where('product.product_id', $product_id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update_product_transaction_status($product_id, $update_data) {

        try {
            $this->db->where('product_id', $product_id);
            $this->db->update('product', $update_data);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

}
