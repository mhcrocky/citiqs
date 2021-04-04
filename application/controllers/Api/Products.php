<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Products extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
		$this->load->model('api_model');
		$this->load->model('shopproductex_model');

		$this->load->helper('utility_helper');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));

	}

    public function allcategories_get()
    {
        $this->db->select('id, description');
        $this->db->from('tbl_category');
        $this->db->order_by('description');
        $query = $this->db->get();
        $result = $query->result_array();

        $this->response($result, 200);
    }

	public function getallproducts_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
//		echo var_dump($vendorId);
//		die();
		$products = $this->shopproductex_model->getAllUserProducts(intval($vendorId));
		echo json_encode($products);
	}

	public function index_get()
	{
		$data = "No function called like this";
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function index_post()
	{
		$data = "No function called like this";
		$this->response($data, REST_Controller::HTTP_OK);
	}

    public function upload_post()
    {
        // maak onderstaande directory writable.
        // chmod -R 777 /Applications/uploads

        switch (strtolower($_SERVER['HTTP_HOST']))
        {
            case 'tiqs.com':
                $uploaddir = '/home/tiqs/public_html/alfred/assets/images/productImages/';

                break;
            default:
                $uploaddir = '/Users/peterroos/www/alfred/application/uploads/productImages/';
                break;
        }

        $valid_formats = array("jpg", "jpeg", "png");
        $filename = $_FILES['file']['name'];

		//        var_dump($_FILES);
		//        var_dump($filename);
		//        die();

        if (strlen($filename) > 0)
        {
            list($txt, $ext) = explode(".", strtolower($filename));
            if (!in_array($ext, $valid_formats))
            {
                $data['status'] = "0";
                $data['message'] = "Invalid photo format";
                $this->response($data, 200);
            }
        }
        else
        {
            $data['status'] = "0";
            $data['message'] = "Invalid photo filename";
            $this->response($data, 200);
            return;
        }


		//        // $hash = $_POST['hash'];
		//        $hash = $this->security->xss_clean($this->input->post('hash'));
		//        if (empty($hash))
		//        {
		//            $data['status'] = "0";
		//            $data['message'] = "You are not logged in. Please, login first";
		//            $this->response($data, 200);
		//            return;
		//        }

        // both fields always have a valid value
        // $descript = $_POST['descript'];
        $vendorId = $this->security->xss_clean($this->input->post('vendorId'));
        // $categoryid = $_POST['categoryid'];
        $description = $this->security->xss_clean($this->input->post('description'));
		$printerId = $this->security->xss_clean($this->input->post('printerId'));
		$categoryId = $this->security->xss_clean($this->input->post('categoryId'));

		//         var_dump($vendorId);
		//         var_dump($description);

        // get userid by hash
		//        $userInfo = $this->user_model->getUserInfoByHash($hash);
		//        $labelInfo = array(
		//            'userId' => $userInfo->userId,
		//            'descript' => $descript,
		//            'categoryid' => $categoryid,
		//            'ipaddress' => $this->input->ip_address(),
		//            'createdDtm' => date('Y-m-d H:i:s' ),
		//            'lost' => 0);
		//
		//        $labelInfo = $this->label_model->generateCodeAndInsertLabel($labelInfo);
		//        if (empty($labelInfo))
		//        {
		//            $data['status'] =  "0";
		//            $data['message'] = "Could not generate code for photo, try again";
		//            $this->response($data, 200);
		//            return;
		//        }
		//        $path = $uploaddir . $userInfo->userId . "-" . $labelInfo->code . '-';

		$path = $uploaddir;
        // $uploadfile = $uploaddir . basename($_FILES['file']['name']);
        // if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
//
//		var_dump($path);
//		var_dump($_FILES);

        if(move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name']))
        {
            $data['status'] =  "1";
            $data['message'] = "Photo uploaded";
        }
        else
		{
			$data['status'] =  "0";
			$data['message'] = "Photo not uploaded, try again";
		}
        $this->response($data, 200);
    }

}

?>
