<?php
    declare(strict_types=1);

    require APPPATH . '/libraries/phpqrcode/qrlib.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Pdfdesigner_helper
    {

        public static function uploadFiles(object $labelInfo, array $templateInfo, string $qrCodePng): ?string
        {
            $image = FCPATH . 'uploads/LabelImages/' . $labelInfo->userId . '-' .$labelInfo->code. '-' . $labelInfo->image;

            QRcode::png($labelInfo->code, $qrCodePng);
            /* Key Values for PDFDesigner text replace */
            $qrcodeKey = base_url() . '#@QRCODE@#';
            $imageKey =  base_url() . '#@ITEM_PIC@#';
            $keysValues = array(
                "#@ITEM_NAME@#" => $labelInfo->claimerName,
                
                "#@ITEM_CAT@#" => $labelInfo->categoryDescription,
                "#@ITEM_DESC@#" => $labelInfo->descript,
                "#@ITEM_DT_LOST@#" => $labelInfo->createdDtm,
                "#@ITEM_DT_COL@#" => date('Y-m-d H:i:s'),
                $imageKey => $image,
                $qrcodeKey => $qrCodePng
            );
            $arrayCode = json_decode($templateInfo[0]->templatePHPcodeJson);
            $phpCode = urldecode(base64_decode($arrayCode->code));
            $pdfCode = strtr($phpCode, $keysValues);
            $token = bin2hex(openssl_random_pseudo_bytes(8));
            $phpFilePath = FCPATH . 'uploads/outputPdf/pdf_' . $token . '.php';            
            if (!file_put_contents($phpFilePath, html_entity_decode($pdfCode))) {
                return null;
            }
            return $phpFilePath;
        }
        
    }