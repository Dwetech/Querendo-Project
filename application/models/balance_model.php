<?php

class Balance_model extends CI_Model {

    public function addBalance($data) {


        try {


            $this->db->set('created', 'NOW()', False);
            $this->db->insert('balance', $data);
            $insertBalance = $this->db->insert_id();



            $updateTotalBalance = $this->updateUserBalance($data['user_id']);
            if ($updateTotalBalance) {


                $userData = $this->getUserCurrentBalance($data['user_id']);

                try {


                    $data = array(
                        'currentBalance' => $userData->balance
                    );
                    $this->db->where('balance_id', $insertBalance);
                    $this->db->update('balance', $data);
                    return $insertBalance;
                }
                catch (Exception $e) {


                    return false;
                }
            } else {


                return false;
            }
        }
        catch (Exception $e) {


            return false;
        }
    }

    public function updateUserBalance($user_id) {
        try {


            $credit = $this->getUserCreditBalance($user_id);
            $debit = $this->getUserDebitBalance($user_id);
            $balance = $credit->amount - $debit->amount;
            $data = array(
                'balance' => $balance
            );
            $this->db->where('id', $user_id);
            $this->db->update('user', $data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function getUserCreditBalance($user_id) {
        $this->db->select_sum('amount');
        $this->db->from('balance');
        $this->db->where('user_id', $user_id);
        $this->db->where('type', 'credit');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getUserDebitBalance($user_id) {
        $this->db->select_sum('amount');
        $this->db->from('balance');
        $this->db->where('user_id', $user_id);
        $this->db->where('type', 'debit');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getUserCurrentBalance($user_id) {
        $this->db->select('balance');
        $this->db->from('user');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getTotalBalance($user_id, $limit, $offset) {
        $this->db->select('*, DATE_FORMAT(created, "%e %b, %Y") AS date', FALSE);
        $this->db->from('balance');
        $this->db->where('user_id', $user_id);
        $this->db->order_by("created", "desc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function countTotalBalance($user_id) {
        $this->db->select('*');
        $this->db->from('balance');
        $this->db->where('user_id', $user_id);
        $this->db->order_by("created", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function getUserBalanceList($user_id,$type) {

        $current_year = date('Y');
        $current_month = date('m');
        $days_in_month = date('t', mktime(0, 0, 0, $current_month, 1, $current_year));
        $start_date = $current_year . '-' . $current_month . '-01 00:00:00';
        $end_date = $current_year . '-' . $current_month . '-' . $days_in_month . ' 24:00:00';

        $this->db->select('balance_id, type, sum(amount) AS amount, user_id , created, DATE_FORMAT(created,"%d") AS dates, DATE_FORMAT(created,"%d") AS today', False);
        $this->db->from('balance');
        $this->db->group_by('today');
        $this->db->where('user_id', $user_id);
        $this->db->where('type', $type);
        $this->db->where('created >=', $start_date);
        $this->db->where('created <=', $end_date);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addWithdraw($data) {
        try {
            $this->db->set('create_date', 'NOW()', False);
            $this->db->insert('withdraw_request', $data);
            return $this->db->insert_id();
        }
        catch (Exception $e) {
            return false;
        }
    }

    function create_balance_description_data($product_id, $from_id, $type) {

        //Getting product data
        if ($type == 'release') {

            $query = $this->db->select('product.product_id, product.name, product.user_id, user.user_name')
                    ->from('product')
                    ->join('bids', 'bids.product_id = product.product_id')
                    ->join('user', 'product.user_id = user.id')
                    ->where('product.product_id', $product_id)
                    ->where('product.user_id', $from_id)
                    ->where('bids.status', 'Awarded')
                    ->where('product.status', 'Awarded')
                    ->get();
        } else if ($type == 'accept') {

            $query = $this->db->select('bids.product_id, product.name, bids.user_id, user.user_name')
                    ->from('bids')
                    ->join('product', 'product.product_id = bids.product_id')
                    ->join('user', 'bids.user_id = user.id')
                    ->where('product.product_id', $product_id)
                    ->where('product.user_id', $from_id)
                    ->where('bids.status', 'Awarded')
                    ->where('product.status', 'Awarded')
                    ->get();
        }
        
        
        
        if ($query->num_rows() > 0) {

            $product_data = $query->row();


            //Generating description data
            if ($type == 'release') {

                $description = 'Payment release by <a href="user/view/' . $product_data->user_name . '">' . $product_data->user_name . '</a> for product <a href="' . base_url() . 'product/view/' . $product_data->product_id . '">' . $product_data->name . '</a>.';
            } else if ($type == 'accept') {

                $description = 'Payment to <a href="user/view/' . $product_data->user_name . '">' . $product_data->user_name . '</a> for product <a href="' . base_url() . 'product/view/' . $product_data->product_id . '">' . $product_data->name . '</a>.';
            }


            return $description;
        }
    }

}
