<?php
require APPPATH . 'libraries/REST_Controller.php';

class Video extends REST_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('label_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }


    public function upload_post()
    {
        // maak onderstaande directory writable.
        // chmod -R 777 /Applications/uploads

        switch (strtolower($_SERVER['HTTP_HOST']))
        {
            case 'tiqs.com':
                $uploaddir = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/video/';
                break;
			case 'www.tiqs.com':
				$uploaddir = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/video/';
				break;
            default:
                $uploaddir = '/Users/peterroos/www/tiqs/application/uploads/video/';
                break;
        }

        if(!$this->input->post('vendor_id')){
            $data['type'] = "Error";
            $data['text'] = "Vendor id cannot be null!";
            return $this->output
            ->set_content_type('application/json')
            ->set_status_header(500)
            ->set_output(json_encode($data));
        }

        $vendor_id = $this->input->post('vendor_id');
        $uploaddir .= $vendor_id;
//        var_dump($uploaddir);
//        die();
		if (!is_dir($uploaddir)) {
			mkdir($uploaddir, 0777, TRUE);
		}

        $config['upload_path']   = $uploaddir;
        $config['allowed_types'] = 'mp4|3gp|mov|wmv|flv|avi|qt|mkv|webm|jpg|jpeg';
        $config['max_size']      = '102400'; // 102400 100mb
        $post_video              = $_FILES['userfile']['name'];
        $video_name_array          = explode(".", $post_video);
        $extension               = end($video_name_array);
        $video_name                = rand() . '.' . $extension;
        $config['file_name']     = $video_name;


		$mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['userfile']['name']);
		$this->load->library('upload', $config);

		//		echo var_dump($config);
		//		die();
		//				$filename = $this->post('userfile');
		//		echo var_dump($filename);
		//		die();

        if (!$this->upload->do_upload('userfile')) {
            $errors   = $this->upload->display_errors('', '');
            $data['type'] = "Error";
            $data['text'] = $this->upload->display_errors('', '');
            return $this->output
            ->set_content_type('application/json')
            ->set_status_header(500)
            ->set_output(json_encode($data));
        } else {
            $this->data = array('upload_data' => $this->upload->data());
            $data['type'] = "Success";
            $data['text'] = "Uploaded successfully!";
            return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));
        }


    }

}

?>
