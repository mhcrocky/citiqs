<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Orders extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopprinters_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');

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
            $logFile = FCPATH . 'application/tiqs_logs/messages.txt';
            Utility_helper::logMessage($logFile, 'printer conected get');

            $get = $this->input->get(null, true);
			Utility_helper::logMessage($logFile, 'printer MAC '. $get['mac'] );
            if(!$get['mac']) return;


            $order = $this->shoporder_model->fetchOrdersForPrint($get['mac']);
            if (!$order) return;
            $order = reset($order);
            Utility_helper::logMessage($logFile, 'printer order ');


            $productsarray = explode($this->config->item('contactGroupSeparator'), $order['products']);
            $imageprint = new Imagick();

            //-------------- LOGO -------------------------
            // TO DO THIS MUST BE VENDOR LOGO
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

            //-------------- SPOT placement -------------------------

            $imagetext = new Imagick();
            $draw = new ImagickDraw();
            $pixel = new ImagickPixel('white');

            /* New image */
            //--- aantal rows bepalen a.d. hand van aantal order regels.

            $rowheight = (count($productsarray) * 30) + 700;
            $imagetext->newImage(576, $rowheight, $pixel);

            /* Black text */
            $draw->setFillColor('black');

            switch (strtolower($_SERVER['HTTP_HOST'])) {
                case 'tiqs.com':
                    $draw->setFont('Helvetica');
                    break;
                case 'loki-vm':
                case '10.0.0.48':
                    $draw->setFont('Helvetica');
                    break;
                default:
                    $draw->setFont('Arial');
                    break;
            }

            // $draw->setFontWeight(551);
            // $draw->setStrokeWidth(5);
            // $draw->setFontSize(40);
            // $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            // $draw->annotation(0, 30, "ORDER: " . $order['orderId']);
            // $draw->annotation(0, 70, "NAAM: " . $order['buyerUserName']);


			$draw->setStrokeWidth(2);
			$draw->setFontSize(28);
			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);

            // $draw->annotation(0, 30, "SPOT: ". $result->spot_id . " EMAIL: " . $email . ' PHONE: ' . $phone);
            // $draw->annotation(0, 30, "SPOT: ". $result->spot_id );
			$draw->annotation(0, 30, "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);;
			$draw->annotation(0, 70, "DATE:". date("m-d h:i:sa"). " SPOT: ". $order['spotName'] );

            /* Font properties */
            // $draw->setFontWeight(1);


            //-------- header regel --------

			$draw->setFontSize(18);
            $draw->setStrokeWidth(2);
            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            $imagetext->annotateImage($draw, 0, 105, 0, "ANT");
            $imagetext->annotateImage($draw, 40, 105, 0, "OMSCHRIJVING");
            $imagetext->annotateImage($draw, 395, 105, 0, "PRIJS");
			$imagetext->annotateImage($draw, 485, 105, 0, "%");
			$imagetext->annotateImage($draw, 505, 105, 0, "TOTAAL");

            $draw->setStrokeColor('black');
            $draw->setStrokeWidth(5);
            $draw->line(0, 120, 576, 120);
            $draw->setStrokeWidth(1);
            //-------- regels --------

            $totalamount = 0;
            $i = 0;
			$Ttotalamount =0;
			$T21totalamount=0;
			$T9totalamount=0;
            $emailMessage = '';
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

                $title = $product[0];
                $price = $product[1];
                $quantity = $product[2];
                $plu =  $product[3];
                $shortDescription = $product[5];
                $longDescription = $product[6];
                $vatpercentage = $product[7];



                $totalamount =  floatval($quantity) * floatval($price);
				$Stotalamount = sprintf("%.2f", $totalamount);

				$Ttotalamount = $Ttotalamount+$totalamount  ;
				$TStotalamount = sprintf("%.2f", $Ttotalamount);

				if($vatpercentage==21){
					$T21totalamount = $T21totalamount+($totalamount-(($totalamount/121)*100))  ;
				}

				if($vatpercentage==9){
					$T9totalamount = $T9totalamount+($totalamount-(($totalamount/121)*100))  ;
				}

				$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                // $draw->annotation(0, 165 + ($i * 30), $plu);
        
                $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                $draw->annotation(0, 165 + ($i * 30), $quantity);
        
                $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                $draw->annotation(40, 165 + ($i * 30), $title);

				$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$draw->annotation(440, 165 + ($i * 30), "€ ". $price);

				$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$draw->annotation(500, 165 + ($i * 30), $vatpercentage);

				$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);
				$draw->annotation(570, 165 + ($i * 30), "€ ". $Stotalamount);

				$i++;
//                $emailMessage .= '<p>';
//                $emailMessage .=    '<tr>';
//                $emailMessage .=        '<td>' . $quantity . '</td>';
//                $emailMessage .=        '<td>' . $title . '</td>';
//                $emailMessage .=        '<td>EURO ' . $price . '</td>';
//                $emailMessage .=    '</tr>';
//                $emailMessage .= '</p>';
            }

			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(1);
			$draw->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
			$draw->setStrokeWidth(1);

			$i++;

			$draw->setFontSize(18);
			$draw->setStrokeWidth(2);
			$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
			$imagetext->annotateImage($draw, 395, 165 + ($i * 30), 0, "TOTAAL");
			$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);
			$draw->annotation(570, 165 + ($i * 30), "€ ". $TStotalamount);

			$i++;

			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(4);
			$draw->line(500, 165 + ($i * 30), 576, 165 + ($i * 30));
			$draw->setStrokeWidth(1);


			$T21Stotalamount = sprintf("%.2f", $T21totalamount);
			$T9Stotalamount = sprintf("%.2f", $T9totalamount);

			$i++;
			$imagetext->annotateImage($draw, 440, 165 + ($i * 30), 0, "BTW 21 % ");
			$draw->annotation(570, 165 + ($i * 30), "€ ". $T21Stotalamount);

			$i++;
			$imagetext->annotateImage($draw, 440, 165 + ($i * 30), 0, "BTW 9 % ");
			$draw->annotation(570, 165 + ($i * 30), "€ ". $T9Stotalamount);

			//-------- regels --------
			//
			//			$i++;
			//			$imagetext->annotateImage($draw, 0, 165 + ($i * 30), 0, $order['vendorName'] );

			$i++;
			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(4);
			$draw->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
			$draw->setStrokeWidth(1);

			$i++;
			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$draw->annotation(570, 165 + ($i * 30), $order['vendorName']);

			$i++;
			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$draw->annotation(570, 165 + ($i * 30), $order['vendorAddress']);

			$i++;
			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$draw->annotation(570, 165 + ($i * 30), $order['vendorZipcode']);

			$i++;
			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$draw->annotation(570, 165 + ($i * 30), $order['vendorCity']);

			$i++;
			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$draw->annotation(570, 165 + ($i * 30), $order['vendorCountry']);

			$i++;
			$imagetext->annotateImage($draw, 500, 165 + ($i * 30), 0, "");
			$draw->annotation(570, 165 + ($i * 30), "BTW:". $order['vendorVAT']);

			$i++;
			$draw->setStrokeColor('black');
			$draw->setStrokeWidth(4);
			$draw->line(0, 165 + ($i * 30), 576, 165 + ($i * 30));
			$draw->setStrokeWidth(1);


			//-------- Text printen!  --------
            $imagetext->drawImage($draw);
            $imageprint->addImage($imagetext);

            // ------------------ QRCode creation --------------------------

//            $imageqr = new Imagick();

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
//
//            $imageprint->addImage($imagelogo);

            // ---------------- Create the print -------------------------
            // $result = $imageprint->mergeImageLayers(imagick::LAYERMETHOD_COMPARECLEAR);
            $imageprint->resetIterator();
            $resultpng = $imageprint->appendImages(true);
            
            /* Output the image with headers */
            /* Give image a format */
            $resultpng->setImageFormat('png');
            $receipt = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'] . '.png';
            if (!file_put_contents($receipt, $resultpng)) {
                $receipt = '';
            }
                
            header('Content-type: image/png');
            // $image ->writeImage("peter.png");
			//            $imageqr->destroy();
            $imagetext->destroy();
            $imagelogo->destroy();
            $imageprint->destroy();
            $draw->destroy();

			Utility_helper::logMessage($logFile, 'printer echo');
            echo $resultpng;


            // UPDATE ORDER EXTENDED PRINT STATUS
            $orderExtendedIds = explode(',', $order['orderExtendedIds']);
            foreach ($orderExtendedIds as $id) {
                $this
                    ->shoporderex_model
                    ->setObjectId(intval($id))
                    ->setObjectFromArray(['printed' => '1'])
                    ->update();
            }

            $this->shoporder_model->updatePrintedStatus();

            // SEND EMAIL
            $subject= "tiqs-Order : ". $order['orderId'] ;
//            $emailMessage .= '<p><tr><td>TOTAAL BETAALD EURO '. number_format($totalamount, 2, '.', ',') . '</p></tr></td>';
            $email = $order['buyerEmail'];
            Email_helper::sendOrderEmail($email, $subject, $emailMessage, $receipt);
        }

        public function data_post()
        {


            $file = FCPATH . 'application/tiqs_logs/messages.txt';
            Utility_helper::logMessage($file, 'printer send post request');
            // Check is valid POST request type
            if (strtolower($_SERVER['CONTENT_TYPE']) !== 'application/json')
			{
				Utility_helper::logMessage($file, 'printer send post request CONTENT TYPE');
				return;
			}


            // Get JSON payload recieved from the request and parse it
            // $parsedJson = Sanitize_helper::sanitizePhpInput();
			Utility_helper::logMessage($file, 'printer send post request passed JSON');

            // $parsedJson = Sanitize_helper::sanitizePhpInput();
			$parsedJson = file_get_contents("php://input");
			$parsedJson = json_decode($parsedJson, true);

			// Validate JSON params
            if (!isset($parsedJson['printerMAC']) || !isset($parsedJson['statusCode']) || !isset($parsedJson['status'])){
				Utility_helper::logMessage($file, 'printer send post request passed JSON MAC ERROR'.$parsedJson['printerMAC']);
				Utility_helper::logMessage($file, 'printer send post request passed JSON STATUS CODEERROR'.$parsedJson['statusCode']);
				Utility_helper::logMessage($file, 'printer send post request passed JSON STATUS ERROR'.$parsedJson['status']);
				return;
			}

    
            if (!Sanitize_helper::isValidMac($parsedJson['printerMAC'])){
				Utility_helper::logMessage($file, 'printer send post request passed MAC ERROR');
				return;
			}


            Utility_helper::logMessage($file, 'Printer MAC:' .  $parsedJson['printerMAC']);
            // If the JSON request contains a request object in the clientAction then the printer is responding to a additional information
            // request (i.e. to get variables like the poll interval from the printer), so in this case the $path variable is set to
            // additional_communication.json to save this additional data
            if (isset($parsedJson["clientAction"][0]["request"])) {
                $arr = array("jobReady" => false);
                Utility_helper::logMessage($file, 'JOB NOT READY => 1');
            } else {
    
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
                    Utility_helper::logMessage($file, 'JOB READY => ');
                } else {
                    $arr = array("jobReady" => false);
                    Utility_helper::logMessage($file, 'JOB NOT READY => 2');
                }
            }
    
            $this->set_response($arr, 200); // CREATED (201) being the HTTP response code
        }

        public function sms_get(): void
        {
            $orders = $this->shoporder_model->ordersToSendSmsToDriver();
            // var_dump($orders);
            // die();

            if (!is_null($orders)) {
                foreach ($orders as $order) {
                    if (
                        $order['delayTime']
                        && $order['driverNumber']
                        && (strtotime($order['orderUpdate']) < strtotime(date('Y-m-d H:i:s', strtotime('-' . $order['delayTime'] . ' minutes'))))
                    ) {
                        $message  = 'Go to "'. $order['categoryName'] .'". ';
                        $message .= 'Order from "' . $order['vendorName']. '"';
                        $message .= ', order id is "' . $order['orderId'] . '" ';
                        $message .= 'and spot name is "' . $order['spotName'] . '" ';
                        if (Curl_helper::sendSmsNew($order['driverNumber'], $message)) {
                            $this
                                ->shoporder_model
                                    ->setObjectId(intval($order['orderId']))
                                    ->setObjectFromArray(['sendSmsDriver' => '1'])
                                    ->update();
                            // var_dump($order);
                            // var_dump($message);
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
    }

