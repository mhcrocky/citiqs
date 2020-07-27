<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Createvisitor_model extends CI_Model
{

	public $uploadFolder = FCPATH . 'uploads/LabelImages';

	function newvisitor($data)
	{


		if ($this->db->insert('tbl_bookandpayvisitor', $data)){
//			var_dump($data);
//			die();
				$insert_id = $this->db->insert_id();
		}
//		var_dump($this->db->last_query());
//		die();
		return true;
	}
}
