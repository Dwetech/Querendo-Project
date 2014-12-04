<?php

/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/4/14
 * Time: 1:50 PM
 */
class Settings_model extends CI_Model {


    var $data;

    function __construct() {
        $this->data = $this->getSettingsArray(
            array('website_name','keyword','description','copyright','website_email', 'paypal_email')
        );
    }

    function getSettingsArray($array){

        $this->db->select('*');
        if( is_array($array) )
        {
            $i = 0;
            foreach($array as $key)
            {
                if( $i == 0 )
                {
                    $this->db->where('key', $key);
                    $i = 1;
                }
                else
                {
                    $this->db->or_where('key', $key);
                }
            }
        }
        else
        {
            return false;
        }

        $query = $this->db->get('settings');
        if ($query->num_rows() == 0) {
            return false;
        }


        $setting = array();
        foreach( $query->result_array() as $row )
        {
            $setting[$row['key']] = $row['value'];
        }

        return $setting;

    }

    /**
     * Get individual settings item
     * ============================
     * @param $key
     * @return bool
     */
    public function getSettings($key) {
        $query = $this->db->get_where('settings',array('key'=>$key));

        if( $query->num_rows() > 0 ) {
            $data = $query->row();
            return $data->value;
        }

        return false;
    }



    public function getAllSettings($type=false){
        $this->db->from('settings');

        if( $type ) {
            $this->db->where('type',$type);
        }

        $query = $this->db->get();

        return $query->result();

    }



    public function change_website_settings($keyword, $description, $website_name, $website_email, $copyright, $paypal_email, $fee_percent) {
        if (!$this->db->update('settings', array('value' => $keyword), array('key' => 'keyword'))) {
            return false;
        }

        if (!$this->db->update('settings', array('value' => $description), array('key' => 'description'))) {
            return false;
        }

        if (!$this->db->update('settings', array('value' => $website_name), array('key' => 'website_name'))) {
            return false;
        }

        if (!$this->db->update('settings', array('value' => $copyright), array('key' => 'copyright'))) {
            return false;
        }

        if (!$this->db->update('settings', array('value' => $website_email), array('key' => 'website_email'))) {
            return false;
        }

        if (!$this->db->update('settings', array('value' => $paypal_email), array('key' => 'paypal_email'))) {
            return false;
        }

        if (!$this->db->update('settings', array('value' => $fee_percent), array('key' => 'fee_percent'))) {
            return false;
        }

        return true;
    }


}
