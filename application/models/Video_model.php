<?php
class Video_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function get_videos($userId){
		$this->db->where('userId', $userId);
		$query = $this->db->get('tbl_video_recordings');
		return $query->result_array();
	}

	public function save_videos($data){
		return $this->db->insert_batch('tbl_video_recordings',$data);
	}

	public function delete_video($userId, $filename){
		$this->db->where('userId', $userId);
		$this->db->where('filename', $filename);
		return $this->db->delete('tbl_video_recordings');
	}

	public function add_video_description($id, $userId, $description){
		$this->db->set('description', $description);
		$this->db->where('userId', $userId);
		$this->db->where('id', $id);
		return $this->db->update('tbl_video_recordings');
	}

	public function video_exists($filename){
		$this->db->where('filename', $filename);
		$query = $this->db->get('tbl_video_recordings');
		if($query->num_rows() > 0){
			return false;
		}
		return true;
	}

}
