<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Qr_model extends CI_Model
{

    public function getQRcodeByCode($code) {
//    	echo $code;
        $this->db->select('*');
        $this->db->from('tbl_qrcodes');
        $this->db->where('code', $code);
        $query = $this->db->get();
        $last = $this->db->last_query();
//      var_dump($last);
//		var_dump($query->row());
        return $query->row();
    }

	function updateQRCodes($data,$code)
	{
		try {
			$this->db->where('code', $code);
			$this->db->update('tbl_qrcodes', $data);
			return TRUE;
		}

		catch (Exception $ex)
		{
			return FALSE;
		}
	}

    public function userAuthentication(string $apiKey): bool
    {
        $this->db->select('id');
        $this->db->from('tbl_APIkeys');
        $this->db->where('apikey', $apiKey);
        $result = $this->db->get();
        return $result->result() ? true : false;
    }



}
