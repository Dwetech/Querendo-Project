<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/4/14
 * Time: 1:50 PM
 */
class Admin_model extends CI_Model {

    function login_access($value) {
        $this->db->where($value);
        $query = $this->db->get('admin_user');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function checkAdminLogin($email){
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function getAdminData($admin_id){
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where('user_id', $admin_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function changePassword($update_data,$admin_id){
        try {
            $this->db->where('user_id', $admin_id);
            $this->db->update('admin_user', $update_data);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function logout(){
        unset($_SESSION['admin_user_id']);
        unset($_SESSION['logged_in']);
        unset($_SESSION['admin_email']);

        $this->logged_in = false;

        return true;
    }

}
