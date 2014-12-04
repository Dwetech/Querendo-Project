<?php

/*
  Created on : Jun 11, 2014, 5:15:48 PM
  Author        : me@rafi.pro
  Name         : Mohammad Faozul Azim Rafi
 */

class Message_model extends CI_Model {

    function insert_thread($thread_data) {

        try {
            $this->db->set('create_date', 'NOW()', FALSE);
            $this->db->insert('thread', $thread_data);
            return $this->db->insert_id();
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function insert_message($message_data) {

        try {
            $this->db->set('create_date', 'NOW()', FALSE);
            $this->db->insert('message', $message_data);
            return $this->db->insert_id();
        }
        catch (Exception $ex) {
            return false;
        }
    }

    function get_conversation($thread_id, $message_id) {
        $this->db->select('message.*, user.profile_pic');
        $this->db->from('message');
        $this->db->join('user', 'user.id = message.from_id', 'LEFT');
        $this->db->where('message.thread_id', $thread_id);
        $this->db->where("message.id > $message_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Getting conversation persons with the logged in user
     * by user id
     * @param type $user_id
     * @return 
     */
    function getMyUser($user_id) {
        $query = $this->db->query(
                "(SELECT thread.thread_id AS thread_id, thread.to_id, thread.from_id, thread.product_id, product.name AS product_name, user.user_name, user.profile_pic, user.id as user_id "
                . "FROM thread "
                . "LEFT JOIN user ON user.id = thread.to_id "
                . "LEFT JOIN product ON product.product_id = thread.product_id "
                . "WHERE thread.from_id = $user_id) "
                . "UNION "
                . "(SELECT thread.thread_id AS thread_id, thread.to_id, thread.from_id, thread.product_id, product.name AS product_name, user.user_name, user.profile_pic, user.id as user_id "
                . "FROM thread "
                . "LEFT JOIN user ON user.id = thread.from_id "
                . "LEFT JOIN product ON product.product_id = thread.product_id "
                . "WHERE thread.to_id = $user_id)"
                . "ORDER BY thread_id DESC"
        );
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_conversation_by_product_id_and_user($product_id, $from_id, $to_id) {
        $query = $this->db->query("SELECT *, message.id AS message_id FROM message JOIN product ON product.product_id = message.product_id LEFT JOIN user ON user.id = message.from_id WHERE (message.from_id = $from_id OR message.from_id = $to_id) AND (message.to_id = $to_id OR message.to_id = $from_id) AND message.product_id = $product_id ORDER BY message.create_date DESC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_thread_by_id($thread_id, $user_id) {
        $query = $this->db->query(
                "SELECT thread.*, product.product_id, product.name AS product_name, user.user_name "
                . "FROM thread "
                . "LEFT JOIN product ON product.product_id = thread.product_id "
                . "LEFT JOIN user ON user.id = thread.to_id "
                . "WHERE thread.thread_id = $thread_id "
                . "AND thread.from_id = $user_id "
                . "UNION "
                . "SELECT thread.*, product.product_id, product.name, user.user_name "
                . "FROM thread "
                . "LEFT JOIN product ON product.product_id = thread.product_id "
                . "LEFT JOIN user ON user.id = thread.from_id "
                . "WHERE thread.thread_id = $thread_id "
                . "AND thread.to_id = $user_id"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function fetch_thread_id($product_id, $user_id, $to_id) {
        $query = $this->db->query("SELECT thread_id FROM thread WHERE product_id = $product_id "
                . "AND ((from_id = $user_id AND to_id = $to_id) OR (from_id = $to_id AND to_id = $user_id))");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_thread_by_user($user_id, $thread_id) {
        $this->db->select('*');
        $this->db->from('thread');
        $this->db->where('thread_id', $thread_id);
        $this->db->where("(from_id = $user_id OR to_id = $user_id)");
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_details_by_thread($thread_id) {

        $this->db->select('user.user_name, product.name, thread.product_id');
        $this->db->from('message');
        $this->db->join('user', 'user.id = message.from_id', 'LEFT');
        $this->db->join('product', 'product.product_id = thread.product_id', 'LEFT');
        $this->db->where('thread.thread_id', $thread_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_message_notification($user_id) {

        //Getting all my threads
        $query = $this->db->select('thread.from_id, thread.to_id, thread.product_id, thread.thread_id')
                ->from('thread')
                ->where("thread.from_id = $user_id OR thread.to_id = $user_id")
                ->get();
        if ($query->num_rows() > 0) {
            $my_threads = $query->result();
        } else {
            $my_threads = false;
        }


        //If threads exist
        if (!$my_threads)
            return false;

        $message = array();
        $count = 0;

        foreach ($my_threads as $thread) {

            //Getting my chat frined id
            if ($thread->from_id == $user_id)
                $from_id = $thread->to_id;
            else if ($thread->to_id == $user_id)
                $from_id = $thread->from_id;


            $query = $this->db->select('COUNT(message.message) AS count, user.user_name, user.profile_pic, user.id, message.thread_id, message.message, message.from_id')
                    ->from('message')
                    ->join('user', 'user.id = message.from_id')
                    ->where('message.status = "unread"')
                    ->where("message.from_id = $from_id")
                    ->where("message.thread_id = $thread->thread_id")
                    ->get();

            if ($query->num_rows() > 0) {
                $message[$count] = $query->row_array();
            } else {
                $message[$count] = false;
            }

            //If there is actually any unread message
            if ($message[$count]['count'] > 0)
                $count++;
        }
        array_unshift($message, $count);
        return $message;
    }

    public function get_my_thread($user_id) {
        $query = $this->db->select('thread.from_id, thread.to_id, thread.product_id, thread.thread_id')
                ->from('thread')
                ->where("thread.from_id = $user_id OR thread.to_id = $user_id")
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function update_status($thread_id, $from_id, $update_data, $message_id = false) {
        try {
            $this->db->where('thread_id', $thread_id);
            $this->db->where("from_id != $from_id");
            /*if ($message_id !== false)
                $this->db->where("id > $message_id");*/
            $this->db->update('message', $update_data);
            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }

}
