<?php
declare(strict_types=1);

ini_set('max_execution_time', '300');

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

Class GenerateQRCODE extends BaseControllerWeb
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('uniquecode_model');
        $this->load->helper('qrcode_helper');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function pdf()
    {
        $code = $this->uri->segment(3) ? $this->uri->segment(3) : '6102';
        Qrcode_helper::genereateQrPdf($code);
    }

    public function qr_codes()
    {
        $data = [];
        $this->global['pageTitle'] = 'TIQS : QR CODES';
        $data['url'] = base_url();
        $data['iframeUrl'] = $data['url'] . 'index.php/generateqrcode/pdf';
        $data['codes'] = array_keys(Qrcode_helper::getAllParametars());
        sort($data['codes']);
        $this->loadViews("qrcodes", $this->global, $data, NULL);
    }

    public function excel()
    {
        
        $numberOfcodes = $this->uri->segment(3) ? intval($this->uri->segment(3)) + 2 : 302;
        $checkUrl = 'https://tiqs.com/id/';
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Url');
        $sheet->setCellValue('B1', 'Code');

        for ($i = 2; $i < $numberOfcodes; $i++) {
            $this->uniquecode_model->insertAndSetCode('K2');
            $url = $checkUrl . $this->uniquecode_model->code;
            $sheet->setCellValue('A' . $i, $url);
            $sheet->setCellValue('B' . $i, $this->uniquecode_model->code);
        }

        $writer = new Xlsx($spreadsheet); 
        $filename = date('Y-m-d H:i:s');
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        var_dump($writer->save('php://output'));
    }
}
