<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    Class Receiptprint_helper
    {

        public static function printPrinterReceipt(array $order): void
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->helper('print_helper');

            $imageprint = new Imagick();
            $imagetext = new Imagick();
            $draw = new ImagickDraw();

            $logoFile = (is_null($order['vendorLogo'])) ? FCPATH . "/assets/home/images/tiqslogonew.png" : $CI->config->item('uploadLogoFolder') . $order['vendorLogo'];
            $productsarray = explode($CI->config->item('contactGroupSeparator'), $order['products']);
            $countProducts = count($productsarray);
            $serviceTypeId = intval($order['serviceTypeId']);

            self::imageTextAndDrawSettings($imagetext, $draw, $countProducts);

            // Print_helper::printImageLogo($imageprint, $logoFile);

            $h = 1;
            
            self::printReceiptHeader($CI, $draw, $imagetext, $h, $order, $serviceTypeId);

            $i = 0;
            $hd = $h * 35;

            foreach ($productsarray as $index => $product) {
                $product = explode($CI->config->item('concatSeparator'), $product);
                if (intval($product[10])) $product[9] = $product[10];
                $productsarray[$index] = $product;
            }
            $productsarray = Utility_helper::resetArrayByKeyMultiple($productsarray, '9');
            
            $numberoflines = self::printPrinterProducts($CI, $imagetext, $productsarray, $i, $hd);

            self::printOrderRemarks($draw, $numberoflines, $order['remarks'], $hd);

            $imagetext->drawImage($draw);
            $imageprint->addImage($imagetext);
            $imageprint->resetIterator();
            $resultpngprinter = $imageprint->appendImages(true);

            $resultpngprinter->setImageFormat('png');
            $receipt = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'] . '_' . $order['printerId'] .'.png';

			// $resultpngprinter->setImageFormat('jpg');
			// $receipt = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'] . '_' . $order['printerId'] .'.jpg';

			if (file_put_contents($receipt, $resultpngprinter) && ENVIRONMENT !== 'development') {
				$logFile = FCPATH . 'application/tiqs_logs/write-error.txt';
				//Utility_helper::logMessage($logFile, 'file order written to server: ' .$receipt);
            }

            header('Content-type: image/png');
            echo $resultpngprinter;

            $imageprint->destroy();
            $imagetext->destroy();
            $draw->destroy();

        }

        public static function printPrinterProducts(object $CI, object &$imagetext, array $productsarray, int &$i, int &$hd): int
        {
            $receiptMain = new ImagickDraw();
            $receiptMain->setFontSize(30);

            foreach ($productsarray as $mainIdnex => $products) {
                Utility_helper::array_sort_by_column($products, '10');
                foreach($products as $product) {
                   
                    // 0 => name
                    // 1 => unit price
                    // 2 => ordered quantity
                    // 3 => category
                    // 4 => category id
                    // 5 => shortDescription
                    // 6 => longDescription
                    // 7 => vatpercentage
                    // 8 => remark

                    $title =  substr($product[0], 0, 27);
                    $titleorder = substr($product[0], 0, 37);
                    $price = $product[1];
                    $quantity = $product[2];
                    $plu =  $product[3];
                    $shortDescription = $product[5];
                    $longDescription = $product[6];
                    $vatpercentage = $product[7];
                    $remark = $product[8];                   

                    $receiptMain->setTextAlignment(\Imagick::ALIGN_LEFT);
                    if (intval($product[10])) { // addon
                        $receiptMain->setStrokeColor('black');
                        $receiptMain->setStrokeWidth(1);
                        $receiptMain->setTextAlignment(\Imagick::ALIGN_LEFT);
                        $receiptMain->annotation(20, $hd + ($i * 30), $quantity);

                        $receiptMain->setTextAlignment(\Imagick::ALIGN_LEFT);
                        $receiptMain->annotation(60, $hd + ($i * 30), $titleorder);

                        if ($remark) {
                            $i++;
                            $receiptMain->setTextAlignment(\Imagick::ALIGN_LEFT);
                            $receiptMain->annotation(60, $hd + ($i * 30), $remark);;
                        }
                    } else {
                        $receiptMain->setStrokeColor('black');
                        $receiptMain->setStrokeWidth(3);
                        $receiptMain->setTextAlignment(\Imagick::ALIGN_LEFT);
                        $receiptMain->annotation(0, $hd + ($i * 30), $quantity);

                        $receiptMain->setTextAlignment(\Imagick::ALIGN_LEFT);
                        $receiptMain->annotation(40, $hd + ($i * 30), $titleorder);

                        if ($remark) {
                            $i++;
                            $receiptMain->setTextAlignment(\Imagick::ALIGN_LEFT);
                            $receiptMain->annotation(40, $hd + ($i * 30), $remark);;
                        }
                    }
                    $i++;
                }
            }

            $imagetext->drawImage($receiptMain);
            return $i;
        }

        public static function imageTextAndDrawSettings(object &$imagetext, object &$draw, int $countProducts): void
        {
            $pixel = new ImagickPixel('white');
            $rowheight = ($countProducts * 30) + 550;
            $imagetext->newImage(576, $rowheight, $pixel);

            /* Black text */
            $draw->setFillColor('black');

            switch (strtolower($_SERVER['HTTP_HOST'])) {
                case 'tiqs.com':
                    $draw->setFont('Helvetica');
                    break;

                default:
                    if (ENVIRONMENT === 'development') break;
                    $draw->setFont('Arial');
                    break;
            }

            $draw->setStrokeWidth(2);
            $draw->setFontSize(28);
            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            
            $pixel->destroy();
        }

        public static function printReceiptHeader(object $CI, object &$draw, object &$imagetext, int &$h, array $order, int $serviceTypeId, bool $isMobile = false): void
        {
            $draw->setStrokeColor('black');
            $draw->setStrokeWidth(1);
            $draw->setFontSize(30);
            $draw->setStrokeWidth(3);

            if (in_array($order['paymentType'], $CI->config->item('cashPaymentTypes'))) {
                $paymetnMethod = 'PAY METHOD: PAY AT THE WAITER';
            } else {
                $paymetnMethod = $order['paymentType'];
            }
            $draw->annotation(0, 35 * $h, $paymetnMethod);
            $h++;



            if (!$isMobile) {
                if ($serviceTypeId === $CI->config->item('local')) {
                    $draw->annotation(0, 35 * $h, "DIT IS GEEN GELDIG BTW TICKET");
                } elseif ($serviceTypeId === $CI->config->item('deliveryType')) {
                    $draw->annotation(0, 35 * $h, "DIT IS GEEN GELDIG BTW TICKET");
                } elseif ($serviceTypeId === $CI->config->item('pickupType')) {
                    $draw->annotation(0, 35 * $h, "DIT IS GEEN GELDIG BTW TICKET");
                }
            }

            $draw->setStrokeWidth(2);
            $draw->setFontSize(28);
            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            $h++;
            $draw->annotation(0, 35 * $h , "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);
            $draw->setStrokeWidth(2);
            $h++;

            if ($serviceTypeId === $CI->config->item('local')) {
                $draw->annotation(0,  35 * $h, "DATE". date("d-m H:i:s",strtotime($order['orderCreated'])). " spot: ". $order['spotName'] );
            } elseif ($serviceTypeId === $CI->config->item('deliveryType')) {
                $draw->annotation(0,  35 * $h, "DELIVERY ON : ". date("d-m H:i:s",strtotime($order['orderCreated'])));
                $h++;
                $draw->annotation(0,  35 * $h, "Phone : ". $order['buyerMobile'] );
                $h++;
                $draw->annotation(0,  35 * $h, "Address: ". $order['buyerAddress'] );
                $h++;
                $draw->annotation(0,  35 * $h, $order['buyerZipcode']. " " . $order['buyerCity'] );
            } elseif ($serviceTypeId === $CI->config->item('pickupType')) {
                $draw->annotation(0,  35 * $h, "PICK-UP at : ". date("d-m H:i:s",strtotime($order['orderCreated'])));
            }

            $draw->setStrokeWidth(1);
            $draw->setFontSize(30);
            $draw->setStrokeWidth(3);

            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            if (!$isMobile) {
                $h++;
                $h++;
                $imagetext->annotateImage($draw, 0,35 * $h, 0, "#");
                $imagetext->annotateImage($draw, 40,35 * $h, 0, "OMSCHRIJVING");
            }            
            if ($order['paidStatus'] === $CI->config->item('orderCashPaying')) {
                $imagetext->annotateImage($draw, 295, 35 * $h, 0, "CASH PAYMENT");
            }

            $h++;

            $draw->setStrokeWidth(5);
            $draw->line(0, 35 * $h, 576, 35 * $h);
            $draw->setStrokeWidth(1);

            $h++;
        }

        public static function printOrderRemarks(object &$draw, int &$i, ?string $orderRemarks, int $hd): void
        {
            if ($orderRemarks) {
                $i = $i + 2;
                $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                $draw->annotation(0, $hd + ($i * 35), 'ORDER REMARK ');
                $i++;
                $draw->annotation(0, $hd + ($i * 35), $orderRemarks);
                $i++;
            }
        }

        public static function printAllReceipts (int $orderId): void
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->model('shoporder_model');
            $CI->load->helper('print_helper');

            $imageprint = new Imagick();
            $imagetext = new Imagick();
            $draw = new ImagickDraw();

            $order = $CI->shoporder_model->setObjectId($orderId)->fetchOrdersForMobileReceipt();
            $logoFile = (is_null($order['vendorLogo'])) ? FCPATH . "/assets/home/images/tiqslogonew.png" : $CI->config->item('uploadLogoFolder') . $order['vendorLogo'];
            $productsarray = explode($CI->config->item('contactGroupSeparator'), $order['products']);
            $countProducts = count($productsarray);
            $serviceTypeId = intval($order['serviceTypeId']);
            $spotPrinter = $order['spotPrinter'];

            self::imageTextAndDrawSettings($imagetext, $draw, $countProducts);

            $h = 1;

            self::printReceiptHeader($CI, $draw, $imagetext, $h, $order, $serviceTypeId, true);

            $i = 0;
            $hd = $h * 35;

            foreach ($productsarray as $index => $product) {
                $product = explode($CI->config->item('concatSeparator'), $product);
                if (intval($product[10])) $product[9] = $product[10];
                $productsarray[$index] = $product;
            }
            $productsarray = Utility_helper::resetArrayByKeyMultiple($productsarray, '12');
            $productsarray = array_map(function($el) {
                return Utility_helper::resetArrayByKeyMultiple($el, '9');
            }, $productsarray);

            foreach ($productsarray as $data) {
                $i++;
                $printer = empty($data[0][0][13]) ? $spotPrinter : $data[0][0][13];
                $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                $draw->annotation(0, $hd + ($i * 30), 'PRINTER: ' . $printer);
                $i++;
				$numberoflines = self::printPrinterProducts($CI, $imagetext, $data, $i, $hd);
            }

            self::printOrderRemarks($draw, $numberoflines, $order['remarks'], $hd);

            $imagetext->drawImage($draw);
            $imageprint->addImage($imagetext);
            $imageprint->resetIterator();
            $resultpngprinter = $imageprint->appendImages(true);
            $resultpngprinter->setImageFormat('png');

            $receipt = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'] . '-mobile.png';
			if (file_put_contents($receipt, $resultpngprinter) ) {
                if (ENVIRONMENT !== 'development') {
                    $logFile = FCPATH . 'application/tiqs_logs/write-error.txt';
//                    Utility_helper::logMessage($logFile, 'file order written to server: ' .$receipt);
                }
            }

            $imageprint->destroy();
            $imagetext->destroy();
            $draw->destroy();
        }
    }
