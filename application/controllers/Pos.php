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

        private function checkIsPosEmployee(): void
        {
            if (empty($_SESSION['posEmployeeId'])) {
                redirect('pos_login');
            }
        }

        public function index(): void
        {
            $this->checkIsPosEmployee();

            $vendorId = intval($_SESSION['userId']);
            $spotId = !empty($_GET['spotid']) ? intval($this->input->get('spotid', true)) : null;
            $spot = $spotId ? $this->shopspot_model->fetchSpot($vendorId, intval($spotId)) : null;
            $allProducts = ($spot && $this->isLocalSpotOpen($spot)) ? $this->shopproductex_model->getMainProductsOnBuyerSide($vendorId, $spot) : null;
            $localTypeId = $this->config->item('local');

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
                ];
                $this->getOrdered($data, $vendorId, $spotId);
                $this->setPosSideFee($data);
            }

            $data['spots'] = $this->shopspot_model->fetchUserSpotsByType($vendorId, $localTypeId);
            $data['spotId'] = $spotId;
            $data['spotPosOrders'] = $this->shopposorder_model->setProperty('spotId', $spotId)->fetchSpotPosOrders();
            $data['isPos'] = 1;
            $data['fodIsActive'] = $isFodActive;

            $this->global['pageTitle'] = 'TIQS : POS';
            $this->loadViews('pos/pos', $this->global, $data, null, 'headerWarehouse');
            return;
        }

        private function getOrdered(array &$data, $vendorId, $spotId): void
        {
            $orderDataRandomKey = empty($_GET[$this->config->item('orderDataGetKey')]) ? '' : $this->input->get($this->config->item('orderDataGetKey'), true);
            $ordered = Jwt_helper::fetch($orderDataRandomKey, $vendorId, $spotId, ['vendorId', 'spotId']);
            $data['orderDataGetKey']    = $this->config->item('orderDataGetKey');
            $data['orderDataRandomKey'] = $orderDataRandomKey;
            if ($ordered['makeOrder']) {
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
            $this->checkIsPosEmployee();
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

        public function posLogin(): void
        {
            if (!empty($_SESSION['posEmployeeId'])) {
                redirect('pos');
            }
            $ownerId = intval($this->session->userdata("userId"));
            $data = [
                'employees' => $this->employee_model->setProperty('ownerId', $ownerId)->getActiveEmployeeForBB($ownerId),
            ];

            $this->global['pageTitle'] = 'TIQS : POS LOGIN';
            $this->loadViews('pos/pos_login', $this->global, $data, null, 'headerWarehouse');
            return;
        }

        public function posLoginAction(): void
        {
            $employee = Utility_helper::sanitizePost();

            if (empty($employee)) {
                $this->session->set_flashdata('error', 'Select employee');
                redirect('pos_login');
            }

            $employee['inOutEmployee'] = $this->config->item('employeeIn');
            $employee['inOutDateTime'] = date('Y-m-d H:i:s');
            $employee['processed'] = '0';

            $insert = $this->shopemployee_model->setObjectFromArray($employee)->create();
            if (!$insert) {
                $this->session->set_flashdata('error', 'Check in failed. Please try again');
                redirect('pos_login');
            }

            $_SESSION['posEmployeeId'] = $employee['employeeId'];
            redirect('pos');
        }

        public function posLogOutAction(): void
        {
            $employee = [
                'employeeId' => $_SESSION['posEmployeeId'],
                'inOutEmployee' => $this->config->item('employeeOut'),
                'inOutDateTime' => date('Y-m-d H:i:s'),
                'processed' => '0'
            ];

            $insert = $this->shopemployee_model->setObjectFromArray($employee)->create();
            if ($insert) {
                unset($_SESSION['posEmployeeId']);
                redirect('pos_login');
            }

            $this->session->set_flashdata('error', 'Logout failed. Please try again');
            redirect('pos');
        }
    }
