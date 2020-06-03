<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Label_modelpublic extends CI_Model
{
    function registernewlabel($labelInfo)
    {
        try {
            // $this->db->trans_start();
            if ($this->db->insert('tbl_label', $labelInfo))
                $insert_id = $this->db->insert_id();
            else
                $insert_id = -1;
            //$this->db->trans_complete();
            return $insert_id;
        }

        catch (Exception $ex)
        {
            return -1;
        }
    }

    function getFoundLabelsByUserId($userId)
    {
            $this->db->select('id');
            $this->db->from('tbl_label');
            $this->db->where('isDeleted', 0);
            $this->db->where('userId', $userId );
            $this->db->where('userfoundId',$userId);
			$this->db->where('userclaimId IS NULL', null, false);

			$query = $this->db->get();

            return $query->num_rows();
    }

    function generateCodeAndInsertLabel($labelInfo)
    {
        // 3x label2 aanpassen + in   function updateimg($userInfo,$id){ in User_model

        try
        {
            $set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
            do
            {
                do
                {
                    $code = 'G-' . substr(str_shuffle($set), 0, 8);
                }
                while ($this->doesUniquecodeExist($code));  // code in tbl_uniquecodes table?

                $this->db->select('id');
                $this->db->from('tbl_label');
                $this->db->where('code', $code);
                $query = $this->db->get();
            }
            while (!empty($query->row()));  // code in tbl_label table?

            // $code = 'G-vmYM5psA';
            $labelInfo['code'] = $code;
            if ($this->db->insert('tbl_label', $labelInfo))
                $insert_id = $this->db->insert_id();
            else
                $insert_id = -1;

            if ($insert_id > 0)
            {
                $this->db->select('id, code');
                $this->db->from('tbl_label');
                $this->db->where('id', $insert_id);
                $query = $this->db->get();
                return $query->row();
            }
            else
                return null;
        }

        catch (Exception $ex)
        {
            return null;
        }
    }

    function getLabelInfoById($id, $userId)
    {
        $this->db->select('code');
        $this->db->from('tbl_label');
        $this->db->where('id', $id);
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();

        return $query->row();
    }

    function getLabelInfoByCode($code)
    {
        $this->db->select('id as labelId, userId, descript');
        $this->db->from('tbl_label');
        $this->db->where('isDeleted', 0);
        $this->db->where('code', $code);
        $query = $this->db->get();

        return $query->row();
    }

    function editLabel($labelInfo, $userId, $labelId)
    {
        try {
            $this->db->where('id', $labelId);
            $this->db->where('isDeleted', 0);
            $this->db->where('userId', $userId);
            $this->db->update('tbl_label', $labelInfo);

            return TRUE;
        }

        catch (Exception $ex)
        {
            return FALSE;
        }
    }

    function doesUniquecodeExist($code)
    {
        $this->db->select('id');
        $this->db->from('tbl_uniquecodes');
        $this->db->where('code', $code);
        $query = $this->db->get();

        return !empty($query->row());
    }

    function doesUserdefinedcodeExist($code)
    {
        $this->db->select('id');
        $this->db->from('tbl_label');
        $this->db->where('code', $code);
        $query = $this->db->get();

        return !empty($query->row());
    }

}

?>
