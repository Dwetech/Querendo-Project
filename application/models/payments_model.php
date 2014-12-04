<?php

/* 
    Created on : Jun 18, 2014, 12:44:08 PM
    Author        : me@rafi.pro
    Name         : Mohammad Faozul Azim Rafi
*/

class Payments_model extends CI_Model{
    
    function check_payment_by_user($user_id) {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else {
            return false;
        }
    }

    function add_payment($insert_data) {
        try {
            $this->db->insert('payments', $insert_data);
            return $this->db->insert_id();
        }
        catch (Exception $ex) {
            return false;
        }
    }
}