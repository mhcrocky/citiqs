<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Publicorders extends BaseControllerWeb
    {
        public function __construct()
        {
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');
            $this->load->helper('country_helper');
            

            $this->load->model('user_subscription_model');
            $this->load->model('shopcategory_model');
            $this->load->model('shopproduct_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('user_model');
            $this->load->model('shopspot_model');
            $this->load->model('shopvendor_model');
            $this->load->model('shopvisitorreservtaion_model');
            $this->load->model('shopvendortime_model');
            $this->load->model('shopspottime_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');
        }

        public function index(): void
        {
            $get = $this->input->get(null, true);
            $typeId = empty($get['typeId']) ? '' : $get['typeId'];

            // FETCH VENDOR DATA AND
            $vendor = $this->shopvendor_model->setProperty('vendorId', $get['vendorid'])->getVendorData();

            // CHECK VENDOR CREDENTIALS
            $this->checkVendorCredentials($vendor);

            // SAVE VENODR DATA IN SESSION
            $_SESSION['vendor'] = $vendor;

            // VENDOR SELECTED SPOT VIEW
            if (isset($get['spotid'])) {
                $spotId = intval($_GET['spotid']);
                $where = [
                    'tbl_shop_printers.userId=' => $_SESSION['vendor']['vendorId'],
                    'tbl_shop_spots.active' => '1',
                    'tbl_shop_spots.id' => $spotId,
                    'tbl_shop_vendor_types.active=' => '1',
                    'tbl_shop_vendor_types.vendorId=' => $_SESSION['vendor']['vendorId']
                ];

                if ($this->shopspot_model->fetchUserSpotsImporved($where)) {
                    $this->loadSpotView($spotId);
                    return;
                } else {
                    $redirect = 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                    redirect($redirect);
                }
            }
            
            // SELECT VENDOR SPOT VIEW
            $this->loadVendorView($typeId);
            return;
      
        }

        private function loadSpotView(int $spotId): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERING';

            //CHECK IS SPOT OPEN
            if (!$this->shopspottime_model->setProperty('spotId', $spotId)->isOpen()) {
                $redirect = 'spot_closed' . DIRECTORY_SEPARATOR  . $spotId;
                redirect($redirect);
                return;
            };

            $userId = $_SESSION['vendor']['vendorId'];
            $time = time();

            $data = [
                'categoryProducts' => $this->shopproductex_model->getUserProductsPublic($userId),
                'spotId' => $spotId,
                'day' => date('D', $time),
                'hours' => strtotime(date('H:i:s', $time)),
                'vendor' => $_SESSION['vendor'],
            ];

            $termsAndConditions = $this->shopvendor_model->readImproved([
                'what' => ['termsAndConditions'],
                'where' => [
                    'vendorId=' => $userId
                ]
            ])[0]['termsAndConditions'];

            if(!empty($termsAndConditions)){
				if (trim($termsAndConditions)) {
					$data['termsAndConditions'] = $termsAndConditions;
				}
			}

            $data['ordered'] = isset($_SESSION['order']) ? $_SESSION['order'] : null;

            $this->loadViews('publicorders/makeOrder', $this->global, $data, null, 'headerWarehousePublic');
            return;
        }

        private function loadVendorView($typeId = ''): void
        {
            $this->global['pageTitle'] = 'TIQS : SELECT SPOT';
            $types = Utility_helper::resetArrayByKeyMultiple($_SESSION['vendor']['typeData'], 'active');

            if (empty($types[1])) {
                $data = [
                    'vendor' => $_SESSION['vendor'],
                    'spots' => []
                ];
                $this->loadViews('publicorders/selectType', $this->global, $data, null, 'headerWarehousePublic');
            } elseif (count($types[1]) === 1 || $typeId) {
                $where = [
                    'tbl_shop_printers.userId=' => $_SESSION['vendor']['vendorId'],
                    'tbl_shop_spots.active' => '1',
                ];
                $where['tbl_shop_spots.spotTypeId'] = $typeId ? $typeId : $types[1][0]['typeId'];
                $data = [
                    'vendor' => $_SESSION['vendor'],
                    'spots' => $this->shopspot_model->fetchUserSpotsImporved($where),
                ];
                $this->loadViews('publicorders/selectSpot', $this->global, $data, null, 'headerWarehousePublic');
            } else {
                $data = [
                    'vendor' => $_SESSION['vendor'],
                    'activeTypes' => $types[1],
                ];
                $this->loadViews('publicorders/selectType', $this->global, $data, null, 'headerWarehousePublic');
            }
            
            return;
        }

        public function checkout_order(): void
        {
            $this->global['pageTitle'] = 'TIQS : CHECKOUT';

            if ( (empty($_POST) || empty($_SESSION['order'])) && empty($_SESSION['vendor']) ) {
                $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                redirect($redirect);
                exit();
            }

            // CHECK VENDOR CREDENTIALS
            $this->checkVendorCredentials($_SESSION['vendor']);

            $post = $this->input->post(null, true);

            if (!empty($post)) {
                $_SESSION['spotId'] = $post['spotId'];
                unset($post['spotId']);
                $_SESSION['order'] = $post;
            }


            $data = [
                'spotId' => $_SESSION['spotId'],
                'vendor' =>  $_SESSION['vendor'],
                'orderDetails' => $_SESSION['order'],
                'buyerRole' => $this->config->item('buyer'),
                'usershorturl' => 'tiqs_shop_service',
                'salesagent' => $this->config->item('tiqsId'),
                // 'countries' => Country_helper::getCountries(),
                'countryCodes' => Country_helper::getCountryPhoneCodes(),
            ];

            $data['username'] = isset($_SESSION['postOrder']['user']['username']) ? $_SESSION['postOrder']['user']['username'] : get_cookie('firstName') . ' ' . get_cookie('lastName');
            $data['email'] = isset($_SESSION['postOrder']['user']['email']) ? $_SESSION['postOrder']['user']['email'] : get_cookie('email');
            $data['mobile'] = isset($_SESSION['postOrder']['user']['mobile']) ? $_SESSION['postOrder']['user']['mobile'] : get_cookie('mobile');
            $data['userCountry'] = isset($_SESSION['postOrder']['user']['country']) ? $_SESSION['postOrder']['user']['country'] : '';#Country_helper::getCountryCodeFromIp();
            $data['phoneCountryCode'] = isset($_SESSION['postOrder']['phoneCountryCode']) ? $_SESSION['postOrder']['phoneCountryCode'] : '';#Country_helper::getCountryCodeFromIp();

            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function submitOrder(): void
        {
            if (empty($_POST) || empty($_SESSION['order']) || empty($_SESSION['vendor']) || empty($_SESSION['spotId'])) {
                $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                redirect($redirect);
                exit();
            }

            $_SESSION['postOrder'] = $this->input->post(null, true);

            redirect('pay_order');
        }

        public function pay_order(): void
        {
            if (empty($_SESSION['order']) || empty($_SESSION['vendor']) || empty($_SESSION['postOrder']) || empty($_SESSION['spotId'])) {
                $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                redirect($redirect);
                exit();
            }

            // CHECK VENDOR CREDENTIALS
            $this->checkVendorCredentials($_SESSION['vendor']);

            $this->global['pageTitle'] = 'TIQS : PAY';

            $data = [
                'ordered' => $_SESSION['order'],
                'vendor' => $_SESSION['vendor'],
                'idealPaymentType' => $this->config->item('idealPaymentType'),
                'creditCardPaymentType' => $this->config->item('creditCardPaymentType'),
                'bancontactPaymentType' => $this->config->item('bancontactPaymentType'),
                'giroPaymentType' => $this->config->item('giroPaymentType'),
            ];

            $this->loadViews('publicorders/payOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function insertOrder($paymentType, $paymentOptionSubId): void
        {
            if (empty($_SESSION['order']) || empty($_SESSION['vendor']) || empty($_SESSION['postOrder']) || empty($_SESSION['spotId'])) {
                $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                redirect($redirect);
                exit();
            }

            //fetch data from $_SESSION
            $post = $_SESSION['postOrder'];

            // check mobile phone
            if ($_SESSION['vendor']['requireMobile'] === '1') {
                if (Validate_data_helper::validateMobileNumber($post['user']['mobile'])) {
                    $post['user']['mobile'] = $post['phoneCountryCode'] . ltrim($post['user']['mobile'], '0');
                } else {
                    $this->session->set_flashdata('error', 'Order not made! Mobile phone is required. Please try again');
                    redirect('checkout_order');
                    exit();
                }
            }

            $this->user_model->manageAndSetBuyer($post['user']);

            if (!$this->user_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Name and email are mandatory fields. Please try again'); #Email, name and mobile are mandatory fields. 
                redirect('checkout_order');
                exit();
            }

            // prepare failed redirect
            $failedRedirect = 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'] . '&spotid=' . $_SESSION['spotId'];


            // insert order
            $post['order']['buyerId'] = $this->user_model->id;
            $post['order']['paid'] = '0';

            $this->shoporder_model->setObjectFromArray($post['order'])->create();            
            
            if (!$this->shoporder_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect($failedRedirect);
                exit();
            }

            // insert order details
            foreach ($post['orderExtended'] as $id => $details) {
                $details['productsExtendedId'] = intval($id);
                $details['orderId'] = $this->shoporder_model->id;
                if (!$this->shoporderex_model->setObjectFromArray($details)->create()) {
                    $this->shoporderex_model->orderId = $details['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                    $this->session->set_flashdata('error', 'Order not made! Please try again');
                    redirect($failedRedirect);
                    exit();
                }
            }

            // save orderId in SESSION
            $_SESSION['orderId'] = $this->shoporder_model->id;

            // go to Alfredpament controller to finish paying
            $successRedirect = 'paymentengine' . DIRECTORY_SEPARATOR . $paymentType  . DIRECTORY_SEPARATOR . $paymentOptionSubId;

            redirect($successRedirect);
        }

        private function checkVendorCredentials(array $vendor): void
        {
            if (empty($vendor['payNlServiceId'])) {
                redirect(base_url());
                exit();
            }

            if (!$this->shopvendortime_model->setProperty('vendorId', $vendor['vendorId'])->isOpen()) {
                redirect('closed/' . $vendor['vendorId']);
                exit();
            }

            if ($vendor['requireReservation'] === '1' && empty($_SESSION['visitorReservationId'])) {
                redirect('check424/' . $vendor['vendorId']);
                exit();
            }

            return;
        }

        public function closed($vendorId): void
        {
            if ($this->shopvendortime_model->setProperty('vendorId', $vendorId)->isOpen()) {
                $redirect = 'make_order?vendorid=' . $vendorId;
                redirect($redirect);
                return;
            };

            $this->global['pageTitle'] = 'TIQS : CLOSED';

            $data = [
                'vendor' => $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData()
            ];
            $workingTime = $this->shopvendortime_model->setProperty('vendorId', $vendorId)->fetchWorkingTime();
            $data['workingTime'] = $workingTime ? Utility_helper::resetArrayByKeyMultiple($workingTime, 'day') : null;

            $this->loadViews('publicorders/closed', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function spotClosed($spotId): void
        {
            if ($this->shopspottime_model->setProperty('spotId', $spotId)->isOpen()) {
                $redirect = 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'] . '&spotid=' . $spotId;
                redirect($redirect);
                return;
            };

            $this->global['pageTitle'] = 'TIQS : CLOSED';

            $spotId = intval($spotId);
            $data = [
                'vendor' => $this->shopvendor_model->setProperty('vendorId', $_SESSION['vendor']['vendorId'])->getVendorData(),
                'spot' => $this->shopspot_model->setObjectId($spotId)->setObject()
            ];

            $workingTime = $this->shopspottime_model->setProperty('spotId', $spotId)->fetchWorkingTime();
            $data['workingTime'] = $workingTime ? Utility_helper::resetArrayByKeyMultiple($workingTime, 'day') : null;

            $this->loadViews('publicorders/spotClosed', $this->global, $data, null, 'headerWarehousePublic');
        }
    }
