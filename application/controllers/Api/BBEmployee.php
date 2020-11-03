<?php
declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class BBEmployee extends REST_Controller
{
	private $jsonoutput=array();
	private $ProductLines=array();
	private $PaymentLines=array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('bbemployee_model');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}
	public function data_get()
	{
		$macNumber	=	$this->input->get('mac');
		$employeedetail=$this->bbemployee_model->getEmployeeByMac($macNumber);
		if(empty($employeedetail)){
			return ;
		}
		$nextemployee=$employeedetail->next+1;
		$price=0.01;
		$quantity=1;
		$vatpercentage=0;
		$this->ProductLines[]=	array(
			"ProductGroupId"	=>	"employee",	// only categoryId !!! DONE
			"ProductGroupName"	=>	"registration",		// categoryName !!! DONE
			"ProductId"			=>	"INSZ0".$employeedetail->id,	// productId !!! DONE
			"ProductName"		=>	$employeedetail->username,
			"Quantity"			=>	$quantity,
			"QuantityUnit"		=>	"P",
			"SellingPrice"		=>	(float)($price*$quantity),
			"VatRateId"			=>	$this->returnVatGrade($vatpercentage),//"B",
			"DiscountLines"		=>	array(
			// array(
			// 	"DiscountId"        =>  "DISC002",
			// 	"DiscountName"      =>  "Prod. discount10%",
			// 	"DiscountType"      =>  "PRODUCTDISCOUNT",z`
			// 	"DiscountGrouping"  =>  0,
			// 	"DiscountAmount"    =>  1.19
			// ),
			// array(
			// 	"DiscountId"        =>  "DISC001",
			// 	"DiscountName"      =>  "Receipt. discount10%",
			// 	"DiscountType"      =>  "RECEIPTDISCOUNT",
			// 	"DiscountGrouping"  =>  0,
			// 	"DiscountAmount"    =>  1.07
			// ),
			),
		);
		$TStotalamount=$price*$quantity;
		$this->PaymentLines[]=array(
			"PaymentId"				=>	$nextemployee, //ONLY ORDER ID WITHOUT PAY TESTING VERSION DONE
			"PaymentName"			=>	$employeedetail->username,
			"PaymentType"			=>	"EFT",
			"Quantity"				=>	1,
			"PayAmount"				=>	(float)$TStotalamount,
			"ForeignCurrencyAmount"	=>	0,
			"ForeignCurrencyISO"	=>	"",
			"Reference"				=>	"Employee in", //PAYNL TRANSACTION ID !!! DONE !!!
			);
		$jsonoutput['TransactionDateTime']	=	gmdate(DATE_ATOM);//"2020-08-08T12:40:54";
		$jsonoutput['TransactionNumber']	=	(int)( ("2000").(200000+$nextemployee));
		$jsonoutput['ordernumberr']			=	$nextemployee;
		$this->bbemployee_model->updateemployeenext($employeedetail->id,$nextemployee);
		// ------------------ QRCode creation --------------------------

		// $imageqr = new Imagick();

		// QRcode::png("https://tiqs.nl", 'petersqr.png', QR_ECLEVEL_H, 15);
		// $imageqr ->readImage('petersqr.png');
		// $imageprint ->addImage($imageqr);

		// $imagelogo = new Imagick($logoFile);
		// $geometry = $imagelogo->getImageGeometry();
		//
		// $width = intval($geometry['width']);
		// $height = intval($geometry['height']);
		// $crop_width = 600;
		// $crop_height = 150;
		// $crop_x = intval(($width - $crop_width) / 2);
		// $crop_y = intval(($height - $crop_height) / 2);
		// $sizeheight = 300;
		// $sizewidth = 576;
		//
		// $imagelogo->cropImage($crop_width, $crop_height, $crop_x, $crop_y);
		// $imagelogo->setImageFormat('png');
		// $imagelogo->setImageBackgroundColor(new ImagickPixel('white'));
		// $imagelogo->extentImage($sizewidth, $sizeheight, -($sizewidth - $crop_width) / 2, -($sizeheight - $crop_height) / 2);
		// $imageprint->addImage($imagelogo);

		// ---------------- Create the print -------------------------
		// $result = $imageprint->mergeImageLayers(imagick::LAYERMETHOD_COMPARECLEAR);
		$jsonoutput['ProductLines']=$this->ProductLines;
		$jsonoutput['PaymentLines']=$this->PaymentLines;
		$jsonoutput['employeedetail']=$employeedetail;
		// header('Content-type: image/png');
		echo json_encode($jsonoutput);
	}
	private function returnVatGrade($vatpar){
		// retunr a or b or or d
		if($vatpar==21){return "A";}
		elseif($vatpar==12){return "B";}
		elseif($vatpar==6){return "C";}
		elseif($vatpar==0){return "D";}
		else{return "D";}
	}
		// function fdmStatus_get(){
		// 	$macNumber	=	$this->input->get('mac');
		// 	$flag		=	$this->input->get('flag');
		// 	$this->fodfdm_model->updatePrinterStatus($macNumber,$flag);
		// 	$jsonarray=array('message'=>"FDM Status st to ".$flag);
			
		// }
	}

