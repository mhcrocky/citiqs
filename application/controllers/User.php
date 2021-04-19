<?php

use idcheckio\Configuration;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class User extends BaseControllerWeb {

    /**
     * This is default constructor of the class
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('country_helper');
        $this->load->helper('form');
        $this->load->helper('uploadfile_helper');
        $this->load->helper('google_helper');
        $this->load->library('form_validation');

        $this->load->model('user_model');
        $this->load->model('label_model');
        $this->load->model('user_subscription_model');
        $this->load->model('category_model');
        $this->load->model('businesstype_model');

        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('pagination');

        $this->load->config('custom');

        $this->isLoggedIn();

        /*
          switch (strtolower($_SERVER['HTTP_HOST']))
          {
          case 'tiqs.com':
          require_once'/home/tiqs/domains/tiqs.com/public_html/shop/application/libraries/fpdf/fpdf.php';
          require_once'/home/tiqs/domains/tiqs.com/public_html/shop/application/libraries/qrcode/qrcode.php';
          break;
          case 'loki-lost':
          require_once'/usr/share/nginx/html/lostandfound/application/libraries/fpdf/fpdf.php';
          require_once'/usr/share/nginx/html/lostandfound/application/libraries/qrcode/qrcode.php';
          break;
          default:
          require_once'/Users/peterroos/www/tiqs/shop/application/libraries/fpdf/fpdf.php';
          require_once'/Users/peterroos/www/tiqs/shop/application/libraries/qrcode/qrcode.php';
          break;
          }
         */
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index() {
        $this->global['pageTitle'] = 'tiqs : Dashboard';

        $this->loadViews("dashboard", $this->global, NULL, NULL);
    }

    /**
     * This function is used to load the user list [not user in tiqs lost + found] currently only for admin.
     */
    /*
      function userListing()
      {
      if($this->isAdmin() == TRUE)
      {
      $this->loadThis();
      }
      else{
      $searchText = $this->security->xss_clean($this->input->post('searchText'));
      $data['searchText'] = $searchText;
      $this->load->library('pagination');
      $count = $this->user_model->userListingCount($searchText);
      $returns = $this->paginationCompress ( "userListing/", $count, 10 );
      $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
      $this->global['pageTitle'] = 'tiqs: User Listing';
      $this->loadViews("users", $this->global, $data, NULL);
      }
      }
     */

    function uploadIdentification() {
        ini_set('memory_limit', '256M');

        $id = $this->security->xss_clean($this->input->post('ilabelid'));
        if (empty($id)) {
            $this->session->set_flashdata('error', "Your device cannot be used to identify yourself. Use another device e.g. desktop computer.");
            redirect('userReturnitemslisting');
        }

        $valid_formats = array("jpg", "jpeg", "png", "tiff", "pdf");
        $name = $_FILES['idfile']['name'];
        if (strlen($name)) {
            list($txt, $ext) = explode(".", strtolower($name));
            if (in_array($ext, $valid_formats)) {

                $result = $this->label_model->getLabelInfoById($id, $this->userId);
                if (empty($result)) {
                    // unlink($path.$_FILES['imgfile']['name']);
                    unlink($_FILES['idfile']['tmp_name']);
                    redirect('userReturnitemslisting');
                }

                $fname = strval(time()) . '.' . $ext;

                switch (strtolower($_SERVER['HTTP_HOST'])) {
                    case 'tiqs.com':
                        $uploaddir = '/home/tiqs/domains/tiqs.com/public_html/lostandfound/uploads/LabelImages/';
                        // $filepath = '/home/tiqs/domains/tiqs.com/uploads/' . $this->userId . "-" . $result->code . '-' . $fname;
                        $filepath = $uploaddir . $this->userId . "-" . $result->code . '-' . $fname;
                        break;
                    case '192.168.1.67':
                        $filepath = "/var/upload/" . $this->userId . "-" . $result->code . '-' . $fname;
                        break;
                    default:
                        $filepath = "/var/upload/" . $this->userId . "-" . $result->code . '-' . $fname;
                        break;
                    case '127.0.0.1':
                        $filepath = '/Users/peterroos/www/lostandfound/uploads' . $this->userId . "-" . $result->code . '-' . $fname;
                        break;
                }

                $upload_status = move_uploaded_file($_FILES['idfile']['tmp_name'], $filepath);
                if ($upload_status) {
                    $result = $this->checkIdentity($filepath);
                    if ($result) {
                        $userInfo = array('identification' => $filepath);
                        $result = $this->label_model->editLabel($userInfo, $this->userId, $id);
                        if (!$result) {
                            unlink($filepath);
                            $this->session->set_flashdata('error', "Could not save identification, try again.");
                        } else
                            $this->session->set_flashdata('success', 'Identification successful. Please, continue with the next step.');
                    } else {
                        $userInfo = array('identification' => NULL);
                        $result = $this->label_model->editLabel($userInfo, $this->userId, $id);
                        unlink($filepath);
                        $this->session->set_flashdata('error', 'Identification NOT successful. Please, try again or contact staff if this problem persist.');
                    }
                } else {
                    $userInfo = array('identification' => NULL);
                    $result = $this->label_model->editLabel($userInfo, $this->userId, $id);
                    $this->session->set_flashdata('error', "File size exceeds 256MB. Please, upload a smaller identification");
                }
            } else {
                $userInfo = array('identification' => NULL);
                $result = $this->label_model->editLabel($userInfo, $this->userId, $id);
                $this->session->set_flashdata('error', "File has invalid format (use jpg, png, tiff or pdf).");
            }
        }

        redirect('userReturnitemslisting');
    }

    private function checkIdentity($filepath) {
        switch (strtolower($_SERVER['HTTP_HOST'])) {
            case 'tiqs.com':
                require_once('/home/tiqs/domains/tiqs.com/public_html/lostandfound/vendor/ariadnext/php-IDCHECKIO/autoload.php');
                idcheckio\Configuration::getDefaultConfiguration()->setUsername('peter@appao.nl'); //Production Server
                idcheckio\Configuration::getDefaultConfiguration()->setPassword('N2ld2rt01@!');   //Production Server
                idcheckio\Configuration::getDefaultConfiguration()->setHost('https://api.idcheck.io'); //Production Server
                break;
            case 'loki-lost.com':
            case '10.0.0.48':
            case '192.168.1.67':
                require_once('/usr/share/nginx/html/lostandfound/vendor/ariadnext/php-IDCHECKIO/autoload.php');
                idcheckio\Configuration::getDefaultConfiguration()->setUsername('appao@ariadnext.com'); // Sandbox
                idcheckio\Configuration::getDefaultConfiguration()->setPassword('!!uBGt7T4!9k');  // Sandbox
                idcheckio\Configuration::getDefaultConfiguration()->setHost('https://api-test.idcheck.io/rest');
                idcheckio\Configuration::getDefaultConfiguration()->setSSLVerification(false);
                break;
            default:
                require_once('/usr/share/nginx/html/lostandfound/vendor/ariadnext/php-IDCHECKIO/autoload.php');
                idcheckio\Configuration::getDefaultConfiguration()->setUsername('appao@ariadnext.com'); // Sandbox
                idcheckio\Configuration::getDefaultConfiguration()->setPassword('!!uBGt7T4!9k');  // Sandbox
                idcheckio\Configuration::getDefaultConfiguration()->setHost('https://api-test.idcheck.io/rest');
                idcheckio\Configuration::getDefaultConfiguration()->setSSLVerification(false);
                break;
        }

        idcheckio\Configuration::getDefaultConfiguration()->setCurlConnectTimeout(60);
        idcheckio\Configuration::getDefaultConfiguration()->setCurlTimeout(60);

        $api_instance = new \idcheckio\api\AnalysisApi(); //Initializing analysis Api

        $async_mode = true; // bool | true to activate asynchrone mode
        $accept_language = "en"; // string | Accept language header

        $returnstatus = false;

        try {
            $body = new \idcheckio\model\ImageRequest();
            $base64 = base64_encode(file_get_contents($filepath));
            $body->setFrontImage($base64);
            //$body->setBackImage(base64_encode($backImageContent)); //optional if back image of id is using
            try {
                $result = $api_instance->postImage($body, $async_mode, $accept_language);
                // file_put_contents("/var/upload/test.txt",$result);
                if ($result) {
                    if ($result['check_report_summary']['check']) {
                        $returnstatus = true;
                        foreach ($result['check_report_summary']['check'] as $check) {
                            if ($check['result'] != "OK") {
                                $returnstatus = false;
                                break;
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Cannot check identification with API. Please, contact staff: ', $e->getMessage());
            }
        } catch (IOException $ioe) {
            $this->session->set_flashdata('error', 'Cannot check identification (encode error). Please, contact staff: ', $ioe->getMessage());
        }

        return ($returnstatus);
    }

    function uploadUtilitybill() {
        ini_set('memory_limit', '256M');

        $id = $this->security->xss_clean($this->input->post('ublabelid'));
        if (empty($id)) {
            $this->session->set_flashdata('error', "Your device cannot be used to upload your utility bill. Use another device e.g. desktop computer.");
            redirect('userReturnitemslisting');
        }

        $valid_formats = array("jpg", "jpeg", "png", "tiff", "pdf");
        $name = $_FILES['ubfile']['name'];
        if (strlen($name)) {
            list($txt, $ext) = explode(".", strtolower($name));
            if (in_array($ext, $valid_formats)) {

                $result = $this->label_model->getLabelInfoById($id, $this->userId);
                if (empty($result)) {
                    // unlink($path.$_FILES['imgfile']['name']);
                    unlink($_FILES['ubfile']['tmp_name']);
                    redirect('userReturnitemslisting');
                }

                $fname = strval(time()) . '.' . $ext;

                switch (strtolower($_SERVER['HTTP_HOST'])) {
                    case 'tiqs.com':
                        $uploaddir = '/home/tiqs/domains/tiqs.com/public_html/lostandfound/uploads/LabelImages/';
                        // $filepath = '/home/tiqs/domains/tiqs.com/uploads/' . $this->userId . "-" . $result->code . '-' . $fname;
                        $filepath = $uploaddir . $this->userId . "-" . $result->code . '-' . $fname;
                        // $filepath = '/home/tiqs/domains/tiqs.com/uploads/' . $this->userId . "-" . $result->code . '-' . $fname;;
                        break;
                    case 'loki-lost.com':
                    case '10.0.0.48':
                    case '192.168.1.67':
                        $filepath = "/var/upload/" . $this->userId . "-" . $result->code . '-' . $fname;
                        break;
                    default:
                        $filepath = "/var/upload/" . $this->userId . "-" . $result->code . '-' . $fname;
                        break;
                }

                $upload_status = move_uploaded_file($_FILES['ubfile']['tmp_name'], $filepath);
                if ($upload_status) {
                    $userInfo = array('utilitybill' => $filepath);
                    $result = $this->label_model->editLabel($userInfo, $this->userId, $id);
                    if (!$result)
                        $this->session->set_flashdata('error', "Could not save utility bill, try again.");
                    else
                        $this->session->set_flashdata('success', 'Upload of your utility bill was successful. If you\'ve finished all three steps, you can wait and relax. We will contact you by e-mail.');
                } else {
                    $userInfo = array('utilitybill' => NULL);
                    $result = $this->label_model->editLabel($userInfo, $this->userId, $id);
                    $this->session->set_flashdata('error', "File size exceeds 256MB or invalid format (use jpg, png, tiff or pdf).");
                }
            } else {
                $userInfo = array('utilitybill' => NULL);
                $result = $this->label_model->editLabel($userInfo, $this->userId, $id);
                $this->session->set_flashdata('error', "File size exceeds 256MB or invalid format (use jpg, png, tiff or pdf).");
            }
        }

        redirect('userReturnitemslisting');
    }

    function userReturnitemslisting() {

        // Check valid subscription first
        if ($this->session->userdata('dropoffpoint') == 1) {
            redirect('lostandfoundlist');
        }

        $result = $this->user_subscription_model->getUserSubscriptionInfoByUserId($this->userId);
        if (empty($result)) {
            // Any found labels and no subscription?
            $result = $this->label_model->getFoundLabelsByUserId($this->userId);
            if ($result > 0) {
                $result = $this->user_model->getUserInfoById($this->userId);
                $this->global['pageTitle'] = 'tiqs : Return items pay subscription first';
                $data['email'] = urlencode($result->email);
                $this->loadViews("returnitemspaysubscriptionfirst", $this->global, $data, NULL);
                return;
            }
        }

        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        $this->load->library('pagination');
        $count = $this->user_model->userReturnitemslistingCount($searchText);
        $returns = $this->paginationCompress("userReturnitemslisting/", $count, 10);
        $data['userRecords'] = $this->user_model->userReturnitemslisting($searchText, $returns["page"], $returns["segment"]);
        $this->global['pageTitle'] = 'tiqs : return items Listing';
        $this->loadViews("returnitems", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the user labels list
     */
    function lostandfoundlist() {
        $this->global['pageTitle'] = 'tiqs : Listing';
        $where = (empty($_POST)) ? ['userId' => $_SESSION['userId']] : $this->input->post(null, true);
        $where['label_type_id'] = $this->config->item('labelLost');

        $records = $this->label_model->filterLabels($where);

        if (!count($records)) {            
            $data['userId'] = $this->session->userdata['userId'];
            $view = ($_SESSION['dropoffpoint'] === '1') ? 'nolabels' : 'nolabelsconsumer';
		} else {
            $data = [
                'userId'        => $this->session->userdata['userId'],
                'userRecords'   => $records,
                'categories'    => $this->category_model->getCategories(),
                'dropoffpoint'  => $_SESSION['dropoffpoint'],
                'userLat'       => $_SESSION['lat'],
                'userLng'       => $_SESSION['lng'],
                'isDeleted'     => ((isset($where['isDeleted'])) ? $where['isDeleted'] : '0'),
            ];
			$view = 'labels';
        }

        $this->loadViews($view , $this->global, $data, NULL);
    }

	function userLabelImageFound() {
		ini_set('memory_limit', '256M');

		// found by someone with no account set to major account =1
		$id = "1";

		//if (!file_exists($path)) {
		//    mkdir($path, 0777, true);
		//}
		$valid_formats = array("jpg", "jpeg", "png");
		$name = $_FILES['imgfile']['name'];
		if (strlen($name)) {
			list($txt, $ext) = explode(".", strtolower($name));
			if (in_array($ext, $valid_formats)) {

				$result = $this->label_model->getLabelInfoById($id, $this->userId);
				if (empty($result)) {
					// unlink($path.$_FILES['imgfile']['name']);
					unlink($_FILES['imgfile']['tmp_name']);
					redirect('lostandfoundlist');
				}

				switch (strtolower($_SERVER['HTTP_HOST'])) {
					case 'tiqs.com':
						//       $path = '/home/tiqs/domains/tiqs.com/public_html/uploads/LabelImages/';
						$path = '/home/tiqs/domains/tiqs.com/public_html/lostandfound/uploads/LabelImages/' . $this->userId . "-" . $result->code . '-';
						break;
					case 'loki-lost.com':
					case '10.0.0.48':
					case '192.168.1.67':
						$path = "/var/upload/LabelImages/" . $this->userId . "-" . $result->code . '-';
						break;
					default:
						$path = "/var/upload/LabelImages/" . $this->userId . "-" . $result->code . '-';
						break;
					case '127.0.0.1':
						$path = '/Users/peterroos/www/lostandfound/uploads/LabelImages/' . $this->userId . "-" . $result->code . '-';
						break;
				}

                //  $path = "uploads/LabelImages/" . $this->userId . "-" . $result->code . '-';

				$upload_status = move_uploaded_file($_FILES['imgfile']['tmp_name'], $path . $_FILES['imgfile']['name']);
				if ($upload_status) {
					$fname = strval(time());
					$new_name = $path . $fname . '.' . $ext;
					if ($this->watermark_text($path . $_FILES['imgfile']['name'], $new_name, $ext, $result->code)) {
						$demo_image = $fname . '.jpg';
						$userInfo = array('image' => $demo_image);
						$result = $this->user_model->updateimg($userInfo, $id, $this->userId);
					}
				} else
					$this->session->set_flashdata('error', "File move not succeeded (use jpg or png).");
			} else
				$this->session->set_flashdata('error', "Invalid format file (use jpg or png).");
		}

		redirect('found/');
	}

	function LabelImageCreateFound() {
		ini_set('memory_limit', '256M');

		// hier automatisch  iuw label maken
		// ID maken voor de found.

		$id = $this->security->xss_clean($this->input->post('id'));

		$valid_formats = array("jpg", "jpeg", "png");
		$name = $_FILES['imgfile']['name'];
		if (strlen($name)) {
			list($txt, $ext) = explode(".", strtolower($name));
			if (in_array($ext, $valid_formats)) {

                //				$result = $this->label_model->getLabelInfoById($id, $this->userId);
                //				if (empty($result)) {
                //					// unlink($path.$_FILES['imgfile']['name']);
                //					unlink($_FILES['imgfile']['tmp_name']);
                //					redirect('lostandfoundlist');
                //				}

				switch (strtolower($_SERVER['HTTP_HOST'])) {
					case 'tiqs.com':
						//       $path = '/home/tiqs/domains/tiqs.com/public_html/uploads/LabelImages/';
						$path = '/home/tiqs/domains/tiqs.com/public_html/lostandfound/uploads/LabelImages/' . $this->userId . "-" . $result->code . '-';
						break;
					case 'loki-lost.com':
					case '10.0.0.48':
					case '192.168.1.67':
						$path = "/var/upload/LabelImages/" . $this->userId . "-" . $result->code . '-';
						break;
					default:
						$path = "/var/upload/LabelImages/" . $this->userId . "-" . $result->code . '-';
						break;
					case '127.0.0.1':
						$path = '/Users/peterroos/www/lostandfound/uploads/LabelImages/' . $this->userId . "-" . $result->code . '-';
						break;
				}

                //                $path = "uploads/LabelImages/" . $this->userId . "-" . $result->code . '-';

				$upload_status = move_uploaded_file($_FILES['imgfile']['tmp_name'], $path . $_FILES['imgfile']['name']);
				if ($upload_status) {
					$fname = strval(time());
					$new_name = $path . $fname . '.' . $ext;
					if ($this->watermark_text($path . $_FILES['imgfile']['name'], $new_name, $ext, $result->code)) {
						$demo_image = $fname . '.jpg';
						$userInfo = array('image' => $demo_image);
						$result = $this->user_model->updateimg($userInfo, $id, $this->userId);
					}
				} else
					$this->session->set_flashdata('error', "File move not succeeded (use jpg or png).");
			} else
				$this->session->set_flashdata('error', "Invalid format file (use jpg or png).");
		}

		redirect('lostandfoundlist');
	}

    /**
     * This function is used to upload and create an image
     */
    function userLabelImageCreate() {
        ini_set('memory_limit', '256M');
        $fileKey = array_keys($_FILES)[0];
        $databaseImage = time() . '_' . rand(10000,99999) . '.' . File_helper::getFileExtension($_FILES[$fileKey]['name']);
        $_FILES[$fileKey]['name'] = $fileKey . '-' . $databaseImage;
        if (File_helper::uploadLabel()) {
            $id = $this->security->xss_clean($this->input->post("id"));
            $this->user_model->updateimg(['image' => $databaseImage], $id, $this->userId);
        } else {
            $this->session->set_flashdata('error', "Invalid format file (use jpg or png).");
        }
        
        redirect('lostandfoundlist');
    }

    // watermark moet een unieke gegenereerde Code krijgen van uit ons.
    // Dat geld dus alleen met afbeeldingen die ZELF geen unieke code al hebben.
    // Met andere woorden:
    // Alleen die items die Niet van een eigenaar zijn, niet van de finder maar
    // die via de app worden upgeload krrijgen een unieke code
    // De rest van de foto's krijgen dioe dus NIET.

    function watermark_text($oldimage_name, $new_image_name, $ext, $code) {

        switch (strtolower($_SERVER['HTTP_HOST'])) {
            case 'tiqs.com':
                $font_path = "/home/tiqs/domains/tiqs.com/public_html/lostandfound/assets/fonts/OpenSans-Bold.ttf"; // Font file
                break;
            case 'loki-lost.com':
            case '10.0.0.48':
            case '192.168.1.67':
                $font_path = "/usr/share/nginx/html/lostandfound/assets/fonts/OpenSans-Bold.ttf"; // Font file
                break;
            default:
                $font_path = '/Users/peterroos/www/tiqs/assets/fonts/OpenSans-Bold.ttf';
                break;
        }


        $font_size = 30; // in pixels
        $water_mark_text_2 = $code; // Watermark Text
        //global $font_path, $font_size, $water_mark_text_2;
        list($owidth, $oheight) = getimagesize($oldimage_name);
        $width = $owidth;
        $height = $oheight;
        $image = imagecreatetruecolor($width, $height);
        if ($ext == 'png') {
            $image_src = imagecreatefrompng($oldimage_name);
            imagejpeg($image_src, $oldimage_name, 100);
        }
        $image_src = imagecreatefromjpeg($oldimage_name);
        imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
        $blue = imagecolorallocate($image, 79, 166, 185);
        imagettftext($image, $font_size, 0, 0, $height - 30, $blue, $font_path, $water_mark_text_2);
        // imagettftext($image, $font_size, 0, 68, 190, $blue, $font_path, $water_mark_text_2);
        // imagettftext is an in-built function.you can change variables for relocating position of watermark
        if ($ext == 'png')
            $new_image_name = str_replace("png", "jpg", $new_image_name);

        $x = imagejpeg($image, $new_image_name, 100);
        imagedestroy($image);
        unlink($oldimage_name);
        return true;
    }

    /**
     * This function is used to load the user list [not user in tiqs lost + found] currently only for admin.
     */
    /*
      function orderListing(){
      if($this->isManager() != TRUE )
      {     $this->loadThis(); }
      else{
      $searchText = $this->security->xss_clean($this->input->post('searchText'));
      $data['searchText'] = $searchText;
      $this->load->library('pagination');
      $count = $this->user_model->orderListingCount($this->userId);
      $returns = $this->paginationCompress ( "orderListing/", $count, 10 );
      $data['userRecords'] = $this->user_model->orderListing($this->userId, $returns["page"], $returns["segment"]);
      $this->global['pageTitle'] = 'tiqs : Order Listing';
      $this->loadViews("orders", $this->global, $data, NULL);
      }
      }
     */

    /**
     * This function is used to load the add new user [not used?]
     */
    function addNew() {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $data['roles'] = $this->user_model->getUserRoles();

            $this->global['pageTitle'] = 'tiqs : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new label
     */
    function addNewlabel() {
        $data['roles'] = $this->user_model->getUserRoles();
        $data['categories'] = $this->user_model->getallcategories();

        $this->global['pageTitle'] = 'tiqs: Add New label';

        $this->loadViews("addNewlabel", $this->global, $data, NULL);
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists() {
        $userId = $this->security->xss_clean($this->input->post("userId"));
        $email = $this->security->xss_clean($this->input->post("email"));

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {
            echo("true");
        } else {
            echo("false");
        }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser() {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('address','Address','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('addressa','Address aditional','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('zipcode','zipcode','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('city','city','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('country','country','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfbuddy','Lost + Found Buddy','trim|required|max_length[128]');
//            $this->form_validation->set_rules('lfbmobile','Mobile Number','required|min_length[10]');
//            $this->form_validation->set_rules('lfbemail','Email','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfaddress','Address','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfaddressa','Address aditional','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfzipcode','zipcode','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfcity','city','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfcountry','country','trim|required|valid_email|max_length[128]');

            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->addNew();
            } else {
                $name = strtolower($this->security->xss_clean($this->input->post('fname')));
                $mobile = $this->security->xss_clean($this->security->xss_clean($this->input->post('mobile')));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $address = ucwords(strtolower($this->security->xss_clean($this->input->post('address'))));
                $addressa = ucwords(strtolower($this->security->xss_clean($this->input->post('addressa'))));
                $zipcode = ucwords(strtolower($this->security->xss_clean($this->input->post('zipcode'))));
                $city = ucwords(strtolower($this->security->xss_clean($this->input->post('city'))));
                $country = ucwords(strtolower($this->security->xss_clean($this->input->post('country'))));

                $lfbuddy = ucwords(strtolower($this->security->xss_clean($this->input->post('lfbuddy'))));
                $lfbmobile = $this->security->xss_clean($this->security->xss_clean($this->input->post('lfbmobile')));
                $lfbemail = strtolower($this->security->xss_clean($this->input->post('lfbemail')));
                $lfaddress = ucwords(strtolower($this->security->xss_clean($this->input->post('lfaddress'))));
                $lfaddressa = ucwords(strtolower($this->security->xss_clean($this->input->post('lfaddressa'))));
                $lfzipcode = ucwords(strtolower($this->security->xss_clean($this->input->post('lfzipcode'))));
                $lfcity = ucwords(strtolower($this->security->xss_clean($this->input->post('lfcity'))));
                $lfcountry = ucwords(strtolower($this->security->xss_clean($this->input->post('lfcountry'))));
                $password = $this->security->xss_clean($this->input->post('password'));
                $roleId = $this->security->xss_clean($this->input->post('role'));

                $userInfo = array('username' => $name,
                    'mobile' => $mobile,
                    'email' => $email,
                    'address' => $address,
                    'addressa' => $addressa,
                    'zipcode' => $zipcode,
                    'city' => $city,
                    'country' => $country,
                    'lfbuddy' => $lfbuddy,
                    'lfbmobile' => $lfbmobile,
                    'lfbemail' => $lfbemail,
                    'lfaddress' => $lfaddress,
                    'lfaddressa' => $lfaddressa,
                    'lfzipcode' => $lfzipcode,
                    'lfcity' => $lfcity,
                    'lfcountry' => $lfcountry,
                    'password' => getHashedPassword($password),
                    'roleId' => $roleId, 'username' => $name,
                    'createdBy' => $this->userId,
                    'createdDtm' => date('Y-m-d H:i:s'),
                );

                $result = $this->user_model->addNewUser($userInfo);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New User created successfully');
                } else {
                    $this->session->set_flashdata('error', 'User creation failed');
                }

                redirect('addNew');
            }
        }
    }

    function addNewUserlabel() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('code', 'Unique code', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('descript', 'Description', 'trim|required|max_length[128]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'New label creation failed');
            redirect('lostandfoundlist');
        } else {
            $code = $this->security->xss_clean($this->input->post('code'));
            if ($this->label_model->doesUserdefinedcodeExist($code)) {
                // aangepast op dit moment probeert iemand een code in te voeren die door middel van onze generor al is gemaakt.
                // i.p.v. een fout boodschap kunnen we beter deze redirecten naar de invoer pagina (check) van de code om die in te laten voeren..
                $this->session->set_flashdata('error', 'Already used code!');
                redirect('lostandfoundlist');
            }
            $code = strtolower($code);
            $categoryid = $this->security->xss_clean($this->input->post('categoryid'));
            $descript = $this->security->xss_clean($this->input->post('descript'));

            $userInfo = array('categoryid' => $categoryid, 'userId' => $this->userId, 'lost' => 0,
                'descript' => $descript, 'code' => $code, 'ipaddress' => $this->input->ip_address(), 'createdDtm' => date('Y-m-d H:i:s'));

            $result = $this->user_model->addNewUserlabel($userInfo);

            if ($result > 0) {
                $this->session->set_flashdata('success', 'New label created successfully');
            } else {
                $this->session->set_flashdata('error', 'New label creation failed');
            }

            redirect('lostandfoundlist');
        }
    }

    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    /*
      function editOld($userId = NULL)
      {
      if($this->isAdmin() == TRUE || $userId == 1)
      {
      $this->loadThis();
      }
      else
      {
      if($userId == null)
      {
      redirect('userListing');
      }

      $data['roles'] = $this->user_model->getUserRoles();
      $data['userInfo'] = $this->user_model->getUserInfo($userId);

      $this->global['pageTitle'] = 'tiqs : Edit User';

      $this->loadViews("editOld", $this->global, $data, NULL);
      }
      }
     */


    function editOldlabel($id = NULL) {

        $this->isLoggedIn();

        if ($id == null) {
            redirect('lostandfoundlist');
        }
        $data['roles'] = $this->user_model->getUserRoles();
        $data['userInfo'] = $this->user_model->getUserInfolabel($id);
        $data['categories'] = $this->user_model->getallcategories();
        // changed from userid to id. see related function as well
        $this->global['pageTitle'] = 'tiqs : Edit bag-tag code';
        $this->loadViews("editOldlabel", $this->global, $data, NULL);
    }

    public function editUserlabel()
    {
        $this->isLoggedIn();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('descript', 'Description', 'trim|required|max_length[128]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Failed to update label');
            redirect('lostandfoundlist');
        } else {
            // $code = strtolower($this->security->xss_clean($this->input->post('code')));
            $categoryid = $this->security->xss_clean($this->input->post('categoryid'));
            $descript = $this->security->xss_clean($this->input->post('descript'));
            $userInfo = array('descript' => $descript, 'categoryid' => $categoryid);
            $labelid = $this->security->xss_clean($this->input->post('id'));
            $result = $this->user_model->updateUserlabel($userInfo, $labelid, $this->userId);
            if ($result > 0) {
                $this->session->set_flashdata('success', 'Successfully updated label');
            } else {
                $this->session->set_flashdata('error', 'Failed to update label');
            }
            redirect('lostandfoundlist');
        }
    }

    function setlost($id, $lost) {

        $this->isLoggedIn();

        $userInfo = array('lost' => $lost);
        $labelid = $id;
        $result = $this->user_model->updateUserlabellost($userInfo, $labelid, $this->userId);

        if ($result > 0) {
            $this->session->set_flashdata('success', 'Successfully updated label');
        } else {
            $this->session->set_flashdata('error', 'Failed update label');
        }

        redirect('lostandfoundlist');
    }

    function setlostreturn($id, $lost) {

        $this->isLoggedIn();

        $userInfo = array('lost' => $lost);
        $labelid = $id;
        $result = $this->user_model->updateUserlabellost($userInfo, $labelid, $this->userId);

        if ($result > 0) {
            $this->session->set_flashdata('success', 'Successfully updated label');
        } else {
            $this->session->set_flashdata('error', 'Failed update label');
        }

        redirect('userReturnitemslisting');
    }

    /**
     * This function is used to edit the user information
     */
    function editUser() {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $userId = $this->security->xss_clean($this->input->post('userId'));

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('address','Address','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('addressa','Address aditional','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('zipcode','zipcode','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('city','city','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('country','country','trim|required|valid_email|max_length[128]');
//
//            $this->form_validation->set_rules('lfbuddy','Lost + Found Buddy','trim|required|max_length[128]');
//            $this->form_validation->set_rules('lfbmobile','Mobile Number','required|min_length[10]');
//            $this->form_validation->set_rules('lfbemail','Email','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfaddress','Address','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfaddressa','Address aditional','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfzipcode','zipcode','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfcity','city','trim|required|valid_email|max_length[128]');
//            $this->form_validation->set_rules('lfcountry','country','trim|required|valid_email|max_length[128]');

            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');


            if ($this->form_validation->run() == FALSE) {
                $this->editOld($userId);
            } else {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $mobile = $this->security->xss_clean($this->security->xss_clean($this->input->post('mobile')));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $address = ucwords(strtolower($this->security->xss_clean($this->input->post('address'))));
                $addressa = ucwords(strtolower($this->security->xss_clean($this->input->post('addressa'))));
                $zipcode = ucwords(strtolower($this->security->xss_clean($this->input->post('zipcode'))));
                $city = ucwords(strtolower($this->security->xss_clean($this->input->post('city'))));
                $country = ucwords(strtolower($this->security->xss_clean($this->input->post('country'))));

                $lfbuddy = ucwords(strtolower($this->security->xss_clean($this->input->post('lfbuddy'))));
                $lfbmobile = $this->security->xss_clean($this->security->xss_clean($this->input->post('lfbmobile')));
                $lfbemail = strtolower($this->security->xss_clean($this->input->post('lfbemail')));
                $lfaddress = ucwords(strtolower($this->security->xss_clean($this->input->post('lfaddress'))));
                $lfaddressa = ucwords(strtolower($this->security->xss_clean($this->input->post('lfaddressa'))));
                $lfzipcode = ucwords(strtolower($this->security->xss_clean($this->input->post('lfzipcode'))));
                $lfcity = ucwords(strtolower($this->security->xss_clean($this->input->post('lfcity'))));
                $lfcountry = ucwords(strtolower($this->security->xss_clean($this->input->post('lfcountry'))));

                $password = $this->security->xss_clean($this->input->post('password'));
                $roleId = $this->security->xss_clean($this->input->post('password'));

                $userInfo = array();

                if (empty($password)) {
                    $userInfo = array(
                        'username' => $name,
                        'mobile' => $mobile,
                        'email' => $email,
                        'address' => $address,
                        'addressa' => $addressa,
                        'zipcode' => $zipcode,
                        'city' => $city,
                        'country' => $country,
                        'lfbuddy' => $lfbuddy,
                        'lfbmobile' => $lfbmobile,
                        'lfbemail' => $lfbemail,
                        'lfaddress' => $lfaddress,
                        'lfaddressa' => $lfaddressa,
                        'lfzipcode' => $lfzipcode,
                        'lfcity' => $lfcity,
                        'lfcountry' => $lfcountry,
                        'updatedBy' => $this->userId,
                        'updatedDtm' => date('Y-m-d H:i:s')

                            //                'password'=>getHashedPassword($password),
                            //                'roleId'=>$roleId, 'username'=> $name,
                            //                'createdBy'=>$this->userId,
                            //                'createdDtm'=>date('Y-m-d H:i:s'),
                    );
                } else {
                    $userInfo = array(
                        'username' => $name,
                        'mobile' => $mobile,
                        'email' => $email,
                        'address' => $address,
                        'addressa' => $addressa,
                        'zipcode' => $zipcode,
                        'city' => $city,
                        'country' => $country,
                        'lfbuddy' => $lfbuddy,
                        'lfbmobile' => $lfbmobile,
                        'lfbemail' => $lfbemail,
                        'lfaddress' => $lfaddress,
                        'lfaddressa' => $lfaddressa,
                        'lfzipcode' => $lfzipcode,
                        'lfcity' => $lfcity,
                        'llfcountry' => $lfcountry,
                        'updatedBy' => $this->userId,
                        'updatedDtm' => date('Y-m-d H:i:s'),
                        'password' => getHashedPassword($password),
//                'roleId'=>$roleId, 'username'=> $name,
//                'createdBy'=>$this->userId,
//                'createdDtm'=>date('Y-m-d H:i:s'),
                    );

//                    $userInfo = array('lfbuddy'=>$lfbuddy,'email'=>$email,'lfbemail'=>$lfbemail,'password'=>getHashedPassword($password), 'roleId'=>$roleId,
//                        'username'=>ucwords($name), 'mobile'=>$mobile, 'lfbmobile'=>$lfbmobile, 'updatedBy'=>$this->userId,
//                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }

                $result = $this->user_model->editUser($userInfo, $userId);

                if ($result == true) {
                    $this->session->set_flashdata('success', 'User updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'User updation failed');
                }

                redirect('userListing');
            }
        }
    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser() {
        $this->isLoggedIn();

        $labelId = $this->security->xss_clean($this->input->post('userId'));
        $labelInfo = array('isDeleted' => 1);

        $result = $this->user_model->deleteUserlabel($labelId, $this->userId, $labelInfo);

        if ($result > 0) {
            echo(json_encode(array('status' => TRUE)));
        } else {
            echo(json_encode(array('status' => FALSE)));
        }

        /*
          if($this->isAdmin() == TRUE)
          {
          echo(json_encode(array('status'=>'access')));
          }
          else
          {
          $userId = $this->security->xss_clean($this->input->post('userId'));
          $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->userId, 'updatedDtm'=>date('Y-m-d H:i:s'));

          $result = $this->user_model->deleteUser($userId, $userInfo);

          if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
          else { echo(json_encode(array('status'=>FALSE))); }
          }
         */
    }

    /**
     * Page not found : error 404
     */
    function pageNotFound() {
        $this->global['pageTitle'] = 'tiqs : 404 - Page Not Found';

        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL) {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $fromDate = $this->security->xss_clean($this->input->post('fromDate'));
            $toDate = $this->security->xss_clean($this->input->post('toDate'));

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;

            $this->load->library('pagination');

            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress("login-history/" . $userId . "/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'tiqs : User Login History';

            $this->loadViews("loginHistory", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to show users profile
     */
    public function profilepage($active = "details")
    {
        $this->global['pageTitle'] = $active == "details" ? 'tiqs : My Profile' : 'tiqs : Change Password';
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $data = [
            'user' => $this->user_model,
            'active' => $active,
            'countries' => Country_helper::getCountries(),
            'action' => 'profileUpdate',
            'businessTypes' => $this->businesstype_model->getAll(),
        ];
        $this->loadViews("profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    // function profileUpdate($active = "details")
    function profileUpdate($active = "details") {

		$this->form_validation->set_rules('username', 'Full Name', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');
        if ($_SESSION['dropoffpoint'] === '1') {
            $this->form_validation->set_rules('first_name', 'Responsible person first Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('second_name', ' Responsible person last name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('business_type_id', 'Business type id', 'required|numeric');
            $this->form_validation->set_rules('vat_number', 'Vat number', 'required|max_length[20]');
        }

        if ($this->form_validation->run()) {
            $data = $this->input->post(null, true);
            if ($data['inszNumber'] && $this->user_model->checkInszNumber($data['inszNumber'], $this->userId)) {
                $this->session->set_flashdata('error', 'Profile update failed. Register number "' . $data['inszNumber'] . '" is already in use by another user');
                redirect('address');
                exit();
            }
 
            $this->uploadPlaceImage($data);

            $geoCoordinates = (Google_helper::getLatLong($data['address'], $data['zipcode'], $data['city'], $data['country']));
			$data['lat'] = $geoCoordinates['lat'];
			$data['lng'] = $geoCoordinates['long'];
            $result = $this->user_model->editUser($data, $this->userId);
            if ($result) {
                $this->session->set_userdata('name', $data['username']);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Profile update failed');
            }
        } else {
            $this->session->set_flashdata('error', 'Profile update failed! Check your data');
        }
        redirect('address');
    }

    private function uploadPlaceImage(array &$data): void
    {
        if (!$_FILES['placeImage']['size']) return;

        $folder = $this->config->item('placeImages');
        $placeImage = $this->userId . '_' . strval(time()) . '.' . Uploadfile_helper::getFileExtension($_FILES['placeImage']['name']);	
		$_FILES['placeImage']['name'] = $placeImage;
        if (Uploadfile_helper::uploadFiles($folder)) {
            $data['placeImage'] = $placeImage;
        } else {
            $this->session->set_flashdata('error', 'Place image upload failed');
        }
    }

	function profileDropOffPointSettings($active = "details") {

//    	$this->form_validation->set_rules('username', 'Full Name', 'trim|required|max_length[128]');
//		$this->form_validation->set_rules('first_name', 'Responsible person first Name', 'trim|required|max_length[128]');
//		$this->form_validation->set_rules('second_name', ' Responsible person last name', 'trim|required|max_length[128]');
//		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
//		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');
//		$this->form_validation->set_rules('business_type_id', 'Business type id', 'required|numeric');
//		$this->form_validation->set_rules('vat_number', 'Vat number', 'required|max_length[20]');
		$this->form_validation->set_rules('itemfee', 'Item fee', 'required|max_length[20]');

		if ($this->form_validation->run()) {
			$data = $this->input->post(null, true);
//			$geoCoordinates = (Google_helper::getLatLong($data['address'], $data['zipcode'], $data['city'], $data['country']));
//			$hotel['lat'] = $geoCoordinates['lat'];
//			$hotel['lng'] = $geoCoordinates['long'];
			$data['publiclisting'] = ($this->input->post('publiclisting') == "on") ? 0 : 1;
			$result = $this->user_model->editUser($data, $this->userId);
			if ($result) {
				$this->session->set_flashdata('success', 'Profile updated successfully');
			} else {
				$this->session->set_flashdata('error', 'Profile update failed');
			}
		} else {
			$this->session->set_flashdata('error', 'Profile update failed! Check your data');
		}
		redirect('profile');
	}



    function buddyUpdate($active = "buddy") {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('lfbuddy', 'Lost + Found Buddy', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('lfbmobile', 'Mobile Number', 'required|min_length[8]');
        $this->form_validation->set_rules('lfbemail', 'Email', 'trim|required|valid_email|max_length[128]');
//        $this->form_validation->set_rules('lfaddress','Address','trim|required|valid_email|max_length[128]');
//        $this->form_validation->set_rules('lfaddressa','Address aditional','trim|required|valid_email|max_length[128]');
//        $this->form_validation->set_rules('lfzipcode','zipcode','trim|required|valid_email|max_length[128]');
//        $this->form_validation->set_rules('lfcity','city','trim|required|valid_email|max_length[128]');
//        $this->form_validation->set_rules('lfcountry','country','trim|required|valid_email|max_length[128]');

        if ($this->form_validation->run() == FALSE) {
            $this->profile($active);
        } else {
            $lfbuddy = ucwords(strtolower($this->security->xss_clean($this->input->post('lfbuddy'))));
            $lfbmobile = $this->security->xss_clean($this->security->xss_clean($this->input->post('lfbmobile')));
            $lfbemail = strtolower($this->security->xss_clean($this->input->post('lfbemail')));
            $lfaddress = ucwords(strtolower($this->security->xss_clean($this->input->post('lfaddress'))));
            $lfaddressa = ucwords(strtolower($this->security->xss_clean($this->input->post('lfaddressa'))));
            $lfzipcode = ucwords(strtolower($this->security->xss_clean($this->input->post('lfzipcode'))));
            $lfcity = ucwords(strtolower($this->security->xss_clean($this->input->post('lfcity'))));
            $lfcountry = ucwords(strtolower($this->security->xss_clean($this->input->post('lfcountry'))));

//            $password= $this->security->xss_clean($this->input->post('password'));
//            $roleId= $this->security->xss_clean($this->input->post('password'));

            $userInfo = array(
                'lfbuddy' => $lfbuddy,
                'lfbmobile' => $lfbmobile,
                'lfbemail' => $lfbemail,
                'lfaddress' => $lfaddress,
                'lfaddressa' => $lfaddressa,
                'lfzipcode' => $lfzipcode,
                'lfcity' => $lfcity,
                'lfcountry' => $lfcountry,
                'updatedBy' => $this->userId,
                'updatedDtm' => date('Y-m-d H:i:s')


//                'password'=>getHashedPassword($password),
//                'roleId'=>$roleId, 'username'=> $name,
//                'createdBy'=>$this->userId,
//                'createdDtm'=>date('Y-m-d H:i:s'),
            );

            $result = $this->user_model->editUser($userInfo, $this->userId);

            if ($result == true) {
                $this->session->set_flashdata('success', 'Profile updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Profile updation failed');
            }

            // redirect('profile/details');
            redirect('profile/' . $active);
        }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass") {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', 'Old password', 'required|max_length[20]');
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            $this->profile($active);
        } else {
            $oldPassword = $this->security->xss_clean($this->input->post('oldPassword'));
            $newPassword = $this->security->xss_clean($this->input->post('newPassword'));

            $resultPas = $this->user_model->matchOldPassword($this->userId, $oldPassword);

            if (empty($resultPas)) {
                $this->session->set_flashdata('error', 'Your old password is not correct');
                redirect('changepassword');
            } else {
                $usersData = array('password' => getHashedPassword($newPassword), 'updatedBy' => $this->userId,
                    'updatedDtm' => date('Y-m-d H:i:s'));

                $result = $this->user_model->changePassword($this->userId, $usersData);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Password updation successful');
                } else {
                    $this->session->set_flashdata('error', 'Password updation failed');
                }

                redirect('changepassword');
            }
        }
    }

    /**
     * This function is used to check whether email already exist or not
     * @param {string} $email : This is users email
     */
    function emailExists($email) {
        $userId = $this->userId;
        $return = false;

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {
            $return = true;
        } else {
            $this->form_validation->set_message('emailExists', 'The {field} already taken');
            $return = false;
        }

        return $return;
    }

    public function updateLabelIsdeleted()
    {        
        $this->isLoggedIn();
        $isDeleted = [
            'isDeleted' => $this->security->xss_clean($this->input->post('isDeleted'))
        ];
        echo $this->user_model->updateUserlabellost($isDeleted, $this->uri->segment(3), $this->userId);
    }

    public function userCalimedlisting()
    {
        $where = [
            'userclaimId' => $_SESSION['userId'],
            'isDeleted' => '0'
        ];

        $data = [
            'claimedLabels' => $this->label_model->filterLabels($where),
            'categories' => $this->category_model->getCategories(),
            'dropoffpoint' => $_SESSION['dropoffpoint'],
        ];

        $this->global['pageTitle'] = 'TIQS : Claimed';
        $this->loadViews("userCalimedlisting", $this->global, $data, NULL);
    }


}

?>
