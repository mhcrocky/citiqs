<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Found_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User_subscription_modelpublic extends CI_Model
{
    public function getUserSubscriptionInfoByTransactionId($transactionid)
    {
        $this->db->select('userid, subscriptionid, paystatus, transactionid, createdDtm');
        $this->db->from('tbl_user_subscription');
        $this->db->where('transactionid', $transactionid);
        $query = $this->db->get();

        return $query->row();
    }

    public function getUserSubscriptionInfoByUserIdAndSubscriptionId($userid, $subscriptionid)
    {
        $this->db->select('userid, subscriptionid, paystatus, transactionid, createdDtm');
        $this->db->from('tbl_user_subscription');
        $this->db->where('userid', $userid);
        $this->db->where('subscriptionid', $subscriptionid);
        $query = $this->db->get();

        return $query->row();
    }

    public function getUserSubscriptionInfoByUserId($userId)
    {
        $query = $this->db->query("SELECT userid, createdDtm FROM tbl_user_subscription WHERE paystatus = 2 and userid = $userId and DATE_ADD(createdDtm,INTERVAL 1 YEAR) > NOW()");

        return $query->result_array();
    }


    public function insert($usersubscriptionInfo)
    {
        try
        {
            $result = $this->db->insert('tbl_user_subscription', $usersubscriptionInfo);
            return $result;
        }
        catch (Exception $ex)
        {
            return FALSE;
        }
    }

    public function update($updatedusersubscriptionInfo, $usersubscriptionInfo)
    {
        try
        {
            $this->db->where('userid', $usersubscriptionInfo->userid);
            $this->db->where('subscriptionid', $usersubscriptionInfo->subscriptionid);
            $this->db->update('tbl_user_subscription', $updatedusersubscriptionInfo);

            return TRUE;
        }

        catch (Exception $ex)
        {
            return FALSE;
        }
    }

}

?>