<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    require_once FCPATH . 'application/libraries/vendor/autoload.php';

    Class Mpdf_helper
    {

        public static $PD_FOLDER = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR;

        public static function createPdfFile(string $html, string $fileName, string $folder = ''): ?string
        {
            $pdfFile = $folder ? $folder : self::$PD_FOLDER;
            $pdfFile = $pdfFile . $fileName . '.pdf';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFile, \Mpdf\Output\Destination::FILE);

            return file_exists($pdfFile) ? $pdfFile : null;

        }

    }
