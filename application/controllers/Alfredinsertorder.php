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
        $this->load->helper('receiptprint_helper');
        $this->load->helper('pay_helper');

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
        $this->load->model('shopvendorfod_model');
        $this->load->model('notification_model');

        $this->load->config('custom');

        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('session');
        $this->load->library('notificationvendor');
		// $this->load->library('notificationcustomer');
    }

    public function index()
	{
        die();
    }
    

    public function onlinePayment($payNlPaymentTypeId, $paymentOptionSubId): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'user', 'orderExtended', 'order']);
        $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

        $payType = Pay_helper::returnPaymentMethod($payNlPaymentTypeId);

        if (!$payType) redirect(base_url());

        $this->voucherPaymentFailed($orderData, $orderRandomKey);

        $orderData['order']['paid'] = $this->config->item('orderNotPaid');
        $orderData['order']['paymentType'] = $payType;

        $orderId = $this->insertOrderProcess($orderData, $orderRandomKey);

        if (!$orderId) {
            $this->failedRedirect($orderData['vendorId'], $orderData['spotId'], $orderRandomKey);
        }

        //$redirect  = 'paymentengine' . DIRECTORY_SEPARATOR . $payNlPaymentTypeId  . DIRECTORY_SEPARATOR . $paymentOptionSubId;
        $redirect  = base_url() . 'paymentengine' . DIRECTORY_SEPARATOR . $payNlPaymentTypeId  . DIRECTORY_SEPARATOR . $paymentOptionSubId; // added base_url()
        $redirect .= DIRECTORY_SEPARATOR . $orderId;
        $redirect .= '?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;

        Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/order_payment.txt', "$redirect");

        redirect($redirect);
        exit();
    }

    public function cashPayment($payStatus, $payType): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'makeOrder', 'user', 'orderExtended', 'order']);
        $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

        $this->voucherPaymentFailed($orderData, $orderRandomKey);

        $orderData['order']['paid'] = $payStatus;
        $orderData['order']['paymentType'] = $payType;

        $orderId = $this->insertOrderProcess($orderData, $orderRandomKey);

        $this->cashVoucerRedirect($orderData['vendorId'], $orderId, $orderRandomKey, $orderData['spotId']);

        return;
    }

    public function voucherPayment(): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'user', 'orderExtended', 'order']);
        $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

        $payStatus = $this->payingWithVoucher($orderData['order']) ? $this->config->item('orderPaid') : $this->config->item('orderNotPaid');
        $orderData['order']['paid'] = $payStatus;
        $orderData['order']['paymentType'] = $this->config->item('voucherPayment');
        $orderId = $this->insertOrderProcess($orderData, $orderRandomKey);

        $this->cashVoucerRedirect($orderData['vendorId'], $orderId, $orderRandomKey, $orderData['spotId']);
        return;
    }

    public function posPayment(): void
    {
        $post = Utility_helper::sanitizePost();
        $post['vendorId'] = intval($post['vendorId']);
        $post['spotId'] = intval($post['spotId']);

        $this->isFodActive($post['vendorId'], $post['spotId']);

        if (!$this->voucherPosPayment($post)) return;

        $orderId = $this->managePosOrder($post);

        $response = [
            'status' => '1',
            'orderId' => $orderId,
            'paid' => $post['order']['paid']
        ];

        $this->posSideJobs($post, $response, $orderId);

        echo json_encode($response);
        return;
    }

    private function voucherPosPayment(array &$post): bool
    {
        if (!empty($post['order']['voucherId']) && !empty($post['order']['voucherAmount'])) {
            if (!$this->payingWithVoucher($post['order'])) {
                $response = [
                    'status' => '0',
                    'paid' => $post['order']['paid'],
                    'messages' => ['Voucher payment failed']
                ];
                echo json_encode($response);
                return false;
            }
            $post['order']['paid'] = '1';
        }
        return true;
    }

    private function managePosOrder(array $post): int
    {
        // check does post has key posOrderId
        if (!empty($post['posOrderId'])) {
            // if has, check ist this order already inserted and need only update of items and dates createdOrders and created
            $posOrderId = intval(Utility_helper::getAndUnsetValue($post, 'posOrderId'));
            $orderId = intval($this->shopposorder_model->setObjectId($posOrderId)->getProperty('orderId'));

            if ($orderId) {
                if (!empty($post['orderExtended'])) {
                    $this->insertOrderExtendedRefactored($post['orderExtended'], $orderId);
                }
                if (!empty($post['order']['paymentType'])) {
                    $this->saveOrderImage($orderId);
                    $this
                        ->shoporder_model
                        ->setObjectId($orderId)
                        ->setProperty('createdOrder', date('Y-m-d H:i:s'))
                        ->setProperty('paid', $post['order']['paid'])
                        ->update();
                }
                return $orderId;
            }
        }

        return $this->insertOrderProcess($post, '');
    }


    private function posSideJobs(array $post, array &$response, int $orderId): void
    {
        // if no payment method, we have request for printing
        if (empty($post['order']['paymentType'])) {
            $response['print'] = '1';
            return;
        }

        $this->shopposorder_model->setProperty('orderId', $orderId)->deleteOrder();

        if ($post['order']['paymentType'] === $this->config->item('pinMachinePayment')) {
            $redirect  = 'paymentengine';
            $redirect .= DIRECTORY_SEPARATOR . $this->config->item('pinMachinePaymentType');
            $redirect .= DIRECTORY_SEPARATOR . $this->config->item('pinMachineOptionSubId');
            $redirect .= DIRECTORY_SEPARATOR . $orderId;

            $response['redirect'] = $redirect;
        }

        $url = 'http://localhost/tiqsbox/index.php/Cron/justprint/' . $orderId;
        @file_get_contents($url);
        if ($post['oneSignalId']) {
            $this->notificationvendor->sendVendorMessage($post['oneSignalId'], $orderId);
        }

        return;
    }

    private function failedRedirect(int $vendorId, int $spotId, string $orderRandomKey): void
    {
        $redirect  = 'make_order?vendorid=' . $vendorId . '&spotid=' . $spotId;
        $redirect .= '&' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
        $this->session->set_flashdata('error', '(1010) Order not made! Please try again');
        redirect($redirect);
        exit();
    }

    private function cashVoucerRedirect(int $vendorId, int $orderId, string $orderRandomKey, int $spotId): void
    {
        if (!$orderId) {
            $this->failedRedirect($vendorId, $spotId, $orderRandomKey);
        }

        $redirect = base_url() . 'success?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey . '&orderid=' . $orderId;
        redirect($redirect);
        exit();
    }

    private function setAmountAndServiceFee(array &$post): void
    {
        if ($post['pos'] === '1') return;

        $serviceTypeId = intval($post['order']['serviceTypeId']);
        $this->setAmount($post, $serviceTypeId);
        $this->setServiceFee($post, $serviceTypeId);
        return;
    }

    private function getProductPrice(int $id, int $type): string
    {
        if ($type === $this->config->item('local')) {
            $property = 'price';
        } elseif ($type === $this->config->item('deliveryType')) {
            $property = 'deliveryPrice';
        } elseif ($type === $this->config->item('pickupType')) {
            $property = 'pickupPrice';
        }

        return $this->shopproductex_model->setObjectId($id)->getProperty($property);
    }

    private function  setAmount(array &$post, int $serviceTypeId): void{
        $products = $post['makeOrder'];
        $checkAmount = 0;
        foreach ($products as $key => $product) {
            $productId = array_keys($product)[0];
            $product = reset($product);
            $productAmount = $this->getProductPrice($productId, $serviceTypeId);
            $checkAmount += floatval($productAmount) * intval($product['quantity']);
            if (!empty($product['addons'])) {
                $addons = $product['addons'];
                foreach ($addons as $addonId => $addon) {
                    $addonAmount = $this->getProductPrice($addonId, $serviceTypeId);
                    $checkAmount += floatval($addonAmount) * intval($addon['quantity']);
                }
            }
        }
        $post['order']['amount'] = $checkAmount;
        return;
    }

    private function getServiceFeeAmountAndPercent(array $post , int $serviceTypeId): array
    {
        if ($serviceTypeId === $this->config->item('local')) {
            $percent = $post['pos'] === '0' ? 'serviceFeePercent' : 'serviceFeePercentPos';
            $amount =  $post['pos'] === '0' ? 'serviceFeeAmount' : 'serviceFeeAmountPos';
            $minimum = $post['pos'] === '0' ? 'minimumOrderFee' : 'minimumOrderFeePos';
        } elseif ($serviceTypeId === $this->config->item('deliveryType')) {
            $percent = $post['pos'] === '0' ? 'deliveryServiceFeePercent' : 'deliveryServiceFeePercentPos';
            $amount =  $post['pos'] === '0' ? 'deliveryServiceFeeAmount' : 'deliveryServiceFeeAmountPos';
            $minimum = $post['pos'] === '0' ? 'deliveryMinimumOrderFee' : 'deliveryMinimumOrderFeePos';
        } elseif ($serviceTypeId === $this->config->item('pickupType')) {
            $percent = $post['pos'] === '0' ? 'pickupServiceFeePercent' : 'pickupServiceFeePercentPos';
            $amount =  $post['pos'] === '0' ? 'pickupServiceFeeAmount' : 'pickupServiceFeeAmountPos';
            $minimum = $post['pos'] === '0' ? 'pickupMinimumOrderFee' : 'pickupMinimumOrderFeePos';
        }

        $percentValue = floatval($this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getProperty($percent));
        $amountValue = floatval($this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getProperty($amount));
        $minimumValue = floatval($this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getProperty($minimum));
        return [$percentValue, $amountValue, $minimumValue];
    }

    private function setServiceFee(array &$post, int $serviceTypeId): void
    {
        list($percent, $amount, $minimum) = $this->getServiceFeeAmountAndPercent($post, $serviceTypeId);
        $serviceFee =  $post['order']['amount'] * $percent / 100 + $minimum;
        if ($serviceFee > $amount) {
            $serviceFee = $amount;
        }
        $post['order']['serviceFee'] = round($serviceFee, 2);
    }

    private function insertOrderProcess(array $post, string $orderRandomKey): int
    {
        $this->user_model->manageAndSetBuyer($post['user']);
        if (!$this->user_model->id) return 0;

        $userId = intval($this->user_model->id);
        $orderId = $this->insertOrderInTable($post, $orderRandomKey, $userId);

        (intval($post['pos'])) ? $this->handlePosOrder($post, $orderId) : $this->insertOrderExtended($post, $orderId);

        $this->saveOrderImage($orderId); // OPTIMIZE THREAD ... ASYNC
        $this->sendNotifictaion($post, $orderId, $post['order']['paid']);
        $this->sendEmailReceipt($post['order']['paid']);

        return $orderId;
    }

    private function handlePosOrder(array $post, int $orderId): void
    {
        $this->insertOrderExtendedRefactored($post['orderExtended'], $orderId);
        if (!empty($post['posOrderId'])) {
            $this->shopposorder_model->setObjectId(intval($post['posOrderId']))->setProperty('orderId', $orderId)->update();
        }
        return;
    }

    private function saveOrderImage(int $orderId): void
    {
        if (!$orderId) return;

        $orderForImage = $this->shoporder_model->setObjectId($orderId)->fetchOrdersForPrintcopy();
        $orderForImage = reset($orderForImage);
        // all details for printer in one order sheat
        Receiptprint_helper::printAllReceipts($orderId);
        Orderprint_helper::saveOrderImage($orderForImage);
    }

    private function insertOrderInTable(array $post, string $orderRandomKey, int $userId): int
    {
        $spot = $this->shopspot_model->fetchSpot($post['vendorId'], $post['spotId']);

        $post['order']['buyerId'] = $userId;
        $post['order']['serviceTypeId'] = $spot['spotTypeId'];
        $post['order']['orderRandomKey'] = $orderRandomKey;
        $post['order']['createdOrder'] = date('Y-m-d H:i:s');
        $post['order']['vendorId'] = $post['vendorId'];

        $this->setAmountAndServiceFee($post);

        if (!empty($post['order']['date']) && !empty($post['order']['time'])) {
            $orderDate = explode(' ', $post['order']['date']);
            $post['order']['created'] = $orderDate[0] . ' ' . $post['order']['time'];
        }

        if (!$this->shoporder_model->setObjectFromArray($post['order'])->create()) {
            return 0;
        }
        return $this->shoporder_model->id;
    }

    private function sendEmailReceipt($paid): void
    {
        if ($paid === $this->config->item('orderPaid'))  {
            $this->shoporder_model->emailReceipt();
        }

        return;
    }

    private function insertOrderExtended($post, int &$orderId): void
    {
        if (!$orderId) return;

        // insert order details
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
                    'orderId' => $orderId,
                    'quantity' => $details['quantity'],
                    'remark' => $remark,
                    'mainPrductOrderIndex' => $mainPrductOrderIndex,
                    'subMainPrductOrderIndex' => $subMainPrductOrderIndex,
                ];
                if (!$this->shoporderex_model->setObjectFromArray($insert)->create()) {
                    $this->shoporderex_model->orderId = $insert['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                }
            } else {
                if (!isset($insertAll[$id])) {
                    $insertAll[$id] = [
                        'productsExtendedId' => intval($id),
                        'orderId' => $orderId,
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
                $this->shoporderex_model->orderId = $orderId;
                $this->shoporderex_model->deleteOrderDetails();
                $this->shoporder_model->setObjectId($orderId)->delete();
                $orderId = 0;
            }
        }
        return;
    }

    private function insertOrderExtendedRefactored(array $insertValues, int &$orderId): void
    {   
        if (!$orderId) return;
        foreach ($insertValues as $key => $item) {
            $insertValues[$key]['orderId'] = $orderId;
        }

        if (!$this->shoporderex_model->multipleCreate($insertValues)) {
            $this->shoporderex_model->orderId = $orderId;
            $this->shoporderex_model->deleteOrderDetails();
            $this->shoporder_model->setObjectId($orderId)->delete();
            $orderId = 0;
        }
        return;
    }

    private function payingWithVoucher(array $order): bool
    {
        return $this->shopvoucher_model
                ->setObjectId(intval($order['voucherId']))
                ->setVoucher()
                ->payOrderWithVoucher(floatval($order['voucherAmount']));
    }

    private function voucherPaymentFailed(array $orderData, string $orderRandomKey): void
    {
        if (!empty($orderData['order']['voucherId']) && !empty($orderData['order']['voucherAmount']) && !$this->payingWithVoucher($orderData['order'])) {
            Jwt_helper::unsetVoucherData($orderData, $orderRandomKey);
            $this->session->set_flashdata('error', '(1082) Order not made! Voucher is not valid');

            $this->failedRedirect($orderData['vendorId'], $orderData['spotId'],  $orderRandomKey);
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

    public function sendNotifictaion(array $post, int $orderId, string $payStatus): void
    {

        if (intval($post['pos']) || $payStatus !== $this->config->item('orderPaid')) return;

        $this->user_model->setUniqueValue($post['vendorId'])->setWhereCondtition()->setUser('oneSignalId');

        $this->notification_model->sendNotifictaion($post['vendorId'], $post['user']['email'], $orderId, $this->user_model->oneSignalId);
    }

}

