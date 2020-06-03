<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Found_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Subscription_model424 extends CI_Model
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
        return array();
    }

    public function select(array $what, array $where = []): array
    {
//		print("<pre>".print_r($what,true)."</pre>");
//		print("<pre>".print_r($where,true)."</pre>");
//		die();
        $this->db->select(implode(',', $what));
        $this->db->from('tbl_subscription');
        if (!empty($where)) {
            foreach($where as $key => $value) {
                $this->db->where([$key => $value]);
            }
        }


        return $this->db->get()->result_array();
    }

}

?>
