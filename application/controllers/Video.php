<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Video extends BaseControllerWeb
{
	private $vendor_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('comparison_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
	}

	public function index(){
		$this->global['pageTitle'] = 'TIQS: Videos';
		$this->loadViews("video/index", $this->global, '', 'footerbusiness', 'headerbusiness');
	}

	public function get_videos(){
		$path = FCPATH . "uploads/video/" . $this->vendor_id;
		$data = [];
		$i = 1;
		if(is_dir($path)){
			$videos = glob($path."/*");
			foreach($videos as $video){
				if(is_file($video)){
					$data[] = [
						'index' => $i,
						'video' => basename($video)
					];
					
				}
			 $i++;
			}
			
			echo json_encode($data);
		}
		//echo "false";
	}

}
