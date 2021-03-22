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
    

    public function onlinePayment($payNlPaymentTypeId, $paymentOptionSubId): void
    {
        $orderRandomKey = $this->input->get($this->config->item('orderDataGetKey'), true);

        if (empty($orderRandomKey)) redirect(base_url());

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        Jwt_helper::checkJwtArray($orderData, ['vendorId', 'spotId', 'user', 'orderExtended', 'order']);
        $this->isFodActive($orderData['vendorId'], $orderData['spotId']);

        $payType = $this->getPayType($payNlPaymentTypeId);

        if (!$payType) redirect(base_url());

        $this->voucherPaymentFailed($orderData, $orderRandomKey);

        $orderData['order']['paid'] = $this->config->item('orderNotPaid');
        $orderData['order']['paymentType'] = $payType;

        $orderId = $this->insertOrderProcess($orderData, $orderRandomKey);

        if (!$orderId) {
            $this->failedRedirect($orderData['vendorId'], $orderData['spotId'], $orderRandomKey);
        }

        $redirect  = 'paymentengine' . DIRECTORY_SEPARATOR . $payNlPaymentTypeId  . DIRECTORY_SEPARATOR . $paymentOptionSubId;
        $redirect .= DIRECTORY_SEPARATOR . $orderId;
        $redirect .= '?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;

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
        $orderId = $this->posPrintingPaying($post);

        if (is_null($orderId)) {
            $orderId = $this->insertOrderProcess($post, '');
        }

        $response = ['orderId' => $orderId];

        $this->posPaid($post, $response, $orderId);

        echo json_encode($response);
        return;
    }

    private function posPaid(array $post, array &$response, int $orderId): void
    {
        if ($post['order']['paid'] !== '1') return;

        $this->shopposorder_model->setProperty('orderId', $orderId)->deleteOrder();

        if ($post['order']['paymentType'] === $this->config->item('pinMachinePayment')) {
            $redirect  = 'paymentengine';
            $redirect .= DIRECTORY_SEPARATOR . $this->config->item('pinMachinePaymentType');
            $redirect .= DIRECTORY_SEPARATOR . $this->config->item('pinMachineOptionSubId');
            $redirect .= DIRECTORY_SEPARATOR . $orderId;

            $response['redirect'] = $redirect;    
        }

        return;
    }

    private function posPrintingPaying(array $post): ?int
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
                if ($post['order']['paid'] === '1') {
                    $this->saveOrderImage($orderId);
                    $this
                        ->shoporder_model
                        ->setObjectId($orderId)
                        ->setProperty('createdOrder', date('Y-m-d H:i:s'))
                        ->setProperty('paid', '1')
                        ->update();
                }
                return $orderId;
            }
        }

        return null;
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

        if ($vendorId === 1162 || $vendorId === 5655) {
            $redirect = base_url() . 'successth';
        } else {
            $redirect = base_url() . 'success?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey . '&orderid=' . $orderId;
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
        } elseif ($payNlPaymentTypeId === $this->config->item('myBankPaymentType')) {
            $payType = $this->config->item('myBankPayment');
        }

        return $payType;
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

        if (!empty($post['order']['date']) && !empty($post['order']['time'])) {
            $orderDate = explode(' ', $post['order']['date']);
            $post['order']['created'] = $orderDate[0] . ' ' . $post['order']['time'];
        }

        if (!$this->shoporder_model->setObjectFromArray($post['order'])->create()) {
            return 0;
        }
        return $this->shoporder_model->id;
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
        if (intval($post['pos'])) return;
        $vendor = $this->shopvendor_model->setProperty('vendorId', $post['vendorId'])->getVendorData();
        if ($payStatus === $this->config->item('orderPaid') && $vendor['oneSignalId']) {
            $this->notificationvendor->sendVendorMessage($vendor['oneSignalId'], $orderId);
        }
    }

    public function posSendNoticication($orderId, $oneSignalId): void
    {
        $orderId = intval($orderId);
        if (!$orderId) return;
        $this->notificationvendor->sendVendorMessage($oneSignalId, $orderId);
    }
}

