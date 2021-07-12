<?php
declare(strict_types=1);

ini_set('memory_limit', '256M');

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    private $errorMessages = [];

    public function __construct()
    {
        parent::__construct();

        $this->load->model('label_model');
        $this->load->model('user_model');
        $this->load->model('appointment_model');
        $this->load->model('uniquecode_model');
        $this->load->model('user_subscription_model');
        $this->load->model('dhl_model');
        $this->load->model('Bizdir_model');
        $this->load->model('floorplanareas_model');
        $this->load->model('floorplandetails_model');
        $this->load->model('shoporder_model');
        $this->load->model('shopspot_model');
        $this->load->model('shopcategory_model');
        $this->load->model('shopspotproduct_model');
        $this->load->model('shopproductex_model');
        $this->load->model('shopvendor_model');
        $this->load->model('shopvoucher_model');
        $this->load->model('shopsession_model');
        $this->load->model('shopposorder_model');
        $this->load->model('shopvendortemplate_model');
        $this->load->model('shopreportrequest_model');
        $this->load->model('shopprinterrequest_model');
        $this->load->model('api_model');
        $this->load->model('employee_model');
        $this->load->model('shopposlogin_model');
        $this->load->model('shoptemplates_model');
        $this->load->model('shoppaymentmethods_model');
        $this->load->model('shoporderpaynl_model');
        $this->load->model('shoplandingpages_model');
        $this->load->model('shopprinters_model');
        $this->load->model('shopproducttime_model');
        $this->load->model('shopproduct_model');
        $this->load->model('shopreport_model');
        $this->load->model('shopreportemail_model');
        $this->load->model('bookandpay_model');
        $this->load->model('floorplan_model');
        $this->load->model('shopprodutctype_model');

        $this->load->helper('cookie');
        $this->load->helper('validation_helper');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->helper('google_helper');
        $this->load->helper('perfex_helper');
        $this->load->helper('curl_helper');
        $this->load->helper('dhl_helper');
        $this->load->helper('validate_data_helper');
        $this->load->helper('uploadfile_helper');
        $this->load->helper('jwt_helper');
        $this->load->helper('pay_helper');
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

    private function uploadFloorplanImage(): bool
    {
        $config = [
            'upload_path' => $this->config->item('floorPlansFolder'),
            'allowed_types' => 'jpg|png',
            'max_size' => (1024 * 8),
            'encrypt_name' => TRUE,
        ];

        $this->load->library('upload', $config);

        return $this->upload->do_upload('image');
    }

    public function uploadFloorPlan(): void
    {
        if (!$this->input->is_ajax_request()) return;

		if (!$this->uploadFloorplanImage()) {
            $response = [
                'status' => '0',
                'messages' => [$this->upload->display_errors('', '')]
            ];
		} else {
            $file = array('upload_data' => $this->upload->data());
            $response = [
                'status' => '1',
                'messages' => ['File successfully uploaded'],
                'result' => [
                    'file' => $file['upload_data']['file_name']
                ]
            ];
        }

        echo json_encode($response);

        return;
    }

    public function save_floor ($floorPlanId = null): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->security->xss_clean($_POST);

        $floorplan = $post['floorplan'];
        $floorplan['vendorId'] = $_SESSION['userId'];
        $areas = empty($post['areas']) ? null : $post['areas'];
        $areas_result = [];
        $floorPlanId =  intval($floorPlanId);

        if (!$this->manageFloorplan($floorplan, intval($floorPlanId))) return;
        if (!$this->insertFloorplanAreas($areas, $this->floorplan_model->id, $areas_result)) return;

        $response = [
            'status' => '1',
			'messages' => ['Success'],
			'floorplanID' => $this->floorplan_model->id,
			'areas_data' => $areas_result
        ];

        // if create floorplan, js redirects user to edit floorplan view
        // message for user is set in session
        if (!$floorPlanId) {
            $this->session->set_flashdata('success', 'Floorplan created');
        }

		echo json_encode($response);
    }
    
    private function manageFloorplan(array $floorplan, int $floorPlanId): bool
    {
        if ($floorPlanId) {
            if (!$this->floorplan_model->setObjectId($floorPlanId)->updateFloorplan($floorplan)) {
                $response = [
                    'status' => '0',
                    'messages' => ['Floorplan did not update']
                ];
                echo json_encode($response);
                return false;
            };
		} else {
		    if (!$this->floorplan_model->setObjectFromArray($floorplan)->create()) {
                $response = [
                    'status' => '0',
                    'messages' => ['Floorplan did not create']
                ];
                echo json_encode($response);
                return false;
            }
        }

        return true;
    }

    private function insertFloorplanAreas(?array $areas, int $floorplanId, array &$areas_result): bool
    {
		if ($areas) {
            $this->floorplanareas_model->setProperty('floorplanID', $floorplanId)->deleteFloorplanAreas();
            
			foreach ($areas as $area_data) {
                unset($area_data['status']);
				unset($area_data['opacity']);
                $area_data['floorplanID'] = $floorplanId;

				if (!$this->floorplanareas_model->setObjectFromArray($area_data)->create()) {
                    $response =  [
                        'status' => '0',
                        'messages' => ['Error while saving area to database. Please try again'],
                    ];
                    $this->floorplanareas_model->setProperty('floorplanID', $floorplanId)->deleteFloorplanAreas();
                    $this->floorplan_model->delete();
                    echo json_encode($response);
					return false;
				}

				$areas_result[] = array(
					'area_id' => $area_data['area_id'],
					'id' => $this->floorplanareas_model->id
				);
			}
		}

        return true;
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
            'tbl_shop_orders.created>=' => date('Y-m-d H:i:s', strtotime('-48 hours', time()))
        ];
        // if (isset($post['orderStatus'])) {
        //     $where['tbl_shop_orders.orderStatus='] = $post['orderStatus'];
        // } else {
        //     $where['tbl_shop_orders.orderStatus!='] = $this->config->item('orderFinished');
        // }
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
        #if (!$this->input->is_ajax_request()) return;

        $addons  = $this->shopproductex_model->getProdctesByMainType(intval($_SESSION['userId']));
        $addonsList = '';
        if (!empty($addons)) {
            foreach ($addons as $productId => $product) {
                $product = reset($product);
                foreach($product['productDetails'] as $details) {                    
                    $productUpdateCycle = intval($details['productUpdateCycle']);
                    $chekIsLast = $this
                                    ->shopproductex_model
                                        ->setProperty('productId', $productId)
                                        ->isLastUpdate($productUpdateCycle);
                    if (!$chekIsLast) continue;
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

        $post = Utility_helper::sanitizePost();
        $response = [];
        

        if ($this->prepareOrderData($post)) {
            $this->insertSession($post, $response);
            $this->savePosOrder($post, $response);
        } else {
            $response['status'] = '0';
        }

        echo json_encode($response);
    }

    

    private function prepareOrderData(array &$post): bool
    {
        if (empty($post['data'])) return false;

        $post['makeOrder'] = [];
        $string = 'qwertzuioplkjhgfdsamnbvcxy';
        $count = 0;
        foreach($post['data'] as $data) {
            if (!$this->checkRemarkLength($data)) return false;
            $count++;
            $shuffled = strval($count) . '_' . str_shuffle($string);
            $post['makeOrder'][$shuffled] = $data;
        };
        unset($post['data']);
        return true;
    }

    private function insertSession(array $post, array &$response): void
    {
        $orderDataRandomKey = trim(Utility_helper::getAndUnsetValue($post, 'orderDataRandomKey'));
        if ($orderDataRandomKey) {
            $this
                ->shopsession_model
                    ->setProperty('randomKey', $orderDataRandomKey)
                    ->updateSessionData($post);
        } else {
            $this->shopsession_model->insertSessionData($post);
        }

        if ($this->shopsession_model->id && $this->shopsession_model->randomKey) {
            $response['orderRandomKey'] = $this->shopsession_model->randomKey;
            $response['status'] = '1';
        } else {
            $response['status'] = '0';
        }
    }

    private function savePosOrder(array $post, array &$response): void
    {
        if ($post['pos'] === '1' && !empty($post['posOrder']) && $response['status'] !== '0') {
            // save pos order
            $post['posOrder']['sessionId'] = $this->shopsession_model->id;
            $shortName = $post['posOrder']['saveName'];
            $post['posOrder']['saveName'] = $post['posOrder']['saveName'];
            $managePosOrder = $this->shopposorder_model->setObjectFromArray($post['posOrder'])->managePosOrder();
            if (!$managePosOrder) {
                $response['status'] = '0';
            }

            $response['posOrderId'] = $this->shopposorder_model->id;
            $response['orderName'] = $post['posOrder']['saveName'];
            $response['lastChange'] = date('Y-m-d H:i:s');
        }

        return;
    }

    private function checkRemarkLength(array $data): bool
    {
        foreach($data as $key => $value)  {
            if (isset($value['remark']) && strlen($value['remark']) > $this->config->item('maxRemarkLength')) {
                return false;
            }
            if (!empty($value['addons']) && !$this->checkRemarkLength($value['addons'])) return false;
        }
        return true;
    }

    public function unsetSessionOrderElement(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $orderSessionIndex = Utility_helper::getAndUnsetValue($post, 'orderSessionIndex');
        $orderRandomKey = Utility_helper::getAndUnsetValue($post, 'orderRandomKey');
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        if (empty($orderData)) return;

        if (!empty($post['addonExtendedId']) && !empty($post['productExtendedId'])) {
            $addonExtendedId = Utility_helper::getAndUnsetValue($post, 'addonExtendedId');
            $productExtendedId = Utility_helper::getAndUnsetValue($post, 'productExtendedId');
            unset($orderData['makeOrder'][$orderSessionIndex][$productExtendedId]['addons'][$addonExtendedId]);
            $this->shopsession_model->updateSessionData($orderData);
            echo ($this->shopsession_model->id && $this->shopsession_model->randomKey) ? '1' : '0';
            return;
        }

        if (!empty($orderData['makeOrder'][$orderSessionIndex])) {
            unset($orderData['makeOrder'][$orderSessionIndex]);
            $this->shopsession_model->updateSessionData($orderData);
            echo ($this->shopsession_model->id && $this->shopsession_model->randomKey) ? '1' : '0';
            return;
        }

        echo '0';
        return;
    }

    public function updateSessionOrderAddon(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $indexId = Utility_helper::getAndUnsetValue($post, 'orderSessionIndex');
        $addonExtendedId = Utility_helper::getAndUnsetValue($post, 'addonExtendedId');
        $productExtendedId = Utility_helper::getAndUnsetValue($post, 'productExtendedId');
        $orderRandomKey = Utility_helper::getAndUnsetValue($post, 'orderRandomKey');
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        if (empty($orderData)) return;

        foreach($post as $key => $value) {
            $orderData['makeOrder'][$indexId][$productExtendedId]['addons'][$addonExtendedId][$key] = $value;
        }

        // UPDATE ONLY IF MAIN PRODUCT IS CHANGED
        if (isset($post['mainProductQuantity']) && intval($post['mainProductQuantity'])) {
            $newStep = intval($post['mainProductQuantity']);
            $newMinQuantity = $newStep * $orderData['makeOrder'][$indexId][$productExtendedId]['addons'][$addonExtendedId]['initialMin'];
            $newMaxQuantity = $newStep * $orderData['makeOrder'][$indexId][$productExtendedId]['addons'][$addonExtendedId]['initialMax'];

            $orderData['makeOrder'][$indexId][$productExtendedId]['addons'][$addonExtendedId]['step'] = $newStep;
            $orderData['makeOrder'][$indexId][$productExtendedId]['addons'][$addonExtendedId]['minQuantity'] = $newMinQuantity;
            $orderData['makeOrder'][$indexId][$productExtendedId]['addons'][$addonExtendedId]['maxQuantity'] = $newMaxQuantity;
        }

        $this->shopsession_model->updateSessionData($orderData);

        return;
    }

    public function updateSessionOrderMainProduct(): void
    {
        if (!$this->input->is_ajax_request()) return;
        
        $post = Utility_helper::sanitizePost();
        $orderSessionIndex = Utility_helper::getAndUnsetValue($post, 'orderSessionIndex');
        $productExtendedId = Utility_helper::getAndUnsetValue($post, 'productExtendedId');
        $orderRandomKey = Utility_helper::getAndUnsetValue($post, 'orderRandomKey');
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        if (empty($orderData)) return;

        foreach($post as $key => $value) {
            $orderData['makeOrder'][$orderSessionIndex][$productExtendedId][$key] = $value;
        }

        $this->shopsession_model->updateSessionData($orderData);
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
        echo is_null($this->user_model->id) ? '0' : $this->user_model->newsletter;

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

    private function isBlocked(array $orderData): bool
    {
        if (get_cookie('codeBlocked')) {
            if (isset($orderData['failed'])) {
                unset($orderData['failed']);
                $this->shopsession_model->updateSessionData($orderData);
            }
            echo json_encode([
                'status' => '0',
                'message' => 'Invalid code inserted three times. You can not use code for next 2 minutes'
            ]);
            return false;
        }
        return true;
    }

    private function checkIsVoucherExist(array $orderData, object $voucher, object $shopsession): bool
    {
        if (is_null($voucher->id)) {

            if (!isset($orderData['failed'])) {
                $orderData['failed'] = 0;
            }
            $orderData['failed']++;
            $shopsession->updateSessionData($orderData);

            if ($orderData['failed'] === 3) {
                set_cookie('codeBlocked', '1', 120);
                echo json_encode([
                    'status' => '0',
                    'message' => 'Invalid code inserted three times. You can not use code for next 2 minutes'
                ]);
                return false;
            }

            echo json_encode([
                'status' => '0',
                'message' => 'Invalid code'
            ]);
            return false;
        }

        unset($orderData['failed']);
        $this->shopsession_model->updateSessionData($orderData);

        return true;
    }

    private function checkVoucher(array $orderData, object $voucher): bool
    {
        $message = '';

        if (intval($voucher->vendorId) !== $orderData['vendorId']) {
            $message = 'Vendor did not create this voucher';
        }

        if (!$message && !$voucher->checkIsValid()) {
            $message = 'Problem with voucher';
            if ($voucher->expire < date('Y-m-d')) {
                $message = 'Voucher expired';
            } elseif ($voucher->active === '0' || $voucher->percentUsed === '1') {
                $message = 'The voucher has already been used';
            } elseif ($voucher->amount <= 0 && $voucher->percent === 0) {
                $message = 'No funds on the voucher';
            }
        }

        if (!$message && $voucher->productId) {
            foreach($orderData['orderExtended'] as $key => $value) {
                $this->shopproductex_model->setObjectId(array_keys($value)[0])->setObject(['productId', 'price']);
                if ($this->shopproductex_model->productId === $voucher->productId) return true;
            }
            $message = 'Voucher product is not in ordered list';
        }

        if ($message) {
            echo json_encode([
                'status' => '0',
                'message' => $message,
            ]);
            return false;
        }

        return true;
    }

    public function voucherPay(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $code = $this->input->post('code', true);
        $orderRandomKey = $this->input->post($this->config->item('orderDataGetKey'), true);
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        if (empty($orderData)) return;


        $this->shopvoucher_model->setProperty('code', $code)->setVoucher();

        $this->shopvoucher_model->rollBackVoucher($this->shoporder_model);

        if (
            !$this->isBlocked($orderData)
            || !$this->checkIsVoucherExist($orderData, $this->shopvoucher_model, $this->shopsession_model)
            || !$this->checkVoucher($orderData, $this->shopvoucher_model)
        ) return;

        $totalAmount = $this->calculateTotalAmount($orderData['order']);

        $this->calculateVoucherDicsount($orderData, $this->shopvoucher_model, $totalAmount);
        $this->voucherOrderResponse($totalAmount, $orderData, $orderRandomKey);

        return;
    }

    public function posVoucherPay(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $orderData = $this->security->xss_clean($_POST);
        $orderData['vendorId'] = intval($_SESSION['userId']);
        $code = $orderData['code'];

        $this->shopvoucher_model->setProperty('code', $code)->setVoucher();

        if (is_null($this->shopvoucher_model->id)) {
            echo json_encode([
                'status' => '0',
                'messages' => ['Invalid code']
            ]);
            return;
        }

        if (!$this->checkVoucher($orderData, $this->shopvoucher_model)) return;

        $totalAmount = $this->calculateTotalAmount($orderData['order']);

        $this->calculateOrderVoucherAmount($orderData, $this->shopvoucher_model, $totalAmount);
        $this->voucherOrderResponse($totalAmount, $orderData);
        return;
    }

    private function calculateTotalAmount(array $order): float
    {
        $amount = round(floatval($order['amount']), 2);
        $waiterTip = round(floatval($order['waiterTip']), 2);
        $serviceFee = round(floatval($order['serviceFee']), 2);
        return ($amount + $waiterTip + $serviceFee);
    }

    private function calculateVoucherDicsount(array &$orderData, object $shopVoucher, float $totalAmount): void
    {
        $this->calculateOrderVoucherAmount($orderData, $shopVoucher, $totalAmount);
        $this->shopsession_model->updateSessionData($orderData);
        return;
    }

    private function calculateOrderVoucherAmount(array &$orderData, object $shopVoucher, float $totalAmount): void
    {
        if ($shopVoucher->productId) {
            // price is set in checkVoucher method
            $productPrice = $this->shopproductex_model->price;
            if ($shopVoucher->percent) {
                $voucherAmount = $productPrice * $shopVoucher->percent / 100;
            } else {
                $voucherAmount = ($shopVoucher->amount >= $productPrice) ? $productPrice : $shopVoucher->amount;
            }
        } else {
            if ($shopVoucher->percent) {
                $voucherAmount = ($shopVoucher->percent === 100) ? ($amount + $serviceFee) : $amount * $shopVoucher->percent / 100;
            } else {
                $voucherAmount = ($shopVoucher->amount >= $totalAmount) ? $totalAmount : $shopVoucher->amount;
            }
        }
        $orderData['order']['voucherAmount'] = round($voucherAmount, 2);
        $orderData['order']['voucherId'] = $this->shopvoucher_model->id;
        return;
    }

    private function voucherOrderResponse(float $totalAmount, array $orderData, string $orderRandomKey = ''): void
    {
        if ($totalAmount > $orderData['order']['voucherAmount']) {
            $voucherDiscount = $orderData['order']['voucherAmount'];
            $leftAmount =  $totalAmount - $orderData['order']['voucherAmount'];
            echo json_encode([
                'status' => '2',
                'message' => 'Select method to finish payment',
                'voucherAmount' => number_format($voucherDiscount, 2, ',', '.'),
                'leftAmount' => number_format($leftAmount, 2, ',', '.')
            ]);
        } else {
            $redirect = base_url() . 'voucherPayment?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
            echo json_encode([
                'status' => '1',
                'redirect' => $redirect,
                'order' => $orderData,
            ]);
        }
    }

    public function confirmOrderAction(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $post = [];
        foreach ($_POST as $key => $value) {
            $post[$key] = $this->input->post($key, true);
        }

        $update = $this
                    ->shoporder_model
                    ->setObjectId(intval($post['orderid']))
                    ->setProperty('confirm', $post['confirmStatus'])
                    ->update();

        if ($update) {
            if ($post['confirmStatus'] === $this->config->item('orderConfirmTrue')) {
                $message = 'Order confirmed.';
            } elseif ($post['confirmStatus'] === $this->config->item('orderConfirmFalse')) {
                $message = 'Order rejected.';
            }
            $message .= $this->sendOrdeEmail($post) ? ' Notification email sent to a buyer' : ' Notification email did not send to a buyer';
            $response = [
                'status'        => '1',
                'message'       => $message,
                'orderId'       => $post['orderid'],
                'confirmStatus' => $post['confirmStatus'],
                'type'          => $post['orderType'],
            ];
        } else {
            if ($post['confirmStatus'] === $this->config->item('orderConfirmTrue')) {
                $message = 'Order confirmation failed!';
            } elseif ($post['confirmStatus'] === $this->config->item('orderConfirmFalse')) {
                $message = 'Order rejection failed!';
            }
            $response = [
                'status' => '0',
                'message' => $message,
            ];
        }

        echo json_encode($response);
        return;
    }

    private function sendOrdeEmail(array &$post): bool
    {
        if ($post['confirmStatus'] === $this->config->item('orderConfirmTrue')) {
            $subject = 'Order confirmed';
            $message = 'Your order with id "' . $post['orderid']. '" confirmed';
        } elseif ($post['confirmStatus'] === $this->config->item('orderConfirmFalse')) {
            $subject = 'Order rejected';
            $message = 'Your order with id "' . $post['orderid']. '" rejected';
        }

        return Email_helper::sendOrderEmail($post['buyerEmail'] , $subject, $message);
    }

    public function getDistance(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $post = Utility_helper::sanitizePost();
        $data = $this->user_model->getDistanceBetweenUsers(intval($post['vendorId']), intval($post['buyerId']));
        if ($data) {
            echo json_encode($data);
        } else {
            $response = [
                'status' => '0',
                'message' => 'Information not available',
            ];
            echo json_encode($response);
        }
    }

    public function getPlaceByLocation(){
        $location = $this->input->post('location');
        $range = $this->input->post('range');
        $coordinates = Google_helper::getLatLong($location);
        $lat = $coordinates['lat'];
        $long = $coordinates['long'];
        $data['directories'] = $this->Bizdir_model->get_bizdir_by_location(floatval($lat),floatval($long),$range);
        $result = $this->load->view('bizdir/place_card', $data,true);
        if( isset($result) ) {
            return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
            ->set_output(json_encode($result));
        } else {
            return $this->output
			->set_content_type('application/json')
			->set_status_header(500)
			->set_output(json_encode(array(
                'text' => 'Not Found',
                'type' => 'Error 404'
            )));
        }
		
	}

    public function getLocation(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $data = Google_helper::getLatLong($post['address'], '', $post['city'], '');

        if ($data['lat'] === '0' && $data['long'] === '0') {
            $response = [
                'status' => '0',
                'message' => 'Unknown location',
            ];
            echo json_encode($response);
            return;
        }
        
        echo json_encode($data);
        return;
    }

    public function calculateDistance(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();

        $distance = Utility_helper::getDistance(floatval($post['latOne']), floatval($post['lngOne']), floatval($post['latTwo']), floatval($post['lngTwo']));

        echo $distance ? round($distance, 2) : 0;
    }

    public function getOrderByVendor($user_id = false){
        $this->load->model('api_model');
        $buyerId = $user_id ? $user_id : $this->session->userdata('userId');
        $result = $this->api_model->getDeliveryOrders($buyerId);
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($result));
        
    }

    public function submitForm(): void
    {
        if (!$this->input->is_ajax_request()) return;
    
        $post = Utility_helper::sanitizePost();
        $vendor = $this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getVendorData();
        $spotTypeId = intval($post['spotTypeId']);
        $orderRandomKey = $post['orderRandomKey'];
    
        if ($spotTypeId === $this->config->item('deliveryType') && !$this->validateDeliveryLocation($post['user'])) {
            $response = [
                'status' => '0',
                'message' => 'Order not made! Please insert delivery city, zipcode and/or address'
            ];
        } elseif ($spotTypeId === $this->config->item('deliveryType') && !$this->validateDeliveryDistance($post['user'], $vendor)) {
            $response = [
                'status' => '0',
                'pickup' => '0'
            ];
            foreach ($vendor['typeData'] as $type) {
                if (intval($type['typeId']) === $this->config->item('pickupType')) {
                    $response['pickup'] = '1';
                    break;
                }
            }
        } elseif (!$this->checkTermsAndConditions($vendor, $post['order'])) {
            $response = [
                'status' => '0',
                'message' => 'Order not made! Please confirm that you read terms and conditions and privacy policy',
            ];
        } elseif (isset($post['order']['remarks']) && strlen($post['order']['remarks']) > $this->config->item('maxRemarkLength')) {
            $response = [
                'status' => '0',
                'message' => 'Order not made! Remark is too long',
            ];
        } else {
            $this->setDeliveryCookies($post['user']);
            $this->checkWaiterTip($post);
            if ($this->populateSessionOrderData($post, $orderRandomKey)) {
                $response = [
                    'status' => '1',
                    'message' => $this->getRedirect($vendor, $spotTypeId, $orderRandomKey)
                ];
            } else {
                $response = [
                    'status' => '0',
                    'message' => '(7345) Order not made! Please try again'
                ];
            }
        }
    
        echo json_encode($response);
        return;
    }
    
    
    private function checkWaiterTip(array &$post): void
    {
        if (!isset($post['order']['waiterTip']) || floatval($post['order']['waiterTip']) < 0) {
            $post['order']['waiterTip'] = 0;
        }
    }

    private function setDeliveryCookies(array $user): void
    {
        if (!empty($user['city'])) {
            set_cookie('city', $user['city'], (365 * 24 * 60 * 60));
        }
        if (!empty($user['zipcode'])) {
            set_cookie('zipcode', $user['zipcode'], (365 * 24 * 60 * 60));
        }
        if (!empty($user['address'])) {
            set_cookie('address', $user['address'], (365 * 24 * 60 * 60));
        }
    }

    private function validateDeliveryLocation(array $user): bool
    {
        if ( empty($user['city']) || empty($user['zipcode']) || empty($user['address']) ) {
                return false;
        }
        return true;
    }
    
    private function validateDeliveryDistance(array $user, array $vendor): bool
    {
        $point = Google_helper::getLatLong($user['address'], $user['zipcode'], $user['city']);

        if ($point['lat'] && $point['long']) {
            $distance = Utility_helper::getDistance($point['lat'], $point['long'], $vendor['vendorLat'], $vendor['vendorLon']);
            return ($distance > $vendor['deliveryAirDistance']) ? false : true;
        }

        return false;
    }

    private function checkTermsAndConditions(array $vendor, array $order): bool
    {
        if ( $vendor['termsAndConditions'] && $vendor['showTermsAndPrivacy'] === '1'
            && (empty($order['termsAndConditions']) || empty($order['privacyPolicy']))
        ) {
            return false;
        }
        return true;
    }

    private function getRedirect(array $vendor, int $spotTypeId, string $orderRandomKey): string
    {
        if (
            $vendor['requireEmail'] === '0'
            && $vendor['requireName'] === '0'
            && $vendor['requireMobile'] === '0'
            && $spotTypeId === $this->config->item('local')
        ) {
            $redirect = 'pay_order?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
        } else {
            $redirect = 'buyer_details?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
        };

        return $redirect;
    }

    private function populateSessionOrderData(array $post, string $orderRandomKey): bool
    {
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        $orderData['user'] = $post['user'];
        $orderData['orderExtended'] = $post['orderExtended'];
        $orderData['order'] = $post['order'];
        $this->shopsession_model->updateSessionData($orderData);

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        return ($this->shopsession_model->id && $this->shopsession_model->randomKey) ? true : false;
    }

    public function submitBuyerDetails(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $vendor = $this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getVendorData();
        $spotTypeId = intval($post['spotTypeId']);
        $messages = $this->checkBuyerData($post, $vendor, $spotTypeId);

        if (count($messages)) {
            $response = [
                'status' => '0',
                'messages' => $messages,
            ];
        } else {
            $orderRandomKey = $post['orderRandomKey'];
            $user = $post['user'];
            if ($this->populateUserData($orderRandomKey, $user)) {
                $this->setBuyerCookies($user);
                $redirect = 'pay_order?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
                $response = [
                    'status' => '1',
                    'message' => $redirect,
                ];  
            } else {
                $response = [
                    'status' => '0',
                    'messages' => ['Order not made. Please try again'],
                ];
            }
        }
        echo json_encode($response);
        return;
    }

    private function checkBuyerData(array &$post, array $vendor, int $spotTypeId): array
    {
        $messages = [];
        // check mobile phone
        if ($vendor['requireMobile'] === '1' || $spotTypeId !== $this->config->item('local')) {
            if (Validate_data_helper::validateMobileNumber($post['user']['mobile'])) {
                 // to store in cookies, without country code
                set_cookie('mobile', ltrim($post['user']['mobile'], '0'), (365 * 24 * 60 * 60));
                set_cookie('phoneCountryCode', $post['phoneCountryCode'], (365 * 24 * 60 * 60));
                $post['user']['mobile'] = $post['phoneCountryCode'] . ltrim($post['user']['mobile'], '0');
            } else {
                $message = 'Order not made! Mobile phone is required. Please try again';
                array_push($messages, $message);
            }
        }

        // check emai
        if ($vendor['requireEmail'] === '1' || $spotTypeId !== $this->config->item('local')) {
            if (!Validate_data_helper::validateEmail($post['user']['email'])) {
                $message = 'Order not made! Email is required. Please try again';
                array_push($messages, $message);
            }
        }

        // check name
        if ($vendor['requireName'] === '1' ) {
            if (!Validate_data_helper::validateString($post['user']['username'])) {
                $message = 'Order not made! Username is required. Please try again';
                array_push($messages, $message);
            }
        }

        return $messages;
    }

    private function setBuyerCookies(array $user): void
    {
        if (!empty($user['username'])) {
            set_cookie('username', $user['username'], (365 * 24 * 60 * 60));
        }
        if (!empty($user['email'])) {
            set_cookie('email', $user['email'], (365 * 24 * 60 * 60));
        }
    }

    private function populateUserData(string $orderRandomKey, array $user): bool
    {
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        foreach ($user as $key => $value) {
            $orderData['user'][$key] = $value;
        }

        // user can click create tiqs account and after change his mind
        if (empty($user['buyerConfirmed'])) {
            $orderData['user']['buyerConfirmed'] = '0';
        }

        $this->shopsession_model->updateSessionData($orderData);
        return ($this->shopsession_model->id && $this->shopsession_model->randomKey) ? true : false;
    }

    public function saveDesign($id = null): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $removeImage = Utility_helper::getAndUnsetValue($post, 'removeImage');

        if (!empty($post['bgImage']) && strpos($post['bgImage'], $this->config->item('_temp'))) {
            $oldName = $this->config->item('backGroundImages') . $post['bgImage'];
            $post['bgImage'] = $post['vendorId'] . '.' . Uploadfile_helper::getFileExtension($oldName);
            $newImageName = $this->config->item('backGroundImages') . $post['bgImage'];
            rename($oldName, $newImageName);
        }

        if (intval($removeImage)) {
            $imgExtensions = ['png', 'jpg', 'gif', 'jpeg'];
            foreach($imgExtensions as $ext) {
                $img = $this->config->item('backGroundImages') . $post['vendorId'] . '.' . $ext;
                $tempImg = $this->config->item('backGroundImages') . $post['vendorId'] . $this->config->item('_temp') . '.' . $ext;
                Uploadfile_helper::unlinkFile($img);
                Uploadfile_helper::unlinkFile($tempImg);
            }
        }

        $input = [
            'vendorId' => Utility_helper::getAndUnsetValue($post, 'vendorId'),
            'active' => Utility_helper::getAndUnsetValue($post, 'active'),
            'templateName' => Utility_helper::getAndUnsetValue($post, 'templateName'),
            'templateValue' => serialize($post),
        ];
        $response = [];

        $this->shopvendortemplate_model->setObjectFromArray($input);

        if ($id) {
            $this->shopvendortemplate_model->id = intval($id);
        }

        // validation methods
        $this->checkDesignTemplateName($response);
        $this->checkTemplateName($response);
        $this->deactivateActive($response);

        // crud
        if (!$response) {
            is_null($this->shopvendortemplate_model->id) ? $this->createDesignTemplate($response) : $this->updateDesingTemplate($response);
        }

        //check for image upoad
        if (isset($newImageName)) {
            $response['bgImage'] = $post['bgImage'];
        }

        echo json_encode($response);
    }

    private function checkDesignTemplateName(array &$response): void
    {
        if (!$this->shopvendortemplate_model->templateName) {
            $response = [
                'status' => '0',
                'message' => ['Template name is requried field.']
            ];
        }
        return;
    }

    private function checkTemplateName(array &$response): void
    {
        if ($this->shopvendortemplate_model->checkIsNameExists()) {
            $response = [
                'status' => '0',
                'message' => ['Template with this name already exists.']
            ];
        }
        return;
    }

    private function deactivateActive(array &$response): void
    {
        if ($this->shopvendortemplate_model->active === '1' && !$this->shopvendortemplate_model->deactivateActive()) {
            if ((isset($response['message']))) {
                $messages = $response['message'];
                array_push($messages, 'Only one template can be active.');
            } else {
                $messages = ['Only one template can be active.'];
            }
            $response = [
                'status' => '0',
                'message' => $messages 
            ];
        }
        return;
    }

    private function createDesignTemplate(array &$response): void
    {
        if ($this->shopvendortemplate_model->create()) {
            $response = [
                'status' => '1',
                'message' => 'Design created',
                'designId' => $this->shopvendortemplate_model->id,
            ];
        } else {
            $response = [
                'status' => '0',
                'message' => ['Design create failed']
            ];
        }
        return;
    }

    public function updateDesingTemplate(array &$response): void
    {
        if ($this->shopvendortemplate_model->update()) {
            $response = [
                'status' => '1',
                'message' => 'Design updated'
            ];
        } else {
            $response = [
                'status' => '0',
                'message' => 'Design update failed'
            ];
        }
        return;
    }
       
    public function saveIrame($id): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $iframeSettings = serialize($post);
        $id = intval($id);
        // $update = $this->shopvendor_model->setObjectId($id)->setProperty('iframeSettings', $iframe)->update();
        // var_dump($id);
        // var_dump($iframeSettings);
        return;
    }

    public function generateCategoryKey(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $userId = intval($post['venodrId']);
        $openKey = $this->shopcategory_model->setProperty('userId', $userId)->createOpenKey();
        echo json_encode([
            'key' => $openKey
        ]);
    }

    public function checkCategoryCode(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $categoryId = intval($post['categoryId']);
        $check = $this->shopcategory_model->setObjectId($categoryId)->setProperty('openKey', $post['openKey'])->checkOpenKey();

        if ($check) {
            // TO DO UPDATE IF EXISTS
            $jwt = [
                'vendorId' => $post['vendorId'],
                'spotId' => $post['spotId'],
                'openCategory' => $categoryId
            ];

            $this->shopsession_model->insertSessionData($jwt);
            if (!$this->shopsession_model->orderData) return;

            $post['randomKey'] = $this->shopsession_model->randomKey;
            echo json_encode($post);
        }

        return;
    }

    public function checkIfsUserExists(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $email = $this->input->post('email', true);
        echo $this->user_model->isDuplicate($email) ? 1 : 0;
        return;
    }

    public function checkIfVendorExists(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $email = $this->input->post('email', true);
        $this->user_model->setUniqueValue($email)->setWhereCondtition()->setUser('roleid');
        echo (!empty($this->user_model->roleid) && $this->user_model->roleid === $this->config->item('owner')) ? 1 : 0;
        return;
    }

    public function uploadViewBgImage(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $folder = $this->config->item('backGroundImages');
        $bgImage = $_SESSION['userId'] . $this->config->item('_temp') . '.'. Uploadfile_helper::getFileExtension($_FILES['bgImage']['name']);
        $checkBgImage = $folder . $bgImage;
		$constraints = [
			'allowed_types'=> 'gif|jpg|png|jpeg'
        ];
        $_FILES['bgImage']['name'] = $bgImage;

		if (Uploadfile_helper::unlinkFile($checkBgImage) && Uploadfile_helper::uploadFiles($folder, $constraints)) {
            $respone = [
                'status' => '1',
                'message' => $bgImage
            ];
		} else {
            $respone = [
                'status' => '0',
                'message' => 'Image upload failed'
            ];
        }

        echo json_encode($respone);
        return;
    }
    
    public function saveAnalytics($id): void
    {
        if (!$this->input->is_ajax_request()) return;
        $post = Utility_helper::sanitizePost();
        $id = intval($id);

        $update = $this->shopvendor_model->setObjectId($id)->setObjectFromArray($post)->update();
        if ($update) {
            $response = [
                'status' => '1',
                'message' => 'Success'
            ];
        } else {
            $response = [
                'status' => '0',
                'message' => 'Error! Please try again'
            ];
        }

        echo json_encode($response);

        return;
    }

    public function actviateApiRequest(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();

        $email = MIGRATION_EMAIL;
        $subject = 'API key activation';
        $message  = 'User with id "' . $post['userId'] . '" asks for activation ';
        $message .= 'api key ' . $post['apikey'] . '.';
        if (Email_helper::sendEmail($email, $subject, $message)) {
            $response = [
                'status' => '1',
                'messages' => ['Request for key activation sent to admin']
            ];
        } else {
            $response = [
                'status' => '0',
                'messages' => ['Action failed. Please try again']
            ];
        }

        echo json_encode($response);
        return;
    }

    public function sendReportPrintRequest(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $post['userId'] =  intval($_SESSION['userId']);
        $response = [];

        $this->printFinanceReporets($post, $response);
        $this->emailFinanceReportes($post, $response);

        echo json_encode($response);
        return;
    }

    private function printFinanceReporets(array $post, array &$response): void
    {
        if (!$this->shopprinters_model->setProperty('userId', $post['userId'])->checkPrinterReportes()) return;

        $post['printed'] = '0';
        $insert = $this->shopreportrequest_model->setObjectFromArray($post)->create();

        if ($insert) {
            $response['printer'] = [
                'status' => '1',
                'messages' => ['Request for printing report sent']
            ];
        } else {
            $response['printer'] = [
                'status' => '0',
                'messages' => ['Action failed. Please try again']
            ];
        }

        return;
    }

    private function emailFinanceReportes(array $post, array &$response): void
    {
        if (!$this->shopvendor_model->setProperty('vendorId', $post['userId'])->getProperty('emailFinanceReporets')) return;

        $this->user_model->setUniqueValue($_SESSION['userId'])->setWhereCondtition()->setUser('receiptEmail');

        if (!$this->user_model->receiptEmail) {
            $response['email'] = [
                'status' => '0',
                'messages' => ['No email. Please add responsible person email']
            ];
            return;
        }

        $url  = base_url() . 'api/report?';
        $url .= 'vendorid=' . $_SESSION['userId'];
        $url .= '&datetimefrom=' . str_replace(' ', 'T', $post['dateTimeFrom']);
        $url .= '&datetimeto=' . str_replace(' ', 'T', $post['dateTimeTo']);
        $url .= '&report=' . $post['report'];
        $url .= '&finance=1';

        $reportResponse = json_decode(file_get_contents($url));

        if(is_null($reportResponse)) {
            $response['email'] = [
                'status' => '0',
                'messages' => ['Email not sent. Check period']
            ];
            return;
        }

        if ($reportResponse->status === '1') {
            $report = $this->config->item('financeReportes') . $_SESSION['userId'] . '_' . $post['report'] . '.png';
            if (Email_helper::sendEmail($this->user_model->receiptEmail, $post['report'], '', false, $report)) {
                $response['email'] = [
                    'status' => '1',
                    'messages' => ['Email sent']
                ];
            } else {
                $response['email'] = [
                    'status' => '0',
                    'messages' => ['Email not sent']
                ];
            }
            unlink($report);
        } else {
            $response['email'] = [
                'status' => '0',
                'messages' => ['Email not sent. Please try again']
            ];
        }

        return;
    }

    public function checkPrintersConnection($printerId): void
    {
        if (!$this->input->is_ajax_request()) return;

        $connected = $this
                        ->shopprinterrequest_model
                            ->setProperty('printerId', intval($printerId))
                            ->setProperty('conected', date('Y-m-d H:i:s', strtotime('-5 minutes')))
                            ->setProperty('smsSent', '0')
                            ->checkIsPrinterConnected();

        $status = $connected ? '1' : '0';
        echo json_encode([
            'status' => $status
        ]);
    }

    public function updateApiName($id): void
    {
        if (!$this->input->is_ajax_request()) return;
        $name = $this->input->post('name', true);
        $id = intval($id);
        $update = $this->api_model->setObjectId($id)->setProperty('name', $name)->update();

        if ($update) {
            $response = [
                'status' => '1',
                'messages' => ['Name updated']
            ];
        } else {
            $response = [
                'status' => '0',
                'messages' => ['Name update failed. Please try again']
            ];
        }

        echo json_encode($response);
    }

    public function posLogin(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $employee = $this
                    ->employee_model
                    ->setProperty('ownerId', $_SESSION['userId'])
                    ->setProperty('posPin', $post['posPin'])
                    ->employeePosLogin();

        if ($employee) {
            $this->shopposlogin_model->login(intval($employee['id']));
            $_SESSION['unlockPos'] = $this->shopposlogin_model->id;
            $response = [
                'status' => '1',
                'posManager' => $employee['manager']
            ];

        } else {
            $response['status'] = '0';
        }

        echo json_encode($response);
        return;
    }

    public function lockPos(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $logout = $this->shopposlogin_model->setObjectId($_SESSION['unlockPos'])->logout();

        if ($logout) unset($_SESSION['unlockPos']);

        $response['status'] = isset($_SESSION['unlockPos']) ? '0' : '1';

        echo json_encode($response);

        return;
    }

    public function fetchSavedOrder(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();
        $spotId = intval($post['spotId']);
        $orderDataRandomKey = $post['orderDataRandomKey'];
        $vendorId = intval($_SESSION['userId']);
        $ordered = Jwt_helper::fetchPos($orderDataRandomKey, $vendorId, $spotId, ['vendorId', 'spotId']);

        if ($ordered && $ordered['makeOrder']) {

            $spot = $this->shopspot_model->fetchSpot($vendorId, $spotId);
            $allProducts = $this->shopproductex_model->getMainProductsOnBuyerSide($vendorId, $spot);
            $vendor = $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData();
            $maxRemarkLength = $this->config->item('maxRemarkLength');

            $ordered = Utility_helper::returnMakeNewOrderElements($ordered['makeOrder'], $vendor, $allProducts['main'], $allProducts['addons'], $maxRemarkLength, true);
            $response['checkoutList'] = $ordered['checkoutList'];
            $this->getPosOrderName($orderDataRandomKey, $response);

            echo json_encode($response);
        }
    }


    private function getPosOrderName(string $ranodmKey, array &$response): void
    {
        $this->shopsession_model->setProperty('randomKey', $ranodmKey)->setIdFromRandomKey();
        $this->shopposorder_model->setProperty('sessionId', intval($this->shopsession_model->id))->setIdFromSessionId();

        if (!$this->shopposorder_model->id) return;

        $this->shopposorder_model->setObject();
        $response['posOrderId'] = $this->shopposorder_model->id;
        $response['posOrderName'] = $this->shopposorder_model->saveName;
        $response['spotId'] = $this->shopposorder_model->spotId;
        $response['lastChange'] = $this->shopposorder_model->updated ? $this->shopposorder_model->updated : $this->shopposorder_model->created;        

        return;
    }

    public function deletePosOrder(string $posOrderId): void
    {
        $posOrderId = intval($posOrderId);
        $response['status'] = ($this->shopposorder_model->setObjectId($posOrderId)->delete()) ? '1' : '0';
        echo json_encode($response);
        return;
    }

    public function checkIsIframeOrderPaid(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $get = Utility_helper::sanitizeGet();
        $order = $this->shoporder_model->setProperty('orderRandomKey', $get['order'])->fecthPaidOrderByRandomKey();

        if (is_null($order)) {
            $response = [
                'status' => '0'
            ];
        } else {
            $response = [
                'status' => '1',
                'id' => $order['id'],
                'orderRandomKey' => $get['order'],
                'orderKey' => $this->config->item('orderDataGetKey')
            ];
        }

        echo json_encode($response);

        return;
    }

    public function uploadEmailImage(): void
    {
        $userId = intval($_SESSION['userId']);
        Uploadfile_helper::changeFilesNameValue('file' , $userId);

        $fileName = $_FILES['file']['name'];

        if (Uploadfile_helper::uploadFilesNew($this->config->item('emailImagesFolder')) ) {
            echo json_encode(array('location' => $fileName));
        }
    }

    public function createEmailTemplate(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $templateName = $this->input->post('templateName', true);
        $templateSubject = $this->input->post('templateSubject', true);
        $templateType = $this->input->post('templateType', true);
        $html = $_POST['templateHtml'];
        $id = intval($this->input->post('templateId', true));
        $userId = intval($_SESSION['userId']);
        $unlayerDesign = $_POST['unlayerDesign'] ?? '';
        $unlayerDesign = str_replace(['<script', '</script'], ['', ''], $unlayerDesign);


        if ($this->shoptemplates_model->saveTemplate($templateName, $templateSubject, $html, $templateType, $userId, $id, $unlayerDesign)) {
            $response = [
                'status' => '1',
            ];

            if ($id) {
                $response['messages'] =  ['Template updated'];
                $response['update'] = '1';
            } else {
                $response['update'] = '0';
                $response['location'] = 'update_template' . DIRECTORY_SEPARATOR . $this->shoptemplates_model->id;
                $response['messages'] =  ['Template created'];
                $this->session->set_flashdata('success', 'Template created');
            }
        } else {
            $response = [
                'status' => '0',
                'messages' => ['Template not saved'],
            ];

        }

        echo json_encode($response);
        return;
    }

    public function payNlRegistration(): void
    {
        if (!$this->input->is_ajax_request() || $_SESSION['payNlServiceIdSet']) return;

        $userId = intval($_SESSION['userId']);
        $post = $this->security->xss_clean($_POST);

        $vatNumber = $this->updateVatNumber($userId, $post);
        $merchantId = $this->updateVendorMerchnatId($userId, $post);
        $serviceId = $this->updateVendorPaynlServiceId($merchantId, $userId);

        if ($merchantId && $serviceId) {
            $_SESSION['payNlServiceIdSet'] = true;
            Perfex_helper::apiUpdateCustomer($userId);
        } else {
            array_push($this->errorMessages, 'Account not created');
        }

        $response['status'] = $_SESSION['payNlServiceIdSet'] ? '1' : '0';
        $response['messages'] = $_SESSION['payNlServiceIdSet'] ? ['Account created'] :  $this->errorMessages;

        echo json_encode($response);
        return;
    }

    private function updateVatNumber($userId, $post): bool
    {
        if (empty($post['user']['vat_number'])) {
            array_push($this->errorMessages, 'VAT number is requried');
            return false;
        }

        $this->user_model->updateUser(['vat_number' => $post['user']['vat_number']], ['id' => $userId]);

        return $this->user_model->effectedrows > 0 ? true : false;
    }

    private function updateVendorMerchnatId($userId, $post): ?string
    {
        if (count($this->errorMessages)) return null;

        $result = Pay_helper::createMerchant($userId, $post);

        if (is_null($result)) {
            array_push($this->errorMessages, 'Merchant id not created. Please contact us');
            return null;
        }

        if ($result->success !== '1') {
            array_push($this->errorMessages, $result->error_message);
            return null;
        }

        $update = $this->shopvendor_model
                    ->setProperty('vendorId', $userId)
                    ->setObjectId(intval($this->shopvendor_model->getProperty('id')))
                    ->setProperty('merchantId', $result->merchantId)
                    ->setProperty('accountId', $result->accounts[0]->accountId)
                    ->update();

        if (!$update) {
            array_push($this->errorMessages, 'An error occurred while saving merchant id. Please contact us');
            return null;
        }

        return $result->merchantId;
    }

    private function updateVendorPaynlServiceId(?string $merchantId, int $userId): ?string
    {
        if (count($this->errorMessages)) return null;

        $result = Pay_helper::getPayNlServiceId($merchantId, $userId);

        if (is_null($result) || $result->request->result !== '1') {
            array_push($this->errorMessages, 'Service id not created. Please contact us');
            return null;
        }

        $update = $this->shopvendor_model
                    ->setProperty('vendorId', $userId)
                    ->setObjectId(intval($this->shopvendor_model->getProperty('id')))
                    ->setProperty('paynlServiceId', $result->serviceId)
                    ->update();

        if (!$update) {
            array_push($this->errorMessages, 'An error occurred while saving service id. Please contact us');
            return null;
        }

        return $result->serviceId;
    }

    public function uploadDocumentsForPayNl(): void
	{
        $payNlErrResponse = [];
        $count = 0;
		foreach ($_FILES as $documentId => $file) {
            if (!$_FILES[$documentId]['error'] && $_FILES[$documentId]['size']) {
                $count++;
                $filename = $_FILES[$documentId]['name'];
                $documentFile = base64_encode(file_get_contents($_FILES[$documentId]['tmp_name']));
                $result = Pay_helper::addDocument($documentId, $filename, $documentFile);
                if ($result->result === '0') {
                    $payNlErrResponse[$documentId] = $result->errorMessage;
                }
            }
        }

        if (!$count) {
            $response = [
                'status' => '0',
                'messages' => ['You did not upload any document']
            ];
        } else {
            if (empty($payNlErrResponse)) {
                $response = [
                    'status' => '1',
                    'messages' => ['Document(s) uplaoded']
                ];
            } else {
                $response = [
                    'messages' => $payNlErrResponse
                ];
            }
        }

        echo json_encode($response);
		return;
    }

    public function insertAllPaymentMethods(): void
    {
        if (!$this->input->is_ajax_request() || intval($_SESSION['userId']) !== $this->config->item('tiqsId')) return;

        $vendorIds = $this->shopvendor_model->readImproved(['what' => ['vendorId']]);

        if ($this->shoppaymentmethods_model->insertAll($vendorIds)) {
            $response = [
                'status' => '1',
                'messages' => ['All data imported']
            ];
        } else {
            $response = [
                'messages' => ['Import failed']
            ];
        }

        echo json_encode($response);
        return;
    }

    public function getVendorPaymentMethods(): void
    {
        if (!$this->input->is_ajax_request()) return;
        $productGroup = base64_decode($_GET['group']);

        $data = [
            'data' =>   $this
                            ->shoppaymentmethods_model
                            ->setProperty('vendorId', $_SESSION['userId'])
                            ->setProperty('productGroup', $productGroup)
                            ->getVendorGroupPaymentMethods()
        ];


        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $this
            ->output
                ->set_status_header( 200 )
                ->set_content_type('application/json', 'utf-8')
                ->set_output($data);

        return;
    }

    public function updatePaymentMethodCost($id): void
    {
        if (!$this->input->is_ajax_request()) return;

        $vendorCost = $this->input->post('vendorCost', true);

        $update = $this
                    ->shoppaymentmethods_model
                        ->setObjectId(intval($id))
                        ->setProperty('vendorId', intval($_SESSION['userId']))
                        ->setProperty('vendorCost', $vendorCost)
                        ->updatePaymentMethod();

        if ($update) {
            $response = [
                'status' => '1',
                'messages' => ['Cost updated']
            ];
        } else {
            $response = [
                'status' => '0',
                'messages' => ['Update failed']
            ];
        }

        echo json_encode($response);
        return;
    }

    public function registerAmbasador(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = Utility_helper::sanitizePost();

        if (empty($post['email']) || !Validate_data_helper::validateString($post['email'])) {
            $message = 'Email is required';
            array_push($this->errorMessages, $message);
        }

        if (!Validate_data_helper::validateEmail($post['email'])) {
            $message = 'Email is not validi';
            array_push($this->errorMessages, $message);
        }

        if (empty($post['firstName']) || !Validate_data_helper::validateString($post['firstName'])) {
            $message = 'First name is required';
            array_push($this->errorMessages, $message);
        }

        if (empty($post['lastName']) || !Validate_data_helper::validateString($post['lastName'])) {
            $message = 'Last name is required';
            array_push($this->errorMessages, $message);
        }

        if (!count($this->errorMessages)) {
            $ambasador = [
                'firstName' => $post['firstName'],
                'lastName' => $post['lastName'],
                'email' => $post['email'],
                'password' => Utility_helper::shuffleString(10),
            ];
            if (Email_helper::activateAmbasador($ambasador)) {
                $response = [
                    'status' => '1',
                    'messages' => ['Activation email sent on given email adress']
                ];
            } else {
                $response = [
                    'status' => '0',
                    'messages' => ['Activation email did not send. Please try again']
                ];
            }
        } else {
            $response = [
                'status' => '0',
                'messages' => $this->errorMessages
            ];
        }

        echo json_encode($response);
        return;
    }

    public function refundOrderMoney($orderId): void
    {
        if (!$this->input->is_ajax_request()) return;

        $venodrId = intval($_SESSION['userId']);
        $orderId = intval($orderId);
        $post = $this->security->xss_clean($_POST);

        if (!$this->shoporder_model->setObjectId($orderId)->isVenodrOrder($venodrId)) {
            $response = [
                'status' => '0',
                'messages' => ['Not allowed']
            ];
            echo json_encode($response);
            return;
        }

        $checkAmount = floatval($this->shoporder_model->getProperty('serviceFee')) + floatval($this->shoporder_model->getProperty('amount')) + floatval($this->shoporder_model->getProperty('waiterTip'));
        if (floatval($post['amount']) > $checkAmount) {
            $response = [
                'status' => '0',
                'messages' => ['Refund amount can not be bigger than total order amount']
            ];
            echo json_encode($response);
            return;
        }

        $post['transactionId'] = $this->shoporderpaynl_model->setProperty('orderId', $orderId)->getOrderTransactionId();

        if (is_null($post['transactionId'])) {
            $response = [
                'status' => '0',
                'messages' => ['No transaction id. Check is order paid online']
            ];
            echo json_encode($response);
            return;
        }

        $post['amount'] = intval($post['amount'] * 100);
        $response = $this->shoporder_model->refundOrder($post);
        echo json_encode($response);
        return;
    }

    public function activatePaymentMethod($id): void
    {
        if (!$this->input->is_ajax_request()) return;

        $active = $this->input->post('active', true);
        $update = $this
                    ->shoppaymentmethods_model
                        ->setObjectId(intval($id))
                        ->setProperty('vendorId', intval($_SESSION['userId']))
                        ->setProperty('active', $active)
                        ->updatePaymentMethod();

        if ($update) {
            $message = ($active === '1') ? 'Method activated' : 'Method deactivated';
            $status = '1';
        } else {
            $message = 'Activation failed';
            $status = '0';
        }

        echo json_encode([
            'status' => $status,
            'messages' => [$message]
        ]);
        return;
    }

    public function manageLandingPage($id = null): void
    {
        if (!$this->input->is_ajax_request()) return;

        if ($id) {
            $this
                ->shoplandingpages_model
                ->setObjectId(intval($id))
                ->setProperty('active', $this->shoplandingpages_model->getProperty('active'));
        }

        $post = [
            'vendorId' => intval($_SESSION['userId']),
            'productGroup' => $this->input->post('productGroup', true),
            'landingPage' => $this->input->post('landingPage', true),
            'landingType' => $this->input->post('landingType', true),
            'name' => $this->input->post('name', true)
        ];

        $this->checkLandingPageName($post);
        $this->checkLandingUrl($post); // this method sets $post['value'] for url type
        $this->saveLandingPageFile($post); // this method sets $post['value'] for template type
        $this->saveLandingPage($post);


        if (count($this->errorMessages)) {
            array_push($this->errorMessages, 'Landing page did not create');
            $response = [
                'status' => '0',
                'messages' => $this->errorMessages
            ];
        } else {
            if ($id) {
                $message = 'Landing page updated';
                $update = '1';
            } else {
                $message = 'New landing page created';
                $update = '0';
            }

            $response = [
                'status' => '1',
                'messages' => [$message],
                'update' => $update
            ];
        }

        echo json_encode($response);
    }


    private function checkLandingPageName(array $post): void
    {
        if (!$this->shoplandingpages_model->setObjectFromArray($post)->checkIsNameFreeToUse()) {
            $message = 'Template with this name already exists for this product group';
            array_push($this->errorMessages, $message);
        }
    }

    private function checkLandingUrl(array &$post): void
    {
        if (empty($this->errorMessages) && $post['landingType'] === $this->config->item('urlLanding')) {
            $post['value'] = $this->input->post('value', true);
            if (!filter_var($post['value'], FILTER_VALIDATE_URL)) {
                $message = 'Invalid url';
                array_push($this->errorMessages, $message);
            }
        }
    }

    private function saveLandingPageFile(array &$post): void
    {
        if (empty($this->errorMessages) && $post['landingType'] === $this->config->item('templateLanding')) {
            $value = $_POST['value']; 
            $fileName =  base64_encode(implode('_' , $post));
            $filePath = $this->config->item('landingPageFolder') . $fileName . '.' . $this->config->item('landingTemplateExt');
            if (file_put_contents($filePath, $value)) {
                $post['value'] = $fileName;
            } else {
                $message = 'Template file is not create';
                array_push($this->errorMessages, $message);                
            }
        }
    }

    private function saveLandingPage(array $post): void
    {
        if (!empty($this->errorMessages)) return;
        if (!$this->shoplandingpages_model->setProperty('value', $post['value'])->manageLandingPage()) {
            $message = 'Process failed';
            array_push($this->errorMessages, $message);
        }
    }

    public function resetProductTimes(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->security->xss_clean($_POST);
        $timeFrom = $post['timeFrom'] ? $post['timeFrom'] : '';
        $timeTo = $post['timeTo'] ? $post['timeTo'] : '';
        $venodrId = intval($_SESSION['userId']);

        if (!Validate_data_helper::validateDate($timeFrom) && !Validate_data_helper::validateDate($timeTo)) {
            $response = [
                'status' => '0',
                'messages' => ['Invalid data sent']
            ];
        } if ($timeFrom && $timeTo && strtotime($timeFrom) > strtotime($timeTo)) {
            $response = [
                'status' => '0',
                'messages' => ['Time "from" cannot be after time "to"']
            ];
        } else {
            $update = $this->shopproducttime_model->resetProductTimes($venodrId, $timeFrom, $timeTo);
            if ($update) {
                $response = [
                    'status' => '1',
                    'messages' => ['Success']
                ];
            } else {
                $response = [
                    'status' => '0',
                    'messages' => ['Update failed']
                ];
            }
        }

        echo json_encode($response);
        return;

    }

    function sortProducts():void
    {
        if (!$this->input->is_ajax_request() || empty($_SESSION['userId'])) return;

        $products = $this->security->xss_clean($_POST['products']);
        $i = 0;
        foreach ($products as $productId) {
            $i++;
            if (!$this->shopproduct_model->setObjectId(intval($productId))->setproperty('orderNo', $i)->update()){
                $response = [
                    'status' => '0',
                    'messages' => ['Sorting failed']
                ];
                echo json_encode($response);
                return;
            }
        }

        $response = [
            'status' => '1',
            'messages' => ['Product sorted']
        ];
        echo json_encode($response);
        return;
    }

    function saveReportsSettings($id = null): void
    {
        if (!$this->input->is_ajax_request() || empty($_SESSION['userId'])) return;

        $id = ($id) ? intval($id) : null;
        $post = $this->security->xss_clean($_POST);

        $reportSettings = $this->prepareReportSettings($post);
        $reportEmails = explode(';', str_replace(' ', '', $post['reportEmails']['emails']));

        if (!$this->validateReportData($reportSettings, $reportEmails)) return;
        if (!$this->saveReport($reportSettings, $id)) return;
        if (!$this->saveEmails($reportEmails, $this->shopreport_model->id)) return;

        $response = [
            'status' => '1',
            'reportId' =>  $this->shopreport_model->id,
            'messages' => ['Saved']
        ];

        echo json_encode($response);
        return;
    }

    private function prepareReportSettings(array $post): array
    {
        $reportSettings = $post['reportSettings'];
        $reportSettings['vendorId'] = $_SESSION['userId'];
        $reportSettings = array_filter($reportSettings);
        return $reportSettings;
    }

    private function validateReportData(array $reportSettings, array $reportEmails): bool
    {
        $messages = [];
        if (!(isset($reportSettings['xReport']) || isset($reportSettings['zReport']))) {
            array_push($messages, 'You must select x and/or z report(s)');
        }

        if (empty($reportSettings['sendTime'])) {
            array_push($messages, 'You must set send time');
        }

        if ($reportSettings['sendPeriod'] === $this->config->item('weekPeriod') && empty($reportSettings['sendDay'])) {
            array_push($messages, 'You must select day for week period');
        }

        if ($reportSettings['sendPeriod'] === $this->config->item('monthPeriod') && empty($reportSettings['sendDate'])) {
            array_push($messages, 'You must select date for month period');
        }

        if (empty($reportSettings['sendPeriod'])) {
            array_push($messages, 'You must select report period');
        }

        if (empty($reportEmails)) {
            array_push($messages, 'No email(s)');
        } else {
            foreach($reportEmails as $email) {
                if (!Validate_data_helper::validateEmail($email)) {
                    $email = trim($email);
                    array_push($messages, 'Email "' . $email . '" is not valid');
                }
            }
        }

        if ($messages) {
            $response = [
                'status' => '0',
                'messages' => $messages
            ];
            echo json_encode($response);
            return false;
        }

        return true;
    }

    private function saveReport(array $reportSettings, ?int $id): bool
    {
        if (!isset($reportSettings['xReport'])) {
            $reportSettings['xReport'] = '0';
        }

        if (!isset($reportSettings['zReport'])) {
            $reportSettings['zReport'] = '0';
        }

        $this->shopreport_model->setObjectFromArray($reportSettings);
        $save = ($id) ? $this->shopreport_model->setObjectId($id)->updateReport() : $this->shopreport_model->createReport();

        if (!$save) {
            $response = [
                'status' => '0',
                'messages' => ['Process failed. Report not saved']
            ];
            echo json_encode($response);
            return false;
        } else {
            $response['reportId'] = $this->shopreport_model->id;
            return true;
        }
    }

    private function saveEmails(array $reportEmails, int $id): bool
    {
        if (!$this->shopreportemail_model->setProperty('reportId', $id)->saveEmails($reportEmails)) {
            $response = [
                'status' => '0',
                'reportId' =>  $this->shopreport_model->id,
                'messages' => ['Report created, but insert emails failed. Please try again']
            ];
            echo json_encode($response);
            return false;
        }
        return true;
    }

    public function changeReservation(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $post = $this->security->xss_clean($_POST);

        $this->validateChangeReservationPost($post);
        list($oldReservation, $newReservation) = $this->getReservations($post);
        $this->validateReservations($oldReservation, $newReservation, $post);
        $this->updateRequestRefund($post['oldReservationId']);

        if ($this->errorMessages) {
            $response = [
                'status' => '0',
                'messages' => $this->errorMessages
            ];
        } else {
            $response = [
                'status' => '1',
                'messages' => ['Reservation changed']
            ];
        }

        echo json_encode($response);
        return;
    }

    private function validateChangeReservationPost(array $post): void
    {
        if (empty($post['oldReservationId'])) {
            array_push($this->errorMessages, 'Old reservation transaction id is requried');
        }

        if (empty($post['newReservationId'])) {
            array_push($this->errorMessages, 'New reservation transaction id is requried');
        }

        if ($post['oldReservationId'] ===  $post['newReservationId']) {
            array_push($this->errorMessages, 'Reservation ids cannot be equal');
        }
    }

    private function getReservations(array $post): array
    {
        if ($this->errorMessages) return [null, null];

        return [
            $this->bookandpay_model->getBookingByReservationId($post['oldReservationId']),
            $this->bookandpay_model->getBookingByReservationId($post['newReservationId'])
        ];
    }

    private function validateReservations(?array $oldReservation, ?array $newReservation, array $post): void
    {
        if ($this->errorMessages) return;

        if ($oldReservation && $newReservation && $oldReservation['customer'] !== $newReservation['customer']) {
            array_push($this->errorMessages, 'Not allowed. This reservations created by different vendors');
        }

        $this->validateReservation($oldReservation, $post['oldReservationId']);
        $this->validateReservation($newReservation, $post['newReservationId']);

        return;
    }

    private function validateReservation(?array $reservation, string $transactionId): void
    {
        if ($this->errorMessages) return;

        if( is_null($reservation)) {
            array_push($this->errorMessages, 'Reservation with  transaction id "' . $transactionId . '" does not exists');
            return;
        }

        if (!intval($reservation['paid'])) {
            array_push($this->errorMessages, 'Reservation with  transaction id "' . $transactionId . '" is not paid');
        }

        if (intval($reservation['scanned'])) {
            array_push($this->errorMessages, 'Reservation with  transaction id "' . $transactionId . '" already scanned');
        }

        if (intval($reservation['refundRequested'])) {
            array_push($this->errorMessages, 'Refund for reservation with  transaction id "' . $transactionId . '" already requested');
        }

        $today = date('Y-m-d');
        $checkDate = date('Y-m-d', strtotime('-2 days', strtotime($reservation['eventdate'])));
        if ($today >= $checkDate) {
            array_push($this->errorMessages, 'Not allowed to change. Reservation date for reservation with id "' . $transactionId . '" must not be in next two days');
        }

        return;
    }

    private function updateRequestRefund(string $reservationId): void
    {
        if ($this->errorMessages) return;

        if (!$this->bookandpay_model->setPropertry('reservationId', $reservationId)->updateBooking(['refundRequested' => '1'])) {
            array_push($this->errorMessages, 'Failed');
        }
    }

    public function deleteFloorplan($floorplanId): void
    {
        if (!$this->input->is_ajax_request()) return;

        $floorplanId = intval($floorplanId);
        $delete = $this
                    ->floorplan_model
                        ->setObjectId($floorplanId)
                        ->setProperty('vendorId', $_SESSION['userId'])
                        ->deleteFloorplan($this->floorplanareas_model);
        if ($delete) {
            $response = [
                'status' => '1',
                'messages' => ['Floorplan deleted']
            ];
        } else {
            $response = [
                'status' => '0',
                'messages' => ['Floorplan did not delete']
            ];
        }

        echo json_encode($response);
    }

    public function downloadPriceList(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $csvFile = 'assets/csv/pricelists/' . $_SESSION['userId'] . '_pricelist.csv';
        $csvData = $this->prepareCsvData();
        $csvFileFullPath = FCPATH . $csvFile;

        if (file_exists($csvFileFullPath)) unlink($csvFileFullPath);

        $csvFileUrl  = Utility_helper::saveArrayToCsv($csvData, $csvFile);

        if (is_null($csvFile)) {
            $response = [
                'status' => '0',
                'messages' => ['Download failed']
            ];
        } else {
            $response = [
                'status' => '1',
                'messages' => ['Download success'],
                'csvFile' => $csvFileUrl,
            ];
        }

        echo json_encode($response);
        return;
    }

    private function prepareCsvData(): array
    {
        $csvData = [];
        $userId = intval($_SESSION['userId']);
        $products = $this->shopproductex_model->getUserProductsNew($userId);  
        $types = $this->shopprodutctype_model->fetchProductTypes($userId, ['tbl_shop_products_types.type AS productType' ]);
        $types = array_map(function($element){
            return $element['productType'];
        }, $types);

        // var_dump($types);
        foreach($products as $product) {
            $productToCsv['name'] = $product[0]['productDetails'][0]['name'];

            // set all type prices to zero
            foreach ($types as $type) {
                $productToCsv[$type . ' local price'] = '0';
                $productToCsv[$type . ' delivery price'] = '0';
                $productToCsv[$type . ' pickup price'] = '0';
            }

            // now fetch prices
            $details = $product[0]['productDetails'];
            foreach ($details as $typeDetails) {
                $productToCsv[$typeDetails['productType'] . ' local price'] = $typeDetails['price'];
                $productToCsv[$typeDetails['productType'] . ' delivery price'] = $typeDetails['deliveryPrice'];
                $productToCsv[$typeDetails['productType'] . ' pickup price'] = $typeDetails['pickupPrice'];
            }

            array_push($csvData, $productToCsv);
        }

        return $csvData;
    }

}
