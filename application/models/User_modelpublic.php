<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_modelpublic extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */

    function lostandfoundlistCount($searchText = '', $location)
    {
        $this->db->select('BaseTbl.id, BaseTbl.userclaimId,  BaseTbl.userId, tbl_category.description as categoryname, tbl_user.IsDropOffPoint, tbl_user.username as username, BaseTbl.userfoundId, BaseTbl.isDeleted, BaseTbl.code, BaseTbl.descript, BaseTbl.lost, BaseTbl.createdDtm, BaseTbl.image');
        $this->db->from('tbl_label as BaseTbl');

        $this->db->join('tbl_category', 'tbl_category.id = BaseTbl.categoryid','left');
        $this->db->join('tbl_user','tbl_user.id = BaseTbl.userId');
        // $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.code LIKE '%".$searchText."%' OR  BaseTbl.descript LIKE '%".$searchText."%')";

            $this->db->where($likeCriteria);
        }
        $userId= $location; // "1"; // $this->session->userdata['userId'];
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('tbl_user.IsDropOffPoint', 1);
        $this->db->where('BaseTbl.userId', $userId );
        $this->db->where('BaseTbl.userclaimId IS NULL', null, false);
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        // die(    $str = $this->db->last_query());
		// $numrows = $query->num_rows();
        return $query->num_rows();
    }


    function lostandfoundlist($searchText = '', $userId , $page, $segment)
    {
        $this->db->select('BaseTbl.id, BaseTbl.userclaimId, tbl_user.showdate, BaseTbl.userId, tbl_category.description as categoryname, tbl_user.IsDropOffPoint, tbl_user.username as username, BaseTbl.userfoundId, BaseTbl.isDeleted, BaseTbl.code, BaseTbl.descript, BaseTbl.lost, BaseTbl.createdDtm, BaseTbl.image, BaseTbl.categoryid');
        $this->db->from('tbl_label as BaseTbl');
        $this->db->join('tbl_category', 'tbl_category.id = BaseTbl.categoryid','left');
        $this->db->join('tbl_user','tbl_user.id = BaseTbl.userId');
        // $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.code LIKE '%".$searchText."%' OR BaseTbl.descript  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.userId', $userId );
        $this->db->where('tbl_user.IsDropOffPoint', 1);
        $this->db->where('BaseTbl.userclaimId IS NULL', null, false);
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
//        var_dump($result);
//        die();
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
        $this->db->where('BaseTbl.userfoundId IS NOT NULL', null, false);
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
        $this->db->select('BaseTbl.id,BaseTbl.userId, tbl_category.description as categoryname, BaseTbl.userfoundId, BaseTbl.isDeleted, BaseTbl.code, BaseTbl.descript, BaseTbl.payreturnfeestatus, BaseTbl.identification, BaseTbl.utilitybill, BaseTbl.dhltrackingcode, BaseTbl.lost, BaseTbl.createdDtm, BaseTbl.image');
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
        $this->db->where('BaseTbl.userfoundId IS NOT NULL', null, false);
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

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
     * @param int $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('id as userId, username as name, email, mobile, roleId, lfbuddy, publiclisting');
        $this->db->from('tbl_user');
        $this->db->where('isDeleted', 0);
        // $this->db->where('roleId !=', 1);
        $this->db->where('id', $userId);
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
     * @param number $userId : This is user id
     */

    function editUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('tbl_user', $userInfo);

        return TRUE;
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
        $this->db->select('BaseTbl.id as userId, BaseTbl.email, BaseTbl.usershorturl, BaseTbl.username as name, BaseTbl.mobile, BaseTbl.address, BaseTbl.addressa, payedwithoutlabels, BaseTbl.zipcode, BaseTbl.city, BaseTbl.country, BaseTbl.lfaddress, BaseTbl.lfaddressa, BaseTbl.lfzipcode, BaseTbl.lfcity, BaseTbl.lfcountry , BaseTbl.roleId, Roles.role, BaseTbl.lfbuddy, BaseTbl.lfbmobile, BaseTbl.lfbemail');
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

    function isDuplicate($email)
    {
        $this->db->select("email");
        $this->db->from("tbl_user");
        $this->db->where("email", $email);
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
}

