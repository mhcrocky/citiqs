<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    Class Orderprint_helper
    {
        public static function saveOrderImage(array $order): string
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $spotTypeId = intval($order['spotTypeId']);
            $productsarray = explode($CI->config->item('contactGroupSeparator'), $order['products']);
            $imageprint = new Imagick();
            $imageprintemail = new Imagick();

            if (is_null($order['vendorLogo'])) {
            	$logoFile = FCPATH . "/assets/home/images/tiqslogonew.png";
            } else {
            	$logoFile = $CI->config->item('uploadLogoFolder') . $order['vendorLogo'];
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
            $pixel = new ImagickPixel('white');
            $imagetextemail = new Imagick();
            $drawemail = new ImagickDraw();

            /* New image */
            //--- aantal rows bepalen a.d. hand van aantal order regels.

            $rowheight = (count($productsarray) * 30) + 1000;
            $rowheight2 = (count($productsarray) * 30) + 550;
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
            $imagetextemail->annotateImage($drawemail, 300, 185, 0, "EX VAT PRIJS");
            $imagetextemail->annotateImage($drawemail, 458, 185, 0, "%");
            $imagetextemail->annotateImage($drawemail, 485, 185, 0, "TOTAAL");

            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(5);
            $drawemail->line(0, 190, 576, 190);
            $drawemail->setStrokeWidth(1);

            $totalamount = 0;
            $i = 0;
            $ii = 0;

            $Ttotalamount =0;
            $productVats = [];

            $startPoint = 220;
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
            	$shortDescription = $product[5];
            	$longDescription = $product[6];

            	// SET PRICE AND VATPERCENTAGE
            	if ($spotTypeId === $CI->config->item('local')) {
            		$price = $product[1];
            		$vatpercentage = $product[7];
            	} elseif ($spotTypeId === $CI->config->item('deliveryType')) {
            		$price = $product[8];
            		$vatpercentage = $product[9];
            	} elseif ($spotTypeId === $CI->config->item('pickupType')) {
            		$price = $product[10];
            		$vatpercentage = $product[11];
            	}

            	$totalamount =  floatval($quantity) * floatval($price);
            	$Stotalamount = sprintf("%.2f", $totalamount);

            	$Ttotalamount = $Ttotalamount+$totalamount  ;
            	$TStotalamount = sprintf("%.2f", number_format($Ttotalamount, 2, '.', ','));

            	if (!isset($productVats[$vatpercentage])) {
            		$productVats[$vatpercentage] = 0;
            	}

            	//$productVats[$vatpercentage] += $totalamount - $totalamount / (100 + intval($vatpercentage)) * 100;
            	$exVatPrijs = ($price * 100 / (100 + intval($vatpercentage)));
            	$exVatPrijs = round($exVatPrijs, 2);
            	$productVats[$vatpercentage] += ($price - $exVatPrijs);
            	$drawemail->setFontSize(24);
            	$drawemail->setStrokeWidth(1);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            	$drawemail->annotation(0, $startPoint + ($i * 30), $quantity);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            	$drawemail->annotation(40, $startPoint + ($i * 30), substr($title, 0, 13));
            	$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            	$drawemail->annotation(415, $startPoint + ($i * 30), "€ ". number_format($exVatPrijs, 2, '.', ','));
            	$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            	$drawemail->annotation(485, $startPoint + ($i * 30), $vatpercentage);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            	$drawemail->annotation(570, $startPoint + ($i * 30), "€ ". $Stotalamount);

            	$i++;
            }

            $ii = $i;

            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(1);
            $drawemail->line(500, $startPoint + ($i * 30), 576, $startPoint + ($i * 30));
            $drawemail->setStrokeWidth(1);

            $i++;

            $drawemail->setFontSize(22);
            $drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $imagetextemail->annotateImage($drawemail, 395, $startPoint + ($i * 30), 0, "");
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(570, $startPoint + ($i * 30), "€ ". $TStotalamount);

            $i++;

            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(4);
            $drawemail->line(500, $startPoint + ($i * 30), 576, $startPoint + ($i * 30));
            $drawemail->setStrokeWidth(1);

            $i++;

            $drawemail->setFontSize(22);
            $drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->setFontSize(22);
            $drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);

            foreach ($productVats as $vat => $amount) {
            	$amount = number_format($amount, 2);
            	$amount = sprintf("%.2f", $amount);
            	$imagetextemail->annotateImage($drawemail, 440, $startPoint + ($i * 30), 0, ' VAT ' . strval($vat) .' % ');
            	$drawemail->annotation(570, $startPoint + ($i * 30), "€ ". $amount);
            	$i++;
            }

            $i++;

            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(4);
            $drawemail->line(0, $startPoint + ($i * 30), 576, $startPoint + ($i * 30));
            $drawemail->setStrokeWidth(1);

            $drawemail->setStrokeColor('black');
            $drawemail->setFontSize(22);
            $drawemail->setStrokeWidth(1);
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);

            $i++;

            $imagetextemail->drawImage($drawemail);


            $i++;
            $i++;

            // --------------------- and final amount !

            $drawemail->setStrokeWidth(3);
            $drawemail->setFontSize(28);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $drawemail->annotation(0, $startPoint + ($i * 30), 'TOTAAL');
            if ($order['paymentType'] === $CI->config->item('prePaid') || $order['paymentType'] === $CI->config->item('postPaid')) {
            	$drawemail->annotation(0, 30, 'SERVICE BY WAITER');
            }
            $totalamt = floatval($order['serviceFee']+$TStotalamount);
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            $drawemail->annotation(570, $startPoint + ($i * 30), '€ ' . sprintf("%.2f", $totalamt));
            $drawemail->setStrokeWidth(2);
            $drawemail->setFontSize(28);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);

            $i++;
            $i++;

            if ($order['voucherAmount'] != 0) {
            	$drawemail->setStrokeWidth(3);
            	$drawemail->setFontSize(28);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            	$drawemail->annotation(0, $startPoint + ($i * 30), 'TOTAAL - VOUCHER');
            	$totalamt = $totalamt - floatval($order['voucherAmount']);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);
            	$drawemail->annotation(570, $startPoint + ($i * 30), '€ ' . sprintf("%.2f", $totalamt));
            	$drawemail->setStrokeWidth(2);
            	$drawemail->setFontSize(28);
            	$drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            }

            $i++;
            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(4);
            $drawemail->line(0, $startPoint + ($i * 30), 576, $startPoint + ($i * 30));
            $drawemail->setStrokeWidth(1);

            $imagetextemail->drawImage($drawemail);
            $drawemail->setStrokeWidth(1);
            $drawemail->setFontSize(22);
            $drawemail->setTextAlignment(\Imagick::ALIGN_RIGHT);

            $i++;
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
            $drawemail->setStrokeColor('black');
            $drawemail->setStrokeWidth(4);
            $drawemail->line(0, $startPoint + ($i * 30), 576, $startPoint + ($i * 30));
            $drawemail->setStrokeWidth(1);

            $i++;

            $drawemail->annotation(570, $startPoint + ($i * 30), 'EXcl terrasfee amount');
            $i++;
            $drawemail->annotation(570, $startPoint + ($i * 30), 'Terrasfee amount € ' . sprintf("%.2f", $order['serviceFee']));
            $i++;

            $serviceFeeAmount = floatval($order['serviceFee']);
            $serviceFeeTaxAmount = $serviceFeeAmount - $serviceFeeAmount / (100 + intval($order['serviceFeeTax'])) * 100;
            $drawemail->annotation(
            	570,
            	$startPoint + ($i * 30),
            	'Terrasfee VAT   ' .  $order['serviceFeeTax'] . ' % ' .  sprintf("%.2f", $serviceFeeTaxAmount)
            );

            $i++;

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
            $imagelogo->destroy();
            $imageprint->destroy();

            return $imgRelativePath;
        }           
    }