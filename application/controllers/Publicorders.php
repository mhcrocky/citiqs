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
            $this->load->helper('date');
            

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
            $this->load->model('shopvoucher_model');

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
                $spot = $this->shopspot_model->fetchUserSpotsImporved($where);
                if ($spot) {
                    $spot = reset($spot);
                    $this->loadSpotView($spot);
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

        private function loadSpotView(array $spot): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERING';
            //CHECK IS SPOT OPEN ONLY LOCAL TYPE
            if (
                intval($spot['spotTypeId']) === $this->config->item('local')
                && !$this->shopspottime_model->setProperty('spotId', $spot['spotId'])->isOpen()
            ) {
                $redirect = 'spot_closed' . DIRECTORY_SEPARATOR  . $spot['spotId'];
                redirect($redirect);
                return;
            };

            $_SESSION['spot'] = $spot;
            $userId = $_SESSION['vendor']['vendorId'];
            $time = time();
            $spotId = intval($spot['spotId']);

            $data = [
                'spotId' => $spotId,
                'day' => date('D', $time),
                'hours' => strtotime(date('H:i:s', $time)),
                'vendor' => $_SESSION['vendor'],
            ];

            if ($_SESSION['vendor']['preferredView'] === $this->config->item('oldMakeOrderView')) {
                $data['categoryProducts'] = $this->shopproductex_model->getUserProductsPublic($userId);
            } elseif ($_SESSION['vendor']['preferredView'] === $this->config->item('newMakeOrderView')) {
                $allProducts = $this->shopproductex_model->getMainProductsOnBuyerSide($userId, $spot);
                if ($allProducts) {
                    $data['mainProducts'] = $allProducts['main'];
                    $data['addons'] = $allProducts['addons'];
                }
            }

            // terms and conditions
            $termsAndConditions = $this->shopvendor_model->readImproved([
                'what' => ['termsAndConditions'],
                'where' => [
                    'vendorId=' => $userId
                ]
            ])[0]['termsAndConditions'];

            if(!empty($termsAndConditions)) {
				if (trim($termsAndConditions)) {
					$data['termsAndConditions'] = $termsAndConditions;
				}
			}

            $ordered = isset($_SESSION['order']) ? $_SESSION['order'] : null;

            $ordered = null;
            if (isset($_SESSION['orderVendorId']) && isset($_SESSION['order'])) {
                if ($_SESSION['orderVendorId'] === $_SESSION['vendor']['vendorId']) {
                    $ordered = $_SESSION['order'];
                } else {
                    unset($_SESSION['orderVendorId']);
                    unset($_SESSION['order']);
                }
            }

            if ($_SESSION['vendor']['preferredView'] === $this->config->item('oldMakeOrderView')) {
                $data['ordered'] = $ordered;
                $this->loadViews('publicorders/makeOrder', $this->global, $data, null, 'headerWarehousePublic');
            } elseif ($_SESSION['vendor']['preferredView'] === $this->config->item('newMakeOrderView')) {
                if ($ordered) {
                    $ordered = Utility_helper::returnMakeNewOrderElements($ordered, $data['vendor'], $data['mainProducts'], $data['addons']);
                    // $data['shoppingList'] = $ordered['shoppingList'];
                    $data['checkoutList'] = $ordered['checkoutList'];
                } else {
                    // $data['shoppingList'] = '';
                    $data['checkoutList'] = '';
                }
                $data['uploadProductImageFolder'] = $this->config->item('uploadProductImageFolder');
                $data['defaultProductsImages'] = $this->config->item('defaultProductsImages');
                if (!empty($_GET['category'])) {
                    $data['returnCategorySlide'] = $_GET['category'];
                }

                $this->loadViews('publicorders/makeOrderNew', $this->global, $data, null, 'headerWarehousePublic');
            }

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
                    'local' => $this->config->item('local'),
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

            if ( (empty($_POST) || empty($_SESSION['order'])) && empty($_SESSION['vendor']) && empty($_SESSION['spot'])) {
                $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                redirect($redirect);
                exit();
            }

            // CHECK VENDOR CREDENTIALS
            $this->checkVendorCredentials($_SESSION['vendor']);

            $post = $this->input->post(null, true);

            $_SESSION['orderVendorId'] = $_SESSION['vendor']['vendorId'];
            if (!empty($post)) {
                unset($post['spotId']);
                $_SESSION['order'] = $post;
            }

            // needed for the first vesrion of th make_order
            $_SESSION['spotId'] = $_SESSION['spot']['spotId'];

            $data = [
                'spotId' => $_SESSION['spotId'],
                'vendor' =>  $_SESSION['vendor'],
                'orderDetails' => $_SESSION['order'],
                'buyerRole' => $this->config->item('buyer'),
                'usershorturl' => 'tiqs_shop_service',
                'salesagent' => $this->config->item('tiqsId'),
                // 'countries' => Country_helper::getCountries(),
                'countryCodes' => Country_helper::getCountryPhoneCodes(),
                'spot' => $_SESSION['spot'],
                'oldMakeOrderView' => $this->config->item('oldMakeOrderView'),
                'newMakeOrderView' => $this->config->item('newMakeOrderView'),
            ];
            $this->setDelayTime($data);

            $data['username'] = isset($_SESSION['postOrder']['user']['username']) ? $_SESSION['postOrder']['user']['username'] : get_cookie('userName');
            $data['email'] = isset($_SESSION['postOrder']['user']['email']) ? $_SESSION['postOrder']['user']['email'] : get_cookie('email');
            $data['mobile'] = isset($_SESSION['postOrder']['user']['mobile']) ? $_SESSION['postOrder']['user']['mobile'] : get_cookie('mobile');
            $data['userCountry'] = isset($_SESSION['postOrder']['user']['country']) ? $_SESSION['postOrder']['user']['country'] : '';
            $data['phoneCountryCode'] = isset($_SESSION['postOrder']['phoneCountryCode']) ? $_SESSION['postOrder']['phoneCountryCode'] : '';
            $data['termsAndConditions'] = isset($_SESSION['postOrder']['order']['termsAndConditions']) ? 'checked' : '';
            $data['privacyPolicy'] = isset($_SESSION['postOrder']['order']['privacyPolicy']) ? 'checked' : '';

            $data['city'] = isset($_SESSION['postOrder']['user']['city']) ? $_SESSION['postOrder']['user']['city'] : get_cookie('city');
            $data['zipcode'] = isset($_SESSION['postOrder']['user']['zipcode']) ? $_SESSION['postOrder']['user']['zipcode'] : get_cookie('zipcode');
            $data['address'] = isset($_SESSION['postOrder']['user']['address']) ? $_SESSION['postOrder']['user']['address'] : get_cookie('address');

            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        private function setDelayTime(array &$data) {
            if (intval($_SESSION['spot']['spotTypeId']) !== $this->config->item('local')) {
                $workingTime = $this->shopspottime_model->setProperty('spotId', $_SESSION['spotId'])->fetchWorkingTime();
                if ($workingTime) {
                    $data['workingTime'] = Utility_helper::convertDayToDate($workingTime, 'day');
                    $data['spotType'] = (intval($data['spot']) === $this->config->item('deliveryType')) ? 'delivery' : 'pickup';

                    if ($_SESSION['vendor']['preferredView'] === $this->config->item('oldMakeOrderView')) {
                        $extendedIds = array_keys($_SESSION['order']);
                        $extendedIds = array_filter($extendedIds, function($i) {
                            if (is_int($i)) return $i;
                        });
                    } else {
                        $extendedIds = [];
                        foreach($_SESSION['order'] as $key => $product) {
                            array_push($extendedIds, array_keys($product)[0]);
                            $product = reset($product);
                            if (!empty($product['addons'])) {
                                $extendedIds = array_merge($extendedIds, array_keys($product['addons']));
                            }
                        }
                    }
                    $data['delayTime'] = $this->shoporder_model->returnDelayMinutes($extendedIds);
                    $data['busyTime'] = intval($_SESSION['vendor']['busyTime']);
                } else {
                    $redirect = 'spot_closed' . DIRECTORY_SEPARATOR  . $_SESSION['spotId'];
                    redirect($redirect);
                    return;
                }
            }
        }

        public function submitOrder(): void
        {
            if (empty($_POST) || empty($_SESSION['order']) || empty($_SESSION['vendor']) || empty($_SESSION['spotId']) || empty($_SESSION['spot'])) {
                $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                redirect($redirect);
                exit();
            }

            $_SESSION['postOrder'] = $this->input->post(null, true);
            if (!isset($_SESSION['postOrder']['order']['waiterTip'])) {
                $_SESSION['postOrder']['order']['waiterTip'] = 0;
            }

            set_cookie('userName', $_SESSION['postOrder']['user']['username'], (365 * 24 * 60 * 60));
            set_cookie('email', $_SESSION['postOrder']['user']['email'], (365 * 24 * 60 * 60));
            if (!empty($_SESSION['postOrder']['user']['mobile'])) {
                set_cookie('mobile', $_SESSION['postOrder']['user']['mobile'], (365 * 24 * 60 * 60));
            }
            if (!empty($_SESSION['postOrder']['user']['city'])) {
                set_cookie('city', $_SESSION['postOrder']['user']['city'], (365 * 24 * 60 * 60));
            }
            if (!empty($_SESSION['postOrder']['user']['zipcode'])) {
                set_cookie('zipcode', $_SESSION['postOrder']['user']['zipcode'], (365 * 24 * 60 * 60));
            }
            if (!empty($_SESSION['postOrder']['user']['address'])) {
                set_cookie('address', $_SESSION['postOrder']['user']['address'], (365 * 24 * 60 * 60));
            }

            redirect('pay_order');

            redirect('pay_order');
        }

        public function pay_order(): void
        {
            if (empty($_SESSION['order']) || empty($_SESSION['vendor']) || empty($_SESSION['postOrder']) || empty($_SESSION['spotId']) || empty($_SESSION['spot'])) {
                $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
                redirect($redirect);
                exit();
            }

            // if $_SESSION['voucherId'] and user refresh the page
            if (isset($_SESSION['voucherId'])) {
                unset($_SESSION['voucherId']);
            }
            // if $_SESSION['payWithVaucher'] and user refresh the page
            if (isset($_SESSION['payWithVaucher'])) {
                unset($_SESSION['payWithVaucher']);
            }

            // CHECK VENDOR CREDENTIALS
            $this->checkVendorCredentials($_SESSION['vendor']);

            $this->global['pageTitle'] = 'TIQS : PAY';

            $data = [
                'ordered'               => $_SESSION['order'],
                'vendor'                => $_SESSION['vendor'],
                'spot'                  => $_SESSION['spot'],
                'waiterTip'             => floatval($_SESSION['postOrder']['order']['waiterTip']),
                'idealPaymentType'      => $this->config->item('idealPaymentType'),
                'creditCardPaymentType' => $this->config->item('creditCardPaymentType'),
                'bancontactPaymentType' => $this->config->item('bancontactPaymentType'),
                'giroPaymentType'       => $this->config->item('giroPaymentType'),
                'payconiqPaymentType'   => $this->config->item('payconiqPaymentType'),
                'pinMachinePaymentType' => $this->config->item('pinMachinePaymentType'),
				'localType'             => $this->config->item('local'),
                'oldMakeOrderView'      => $this->config->item('oldMakeOrderView'),
                'newMakeOrderView'      => $this->config->item('newMakeOrderView'),
            ];

            $this->loadViews('publicorders/payOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function insertOrder($payNlPaymentTypeId, $paymentOptionSubId): void
        {
            $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
            if (empty($_SESSION['order']) || empty($_SESSION['vendor']) || empty($_SESSION['postOrder']) || empty($_SESSION['spotId']) || empty($_SESSION['spot'])) {                
                redirect($redirect);
                exit();
            }

            if ($payNlPaymentTypeId === $this->config->item('idealPaymentType')) {
                $payType = $this->config->item('idealPayment');
            } elseif ($payNlPaymentTypeId === $this->config->item('creditCardPaymentType')) {
                $payType = $this->config->item('creditCardPayment');
            } elseif ($payNlPaymentTypeId === $this->config->item('bancontactPaymentType')) {
                $payType = $this->config->item('bancontactPayment');
            } elseif ($payNlPaymentTypeId === $this->config->item('giroPaymentType')) {
                $payType = $this->config->item('giroPayment');
            } elseif ($payNlPaymentTypeId === $this->config->item('payconiqPaymentType')) {
                $payType = $this->config->item('payconiqPayment');
            } elseif ($payNlPaymentTypeId === $this->config->item('pinMachinePaymentType')) {
                $payType = $this->config->item('pinMachinePayment');
            } else {
                redirect($redirect);
                exit();
            }

            $this->insertOrderProcess($this->config->item('orderNotPaid'), $payType);

            $successRedirect = 'paymentengine' . DIRECTORY_SEPARATOR . $payNlPaymentTypeId  . DIRECTORY_SEPARATOR . $paymentOptionSubId;

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

            if (
                $vendor['requireReservation'] === '1' && ( empty($_SESSION['visitorReservationId']) || empty(get_cookie('visitorReservationId')) )
            ) {
                $_SESSION['comeFromAlfred'] = true;
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

        private function insertOrderProcess(string $payStatus, string $payType, int $voucherId = 0): void
        {
            //fetch data from $_SESSION
            $post = $_SESSION['postOrder'];

            $this->validateData($post);

            // insert buyer
            $this->user_model->manageAndSetBuyer($post['user']);
            if (!$this->user_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Email is mandatory field. Please try again');
                redirect('checkout_order');
                exit();
            }

            // prepare failed redirect
            $failedRedirect = 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'] . '&spotid=' . $_SESSION['spotId'];

            // insert order
            if (!empty($post['order']['date']) && !empty($post['order']['time'])) {
                $orderDate = explode(' ', $post['order']['date']);
                $post['order']['created'] = $orderDate[0] . ' ' . $post['order']['time'];
            }

            //set $post['order'] keys and value if whole or part of order is paid from wallet

            $post['order']['buyerId'] = $this->user_model->id;
            $post['order']['paid'] = $payStatus;
            $post['order']['paymentType'] = $payType;
            $post['order']['serviceTypeId'] = $_SESSION['spot']['spotTypeId'];

            if ($voucherId || isset($_SESSION['voucherId'])) {
                $payPartial = false;
                if (isset($_SESSION['voucherId'])) {
                    $voucherId = $_SESSION['voucherId'];
                    $payPartial = true;
                    unset($_SESSION['voucherId']);
                }
                $this->payOrderWithVoucher($voucherId, $post, $failedRedirect, $payPartial);
            }

            $this->shoporder_model->setObjectFromArray($post['order'])->create();

            if (!$this->shoporder_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect($failedRedirect);
                exit();
            }

            // insert order details
            if ($_SESSION['vendor']['preferredView'] === $this->config->item('oldMakeOrderView')) {
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
            } elseif ($_SESSION['vendor']['preferredView'] === $this->config->item('newMakeOrderView')) {
                $insertAll = [];
                foreach ($post['orderExtended'] as $details) {
                    $id = array_keys($details)[0];
                    $details = reset($details);
                    $details['quantity'] = intval($details['quantity']);

                    if (isset($details['remark'])) {
                        $insert['remark'] = $details['remark'];
                        $insert = [
                            'productsExtendedId' => intval($id),
                            'orderId' => $this->shoporder_model->id,
                            'quantity' => $details['quantity'],
                            'remark' => $details['remark'],
                        ];
                        if (!$this->shoporderex_model->setObjectFromArray($insert)->create()) {
                            $this->shoporderex_model->orderId = $insert['orderId'];
                            $this->shoporderex_model->deleteOrderDetails();
                            $this->shoporder_model->delete();
                            $this->session->set_flashdata('error', 'Order not made! Please try again');
                            redirect($failedRedirect);
                            exit();
                        }
                    } else {
                        if (!isset($insertAll[$id])) {
                            $insertAll[$id] = [
                                'productsExtendedId' => intval($id),
                                'orderId' => $this->shoporder_model->id,
                                'quantity' => $details['quantity'],
                            ];
                        } else {
                            $insertAll[$id]['quantity'] += $details['quantity'];
                        }
                    }
                }

                $insertValues = array_values($insertAll);
                if (!$this->shoporderex_model->multipleCreate($insertValues)) {
                    $this->shoporderex_model->orderId = $insert['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                    $this->session->set_flashdata('error', 'Order not made! Please try again');
                    redirect($failedRedirect);
                    exit();
                }
            }

            // save orderId in SESSION
            $_SESSION['orderId'] = $this->shoporder_model->id;
        }

        public function cashPayment($payStatus, $payType): void
        {
            $this->insertOrderProcess($payStatus, $payType);
            $redirect =  ($_SESSION['vendor']['vendorId'] === 1162 || $_SESSION['vendor']['vendorId'] === 5655 ) ?  'successth' : 'success';
            // peter  change
			//            var_dump($redirect);
			//            die();
            Utility_helper::unsetPaymentSession();
            redirect($redirect);
        }

        public function voucherPayment($voucherId): void
        {
            $voucherId = intval($voucherId);
            $this->insertOrderProcess($this->config->item('orderNotPaid'), $this->config->item('voucherPayment'), $voucherId);
            $redirect =  ($_SESSION['vendor']['vendorId'] === 1162 || $_SESSION['vendor']['vendorId'] === 5655 ) ?  'successth' : 'success';
            Utility_helper::unsetPaymentSession();
            redirect($redirect);
        }

        private function payOrderWithVoucher(int $voucherId, array &$post, string $failedRedirect, bool $payPartial): void
        {
            $checkAmount = (isset($_SESSION['payWithVaucher'])) ? $_SESSION['payWithVaucher'] : floatval($post['order']['amount']);
            $voucherAmount = $this->shopvoucher_model->setObjectId($voucherId)->setVoucher()->payOrderWithVoucher($checkAmount, $payPartial);

            if (isset($_SESSION['payWithVaucher'])) {
                unset($_SESSION['payWithVaucher']);
            }

            if ($voucherAmount) {
                if (
                    $checkAmount === floatval($post['order']['amount'])
                    && ($this->shopvoucher_model->percent === 100 || $voucherAmount >= $post['order']['amount'])
                ) {
                    $post['order']['serviceFee'] = 0;
                }

                $post['order']['voucherId'] = $voucherId;
                $post['order']['voucherAmount'] = $voucherAmount;
                $post['order']['paid'] = $payPartial ? $this->config->item('orderNotPaid') : $this->config->item('orderPaid');
                $post['order']['paymentType'] = $payPartial ? $post['order']['paymentType'] . ' / ' . $this->config->item('voucherPayment') : $this->config->item('voucherPayment');
            } else {
                $this->session->set_flashdata('error', 'Order not made! Not enough funds on voucher');
                redirect($failedRedirect);
            }
        }

        private function validateData(array &$post): void
        {
            // check pickup period and time for pickup and delivery
            if (intval($_SESSION['spot']['spotTypeId']) !== $this->config->item('local')) {
                if (empty($post['order']['date']) || empty($post['order']['time'])) {
                    $this->session->set_flashdata('error', 'Order not made! Please select pickup period and time');
                    redirect('checkout_order');
                    exit();
                }
            }

            // check city, zipcode and addressfor delivery
            if (intval($_SESSION['spot']['spotTypeId']) === $this->config->item('deliveryType')) {
                if (empty($post['user']['city']) || empty($post['user']['zipcode']) || empty($post['user']['address'])) {
                    $this->session->set_flashdata('error', 'Order not made! Please insert delivery city, zipcode and address');
                    redirect('checkout_order');
                    exit();
                }
            }

            if ($_SESSION['vendor']['termsAndConditions'] && $_SESSION['vendor']['showTermsAndPrivacy'] === '1' && (empty($post['order']['termsAndConditions']) || empty($post['order']['privacyPolicy']))) {
                $this->session->set_flashdata('error', 'Order not made! Please confirm that you read terms and conditions and privacy policy');
                    redirect('checkout_order');
            }

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
            return;
        }
    }
