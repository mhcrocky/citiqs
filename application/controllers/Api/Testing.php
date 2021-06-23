<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Testing extends REST_Controller
    {
        //if slave printer send request this will be value of masterMacNumber
        private $macToFetchOrder;
        private $fodUser;
        private $printOnlyReceipt;
        private $printTimeConstraint;

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

        /**
         * CHECK PRINTER POST REQUEST WHEN WORK ON THIS METHOD
         *
         * @see data_post
         * @return void
         */
        public function data_get()
        {
            $mac = $this->input->get('mac', true);
            if (!$mac) exit;

            $this->setPrinterAndMacToFetchOrder($mac);

            // print finance report
            $this->printFinanceReport($mac);

            if (Utility_helper::testingVendors($this->shopprinters_model->userId)) {
                $this->setVendorInfo();
                $this->printReceipt();
                $this->printOrder();
            } else {
                //get order to print
                $order = $this->getOrder();

                // get utility data
                list($fodUser, $orderExtendedIds, $printOnlyReceipt) = $this->getRequiredInfo($order);

                // send message
                $this->sendMessages($order);

                // do printing job
                $this->printOrderAndReceipts($order, $fodUser, $orderExtendedIds, $printOnlyReceipt);

                $this->doFinalUpdates($order, $orderExtendedIds);
            }

            return;
            // $this->callOrderCopy($order, $fodUser);
        }



        /**
         * 
         * PRINTER FIRST SENDS POST REQUEST TO CHECK IS ANY JOB TO PRINT
         * 
         * IF JOB IS TRUE, IT SENDS GET REQUEST
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
                $this->setPrinterAndMacToFetchOrder($parsedJson['printerMAC']);
                $this->setVendorInfo();
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

                if (Utility_helper::testingVendors($this->shopprinters_model->userId)) {
                    if (
                        $this->shoporder_model->fetchOrdersForPrint($this->macToFetchOrder, $this->printTimeConstraint)
                        || $this->shoporder_model->getOrderReceipt($this->shopprinters_model->userId, $this->printTimeConstraint)
                    ) {
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
                } else {
                    if ($this->shoporder_model->fetchOrdersForPrint($this->macToFetchOrder)) {
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
            }

            $this->set_response($arr, 200); // CREATED (201) being the HTTP response code
        }

        /**
         * Cron job to send sms vategory driver
         *
         * @return void
         */
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

        /**
         * Cron job to update record print status from 2 to 0 in tbl_shop_order_extended
         *
         * @return void
         */
        public function updateTwoToZero_get(): void
        {
            $this->shoporderex_model->updateTwoToZero();
        }

        private function printFinanceReport($mac): void
        {

            if ($this->shopprinters_model->printReports === '0') return;
            $data = $this->shopreportrequest_model->checkRequests($mac);

            if (is_null($data)) return;

            $this->shopreportrequest_model->id = intval(Utility_helper::getAndUnsetValue($data, 'id'));

            $data['finance'] = '1';
            $data['datetimefrom'] = str_replace(' ', 'T', $data['datetimefrom']);
            $data['datetimeto'] = str_replace(' ', 'T', $data['datetimeto']);

            $url = base_url() . 'api/report?' . http_build_query($data);
            $content = file_get_contents($url);
            if (!$content) return;
            $response = json_decode($content);

            if ($response && $response->status === '1') {
                $report = $this->config->item('financeReportes') . $data['vendorid'] . '_' . $data['report'] . '.png';
                header('Content-type: image/png');
                echo file_get_contents($report);
                unlink($report);
                $this->shopreportrequest_model->setProperty('printed', '1')->update();
                exit();
            }

            return;
        }

        private function setVendorInfo(): void
        {
            $vendorId = $this->shopprinters_model->userId;
            $this->shopvendor_model->setProperty('vendorId', $vendorId);

            $this->fodUser = $this->shopvendorfod_model->isFodVendor($vendorId);
            $this->printOnlyReceipt = $this->shopvendor_model->getProperty('printOnlyReceipt') === '1' ? true : false;
            $this->printTimeConstraint = $this->shopvendor_model->getPrintTimeConstraint();

            return;
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

        private function doFinalUpdates(array $order, array $orderExtendedIds): void
        {
            $this->shopprinterrequest_model->setObjectFromArray(['printerEcho' => date('Y-m-d H:i:s')])->update();
            $this->shoporderex_model->updatePrintStatus($orderExtendedIds, '1');

            if ($order['paidStatus'] === '1') {
                $this->shoporder_model->updatePrintedStatus();
            }
        }

        private function setPrinterAndMacToFetchOrder(string $mac): void
        {
            $this->shopprinters_model->setPrinterIdFromMacNumber($mac);

            if (is_null($this->shopprinters_model->id)) exit();

            $this->shopprinters_model->setObject();

            if (is_null($this->shopprinters_model->id) || $this->shopprinters_model->active === '0') exit();

            $this->shopprinterrequest_model->insertPrinterRequest($mac);
            $this->macToFetchOrder = empty($this->shopprinters_model->masterMac) ? $mac : $this->shopprinters_model->masterMac;

            return;
        }

        private function printOrder(): void
        {
            $order = $this->shoporder_model->fetchOrdersForPrint($this->macToFetchOrder, $this->printTimeConstraint);
            if (!$order) exit();

            $order = reset($order);
            $orderExtendedIds = explode(',', $order['orderExtendedIds']);

            if ($this->printOnlyReceipt && $this->isCashpayment($order)) {
                //update order printStatus so that printer can print receipt
                $this->doFinalUpdates($order, $orderExtendedIds);
                return;
            }

            $this->shopprinterrequest_model->setObjectFromArray(['orderId' => $order['orderId']])->update();
            $this->shoporderex_model->updatePrintStatus($orderExtendedIds, '2');
            $this->sendMessages($order);

            Receiptprint_helper::printPrinterReceipt($order);

            $this->doFinalUpdates($order, $orderExtendedIds);
            return;
        }

        private function printReceipt(): void
        {
            if ($this->shopprinters_model->printReceipts === '0' || $this->fodUser) return;

            $order = $this->shoporder_model->getOrderReceipt($this->shopprinters_model->userId, $this->printTimeConstraint);

            if (is_null($order)) return;

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

        // OLD

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


        private function getOrder(): array
        {
            $order = $this->shoporder_model->fetchOrdersForPrint($this->macToFetchOrder);

            if (!$order) exit();

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

        private function getRequiredInfo(array $order): array
        {
            $vendorId = intval($order['vendorId']);
            $fodUser = $this->shopvendorfod_model->isFodVendor($vendorId);

            $orderExtendedIds = explode(',', $order['orderExtendedIds']);
            $printOnlyReceipt = $this->shopvendor_model->setProperty('vendorId', $vendorId)->getProperty('printOnlyReceipt') === '1' ? true : false;

            return [$fodUser, $orderExtendedIds, $printOnlyReceipt];
        }
    }
