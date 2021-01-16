<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Video extends BaseControllerWeb
{
	private $user_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('video_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->user_id = $this->session->userdata("userId");
	}

	public function index(){
		$this->global['pageTitle'] = 'TIQS: Videos';
		$this->save_videos();
		$data['userId'] = $this->userId;
		$this->loadViews("video/index", $this->global, $data, 'footerbusiness', 'headerbusiness');
	}

	public function save_videos(){
		$path = FCPATH . "uploads/video/" . $this->user_id;
		$data = [];
		if(is_dir($path)){
			$videos = glob($path."/*");
			foreach($videos as $video){
				if(is_file($video)){
					$filename = basename($video);
					$file = $path . "/" . $filename;
					if($this->video_model->video_exists($filename)){
						$data[] = [
							'filename' => basename($video),
							'description' => '',
							'date_created' => date ("Y-m-d H:i:s.", filectime($file)),
							'userId' => $this->user_id
						];

					}
					
				}
			}

			$this->video_model->save_videos($data);
		}
		return ;
	}

	public function delete_video(){
		$filename = $this->input->post('filename');
		$file = FCPATH . "uploads/video/" . $this->user_id . "/" . $filename;
		unlink($file);
		return $this->video_model->delete_video($this->user_id, $filename);
	}

	public function add_video_description(){
		$id = $this->input->post('id');
		$description = $this->input->post('description');
		return $this->video_model->add_video_description($id, $this->userId, $description);
	}

	public function get_videos(){
		$data = $this->video_model->get_videos($this->user_id);
		echo json_encode($data);
	}

}