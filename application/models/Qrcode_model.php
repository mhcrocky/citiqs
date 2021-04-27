<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode_model extends CI_Model
{

    public function get_qrcodes($vendorId) {

        $this->db->select('tbl_qrcodes.*, spotName');
        $this->db->from('tbl_qrcodes');
        $this->db->join('tbl_shop_spots', 'tbl_shop_spots.id = tbl_qrcodes.spot','left');
        $this->db->where('vendorId', $vendorId);
        $query = $this->db->get();
        return $query->result_array();
    }

	function save_qrcode($id, $data)
	{
        $this->db->select('*');
        $this->db->from('tbl_qrcodes');
        $this->db->where('id', $id);
        $first_query = $this->db->get();
        $response = [];
        if($first_query->num_rows() < 1){
            $response = [
                'status' => 'error',
                'message' => 'Not Found!'
            ];
            return $response;
        }

        $this->db->select('*');
        $this->db->from('tbl_qrcodes');
        $this->db->where('id', $id);
        $this->db->where('vendorId', 0);
        $second_query = $this->db->get();

        if($second_query->num_rows() < 1){
            $response = [
                'status' => 'error',
                'message' => 'Already taken, call support!'
            ];
            return $response;
        }

        $this->db->where('id', $id);
		$this->db->update('tbl_qrcodes', $data);
        $response = [
            'status' => 'success',
            'message' => 'Updated Successfully!'
        ];
        return $response;
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
