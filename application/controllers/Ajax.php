<?php
declare(strict_types=1);

ini_set('memory_limit', '256M');

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('label_model');
        $this->load->model('user_model');
        $this->load->model('appointment_model');
        $this->load->model('uniquecode_model');
        $this->load->model('user_subscription_model');
        $this->load->model('dhl_model');
        $this->load->model('floorplanareas_model');
        $this->load->model('floorplandetails_model');
        $this->load->model('shoporder_model');
        $this->load->model('shopspot_model');
        $this->load->model('shopcategory_model');
        $this->load->model('shopspotproduct_model');
        $this->load->model('shopproductex_model');
        $this->load->model('shopvendor_model');
        $this->load->model('shopvoucher_model');

        $this->load->helper('cookie');
        $this->load->helper('validation_helper');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->helper('google_helper');
        $this->load->helper('perfex_helper');
        $this->load->helper('curl_helper');
        $this->load->helper('dhl_helper');
        $this->load->helper('validate_data_helper');

        

        $this->load->library('session');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');

        $this->load->config('custom');
    }

    public function Users(string $userMail): void
    {
        if (!$this->input->is_ajax_request()) return;
        $array = [
            'username' => !$this->user_model->isDuplicate(urldecode($userMail)),
            'email' => 'zal@wel.com'
        ];
        echo json_encode($array);
        return;
    }

	public function imageupload(): void
	{
        if (!$this->input->is_ajax_request()) return;
    
        redirect("https://tiqs.com");
        return;
    }
    
    public function uploadIdentification(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $this->form_validation->set_rules('labelCode', 'Label code', 'trim|required');
        $this->form_validation->set_rules('labelId', 'Label id', 'trim|required|numeric');

        if (!$this->form_validation->run()) {
            echo 0;
            return;
        }
        
        $data = $this->input->post(null, true);
        $result = false;
        $constraints = ['allowed_types' => "jpeg|jpg|png|tiff|pdf"];

        if ($_FILES['idfile']['name'] && File_helper::uploadFiles(FCPATH . 'uploads/', $constraints, false)) {
            $imagePath = FCPATH . 'uploads/' . $_FILES['idfile']['name'];
            $result = Identity_helper::checkIdentity($imagePath);
            unlink($imagePath);
            $identification = $data['labelCode'] . '-' . time();
            $where = ['id=' => $data['labelId']];
            echo ($result) ? $this->label_model->update(['identification' => $identification], $where) : 0;
        } else {
            echo 2;
        }
        return;
    }

    public function uploadUtilityBill(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $this->form_validation->set_rules('labelCode', 'Label code', 'trim|required');
        $this->form_validation->set_rules('labelId', 'Label id', 'trim|required|numeric');

        if (!$this->form_validation->run() || !$_FILES['ubfile']['name']) {
            echo 0;
            return;
        }

        $data = $this->input->post(null, true);
        $label = $this->label_model->getLabelInfoByCode($data['labelCode']);
        $constraints = ['allowed_types' => "jpeg|jpg|png|tiff|pdf"];
        $_FILES['ubfile']['name'] = $label->userId . "-" . $label->code . '-' . strval(time()) . '.' . File_helper::getFileExtension($_FILES['ubfile']['name']);

        if (File_helper::uploadFiles($this->label_model->uploadFolder, $constraints, false)) {
            echo $this->label_model->update(['utilitybill' => $_FILES['ubfile']['name']], ['id=' => $data['labelId']]);
        } else {
            echo 0;
        }
        return;
    }

    public function labelImageUpload(): void
    {
        if (!$this->input->is_ajax_request()) return;

        ini_set('memory_limit', '256M');
        $fileKey = array_keys($_FILES)[0];
        $databaseImage = time() . '_' . rand(10000,99999) . '.' . File_helper::getFileExtension($_FILES[$fileKey]['name']);
        $_FILES[$fileKey]['name'] = $fileKey . '-' . $databaseImage;
        $id = $this->security->xss_clean($this->input->post("id"));
        if (File_helper::uploadLabel() && $this->label_model->update(['image' => $databaseImage], ['id=' => $id])) {
            $response = [
                'image' => base_url() . 'uploads' . DIRECTORY_SEPARATOR . 'LabelImages' . DIRECTORY_SEPARATOR . $_FILES[$fileKey]['name'],
                'bigImage' => base_url() . 'uploads' . DIRECTORY_SEPARATOR . 'LabelImagesBig' . DIRECTORY_SEPARATOR . $_FILES[$fileKey]['name'],
            ];
            echo json_encode($response);
        }
        return;
    }

    public function deleteAppointment(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $id = intval($this->uri->segment(3));
        $result = $this->appointment_model->setId($id)->delete();
        echo (isset($result) && $result) ? json_encode(['status' => 1]) : json_encode(['status' => 0]);
        return;
    }

    public function labelImageUploadAndGetCode(): void
    {
        if (!$this->input->is_ajax_request()) return;

        ini_set('memory_limit', '256M');

        $this->uniquecode_model->insertAndSetCode();
        $fileKey = array_keys($_FILES)[0];
        $imageDatabaseName = time() . '_' . rand(10000,99999) . '.' . File_helper::getFileExtension($_FILES[$fileKey]['name']);
        $_FILES[$fileKey]['name'] = $this->config->item('tiqsId') . '-' . $this->uniquecode_model->code . '-' . $imageDatabaseName;
        
        if (File_helper::uploadLabel() && $this->uniquecode_model->code) {
            $response = [
                'imageDatabaseName' => $imageDatabaseName,
                'imageFullName' => $_FILES[$fileKey]['name'],
                'code' => $this->uniquecode_model->code,
            ];
            echo json_encode($response);
        }
        return;
    }

    public function sendItem(): void
    {   
        $data = $this->input->post(null, true);
        if (!isset($data['label']['code']) || !$this->label_model->doesUniquecodeExist($data['label']['code'])) {        
            echo json_encode(['success' => 0]);
            return;
        }

        $sender = $this->user_model;
        if (!$sender->isDuplicate($data['sender']['email']) && Validation_helper::validateInsertUser($data['sender'])) {
            $sender->manageAndSetUser($data['sender'])->sendActivationLink();
        }
        $senderId = $sender->id; 
        $recipient = $this->user_model;
        if (!$recipient->isDuplicate($data['recipient']['email']) && Validation_helper::validateInsertUser($data['recipient'])) {
            $recipient->manageAndSetUser($data['recipient'])->sendActivationLink();            
        }
        $recipientId = $recipient->id;

        if (!$senderId || !$recipientId) {
            echo json_encode(['success' => 0]);
            return;
        }

        $data['label']['userId'] = $senderId;
        $data['label']['userfoundId'] = $senderId;
        $data['label']['userclaimId'] = $recipientId;
        $data['label']['ipaddress'] = $this->input->ip_address();            
        $data['label']['createdDtm'] = date('Y-m-d H:i:s');
        $data['label']['lost'] = 0;
        $data['label']['label_type_id'] = $this->config->item('labelSend');

        if (isset($data['label']['image']) && isset($data['label']['imageResponseFullName'])) {
            File_helper::renameLabel($data['label']['imageResponseFullName'], $data['label']['image'], $data['label']['userId'], $data['label']['code']);
        }

        if (isset($data['label']['imageResponseFullName'])) {
            unset($data['label']['imageResponseFullName']);
        }

        if (!Validation_helper::validateInsertLabel($data['label']) || !($this->label_model->insert($data['label']))) {
            echo json_encode(['success' => 0]);
            return;
        }
        
        $url = base_url() . 'getDHLPrice' . DIRECTORY_SEPARATOR . $this->label_model->id;
        $content = '`' . file_get_contents($url) . '`';
        echo json_encode([
            'success' => 1,
            'content' => $content,
        ]);
        return;
    }

    public function updateLabel(): void
    {
        if (!$this->input->is_ajax_request()) return;
        
        $data = $this->input->post(null, true);
        $id = $data['id'];
        unset($data['id']);

        if (isset($data['lat']) && isset($data['lng']) && !isset($data['lost_item_address'])) {
            $data['lost_item_address'] = Google_helper::getAddress(floatval($data['lat']), floatval($data['lng']));
        }

        if (!isset($data['lat']) && !isset($data['lng']) && isset($data['lost_item_address'])) {
            $geoData = Google_helper::getLatLong($data['lost_item_address']);
            $data['lat'] = $geoData['lat'];
            $data['lng'] = $geoData['long'];            
        }
        
        if ($this->label_model->update($data, ['id=' => $id])) {
            echo json_encode([
                'success' => 1,
                'label' => $this->label_model->getLabelById($id)[0],
            ]);
        }
    }

    public function sendInvoice(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $data = $this->input->post(null, true);
        $success = Perfex_helper::apiInovice($data['backOffice']);
        if ($success) {
            $data['subscription']['paystatus'] = $this->config->item('paystatusPending');
            $data['subscription']['createdDtm'] = date('Y-m-d H:i:s');
            $data['subscription']['invoice_source'] = $success->inoviceSource;
            if (strpos($data['type'], 'YEAR' )) {
                $data['subscription']['expireDtm'] = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 year')); 
            } elseif (strpos($data['type'], 'MONTH' )) {
                $data['subscription']['expireDtm'] =  date('Y-m-d', strtotime(date('Y-m-d') . ' +1 month')); 
            }
            $this->user_subscription_model->insert($data['subscription']);
            echo json_encode([
                'success' => 1,
                'inoviceSource' => $success->inoviceSource,
            ]);
            return;
        }
        echo json_encode([
            'success' => 0,
        ]);
        return;
    }

    public function paySubscriptionInvoice(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $data = $this->input->post(null, true);
        var_dump($data);
    }

    public function uploadFloorPlan($objectId): void
    {
        if (!$this->input->is_ajax_request()) return;
        if (!is_dir($this->config->item('floorPlansFolder'))) {
            mkdir($this->config->item('floorPlansFolder'), 0775, TRUE);
        }
        $config = [
            'upload_path' => $this->config->item('floorPlansFolder'),
            'allowed_types' => 'jpg|png',
            'max_size' => (1024 * 8),
            'encrypt_name' => TRUE,
        ];

        $this->load->library('upload', $config);

		if (!$this->upload->do_upload('image')) {
			$status = 'error';
            $msg = $this->upload->display_errors('', '');
            echo json_encode(array('status' => $status, 'msg' => $msg));
		} else {
            $file = array('upload_data' => $this->upload->data());
			$data = array (
				'file_name' => $file['upload_data']['file_name'],
				'file_type' => $file['upload_data']['file_type'],
				'orig_name' => $file['upload_data']['orig_name'],
                'raw_name'  => $file['upload_data']['raw_name'],
                'spot_object_id' => $objectId,
            );

			if ($this->floorplandetails_model->setObjectFromArray($data)->create()) {
                $status = "success";
				$msg = "File successfully uploaded";
                $result = ['file' => $file['upload_data']['file_name'], 'floorplanID' => $this->floorplandetails_model->id];
                $this->session->set_userdata('unsaved_floorplan_id', $this->floorplandetails_model->id);
                echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $result));
			} else {
				$status = "error";
                $msg = "Error while saving to database";
                echo json_encode(array('status' => $status, 'msg' => $msg));
			}
        }
        
        return;
    }

    public function save_floor () {
        if (!$this->input->is_ajax_request()) return;

		$floorplanData = [
			'canvas' => $this->input->post('canvas'),
			'floor_name' => $this->input->post('floor_name')
		];
        $floorplanID = intval($this->input->post('floorplanID'));
        if ($this->session->userdata('unsaved_floorplan_id')) {
            $unsaved_floorplan_id = $this->session->userdata('unsaved_floorplan_id');
            if ($floorplanID == $unsaved_floorplan_id) {
                $this->session->unset_userdata('unsaved_floorplan_id');
            } else {
                $unsaved_floorplan = $this->floorplandetails_model->read(
                    ['*'],
                    ['id=' => $unsaved_floorplan_id]
                    );
                unlink($this->config->item('floorPlansFolder') . DIRECTORY_SEPARATOR . $unsaved_floorplan[0]['file_name']);
                $this->floorplandetails_model->id = $unsaved_floorplan[0]['id'];
                $this->floorplandetails_model->delete();
                $this->session->unset_userdata('unsaved_floorplan_id');
            }
        }


		// first do updated
		if ($floorplanID) {
            if ($this->floorplandetails_model->setObjectId($floorplanID)->setObjectFromArray($floorplanData)->update())
			$msg = 'Floor plan updated';
			$status = 'success';
		} else {
		    $this->floorplandetails_model->setObjectFromArray($floorplanData)->create();
            $floorplanID = $this->floorplandetails_model->id;
            // insert failed
            if (!$floorplanID) {
                $msg = "Floor plan didn't create";
                $status = 'error';
                echo json_encode(array('status' => $status, 'msg' => $msg));
                return;
            }
            $msg = 'Floor Plan Saved!';
            $status = 'success';
		}

		$areas = $this->input->post('areas_data');
		$areas_result = [];

		//Remove deleted areas
        $deleteAreasIDs = $this->input->post('deleteAreas');
        if ($deleteAreasIDs) {
            $this->floorplanareas_model->remove_floorplan_areas($floorplanID, $deleteAreasIDs);
        }

		if ($areas) {
			foreach ($areas as $area_data) {
				$area_data['floorplanID'] = $floorplanID;
				unset($area_data['status']);
				unset($area_data['opacity']);
				if (isset($area_data['id']) AND $area_data['id']) {
					$this->floorplanareas_model->setObjectFromArray($area_data)->update();
                    $floor_areaID = $this->floorplanareas_model->id;
				} else {
					$this->floorplanareas_model->setObjectFromArray($area_data)->create();
                    $floor_areaID = $this->floorplanareas_model->id;
				}

				if (!$floor_areaID) {
					$status = 'error';
					$msg .= " Error while saving area to database. Please try again";
					break;
				}

				$areas_result[] = array(
					'area_id' => $area_data['area_id'],
					'id' => $floor_areaID
				);
			}
		}

		echo json_encode(array(
			'status' => $status,
			'msg' => $msg,
			'floorplanID' => $floorplanID,
			'areas_data' => $areas_result)
		);
    }
    
    public function updateSpot($id): void
    {
        if (!$this->input->is_ajax_request()) return;
        $data = $this->input->post(null, true);
        $result = $this
                    ->floorplanareas_model
                    ->setObjectId(intval($id))
                    ->setObject($data['spot'])
                    ->setObjectFromArray($data['spot'])
                    ->update();
        echo intval($result);
    }

    public function fetchOrders():void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->input->post(null, true);
        $userId = intval($_SESSION['userId']);

        $where = [
            'vendor.id' => $userId,
            'tbl_shop_orders.paid=' => $post['paid'],
            'tbl_shop_orders.created>=' => date('Y-m-d H:i:s', strtotime('-1 hours', time()))
        ];
//        if (isset($post['orderStatus'])) {
//            $where['tbl_shop_orders.orderStatus='] = $post['orderStatus'];
//        } else {
//            $where['tbl_shop_orders.orderStatus!='] = $this->config->item('orderFinished');
//        }
        $selectedPrinter = (isset($post['selectedPrinter'])) ? $post['selectedPrinter'] : '';


        $result = $this->shoporder_model->fetchOrderDetailsJquery($where, $selectedPrinter);
        echo is_null($result) ? json_encode([]): json_encode($result);

        return;
    }

    public function updateOrder(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $data = $this->input->post(null, true);
        $orderId = intval($this->uri->segment(3));
        $update =    $this
                        ->shoporder_model
                        ->setObjectId($orderId)
                        ->setObjectFromArray($data)
                        ->update();
        echo $update ? 1 : 0;
        return;
    }

    public function sendSms(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $smsData = $this->input->post(null, true);
        $orderId = intval($this->uri->segment(3));
        $url = 'https://tiqs.com/lostandfound/Api/Missing/sendsms';

        if (Curl_helper::sendSms($url, $smsData)) {
            $updateData = [
                'orderStatus' => 'finished',
                'sendSms' => '1'
            ];
            $update =    $this
                            ->shoporder_model
                            ->setObjectId($orderId)
                            ->setObjectFromArray($updateData)
                            ->update();
            echo $update ? $this->shoporder_model->updateSmsCounter() : 0;
        } else {
            echo 0;
        }
        return;
    }

    public function updateUser(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $userId = intval($this->uri->segment(3));
        $userInfo = $this->input->post(null, true);

        echo $this->user_model->editUser($userInfo, $userId) ? 1 : 0;
        return;
    }

    public function ajaxUpdateSession(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $post = $this->input->post(null, true);

        if (isset($_SESSION['order']) && $post) {
            $id = $post['productExId'];
            if (isset($post['newPrice']) && isset($post['newQuantityValue'])) {

                if(isset($post['mainExtendedId'])) {
                    $_SESSION['order'][$id]['mainProduct'][$post['mainExtendedId']]['amount'][0] = $post['newPrice'];
                    $_SESSION['order'][$id]['mainProduct'][$post['mainExtendedId']]['quantity'][0] = $post['newQuantityValue']; 
                } else {
                    $_SESSION['order'][$id]['amount'][0] = $post['newPrice'];
                    $_SESSION['order'][$id]['quantity'][0] = $post['newQuantityValue'];    
                }
                
            } else {
                unset($_SESSION['order'][$id]);
                if (!count($_SESSION['order'])) {
                    unset($_SESSION['order']);
                }
            }
        }
        echo 1;
        return;
    }

    // public function checkSpotId(): void
    // {
    //     if (!$this->input->is_ajax_request()) return;

    //     $post = $this->input->post(null, true);
    //     $where = [
    //         'tbl_shop_printers.userId=' => $post['vendorId'],
    //         'tbl_shop_spots.active' => '1',
    //         'tbl_shop_spots.spotName' =>  $post['spotName'],
    //     ];

    //     $spot = $this->shopspot_model->fetchUserSpotsImporved($where);
    //     if ($spot) {
    //         $id = $spot[0]['spotId'];
    //         $result = [
    //             'url' => 'make_order?vendorid=' . $post['vendorId'] . '&spotid=' . $id
    //         ];
    //         echo json_encode($result);
    //     } else {
    //         echo 0;
    //     }
    // }

    public function updateCategoriesOrder(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->input->post(null, true);
        foreach ($post as $categoryId => $sortNumber) {
            $sort = $this
                    ->shopcategory_model
                        ->setObjectId($categoryId)
                        ->setObjectFromArray(['sortNumber' => $sortNumber])
                        ->update();
            if (!$sort) {
                return;
            }
        }
        echo 1;
        return;
    }

    public function updateProductSpotStatus($id): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->input->post(null, true);
        
        $update = $this
                    ->shopspotproduct_model
                        ->setObjectId(intval($id))
                        ->setObjectFromArray($post)
                        ->update();

        echo $update ? 1 : 0;
    }

    public function getAddonsList(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $addons  = $this->shopproductex_model->getProdctesByMainType(intval($_SESSION['userId']));
        $addonsList = '';
        if (!empty($addons)) {
            foreach ($addons as $productId => $product) {
                $product = reset($product);
                foreach($product['productDetails'] as $details) {
                    $addonsList .=  '<div>';
                    $addonsList .=      '<label class="checkbox-inline">';
                    $addonsList .=          $details['name'] . ' (' . $details['productType']. '):&nbsp;&nbsp;';
                    $addonsList .=          '<input ';
                    $addonsList .=              'type="checkbox" ';
                    $addonsList .=              'data-extended-id="' . $details['productExtendedId'] . '" ';
                    $addonsList .=              'value="' . $productId . '" ';
                    $addonsList .=              'name="productAddons[' . $details['productExtendedId'] . ']" ';
                    $addonsList .=              '/>&nbsp;&nbsp;';
                    $addonsList .=      '</label>';
                    $addonsList .=      '<label class="checkbox-inline">';
                    $addonsList .=          'Quantity:&nbsp;&nbsp;';
                    $addonsList .=          '<input ';
                    $addonsList .=              'style="width:45px" ';
                    $addonsList .=              'type="number" ';
                    $addonsList .=              'name="productQuantities[' . $details['productExtendedId'] . ']" ';
                    $addonsList .=              '/>';
                    $addonsList .=      '</label>';
                    $addonsList .=  '</div>';
                }
            }
        }

        echo str_replace('\'', ' ', $addonsList);
    }

    public function runMigration(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $password = $this->input->post('password', true);
        if ($this->user_model->checkIsAdmin($this->config->item('petersEmail'), $password)) {
            $this->load->library('migration');
            if ($this->migration->current() === FALSE) {
                echo 'Migration failed';
            } else {
                echo 'success';
            }
        } else {
            echo 'Invalid password';
        }
    }

    public function setOrderSession(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $post = $this->input->post(null, true);

        if (!empty($post['data'])) {
            $_SESSION['order'] = [];
            $string = 'qwertzuioplkjhgfdsamnbvcxy';
            $count = 0;
            foreach($post['data'] as $data) {
                $count++;
                $shuffled = strval($count) . '_' . str_shuffle($string);
                $_SESSION['order'][$shuffled] = $data;
            }
        }

        echo !empty($_SESSION['order']) ? '1' : '0';
        return;
    }

    public function unsetSessionOrderElement(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->input->post(null, true);
        $indexId = $post['orderSessionIndex'];

        if (!empty($post['addonExtendedId']) && !empty($post['productExtendedId'])) {
            $addonextenedId = $post['addonExtendedId'];
            $productExtendedId = $post['productExtendedId'];
            unset($_SESSION['order'][$indexId][$productExtendedId]['addons'][$addonextenedId]);
            echo '1';
            return;
        }

        if (!empty($_SESSION['order'][$indexId])) {
            unset($_SESSION['order'][$indexId]);
            echo '1';
            return;
        }

        echo '0';
        return;
    }

    public function updateSessionOrderAddon(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->input->post(null, true);

        $indexId = $post['orderSessionIndex'];
        $addonextenedId = $post['addonExtendedId'];
        $productExtendedId = $post['productExtendedId'];
        unset($post['orderSessionIndex']);
        unset($post['addonExtendedId']);
        unset($post['productExtendedId']);

        foreach($post as $key => $value) {
            $_SESSION['order'][$indexId][$productExtendedId]['addons'][$addonextenedId][$key] = $value;
        }

        // UPDATE ONLY IF MAIN PRODUCT IS CHANGED
        if (isset($post['mainProductQuantity']) && intval($post['mainProductQuantity'])) {
            $newStep = intval($post['mainProductQuantity']);
            $newMinQuantity = $newStep * $_SESSION['order'][$indexId][$productExtendedId]['addons'][$addonextenedId]['initialMinQuantity'];
            $newMaxQuantity = $newStep * $_SESSION['order'][$indexId][$productExtendedId]['addons'][$addonextenedId]['initialMaxQuantity'];
            $_SESSION['order'][$indexId][$productExtendedId]['addons'][$addonextenedId]['step'] = $newStep;
            $_SESSION['order'][$indexId][$productExtendedId]['addons'][$addonextenedId]['minQuantity'] = $newMinQuantity;
            $_SESSION['order'][$indexId][$productExtendedId]['addons'][$addonextenedId]['maxQuantity'] = $newMaxQuantity;
        }


        return;
    }

    public function updateSessionOrderMainProduct(): void
    {
        if (!$this->input->is_ajax_request()) return;
        

        $post = $this->input->post(null, true);
        $indexId = $post['orderSessionIndex'];
        $productExtendedId = $post['productExtendedId'];

        unset($post['orderSessionIndex']);
        unset($post['productExtendedId']);

        foreach($post as $key => $value) {
            $_SESSION['order'][$indexId][$productExtendedId][$key] = $value;
        }

        return;
    }

    public function updateVendor($venodrId): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->input->post(null, true);        
        $update = $this
                    ->shopvendor_model
                    ->setObjectId(intval($venodrId))
                    ->setObjectFromArray($post)
                    ->update();

        echo $update ? '1' : '0';

        return;
    }

    public function checkUserNewsLetter(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $email = $this->input->post('email', true);
        $this->user_model->setUniqueValue($email)->setWhereCondtition()->setUser();
        echo $this->user_model->newsletter;

        return;
    }

	public function saveEmailTemplate  () {
		if (!$this->input->is_ajax_request()) return;
		var_dump($this->input->post('html'));
	}

	public function saveEmailTemplateSource () {
		if (!$this->input->is_ajax_request()) return;

		$user_id = $this->input->post('user_id');
		$html = $this->input->post('html');

		$dir = FCPATH.'assets/email_templates/'.$user_id;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}

		$clear_name = mb_strtolower(preg_replace('/[^ a-z\d]/ui', '', $this->input->post('template_name')));
		$filename = $clear_name.time().'.html';
		$filepath = $dir.'/'.$filename;

		$template_id = $this->input->post('template_id');

		if ($template_id && $template_id != 'false') {
			$email_template = $this->email_templates_model->get_emails_by_id($template_id);
			$filename = $email_template->template_file;
		}

		$data = [
			'user_id' => $user_id,
			'template_file' => $filename,
			'template_name' => $this->input->post('template_name')
		];

		if (!write_file($filepath, $html) )
		{
			$msg = 'Unable to write the file';
			$status = 'error';
		}
		else
		{
			if ($template_id && $template_id != 'false') {
				$result = $this->email_templates_model->update_email_template($data, $template_id);
			} else {
				$result = $this->email_templates_model->add_email_template($data);
			}
			if ($result) {
				$msg = 'Email saved';
				$status = 'success';
			} else {
				$msg = 'Email not saved in db';
				$status = 'error';
			}

		}

		echo json_encode(array('msg' => $msg, 'status' =>$status));
	}

	public function getEmailImages () {
		if (!$this->input->is_ajax_request()) return;

		$dir = FCPATH.'assets/user_images/'.$this->input->post('user_id');
		$images = get_filenames($dir);
		echo json_encode(array('images' => $images));
	}

	public function uploadUserImage () {
		if (!$this->input->is_ajax_request()) return;

		$dir = FCPATH.'assets/user_images/'.$this->input->post('user_id');
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		$config['upload_path']          = $dir;
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 1024 * 5;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('nomefile'))
		{
			$msg = $this->upload->display_errors();
			$status = 'error';
		}
		else
		{
			$msg = 'File uploaded';
			$status = 'success';
		}
		echo json_encode(array('msg' => $msg, 'status' =>$status));
	}

	public function delete_email_template () {
		$email_id = $this->input->post('email_id');

		if ($this->email_templates_model->deleteEmail($email_id)) {
			$msg = 'Email template deleted!';
			$status = 'success';
		} else {
			$msg = 'Something goes wrong!';
			$status = 'error';
		}
		echo json_encode(array('msg' => $msg, 'status' =>$status));
    }

    public function voucherPay(): void
    {
        if (!$this->input->is_ajax_request()) return;

        if (get_cookie('codeBlocked')) {
            unset($_SESSION['failed']);
            echo json_encode([
                'status' => '0',
                'message' => 'Invalid code inserted three times. You can not use code for next 2 minutes'
            ]);
            return;
        }

        $code = $this->input->post('code', true);
        $amount = floatval($this->input->post('amount', true));

        $this
            ->shopvoucher_model
                ->setProperty('code', $code)
                ->setVoucher();


        if (is_null($this->shopvoucher_model->id)) {

            if (!isset($_SESSION['failed'])) {
                $_SESSION['failed'] = 0;
            }
            $_SESSION['failed']++;
            if ($_SESSION['failed'] === 3) {
                set_cookie('codeBlocked', '1', 120);
                echo json_encode([
                    'status' => '0',
                    'message' => 'Invalid code inserted three times. You can not use code for next 2 minutes'
                ]);
                return;
            }

            echo json_encode([
                'status' => '0',
                'message' => 'Invalid code'
            ]);
            return;
        }

        if (isset($_SESSION['failed'])) {
            unset($_SESSION['failed']);
        }

        if ($this->shopvoucher_model->expire < date('Y-m-d')) {
            echo json_encode([
                'status' => '0',
                'message' => 'Voucher expired'
            ]);
            return;
        };

        if ($this->shopvoucher_model->active === '0') {
            echo json_encode([
                'status' => '0',
                'message' => 'The voucher has already been used'
            ]);
            return;
        }

        if ($this->shopvoucher_model->productId) {
            if ($_SESSION['vendor']['preferredView'] === $this->config->item('oldMakeOrderView')) {
                // OLD MAKE ORDER VIEW
                foreach ($_SESSION['order'] as $key => $productRaw) {
                    if (isset($productRaw['mainProduct'])) {
                        $product = $productRaw['mainProduct'][$mainKey];
                    } else {
                        $mainKey = $key;
                        $product = $productRaw;
                    }
                    if (intval($product['productId'][0]) === $this->shopvoucher_model->productId) {
                        $productPrice = floatval($product['price'][0]);
                        $_SESSION['payWithVaucher'] = $productPrice + $productPrice * $_SESSION['vendor']['serviceFeePercent'] / 100;
                        $_SESSION['payWithVaucher'] = round($_SESSION['payWithVaucher'], 2);
                        break;
                    }
                }
            } else {
                // NEW MAKE ORDER VIEW
                foreach ($_SESSION['order'] as $key => $productRaw) {
                    $productRaw = reset($productRaw);
                    if (intval($productRaw['productId']) === $this->shopvoucher_model->productId) {
                        $productPrice = floatval($productRaw['price']);
                        $_SESSION['payWithVaucher'] = $productPrice + $productPrice * $_SESSION['vendor']['serviceFeePercent'] / 100;
                        $_SESSION['payWithVaucher'] = round($_SESSION['payWithVaucher'], 2);
                        break;
                    }
                    if (isset($productRaw['addons'])) {
                        $addons = $productRaw['addons'];
                        foreach ($addons as $prodcutExtendedId => $details) {
                            if (intval($details['addonProductId']) === $this->shopvoucher_model->productId) {
                                $productPrice = floatval($details['price']);
                                $_SESSION['payWithVaucher'] = $productPrice + $productPrice * $_SESSION['vendor']['serviceFeePercent'] / 100;
                                $_SESSION['payWithVaucher'] = round($_SESSION['payWithVaucher'], 2);
                                break;
                            }
                        }
                    }
                }
            }

            if (!isset($_SESSION['payWithVaucher'])) {
                echo json_encode([
                    'status' => '0',
                    'message' => 'Product from voucher is not in order list'
                ]);
            } else {
                if (
                    ($this->shopvoucher_model->amount >= $_SESSION['payWithVaucher'] || $this->shopvoucher_model->percent === 100)
                    && $_SESSION['payWithVaucher'] === $amount
                ) {
                    $redirect = base_url() . 'voucherPayment' . DIRECTORY_SEPARATOR . $this->shopvoucher_model->id;
                    echo json_encode([
                        'status' => '1',
                        'redirect' => $redirect
                    ]);
                } else {
                    $_SESSION['voucherId'] = $this->shopvoucher_model->id;

                    if ($this->shopvoucher_model->amount) {
                        $voucherDiscount = ($_SESSION['payWithVaucher'] > $this->shopvoucher_model->amount) ? $this->shopvoucher_model->amount : $_SESSION['payWithVaucher'];
                    } else {
                        $voucherDiscount = $this->shopvoucher_model->percent * $_SESSION['payWithVaucher'] / 100;
                    }
                    $leftAmount = $amount - $voucherDiscount;

                    echo json_encode([
                        'status' => '2',
                        'message' => 'Select method to finish payment',
                        'voucherAmount' => number_format($voucherDiscount, 2, ',', '.'),
                        'leftAmount' => number_format($leftAmount, 2, ',', '.'),
                    ]);
                }
            }
            return;
        }

        if ($this->shopvoucher_model->amount >= $amount || $this->shopvoucher_model->percent === 100) {
            $redirect = base_url() . 'voucherPayment' . DIRECTORY_SEPARATOR . $this->shopvoucher_model->id;
            echo json_encode([
                'status' => '1',
                'redirect' => $redirect
            ]);
            return;
        };

        $_SESSION['voucherId'] = $this->shopvoucher_model->id;

        if ($this->shopvoucher_model->amount) {
            $voucherDiscount = $this->shopvoucher_model->amount;
        } else {
            $voucherDiscount = $this->shopvoucher_model->percent * $amount / 100;
        }
        $leftAmount = $amount - $voucherDiscount;

        echo json_encode([
            'status' => '2',
            'message' => 'Select method to finish payment',
            'voucherAmount' => number_format($voucherDiscount, 2, ',', '.'),
            'leftAmount' => number_format($leftAmount, 2, ',', '.'),
        ]);

        return;
    }
}
