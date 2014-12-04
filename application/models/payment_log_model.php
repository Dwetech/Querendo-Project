<?php

/*
  Created on : May 26, 2014, 3:01:51 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Payment_log_model extends CI_Model {

    function add_payment_log($insert_data) {
        try {
            $this->db->insert('payment_log', $insert_data);
            return $this->db->insert_id();
        }
        catch (Exception $ex) {
            return false;
        }
    }

}
