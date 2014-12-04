<?php

/*
  Created on : Aug 9, 2014, 4:59:35 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Invoice_model extends CI_Model {

    /**
     * 
     * @param type array | $insert_data
     * @return boolean|integer
     * Inserting data to the invoice table
     */
    function insert_invoice($insert_data) {
        try {
            $this->db->set('create_date', 'NOW()', FALSE);
            $this->db->insert('invoice', $insert_data);
            return $this->db->insert_id();
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function check_invoice_by_product_id($product_id) {
        $query = $this->db->select('*')
                ->from('invoice')
                ->where('product_id', $product_id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_invoices_by_user($user_id, $limit, $offset) {
        $query = $this->db->select('invoice.*, product.name')
                ->from('invoice')
                ->join('product', 'product.product_id = invoice.product_id', 'LEFT')
                ->where('invoice.user_id', $user_id)
                ->limit($limit, $offset)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function count_invoices_by_user($user_id) {

        $this->db->from('invoice')
                ->join('product', 'product.product_id = invoice.product_id', 'LEFT')
                ->where('invoice.user_id', $user_id);
        return $this->db->count_all_results();
    }

}
