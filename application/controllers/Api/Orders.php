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

            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');
            $this->load->helper('email_helper');

            $this->load->config('custom');
            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function data_get()
        {
            $get = $this->input->get(null, true);

            if(!$get['mac']) return;

            $ordersToPrint = $this->shoporder_model->fetchOrdersForPrint($get['mac']);

            if (!$ordersToPrint) return;

            $ordersToPrint = Utility_helper::resetArrayByKeyMultiple($ordersToPrint, 'orderId');

            foreach ($ordersToPrint as $orderId => $order) {

                $order = reset($order);
                $productsarray = explode($this->config->item('contactGroupSeparator'), $order['products']);
                $imageprint = new Imagick();

                //-------------- LOGO -------------------------
                // TO DO THIS MUST BE VENDOR LOGO
                $file = FCPATH . "../tiqsimg/thuishavenprint.png";
                $imagelogo = new Imagick($file);
                $geometry = $imagelogo->getImageGeometry(); 

                $width = intval($geometry['width']);
                $height = intval($geometry['height']);
                $crop_width = 400;
                $crop_height = 100;
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

                $rowheight = (count($productsarray) * 30) + 170;
                $imagetext->newImage(576, $rowheight, $pixel);

                /* Black text */
                $draw->setFillColor('black');

                // switch (strtolower($_SERVER['HTTP_HOST'])) {
                //     case 'tiqs.com':
                //         $draw->setFont('Helvetica');
                //         break;
                //     case 'loki-vm':
                //     case '10.0.0.48':
                //         $draw->setFont('Helvetica');
                //         break;
                //     default:
                //         $draw->setFont('Arial');
                //         break;
                // }

                // $draw->setFontWeight(551);
                $draw->setStrokeWidth(5);
                $draw->setFontSize(40);
                $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                $draw->annotation(0, 30, "ORDER: " . $order['orderId']);
                $draw->annotation(0, 70, "NAAM: " . $order['buyerUserName']);

                /* Font properties */
                // $draw->setFontWeight(1);
                $draw->setFontSize(30);

                //-------- header regel --------

                $draw->setStrokeWidth(2);
                $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                $imagetext->annotateImage($draw, 0, 105, 0, "PLU");
                $imagetext->annotateImage($draw, 95, 105, 0, "Amt");
                $imagetext->annotateImage($draw, 160, 105, 0, "Description");
                // $imagetext->annotateImage($draw, 440, 75, 0, "Price");
                $draw->setStrokeColor('black');
                $draw->setStrokeWidth(5);
                $draw->line(0, 120, 576, 120);
                $draw->setStrokeWidth(1);
                //-------- regels --------

                $totalamount = 0;
                $i = 0;
                $emailMessage = '';
                foreach ($productsarray as $product) {

                    $product = explode('|', $product);
                    $title = $product[0];
                    $price = $product[1];
                    $quantity = $product[2];
                    $plu =  $product[3];
                    $totalamount +=  floatval($quantity) * floatval($price);

                    $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                    $draw->annotation(0, 165 + ($i * 30), $plu);
            
                    $draw->setTextAlignment(\Imagick::ALIGN_RIGHT);
                    $draw->annotation(150, 165 + ($i * 30), $quantity);
            
                    $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
                    $draw->annotation(160, 165 + ($i * 30), $title);

                    $i++;
                    $emailMessage .= '<p>';
                    $emailMessage .=    '<tr>';
                    $emailMessage .=        '<td>' . $quantity . '</td>';
                    $emailMessage .=        '<td>' . $title . '</td>';
                    $emailMessage .=        '<td>EURO ' . $price . '</td>';
                    $emailMessage .=    '</tr>';
                    $emailMessage .= '</p>';
                }

                //-------- Text printen!  --------

                $imagetext->drawImage($draw);

                $imageprint->addImage($imagetext);

                // ------------------ QRCode creation --------------------------

                $imageqr = new Imagick();

                // QRcode::png("https://tiqs.nl", 'petersqr.png', QR_ECLEVEL_H, 15);
                // $imageqr ->readImage('petersqr.png');
                // $imageprint ->addImage($imageqr);

                $file = FCPATH . "../tiqsimg/thuishavenprint2.png";

                $imagelogo = new Imagick($file);
                $geometry = $imagelogo->getImageGeometry();

                $width = intval($geometry['width']);
                $height = intval($geometry['height']);
                $crop_width = 600;
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

                // ---------------- Create the print -------------------------
                // $result = $imageprint->mergeImageLayers(imagick::LAYERMETHOD_COMPARECLEAR);
                $imageprint->resetIterator();
                $resultpng = $imageprint->appendImages(true);
                
                /* Output the image with headers */
                /* Give image a format */
                $resultpng->setImageFormat('png');
                header('Content-type: image/png');
                // $image ->writeImage("peter.png");

                $imageqr->destroy();
                $imagetext->destroy();
                $imagelogo->destroy();
                $imageprint->destroy();
                $draw->destroy();

                echo $resultpng;

                // UPDATE ORDER PRINT STATUS
                $this
                    ->shoporder_model
                    ->setObjectId(intval($orderId))
                    ->setObjectFromArray(['printStatus' => '1'])
                    ->update();

                // SEND EMAIL
                $subject= "Order : ". $orderId;
                $emailMessage .= '<p><tr><td>TOTAAL BETAALD EURO '. number_format($totalamount, 2, '.', ',') . '</p></tr></td>';
                $email = $order['buyerEmail'];
                Email_helper::sendOrderEmail($email, $subject, $emailMessage);


            }
        }
    }
