<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');
    Class Reportesprint_helper
    {

        public static function printZreport(array $data): void
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $imageprint = new Imagick();
            $imagetext = new Imagick();
            $draw = new ImagickDraw();
            
            $countLines = count($data) + count($data['serviceTypes']) * 9 + count($data['paymentTypes']) * 9;
            $startPoint = 50;

            // image elements
            self::imageTextAndDrawSettings($imagetext, $draw, $countLines);
            self::printReportHeader($imagetext, $draw, $data, $startPoint, 'Z');
            self::printReportTotals($imagetext, $draw, $data, $startPoint);
            self::printServicePaymentTypes($CI, $imagetext, $draw, $data['serviceTypes'], $startPoint, 'SERVICE TYPES');
            self::printServicePaymentTypes($CI, $imagetext, $draw, $data['paymentTypes'], $startPoint, 'PAYMENT TYPES');

            // draw image
            self::drawReport($imagetext, $draw, $imageprint);

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

        public static function printReportHeader (object &$imagetext, object &$drawemail, array $data, int &$startPoint, string $report): void
        {
            $drawemail->setFontSize(40);
            $drawemail->setStrokeWidth(2);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $imagetext->annotateImage($drawemail, 5, $startPoint, 0, $report . ' - REPORT');
            $startPoint += 50;
        }

        public static function printReportTotals (object &$imagetext, object &$drawemail, array $data, int &$startPoint): void
        {
            $drawemail->setFontSize(22);
            $drawemail->setStrokeWidth(2);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $imagetext->annotateImage($drawemail, 5, $startPoint, 0, 'TOTALS');
            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 20, $startPoint, 0, 'Number of orders: ' . $data['orders']);
            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 20, $startPoint, 0, 'Total: ' . self::returnFormarNumber($data['orderTotalAmount'])) ;
            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 35, $startPoint, 0, 'Amount without service fee: '. self::returnFormarNumber($data['orderAmount']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 50, $startPoint, 0, 'Products ex. vat: '. self::returnFormarNumber($data['productsExVat']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 50, $startPoint, 0, 'Products vat: '. self::returnFormarNumber($data['productsVat']) . ' €');

            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 35, $startPoint, 0, 'Service fee: ' . self::returnFormarNumber($data['serviceFee']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 50, $startPoint, 0, 'Service fee ex. vat: '. self::returnFormarNumber($data['exVatService']) . ' €');
            $startPoint += 30;
            $imagetext->annotateImage($drawemail, 50, $startPoint, 0, 'Service fee vat: '. self::returnFormarNumber($data['vatService']) . ' €');
            $startPoint += 50;
        }

        public static function printServicePaymentTypes(
            object $CI,
            object &$imagetext,
            object &$drawemail,
            array $allData,
            int &$startPoint,
            string $type

        ): void
        {
            $drawemail->setFontSize(22);
            $drawemail->setStrokeWidth(2);
            $drawemail->setTextAlignment(\Imagick::ALIGN_LEFT);
            $imagetext->annotateImage($drawemail, 5, $startPoint, 0, $type);
            $startPoint += 30;
            foreach ($allData as $key => $data) {
                if ($type === 'SERVICE TYPES') {
                    $imagetext->annotateImage($drawemail, 20, $startPoint, 0, self::returnServiceType($CI, $key));
                } else {
                    if ($key === $CI->config->item('prePaid') || $key === $CI->config->item('postPaid')) {
                        $imagetext->annotateImage($drawemail, 20, $startPoint, 0, 'cash payment');
                    } else {
                        $imagetext->annotateImage($drawemail, 20, $startPoint, 0, $key);
                    }
                }

                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 35, $startPoint, 0, 'Number of orders: ' . $data['count']);
                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 35, $startPoint, 0, 'Total: ' . self::returnFormarNumber($data['orderTotalAmount'])) ;
                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 50, $startPoint, 0, 'Amount without service fee: '. self::returnFormarNumber($data['orderAmount']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 65, $startPoint, 0, 'Products ex. vat: '. self::returnFormarNumber($data['productsExVat']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 65, $startPoint, 0, 'Products vat: '. self::returnFormarNumber($data['productsVat']) . ' €');    
                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 50, $startPoint, 0, 'Service fee: ' . self::returnFormarNumber($data['serviceFee']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 65, $startPoint, 0, 'Service fee ex. vat: '. self::returnFormarNumber($data['exVatService']) . ' €');
                $startPoint += 30;
                $imagetext->annotateImage($drawemail, 65, $startPoint, 0, 'Service fee vat: '. self::returnFormarNumber($data['vatService']) . ' €');
                $startPoint += 30;
            }
            $startPoint += 20;
        }

        public static function returnFormarNumber(float $number): string
        {
            return number_format($number, 2, '.', ',');
        }

        public static function drawReport(object &$imagetext, object &$draw, object &$imageprint): void
        {
            $imagetext->drawImage($draw);
            $imageprint->addImage($imagetext);
            $imageprint->resetIterator();
            $resultpngprinter = $imageprint->appendImages(true);
            $resultpngprinter->setImageFormat('png');

            header('Content-type: image/png');
            echo $resultpngprinter;
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
    }
