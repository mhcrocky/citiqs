<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class BBOrders extends REST_Controller
    {
        private $jsonoutput=array();
        private $ProductLines=array();
        private $PaymentLines=array();

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopprinters_model');
            $this->load->model('shoporder_model2',"shoporder_model");
            $this->load->model('shoporderex_model');
            $this->load->model('shopvendor_model');
            $this->load->model('fodfdm_model');

            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');
            $this->load->helper('sanitize_helper');            
            $this->load->helper('email_helper');
            $this->load->helper('curl_helper');

            $this->load->config('custom');
            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function data_get()
        {
            // $logFile = FCPATH . 'application/tiqs_logs/messages.txt';
            // Utility_helper::logMessage($logFile, 'ordernumber ' .$orderId);

            $logFile = FCPATH . 'application/tiqs_logs/messages.txt';
            Utility_helper::logMessage($logFile, 'printer conected get');
            $get = $this->input->get(null, true);
            Utility_helper::logMessage($logFile, 'printer MAC '. $get['mac'] );
            if(!$get['mac']) return;


            //Check FDM Status 
            $FDMStatusByMac=$this->fodfdm_model->getFDMstatusByMac($get['mac']);
        	if(!empty($FDMStatusByMac) && $FDMStatusByMac->FDM_active==1){
        		return "";
        	}
        	//it will not proceed when FDM have an issue

            $order = $this->shoporder_model->fetchOrdersForPrint($get['mac']);
            if (!$order) return;
            $order = reset($order);

            // var_dump($order);
            // $order = $this->shoporder_model->fetchOrdersForPrintcopy($orderId);
            // if (!$order) return;
            // $order = reset($order);

            // if ($order['printStatus'] === '0') return;

			Utility_helper::logMessage($logFile, 'order vendor'.$order['vendorId']);

            $productsarray = explode($this->config->item('contactGroupSeparator'), $order['products']);
            // print_r($productsarray);die();
            $imageprint = new Imagick();
			$imageprintemail = new Imagick();

            if (is_null($order['vendorLogo'])) {
                $logoFile = FCPATH . "/assets/home/images/tiqslogonew.png";
            } else {
                $logoFile = $this->config->item('uploadLogoFolder') . $order['vendorLogo'];
            }
            $imagelogo = new Imagick($logoFile);
            $geometry = $imagelogo->getImageGeometry(); 

            $width = intval($geometry['width']);
            $height = intval($geometry['height']);
            $crop_width = 550;
            $crop_height = 150;
            $crop_x = intval(($width - $crop_width) / 2);
            $crop_y = intval(($height - $crop_height) / 2);
            $sizeheight = 300;
            $sizewidth = 576;

			$imagelogo->cropImage($crop_width, $crop_height, $crop_x, $crop_y);
			$imagelogo->setImageFormat('png');
			$imagelogo->setImageBackgroundColor(new ImagickPixel('white'));
			$imagelogo->extentImage($sizewidth, $sizeheight, -($sizewidth - $crop_width) / 2, -($sizeheight - $crop_height) / 2);

			$imageprint->addImage($imagelogo);
			$imageprintemail->addImage($imagelogo);

            //-------------- SPOT placement -------------------------

            $imagetext = new Imagick();
            $draw = new ImagickDraw();
            $pixel = new ImagickPixel('white');

			$imagetextemail = new Imagick();
			$drawemail = new ImagickDraw();
			$pixelemail = new ImagickPixel('white');

			/* New image */
            //--- aantal rows bepalen a.d. hand van aantal order regels.

            $rowheight = (count($productsarray) * 30) + 700;
			$rowheight2 = (count($productsarray) * 30) + 350;
            $imagetext->newImage(576, $rowheight2, $pixel);
            $imagetextemail->newImage(576, $rowheight, $pixel);

            /* Black text */
            $draw->setFillColor('black');
			$drawemail->setFillColor('black');

            switch (strtolower($_SERVER['HTTP_HOST'])) {
                case 'tiqs.com':
                    $draw->setFont('Helvetica');
					$drawemail->setFont('Helvetica');
                    break;

                default:
                    $draw->setFont('Arial');
					$drawemail->setFont('Arial');
                    break;
            }


			$draw->annotation(0, 30, "GEEN BTW BON");

			$draw->setStrokeWidth(2);
			$draw->setFontSize(28);
			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);

			$drawemail->setStrokeWidth(2);
			$drawemail->setFontSize(28);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

			$h = 1;

			if($order['serviceTypeId']==1){
				$draw->annotation(0, 35 * $h, "GEEN BTW BON / LOCAL ");
			}
			if($order['serviceTypeId']==2){
				$draw->annotation(0, 35 * $h, "GEEN BTW BON / DELIVERY ");
			}
			if($order['serviceTypeId']==3){
				$draw->annotation(0, 35 * $h, "GEEN BTW BON / PICKUP ");
			}
			$draw->setStrokeWidth(4);
			$draw->setFontSize(28);
			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);

			$drawemail->setStrokeWidth(4);
			$drawemail->setFontSize(28);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

			// $draw->annotation(0, 30, "SPOT: ". $result->spot_id . " EMAIL: " . $email . ' PHONE: ' . $phone);
			// $draw->annotation(0, 30, "SPOT: ". $result->spot_id );

			$h++;

			$draw->annotation(0, 35 * $h , "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);
			$drawemail->annotation(0,35 * $h , "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);


			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(2);

			$h++;

			if($order['serviceTypeId']==1){
				$draw->annotation(0,  35 * $h, "DATE". date("d-m h:i:sa",strtotime($order['orderCreated'])). " spot: ". $order['spotName'] );
			}
			if($order['serviceTypeId']==2){
				$draw->annotation(0,  35 * $h, "DELIVERY ON : ". date("d-m h:i:sa",strtotime($order['orderCreated'])));
				$h++;
				$draw->annotation(0,  35 * $h, "Phone : ". $order['buyerMobile'] );
				$h++;
				$draw->annotation(0,  35 * $h, "Address: ". $order['buyerAddress'] );
				$h++;
				$draw->annotation(0,  35 * $h, $order['buyerZipcode']. " " . $order['buyerCity'] );
			}

			if($order['serviceTypeId']==3){
				$draw->annotation(0,  35 * $h, "PICK-UP at : ". date("d-m h:i:sa",strtotime($order['orderCreated'])));
			}

			if($order['serviceTypeId']==1){
				$drawemail->annotation(0, 35 * $h, "DATE:". date("d-m h:i:sa",strtotime($order['orderCreated'])). " SPOT: ". $order['spotName'] );
			}
			if($order['serviceTypeId']==2){
				$drawemail->annotation(0, 35 * $h, "DELIVERY AT:". date("d-m h:i:sa",strtotime($order['orderCreated'])). " SPOT: ". $order['spotName'] );
			}
			if($order['serviceTypeId']==3){
				$drawemail->annotation(0, 35 * $h, "PICK-UP AT". date("d-m h:i:sa",strtotime($order['orderCreated'])). " spot: ". $order['spotName'] );
			}

			$h++;
			$h++;


			//-------- header regel --------
			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(1);
			$draw->setFontSize(30);
			$draw->setStrokeWidth(3);

			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
			$imagetext->annotateImage($draw, 0,35 * $h, 0, "#");
			$imagetext->annotateImage($draw, 40,35 * $h, 0, "OMSCHRIJVING");
			if ($order['paidStatus'] === $this->config->item('orderCashPaying')) {
				$imagetext->annotateImage($draw, 295, 35 * $h, 0, "CASH PAYMENT");
			}

			$h++;

			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(5);
			$draw->line(0, 35 * $h, 576, 35 * $h);
			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(5);
			$drawemail->line(0, 35 * $h, 576, 35 * $h);
			$drawemail->setStrokeWidth(1);

			$h++;

			$drawemail->setFontSize(22);
			$drawemail->setStrokeWidth(2);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
			$imagetextemail->annotateImage($drawemail, 0, 165, 0, "ANT");
			$imagetextemail->annotateImage($drawemail, 48, 165, 0, "OMSCHRIJVING");
			$imagetextemail->annotateImage($drawemail, 380, 165, 0, "PRIJS");
			$imagetextemail->annotateImage($drawemail, 475, 165, 0, "%");
			$imagetextemail->annotateImage($drawemail, 495, 165, 0, "TOTAAL");
			$h++;

			//-------- regels --------

			$totalamount = 0;
			$i = 0;
			$ii = 0;
			$hd = $h * 35;

			$Ttotalamount =0;
			// $T21totalamount=0;
			// $T9totalamount=0;
            $emailMessage = '';
            $productVats = [];

            foreach ($productsarray as $product) {

                $product = explode($this->config->item('concatSeparator'), $product);
                // 0 => name
                // 1 => unit price
                // 2 => ordered quantity
                // 3 => category
                // 4 => category id
                // 5 => shortDescription
                // 6 => longDescription
                // 7 => vatpercentage
                // 8 => productId

                $title = $product[0];
                $price = $product[1];
                $quantity = $product[2];
                $plu =  $product[3]; //????????????????
                $shortDescription = $product[5];
                $longDescription = $product[6];
                $vatpercentage = $product[7];



                $totalamount =  floatval($quantity) * floatval($price);
				$Stotalamount = sprintf("%.2f", $totalamount);

				$Ttotalamount = $Ttotalamount+$totalamount  ;
				$TStotalamount = sprintf("%.2f", $Ttotalamount);

				// if($vatpercentage==21){
				// 	$T21totalamount = $T21totalamount+($totalamount-(($totalamount/121)*100))  ;
				// }

				// if($vatpercentage==9){
				// 	$T9totalamount = $T9totalamount+($totalamount-(($totalamount/121)*100))  ;
                // }
                
                if (!isset($productVats[$vatpercentage])) {
                    $productVats[$vatpercentage] = 0;
                }

                $productVats[$vatpercentage] += $totalamount - $totalamount / (100 + intval($vatpercentage)) * 100;

				$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
				// $draw->annotation(0, $hd + ($i * 30), $plu);
				if (isset($subMainProductIndex) && isset($mainProductIndex) && $subMainProductIndex === $mainProductIndex) {
					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(20, $hd + ($i * 30), $quantity);

					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(60, $hd + ($i * 30), $title);
				} else {
					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(0, $hd + ($i * 30), $quantity);

					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(40, $hd + ($i * 30), $title);
				}

				$drawemail->setFontSize(18);
				$drawemail->setStrokeWidth(1);
				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
				// $draw->annotation(0, 165 + ($i * 30), $plu);

				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
				$drawemail->annotation(0, 165 + ($i * 30), $quantity);

				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
				$drawemail->annotation(40, 165 + ($i * 30), $title);

				$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$drawemail->annotation(440, 165 + ($i * 30), "€ ". $price);

				$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$drawemail->annotation(500, 165 + ($i * 30), $vatpercentage);

				$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$drawemail->annotation(570, 165 + ($i * 30), "€ ". $Stotalamount);


				$i++;

				//

                // $emailMessage .= '<p>';
                // $emailMessage .=    '<tr>';
                // $emailMessage .=        '<td>' . $quantity . '</td>';
                // $emailMessage .=        '<td>' . $title . '</td>';
                // $emailMessage .=        '<td>EURO ' . $price . '</td>';
                // $emailMessage .=    '</tr>';
                // $emailMessage .= '</p>';

                //added by Nadeem
                //set json product price and etc
                $price=(float)$price;
                $quantity=(int)$quantity;
                $this->ProductLines[]=  array(
                    "ProductGroupId"    =>  "PRGR".$product[4], // only categoryId !!! DONE
                    "ProductGroupName"  =>  $product[3], // categoryName !!! DONE
                    "ProductId"         =>  "PROD".$product[8], // productId !!! DONE
                    "ProductName"       =>  $title,
                    "Quantity"          =>  $quantity,
                    "QuantityUnit"      =>  "P",
                    "SellingPrice"      =>  (float)($price*$quantity),
                    "VatRateId"         =>  $this->returnVatGrade($vatpercentage),//"B",
                    "DiscountLines"     =>array(
                        // array(
                        // "DiscountId"        =>  "DISC002",
                        // "DiscountName"      =>  "Prod. discount10%",
                        // "DiscountType"      =>  "PRODUCTDISCOUNT",z`
                        // "DiscountGrouping"  =>  0,
                        // "DiscountAmount"    =>  1.19
                        // ),
                        // array(
                        // "DiscountId"        =>  "DISC001",
                        // "DiscountName"      =>  "Receipt. discount10%",
                        // "DiscountType"      =>  "RECEIPTDISCOUNT",
                        // "DiscountGrouping"  =>  0,
                        // "DiscountAmount"    =>  1.07
                        // ),
                    ),
                );
            }

			$ii = $i;


            // set end for the printer...


                //			$draw->setStrokeColor('black');
                //			$draw->setStrokeWidth(1);
                //			$draw->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
                //			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(1);
			$drawemail->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);


			$i++;
            //			$draw->setFontSize(18);
            //			$draw->setStrokeWidth(2);
            //			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            //			$imagetext->annotateImage($draw, 395, 165 + ($i * 30), 0, "TOTAAL");
            //			$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);
            //			$draw->annotation(570, 165 + ($i * 30), "€ ". $TStotalamount);


			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
			$imagetextemail->annotateImage($drawemail, 395, 165 + ($i * 30), 0, "TOTAAL");
			$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
			$drawemail->annotation(570, 165 + ($i * 30), "€ ". $TStotalamount);

				$i++;

            //			$draw->setStrokeColor('black');
            //			$draw->setStrokeWidth(4);
            //			$draw->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
            //			$draw->setStrokeWidth(1);

			//
			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(4);
			$drawemail->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);


			// $T21Stotalamount = sprintf("%.2f", $T21totalamount);
			// $T9Stotalamount = sprintf("%.2f", $T9totalamount);

			$i++;
            //			$imagetext->annotateImage($draw, 440, 165 + ($i * 30), 0, "BTW 21 % ");
            //			$draw->annotation(570, 165 + ($i * 30), "€ ". $T21Stotalamount);

			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

            //			$imagetextemail->setFontSize(18);
            //			$drawemail->setStrokeWidth(2);
            //			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
			//
			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            
            foreach ($productVats as $vat => $amount) {
                $amount = number_format($amount, 2);
                $amount = sprintf("%.2f", $amount);
                $imagetextemail->annotateImage($drawemail, 440, 165 + ($i * 30), 0, 'BTW ' . strval($vat) .' % ');
                $drawemail->annotation(570, 165 + ($i * 30), "€ ". $amount);
                $i++;
            }
            //added by nadeem

            $this->PaymentLines[]=array(
                "PaymentId"             =>  $order['orderId'], //ONLY ORDER ID WITHOUT PAY TESTING VERSION DONE
                "PaymentName"           =>  "Alfred",
                "PaymentType"           =>  "EFT",
                "Quantity"              =>  1,
                "PayAmount"             =>  (float)$TStotalamount,
                "ForeignCurrencyAmount" =>  0,
                "ForeignCurrencyISO"    =>  "",
                "Reference"             =>  $order['payNlTransactionId'], //PAYNL TRANSACTION ID !!! DONE !!!
            );
            $jsonoutput['TransactionDateTime']    =   gmdate(DATE_ATOM);//"2020-08-08T12:40:54";
            $jsonoutput['TransactionNumber']      =   (int)(("1000").(100000+$order['orderId']) );
            $jsonoutput['ordernumberr']           =   $order['orderId'];
			// $imagetextemail->annotateImage($drawemail, 440, 165 + ($i * 30), 0, "BTW 21 % ");
			// $drawemail->annotation(570, 165 + ($i * 30), "€ ". $T21Stotalamount);

			
            //			$imagetext->annotateImage($draw, 440, 165 + ($i * 30), 0, "BTW 9 % ");
            //			$draw->annotation(570, 165 + ($i * 30), "€ ". $T9Stotalamount);

			// $drawemail->setFontSize(18);
			// $drawemail->setStrokeWidth(1);
			// $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);

			//
			// $imagetextemail->annotateImage($drawemail, 440, 165 + ($i * 30), 0, "BTW 9 % ");
			// $drawemail->annotation(570, 165 + ($i * 30), "€ ". $T9Stotalamount);

			//-------- regels --------
			//
			//			$i++;
			//			$imagetext->annotateImage($draw, 0, 165 + ($i * 30), 0, $order['vendorName'] );

			$i++;
            //			$draw->setStrokeColor('black');
            //			$draw->setStrokeWidth(4);
            //			$draw->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
            //			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(4);
			$drawemail->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);


			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
			$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorName']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorName']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorAddress']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorAddress']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorZipcode']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorZipcode']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorCity']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorCity']);

			$i++;
			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorCountry']);

            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorCountry']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), "BTW:". $order['vendorVAT']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), "BTW:". $order['vendorVAT']);

			$i++;
            //			$draw->setStrokeColor('black');
            //			$draw->setStrokeWidth(4);
            //			$draw->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
            //			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(4);
			$drawemail->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), "BTW:". $order['vendorVAT']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            $drawemail->annotation(570, 165 + ($i * 30), 'EXcl terrasfee amount');
            $i++;
            $imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            $drawemail->annotation(570, 165 + ($i * 30), 'Terrasfee amount € ' . sprintf("%.2f", $order['serviceFee']));
            $i++;
            // $imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            $serviceFeeAmount = floatval($order['serviceFee']);
            $serviceFeeTaxAmount = $serviceFeeAmount - $serviceFeeAmount / (100 + intval($order['serviceFeeTax'])) * 100;
            $drawemail->annotation(
                570,
                165 + ($i * 30),
                'Terrasfee BTW  ' .  $order['serviceFeeTax'] . ' % ' .  sprintf("%.2f", $serviceFeeTaxAmount)
            );
			//-------- Text printen!  --------
            $imagetext->drawImage($draw);
			$imagetextemail->drawImage($drawemail);

            $imageprint->addImage($imagetext);
			$imageprintemail->addImage($imagetextemail);

            // ------------------ QRCode creation --------------------------

			// $imageqr = new Imagick();

            // QRcode::png("https://tiqs.nl", 'petersqr.png', QR_ECLEVEL_H, 15);
            // $imageqr ->readImage('petersqr.png');
            // $imageprint ->addImage($imageqr);

			//            $imagelogo = new Imagick($logoFile);
			//            $geometry = $imagelogo->getImageGeometry();
			//
			//            $width = intval($geometry['width']);
			//            $height = intval($geometry['height']);
			//            $crop_width = 600;
			//            $crop_height = 150;
			//            $crop_x = intval(($width - $crop_width) / 2);
			//            $crop_y = intval(($height - $crop_height) / 2);
			//            $sizeheight = 300;
			//            $sizewidth = 576;
			//
			//            $imagelogo->cropImage($crop_width, $crop_height, $crop_x, $crop_y);
			//            $imagelogo->setImageFormat('png');
			//            $imagelogo->setImageBackgroundColor(new ImagickPixel('white'));
			//            $imagelogo->extentImage($sizewidth, $sizeheight, -($sizewidth - $crop_width) / 2, -($sizeheight - $crop_height) / 2);
			//            $imageprint->addImage($imagelogo);

            // ---------------- Create the print -------------------------
            // $result = $imageprint->mergeImageLayers(imagick::LAYERMETHOD_COMPARECLEAR);
            $imageprint->resetIterator();
			$imageprintemail->resetIterator();

            $resultpngprinter = $imageprint->appendImages(true);
			$resultpngemail = $imageprintemail->appendImages(true);
            
            /* Output the image with headers */
            /* Give image a format */
            $resultpngprinter->setImageFormat('png');
			$resultpngemail->setImageFormat('png');
            $receipt = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'] . '.png';
			$receiptemail = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'].'-email' . '.png';
            if (!file_put_contents($receipt, $resultpngprinter)) {
                $receipt = '';
            }
			if (!file_put_contents($receiptemail, $resultpngemail)) {
				$receiptemail = '';
			}
            $receiptemailBasepath = base_url() . 'receipts/'.$order['orderId'].'-email' . '.png';
                
            
            // $image ->writeImage("peter.png");
			//            $imageqr->destroy();
            $imagetext->destroy();
            $imagelogo->destroy();
            $imageprint->destroy();
            $draw->destroy();

			$imagetextemail->destroy();
			$imagelogo->destroy();
			$imageprint->destroy();
			$draw->destroy();

			Utility_helper::logMessage($logFile, 'printer echo');
            // header('Content-type: image/png');
            // echo $resultpngprinter;
            
            // output here added by nadeem


            // UPDATE ORDER EXTENDED PRINT STATUS
            $orderExtendedIds = explode(',', $order['orderExtendedIds']);
            foreach ($orderExtendedIds as $id) {
                $this
                    ->shoporderex_model
                    ->setObjectId(intval($id))
                    ->setObjectFromArray(['printed' => '1'])
                    ->update();
            }

            if ($this->shoporder_model->updatePrintedStatus()) {
            }


            $jsonoutput['ProductLines']=$this->ProductLines;
            $jsonoutput['PaymentLines']=$this->PaymentLines;
            $jsonoutput['image']=$receiptemailBasepath;
            $jsonoutput['vendorId']=$order['vendorId'];
            $jsonoutput['lastNumber']=$this->fodfdm_model->getlastRecieptCount($order['vendorId']);
            // header('Content-type: image/png');
            echo json_encode($jsonoutput);

            // SEND EMAIL
            // $subject= "tiqs-Order : ". $order['orderId'] ;
            // $order['buyerEmail'] = 'pnroos@icloud.com';
            // $email = $order['buyerEmail'];
            // Email_helper::sendOrderEmail($email, $subject, $emailMessage, $receiptemail);
        }
        function updatelastRecieptCount_get($vendorId){
            $this->fodfdm_model->updatelastRecieptCount($vendorId);
        }
        private function returnVatGrade($vatpar){
            // retunr a or b or or d
            if($vatpar==21){return "A";}
            elseif($vatpar==12){return "B";}
            elseif($vatpar==6){return "C";}
            elseif($vatpar==0){return "D";}
            else{return "D";}

        }
        function fdmStatus_get(){
        	$macNumber	=	$this->input->get('mac');
        	$flag		=	$this->input->get('flag');

        	$this->fodfdm_model->updatePrinterStatus($macNumber,$flag);
        	$jsonarray=array('message'=>"FDM Status st to ".$flag);
        	
        }



        function data2_get(){
        	// $logFile = FCPATH . 'application/tiqs_logs/messages.txt';
            // Utility_helper::logMessage($logFile, 'ordernumber ' .$orderId);

            $logFile = FCPATH . 'application/tiqs_logs/messages.txt';
            Utility_helper::logMessage($logFile, 'printer conected get');
            $get = $this->input->get(null, true);
            Utility_helper::logMessage($logFile, 'printer MAC '. $get['mac'] );
            if(!$get['mac']) return;


            //Check FDM Status 
            $FDMStatusByMac=$this->fodfdm_model->getFDMstatusByMac($get['mac']);
        	if(!empty($FDMStatusByMac) && $FDMStatusByMac->FDM_active==1){
        		return "";
        	}
        	//it will not proceed when FDM have an issue

            $order = $this->shoporder_model->fetchOrdersForPrint($get['mac']);
            if (!$order) return;
            $order = reset($order);
            $receiptemailBasepath=$this->VatnoVatdata($order,0);
            
            $jsonoutput['TransactionDateTime']    =   gmdate(DATE_ATOM);//"2020-08-08T12:40:54";
            $jsonoutput['TransactionNumber']      =   (int)(("1000").(100000+$order['orderId']) );
            $jsonoutput['ordernumberr']           =   $order['orderId'];


            $jsonoutput['ProductLines']=$this->ProductLines;
            $jsonoutput['PaymentLines']=$this->PaymentLines;
            $jsonoutput['image']=$receiptemailBasepath;
            $jsonoutput['vendorId']=$order['vendorId'];
            $jsonoutput['lastNumber']=$this->fodfdm_model->getlastRecieptCount($order['vendorId']);

            $this->ProductLines=null;
            $this->PaymentLines=null;

            $receiptemailBasepath=$this->VatnoVatdata($order,1);
            


            $jsonoutput['ProductLines1']=$this->ProductLines;
            $jsonoutput['PaymentLines1']=$this->PaymentLines;
            $jsonoutput['image1']=$receiptemailBasepath;




            // UPDATE ORDER EXTENDED PRINT STATUS
            $orderExtendedIds = explode(',', $order['orderExtendedIds']);
            foreach ($orderExtendedIds as $id) {
                $this
                    ->shoporderex_model
                    ->setObjectId(intval($id))
                    ->setObjectFromArray(['printed' => '1'])
                    ->update();
            }

            if ($this->shoporder_model->updatePrintedStatus()) {
            }



            // header('Content-type: image/png');
            echo json_encode($jsonoutput);

            // SEND EMAIL
            // $subject= "tiqs-Order : ". $order['orderId'] ;
            // $order['buyerEmail'] = 'pnroos@icloud.com';
            // $email = $order['buyerEmail'];
            // Email_helper::sendOrderEmail($email, $subject, $emailMessage, $receiptemail);
        }

        private function VatnoVatdata($order,$vatzeroflag=0)
        {
            

            // var_dump($order);
            // $order = $this->shoporder_model->fetchOrdersForPrintcopy($orderId);
            // if (!$order) return;
            // $order = reset($order);

            // if ($order['printStatus'] === '0') return;
        	$logFile = FCPATH . 'application/tiqs_logs/messages.txt';
			Utility_helper::logMessage($logFile, 'order vendor'.$order['vendorId']);

            $productsarray = explode($this->config->item('contactGroupSeparator'), $order['products']);
            // print_r($productsarray);die();
            $imageprint = new Imagick();
			$imageprintemail = new Imagick();

            if (is_null($order['vendorLogo'])) {
                $logoFile = FCPATH . "/assets/home/images/tiqslogonew.png";
            } else {
                $logoFile = $this->config->item('uploadLogoFolder') . $order['vendorLogo'];
            }
            $imagelogo = new Imagick($logoFile);
            $geometry = $imagelogo->getImageGeometry(); 

            $width = intval($geometry['width']);
            $height = intval($geometry['height']);
            $crop_width = 550;
            $crop_height = 150;
            $crop_x = intval(($width - $crop_width) / 2);
            $crop_y = intval(($height - $crop_height) / 2);
            $sizeheight = 300;
            $sizewidth = 576;

			$imagelogo->cropImage($crop_width, $crop_height, $crop_x, $crop_y);
			$imagelogo->setImageFormat('png');
			$imagelogo->setImageBackgroundColor(new ImagickPixel('white'));
			$imagelogo->extentImage($sizewidth, $sizeheight, -($sizewidth - $crop_width) / 2, -($sizeheight - $crop_height) / 2);

			$imageprint->addImage($imagelogo);
			$imageprintemail->addImage($imagelogo);

            //-------------- SPOT placement -------------------------

            $imagetext = new Imagick();
            $draw = new ImagickDraw();
            $pixel = new ImagickPixel('white');

			$imagetextemail = new Imagick();
			$drawemail = new ImagickDraw();
			$pixelemail = new ImagickPixel('white');

			/* New image */
            //--- aantal rows bepalen a.d. hand van aantal order regels.

            $rowheight = (count($productsarray) * 30) + 700;
			$rowheight2 = (count($productsarray) * 30) + 350;
            $imagetext->newImage(576, $rowheight2, $pixel);
            $imagetextemail->newImage(576, $rowheight, $pixel);

            /* Black text */
            $draw->setFillColor('black');
			$drawemail->setFillColor('black');

            switch (strtolower($_SERVER['HTTP_HOST'])) {
                case 'tiqs.com':
                    $draw->setFont('Helvetica');
					$drawemail->setFont('Helvetica');
                    break;

                default:
                    $draw->setFont('Arial');
					$drawemail->setFont('Arial');
                    break;
            }


			$draw->annotation(0, 30, "GEEN BTW BON");

			$draw->setStrokeWidth(2);
			$draw->setFontSize(28);
			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);

			$drawemail->setStrokeWidth(2);
			$drawemail->setFontSize(28);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

			$h = 1;

			if($order['serviceTypeId']==1){
				$draw->annotation(0, 35 * $h, "GEEN BTW BON / LOCAL ");
			}
			if($order['serviceTypeId']==2){
				$draw->annotation(0, 35 * $h, "GEEN BTW BON / DELIVERY ");
			}
			if($order['serviceTypeId']==3){
				$draw->annotation(0, 35 * $h, "GEEN BTW BON / PICKUP ");
			}
			$draw->setStrokeWidth(4);
			$draw->setFontSize(28);
			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);

			$drawemail->setStrokeWidth(4);
			$drawemail->setFontSize(28);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

			// $draw->annotation(0, 30, "SPOT: ". $result->spot_id . " EMAIL: " . $email . ' PHONE: ' . $phone);
			// $draw->annotation(0, 30, "SPOT: ". $result->spot_id );

			$h++;

			$draw->annotation(0, 35 * $h , "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);
			$drawemail->annotation(0,35 * $h , "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);


			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(2);

			$h++;

			if($order['serviceTypeId']==1){
				$draw->annotation(0,  35 * $h, "DATE". date("d-m h:i:sa",strtotime($order['orderCreated'])). " spot: ". $order['spotName'] );
			}
			if($order['serviceTypeId']==2){
				$draw->annotation(0,  35 * $h, "DELIVERY ON : ". date("d-m h:i:sa",strtotime($order['orderCreated'])));
				$h++;
				$draw->annotation(0,  35 * $h, "Phone : ". $order['buyerMobile'] );
				$h++;
				$draw->annotation(0,  35 * $h, "Address: ". $order['buyerAddress'] );
				$h++;
				$draw->annotation(0,  35 * $h, $order['buyerZipcode']. " " . $order['buyerCity'] );
			}

			if($order['serviceTypeId']==3){
				$draw->annotation(0,  35 * $h, "PICK-UP at : ". date("d-m h:i:sa",strtotime($order['orderCreated'])));
			}

			if($order['serviceTypeId']==1){
				$drawemail->annotation(0, 35 * $h, "DATE:". date("d-m h:i:sa",strtotime($order['orderCreated'])). " SPOT: ". $order['spotName'] );
			}
			if($order['serviceTypeId']==2){
				$drawemail->annotation(0, 35 * $h, "DELIVERY AT:". date("d-m h:i:sa",strtotime($order['orderCreated'])). " SPOT: ". $order['spotName'] );
			}
			if($order['serviceTypeId']==3){
				$drawemail->annotation(0, 35 * $h, "PICK-UP AT". date("d-m h:i:sa",strtotime($order['orderCreated'])). " spot: ". $order['spotName'] );
			}

			$h++;


			//-------- header regel --------
			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(1);
			$draw->setFontSize(30);
			$draw->setStrokeWidth(3);

			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
			$imagetext->annotateImage($draw, 0,35 * $h, 0, "#");
			$imagetext->annotateImage($draw, 40,35 * $h, 0, "OMSCHRIJVING");
			if ($order['paidStatus'] === $this->config->item('orderCashPaying')) {
				$imagetext->annotateImage($draw, 295, 35 * $h, 0, "CASH PAYMENT");
			}

			$h++;

			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(5);
			$draw->line(0, 35 * $h, 576, 35 * $h);
			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(5);
			$drawemail->line(0, 35 * $h, 576, 35 * $h);
			$drawemail->setStrokeWidth(1);

			$h++;

			$drawemail->setFontSize(22);
			$drawemail->setStrokeWidth(2);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
			$imagetextemail->annotateImage($drawemail, 0, 165, 0, "ANT");
			$imagetextemail->annotateImage($drawemail, 48, 165, 0, "OMSCHRIJVING");
			$imagetextemail->annotateImage($drawemail, 380, 165, 0, "PRIJS");
			$imagetextemail->annotateImage($drawemail, 475, 165, 0, "%");
			$imagetextemail->annotateImage($drawemail, 495, 165, 0, "TOTAAL");
			$h++;
			$h++;
			$h++;

			//-------- regels --------

			$totalamount = 0;
			$i = 2;//
			$ii = 0;
			$hd = $h * 35;

			$Ttotalamount =0;
			// $T21totalamount=0;
			// $T9totalamount=0;
            $emailMessage = '';
            $productVats = [];

            foreach ($productsarray as $product) {

                $product = explode($this->config->item('concatSeparator'), $product);
                // 0 => name
                // 1 => unit price
                // 2 => ordered quantity
                // 3 => category
                // 4 => category id
                // 5 => shortDescription
                // 6 => longDescription
                // 7 => vatpercentage
                // 8 => productId

                $title = $product[0];
                $price = $product[1];
                $quantity = $product[2];
                $plu =  $product[3]; //????????????????
                $shortDescription = $product[5];
                $longDescription = $product[6];
                $vatpercentage = $product[7];
                if($vatzeroflag==1){
                	$vatpercentage=0;
                }
                



                $totalamount =  floatval($quantity) * floatval($price);
				$Stotalamount = sprintf("%.2f", $totalamount);

				$Ttotalamount = $Ttotalamount+$totalamount  ;
				$TStotalamount = sprintf("%.2f", $Ttotalamount);

				// if($vatpercentage==21){
				// 	$T21totalamount = $T21totalamount+($totalamount-(($totalamount/121)*100))  ;
				// }

				// if($vatpercentage==9){
				// 	$T9totalamount = $T9totalamount+($totalamount-(($totalamount/121)*100))  ;
                // }
                
                if (!isset($productVats[$vatpercentage])) {
                    $productVats[$vatpercentage] = 0;
                }

                $productVats[$vatpercentage] += $totalamount - $totalamount / (100 + intval($vatpercentage)) * 100;

				$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
				// $draw->annotation(0, $hd + ($i * 30), $plu);
				if (isset($subMainProductIndex) && isset($mainProductIndex) && $subMainProductIndex === $mainProductIndex) {
					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(20, $hd + ($i * 30), $quantity);

					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(60, $hd + ($i * 30), $title);
				} else {
					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(0, $hd + ($i * 30), $quantity);

					$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
					$draw->annotation(40, $hd + ($i * 30), $title);
				}

				$drawemail->setFontSize(18);
				$drawemail->setStrokeWidth(1);
				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
				// $draw->annotation(0, 165 + ($i * 30), $plu);

				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
				$drawemail->annotation(0, 165 + ($i * 30), $quantity);

				$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
				$drawemail->annotation(40, 165 + ($i * 30), $title);

				$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$drawemail->annotation(440, 165 + ($i * 30), "€ ". $price);

				$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$drawemail->annotation(500, 165 + ($i * 30), (string)$vatpercentage);

				$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$drawemail->annotation(570, 165 + ($i * 30), "€ ". $Stotalamount);


				$i++;

				//

                // $emailMessage .= '<p>';
                // $emailMessage .=    '<tr>';
                // $emailMessage .=        '<td>' . $quantity . '</td>';
                // $emailMessage .=        '<td>' . $title . '</td>';
                // $emailMessage .=        '<td>EURO ' . $price . '</td>';
                // $emailMessage .=    '</tr>';
                // $emailMessage .= '</p>';

                //added by Nadeem
                //set json product price and etc
                $price=(float)$price;
                $quantity=(int)$quantity;
                $this->ProductLines[]=  array(
                    "ProductGroupId"    =>  "PRGR".$product[4], // only categoryId !!! DONE
                    "ProductGroupName"  =>  $product[3], // categoryName !!! DONE
                    "ProductId"         =>  "PROD".$product[8], // productId !!! DONE
                    "ProductName"       =>  $title,
                    "Quantity"          =>  $quantity,
                    "QuantityUnit"      =>  "P",
                    "SellingPrice"      =>  (float)($price*$quantity),
                    "VatRateId"         =>  $this->returnVatGrade($vatpercentage),//"B",
                    "DiscountLines"     =>array(
                        // array(
                        // "DiscountId"        =>  "DISC002",
                        // "DiscountName"      =>  "Prod. discount10%",
                        // "DiscountType"      =>  "PRODUCTDISCOUNT",z`
                        // "DiscountGrouping"  =>  0,
                        // "DiscountAmount"    =>  1.19
                        // ),
                        // array(
                        // "DiscountId"        =>  "DISC001",
                        // "DiscountName"      =>  "Receipt. discount10%",
                        // "DiscountType"      =>  "RECEIPTDISCOUNT",
                        // "DiscountGrouping"  =>  0,
                        // "DiscountAmount"    =>  1.07
                        // ),
                    ),
                );
            }

			$ii = $i;


            // set end for the printer...


                //			$draw->setStrokeColor('black');
                //			$draw->setStrokeWidth(1);
                //			$draw->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
                //			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(1);
			$drawemail->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);


			$i++;
            //			$draw->setFontSize(18);
            //			$draw->setStrokeWidth(2);
            //			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            //			$imagetext->annotateImage($draw, 395, 165 + ($i * 30), 0, "TOTAAL");
            //			$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);
            //			$draw->annotation(570, 165 + ($i * 30), "€ ". $TStotalamount);


			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
			$imagetextemail->annotateImage($drawemail, 395, 165 + ($i * 30), 0, "TOTAAL");
			$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
			$drawemail->annotation(570, 165 + ($i * 30), "€ ". $TStotalamount);

				$i++;

            //			$draw->setStrokeColor('black');
            //			$draw->setStrokeWidth(4);
            //			$draw->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
            //			$draw->setStrokeWidth(1);

			//
			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(4);
			$drawemail->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);


			// $T21Stotalamount = sprintf("%.2f", $T21totalamount);
			// $T9Stotalamount = sprintf("%.2f", $T9totalamount);

			$i++;
            //			$imagetext->annotateImage($draw, 440, 165 + ($i * 30), 0, "BTW 21 % ");
            //			$draw->annotation(570, 165 + ($i * 30), "€ ". $T21Stotalamount);

			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

            //			$imagetextemail->setFontSize(18);
            //			$drawemail->setStrokeWidth(2);
            //			$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
			//
			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            
            foreach ($productVats as $vat => $amount) {
                $amount = number_format($amount, 2);
                $amount = sprintf("%.2f", $amount);
                $imagetextemail->annotateImage($drawemail, 440, 165 + ($i * 30), 0, 'BTW ' . strval($vat) .' % ');
                $drawemail->annotation(570, 165 + ($i * 30), "€ ". $amount);
                $i++;
            }
            //added by nadeem

            $this->PaymentLines[]=array(
                "PaymentId"             =>  $order['orderId'], //ONLY ORDER ID WITHOUT PAY TESTING VERSION DONE
                "PaymentName"           =>  "Alfred",
                "PaymentType"           =>  "EFT",
                "Quantity"              =>  1,
                "PayAmount"             =>  (float)$TStotalamount,
                "ForeignCurrencyAmount" =>  0,
                "ForeignCurrencyISO"    =>  "",
                "Reference"             =>  $order['payNlTransactionId'], //PAYNL TRANSACTION ID !!! DONE !!!
            );
            
			// $imagetextemail->annotateImage($drawemail, 440, 165 + ($i * 30), 0, "BTW 21 % ");
			// $drawemail->annotation(570, 165 + ($i * 30), "€ ". $T21Stotalamount);

			
            //			$imagetext->annotateImage($draw, 440, 165 + ($i * 30), 0, "BTW 9 % ");
            //			$draw->annotation(570, 165 + ($i * 30), "€ ". $T9Stotalamount);

			// $drawemail->setFontSize(18);
			// $drawemail->setStrokeWidth(1);
			// $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);

			//
			// $imagetextemail->annotateImage($drawemail, 440, 165 + ($i * 30), 0, "BTW 9 % ");
			// $drawemail->annotation(570, 165 + ($i * 30), "€ ". $T9Stotalamount);

			//-------- regels --------
			//
			//			$i++;
			//			$imagetext->annotateImage($draw, 0, 165 + ($i * 30), 0, $order['vendorName'] );

			$i++;
            //			$draw->setStrokeColor('black');
            //			$draw->setStrokeWidth(4);
            //			$draw->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
            //			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(4);
			$drawemail->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);


			$drawemail->setFontSize(18);
			$drawemail->setStrokeWidth(1);
			$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorName']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorName']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorAddress']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorAddress']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorZipcode']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorZipcode']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorCity']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorCity']);

			$i++;
			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), $order['vendorCountry']);

            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), $order['vendorCountry']);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), "BTW:". $order['vendorVAT']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$drawemail->annotation(570, 165 + ($i * 30), "BTW:". $order['vendorVAT']);

			$i++;
            //			$draw->setStrokeColor('black');
            //			$draw->setStrokeWidth(4);
            //			$draw->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
            //			$draw->setStrokeWidth(1);

			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(4);
			$drawemail->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
			$drawemail->setStrokeWidth(1);

			$i++;
            //			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            //			$draw->annotation(570, 165 + ($i * 30), "BTW:". $order['vendorVAT']);

			$imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            $drawemail->annotation(570, 165 + ($i * 30), 'EXcl terrasfee amount');
            $i++;
            $imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            $drawemail->annotation(570, 165 + ($i * 30), 'Terrasfee amount € ' . sprintf("%.2f", $order['serviceFee']));
            $i++;
            // $imagetextemail->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
            $serviceFeeAmount = floatval($order['serviceFee']);
            $serviceFeeTaxAmount = $serviceFeeAmount - $serviceFeeAmount / (100 + intval($order['serviceFeeTax'])) * 100;
            $drawemail->annotation(
                570,
                165 + ($i * 30),
                'Terrasfee BTW  ' .  $order['serviceFeeTax'] . ' % ' .  sprintf("%.2f", $serviceFeeTaxAmount)
            );
			//-------- Text printen!  --------
            $imagetext->drawImage($draw);
			$imagetextemail->drawImage($drawemail);

            $imageprint->addImage($imagetext);
			$imageprintemail->addImage($imagetextemail);

            // ------------------ QRCode creation --------------------------

			// $imageqr = new Imagick();

            // QRcode::png("https://tiqs.nl", 'petersqr.png', QR_ECLEVEL_H, 15);
            // $imageqr ->readImage('petersqr.png');
            // $imageprint ->addImage($imageqr);

			//            $imagelogo = new Imagick($logoFile);
			//            $geometry = $imagelogo->getImageGeometry();
			//
			//            $width = intval($geometry['width']);
			//            $height = intval($geometry['height']);
			//            $crop_width = 600;
			//            $crop_height = 150;
			//            $crop_x = intval(($width - $crop_width) / 2);
			//            $crop_y = intval(($height - $crop_height) / 2);
			//            $sizeheight = 300;
			//            $sizewidth = 576;
			//
			//            $imagelogo->cropImage($crop_width, $crop_height, $crop_x, $crop_y);
			//            $imagelogo->setImageFormat('png');
			//            $imagelogo->setImageBackgroundColor(new ImagickPixel('white'));
			//            $imagelogo->extentImage($sizewidth, $sizeheight, -($sizewidth - $crop_width) / 2, -($sizeheight - $crop_height) / 2);
			//            $imageprint->addImage($imagelogo);

            // ---------------- Create the print -------------------------
            // $result = $imageprint->mergeImageLayers(imagick::LAYERMETHOD_COMPARECLEAR);
            $imageprint->resetIterator();
			$imageprintemail->resetIterator();

            $resultpngprinter = $imageprint->appendImages(true);
			$resultpngemail = $imageprintemail->appendImages(true);
            
            /* Output the image with headers */
            /* Give image a format */
            $resultpngprinter->setImageFormat('png');
			$resultpngemail->setImageFormat('png');
			$img__filename=$order['orderId'].'_'.rand(00,99);
            $receipt = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $img__filename . '.png';
			$receiptemail = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $img__filename.'-email' . '.png';
            if (!file_put_contents($receipt, $resultpngprinter)) {
                $receipt = '';
            }
			if (!file_put_contents($receiptemail, $resultpngemail)) {
				$receiptemail = '';
			}
            $receiptemailBasepath = base_url() . 'receipts/'.$img__filename.'-email' . '.png';
                
            
            // $image ->writeImage("peter.png");
			//            $imageqr->destroy();
            $imagetext->destroy();
            $imagelogo->destroy();
            $imageprint->destroy();
            $draw->destroy();

			$imagetextemail->destroy();
			$imagelogo->destroy();
			$imageprint->destroy();
			$draw->destroy();

			//Utility_helper::logMessage($logFile, 'printer echo');
			return $receiptemailBasepath;
            // header('Content-type: image/png');
            // echo $resultpngprinter;
            
            // output here added by nadeem


            
        }
    }

