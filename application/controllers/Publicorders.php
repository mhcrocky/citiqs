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
            $this->load->helper('jwt_helper');

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
            $this->load->model('shopsession_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));


            $this->load->library('session');
        }

        // MAKE ORDER VIEW
        public function index(): void
        {
            $get = Utility_helper::sanitizeGet();
            $spotId = empty($get['spotid']) ? 0 : intval($get['spotid']);
            $vendor = $this->shopvendor_model->setProperty('vendorId', $get['vendorid'])->getVendorData();

            $this->global[$this->config->item('design')] = (!empty($vendor['design'])) ? unserialize($vendor['design']) : null;

            if ($spotId && $vendor) {
                $orderDataRandomKey = empty($get[$this->config->item('orderDataGetKey')]) ? '' : $get[$this->config->item('orderDataGetKey')];
                $this->checkSpot($spotId, $vendor, $orderDataRandomKey);
            } elseif ($vendor) {
                $typeId = empty($get['typeid']) ? 0 : intval($get['typeid']);
                $this->loadVendorView($typeId, $vendor);
            } else {
                redirect(base_url());
            }

            return;
        }

        private function checkSpot(int $spotId, array $vendor, string $orderDataRandomKey): void
        {
            $vendorId = intval($vendor['vendorId']);
            $spot = $this->shopspot_model->fetchSpot($vendorId, $spotId);

            if ($spot) {
                $this->loadSpotView($spot, $vendor, $orderDataRandomKey);
                return;
            } else {
                $redirect = 'make_order?vendorid=' . $vendorId;
                redirect($redirect);
                exit();
            }
        }

        private function loadSpotView(array $spot, array $vendor, string $orderDataRandomKey): void
        {
            $spotId = intval($spot['spotId']);
            $spotTypeId = intval($spot['spotTypeId']);
            $time = time();

            $this->checkVendorCredentials($vendor, $spotTypeId);
            $this->isLocalSpotOpen($spotTypeId, $spotId);

            $this->global['pageTitle'] = 'TIQS : ORDERING';

            $data = [
                'spotId' => $spotId,
                'day' => date('D', $time),
                'hours' => strtotime(date('H:i:s', $time)),
                'vendor' => $vendor,
                'spotTypeId'  => $spotTypeId,
                'localTypeId' => $this->config->item('local'),
                'termsAndConditions' => $vendor['termsAndConditions'],
                'uploadProductImageFolder' => $this->config->item('uploadProductImageFolder'),
                'defaultProductsImages' => $this->config->item('defaultProductsImages'),
                'orderDataRandomKey' => $orderDataRandomKey,
                'orderDataGetKey' => $this->config->item('orderDataGetKey'),
            ];

            $preferedView = $this->getPreferedView($data, $spot, $vendor, $orderDataRandomKey);

            $this->loadViews($preferedView, $this->global, $data, null, 'headerWarehousePublic');
            return;
        }

        private function loadVendorView(int $typeId, array $vendor): void
        {
            $types = Utility_helper::resetArrayByKeyMultiple($vendor['typeData'], 'active');

            if (empty($types[1])) {
                $data = [
                    'vendor' => $vendor,
                    'spots' => []
                ];
                $this->loadViews('publicorders/selectType', $this->global, $data, null, 'headerWarehousePublic');
            } elseif ($typeId) {
                $this->checkVendorCredentials($vendor, $typeId);
                $this->loadSelectSpotView($vendor, $typeId);
            } elseif (count($types[1]) === 1) {
                $redirect = base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&typeid=' . $types[1]['0']['typeId'];
                redirect($redirect);
            } else {
                $data = [
                    'vendor' => $vendor,
                    'activeTypes' => $types[1],
                ];

                $this->global['pageTitle'] = 'TIQS : SELECT TYPE';
                $this->loadViews('publicorders/selectType', $this->global, $data, null, 'headerWarehousePublic');
            }

            return;
        }

        private function loadSelectSpotView(array $vendor, int $typeId): void
        {
            $where = [
                'tbl_shop_printers.userId=' => $vendor['vendorId'],
                'tbl_shop_spots.active' => '1',
                'tbl_shop_spots.spotTypeId' => $typeId,
            ];
            $spots = $this->shopspot_model->fetchUserSpotsImporved($where);

            if (!empty($spots) && count($spots) === 1) {
                $redirect = base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spots[0]['spotId'];
                redirect($redirect);
            }
            $data = [
                'vendor' => $vendor,
                'spots' => $spots,
                'local' => $this->config->item('local'),
                'typeId' => $where['tbl_shop_spots.spotTypeId']
            ];

            $this->global['pageTitle'] = 'TIQS : SELECT SPOT';
            $this->loadViews('publicorders/selectSpot', $this->global, $data, null, 'headerWarehousePublic');
            return;
        }

        private function isLocalSpotOpen(int $spotTypeId, int $spotId)
        {
            if (
                $spotTypeId === $this->config->item('local')
                && !$this->shopspottime_model->setProperty('spotId', $spotId)->isOpen()
            ) {
                $redirect = 'spot_closed' . DIRECTORY_SEPARATOR  . $spotId;
                redirect($redirect);
                return;
            };
        }

        private function getPreferedView(array &$data, array $spot, array $vendor, string $orderDataRandomKey): string
        {
            $vendorId = $vendor['vendorId'];
            $spotId = intval($spot['spotId']);
            $ordered = $this->fetchAndChekOrdered($orderDataRandomKey, $vendorId, $spotId);

            if ($vendor['preferredView'] === $this->config->item('oldMakeOrderView')) {
                $data['categoryProducts'] = $this->shopproductex_model->getUserProductsPublic($vendorId);
                $data['ordered'] =  $ordered;
                $preferedView = 'publicorders/makeOrder';
            } elseif ($vendor['preferredView'] === $this->config->item('newMakeOrderView')) {
                $allProducts = $this->shopproductex_model->getMainProductsOnBuyerSide($vendorId, $spot);
                if ($allProducts) {
                    $data['mainProducts'] = $allProducts['main'];
                    $data['addons'] = $allProducts['addons'];
                    $data['returnCategorySlide'] = isset($_GET['category']) ? $_GET['category'] : null;
                    $data['maxRemarkLength'] = $this->config->item('maxRemarkLength');

                    if ($ordered) {
                        $ordered = Utility_helper::returnMakeNewOrderElements($ordered, $data['vendor'], $data['mainProducts'], $data['addons'], $data['maxRemarkLength']);
                        $data['checkoutList'] = $ordered['checkoutList'];
                    } else {
                        $data['checkoutList'] = '';
                    }

                }
                $preferedView = 'publicorders/makeOrderNew';
            }

            return $preferedView;
        }

        private function fetchAndChekOrdered(string $orderDataRandomKey, int $vendorId, int $spotId): ?array
        {
            
            if (empty($orderDataRandomKey)) return null;

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderDataRandomKey)->getArrayOrderDetails();

            Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId']);

            if ($orderData['vendorId'] !== $vendorId || $orderData['spotId'] !== $spotId) redirect(base_url());

            return (empty($orderData['makeOrder'])) ? null : $orderData['makeOrder'];
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

        public function closed($vendorId): void
        {
            if ($this->shopvendortime_model->setProperty('vendorId', $vendorId)->isOpen()) {
                $redirect = 'make_order?vendorid=' . $vendorId;
                redirect($redirect);
                return;
            };

            $data = [
                'vendor' => $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData()
            ];
            $workingTime = $this->shopvendortime_model->setProperty('vendorId', $vendorId)->fetchWorkingTime();
            $data['workingTime'] = $workingTime ? Utility_helper::resetArrayByKeyMultiple($workingTime, 'day') : null;

            $this->global['pageTitle'] = 'TIQS : CLOSED';
            $this->global[$this->config->item('design')] = (!empty($data['vendor']['design'])) ? unserialize($data['vendor']['design']) : null;

            $this->loadViews('publicorders/closed', $this->global, $data, null, 'headerWarehousePublic');
        }
        // CHECKOUT ORDER

        // TO DO !!!!!!!!!!!!!
        // public function oldMakeNedOrderView()
        // {
        //     $post = $this->input->post(null, true);

        //     $_SESSION['orderVendorId'] = $_SESSION['vendor']['vendorId'];
        //     if (!empty($post)) {
        //         unset($post['spotId']);
        //         $_SESSION['order'] = $post;
        //     }
        // }

        public function checkout_order(): void
        {
            $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

            if (empty($orderRandomKey)) redirect(base_url());

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

            Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder']);

            $data = [
                'orderRandomKey'    => $orderRandomKey,
                'orderDetails'      => $orderData['makeOrder'],
                'spotId'            => $orderData['spotId'],
                'vendor'            => $this->shopvendor_model->setProperty('vendorId', $orderData['vendorId'])->getVendorData(),
                'spot'              => $this->shopspot_model->fetchSpot($orderData['vendorId'], $orderData['spotId']),
                'oldMakeOrderView'  => $this->config->item('oldMakeOrderView'),
                'newMakeOrderView'  => $this->config->item('newMakeOrderView'),
                'buyerRole'         => $this->config->item('buyer'),
                'salesagent'        => $this->config->item('tiqsId'),
                'local'             => $this->config->item('local'),
                'buyershorturl'     => $this->config->item('buyershorturl'),
                'countryCodes'      => Country_helper::getCountryPhoneCodes(),
                'orderDataGetKey'   => $this->config->item('orderDataGetKey'),
                'maxRemarkLength'   => $this->config->item('maxRemarkLength'),
                'pickupTypeId'      => $this->config->item('pickupType'),
            ];

            $this->checkVendorCredentials( $data['vendor'], intval($data['spot']['spotTypeId']) );
            $this->setOrderData($data, $orderData);
            $this->setDelayTime($data);
            $this->setFeeValues($data);

            $this->global['pageTitle'] = 'TIQS : CHECKOUT';
            $this->global[$this->config->item('design')] = (!empty($data['vendor']['design'])) ? unserialize($data['vendor']['design']) : null;
            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        private function setOrderData(array &$data, array $orderData): void
        {
            $data['termsAndConditions'] = isset($orderData['order']['termsAndConditions']) ? 'checked' : '';
            $data['privacyPolicy'] = isset($orderData['order']['privacyPolicy']) ? 'checked' : '';
            $data['waiterTip'] = isset($orderData['order']['waiterTip']) ? floatval($orderData['order']['waiterTip']) : 0;

            $data['city'] = isset($orderData['user']['city']) ? $orderData['user']['city'] : get_cookie('city');
            $data['zipcode'] = isset($orderData['user']['zipcode']) ? $orderData['user']['zipcode'] : get_cookie('zipcode');
            $data['address'] = isset($orderData['user']['address']) ? $orderData['user']['address'] : get_cookie('address');
        }

        private function setDelayTime(array &$data)
        {
            if (intval($data['spot']['spotTypeId']) !== $this->config->item('local')) {
                $workingTime = $this->shopspottime_model->setProperty('spotId', $data['spotId'])->fetchWorkingTime();
                if ($workingTime) {
                    $data['workingTime'] = Utility_helper::convertDayToDate($workingTime, 'day');
                    $data['spotType'] = (intval($data['spot']) === $this->config->item('deliveryType')) ? 'delivery' : 'pickup';

                    if ($data['vendor']['preferredView'] === $this->config->item('oldMakeOrderView')) {
                        $extendedIds = array_keys($data['orderDetails']);
                        $extendedIds = array_filter($extendedIds, function($i) {
                            if (is_int($i)) return $i;
                        });
                    } else {
                        $extendedIds = [];
                        foreach($data['orderDetails'] as $key => $product) {
                            array_push($extendedIds, array_keys($product)[0]);
                            $product = reset($product);
                            if (!empty($product['addons'])) {
                                $extendedIds = array_merge($extendedIds, array_keys($product['addons']));
                            }
                        }
                    }
                    $data['delayTime'] = $this->shoporder_model->returnDelayMinutes($extendedIds);
                    $data['busyTime'] = intval($data['vendor']['busyTime']);
                } else {
                    $redirect = 'spot_closed' . DIRECTORY_SEPARATOR  . $data['spotId'];
                    redirect($redirect);
                    return;
                }
            }
        }

        private function setFeeValues(array &$data)
        {
            $spotTypeId = intval($data['spot']['spotTypeId']);

            if ($spotTypeId === $this->config->item('local')) {
                $data['serviceFeePercent'] = $data['vendor']['serviceFeePercent'];
                $data['serviceFeeAmount'] = $data['vendor']['serviceFeeAmount'];
                $data['minimumOrderFee'] = $data['vendor']['minimumOrderFee'];
            } elseif ($spotTypeId === $this->config->item('deliveryType')) {
                $data['serviceFeePercent'] = $data['vendor']['deliveryServiceFeePercent'];
                $data['serviceFeeAmount'] = $data['vendor']['deliveryServiceFeeAmount'];
                $data['minimumOrderFee'] = $data['vendor']['deliveryMinimumOrderFee'];
            } elseif ($spotTypeId === $this->config->item('pickupType')) {
                $data['serviceFeePercent'] = $data['vendor']['pickupServiceFeePercent'];
                $data['serviceFeeAmount'] = $data['vendor']['pickupServiceFeeAmount'];
                $data['minimumOrderFee'] = $data['vendor']['pickupMinimumOrderFee'];
            }
        }

        // BUYER DATA
        public function buyer_details(): void
        {
            $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

            if (empty($orderRandomKey)) redirect(base_url());

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

            Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);

            $data = [];
            $data['vendor'] = $this->shopvendor_model->setProperty('vendorId', $orderData['vendorId'])->getVendorData();
            $data['spot'] = $this->shopspot_model->fetchSpot($orderData['vendorId'], $orderData['spotId']);
            $data['username'] = get_cookie('userName');
            $data['email'] = get_cookie('email');
            $data['mobile'] = get_cookie('mobile');
            $data['userCountry'] = isset($orderData['user']['country']) ? $orderData['user']['country'] : '';
            $data['phoneCountryCode'] = isset($orderData['phoneCountryCode']) ? $orderData['phoneCountryCode'] : '';
            $data['countryCodes'] = Country_helper::getCountryPhoneCodes();
            $data['minMobileLength'] = $this->config->item('minMobileLength');
            $data['local'] = $this->config->item('local');
            $data['orderRandomKey'] = $orderRandomKey;
            $data['orderDataGetKey'] = $this->config->item('orderDataGetKey');

            $this->global['pageTitle'] = 'TIQS : BUYER DETAILS';
            $this->global[$this->config->item('design')] = (!empty($data['vendor']['design'])) ? unserialize($data['vendor']['design']) : null;
            $this->loadViews('publicorders/buyerDetails', $this->global, $data, null, 'headerWarehousePublic');
        }

        // PAY ORDER
        public function pay_order(): void
        {
            $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

            if (empty($orderRandomKey)) redirect(base_url());

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

            Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);
            
            $vendor = $this->shopvendor_model->setProperty('vendorId', $orderData['vendorId'])->getVendorData();
            $spot = $this->shopspot_model->fetchSpot($orderData['vendorId'], $orderData['spotId']);
            $spotTypeId = intval($spot['spotTypeId']);

            $this->checkVendorCredentials($vendor, $spotTypeId);

            // if $orderData['voucherId'] and $orderData['payWithVaucher'] unset on refresh page
            Jwt_helper::unsetVoucherData($orderData, $orderRandomKey);

            $data = [
                'vendor'                => $vendor,
                'spot'                  => $spot,
                'waiterTip'             => floatval($orderData['order']['waiterTip']),
                'amount'                => floatval($orderData['order']['amount']),
                'serviceFee'            => floatval($orderData['order']['serviceFee']),
                'idealPaymentType'      => $this->config->item('idealPaymentType'),
                'creditCardPaymentType' => $this->config->item('creditCardPaymentType'),
                'bancontactPaymentType' => $this->config->item('bancontactPaymentType'),
                'giroPaymentType'       => $this->config->item('giroPaymentType'),
                'payconiqPaymentType'   => $this->config->item('payconiqPaymentType'),
                'pinMachinePaymentType' => $this->config->item('pinMachinePaymentType'),
				'localType'             => $this->config->item('local'),
                'oldMakeOrderView'      => $this->config->item('oldMakeOrderView'),
                'newMakeOrderView'      => $this->config->item('newMakeOrderView'),
                'redirect'              => $this->getRedirect($vendor, $spotTypeId, $orderRandomKey),
                'orderRandomKey'        => $orderRandomKey,
                'orderDataGetKey'       => $this->config->item('orderDataGetKey'),
                'orderRandomKey'        => $orderRandomKey,
            ];

            $this->global['pageTitle'] = 'TIQS : PAY';
            $this->global[$this->config->item('design')] = (!empty($data['vendor']['design'])) ? unserialize($data['vendor']['design']) : null;
            $this->loadViews('publicorders/payOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        private function getRedirect(array $vendor, int $spotTypeId, string $orderRandomKey): string
        {
            if (
                $vendor['requireEmail'] === '0'
                && $vendor['requireName'] === '0'
                && $vendor['requireMobile'] === '0'
                && $spotTypeId === $this->config->item('local')
            ) {
                $redirect = 'checkout_order?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
            } else {
                $redirect = 'buyer_details?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
            };
    
            return $redirect;
        }

        private function checkVendorCredentials(array $vendor, int $spotTypeId): void
        {
            if (empty($vendor['payNlServiceId'])) {
                redirect(base_url());
                exit();
            }

            if (!$spotTypeId || $spotTypeId !== $this->config->item('local')) return;

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

    }
