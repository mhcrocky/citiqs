<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Found_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Subscription_modelpublic extends CI_Model
{
    public function getSubscriptionInfoById($subscriptionid)
    {
        $this->db->select('id as subscriptionId, description, amount, active');
        $this->db->from('tbl_subscription');
        $this->db->where('id', $subscriptionid);
        $query = $this->db->get();

        return $query->row();
    }

    public function getallsubscriptions()
    {
        $this->db->select('id, description, amount');
        $this->db->from('tbl_subscription');
        $this->db->where('active', 1);
        $this->db->order_by('description');
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

}

?>