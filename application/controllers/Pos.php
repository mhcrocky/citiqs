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
            $this->load->model('floorplan_model');
            $this->load->model('floorplanareas_model');

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
            $this->redirectToFirstLocalSpot();

            $vendorId = intval($_SESSION['userId']);
            $localTypeId = $this->config->item('local');
            $spots = $this->shopspot_model->fetchUserSpotsByType($vendorId, $localTypeId);
            $spotId = intval($this->input->get('spotid', true));
            $spot = $this->shopspot_model->fetchSpot($vendorId, $spotId);
            $spotName = $spot ? $spot['spotName'] : null;
            $allProducts = ($spot && $this->isLocalSpotOpen($spot)) ? $this->shopproductex_model->getMainProductsOnBuyerSide($vendorId, $spot) : null;
            $isFodActive = Fod_helper::isFodActive($vendorId, $spotId);

            if ($allProducts && $isFodActive) {

                $data = [
                    'productsImagesFolder'      => (base_url() . $this->config->item('productsImagesRelativePath')),
                    'defaultImagesFolder'      => (base_url() . $this->config->item('defautProductsImagesRelativePath')),
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

                $this->setPosSideFee($data);
            }

            $data['employees'] = $this->employee_model->setProperty('ownerId', $vendorId)->getMenuOptionEmployees($this->config->item('posMenuOptionId'));
            $data['lock'] = (isset($_SESSION['unlockPos']) && $_SESSION['unlockPos']) ? true : false;
            $data['spots'] = $spots;
            $data['spotId'] = $spotId;
            $data['spotName'] = $spotName;
            $data['spotPosOrders'] = $this->shopposorder_model->setProperty('spotId', $spotId)->fetchSpotPosOrders();
            // $data['vendorPosOrders'] = $this->shopposorder_model->fetchVendorPosOrders($vendorId);
            $data['isPos'] = 1;
            $data['fodIsActive'] = $isFodActive;
            $data['orderDataGetKey'] = $this->config->item('orderDataGetKey');
            $data['postPaid'] = $this->config->item('postPaid');
            $data['pinMachinePayment'] = $this->config->item('pinMachinePayment');
            $data['voucherPayment'] = $this->config->item('voucherPayment');

            $this->getFloorplan($data);

            $this->global['pageTitle'] = 'TIQS : POS';
            $this->loadViews('pos/pos', $this->global, $data, null, 'headerWarehouse');
            return;
        }

        private function getFloorplan(array &$data): void
        {
            // TO DO improve, JUST QUICK VCERSION TO SHOW FLOORPLAN IN POS
            $this->load->model('floorplan_model');
            $this->load->model('shopspot_model');
            $floorplan = $this->floorplan_model->readImproved([
                'what' => ['*'],
                'where' => [
                    'vendorId' => $_SESSION['userId']
                ],
                'conditions' => [
                    'order_by' => ['id', 'DESC'],
                    'limit' => ['1']
                ]
            ]);

            if (is_null($floorplan)) return;

            $floorplan = reset($floorplan);
            $areas = $this->floorplanareas_model->get_floorplan_areas($floorplan['id']);

            $data['floorplan'] = $floorplan;
            $data['areas'] = $areas;
        }

        public function redirectToFirstLocalSpot(): void
        {
            if (empty($_GET['spotid'])) {
                $spotId = $this->shopspot_model->getFirstLocalSpotId(intval($_SESSION['userId']));
                $redirect = base_url() . 'pos?spotid=' . strval($spotId);
                redirect($redirect);
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

        private function setPosSideFee(array &$data): void
        {
            $data['serviceFeePercent'] = $data['vendor']['serviceFeePercentPos'] === '1' ? $data['vendor']['serviceFeePercent'] : 0.0;
            $data['serviceFeeAmount'] = $data['vendor']['serviceFeeAmountPos'] === '1' ? $data['vendor']['serviceFeeAmount'] : 0.0;
            $data['minimumOrderFee'] =  $data['vendor']['minimumOrderFeePos'] === '1' ? $data['vendor']['minimumOrderFee'] : 0.0;
            return;
        }

    }
