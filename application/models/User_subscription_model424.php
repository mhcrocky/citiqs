<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Found_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User_subscription_model424 extends CI_Model
{
    private $table = 'tbl_user_subscription';

    public function getUserSubscriptionInfoByTransactionId($transactionid)
    {
        $this->db->select('*');
        $this->db->from('tbl_user_subscription');
        $this->db->where('transactionid', $transactionid);
        $query = $this->db->get();
        return $query->row();
    }

    public function getUserSubscriptionInfoByUserIdAndSubscriptionIdPaid($userid, $subscriptionid)
    {
        $this->db->select('userid, subscriptionid, paystatus, transactionid, createdDtm, paystatus');
        $this->db->from('tbl_user_subscription');
        $this->db->where('userid', $userid);
        $this->db->where('subscriptionid', $subscriptionid);
        $this->db->where('paystatus', 2);
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
        $query = $this->db->query("SELECT userid, createdDtm FROM tbl_user_subscription " .
            "WHERE (paystatus = 2 and userid = $userId and DATE_ADD(createdDtm,INTERVAL 1 YEAR) > NOW() and (subscriptionid = 1 or subscriptionid = 2)) " .
            "OR (paystatus = 2 and userid = $userId and DATE_ADD(createdDtm,INTERVAL 1 MONTH) > NOW() and subscriptionid = 3)");
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
    
    public function updateRecurringPaymentRocord($recurring_id, $paystatus, $createdDtm, $orderId) {
        $this->db->trans_start();
        $this->db->set("paystatus", $paystatus);
        $this->db->set("createdDtm", $createdDtm);
        $this->db->set("orderId", $orderId);
        $this->db->where("recurring_id", $recurring_id);
        $this->db->update('tbl_user_subscription');
        $affected_rows = $this->db->affected_rows();
        $this->db->trans_complete();
        return $affected_rows;
    }
    
    public function getUsersSubscriptionsInfoForPaynlRecurringPayments()
    {
        $this->db->select('userid, subscriptionid, paystatus, transactionid, recurring_id, recurring_token, type, createdDtm');
        $this->db->from('tbl_user_subscription');
        $this->db->where('recurring_id !=', NULL);
        $this->db->where('recurring_token !=', NULL);
        $result = $this->db->get();
        return $result->result_array();
    }


    public function select(array $what, array $where)
    {
        $this->db->select(implode(',', $what));
        $this->db->from('tbl_user_subscription');
        foreach($where as $key => $value) {
            $this->db->where($key, $value);
        }
        $query = $this->db->get();
        return $query->row();
    }

    public function getLastSubscriptionId($userId): ?array
    {
        $query = '
            SELECT 
            tbl_user_subscription.subscriptionid,
            tbl_user_subscription.createdDtm,
            tbl_user_subscription.expireDtm,
            tbl_user_subscription.paystatus,
            tbl_user_subscription.invoice_source,
            tbl_subscription.description,
            tbl_subscription.type,
            tbl_subscription.amount  
            FROM tbl_user_subscription
                RIGHT JOIN tbl_subscription  ON tbl_subscription.id = tbl_user_subscription.subscriptionid
            WHERE
                tbl_user_subscription.userid = ' .  $userId . '
                AND tbl_subscription.itemgroup = "spot"
            ORDER BY tbl_user_subscription.id DESC LIMIT 1';

        $result = $this->db->query($query);
        $result = $result->result_array();
        return ($result) ? reset($result) : null;
    }
}

?>
