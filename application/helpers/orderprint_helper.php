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
            self::printVatAndTotal($drawemail, $startPoint, $i, $productVats);
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

        public static function createProductLine(&$drawemail, $startPoint, int $i, int $quantity, string $title, string $lineAmount, int $vatpercentage, bool $isFod): void
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

            $CI =& get_instance();
            $CI->load->config('custom');
            
            return [
                $CI->config->item('taxA') => [
                    'grade' => 'A',
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ],
                $CI->config->item('taxB') => [
                    'grade' => 'B',
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ],
                $CI->config->item('taxC') => [
                    'grade' => 'C',
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ],
                $CI->config->item('taxD') => [
                    'grade' => 'D',
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
            $i++;        
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
                $quantity = intval($product[2]);
                $plu =  $product[3];

                // SET PRICE AND VATPERCENTAGE
                if ($spotTypeId === $CI->config->item('local')) {
                    $price = floatval($product[1]);
                    $vatpercentage = intval($product[7]);
                } elseif ($spotTypeId === $CI->config->item('deliveryType')) {
                    $price = floatval($product[8]);
                    $vatpercentage = intval($product[9]);
                } elseif ($spotTypeId === $CI->config->item('pickupType')) {
                    $price = floatval($product[10]);
                    $vatpercentage = intval($product[11]);
                }

                $productTotal =  $quantity * $price;
                self::populateVatArray($productVats, $productTotal, $vatpercentage);

                $productTotal =  number_format($productTotal, 2, '.', ',');
                self::createProductLine($drawemail, $startPoint, $i, $quantity, $title, $productTotal, $vatpercentage, $isFod);
                $i++;
            }
            // Service fee line
            self::createProductLine($drawemail, $startPoint, $i, 1, 'servicefee', $order['serviceFee'], $CI->config->item('taxA'), $isFod);
            self::populateVatArray($productVats, floatval($order['serviceFee']), $CI->config->item('taxA'));
        }

        public static function populateVatArray(array &$productVats, float $productTotal, int $vatpercentage)
        {
            $productVats[$vatpercentage]['baseAmount'] += $productTotal;
            $productVats[$vatpercentage]['vatAmount'] += $productTotal * $vatpercentage / 100;
        }

        public static function printVatAndTotal(object &$drawemail, int $startPoint, int &$i, array $productVats): void
        {
            $i++;
            $drawemail->setFontSize(24);
            $drawemail->setStrokeWidth(1);

            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), '');
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(150, $startPoint + ($i * 30), ' Basis (MvH) ');
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(360, $startPoint + ($i * 30), ' BTW ');
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(560, $startPoint + ($i * 30), ' Totaal ');

            $baseAmountTotal = 0;
            $vatTotal = 0;
            $overAllTotal = 0;

            foreach ($productVats as $percent => $data) {
                $i++;

                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(0, $startPoint + ($i * 30), $data['grade'] . ' ' . $percent . ' %');

                $baseAmount = round($data['baseAmount'], 2);
                $baseAmountTotal += $baseAmount;
                $baseAmountString = $baseAmount ? number_format($baseAmount, 2, '.', ',') : '';

                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(150, $startPoint + ($i * 30),  $baseAmountString);

                $vatAmount = round($data['vatAmount'], 2);
                $vatTotal += $vatAmount;
                $vatAmountString = $vatAmount ? number_format($vatAmount, 2, '.', ',') : '';

                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(360, $startPoint + ($i * 30),  strval($vatAmountString) );

                $totalAmount = $baseAmount + $vatAmount;
                $overAllTotal += $totalAmount;
                $totalString = $totalAmount ? number_format($totalAmount, 2, '.', ',') : '';

                $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
                $drawemail->annotation(560, $startPoint + ($i * 30),  $totalString);
            }
            $i++;
            
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), 'Totaal');
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(150, $startPoint + ($i * 30), number_format($baseAmountTotal, 2, '.', ','));
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(360, $startPoint + ($i * 30), number_format($vatTotal, 2, '.', ','));
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(560, $startPoint + ($i * 30), number_format($overAllTotal, 2, '.', ','));
        }
    }
