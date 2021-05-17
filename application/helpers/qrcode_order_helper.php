<?php
declare(strict_types=1);

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require_once FCPATH . '/vendor/autoload.php';

if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Qrcode_order_helper
{
    public static function generateOrderQrCode(string $uniqueCode)
    {
		$qrtext = $uniqueCode;

		switch (strtolower($_SERVER['HTTP_HOST'])) {
			case 'tiqs.com':
				$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
				break;
			case 'www.tiqs.com':
				$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
				break;
			case '127.0.0.1':
				$file = 'C:/wamp64/www/alfred/alfred/uploads/qrcodes/';
				break;
			default:
				$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
				break;
		}

		$SERVERFILEPATH = $file;
		$text = $qrtext;
		$folder = $SERVERFILEPATH;
		$file_name1 = "QR-Order-".$qrtext . ".png";
		$file_name = $folder . $file_name1;

		QRcode::png($text, $file_name);

		$qrlink = $SERVERFILEPATH . $file_name1;

		return $qrlink;
    }

}
