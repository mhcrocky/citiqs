<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Orders extends REST_Controller
    {
        private $trackPrinterFile = FCPATH . 'application/tiqs_logs/track_printer.txt';

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopprinters_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('shopvendor_model');
            $this->load->model('shopprinterrequest_model');
            $this->load->model('shopvendorfod_model');
            $this->load->model('shopreportrequest_model');

            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');
            $this->load->helper('sanitize_helper');            
            $this->load->helper('email_helper');
            $this->load->helper('curl_helper');
            $this->load->helper('receiptprint_helper');
            $this->load->helper('orderprint_helper');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('notificationvendor');
        }

		public function index_delete()
		{
			return;
        }

        public function data_get()
        {
            $mac = $this->getMacNumber();

            // first set printer from mac number
            $this->shopprinters_model->setPrinterIdFromMacNumber($mac)->setObject();

            // print finance report
            $this->printFinanceReport($mac);

            //get order to print
            $order = $this->getOrder($mac);

            // get utility data
            list($fodUser, $orderExtendedIds, $printOnlyReceipt) = $this->getRequiredInfo($order);

            // do printing job
            $this->printOrderAndReceipts($order, $fodUser, $orderExtendedIds, $printOnlyReceipt);

            // final updates
            $this->doFinalUpdates($order, $orderExtendedIds);

            // send message
            $this->sendMessages($order);

            return;
            // $this->callOrderCopy($order, $fodUser);
        }

        private function isCashpayment(array $order): bool
        {
            if (
                $order['paymentType'] === $this->config->item('prePaid')
                || $order['paymentType'] === $this->config->item('postPaid')
                || $order['paymentType'] === $this->config->item('pinMachinePayment')
                // if voucher payment and pos orders
                || ( $order['paymentType'] === $this->config->item('voucherPayment') && $order['orderIsPos'] === '1' )
            ) {
                return true;
            }
            return false;
        }

        private function handlePrePostPaid(array $order, bool $fodUser): void
        {
            if ($fodUser) {   
                return;
            }
            if ($this->isCashpayment($order)) {

                if ($order['waiterReceipt'] === '0') {
                    header('Content-type: image/png');
                    echo file_get_contents(base_url() . 'Api/Orderscopy/data/' . $order['orderId']);
                    $this->shoporder_model->setObjectId(intval($order['orderId']))->setProperty('waiterReceipt', '1')->update();
                    exit;
                }

                if ($order['customerReceipt'] === '0') {
                    header('Content-type: image/png');
                    echo file_get_contents(base_url() . 'Api/Orderscopy/data/' . $order['orderId']);
                    $this->shoporder_model->setObjectId(intval($order['orderId']))->setProperty('customerReceipt', '1')->update();
                    exit;
                }

                if ($order['paidStatus'] === $this->config->item('orderNotPaid') && $order['orderIsPos'] === '0') exit;
            }
        }


        private function getMacNumber(): string
        {
            $mac = $this->input->get('mac', true);
            if (!$mac) exit;

            if (
                !$this->shopprinters_model->setProperty('macNumber', $mac)->checkIsPrinterActive()
                || !$this->shopprinterrequest_model->insertPrinterRequest($mac)
            ) exit;

            return $this->shopprinters_model->setProperty('macNumber', $mac)->printMacNumber();
        }

        private function getOrder(string $mac): array
        {
            $order = $this->shoporder_model->fetchOrdersForPrint($mac);

            if (!$order) exit;

            $order = reset($order);

            $this->checkoOrderTime($order);

            // if we have an order, update shopprinterrequest_model
            $this->shopprinterrequest_model->setObjectFromArray(['orderId' => $order['orderId']])->update();

            return $order;
        }

        private function checkoOrderTime(array $order): void
        {
            $printTimeConstraint = $this->shopvendor_model->setProperty('vendorId', $order['vendorId'])->getPrintTimeConstraint();
            // order expiration settings
            if (strtotime($printTimeConstraint) > strtotime($order['orderCreated'])) {
                $this->shoporder_model->setObjectId(intval($order['orderId']))->updateExpired('1');
                exit;
            }
        }

        private function callOrderCopy(array $order, bool $fodUser): void
        {
            if (
                !($order['paymentType'] === $this->config->item('prePaid') || $order['paymentType'] === $this->config->item('postPaid'))
                && !$fodUser
            ) {
                file_get_contents(base_url() . 'Api/Orderscopy/data/' . $order['orderId']);
            }
        }

        /**
         * 
         * PRINTER FIRST SEND POST REQUEST TO CHECK IS ANY JOB TO PRINT
         * 
         * IF JOB IS TRUE, HE SEND GET REQUEST
         *
         * @return void
         */
        public function data_post()
        {
			// $file = FCPATH . 'application/tiqs_logs/messages.txt';
			// Utility_helper::logMessage($file, 'printer send post request');
            // Check is valid POST request type

			// DO HERE CHECK IF PRINTER CONNECTED NOT AT GET BECAUSE THAN WE KNOW IT IS...

            if (strtolower($_SERVER['CONTENT_TYPE']) !== 'application/json')
			{
                //Utility_helper::logMessage($file, 'printer send post request CONTENT TYPE');
				return;
			}


            // Get JSON payload recieved from the request and parse it
            // $parsedJson = Sanitize_helper::sanitizePhpInput();
			// Utility_helper::logMessage($file, 'printer send post request passed JSON');

            // $parsedJson = Sanitize_helper::sanitizePhpInput();
			$parsedJson = file_get_contents("php://input");
			$parsedJson = json_decode($parsedJson, true);

			// Validate JSON params
            if (!isset($parsedJson['printerMAC']) || !isset($parsedJson['statusCode']) || !isset($parsedJson['status'])){
				// Utility_helper::logMessage($file, 'printer send post request passed JSON MAC ERROR'.$parsedJson['printerMAC']);
				// Utility_helper::logMessage($file, 'printer send post request passed JSON STATUS CODEERROR'.$parsedJson['statusCode']);
				// Utility_helper::logMessage($file, 'printer send post request passed JSON STATUS ERROR'.$parsedJson['status']);
				return;
			}

    
            if (!Sanitize_helper::isValidMac($parsedJson['printerMAC'])) {
				// Utility_helper::logMessage($file, 'printer send post request passed MAC ERROR');
				return;
            } else {
                $this->shopprinterrequest_model->insertPrinterRequest($parsedJson['printerMAC']);
            };


            // Utility_helper::logMessage($file, 'Printer MAC:' .  $parsedJson['printerMAC']);
            // If the JSON request contains a request object in the clientAction then the printer is responding to a additional information
            // request (i.e. to get variables like the poll interval from the printer), so in this case the $path variable is set to
            // additional_communication.json to save this additional data
            if (isset($parsedJson["clientAction"][0]["request"])) {
                $arr = array("jobReady" => false);
                // Utility_helper::logMessage($file, 'JOB NOT READY => 1');
            } else {
                if ($this->shopreportrequest_model->checkRequests($parsedJson['printerMAC'])) {
                    $arr = [
                        "jobReady" => true,
                        // "mediaTypes" => array('text/plain','image/png', 'image/jpeg'));
                        "mediaTypes" => array('image/png')
                        // "deleteMethod" => "GET");
                    ];
                    $this->set_response($arr, 200); // CREATED (201) being the HTTP response code
                    return;
                }
                // er is een bon betaald
                // nu gaan we de bon opbouwen in printqueue.tbl
                // daarvoor hebben we nodig
                // ordernr
                // vullen onderdelen
                // printed op 1 zetten.
                if ($this->shoporder_model->fetchOrdersForPrint($parsedJson['printerMAC'])) {
                    $arr = [
                        "jobReady" => true,
                        // "mediaTypes" => array('text/plain','image/png', 'image/jpeg'));
                        "mediaTypes" => array('image/png')
                        // "deleteMethod" => "GET");
                    ];
                    //    Utility_helper::logMessage($file, 'JOB READY => ');
                } else {
                    $arr = array("jobReady" => false);
                    // Utility_helper::logMessage($file, 'JOB NOT READY => 2');
                }
            }
    
            $this->set_response($arr, 200); // CREATED (201) being the HTTP response code
        }

        public function sms_get(): void
        {
            $orders = $this->shoporder_model->ordersToSendSmsToDriver();
            if (!is_null($orders)) {
                foreach ($orders as $order) {
                    if (
                        ($order['delayTime'] || intval($order['delayTime']) === 0)
                        && $order['driverNumber']
                        && (strtotime($order['orderCreated']) < strtotime(date('Y-m-d H:i:s', strtotime('-' . $order['delayTime'] . ' minutes'))))
                    ) {
                        $message  = $order['driverSmsMessage'] . ' ';
                        $message .= 'Order id is "' . $order['orderId'] . '" ';
                        $message .= 'and spot name is "' . $order['spotName'] . '" ';
                        if (Curl_helper::sendSmsNew($order['driverNumber'], $message)) {
                            $this
                                ->shoporder_model
                                    ->setObjectId(intval($order['orderId']))
                                    ->setObjectFromArray(['sendSmsDriver' => '1'])
                                    ->update();
                        } else {
                            $file = FCPATH . 'application/tiqs_logs/messages.txt';
                            $errorMessage = 'SMS NOT SENT TO DRIVER FOR ORDER ID: ' . $order['orderId'];
                            Utility_helper::logMessage($file, $errorMessage);
                        }
                    }
                }
            }
            exit();
        }

        public function updateTwoToZero_get(): void
        {
            $this->shoporderex_model->updateTwoToZero();
        }

        private function printFinanceReport($mac): void
        {
            return;

            if ($this->shopprinters_model->printReports === '0') return;
            $data = $this->shopreportrequest_model->checkRequests($mac);
            if (!$data) return;

            $this->shopreportrequest_model->id = intval(Utility_helper::getAndUnsetValue($data, 'id'));

            $data['finance'] = '1';
            $data['datetimefrom'] = str_replace(' ', 'T', $data['datetimefrom']);
            $data['datetimeto'] = str_replace(' ', 'T', $data['datetimeto']);

            $url = base_url() . 'api/report?' . http_build_query($data);
            $content = file_get_contents($url);
            if (!$content) return;
            $response = json_decode($content);

            if ($response->status === '1') {
                $report = $this->config->item('financeReportes') . $data['vendorid'] . '_' . $data['report'] . '.png';
                header('Content-type: image/png');
                echo file_get_contents($report);
                unlink($report);
                $this->shopreportrequest_model->setProperty('printed', '1')->update();
                exit();
            }

            return;
        }

        private function getRequiredInfo(array $order): array
        {
            $vendorId = intval($order['vendorId']);
            $fodUser = $this->shopvendorfod_model->isFodVendor($vendorId);
            $orderExtendedIds = explode(',', $order['orderExtendedIds']);
            $printOnlyReceipt = $this->shopvendor_model->setProperty('vendorId', $vendorId)->getProperty('printOnlyReceipt') === '1' ? true : false;

            return [$fodUser, $orderExtendedIds, $printOnlyReceipt];
        }

        private function printOrderAndReceipts(array $order, bool $fodUser, array $orderExtendedIds, bool $printOnlyReceipt): void
        {
            if (
                $printOnlyReceipt
                && $order['paidStatus'] ===  $this->config->item('orderPaid')
                && $this->shopprinters_model->printReceipts === '1'
                && $this->isCashpayment($order)
            ) {
                header('Content-type: image/png');
                echo file_get_contents(base_url() . 'Api/Orderscopy/receipt/' . $order['orderId']);
            } else {
                if ($this->shopprinters_model->printReceipts === '1') {
                    $this->handlePrePostPaid($order, $fodUser);
                    $this->shoporderex_model->updatePrintStatus($orderExtendedIds, '2');
                }
                Receiptprint_helper::printPrinterReceipt($order);
            }
        }

        private function doFinalUpdates(array $order, array $orderExtendedIds): void
        {
            $this->shopprinterrequest_model->setObjectFromArray(['printerEcho' => date('Y-m-d H:i:s')])->update();
            $this->shoporderex_model->updatePrintStatus($orderExtendedIds, '1');

            if ($order['paidStatus'] === '1') {
                $this->shoporder_model->updatePrintedStatus();
            }
        }

        private function sendMessages(array $order): void
        {
            $search = $this->config->item('messageToBuyerTags');
            $replace = [$order['orderId'], $order['buyerUserName']];
            $message = str_replace ($search, $replace, $this->shopprinters_model->messageToBuyer);

            // send buyer sms
            if ($this->shopprinters_model->sendSmsToBuyer === '1') {
                Curl_helper::sendSmsNew($order['buyerMobile'], $message);
            }

            // send message to vendor
            if ($order['oneSignalId']) {
                $this->notificationvendor->sendVendorMessageImproved($order['oneSignalId'], intval($order['orderId']), $message);
            }
            return;
        }


    }
