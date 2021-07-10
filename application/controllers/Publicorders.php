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
            $this->load->helper('fod_helper');
            $this->load->helper('language_helper');

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
            $this->load->model('fodfdm_model');
            $this->load->model('shopprinters_model');
            $this->load->model('shopvendortemplate_model');
            $this->load->model('shoppaymentmethods_model');
            $this->load->model('shopcategorytime_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');
        }

        private function checkDataFromGet(): void
        {
            if (
                (empty($_GET['vendorid']) && !ctype_digit($_GET['vendorid']))
                || (isset($_GET['spotid']) && !ctype_digit($_GET['spotid']))
                || (isset($_GET['category']) && !ctype_digit($_GET['category']))
                || (isset($_GET['typeid']) && !ctype_digit($_GET['typeid']))
            ) {
                redirect(base_url(). 'places');
                exit;
            }
            return;
        }

        // MAKE ORDER VIEW
        public function index(): void
        {
            $this->checkDataFromGet();
            $get = Utility_helper::sanitizeGet();
            $spotId = empty($get['spotid']) ? 0 : intval($get['spotid']);
            $vendor = $this->shopvendor_model->setProperty('vendorId', $get['vendorid'])->getVendorData();
            

            if (is_null($vendor)) {
                redirect(base_url(). 'places');
            }

            $this->setGlobalDesign($vendor['design']);
            $this->setGlobalVendor($vendor);
            $this->isVendorClosed($vendor);

            if ($spotId && $vendor) {
                $orderDataRandomKey = empty($get[$this->config->item('orderDataGetKey')]) ? '' : $get[$this->config->item('orderDataGetKey')];
                $this->checkSpot($spotId, $vendor, $orderDataRandomKey);
            } elseif ($vendor) {
                empty($get['typeid']) ? $this->loadVendorView($vendor) : $this->loadVendorView($vendor, intval($get['typeid']));
            } else {
                redirect(base_url(). 'places');
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
            // $spotPrinterId = intval($spot['spotPrinterId']);

            $this->checkVendorCredentials($vendor, $spotTypeId);
            $this->isLocalSpotOpen($spotTypeId, $spotId);
            // $this->isFodLocked($spotPrinterId);
            $this->isFodActive($vendor['vendorId'], $spotId);
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
                'baseUrl' => base_url(),
                'categoriesImages' => $this->shopcategory_model->setProperty('userId', $vendor['vendorId'])->getImages(),
                'categoriesImagesRelPath' => base_url() . $this->config->item('categoriesImagesRelPath'),
            ];

            $preferedView = $this->getPreferedView($data, $spot, $vendor, $orderDataRandomKey);

            // filter categories by time
            // it is better TO DO here, not on querr to cover case when user (after som time) click back in browser
            $this->chcekCategoriesTimes($data);

            if ($vendor['preferredView'] === $this->config->item('view2021')) {
                $this->loadViews($preferedView, $this->global, $data, 'footer2021', 'header2021');
            } else {
                $this->loadViews($preferedView, $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendor['vendorId']));
            }
            return;
        }

        private function chcekCategoriesTimes(array &$data): void
        {
            if (!empty($data['mainProducts'])) {
                foreach ($data['mainProducts'] as $categoryName => $details) {
                    $categoryId = intval($details[0]['categoryId']);
                    if (!$this->shopcategorytime_model->setProperty('categoryId', $categoryId)->isCategoryOpen()) {
                        unset($data['mainProducts'][$categoryName]);
                    }
                }
            }

            return;
        }

        private function loadVendorView(array $vendor, int $typeId = 0): void
        {;
            if ($typeId) {
                $this->checkVendorCredentials($vendor, $typeId);
                $this->loadSelectSpotView($vendor, $typeId);
                return;
            }

            $activeTypes = $this->filterShopTypes($vendor['typeData'], $vendor['vendorId']);
            if (count($activeTypes) === 1) {
                $typeId = reset($activeTypes)['typeId'];
                $redirect = base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&typeid=' . $typeId;
                redirect($redirect);
            } else {
                $data = [
                    'vendor' => $vendor,
                    'activeTypes' => $activeTypes,
                ];

                $this->global['pageTitle'] = 'TIQS : SELECT TYPE';
                $this->loadViews('publicorders/selectType', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendor['vendorId']));
            }

            return;
        }

        private function filterShopTypes(array $types, int $vendorId)
        {
            $where = [
                'tbl_shop_printers.userId' => $vendorId,
                'tbl_shop_spots.active' => '1',
                'tbl_shop_spots.archived' => '0',
                'tbl_shop_spots.isApi' => '0'
            ];

            return array_filter($types, function($type) use($where) {
                $where['tbl_shop_spots.spotTypeId'] = $type['typeId'];                
                if ($this->shopspot_model->hasTypeActiveSpots($where)) {
                    return ($type);
                };
            });
        }

        private function loadSelectSpotView(array $vendor, int $typeId): void
        {
            $where = [
                'tbl_shop_printers.userId=' => $vendor['vendorId'],
                'tbl_shop_spots.active' => '1',
                'tbl_shop_spots.spotTypeId' => $typeId,
                'tbl_shop_spots.archived' => '0',
                'tbl_shop_spots.isApi' => '0'
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
            $this->loadViews('publicorders/selectSpot', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendor['vendorId']));
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

        // private function isFodLocked(int $spotPrinterId): void
        // {
        //     $isHardLock = $this->shopprinters_model->setObjectId($spotPrinterId)->getProperty('isFodHardLock');
        //     if (!intval($isHardLock)) return;

        //     $isAactive = $this->fodfdm_model->setProperty('printer_id', $spotPrinterId)->isActive();
        //     if ($isAactive) return;

        //     $vendorId = $this->shopprinters_model->setObjectId($spotPrinterId)->getProperty('userId');
        //     $redirect = base_url() . $this->config->item('fodInActive') . DIRECTORY_SEPARATOR . $vendorId;
        //     redirect($redirect);
        // }

        private function isFodActive(int $vendorId, int $spotId): void
        {
            if (!Fod_helper::isFodActive($vendorId, $spotId)) {
                $redirect = base_url() . $this->config->item('fodInActive') . DIRECTORY_SEPARATOR . $vendorId . DIRECTORY_SEPARATOR . $spotId;                
                redirect($redirect);
            }
        }
        
        private function getPreferedView(array &$data, array $spot, array $vendor, string $orderDataRandomKey): string
        {
            $vendorId = $vendor['vendorId'];
            $spotId = intval($spot['spotId']);
            $storedData = Jwt_helper::fetch($orderDataRandomKey, $vendorId, $spotId, ['vendorId', 'spotId']);
            $ordered = (empty($storedData['makeOrder'])) ? null : $storedData['makeOrder'];
            $openCategory = (empty($storedData['openCategory'])) ? 0 : $storedData['openCategory'];

            if ($vendor['preferredView'] === $this->config->item('oldMakeOrderView')) {
                $data['categoryProducts'] = $this->shopproductex_model->getUserProductsPublic($vendorId);
                $data['ordered'] =  $ordered;
                $preferedView = 'publicorders/makeOrder';
            } else {
                $allProducts = $this->shopproductex_model->getMainProductsOnBuyerSide($vendorId, $spot);
                if ($allProducts) {
                    $data['mainProducts'] = $allProducts['main'];
                    $data['addons'] = $allProducts['addons'];
                    $data['returnCategorySlide'] = isset($_GET['category']) ? $_GET['category'] : null;
                    $data['maxRemarkLength'] = $this->config->item('maxRemarkLength');
                    $data['openCategory'] = $openCategory;
                    $data['categories'] = array_keys($allProducts['main']);

                    if ($ordered) {
                        $ordered = Utility_helper::returnMakeNewOrderElements($ordered, $data['vendor'], $data['mainProducts'], $data['addons'], $data['maxRemarkLength']);
                        $data['checkoutList'] = $ordered['checkoutList'];
                    } else {
                        $data['checkoutList'] = '';
                    }

                }

                if ($vendor['preferredView'] === $this->config->item('newMakeOrderView')) {
                    $preferedView = 'publicorders/makeOrderNew';
                } elseif ($vendor['preferredView'] === $this->config->item('view2021')) {
                    $preferedView = 'publicorders/makeOrder2021';
                }
            }

            return $preferedView;
        }

        public function spotClosed($spotId): void
        {
            if (!ctype_digit($spotId)) redirect(base_url());

            $spotId = intval($spotId);
            $spot =  $this->shopspot_model->setObjectId($spotId)->setObject();
            $vendorId = intval($this->shopprinters_model->setObjectid($spot->printerId)->getProperty('userId'));

            if ($this->shopspottime_model->setProperty('spotId', $spotId)->isOpen()) {
                $redirect = 'make_order?vendorid=' . $vendorId . '&spotid=' . $spotId;
                redirect($redirect);
                return;
            };
            
            $data = [
                'vendor' => $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData(),
                'spot' => $spot,
            ];

            $workingTime = $this->shopspottime_model->setProperty('spotId', $spotId)->fetchWorkingTime();
            $data['workingTime'] = $workingTime ? Utility_helper::resetArrayByKeyMultiple($workingTime, 'day') : null;

            $this->global['pageTitle'] = 'TIQS : CLOSED';
            $this->setGlobalDesign($data['vendor']['design']);
            $this->setGlobalVendor($data['vendor']);
            $this->loadViews('publicorders/spotClosed', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendorId));
        }

        public function temporarilyClosed($vendorId, $spotId): void
        {
            $vendorId = intval($vendorId);
            if (Fod_helper::isFodActive(intval($vendorId), intval($spotId))) {
                $redirect = base_url() . 'make_order?vendorid=' . $vendorId . '&spotid=' . $spotId;
                redirect($redirect);
            }

            $data = [
                'vendor' => $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData(),
                'spotId' => $spotId,
            ];

            $this->global['pageTitle'] = 'TIQS : CLOSED';
            $this->setGlobalDesign($data['vendor']['design']);
            $this->setGlobalVendor($data['vendor']);
            $this->loadViews('publicorders/temporarilyClosed', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendorId));
        }

        public function closed(string $vendorId): void
        {
            if (!ctype_digit($vendorId)) redirect(base_url());

            $vendorId = intval($vendorId);
            $vendor = $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData();
            $isClosedPeriod = ($vendor['nonWorkFrom'] && $vendor['nonWorkTo'] && date('Y-m-d') >= $vendor['nonWorkFrom'] && date('Y-m-d') <= $vendor['nonWorkTo']);
            $isOpenTime = $this->shopvendortime_model->setProperty('vendorId', $vendorId)->isOpen();
            
            if ($isOpenTime && !$isClosedPeriod) {
                $redirect = 'make_order?vendorid=' . $vendorId;
                redirect($redirect);
                return;
            };

            $data = [
                'vendor' => $vendor,
                'isClosedPeriod' => $isClosedPeriod,
                'isOpenTime' => $isOpenTime,
            ];
            $workingTime = $this->shopvendortime_model->setProperty('vendorId', $vendorId)->fetchWorkingTime();
            $data['workingTime'] = $workingTime ? Utility_helper::resetArrayByKeyMultiple($workingTime, 'day') : null;

            $this->global['pageTitle'] = 'TIQS : CLOSED';
            $this->setGlobalDesign($data['vendor']['design']);
            $this->setGlobalVendor($data['vendor']);
            $this->loadViews('publicorders/closed', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendorId));
        }
        // CHECKOUT ORDER

        public function checkout_order(): void
        {
            $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

            if (empty($orderRandomKey)) redirect(base_url());

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
            Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder']);
            $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

            $data = [
                'orderRandomKey'    => $orderRandomKey,
                'orderDetails'      => $orderData['makeOrder'],
                'spotId'            => $orderData['spotId'],
                'vendor'            => $this->shopvendor_model->setProperty('vendorId', $orderData['vendorId'])->getVendorData(),
                'spot'              => $this->shopspot_model->fetchSpot($orderData['vendorId'], $orderData['spotId']),
                'oldMakeOrderView'  => $this->config->item('oldMakeOrderView'),
                'newMakeOrderView'  => $this->config->item('newMakeOrderView'),
                'buyerRole'         => $this->config->item('buyer'),
                'salesagent'        => $this->config->item('defaultSalesAgentId'),
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
            $this->setBuyerSideFee($data);

            $vendorId = intval($orderData['vendorId']);

            $this->global['pageTitle'] = 'TIQS : CHECKOUT';
            $this->setGlobalDesign($data['vendor']['design']);
            $this->setGlobalVendor($data['vendor']);
            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendorId));
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

        private function setDelayTime(array &$data): void
        {
            if (intval($data['spot']['spotTypeId']) !== $this->config->item('local')) {
                $workingTime = $this->shopspottime_model->setProperty('spotId', $data['spotId'])->fetchWorkingTime();
                if ($workingTime) {
                    $data['workingTime'] = Utility_helper::convertDayToDate($workingTime, 'day', $data['vendor']['nonWorkFrom'], $data['vendor']['nonWorkTo'], $data['vendor']['pickupDeliveryWeeks']);
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

        private function setBuyerSideFee(array &$data): void
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
            return;
        }


        // BUYER DATA
        public function buyer_details(): void
        {
            $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

            if (empty($orderRandomKey)) redirect(base_url());

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
            Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);
            $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

            $data = [];
            $data['vendor'] = $this->shopvendor_model->setProperty('vendorId', $orderData['vendorId'])->getVendorData();
            $data['spot'] = $this->shopspot_model->fetchSpot($orderData['vendorId'], $orderData['spotId']);
            $data['spotId'] = $orderData['spotId'];
            $data['username'] = !empty($orderData['user']['username']) ? $orderData['user']['username'] : get_cookie('username');
            $data['email'] = !empty($orderData['user']['email']) ? $orderData['user']['email'] : get_cookie('email');
            $data['mobile'] = !empty($orderData['user']['mobile']) ? $orderData['user']['mobile'] : get_cookie('mobile');
            $data['userCountry'] = isset($orderData['user']['country']) ? $orderData['user']['country'] : '';
            $data['phoneCountryCode'] = isset($orderData['phoneCountryCode']) ? $orderData['phoneCountryCode'] : get_cookie('phoneCountryCode');
            $data['countryCodes'] = Country_helper::getCountryPhoneCodes();
            $data['minMobileLength'] = $this->config->item('minMobileLength');
            $data['local'] = $this->config->item('local');
            $data['orderRandomKey'] = $orderRandomKey;
            $data['orderDataGetKey'] = $this->config->item('orderDataGetKey');

            $vendorId = intval($orderData['vendorId']);

            $this->global['pageTitle'] = 'TIQS : BUYER DETAILS';
            $this->setGlobalDesign($data['vendor']['design']);
            $this->setGlobalVendor($data['vendor']);
            $this->loadViews('publicorders/buyerDetails', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendorId));
        }

        // PAY ORDER
        public function pay_order(): void
        {
            $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

            if (empty($orderRandomKey)) redirect(base_url());

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
            Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);
            $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

            $vendor = $this->shopvendor_model->setProperty('vendorId', $orderData['vendorId'])->getVendorData();
            $spot = $this->shopspot_model->fetchSpot($orderData['vendorId'], $orderData['spotId']);
            $spotTypeId = intval($spot['spotTypeId']);

            $this->checkVendorCredentials($vendor, $spotTypeId);

            // if $orderData['voucherId'] and $orderData['payWithVaucher'] unset on refresh page
            Jwt_helper::unsetVoucherData($orderData, $orderRandomKey);

            $paymentMethods = $this
                                ->shoppaymentmethods_model
                                ->setProperty('vendorId', $orderData['vendorId'])
                                ->setProperty('active', '1')
                                ->setProperty('productGroup', $this->config->item('storeAndPos'))
                                ->getVendorGroupPaymentMethods();
            $paymentMethods = Utility_helper::resetArrayByKeyMultiple($paymentMethods, 'paymentMethod');

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
                'myBankPaymentType'     => $this->config->item('myBankPaymentType'),
                'payconiqPaymentType'   => $this->config->item('payconiqPaymentType'),
                'pinMachinePaymentType' => $this->config->item('pinMachinePaymentType'),
				'localType'             => $this->config->item('local'),
                'oldMakeOrderView'      => $this->config->item('oldMakeOrderView'),
                'newMakeOrderView'      => $this->config->item('newMakeOrderView'),
                'redirect'              => $this->getRedirect($vendor, $spotTypeId, $orderRandomKey, intval($orderData['spotId'])),
                'orderDataGetKey'       => $this->config->item('orderDataGetKey'),
                'orderRandomKey'        => $orderRandomKey,
                'spotId'                => $orderData['spotId'],
                'pinMachineOptionSubId' => $this->config->item('pinMachineOptionSubId'),
                'idealPayment'          => $this->config->item('idealPayment'),
                'creditCardPayment'     => $this->config->item('creditCardPayment'),
                'bancontactPayment'     => $this->config->item('bancontactPayment'),
                'giroPayment'           => $this->config->item('giroPayment'),
                'payconiqPayment'       => $this->config->item('payconiqPayment'),
                'pinMachinePayment'     => $this->config->item('pinMachinePayment'),
                'voucherPayment'        => $this->config->item('voucherPayment'),
                'myBankPayment'         => $this->config->item('myBankPayment'),
                'prePaid'               => $this->config->item('prePaid'),
                'postPaid'              => $this->config->item('postPaid'),
                'paymentMethodsKey'     => array_keys($paymentMethods),
                # this we will need for cost calculation
                #'vendorPaymentMethods'  => $paymentMethods,
            ];

            // echo '<pre>';
            // print_r($data);
            // die();
            $vendorId = intval($orderData['vendorId']);

            $this->global['pageTitle'] = 'TIQS : PAY';
            $this->setGlobalDesign($data['vendor']['design']);
            $this->setGlobalVendor($data['vendor']);
            $this->loadViews('publicorders/payOrder', $this->global, $data, null, 'headerWarehousePublic', Language_helper::getLanguage($vendorId));
        }

        private function getRedirect(array $vendor, int $spotTypeId, string $orderRandomKey, int $spotId): string
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

        private function isVendorClosed(array $vendor): void
        {
            if (
                $vendor['nonWorkFrom']
                && $vendor['nonWorkTo']
                && date('Y-m-d') >= $vendor['nonWorkFrom']
                && date('Y-m-d') <= $vendor['nonWorkTo']
            ) {
                redirect('closed/' . $vendor['vendorId']);                
            }
            return;
        }

        private function setGlobalDesign(?string $design): void
        {
            if ((!empty($design))) {
                $this->global[$this->config->item('design')] = unserialize($design);
            } else {
                $this->global[$this->config->item('design')] = $this->shopvendortemplate_model->getDefaultDesign();
            }
        }

        private function setGlobalVendor(array $vendor): void
        {
            $this->global['vendor'] = $vendor;
        }
    }
