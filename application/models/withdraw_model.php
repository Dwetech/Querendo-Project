<?php


class Withdraw_model extends CI_Model
{


    public function getAllWithdraw()
    {
        $this->db->select('*');
        $this->db->from('withdraw_request');
        $this->db->order_by("create_date","desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getStatusWithdraw($status)
    {
        $this->db->select('*');
        $this->db->from('withdraw_request');
        $this->db->where('status', $status);
        $this->db->order_by("create_date","desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getWithdrawData($withdraw_id)
    {
        $this->db->select('*');
        $this->db->from('withdraw_request');
        $this->db->where("withdraw_id",$withdraw_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function existWithdraw($withdraw_id)
    {
        $this->db->select('withdraw_id');
        $this->db->from('withdraw_request');
        $this->db->where("withdraw_id",$withdraw_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return True;
        } else {
            return false;
        }
    }

    public function getWithdrawList($user_id)
    {
        $this->db->select('*');
        $this->db->from('withdraw_request');
        $this->db->where('user_id', $user_id);
        $this->db->order_by("create_date","desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function updateWithdrawStatus($withdraw_id, $data)
    {
        try {
            $this->db->where('withdraw_id', $withdraw_id);
            $this->db->update('withdraw_request', $data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


}
