<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';


class Alfredinsertorder extends BaseControllerWeb
{

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('validate_data_helper');
        $this->load->helper('utility_helper');
        $this->load->helper('country_helper');
        $this->load->helper('date');
        $this->load->helper('jwt_helper');
        $this->load->helper('orderprint_helper');
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

        $this->load->config('custom');

        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('session');
        $this->load->library('notificationvendor');
    }

    public function index()
	{
        die();
    }
    

    public function insertOrder($payNlPaymentTypeId, $paymentOptionSubId): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);

        $payType = $this->getPayType($payNlPaymentTypeId);

        if (!$payType) redirect(base_url());

        $this->voucherPaymentFailed($orderData);

        $orderId = $this->insertOrderProcess($orderData, $this->config->item('orderNotPaid'), $payType, $orderRandomKey);
        
        if (is_null($orderId)) {
            $redirect  = 'make_order?vendorid=' . $orderData['vendorId'] . '&spotid=' . $orderData['spotId'];
            $redirect .= '&' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
            $this->session->set_flashdata('error', '(1010) Order not made! Please try again');
        } else {
            $redirect  = 'paymentengine' . DIRECTORY_SEPARATOR . $payNlPaymentTypeId  . DIRECTORY_SEPARATOR . $paymentOptionSubId;
            $redirect .= DIRECTORY_SEPARATOR . $orderId;
            $redirect .= '?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
        }

        redirect($redirect);
        exit();
    }

    private function getPayType(string $payNlPaymentTypeId): ?string
    {
        $payType = null;
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
        }

        return $payType;
    }

    private function insertOrderProcess(array $post, string $payStatus, string $payType, string $orderRandomKey): ?int
    {
        $this->user_model->manageAndSetBuyer($post['user']);
        if (!$this->user_model->id) return null;

        $this->insertOrderInTable($post, $payStatus, $payType, $orderRandomKey);
        $this->insertOrderExtended($post);
        $this->deletePosOrder($post, $orderRandomKey);
        $this->saveOrderImage(); // OPTIMIZE THREAD ... ASYNC       

        if ($payStatus === $this->config->item('orderPaid') && $this->vendorOneSignalId) {
            $this->notificationvendor->sendVendorMessage($this->vendorOneSignalId, $this->shoporder_model->id);
        }
        return $this->shoporder_model->id;
    }

    private function saveOrderImage(): void
    {
        $orderForImage = $this->shoporder_model->fetchOrdersForPrintcopy();
        $orderForImage = reset($orderForImage);
        Orderprint_helper::saveOrderImage($orderForImage);
    }
    private function insertOrderInTable(array $post, string $payStatus, string $payType, string $orderRandomKey): void
    {
        $spot = $this->shopspot_model->fetchSpot($post['vendorId'], $post['spotId']);

        $post['order']['buyerId'] = $this->user_model->id;
        $post['order']['paid'] = $payStatus;
        $post['order']['paymentType'] = $payType;
        $post['order']['serviceTypeId'] = $spot['spotTypeId'];
        $post['order']['orderRandomKey'] = $orderRandomKey;

        if (!empty($post['order']['date']) && !empty($post['order']['time'])) {
            $orderDate = explode(' ', $post['order']['date']);
            $post['order']['created'] = $orderDate[0] . ' ' . $post['order']['time'];
        }

        $this->shoporder_model->setObjectFromArray($post['order'])->create();
    }

    private function insertOrderExtended($post): void
    {
        $vendor = $this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getVendorData();
        $this->vendorOneSignalId = $vendor['oneSignalId'];

        // insert order details
        if ($vendor['preferredView'] === $this->config->item('oldMakeOrderView')) {
            foreach ($post['orderExtended'] as $id => $details) {
                $details['productsExtendedId'] = intval($id);
                $details['orderId'] = $this->shoporder_model->id;
                if (!$this->shoporderex_model->setObjectFromArray($details)->create()) {
                    $this->shoporderex_model->orderId = $details['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                    $this->shoporder_model->id = null;
                }
            }
        } elseif ($vendor['preferredView'] === $this->config->item('newMakeOrderView')) {
            $insertAll = [];

            foreach ($post['orderExtended'] as $details) {
                $id = array_keys($details)[0];
                $details = reset($details);
                $details['quantity'] = intval($details['quantity']);

                if (isset($details['remark']) || isset($details['mainPrductOrderIndex']) || isset($details['subMainPrductOrderIndex'])) {
                    $remark = isset($details['remark']) ? $details['remark'] : '';
                    $mainPrductOrderIndex = isset($details['mainPrductOrderIndex']) ? $details['mainPrductOrderIndex'] : 0;
                    $subMainPrductOrderIndex = isset($details['subMainPrductOrderIndex']) ? $details['subMainPrductOrderIndex'] : 0;
                    $insert = [
                        'productsExtendedId' => intval($id),
                        'orderId' => $this->shoporder_model->id,
                        'quantity' => $details['quantity'],
                        'remark' => $remark,
                        'mainPrductOrderIndex' => $mainPrductOrderIndex,
                        'subMainPrductOrderIndex' => $subMainPrductOrderIndex,
                    ];
                    if (!$this->shoporderex_model->setObjectFromArray($insert)->create()) {
                        $this->shoporderex_model->orderId = $insert['orderId'];
                        $this->shoporderex_model->deleteOrderDetails();
                        $this->shoporder_model->delete();
                        $this->shoporder_model->id = null;
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
            if ($insertValues) {
                if (!$this->shoporderex_model->multipleCreate($insertValues)) {
                    $this->shoporderex_model->orderId = $insert['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                    $this->shoporder_model->id = null;
                }
            }
        }
        return;
    }

    public function cashPayment($payStatus, $payType): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);

        $this->voucherPaymentFailed($orderData);
        $orderId = $this->insertOrderProcess($orderData, $payStatus, $payType, $orderRandomKey);
        if ($orderData['vendorId'] === 1162 || $orderData['vendorId'] === 5655) {
            $redirect = base_url() . 'successth';
        } else {
            $redirect = base_url() . 'success?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey . '&orderid=' . $orderId;
        }
        redirect($redirect);
        return;
    }

    public function voucherPayment(): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        $this->isFodActive($orderData['vendorId'], $orderData['spotId']);


        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);

        $payStatus = $this->payingWithVoucher($orderData['order']) ? $this->config->item('orderPaid') : $this->config->item('orderNotPaid');
        $orderId = $this->insertOrderProcess($orderData, $payStatus, $this->config->item('voucherPayment'), $orderRandomKey);
        
        if ($orderData['vendorId'] === 1162 || $orderData['vendorId'] === 5655) {
            $redirect = base_url() . 'successth';
        } else {
            $redirect = base_url() . 'success?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey . '&orderid=' . $orderId;
        }
        redirect($redirect);
        return;
    }

    private function payingWithVoucher(array $order): bool
    {
        return $this->shopvoucher_model
                ->setObjectId(intval($order['voucherId']))
                ->setVoucher()
                ->payOrderWithVoucher(floatval($order['voucherAmount']));
    }

    private function deletePosOrder(array $post, string $ranodmKey): void
    {
        if ($this->shoporder_model->id && isset($post['pos']) && $post['pos'] === '1' ) {
            $this->shopsession_model->setProperty('randomKey', $ranodmKey)->setIdFromRandomKey();
            $this
                ->shopposorder_model
                    ->setProperty('sessionId', intval($this->shopsession_model->id))
                    ->setIdFromSessionId()
                    ->delete();
        }
        return ;
    }

    private function voucherPaymentFailed(array $orderData): void
    {
        if (!empty($orderData['order']['voucherId']) && !empty($orderData['order']['voucherAmount']) && !$this->payingWithVoucher($orderData['order'])) {
            Jwt_helper::unsetVoucherData($orderData, $orderRandomKey);
            $redirect  = 'make_order?vendorid=' . $orderData['vendorId'] . '&spotid=' . $orderData['spotId'];
            $redirect .= '&' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
            $this->session->set_flashdata('error', '(1082) Order not made! Voucher is not valid');
            redirect($redirect);
            exit();
        }
        return;
    }

    private function isFodActive(int $vendorId, int $spotId): void
    {
        if (!Fod_helper::isFodActive($vendorId, $spotId)) {
            $redirect = base_url() . $this->config->item('fodInActive') . DIRECTORY_SEPARATOR . $vendorId;
            redirect($redirect);
        }
    }
}
