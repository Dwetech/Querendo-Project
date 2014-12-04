<?php

/*
  Created on : May 26, 2014, 3:01:51 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Country_model extends CI_Model {

    public function get_countries() {
        $query = $this->db->select('*')->from('country')->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        else {
            return false;
        }
    }

    public function get_country_by_user($id) {
        $this->db->select('country.*, user.id');
        $this->db->from('country');
        $this->db->join('user', 'user.country = country.country_id');
        $this->db->where('user.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    public function getCountryCOde($user_name) {
        $this->db->select('country.*, user.id');
        $this->db->from('country');
        $this->db->join('user', 'user.country = country.country_id');
        $this->db->where('user.user_name', $user_name);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        else {
            return false;
        }
    }

}
