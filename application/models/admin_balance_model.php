<?php
/**
 * User: AbdullahAlJahid
 * Date: 7/13/14
 * Time: 3:37 PM
 */

/**
 * Admin balance is where all balance credit notes are stored.
 * Admin balance currently only populate during a user pays to another user.
 *
 * So this balance data store those information, ex - product_id, milestone id, fee taken from and finally the amount.
 *
 * Class Admin_balance
 */
class Admin_balance_model extends CI_Model {

    /**
     * Add balance to admin balance
     * ============================
     *
     * @param $product_id
     * @param $milestone_id
     * @param $fee_taken_from
     * @param $amount
     * @return bool
     */
    public function add($product_id, $milestone_id,$percent, $fee_taken_from, $amount) {
        $this->db->set('created','NOW()', false);
        $this->db->insert('admin_balance', array(
            'product_id'    => $product_id,
            'milestone_id'  => $milestone_id,
            'fee_percent'=> $percent,
            'fee_taken_from'=> $fee_taken_from,
            'amount'        => $amount
        ));
        return true;
    }

    public function getAllAdminBalance(){
        $this->db->select('*');
        $this->db->from('admin_balance');
        $this->db->order_by('created','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function getMilestoneDetails($id){
        $this->db->select('milestone.*,
        product.name AS product_name,
        product.product_id AS product_name_id,
        a.user_name AS from_name,
        b.user_name AS to_name,
        c.user_name AS initiated_name,
        ');
        $this->db->from('milestone');
        $this->db->join('product', 'product.product_id = milestone.product_id', 'LEFT');
        $this->db->join('user a', 'a.id = milestone.from_id', 'LEFT');
        $this->db->join('user b', 'b.id = milestone.to_id', 'LEFT');
        $this->db->join('user c', 'c.id = milestone.initiated_by', 'LEFT');
        $this->db->where('milestone.id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }


    public function getBalanceDetails($id){
        $this->db->select('*');
        $this->db->from('admin_balance');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }


    public function existBalane($id){
        $this->db->select('*');
        $this->db->from('admin_balance');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}