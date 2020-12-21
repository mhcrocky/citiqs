<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    Class Orderprint_helper
    {

        public static function saveOrderImage(array $order): string
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->model('shopvendorfod_model');

            $isFod = $CI->shopvendorfod_model->isFodVendor(intval($order['vendorId']));
            $i = 0;
            $startPoint = 220;
            $productVats = self::getVatsArray();
            $spotTypeId = intval($order['spotTypeId']);
            $productsarray = explode($CI->config->item('contactGroupSeparator'), $order['products']);
            $logoFile = is_null($order['vendorLogo']) ? FCPATH . "/assets/home/images/tiqslogonew.png" : $CI->config->item('uploadLogoFolder') . $order['vendorLogo'];

            $imageprintemail = new Imagick();
            $pixel = new ImagickPixel('white');
            $drawemail = new ImagickDraw();
            $imagetextemail = new Imagick();

            self::drawEmailSettings($imagetextemail, $drawemail, $pixel, count($productsarray));

            self::printImageLogo($imageprintemail, $logoFile);
            self::printOrderHeader($CI, $imagetextemail, $drawemail, $order, $spotTypeId);
            self::printProductLines($CI, $drawemail, $productsarray, $spotTypeId, $i, $startPoint, $productVats, $order, $isFod);
            self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);           
            self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);
            self::printVendorData($drawemail, $startPoint, $i, $order);

            return self::saveImageAndDestroyObjects($imagetextemail, $imageprintemail, $drawemail, $order);
        }

        public static function printVatString(int $vatPercent, bool $isFod): string
        {
            return $isFod ? self::returnVatGrade($vatPercent) : '';
        }

        public static function returnVatGrade(int $vatpercentage)
        {
            $vatPercentArray = self::getVatsArray();
            return isset($vatPercentArray[$vatpercentage]) ? $vatPercentArray[$vatpercentage]['grade'] : 'D';
        }

        public static function createProductLine(&$drawemail, $startPoint, int $i, string $quantity, string $title,string $lineAmount, int $vatpercentage, bool $isFod): void
        {
            $drawemail->setFontSize(24);
            $drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), $quantity . ' x ');
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(40, $startPoint + ($i * 30), substr($title, 0, 13));
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(560, $startPoint + ($i * 30), "€ ". $lineAmount . ' ' . self::printVatString($vatpercentage, $isFod));
        }

        public static function printBoldLine(object &$drawemail, object &$imagetextemail, int &$i, int $startPoint): void
        {
            $i++;            
            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(4);
            $drawemail->line(0, $startPoint + ($i * 30), 576, $startPoint + ($i * 30));
            $drawemail->setStrokeWidth(1);
            $imagetextemail->drawImage($drawemail);
            $i++;
        }

        public static function getVatsArray(): array
        {
            return [
                0 => [
                    'grade' => 'D',
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ],
                6 => [
                    'grade' => 'C',
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ],
                12 => [
                    'grade' => 'B',
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ],
                21 => [
                    'grade' => 'A',
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ]
            ];
        }

        public static function printVendorData(object &$drawemail, int $startPoint, int &$i, array $order): void
        {

            $drawemail->annotation(570, $startPoint + ($i * 30), $order['vendorName']);

            $i++;
            $drawemail->annotation(570, $startPoint + ($i * 30), $order['vendorAddress']);

            $i++;
            $drawemail->annotation(570, $startPoint + ($i * 30), $order['vendorZipcode']);

            $i++;
            $drawemail->annotation(570, $startPoint + ($i * 30), $order['vendorCity']);

            $i++;
            $drawemail->annotation(570, $startPoint + ($i * 30), $order['vendorCountry']);

            $i++;
            $drawemail->annotation(570, $startPoint + ($i * 30), "VAT #:". $order['vendorVAT']);

            $i++;    
        }

        public static function printOrderHeader (object &$CI, object &$imagetextemail, object &$drawemail, array $order, int $spotTypeId): void
        {
            if ($order['paymentType'] === $CI->config->item('prePaid') || $order['paymentType'] === $CI->config->item('postPaid')) {
                $drawemail->setStrokeWidth(4);
                $drawemail->setFontSize(28);
                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(0, 30, 'SERVICE BY WAITER');
                $drawemail->setStrokeWidth(2);
                $drawemail->setFontSize(28);
                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            }

            $drawemail->annotation(0, 70, "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);
            $drawemail->annotation(0, 105, "SPOT: ". $order['spotName'] );

            if ($spotTypeId === $CI->config->item('local')) {
                $drawemail->annotation(0, 135, "DATE: " . $order['orderCreated']);
            } elseif ($spotTypeId === $CI->config->item('deliveryType')) {
                $drawemail->annotation(0, 135, "DELIVERY AT: " . $order['orderCreated']);
            } elseif ($spotTypeId === $CI->config->item('pickupType')) {
                $drawemail->annotation(0, 135, "PICKUP AT: " . $order['orderCreated']);
            }


            //-------- header regel --------

            $drawemail->setFontSize(22);
            $drawemail->setStrokeWidth(2);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

            $imagetextemail->annotateImage($drawemail, 0, 185, 0, "ANT");
            $imagetextemail->annotateImage($drawemail, 50, 185, 0, "OMSCHRIJVING");
            $imagetextemail->annotateImage($drawemail, 300, 185, 0, "");
            $imagetextemail->annotateImage($drawemail, 458, 185, 0, "");
            $imagetextemail->annotateImage($drawemail, 485, 185, 0, "TOTAAL");

            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(5);
            $drawemail->line(0, 190, 576, 190);
            $drawemail->setStrokeWidth(1);
        }


        public static function printImageLogo(object &$imageprintemail, string $logoFile): void
        {
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

            $imageprintemail->addImage($imagelogo);
            $imagelogo->destroy();
        }

        public static function saveImageAndDestroyObjects(object $imagetextemail, object $imageprintemail, object $drawemail, array $order): string
        {
            $imagetextemail->drawImage($drawemail);
            $imageprintemail->addImage($imagetextemail);
            $imageprintemail->resetIterator();
            $resultpngemail = $imageprintemail->appendImages(true);
            $resultpngemail->setImageFormat('png');		
            $imgRelativePath = 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'].'-email' . '.png';
            $imgFullPath = FCPATH . $imgRelativePath;

            file_put_contents($imgFullPath, $resultpngemail);

            $imagetextemail->destroy();
            $imageprintemail->destroy();


            return $imgRelativePath;
        }

        public static function drawEmailSettings(object &$imagetextemail, object &$drawemail, object $pixel, int $countProductArray): void
        {
            $rowheight = ($countProductArray * 30) + 1000;
            $imagetextemail->newImage(576, $rowheight, $pixel);

            /* Black text */
            $drawemail->setFillColor('black');

            switch (strtolower($_SERVER['HTTP_HOST'])) {
                case 'tiqs.com':
                    $drawemail->setFont('Helvetica');
                    break;
                case 'loki-vm':
                case '10.0.0.48':
                    $drawemail->setFont('Helvetica');
                    break;
                default:
                    if (ENVIRONMENT === 'development') break;
                    $drawemail->setFont('Arial');
                    break;
            }

            $drawemail->setStrokeWidth(2);
            $drawemail->setFontSize(28);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
        }

        public static function printProductLines(
            object &$CI,
            object &$drawemail,
            array $productsarray,
            int $spotTypeId,
            int &$i,
            int $startPoint,
            array &$productVats,
            array $order,
            bool $isFod
        ): void
        {            
            foreach ($productsarray as $product) {

                $product = explode($CI->config->item('concatSeparator'), $product);
                // 0 => name
                // 1 => local unit price
                // 2 => ordered quantity
                // 3 => category
                // 4 => category id
                // 5 => shortDescription
                // 6 => longDescription
                // 7 => local vatpercentage
                // 8 => deliveryPrice
                // 9 => deliveryVatpercentage
                // 10 => pickupPrice
                // 11 => pickupVatpercentage

                $title = substr($product[0], 0, 20);
                $quantity = $product[2];
                $plu =  $product[3];

                // SET PRICE AND VATPERCENTAGE
                if ($spotTypeId === $CI->config->item('local')) {
                    $price = $product[1];
                    $vatpercentage = intval($product[7]);
                } elseif ($spotTypeId === $CI->config->item('deliveryType')) {
                    $price = $product[8];
                    $vatpercentage = intval($product[9]);
                } elseif ($spotTypeId === $CI->config->item('pickupType')) {
                    $price = $product[10];
                    $vatpercentage = intval($product[11]);
                }

                $productTotal =  floatval($quantity) * floatval($price);
                $productTotal =  number_format($productTotal, 2, '.', ',');
            

                //$productVats[$vatpercentage] += $totalamount - $totalamount / (100 + intval($vatpercentage)) * 100;
                // $exVatPrijs = ($price * 100 / (100 + intval($vatpercentage)));
                // $exVatPrijs = round($exVatPrijs, 2);
                // $productVats[$vatpercentage] += ($price - $exVatPrijs);

                self::createProductLine($drawemail, $startPoint, $i, $quantity, $title, $productTotal, $vatpercentage, $isFod);
                $i++;
            }
            // Service fee line
            self::createProductLine($drawemail, $startPoint, $i, '1', 'servicefee', $order['serviceFee'], 21, $isFod);
        }
    }
        // foreach ($productVats as $vat => $amount) {
        //     $vatString = $isFod ? ' VAT ' . self::returnVatGrade(intval($vat)) . '(' . $vat .' %) ' : ' VAT ' . strval($vat) .' % ';
        // 	$amount = number_format($amount, 2);
        // 	$amount = sprintf("%.2f", $amount);
        // 	$imagetextemail->annotateImage($drawemail, 440, $startPoint + ($i * 30), 0, ' VAT ' . self::printVatString(intval($vat), $isFod));
        // 	$drawemail->annotation(570, $startPoint + ($i * 30), "€ ". $amount);
        // 	$i++;
        // }
        

        // --------------------- and final amount !

        // $drawemail->setStrokeWidth(3);
        // $drawemail->setFontSize(28);
        // $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
        // $drawemail->annotation(0, $startPoint + ($i * 30), 'TOTAAL');
        // if ($order['paymentType'] === $CI->config->item('prePaid') || $order['paymentType'] === $CI->config->item('postPaid')) {
        // 	$drawemail->annotation(0, 30, 'SERVICE BY WAITER');
        // }
        // $totalamt = floatval($order['serviceFee']+$TStotalamount);
        // $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
        // $drawemail->annotation(570, $startPoint + ($i * 30), '€ ' . sprintf("%.2f", $totalamt));
        // $drawemail->setStrokeWidth(2);
        // $drawemail->setFontSize(28);
        // $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

        // $i++;
        // $i++;

        // if ($order['voucherAmount'] != 0) {
        // 	$drawemail->setStrokeWidth(3);
        // 	$drawemail->setFontSize(28);
        // 	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
        // 	$drawemail->annotation(0, $startPoint + ($i * 30), 'TOTAAL - VOUCHER');
        // 	$totalamt = $totalamt - floatval($order['voucherAmount']);
        // 	$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
        // 	$drawemail->annotation(570, $startPoint + ($i * 30), '€ ' . sprintf("%.2f", $totalamt));
        // 	$drawemail->setStrokeWidth(2);
        // 	$drawemail->setFontSize(28);
        // 	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
        // }
