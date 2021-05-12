<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Productsonoff extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('utility_helper');

            $this->load->model('shopcategory_model');
            $this->load->model('shopprinters_model');
            $this->load->model('shopspot_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shopprodutctype_model');
            $this->load->model('shopvendor_model');
            $this->load->model('shopvendortypes_model');
            $this->load->model('user_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->load->config('custom');

            $this->isLoggedIn();
        }


        // PRODUCTS
        /**
         * Read products
         *
         * @return void
         */
        public function index($active = ''): void
        {
            if ($active === 'active') {
                $activeFilter = '1';
            } elseif ($active === 'archived') {
                $activeFilter = '0';
            } else {
                $activeFilter = '';
            }

            $userId = intval($_SESSION['userId']);
            $productNames = $this->shopproductex_model->getProductsNames($userId, $activeFilter);
            if ($productNames) {
                Utility_helper::array_sort_by_column($productNames, 'name');
            }
            $offset = intval($this->input->get('offset', true));
            $perPage = 21;
            $whereIn = [];
            $url = 'productsonoff' . DIRECTORY_SEPARATOR . $active;
            $pagination = Utility_helper::getPaginationLinks(count($productNames), $perPage, $url);

            // filter productes ny name(s)
            if (!empty($_POST)) {
                $post = Utility_helper::sanitizePost();
                $whereIn = [
                    'column' => 'tbl_shop_products_extended.productId',
                    'array' => $post['names']
                ];
                $pagination = '';
            }

            // for country taxes
            $this->user_model->setUniqueValue($userId)->setWhereCondtition()->setUser('country');

            $data = [
                'categories' => $this->shopcategory_model->fetch(['userId' => $userId]),
                'products' => $this->shopproductex_model->getUserProducts($userId, $perPage, $offset, $whereIn, $activeFilter),
                'printers' => $this->shopprinters_model->read(['*'], ['userId' => $userId, 'archived' => '0']),
                'userSpots' => $this->shopspot_model->fetchUserSpots($userId),
                'productTypes' => $this->shopprodutctype_model->fetchProductTypes($userId),
                'concatSeparator' => $this->config->item('concatSeparator'),
                'productNames' => $productNames,
                'pagination' => $pagination,
                'dayOfWeeks' => $this->config->item('weekDays'),
                'allergies' => $this->config->item('allergies'),
                'showAllergies' => $this->shopvendor_model->setProperty('vendorId', $userId)->getProperty('showAllergies'),
                'vendorTypes' => $this->shopvendortypes_model->setProperty('vendorId', $userId)->fetchActiveVendorTypes(),
                'localTypeId' => $this->config->item('local'),
                'deliveryTypeId' => $this->config->item('deliveryType'),
                'pickupTypeId' => $this->config->item('pickupType'),
                'taxRates' => $this->config->item('countriesTaxes')[$this->user_model->country]['taxRates'],
                'active' => $active
            ];

            $this->global['pageTitle'] = 'TIQS : PRODUCTS';
            $this->loadViews('productsonoff/index', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

    }
