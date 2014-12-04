<?php

/*
  Created on : Jun 22, 2014, 5:40:05 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Review_model extends CI_Model {

    function get_review_by_user($user_id, $type) {
        $this->db->select('*');
        $this->db->from('review');
        $this->db->where('user_id', $user_id);
        $this->db->where('type', $type);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function make_review($insert_data) {
        try {
            $this->db->set('create_date', 'NOW()', FALSE);
            $this->db->insert('review', $insert_data);
            return $this->db->insert_id();
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function check_review_eligibility($product_id, $user_id, $from_id) {

        $query = $this->db->select("product.product_id")
                ->from('product')
                ->join('bids', 'bids.product_id = product.product_id')
                ->where('product.product_id', $product_id)
                ->where('bids.product_id', $product_id)
                ->where("(product.user_id = $user_id OR product.user_id = $from_id)")
                ->where("(bids.user_id = $user_id OR bids.user_id = $from_id)")
                ->where('bids.status', 'Completed')
                ->where('product.status', 'completed')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

}
