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

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->isLoggedIn();
            $this->checkIsPosActive();
        }

        private function checkIsPosActive() {            
            if ($_SESSION['activatePos'] !== '1') {
                redirect('loggedin');
            }
        }

        public function index(): void
        {
            $vendorId = intval($_SESSION['userId']);
            $spotId = !empty($_GET['spotid']) ? intval($this->input->get('spotid', true)) : null;
            $spot = $spotId ? $this->shopspot_model->fetchSpot($vendorId, intval($spotId)) : null;            
            $allProducts = ($spot && $this->isLocalSpotOpen($spot)) ? $this->shopproductex_model->getMainProductsOnBuyerSide($vendorId, $spot) : null;

            if ($allProducts) {
                $data = [
                    'uploadProductImageFolder'  => $this->config->item('uploadProductImageFolder'),
                    'mainProducts'              => $allProducts['main'],
                    'addons'                    => $allProducts['addons'],
                    'maxRemarkLength'           => $this->config->item('maxRemarkLength'),
                    'categories'                => array_keys($allProducts['main']),
                    'vendor'                    => $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData(),
                    'baseUrl'                   => base_url(),
                ];
                $this->getOrdered($data, $vendorId, $spotId);
            }

            $data['spots'] = $this->shopspot_model->fetchUserSpots($vendorId);
            $data['spotId'] = $spotId;
            $data['spotPosOrders'] = $this->shopposorder_model->setProperty('spotId', $spotId)->fetchSpotPosOrders();

            $this->global['pageTitle'] = 'TIQS : POS';
            $this->loadViews('pos/pos', $this->global, $data, null, 'headerWarehouse');
            return;
        }

        private function getOrdered(array &$data, $vendorId, $spotId): void
        {
            $orderDataRandomKey = empty($_GET[$this->config->item('orderDataGetKey')]) ? '' : $this->input->get($this->config->item('orderDataGetKey'), true);
            $ordered = Jwt_helper::fetchAndChekOrdered($orderDataRandomKey, $vendorId, $spotId, ['vendorId', 'spotId']);
            $data['orderDataGetKey']    = $this->config->item('orderDataGetKey');
            $data['orderDataRandomKey'] = $orderDataRandomKey;
            if ($ordered) {
                $ordered = Utility_helper::returnMakeNewOrderElements($ordered, $data['vendor'], $data['mainProducts'], $data['addons'], $data['maxRemarkLength']);
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

        public function delete(string $ranodmKey): void
        {            
            $this->shopsession_model->setProperty('randomKey', $ranodmKey)->setIdFromRandomKey();
            $this
                ->shopposorder_model
                    ->setProperty('sessionId', intval($this->shopsession_model->id))
                    ->setIdFromSessionId()
                    ->setObject()
                    ->delete();

            $redirect = base_url() . 'pos?spotid=' . $this->shopposorder_model->spotId;
            redirect($redirect);
            return;
        }

        private function getPosOrderName(string $ranodmKey): string
        {
            $this->shopsession_model->setProperty('randomKey', $ranodmKey)->setIdFromRandomKey();
            $this
                ->shopposorder_model
                    ->setProperty('sessionId', intval($this->shopsession_model->id))
                    ->setIdFromSessionId()
                    ->setObject();
            return $this->shopposorder_model->saveName;
        }
    }
