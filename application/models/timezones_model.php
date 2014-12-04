<?php

/*
  Created on : May 25, 2014, 4:35:03 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Timezones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_timezones() {
        $query = $this->db->select('*')->from('timezones')->get('');
        if ($query->num_rows() > 1) {
            return $query->result();
        }
        else {
            return false;
        }
    }
    
    function get_timezone($condition) {
        $this->db->select('*');
        $this->db->from('timezones');
        $this->db->where($condition);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

}
