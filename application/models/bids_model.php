<?php

/*
  Created on : May 29, 2014, 6:03:37 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Bids_model extends CI_Model {

    public function insert_bid($data) {
        $this->db->set('create_date', 'NOW()', false);
        $this->db->insert('bids', $data);
        return $this->db->insert_id();
    }

    /**
     * Update bid information
     *
     * @param $id
     * @param $data
     * @return bool
     */
    function update_bid($id, $data) {
        try {
            $this->db->where('id', $id);
            $this->db->update('bids', $data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    function check_bid_status_by_user($credentials) {
        $this->db->select('*');
        $this->db->from('bids');
        $this->db->where($credentials);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function delete_bid($condition) {
        try {
            $this->db->delete('bids', $condition);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function get_bid_details_by_id($bid_id) {
        $this->db->select('*');
        $this->db->from('bids');
        $this->db->where('id', $bid_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function count_bid_by_product($product_id) {
        $this->db->select('COUNT(product_id) AS count_product');
        $this->db->from('bids');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function highetst_bid_by_product($product_id) {
        $this->db->select('MAX(bid_amount) AS max_bid');
        $this->db->from('bids');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function average_bid_by_product($product_id) {
        $this->db->select('AVG(bid_amount) AS avg_bid');
        $this->db->from('bids');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function lowest_bid_by_product($product_id) {
        $this->db->select('MIN(bid_amount) AS min_bid');
        $this->db->from('bids');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_bids_by_product_id($product_id) {
        $this->db->select('*');
        $this->db->from('bids');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function count_bids($user_id, $condition) {
        $query = $this->db->query("SELECT COUNT(bids.product_id) AS numrows FROM bids join product on product.product_id = bids.product_id  WHERE bids.user_id = $user_id AND product.activity=1 $condition");
        return $query->row();
    }

    function get_bids_by_user($user_id, $where, $limit, $offset = false) {

        $this->db->select('*, bids.status AS bid_status, DATE_FORMAT(bids.create_date, "%e %b, %Y") AS bid_create_date  ', FALSE);
        $this->db->from('bids');
        $this->db->join('product', 'product.product_id = bids.product_id', 'LEFT');
        $this->db->where('bids.user_id', $user_id);
        $this->db->where('product.activity', 1);
        $this->db->where($where);
        $this->db->order_by('bids.create_date', 'DESC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_all_bids_by_product_id($product_id) {
        $this->db->select('bids.*, bids.id AS bid_id, bids.user_id AS bidder_id, user.user_name, user.id, user.email, user.first_name, user.last_name, user.city, user.state, user.postal_code, user.country, user.timezone, user.company, user.profile_pic, user.member_since, user.contact_address, user.contact_number, user.shipping_address, user.fax, user.buyer_review, user.buyer_review_count, user.seller_review, user.seller_review_count, country.iso_code_2, country.name');
        $this->db->from('bids');
        $this->db->join('user', 'user.id = bids.user_id', 'LEFT');
        $this->db->join('country', 'country.country_id = user.country', 'LEFT');
        $this->db->order_by("user.seller_review","desc");
        $this->db->order_by("user.seller_review_count","desc");
        $this->db->order_by("bids.create_date","asc");
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_product_bid_count_and_average($product_id) {
        $this->db->select('COUNT(product_id) as bid_count, AVG(bid_amount) as bid_avg');
        $this->db->where('product_id', $product_id);
        $this->db->from('bids');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_awarded_bid_details($condition) {

        $this->db->select('*');
        $this->db->from('bids');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

}
