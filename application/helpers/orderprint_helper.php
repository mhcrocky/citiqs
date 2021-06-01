<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    Class Orderprint_helper
    {
        public static $checkVenodrs = ['43533', '417', '22762','6485', '28269', '45966', '45960'];

        // order is receipt
        public static function saveOrderImage(array $order): string
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->model('shopvendorfod_model');
            $CI->load->helper('print_helper');

            $isFod = $CI->shopvendorfod_model->isFodVendor(intval($order['vendorId']));
            $i = 0;
            
            $productVats = self::getVatsArray($order['vendorCountry']);
            $spotTypeId = intval($order['spotTypeId']);
            $productsarray = explode($CI->config->item('contactGroupSeparator'), $order['products']);
            $logoFile = is_null($order['vendorLogo']) ? FCPATH . "/assets/home/images/tiqslogonew.png" : $CI->config->item('uploadLogoFolder') . $order['vendorLogo'];

            $imageprintemail = new Imagick();
            $pixel = new ImagickPixel('white');
            $drawemail = new ImagickDraw();
            $imagetextemail = new Imagick();

            if ( !in_array($order['vendorId'], self::$checkVenodrs)) {
                $startPoint = 220;
                self::drawEmailSettings($imagetextemail, $drawemail, $pixel, count($productsarray));
				Print_helper::printImageLogo($imageprintemail, $logoFile);
            	self::printOrderHeader($CI, $imagetextemail, $drawemail, $order, $spotTypeId);
                self::printProductLines($CI, $drawemail, $productsarray, $spotTypeId, $i, $startPoint, $productVats, $order, $isFod);
                self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);
                self::printVatAndTotal($drawemail, $startPoint, $i, $productVats, $order);
                self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);
                self::printVendorData($drawemail, $startPoint, $i, $order);
                self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);
                return self::saveImageAndDestroyObjects($imagetextemail, $imageprintemail, $drawemail, $order);
            } else {
				// $startPoint = 220;
				// self::drawEmailSettings($imagetextemail, $drawemail, $pixel, count($productsarray));
				// Print_helper::printImageLogo($imageprintemail, $logoFile);
				// self::printOrderHeader($CI, $imagetextemail, $drawemail, $order, $spotTypeId);
				// self::printProductLines($CI, $drawemail, $productsarray, $spotTypeId, $i, $startPoint, $productVats, $order, $isFod);
				// self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);
				// self::printVatAndTotal($drawemail, $startPoint, $i, $productVats, $order);
				// self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);
				// self::printVendorData($drawemail, $startPoint, $i, $order);
				// self::printBoldLine($drawemail, $imagetextemail, $i, $startPoint);
				// return self::saveImageAndDestroyObjects43533($imagetextemail, $imageprintemail, $drawemail, $order);

				$startPoint = 180;
                self::drawEmailSettings43533($imagetextemail, $drawemail, $pixel, count($productsarray));
				// Print_helper::printImageLogo($imageprintemail, $logoFile);
				self::printOrderHeader43533($CI, $imagetextemail, $drawemail, $order, $spotTypeId);
				self::printProductLines43533($CI, $drawemail, $productsarray, $spotTypeId, $i, $startPoint, $productVats, $order, $isFod);
				self::printBoldLine43533($drawemail, $imagetextemail, $i, $startPoint);
				self::printVatAndTotal43533($drawemail, $startPoint, $i, $productVats, $order);
				self::printBoldLine43533($drawemail, $imagetextemail, $i, $startPoint);
				self::printVendorData43533($drawemail, $startPoint, $i, $order);
				self::printBoldLine43533($drawemail, $imagetextemail, $i, $startPoint);

                return self::saveImageAndDestroyObjects($imagetextemail, $imageprintemail, $drawemail, $order);
			}

//            return self::saveImageAndDestroyObjects($imagetextemail, $imageprintemail, $drawemail, $order);
        }

        public static function printVatString(int $vatPercent, bool $isFod, array $productVats): string
        {
            // return $isFod ? self::returnVatGrade($vatPercent) : '';
            if (!$isFod) return '';
            return isset($productVats[$vatPercent]) ? $productVats[$vatPercent]['grade'] : 'D';
        }

        // public static function returnVatGrade(int $vatpercentage)
        // {
        //     $vatPercentArray = self::getVatsArray();
        //     return isset($vatPercentArray[$vatpercentage]) ? $vatPercentArray[$vatpercentage]['grade'] : 'D';
        // }

        public static function createProductLine(
            &$drawemail,
            $startPoint,
            int $i,
            int $quantity,
            string $title,
            string $lineAmount,
            int $vatpercentage,
            bool $isFod,
            array $productVats
        ): void
        {
            $drawemail->setFontSize(24);
            $drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), $quantity . ' x ');
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(40, $startPoint + ($i * 30), substr($title, 0, 19));
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(560, $startPoint + ($i * 30), "€ ". $lineAmount . ' ' . self::printVatString($vatpercentage, $isFod, $productVats));
        }
        

        public static function createProductLine43533(
            &$drawemail,
            $startPoint,
            int $i,
            int $quantity,
            string $title,
            string $lineAmount,
            int $vatpercentage,
            bool $isFod,
            array $productVats
        ): void
        {
            $drawemail->setFontSize(24);
            $drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), $quantity . ' x ');
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(40, $startPoint + ($i * 30), substr($title, 0, 19));
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(560, $startPoint + ($i * 30), "€ ". $lineAmount . ' ' . self::printVatString($vatpercentage, $isFod, $productVats));
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

		public static function printBoldLine43533(object &$drawemail, object &$imagetextemail, int &$i, int $startPoint): void
		{
			$i++;
			$drawemail->setStrokeColor('black');
			$drawemail->setStrokeWidth(4);
			$drawemail->line(0, $startPoint + ($i * 30), 576, $startPoint + ($i * 30));
			// $imagetextemail->annotateImage($drawemail, 0, 185, 0, "ANT");
			// $drawemail->annotation(40, $startPoint + ($i * 30), "test line");
			// $imagetextemail->annotateImage($drawemail, 0, $startPoint + ($i * 30), 0, "ANT");
			$drawemail->setStrokeWidth(1);
			$imagetextemail->drawImage($drawemail);
			$i++;
		}

        public static function getVatsArray(string $country): array
        {

            $CI =& get_instance();
            $CI->load->config('custom');

            $taxes = $CI->config->item('countriesTaxes')[$country];
            $taxRates = $taxes['taxRates'];
            $taxGrades = isset($taxes['taxGrades']) ? $taxes['taxGrades'] : null;
            $taxRatesLength = count($taxRates);
            $return = [];

            for ($i = 0; $i < $taxRatesLength; $i++) {
                $return[$taxRates[$i]] = [
                    'vatAmount' => 0,
                    'baseAmount' => 0,
                ];
                $return[$taxRates[$i]]['grade'] = $taxGrades ? $taxGrades[$i] : '';
            }

            return $return;
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

		public static function printVendorData43533(object &$drawemail, int $startPoint, int &$i, array $order): void
		{

            $drawemail->setFontSize(24);
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

        public static function printOrderHeader43533 (object &$CI, object &$imagetextemail, object &$drawemail, array $order, int $spotTypeId): void
        {
            if ($order['paymentType'] === $CI->config->item('prePaid') || $order['paymentType'] === $CI->config->item('postPaid')) {
                $drawemail->setStrokeWidth(2);
                $drawemail->setFontSize(24);
                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(0, 30, 'SERVICE BY WAITER');
                // $drawemail->setStrokeWidth(2);
                // $drawemail->setFontSize(12);
                // $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            }

            $drawemail->annotation(0, 60, "ORDER: " . $order['orderId'] . " NAAM: " . $order['buyerUserName']);
            $drawemail->annotation(0, 90, "SPOT: ". $order['spotName'] );


            if ($spotTypeId === $CI->config->item('local')) {
                $drawemail->annotation(0, 120, "DATE: " . $order['orderCreated']);
            } elseif ($spotTypeId === $CI->config->item('deliveryType')) {
                $drawemail->annotation(0, 120, "DELIVERY AT: " . $order['orderCreated']);
            } elseif ($spotTypeId === $CI->config->item('pickupType')) {
                $drawemail->annotation(0, 120, "PICKUP AT: " . $order['orderCreated']);
            }


            //-------- header regel --------

            $drawemail->setFontSize(24);
            $drawemail->setStrokeWidth(2);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

            $imagetextemail->annotateImage($drawemail, 0, 150, 0, "ANT");
            $imagetextemail->annotateImage($drawemail, 50, 150, 0, "OMSCHRIJVING");
            $imagetextemail->annotateImage($drawemail, 300, 150, 0, "");
            $imagetextemail->annotateImage($drawemail, 458, 150, 0, "");
            $imagetextemail->annotateImage($drawemail, 485, 150, 0, "TOTAAL");

            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(5);
            $drawemail->line(0, 180, 576, 180);
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

		public static function saveImageAndDestroyObjects43533(object $imagetextemail, object $imageprintemail, object $drawemail, array $order): string
		{
			$imagetextemail->drawImage($drawemail);
			$imageprintemail->addImage($imagetextemail);
			$imageprintemail->resetIterator();
			$resultpngemail = $imageprintemail->appendImages(true);
			$resultpngemail->setImageFormat('jpg');
			$imgRelativePath = 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'].'-email' . '.jpg';
			$imgFullPath = FCPATH . $imgRelativePath;

			file_put_contents($imgFullPath, $resultpngemail);

			$imagetextemail->destroy();
			$imageprintemail->destroy();

			return $imgRelativePath;
		}

        public static function drawEmailSettings(object &$imagetextemail, object &$drawemail, object $pixel, int $countProductArray): void
        {
            $rowheight = ($countProductArray * 30) + 850;
            $imagetextemail->newImage(600, $rowheight, $pixel);

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

        public static function drawEmailSettings43533(object &$imagetextemail, object &$drawemail, object $pixel, int $countProductArray): void
        {
             $rowheight = ($countProductArray * 30) + 850;
            // $rowheight = 550;
             $imagetextemail->newImage(576, $rowheight, $pixel);
            //			$imagetextemail->newImage(576, 550, $pixel);

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

		public static function printProductLines43533(
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
				self::createProductLine43533($drawemail, $startPoint, $i, $quantity, $title, $productTotal, $vatpercentage, $isFod, $productVats);
				$i++;
			}
			// Service fee line
			$serviceFeeTax = intval($order['serviceFeeTax']);
			self::createProductLine43533($drawemail, $startPoint, $i, 1, 'servicefee', $order['serviceFee'], $serviceFeeTax, $isFod, $productVats);
			self::populateVatArray($productVats, floatval($order['serviceFee']), $serviceFeeTax);
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
                self::createProductLine($drawemail, $startPoint, $i, $quantity, $title, $productTotal, $vatpercentage, $isFod, $productVats);
                $i++;
            }
            // Service fee line
            $serviceFeeTax = intval($order['serviceFeeTax']);
            self::createProductLine($drawemail, $startPoint, $i, 1, 'servicefee', $order['serviceFee'], $serviceFeeTax, $isFod, $productVats);
            self::populateVatArray($productVats, floatval($order['serviceFee']), $serviceFeeTax);
        }

        public static function populateVatArray(array &$productVats, float $productTotal, int $vatpercentage)
        {
            $productVats[$vatpercentage]['baseAmount'] += ($productTotal * 100) / ($vatpercentage + 100);
            $exAmount = ($productTotal * 100) / ($vatpercentage + 100);
            $productVats[$vatpercentage]['vatAmount'] += $productTotal - $exAmount;
        }

        public static function printVatAndTotal(object &$drawemail, int $startPoint, int &$i, array $productVats, array $order): void
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

            self::printVoucherAmount($drawemail, $startPoint, $i, $order, $overAllTotal);
            self::printWaiterTip($drawemail, $startPoint, $i, $order, $overAllTotal);
        }

		public static function printVatAndTotal43533(object &$drawemail, int $startPoint, int &$i, array $productVats, array $order): void
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

            self::printVoucherAmount($drawemail, $startPoint, $i, $order, $overAllTotal);
            self::printWaiterTip43533($drawemail, $startPoint, $i, $order, $overAllTotal);
        }

        private static function printWaiterTip(object &$drawemail, int $startPoint, int &$i, array &$order, float &$overAllTotal): void
        {
            $waiterTip = floatval($order['waiterTip']);
            if ($waiterTip) {
                $overAllTotal = $overAllTotal + $waiterTip;

                $i++;
                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(0, $startPoint + ($i * 30), 'Waiter tip');
                $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
                $drawemail->annotation(560, $startPoint + ($i * 30), number_format($waiterTip, 2, '.', ','));

                $i++;
                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(0, $startPoint + ($i * 30), 'Total with waiter tip');
                $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
                $drawemail->annotation(560, $startPoint + ($i * 30), number_format($overAllTotal, 2, '.', ','));
            }
        }

        private static function printWaiterTip43533(object &$drawemail, int $startPoint, int &$i, array &$order, float &$overAllTotal): void
        {
            $waiterTip = floatval($order['waiterTip']);
            if ($waiterTip) {
                $overAllTotal = $overAllTotal + $waiterTip;
                $i++;
                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(0, $startPoint + ($i * 30), 'Waiter tip');
                $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
                $drawemail->annotation(560, $startPoint + ($i * 30), number_format($waiterTip, 2, '.', ','));

                $i++;
                $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
                $drawemail->annotation(0, $startPoint + ($i * 30), 'Total with waiter tip');
                $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
                $drawemail->annotation(560, $startPoint + ($i * 30), number_format($overAllTotal, 2, '.', ','));
            }
        }

		public static function printVoucherAmount(object &$drawemail, int $startPoint, int &$i, array $order, float &$overAllTotal): void
        {
            $voucherAmount = floatval($order['voucherAmount']);

            if (!$voucherAmount) return;

            $overAllTotal = $overAllTotal - $voucherAmount;

            $drawemail->setFontSize(24);
            $drawemail->setStrokeWidth(1);

            $i++;
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), 'Voucher');
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(560, $startPoint + ($i * 30), number_format($voucherAmount, 2, '.', ','));

            $i++;
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), 'Total with voucher');
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(560, $startPoint + ($i * 30), number_format($overAllTotal, 2, '.', ','));
            $i++;
            $i++;

            return;
        }

    }
