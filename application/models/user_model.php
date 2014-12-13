<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/4/14
 * Time: 1:50 PM
 */
class User_model extends CI_Model {
    
    function check_profile_complete($user_id) {
        $query = $this->db->select('first_name, last_name, country, state, postal_code, contact_address, profile_pic, timezone, shipping_address')
                ->from('user')
                ->where('id', $user_id)
                ->get();
        if ($query->num_rows() > 0) {
            
            $data = $query->row();
            $empty_data = '';
            
            if (empty($data->first_name))
                $empty_data .= 'Nome, ';
            if (empty($data->last_name))
                $empty_data .= 'Sobrenome, ';
            if (empty($data->country))
                $empty_data .= 'país, ';
            if (empty($data->contact_address))
                $empty_data .= 'Endereço, ';
            if (empty($data->timezone))
                $empty_data .= 'Timezone, ';
            if (empty($data->shipping_address))
                $empty_data .= 'Shipping Address ';
            
            return $empty_data;
                
        } else {
            
            return false;
        }
    }

    /**
     * Check whether a user is exist or not by where array.
     *
     * @param $where array
     * @return bool
     */
    public function isUserExist($where) {
        $query = $this->db->get_where('user', $where);

        if( $query->num_rows() > 0 ){
            return $query->row();
        } else {
            return false;
        }
    }



    /**
     * Register an User
     * -----------------
     * Register a new user with given information.
     * User password are hashed into sha256 encryption along with a randomly
     * generated 4 character password key.
     * @param $username
     * @param $password
     * @param $email
     * @return bool
     */
    function user_registration($username, $password, $email, $verification_code) {

        //GETTING USER IP ADDRESS
        $userInfoByIp = getUserInfoByIp();

        $country = $this->getCountryId($userInfoByIp->countryCode);
        if ($country !== false) {
            $countryId = $country->country_id;
            $timezone = $userInfoByIp->timezone;
            $timezone_data = $this->get_timezone(array('timezone' => $timezone));
            $timezone_id = $timezone_data->id;
        } else {
            $timezone_id = '';
            $countryId = '';
        }

        $password = hash('sha256', $password);

        $user_data = array(
            'user_name' => $username,
            'email' => $email,
            'country' => $countryId,
            'password' => $password,
            'email_verify' => $verification_code,
            'timezone' => $timezone_id,
            'balance' => 0
        );


        try {
            $this->db->set('member_since', 'NOW()', FALSE);
            $this->db->insert('user', $user_data);
            return $this->db->insert_id();
        }
        catch (Exception $e) {
            return false;
        }
    }


    /**
     * Add a new user with given data
     * returns user id if success otherwise false
     * @param $data
     * @return bool
     */
    function add_user($data) {
        try {
            $this->db->set('member_since','now()',false);
            $this->db->insert('user',$data);
            return $this->db->insert_id();
        }
        catch (Exception $e) {
            return false;
        }

    }


    function get_timezone($condition) {
        $this->db->select('*');
        $this->db->from('timezones');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Login Access
     *
     * @param $value
     * @return mixed
     */
    function login_access($value) {
        $this->db->where($value);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function admin_login_access($value) {
        $this->db->where($value);
        $query = $this->db->get('admin_user');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_user_by_id($user_id) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function get_user_auth_data($credentials) {
        $this->db->select('*, country.name as country_name, DATE_FORMAT(user.member_since, "%e %b, %Y") AS member_since', False);
        $this->db->from('user');
        $this->db->join('country', 'user.country = country.country_id', 'LEFT');
        $this->db->where($credentials);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Update user information for a given user $id and with given $data
     *
     * @param $id
     * @param $data
     * @return bool
     */
    function update_an_user($id, $data) {
        try {
            $this->db->where('id', $id);
            $this->db->update('user', $data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    function get_user_by_key($key) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email_verify', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }



    function getCountryId($countryCode) {

        $this->db->select('country_id');
        $this->db->from('country');
        $this->db->where('iso_code_2', $countryCode);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function getCountryCode($country_id) {

        $this->db->select('*');
        $this->db->from('country');
        $this->db->where('country_id', $country_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function getReview($user_id) {

        $this->db->select('*');
        $this->db->from('review');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getReviewComplete($user_id, $from_id, $product_id) {

        $this->db->select('*');
        $this->db->from('review');
        $this->db->where('user_id', $user_id);
        $this->db->where('from_id', $from_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_review_by_product($user_id, $product_id) {
        $this->db->select('*');
        $this->db->from('review');
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }





    public function updateUserDataByUserId($user_id, $data) {
        try {
            $this->db->where('id', $user_id);
            $this->db->where('email_verify', '1');
            $this->db->update('user', $data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    function update_user($table, $data, $user_id) {
        try {
            $this->db->where('id', $user_id);
            $this->db->update($table, $data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    function get_user_data($where) {
        $this->db->select('user.*, country.name');
        $this->db->from('user');
        $this->db->join('country', 'user.country = country.country_id', 'LEFT');
        $this->db->where('user.email_verify', '1');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function getAllReviewWithProduct($user_id) {
        $query = $this->db->query("SELECT product.*, review.*, user.*, user.id AS users_id FROM review LEFT JOIN product ON review.product_id = product.product_id LEFT JOIN user ON review.from_id = user.id WHERE (review.user_id = $user_id OR review.from_id = $user_id) ORDER BY review.create_date DESC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getTotalUserData() {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('country', 'user.country = country.country_id', 'LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function searchUser($search) {
        $srting = explode(' ', $search);
        $this->db->select('user.*, DATE_FORMAT(member_since, "%e %b, %Y") AS member_since', FALSE);
        $this->db->from('user');
        $this->db->join('country', 'user.country = country.country_id', 'LEFT');
        foreach ($srting as $val) {
            $this->db->or_like('user_name', $val);
            $this->db->or_like('first_name', $val);
            $this->db->or_like('last_name', $val);
        }
        $this->db->order_by("member_since","desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function activity($user_id) {
        $this->db->select('*');
        $this->db->where('id', $user_id);
        $this->db->from('user');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->status;
        } else {
            return false;
        }
    }

    function getBalance($user_id) {
        $this->db->select('balance');
        $this->db->where('id', $user_id);
        $this->db->from('user');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function activityAction($user_id, $data) {
        $this->db->where('id', $user_id);
        $update = $this->db->update('user', $data);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    function getAllData($table) {
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getAllUserData() {
        $this->db->select('user.*, DATE_FORMAT(member_since, "%e %b, %Y") AS create_date', FALSE);
        $this->db->from('user');
        $this->db->order_by("seller_review","desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getAllDataByCountry($country) {
        $this->db->select('user.*, DATE_FORMAT(member_since, "%e %b, %Y") AS create_date', FALSE);
        $this->db->from('user');
        $this->db->where('country', $country);
        $this->db->order_by("seller_review","desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getAllDataBySearch($search) {

        $srting = explode(' ', $search);
        $this->db->select('user.*, DATE_FORMAT(member_since, "%e %b, %Y") AS create_date', FALSE);
        $this->db->from('user');

        foreach ($srting as $val) {
            $this->db->or_like('user_name', $val);
            $this->db->or_like('first_name', $val);
            $this->db->or_like('last_name', $val);
            $this->db->or_like('email', $val);
        }
        $this->db->order_by("seller_review","desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getAllDataByCountrySearch($search, $country) {

        $srting = explode(' ', $search);
        $this->db->select('user.*, DATE_FORMAT(member_since, "%e %b, %Y") AS create_date', FALSE);
        $this->db->from('user');

        foreach ($srting as $val) {
            $this->db->where("(`user_name` LIKE '%$val%'");
            $this->db->or_where("`first_name` LIKE '%$val%'");
            $this->db->or_where("`last_name` LIKE '%$val%'");
            $this->db->or_where("`email` LIKE '%$val%')");
        }
        $this->db->order_by("seller_review","desc");
        $this->db->where('country', $country);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function check_balance_by_user($where) {
        $this->db->select('balance, balance_status');
        $this->db->from('user');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function update_balance_by_user($where, $update_data) {
        try {
            $this->db->where($where);
            $this->db->update('user', $update_data);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function completeWorkBuyer($user_id) {
        $this->db->select('*, product.user_id as owner_id, bids.user_id as bidder_id');
        $this->db->from('product');
        $this->db->join('bids', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('product.user_id', $user_id);
        $this->db->where('product.status', 'Completed');
        $this->db->where('bids.status', 'Completed');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function count_completeWork_by_buyer($user_id) {
        $this->db->select('*, product.user_id as owner_id, bids.user_id as bidder_id');
        $this->db->from('product');
        $this->db->join('bids', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('product.user_id', $user_id);
        $this->db->where('product.status', 'Completed');
        $this->db->where('bids.status', 'Completed');
        return $this->db->count_all_results();
    }

    function completeWorkSeller($user_id) {
        $this->db->select('*,product.user_id as owner_id, bids.user_id as bidder_id');
        $this->db->from('bids');
        $this->db->join('product', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('bids.user_id', $user_id);
        $this->db->where('bids.status', 'Completed');
        $this->db->where('product.status', 'Completed');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function count_completeWork_by_seller($user_id) {
        $this->db->select('*,product.user_id as owner_id, bids.user_id as bidder_id, COUNT(product.product_id) AS work_count');
        $this->db->from('bids');
        $this->db->join('product', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('bids.user_id', $user_id);
        $this->db->where('bids.status', 'Completed');
        $this->db->where('product.status', 'Completed');
        return $this->db->count_all_results();
    }



    function runningWorkSeller($user_id) {
        $this->db->select('*, DATE_FORMAT(product.create_date, "%e %b, %Y") AS date', False);
        $this->db->from('bids');
        $this->db->join('product', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('bids.user_id', $user_id);
        $this->db->where('bids.status', 'Awarded');
        $this->db->where('product.status', 'Awarded');
        $this->db->order_by('product.create_date','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function count_runningWorkSeller($user_id) {
        $this->db->select('*');
        $this->db->from('bids');
        $this->db->join('product', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('bids.user_id', $user_id);
        $this->db->where('bids.status', 'Awarded');
        $this->db->where('product.status', 'Awarded');
        return $this->db->count_all_results();
    }

    function currentBidOn($user_id) {
        $this->db->select('*, DATE_FORMAT(product.create_date, "%e %b, %Y") AS date', False);
        $this->db->from('bids');
        $this->db->join('product', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('bids.user_id', $user_id);
        $this->db->where('bids.status', 'Regular');
        $this->db->where('product.status', 'running');
        $this->db->order_by('product.create_date','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function count_currentBidOn($user_id) {
        $this->db->select('*');
        $this->db->from('bids');
        $this->db->join('product', 'bids.product_id = product.product_id', 'LEFT');
        $this->db->where('bids.user_id', $user_id);
        $this->db->where('bids.status', 'Regular');
        $this->db->where('product.status', 'running');
        return $this->db->count_all_results();
    }

    function runningWorkBuyer($user_id) {
        $this->db->select('*, DATE_FORMAT(product.create_date, "%e %b, %Y") AS date', False);
        $this->db->from('product');
        $this->db->where('status', 'Awarded');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('product.create_date','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function count_runningWorkBuyer($user_id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('status', 'Awarded');
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results();
    }

    function activityComplete($user_id, $from_id, $product_id) {
        $this->db->select('*, DATE_FORMAT(review.create_date, "%e %b, %Y") AS date', False);
        $this->db->from('review');
        $this->db->join('user', 'user.id = review.from_id', 'LEFT');
        $this->db->where('review.user_id', $user_id);
        $this->db->where('review.from_id', $from_id);
        $this->db->where('review.product_id', $product_id);
        $this->db->order_by('review.create_date', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_review_by_user($condition) {
        $this->db->select('buyer_review, buyer_review_count, seller_review, seller_review_count');
        $this->db->from('user');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

}
