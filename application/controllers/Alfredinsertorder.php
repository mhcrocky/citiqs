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

    public function index()
	{
        die();
    }
    

    public function insertOrder($payNlPaymentTypeId, $paymentOptionSubId): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);

        $payType = $this->getPayType($payNlPaymentTypeId);

        if (!$payType) redirect(base_url());

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

    private function insertOrderProcess(array $post, string $payStatus, string $payType, string $orderRandomKey, int $voucherId = 0): ?int
    {
        $this->user_model->manageAndSetBuyer($post['user']);
        if (!$this->user_model->id) return null;

        // insert order
        $this->insertOrderInTable($post, $payStatus, $payType, $orderRandomKey);
        $this->insertOrderExtended($post);

        return $this->shoporder_model->id;
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

        // TO DO VOUCHER PAYMENT !!!!!!!!!!!!!!!!!!!!!!!!!!
        // if ($voucherId || isset($_SESSION['voucherId'])) {
        //     $payPartial = false;
        //     if (isset($_SESSION['voucherId'])) {
        //         $voucherId = $_SESSION['voucherId'];
        //         $payPartial = true;
        //         unset($_SESSION['voucherId']);
        //     }
        //     $this->payOrderWithVoucher($voucherId, $post, $failedRedirect, $payPartial);
        // }

        $this->shoporder_model->setObjectFromArray($post['order'])->create();
    }

    private function insertOrderExtended($post)
    {
        $vendor = $this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getVendorData();

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
    }

    public function cashPayment($payStatus, $payType): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);

        $orderId = $this->insertOrderProcess($orderData, $payStatus, $payType, $orderRandomKey);
        if ($orderData['vendorId'] === 1162 || $orderData['vendorId'] === 5655) {
            $redirect = base_url() . 'successth';
        } else {
            $redirect = base_url() . 'success?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey . '&orderid=' . $orderId;
        }
        redirect($redirect);
    }


    // TO DO !!!!!!!!!!!!!!!!!!!!!
    public function voucherPayment($voucherId): void
    {
        $voucherId = intval($voucherId);
        $this->insertOrderProcess($this->config->item('orderNotPaid'), $this->config->item('voucherPayment'), $voucherId);
        $redirect =  ($_SESSION['vendor']['vendorId'] === 1162 || $_SESSION['vendor']['vendorId'] === 5655 ) ?  'successth' : 'success';
        $_SESSION['orderStatusCode'] = $this->config->item('payNlSuccess');
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
}
