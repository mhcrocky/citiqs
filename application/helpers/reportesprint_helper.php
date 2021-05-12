<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');
    Class Reportesprint_helper
    {

        public static function printReport(array $data, string $from, string $to, string $reportType, string $logoFile, int $vendorId, bool $isPosRequest = true): void
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->helper('print_helper');

            $imageprint = new Imagick();
            $imagetext = new Imagick();
            $draw = new ImagickDraw();
            
            $countLines = count($data) + count($data['serviceTypes']) * 9 + count($data['paymentTypes']) * 9;
            if (isset($data['productsDetailsXreport'])) {
                $countLines += count($data['productsDetailsXreport']) + 2;
            };
            $startPoint = 50;
            $reportTypeHeader = ($reportType === $CI->config->item('z_report')) ? 'Z' : 'X';

            // image elements
            // Print_helper::printImageLogo($imageprint, $logoFile);
            self::imageTextAndDrawSettings($imagetext, $draw, $countLines);
            self::printReportHeader($imagetext, $draw, $data, $startPoint, $reportTypeHeader, $from, $to);
            self::printReportTotals($imagetext, $draw, $data, $startPoint);
            self::printServicePaymentTypes($CI, $imagetext, $draw, $data['serviceTypes'], $startPoint, 'SERVICE TYPES');
            self::printServicePaymentTypes($CI, $imagetext, $draw, $data['paymentTypes'], $startPoint, 'PAYMENT TYPES');
            self::printProcucts($imagetext, $draw, $data, $startPoint);

            // draw image
            self::drawAndSaveReport($CI,$imagetext, $draw, $imageprint, $reportType, $vendorId, $isPosRequest);

            // destroy objects
            self::destroyObjects($imagetext, $draw, $imageprint);
        }

        public static function imageTextAndDrawSettings(object &$imagetext, object &$draw, int $countLines): void
        {
            $pixel = new ImagickPixel('white');
            $rowheight = ($countLines * 30) + 550;
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
            $pixel->destroy();
        }

        public static function printReportHeader (
            object &$imagetext,
            object &$draw,
            array $data,
            int &$startPoint,
            string $report,
            string $from,
            string $to
        ): void
        {
            $draw->setFontSize(40);
            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            $imagetext->annotateImage($draw, 5, $startPoint, 0, $report . ' - REPORT ');
            $startPoint += 30;
            $draw->setFontSize(20);
            $imagetext->annotateImage($draw, 5, $startPoint, 0, '(' . $from . ' - ' . $to . ')');
            $startPoint += 10;
            self::getBoldLine($draw, $imagetext, $startPoint);
            $startPoint += 40;
        }

        public static function printReportTotals (object &$imagetext, object &$draw, array $data, int &$startPoint): void
        {
            $draw->setFontSize(22);
            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            $draw->setStrokeWidth(2);
            $imagetext->annotateImage($draw, 5, $startPoint, 0, 'TOTALS');
            $draw->setStrokeWidth(0);
            $draw->setFontSize(20);
            $startPoint += 30;
            $imagetext->annotateImage($draw, 20, $startPoint, 0, 'Number of orders: ' . $data['orders']);
            $startPoint += 30;
            $imagetext->annotateImage($draw, 20, $startPoint, 0, 'Total: ' . self::returnFormarNumber($data['orderTotalAmount'])) ;
            $startPoint += 30;
            $imagetext->annotateImage($draw, 35, $startPoint, 0, 'Amount without service fee: '. self::returnFormarNumber($data['orderAmount']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($draw, 50, $startPoint, 0, 'Products ex. vat: '. self::returnFormarNumber($data['productsExVat']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($draw, 50, $startPoint, 0, 'Products vat: '. self::returnFormarNumber($data['productsVat']) . ' €');

            $startPoint += 30;
            $imagetext->annotateImage($draw, 35, $startPoint, 0, 'Service fee: ' . self::returnFormarNumber($data['serviceFee']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($draw, 50, $startPoint, 0, 'Service fee ex. vat: '. self::returnFormarNumber($data['exVatService']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($draw, 50, $startPoint, 0, 'Service fee vat: '. self::returnFormarNumber($data['vatService']) . ' €');
            $startPoint += 30;

            $imagetext->annotateImage($draw, 20, $startPoint, 0, 'Vat amounts') ;
            $startPoint += 30;
            foreach($data['vatGrades'] as $vat => $amount) {
                $imagetext->annotateImage($draw, 35, $startPoint, 0, strval($vat) . ' %: '. self::returnFormarNumber($amount) . ' €');
                $startPoint += 30;
            }
            self::getBoldLine($draw, $imagetext, $startPoint);
            $startPoint += 40;
        }

        public static function printServicePaymentTypes(
            object $CI,
            object &$imagetext,
            object &$draw,
            array $allData,
            int &$startPoint,
            string $type

        ): void
        {
            $draw->setFontSize(22);
            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            $draw->setStrokeWidth(2);
            $imagetext->annotateImage($draw, 5, $startPoint, 0, $type);
            $draw->setStrokeWidth(0);
            $draw->setFontSize(20);
            $startPoint += 30;
            foreach ($allData as $key => $data) {
                if ($type === 'SERVICE TYPES') {
                    $text = self::returnServiceType($CI, $key);
                } else {
                    $text = ($key === $CI->config->item('prePaid') || $key === $CI->config->item('postPaid')) ? 'cash payment' : $key;
                }

                $imagetext->annotateImage($draw, 20, $startPoint, 0, strtoupper($text));
                $startPoint += 10;
                self::getBoldLine($draw, $imagetext, $startPoint, strlen($text) * 18, 20);
                $startPoint += 30;
                $imagetext->annotateImage($draw, 35, $startPoint, 0, 'Number of orders: ' . $data['orders']);
                $startPoint += 30;
                $imagetext->annotateImage($draw, 35, $startPoint, 0, 'Total: ' . self::returnFormarNumber($data['orderTotalAmount'])) ;
                $startPoint += 30;
                $imagetext->annotateImage($draw, 50, $startPoint, 0, 'Amount without service fee: '. self::returnFormarNumber($data['orderAmount']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($draw, 65, $startPoint, 0, 'Products ex. vat: '. self::returnFormarNumber($data['productsExVat']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($draw, 65, $startPoint, 0, 'Products vat: '. self::returnFormarNumber($data['productsVat']) . ' €');    
                $startPoint += 30;
                $imagetext->annotateImage($draw, 50, $startPoint, 0, 'Service fee: ' . self::returnFormarNumber($data['serviceFee']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($draw, 65, $startPoint, 0, 'Service fee ex. vat: '. self::returnFormarNumber($data['exVatService']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($draw, 65, $startPoint, 0, 'Service fee vat: '. self::returnFormarNumber($data['vatService']) . ' €');
                $startPoint += 30;
            }

            self::getBoldLine($draw, $imagetext, $startPoint);
            $startPoint += 40;
        }

        public static function returnFormarNumber(float $number): string
        {
            return number_format($number, 2, '.', ',');
        }

        public static function drawAndSaveReport(object $CI, object &$imagetext, object &$draw, object &$imageprint, string $reportType, int $vendorId, bool $isPosRequest): void
        {
            $imagetext->drawImage($draw);
            $imageprint->addImage($imagetext);
            $imageprint->resetIterator();
            $resultpngprinter = $imageprint->appendImages(true);
            $resultpngprinter->setImageFormat('png');


            $folder = $isPosRequest ? $CI->config->item('posReportes') : $CI->config->item('financeReportes');
            $report = $folder . $vendorId . '_' . $reportType . '.png';

            if (file_exists($report)) unlink($report);

            file_put_contents($report, $resultpngprinter);

            // header('Content-type: image/png');
            // echo $resultpngprinter;
        }

        public static function destroyObjects(object $imagetext, object $draw, object $imageprint): void
        {
            $imageprint->destroy();
            $imagetext->destroy();
            $draw->destroy();
        }

        public static function returnServiceType(object $CI, int $typeId): string
        {
            if ($typeId === $CI->config->item('local')) return 'LOCAL';
            if ($typeId === $CI->config->item('deliveryType')) return 'DELIVERY';
            if ($typeId === $CI->config->item('pickupType')) return 'PICKUP';
        }

        public static function getBoldLine(object &$draw, object &$imagetext, int &$startPoint, $width = 570, int $leftMargin = 5): void
        {
            $draw->setStrokeColor('black');
            $draw->setStrokeWidth(4);
            $draw->line($leftMargin, $startPoint, $width, $startPoint);
            $imagetext->drawImage($draw);
            $draw->setStrokeWidth(0);
        }

        public static function printProcucts(object &$imagetext, object &$draw, array $data, int &$startPoint): void
        {
            if (!isset($data['productsDetailsXreport'])) return;
            $products = $data['productsDetailsXreport'];

            $draw->setFontSize(22);
            $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
            $draw->setStrokeWidth(2);
            $imagetext->annotateImage($draw, 5, $startPoint, 0, 'PRODUCT TOTALS');
            $draw->setStrokeWidth(0);
            $draw->setFontSize(16);
            $startPoint += 30;
            $imagetext->annotateImage($draw, 10, $startPoint, 0, "NAME");
            $imagetext->annotateImage($draw, 180, $startPoint, 0, "Q#");            
            $imagetext->annotateImage($draw, 280, $startPoint, 0, "EX. VAT");
            $imagetext->annotateImage($draw, 380, $startPoint, 0, "VAT");
            $imagetext->annotateImage($draw, 500, $startPoint, 0, "TOTAL");
            $startPoint += 30;
            $draw->setFontSize(14);
            foreach ($products as $id => $details) {
                $productName = (strlen($details['name']) < 13) ? $details['name'] : substr($details['name'], 0, 12) . '.';
                $imagetext->annotateImage($draw, 10, $startPoint, 0, $productName);
                $imagetext->annotateImage($draw, 180, $startPoint, 0, strval($details['quantity']));            
                $imagetext->annotateImage($draw, 280, $startPoint, 0, self::returnFormarNumber($details['exVat']) . ' €');
                $imagetext->annotateImage($draw, 380, $startPoint, 0, self::returnFormarNumber($details['vat']) . ' €');
                $imagetext->annotateImage($draw, 500, $startPoint, 0, self::returnFormarNumber($details['total']) . ' €');
                $startPoint += 30;
            }
        }
    }
