<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public $id;
    public $hash;
    public $url;
    public $email;
    public $active;
    private $table = 'tbl_user';

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */

    /*
    function userLabelCount($userId)
    {
        $this->db->select('BaseTbl.userId');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->from('tbl_label as BaseTbl');
        $query = $this->db->get();

        return $query->num_rows();
    }
    */

    /*
    function userListingCount($searchText = '')
    {
        $this->db->select('BasetTbl.lfbuddy, BaseTbl.id as userId, BaseTbl.userfoundId, BaseTbl.email, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_user as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.username  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();

        return $query->num_rows();
    }
    */

    public function lostandfoundlistCount($searchText = '')
    {
        $this->db->select('BaseTbl.id,  BaseTbl.userId, BaseTbl.userfoundId, BaseTbl.code, BaseTbl.descript, BaseTbl.lost, BaseTbl.createdDtm');
        $this->db->from('tbl_label as BaseTbl');
        // $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.code LIKE '%".$searchText."%' OR  BaseTbl.descript LIKE '%".$searchText."%')";

            $this->db->where($likeCriteria);
        }
        $userId= $this->session->userdata['userId'];
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.userId', $userId );
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();

        return $query->num_rows();
    }

//    function orderListingCount($searchText = '')
/*
    function orderListingCount($vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        return $this->db->count_all_results('orders');
    }
*/

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function lostandfoundlist($searchText = '', $userId, $page = null, $segment = null)

    {
        $this->db->select('BaseTbl.id,BaseTbl.userId, tbl_category.description as categoryname, BaseTbl.userfoundId, BaseTbl.isDeleted, BaseTbl.code, BaseTbl.descript, BaseTbl.lost, BaseTbl.createdDtm, BaseTbl.image, BaseTbl.categoryid, BaseTbl.userclaimId, tbl_employee.username AS employee, tbl_user.username AS owner');
        $this->db->from('tbl_label as BaseTbl');
        $this->db->join('tbl_category', 'tbl_category.id = BaseTbl.categoryid','left');
        $this->db->join('tbl_user', 'tbl_user.id = BaseTbl.userId','inner');
        $this->db->join('tbl_employee', 'BaseTbl.employeeId = tbl_employee.id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.code LIKE '%".$searchText."%' OR BaseTbl.descript  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.userId', $userId );
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }


    function userReturnitemslistingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id,  BaseTbl.userId, BaseTbl.userfoundId, BaseTbl.code, BaseTbl.descript, BaseTbl.payreturnfeestatus, BaseTbl.identification, BaseTbl.utilitybill, BaseTbl.dhltrackingcode, BaseTbl.lost, BaseTbl.createdDtm');
        $this->db->from('tbl_label as BaseTbl');
        // $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.code LIKE '%".$searchText."%' OR  BaseTbl.descript LIKE '%".$searchText."%')";

            $this->db->where($likeCriteria);
        }

        $userId= $this->session->userdata['userId'];
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.userId', $userId );
        // $this->db->where('BaseTbl.userfoundId IS NOT NULL', null, false);
        $where = 'BaseTbl.userfoundId IS NOT NULL or BaseTbl.userclaimId = '.$userId;
        $this->db->where($where, null, false);
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();

        return $query->num_rows();
    }


    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */

    function userReturnitemslisting($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.id,BaseTbl.userId, tbl_category.description as categoryname,BaseTbl.userclaimId, BaseTbl.userfoundId,BaseTbl.isDeleted, BaseTbl.code, BaseTbl.descript, BaseTbl.payreturnfeestatus, BaseTbl.identification, BaseTbl.utilitybill, BaseTbl.dhltrackingcode, BaseTbl.lost, BaseTbl.createdDtm, BaseTbl.image');
        $this->db->from('tbl_label as BaseTbl');
        $this->db->join('tbl_category', 'tbl_category.id = BaseTbl.categoryid','left');
        // $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.code LIKE '%".$searchText."%' OR BaseTbl.descript  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $userId= $this->session->userdata['userId'];
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.userId', $userId );
        $where = 'BaseTbl.userfoundId IS NOT NULL or BaseTbl.userclaimId = '.$userId;
        $this->db->where($where, null, false);
        // $this->db->where('BaseTbl.userfoundId IS NOT NULL', null, false);
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        // die(    $str = $this->db->last_query());
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

	function userReturnClaim($searchText = '', $userId)
	{
		$this->db->select('BaseTbl.id as labelId, BaseTbl.userId, tbl_category.description as categoryname,BaseTbl.userclaimId, BaseTbl.userfoundId,BaseTbl.isDeleted, BaseTbl.code, BaseTbl.descript, BaseTbl.payreturnfeestatus, BaseTbl.identification, BaseTbl.utilitybill, BaseTbl.dhltrackingcode, BaseTbl.lost, BaseTbl.createdDtm, BaseTbl.image');
		$this->db->from('tbl_label as BaseTbl');
		$this->db->join('tbl_category', 'tbl_category.id = BaseTbl.categoryid','left');
		if(!empty($searchText)) {
			$this->db->where('BaseTbl.code', $searchText);
		}
		$this->db->where('BaseTbl.isDeleted', 0);
		$this->db->where('BaseTbl.userId', $userId );
//		$where = 'BaseTbl.userfoundId IS NOT NULL or BaseTbl.userclaimId = '. $userfoundId;
//		$this->db->where($where, null, false);
		$query = $this->db->get();
//		echo $this->db->last_query();
		$result = $query->row();
//		echo $this->db->last_query();
		return $result;
	}


    /*
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.lfbuddy, BaseTbl.id as userId, BaseTbl.email, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_user as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.username  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
    */

    /*
    public function orderListing($vendor_id, $page, $segment)
    {
        $this->db->where('vendor_id', $vendor_id);
        $this->db->order_by('id', 'DESC');
        $this->db->select('orders.*, orders_clients.first_name,'
            . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
            . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
            . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $this->db->limit($page, $segment);
        $result = $this->db->get('orders');
        return $result->result();
    }
    */


//    function orderListing($searchText = '', $page, $segment)
//    {
//        $this->db->select('BaseTbl.id as userId, BaseTbl.email, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
//        $this->db->from('tbl_user as BaseTbl');
//        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
//        if(!empty($searchText)) {
//            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
//                            OR  BaseTbl.username  LIKE '%".$searchText."%'
//                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
//            $this->db->where($likeCriteria);
//        }
//        $this->db->where('BaseTbl.isDeleted', 0);
//        $this->db->where('BaseTbl.roleId !=', 1);
//        $this->db->order_by('BaseTbl.id', 'DESC');
//        $this->db->limit($page, $segment);
//        $query = $this->db->get();
//
//        $result = $query->result();
//        return $result;
//    }
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_user");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function checkUserExists($email, $userId = 0)
    {
        $this->db->select("email,id as userId, username as name, mobile, id as userid, lfbuddy");
        $this->db->from("tbl_user");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->row();
    }


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_user', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function addNewUserlabel($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_label', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function registernew($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_user', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('id as userId, username as name, email, mobile, roleId, lfbuddy');
        $this->db->from('tbl_user');
        $this->db->where('isDeleted', 0);
        // $this->db->where('roleId !=', 1);
        $this->db->where('id', $userId);
        $query = $this->db->get();

        return $query->row();
    }

    function getUserInfoByUrlName($name)
    {
        $this->db->select('id as userId');
        $this->db->from('tbl_user');
        $this->db->where('isDeleted', 0);
        // $this->db->where('roleId =', 2);
        $this->db->where('usershorturl', $name);
        $query = $this->db->get();
        return $query->row();
    }


    function getUserInfoByHash($hash)
    {
        $this->db->select('id as userId');
        $this->db->from('tbl_user');
        $this->db->where('isDeleted', 0);
        $this->db->where('hash', $hash);
        $query = $this->db->get();

        return $query->row();
    }


    function getUserInfolabel($id)
    {
        $this->db->select('id,userId, descript, categoryid, code, isDeleted, roleId,image');
        $this->db->from('tbl_label');
        $this->db->where('isDeleted', 0);
        // $this->db->where('roleId =', 2);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }



    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param int $userId : This is user id
     * @return bool
     */
    function editUser($userInfo, $userId): bool
    {
        $this->db->where('id', $userId);
        $this->db->update('tbl_user', $userInfo);
		$effectedrows =$this->db->affected_rows();
        return ($effectedrows > 0) ? true : false;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        die('deleteUser obsolete. Contact tiqs staff');

        //$this->db->where('id', $userId);
        //$this->db->update('tbl_user', $userInfo);

        //return $this->db->affected_rows();
    }

    function deleteUserlabel($id, $userId, $userInfo)
    {
        // save old code by adding timestamp
        $this->db->set('code', 'CONCAT(CAST(code as CHAR(254)), CAST(UNIX_TIMESTAMP() as CHAR(20)))', FALSE);
        $this->db->where('id', $id);
        $this->db->where('userId', $userId);
        $this->db->update('tbl_label', $userInfo);

        return $this->db->affected_rows();
    }



    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('id as userId, password');
        $this->db->where('id', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_user');

        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('id', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_user', $userInfo);
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     */
    function loginHistoryCount($userId, $searchText, $fromDate, $toDate)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->from('tbl_last_login as BaseTbl');
        $query = $this->db->get();

        return $query->num_rows();
    }

    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function loginHistory($userId, $searchText, $fromDate, $toDate, $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        $this->db->from('tbl_last_login as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('BaseTbl.id as userId, BaseTbl.email, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.address, BaseTbl.addressa, payedwithoutlabels, BaseTbl.zipcode, BaseTbl.city, BaseTbl.country, BaseTbl.lfaddress, BaseTbl.lfaddressa, BaseTbl.lfzipcode, BaseTbl.lfcity, BaseTbl.lfcountry , BaseTbl.roleId, Roles.role, BaseTbl.lfbuddy, BaseTbl.lfbmobile, BaseTbl.lfbemail');
        $this->db->from('tbl_user as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.id', $userId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();

        return $query->row();
    }

    function getUserInfoByMail($userMail)
    {
//         $this->db->select('id as userId, username as name, email, mobile, roleId, lfbuddy');
        $this->db->select('BaseTbl.id as userId, BaseTbl.email, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.address, BaseTbl.addressa, BaseTbl.zipcode, BaseTbl.city, BaseTbl.country, BaseTbl.lfaddress, BaseTbl.lfaddressa, BaseTbl.lfzipcode, BaseTbl.lfcity, BaseTbl.lfcountry , BaseTbl.roleId, Roles.role, BaseTbl.lfbuddy, BaseTbl.lfbmobile, BaseTbl.lfbemail');
        $this->db->from('tbl_user as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $userMail);
        $query = $this->db->get();

        return $query->row();
    }

    function getaddressexist($userMail)
    {
//         $this->db->select('id as userId, username as name, email, mobile, roleId, lfbuddy');
        $this->db->select('BaseTbl.id as userId, BaseTbl.email, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.address, BaseTbl.addressa, BaseTbl.zipcode, BaseTbl.city, BaseTbl.country, BaseTbl.lfaddress, BaseTbl.lfaddressa, BaseTbl.lfzipcode, BaseTbl.lfcity, BaseTbl.lfcountry , BaseTbl.roleId, Roles.role, BaseTbl.lfbuddy, BaseTbl.lfbmobile, BaseTbl.lfbemail');
        $this->db->from('tbl_user as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $userMail);
        $this->db->where('BaseTbl.username !=', "");
        $this->db->where('BaseTbl.address !=', "");
        $query = $this->db->get();

        // return $query->row();

        if ($query->num_rows()<=0)
        {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getUserInfoWithRole($userId)
    {
        $this->db->select('BaseTbl.id as userId, BaseTbl.email, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.address, BaseTbl.addressa, BaseTbl.zipcode, BaseTbl.city, BaseTbl.country, BaseTbl.lfaddress, BaseTbl.lfaddressa, BaseTbl.lfzipcode, BaseTbl.lfcity, BaseTbl.lfcountry , BaseTbl.roleId, Roles.role, BaseTbl.lfbuddy, BaseTbl.lfbmobile, BaseTbl.lfbemail');
        $this->db->from('tbl_user as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.id', $userId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        if ($query) {
            $querytext=$this->db->last_query();
            return $query->row();
        } else {
            echo "failed";
        }
       //  return $query->row();
    }

    public function isDuplicate(string $email): bool
    {
        $this->db->select("id");
        $this->db->from("tbl_user");
        $this->db->where("email", $email);
        $query = $this->db->get();
        if ($query->num_rows() <= 0) {
            return false;
        } else {
            $this->id = $query->row()->id;
            return true;
        }
    }

    function isDropOffPoint($email)
    {
        $this->db->select("email");
        $this->db->from("tbl_user");
        $this->db->where("email", $email);
        $this->db->where("IsDropOffPoint", 1);

        $query = $this->db->get();

        if ($query->num_rows()<=0)
        {
            return false;
        }
        else {
            return true;
        }
    }

    function isDuplicateusername($username)
    {
        $this->db->select("username");
        $this->db->from("tbl_user");
        $this->db->where("username", $username);
        $query = $this->db->get();

        if ($query->num_rows()<=0)
        {
            return false;
        }
        else {
            return true;
        }
    }

    public function getallcategories(){
        $this->db->select('id, description');
        $this->db->from('tbl_category');
        $this->db->order_by('description');
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    function updateUserlabellost($userInfo,$labelid, $userId){
        // $this->db->set('lost', false);
        $this->db->where('id',$labelid);
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_label',$userInfo);
        return $this->db->affected_rows();
    }

    function updateUserlabel($userInfo,$labelid, $userId){
        $this->db->set('categoryid','descript',false);
        $this->db->where('id',$labelid);
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_label',$userInfo);
        return $this->db->affected_rows();
    }

    function updateimg($userInfo,$id,$userId){
        $this->db->set('image',false);
        $this->db->where('id',$id);
        $this->db->where('userId',$userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_label',$userInfo);
        return $this->db->affected_rows();
    }

    /**
     * getData
     * 
     * This method gets user(s) data from $this->table. Filter can be $where array or $this->where if it is set.
     * // TO DO ADD JOIN
     * 
     * @access public
     * @see setWhereCondtition
     * @param array $key Argument is required, array with names of columns in $this->table. Use ['*'] for all user's data.
     * @param array $where Argument is optional.
     * @return null|string Method returns string or null.
     */
    public function getData(array $key, array $where = null): ?object
    {
        $filter = (!$where && isset($this->where)) ? $this->where : $where;
        $this->db->select(implode(',', $key));
        $this->db->from($this->table);
        $this->db->where($filter);
        $this->db->where('isDeleted', 0);
        $result = $this->db->get();
        return $result->row();
    }

    /**
     * setWhereCondtition
     * 
     * Method sets where condition for select query if $this->id, $this->hash or $this->url.
     * Id, hash and url are columns with unique constraint in $this->table.
     * Method returns $this.
     * 
     * @access public
     * @return object Method returns object
     */
    public function setWhereCondtition(): object
    {
        if ($this->id) {
            $this->where = ['id=' => $this->id];
        } elseif ($this->hash) {
            $this->where = ['hash' => $this->hash];
        } elseif ($this->url) {
            $this->where = ['url' => $this->url];
        } elseif ($this->email) {
            $this->where = ['email' => $this->email];
        }
        return $this;
    }

    /**
     * setUniqueValue
     * 
     * Method filter value and add value  to $this->email, $this->id, $this->hash or $this->url.
     * It uses PHP filter_var function for filtering
     * Id, email, hash and url are columns with unique constraint in $this->table.
     * Method returns $this.
     * 
     * @see https://www.php.net/manual/en/function.filter-var.php
     * @see https://www.php.net/manual/en/filter.filters.validate.php
     * @access public
     * @param string Argument is requrired
     * @return object Method returns object
     */
    public function setUniqueValue(string $value): object
    {
        // check is location id(number), url or string(hash)
        if (filter_var($value, FILTER_VALIDATE_INT)) {
            $this->id = intval($value);
        } elseif (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->email = $value;
        } elseif (filter_var($value, FILTER_VALIDATE_URL)) {
            $this->url = $value;
        } elseif (strlen($value)) {
            $this->hash = $value;
        }
        return $this;
    }

    public function setUser()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->where);
        $user = $this->db->get()->result_array()[0];
        foreach ($user as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function insertUser(array $user): bool
    {
        $this->db->insert('tbl_user', $user);
        $this->id = $this->db->insert_id();
        return $this->id ? true : false;
    }

    public function updateUser(array $data, array $where = null)
    {
        $filter = (!$where && isset($this->where)) ? $this->where : $where;
        $this->db->where($filter);
        $this->db->update('tbl_user', $data);
        $this->effectedrows = $this->db->affected_rows();
        return $this;
    }

    public function manageAndSetUser(array $user): object
    {
        if (!$this->isDuplicate($user['email'])) {
            $password = Utility_helper::shuffleString(12);
            $user['password'] = getHashedPassword($password);
            $user['code'] = Utility_helper::shuffleString(5);
            $user['createdDtm'] = date('Y-m-d H:i:s');
            $this->getGeoCoordinates($user);
            $this->insertUser($user);
            $this->setUniqueValue($user['email'])->setWhereCondtition()->setUser();
            // must return non hashed password for activation link
            $this->password = $password;

        } else {
            // update user - maybe it was register as finder and now is claimer or user insert new mobile
            $this->setUniqueValue($user['email'])->setWhereCondtition()->updateUser($user)->setUser();
        }
        return $this;
    }
    
    public function insertAndSetHotel(array $hotel): object
    {
        $password = $hotel['password'];
        $hotel['password'] = getHashedPassword($password);
        $hotel['code'] = Utility_helper::shuffleString(5);
        $hotel['createdDtm'] = date('Y-m-d H:i:s');
        $this->getGeoCoordinates($hotel);
        $this->insertUser($hotel);    
        $this->setUniqueValue($hotel['email'])->setWhereCondtition()->setUser();
        $this->password = $password;
        return $this;
    }

    public function sendActivationLink(): bool
    {
        if ($this->active === '0') {
            // in $this must be set password (not hashed)
            return Email_helper::sendUserActivationEmail($this);
        }
        return true;
    }

    public function setGeoCoordaintes(): object
    {
        $geoCoordinates = (Google_helper::getLatLong($this->address, $this->zipcode, $this->city, $this->country));
        $this->lat = $geoCoordinates['lat'];
        $this->lng = $geoCoordinates['long'];
        return $this;
    }

    public function select(array $what, array $where): array
    {
        $this->db->select(implode(',', $what));
        $this->db->from($this->table);
        foreach($where as $key => $value) {
            $this->db->where([$key => $value]);
        }
        return $this->db->get()->result_array();
    }

    private function getGeoCoordinates(array &$user): void
    {
        if (!isset($user['lat']) || !isset($user['lng'])) {
            $this->load->helper('google_helper');
            $geoCoordinates = (Google_helper::getLatLong($user['address'], $user['zipcode'], $user['city'], $user['country']));
            $user['lat'] = $geoCoordinates['lat'];
            $user['lng'] = $geoCoordinates['long'];
            $user['gmtOffSet'] = Google_helper::getGmtOffset($geoCoordinates);
        }
    }

    public function manageAndSetBuyer(array $buyer): object
    {
        if (
            !isset($buyer['username']) || !$buyer['username']
            || !isset($buyer['email']) || !$buyer['email'] || !filter_var($buyer['email'], FILTER_VALIDATE_EMAIL)
        ) {
            return $this;
        }

        if (!$this->isDuplicate($buyer['email'])) {
            $password = Utility_helper::shuffleString(12);
            $buyer['password'] = getHashedPassword($password);
            $buyer['code'] = Utility_helper::shuffleString(5);
            $buyer['createdDtm'] = date('Y-m-d H:i:s');
            $this->insertUser($buyer);
			// echo $this->db->last_query();
			// die();

            // must return non hashed password for activation link
            $this->password = $password;
        } else {
            $newData = [
                'username' => $buyer['username'],
                'email' => $buyer['email'],
            ];
            if ($buyer['mobile']) {
                $newData['mobile'] = $buyer['mobile'];
            }
            $this->editUser($newData, $this->id);
        }

		$this->setUniqueValue($buyer['email'])->setWhereCondtition()->setUser();
        return $this;
    }


}
