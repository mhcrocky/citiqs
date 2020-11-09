<?php
//require(APPPATH.'/libraries/REST_Controller.php');

class Video extends \CI_Controller
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

        $config['upload_path']   = $uploaddir;
        $config['allowed_types'] = 'mp4|3gp|mov|wmv|flv|avi|qt|mkv|webm';
        $config['max_size']      = '102400'; // 102400 100mb
        $post_image              = $_FILES['file']['name'];
        $video_name_array          = explode(".", $post_image);
        $extension               = end($video_name_array);
        $video_name                = rand() . '.' . $extension;
        $config['file_name']     = $video_name;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
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
