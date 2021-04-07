<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode_model extends CI_Model
{

    public function get_qrcodes($vendorId) {

        $this->db->select('*');
        $this->db->from('tbl_qrcodes');
        $this->db->where('vendorId', $vendorId);
        $query = $this->db->get();
        return $query->result_array();
    }

	function save_qrcode($data)
	{
		$set = '3456789BCDEFGHJKLMNPQRSTVWXY';
		$data['timestamp'] = date('Y-m-d H:i:s');
		$data['code'] = 'A-' . substr(str_shuffle($set), 0, 8);
        var_dump($data);
		$this->db->insert('tbl_qrcodes', $data);
        return true;
	}

    public function update_qrcode($spot, $qrcodeId, $vendorId)
    {
        $this->db->set('spot', $spot);
        $this->db->where('id', $qrcodeId);
        $this->db->where('vendorId', $vendorId);
        $this->db->update('tbl_qrcodes');
        return true;
    }



}
