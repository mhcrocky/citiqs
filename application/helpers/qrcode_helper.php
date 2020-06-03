<?php
declare(strict_types=1);

require APPPATH . '/libraries/phpqrcode/phpqrcode.php';
require_once FCPATH . '/vendor/autoload.php';

if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Qrcode_helper
{
    public static function generateQrCode(string $uniqueCode)
    {
        ob_start("callback");
        $debugLog = ob_get_contents();
        ob_end_clean();
        QRcode::png($uniqueCode);
    }

    public static function saveQrCode(string $uniqueCode)
    {
        $relativePathToFile = 'uploads/qrcodes/' . $uniqueCode.'.png';
        $pngAbsoluteFilePath = FCPATH . $relativePathToFile;
        if (!file_exists($pngAbsoluteFilePath)) {
            QRcode::png($uniqueCode, $pngAbsoluteFilePath);
        }
        return file_exists($pngAbsoluteFilePath) ? $relativePathToFile : null;
    }

    public static function getQrUniqueCode(): string
    {
        $CI =& get_instance();
        $CI->uniquecode_model->insertAndSetCode();
        return $CI->uniquecode_model->code;
    }

    public static function getAllParametars(): array
    {
        $json = FCPATH . 'assets/documents/labels.json';
        $json = file_get_contents($json);
        return json_decode($json, true);
    }

    public static function getQodeParametars(string $key): array
    {
        $json = FCPATH . 'assets/documents/labels.json';
        $json = file_get_contents($json);
        $parametars = self::getAllParametars();

        //conevrt width and height from mm to px;
        $parametars[$key]['width'] = round($parametars[$key]['width'] * 3.7795275591);
        $parametars[$key]['height'] = round($parametars[$key]['height'] * 3.7795275591);

        return $parametars[$key];
    }

    public static function genereateQrPdf(string $code): void
    {
        $html  = self::getHtmlForPdf($code);        
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public static function getHtmlForPdf(string $code): string
    {
        $parametars = self::getQodeParametars($code);
        $html  = '<html>';
        $html .= '<head>';
        $html .= '<style>';
        $html .=    'td {';
        $html .=        'border:1px solid #000;';
        $html .=        'border-radius:15px;';
        $html .=    '}';
        #$html .=   'img {';
        #$html .=       'border:1px solid #000;';
        #$html .=       'border-radius:15px';
        #$html .=   '}';
        $html .=    'p {';
        $html .=        'marign-top:0px;';
        $html .=        'marign-bottom:0px;';
        $html .=        'padding-top:0px;';
        $html .=        'padding-bottom:0px;';
        $html .=        'text-align:left;';
        $html .=        'color:#E25F2A;';
        $html .=        'font-size:' . (round($parametars['height'] / 12)) . 'pt';
        $html .=    '}';

        $html .= '</style>';
        $html .= '</head>';
        $html .= '<table>';
        for ($i = 0; $i < $parametars['rowNumbers']; $i++) {
            $html .= '<tr>';
            for($j = 0; $j < $parametars['columnNumbers']; $j++) {
                $html .= self::getCeil( $parametars['width'], $parametars['height'], self::getQrUniqueCode());
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '</html>';
        return $html;
    }

    public static function getCeil($width, $height, $code): string
    {
        $width = $width - 2;
        $height = $height - 2;
        $logoWidth = ($width > $height) ? ($width  * 0.4) : ($height * 0.4);
        $logoHeight = ($width > $height) ? 'auto' : 'auto';
        $qrCodeWidth = ($width > $height) ? ($width  * 0.2) : ($height * 0.2);
        $qrCodeHeight = ($width > $height) ? 'auto' : 'auto';

        $td  = '<td width="' . $width . 'px" height="' . $height . 'px" align="center" valign="middle">';
        $td .=     '<img src="'. base_url() . 'uploads/LabelImages/qr_image.png"  width="' . $logoWidth. '" height="' . $logoHeight. '" />';
        $td .=     '<img src="'. base_url() . self::saveQrCode($code) . '" width="' . $qrCodeWidth . '" height="' . $qrCodeHeight. '" />';
        $td .=     '<p>Code: ' . $code .'</p>';
        $td .=  '</td>';
        return $td;
    }

}