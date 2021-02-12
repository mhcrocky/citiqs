<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Pos extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');
            $this->load->helper('country_helper');
            $this->load->helper('date');
            $this->load->helper('jwt_helper');
            $this->load->helper('fod_helper');

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
            $this->load->model('shopposorder_model');
            $this->load->model('employee_model');
            $this->load->model('shopemployee_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->isLoggedIn();
            $this->checkIsPosActive();
        }

        private function checkIsPosActive(): void
        {
            if ($_SESSION['activatePos'] !== '1') {
                redirect('loggedin');
            }
        }

        public function index(): void
        {

            $vendorId = intval($_SESSION['userId']);
            $localTypeId = $this->config->item('local');
            $spots = $this->shopspot_model->fetchUserSpotsByType($vendorId, $localTypeId);
            $spotId = !empty($_GET['spotid']) ? intval($this->input->get('spotid', true)) : ((count($spots) === 1) ? intval($spots[0]['spotId']) : null);
            $spot = $spotId ? $this->shopspot_model->fetchSpot($vendorId, $spotId) : null;
            $allProducts = ($spot && $this->isLocalSpotOpen($spot)) ? $this->shopproductex_model->getMainProductsOnBuyerSide($vendorId, $spot) : null;
            $isFodActive = $spotId ? Fod_helper::isFodActive($vendorId, $spotId) : true;

            if ($allProducts && $isFodActive) {

                $data = [
                    'uploadProductImageFolder'  => $this->config->item('uploadProductImageFolder'),
                    'mainProducts'              => $allProducts['main'],
                    'addons'                    => $allProducts['addons'],
                    'maxRemarkLength'           => $this->config->item('maxRemarkLength'),
                    'categories'                => array_keys($allProducts['main']),
                    'vendor'                    => $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData(),
                    'baseUrl'                   => base_url(),
                    'buyerRoleId'               => $this->config->item('buyer'),
                    'salesagent'                => $this->config->item('tiqsId'),
                    'buyershorturl'             => $this->config->item('buyershorturl'),
                    'xReport'                   => $this->config->item('x_report'),
                    'zReport'                   => $this->config->item('z_report'),
                    
                ];

                $this->getOrdered($data, $vendorId, $spotId);
                $this->setPosSideFee($data);
            }

            $data['employees'] = $this
                                    ->employee_model
                                        ->setProperty('ownerId', $vendorId)
                                        ->getMenuOptionEmployees($this->config->item('posMenuOptionId'));
            $data['lock'] = (isset($_SESSION['unlockPos']) && $_SESSION['unlockPos']) ? true : false;
            $data['spots'] = $spots;
            $data['spotId'] = $spotId;
            $data['spotPosOrders'] = $this->shopposorder_model->setProperty('spotId', $spotId)->fetchSpotPosOrders();
            $data['isPos'] = 1;
            $data['fodIsActive'] = $isFodActive;
            $data['orderDataGetKey']    = $this->config->item('orderDataGetKey');
            // $data['employees'] = $this->employee_model->setProperty('ownerId', $vendorId)->getActiveEmployeeForBB($vendorId);
            $this->global['pageTitle'] = 'TIQS : POS';
            $this->loadViews('pos/pos', $this->global, $data, null, 'headerWarehouse');
            return;
        }

        private function getOrdered(array &$data, $vendorId, $spotId): void
        {
            $orderDataRandomKey = empty($_GET[$this->config->item('orderDataGetKey')]) ? '' : $this->input->get($this->config->item('orderDataGetKey'), true);

            $ordered = Jwt_helper::fetchPos($orderDataRandomKey, $vendorId, $spotId, ['vendorId', 'spotId']);

            $data['orderDataRandomKey'] = $orderDataRandomKey;
            if ($ordered && $ordered['makeOrder']) {
                $ordered = Utility_helper::returnMakeNewOrderElements($ordered['makeOrder'], $data['vendor'], $data['mainProducts'], $data['addons'], $data['maxRemarkLength'], true);
                $data['checkoutList'] = $ordered['checkoutList'];
                $data['posOrderName'] = $this->getPosOrderName($orderDataRandomKey);
            }
        }

        private function isLocalSpotOpen(array $spot): bool
        {
            $spotTypeId = intval($spot['spotTypeId']);
            $spotId = intval($spot['spotId']);

            if ($spotTypeId === $this->config->item('local') && !$this->shopspottime_model->setProperty('spotId', $spotId)->isOpen() ) {
                return false;;
            }
            return true;
        }

        public function delete(string $ranodmKey, string $spotId): void
        {
            $this->shopsession_model->setProperty('randomKey', $ranodmKey)->setIdFromRandomKey();
            $this->shopposorder_model->setProperty('sessionId', intval($this->shopsession_model->id))->setIdFromSessionId();
            if ($this->shopposorder_model->id) {
                $this->shopposorder_model->delete();
            }
            $redirect = base_url() . 'pos?spotid=' . $spotId;
            redirect($redirect);
            return;
        }

        private function getPosOrderName(string $ranodmKey): ?string
        {
            $this->shopsession_model->setProperty('randomKey', $ranodmKey)->setIdFromRandomKey();
            $this
                ->shopposorder_model
                    ->setProperty('sessionId', intval($this->shopsession_model->id))
                    ->setIdFromSessionId();
            if (!$this->shopposorder_model->id) return null;
            $this ->shopposorder_model->setObject();
            return $this->shopposorder_model->saveName;
        }

        private function setPosSideFee(array &$data): void
        {
            $data['serviceFeePercent'] = $data['vendor']['serviceFeePercentPos'] === '1' ? $data['vendor']['serviceFeePercent'] : 0.0;
            $data['serviceFeeAmount'] = $data['vendor']['serviceFeeAmountPos'] === '1' ? $data['vendor']['serviceFeeAmount'] : 0.0;
            $data['minimumOrderFee'] =  $data['vendor']['minimumOrderFeePos'] === '1' ? $data['vendor']['minimumOrderFee'] : 0.0;
            return;
        }

    }
