<?php
// require(APPPATH.'/libraries/REST_Controller.php');

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

        $valid_formats = array("mp4");
        $filename = $_FILES['file']['name'];
        if (strlen($filename) > 0)
        {
            list($txt, $ext) = explode(".", strtolower($filename));
            if (!in_array($ext, $valid_formats))
            {
                $data['status'] = "0";
                $data['message'] = "Invalid movie format";
                $this->response($data, 200);
            }
        }
        else
        {
            $data['status'] = "0";
            $data['message'] = "Invalid movie filename";
            $this->response($data, 200);
            return;
        }

        $vendor = $this->security->xss_clean($this->input->post('vendor'));

       	$path = $uploaddir . $vendor . "-" ;
        // $uploadfile = $uploaddir . basename($_FILES['file']['name']);
        // if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))

        if(move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name']))
        {

        }
        else
        {
            $data['status'] =  "0";
            $data['message'] = "video not uploaded, try again";
        }
        $this->response($data, 200);
    }

}

?>
