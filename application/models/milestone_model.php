<?php

/*
  Created on : Jun 17, 2014, 2:23:20 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Milestone_model extends CI_Model {

    function get_milestone_by_product_and_user($product_id, $from_id, $to_id) {
        $query = $this->db->query("SELECT * FROM (milestone) WHERE product_id = $product_id AND (from_id = $from_id OR from_id = $to_id AND to_id = $to_id OR to_id = $from_id) ORDER BY create_date ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function get_milestone_by_id($milestone_id) {
        $this->db->select('*');
        $this->db->from('milestone');
        $this->db->where('id', $milestone_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    function get_milestne_product($condition) {
        $query = $this->db->select('milestone.*, product.user_id, product.name')
                ->from('milestone')
                ->join('product', 'product.product_id = milestone.product_id')
                ->join('bids', 'bids.product_id = milestone.product_id')
                ->join('user', 'bids.user_id = user.id')
                ->where('user.status', 1)
                ->where('bids.status', 'Awarded')
                ->where('product.status', 'awarded')
                ->where('bids.user_id = milestone.to_id')
                ->where('product.user_id = milestone.from_id')
                ->where($condition)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    function sum_released_milestone_by_product_id($product_id) {
        $query = $this->db->query("SELECT SUM(amount) AS released_milestone_amount FROM milestone WHERE product_id=$product_id AND status='released'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    function sum_milestone_by_product_id($product_id) {
        $query = $this->db->query("SELECT SUM(amount) AS milestone_amount FROM milestone WHERE product_id=$product_id");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function insert_milestone($data) {
        try {
            $this->db->set('create_date', 'NOW()', false);
            $this->db->insert('milestone', $data);
            return $this->db->insert_id();
        }
        catch (Exception $e) {
            return false;
        }
    }

    function update_milestone($update_data, $where) {
        try {
            $this->db->set('create_date', 'NOW()', false);
            $this->db->where($where);
            $this->db->update('milestone', $update_data);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

}
