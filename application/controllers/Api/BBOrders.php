<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class BBOrders extends REST_Controller
{
	private $jsonoutput = array();
	private $productLines = array();
	private $paymentLines = array();
	private $drawreciept = null;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('shopprinters_model');
		$this->load->model('shoporder_model');
		$this->load->model('shoporderex_model');
		$this->load->model('shopvendor_model');
		$this->load->model('fodfdm_model');

		$this->load->helper('utility_helper');
		$this->load->helper('validate_data_helper');
		$this->load->helper('sanitize_helper');
		$this->load->helper('email_helper');
		$this->load->helper('curl_helper');
		$this->load->helper('orderprint_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function index_get(): void
	{
		return;
	}

	public function updatelastRecieptCount_get($vendorId): void
	{
		$this->fodfdm_model->updatelastRecieptCount($vendorId);
	}

	public function fdmStatus_get(): void
	{
		$macNumber  =   $this->input->get('mac');
		$flag       =   $this->input->get('flag');
		$this->fodfdm_model->updatePrinterStatus($macNumber,$flag);
		$jsonarray=array('message' => 'FDM Status st to ' . $flag);
	}

	public function data2_get(){
		$logFile = FCPATH . 'application/tiqs_logs/messages.txt';
		Utility_helper::logMessage($logFile, 'request from tiqsbox');
		$get = Utility_helper::sanitizeGet();
		if(!$get['mac']) return;
		Utility_helper::logMessage($logFile, 'printer MAC '. $get['mac'] );

		// Check FDM Status
		// $FDMStatusByMac=$this->fodfdm_model->getFDMstatusByMac($get['mac']);
		// if(!empty($FDMStatusByMac) && $FDMStatusByMac->FDM_active==1){
		//     return "";
		// }
		// it will not proceed when FDM have an issue

		$order = $this->shoporder_model->fetchBBOrderForPrint($get['mac']);
		Utility_helper::logMessage($logFile, serialize ( $order ) );
		if (!$order) return;
		$orderRelativePath = 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'] . '-email.png';
		if (!file_exists((FCPATH . $orderRelativePath))) {
			Orderprint_helper::saveOrderImage($order);
		}

		$receiptemailBasepath = base_url() . $orderRelativePath;
		$ordercreatedtime = strtotime($order['orderCreated']);
		$orderId = intval($order['orderId']);
		$orderAmount = floatval($order['orderAmount']);
		$serviceFee = floatval($order['serviceFee']);
		$serviceFeeTax = intval($order['serviceFeeTax']);
		$transactionNumber = intval( ('1000') . (100000 + $order['orderId']) );
		$products = explode($this->config->item('contactGroupSeparator'), $order['products']);
		$orderTypeId = intval($order['spotTypeId']);
		$ordertotalamount   =   $orderAmount+($serviceFee>0?$serviceFee:0);
		$this->setPaymentLines($orderId, $ordertotalamount);
		$this->setProductLines($products, $this->config->item('concatSeparator'), $orderTypeId);

		if($serviceFee>0){
			$this->productLines[]=array(
				'ProductGroupId'    =>  'fee01', // only categoryId !!! DONE
				'ProductGroupName'  =>  'fee', // categoryName !!! DONE
				'ProductId'         =>  'fee001', // productId !!! DONE
				'ProductName'       =>  'servicefee',
				'Quantity'          =>  1,
				'QuantityUnit'      =>  'P',
				'SellingPrice'      =>  $serviceFee,
				'VatRateId'         =>  Orderprint_helper::returnVatGrade($serviceFeeTax),
			);
		}
		// $jsonoutput['TransactionDateTime'] = date("c",strtotime($order['orderCreated'])); //gmdate(DATE_ATOM);//"2020-08-08T12:40:54";
		// $jsonoutput['TransactionDateTime_Emp'] = date("c", ($ordercreatedtime-10)); //this is for when emp
		// $jsonoutput['TransactionNumber'] = (int)(("1000").(100000+$order['orderId']) );
		// $jsonoutput['ordernumberr'] = $order['orderId'];
		// $jsonoutput['ProductLines'] = $this->ProductLines;
		// $jsonoutput['PaymentLines'] = $this->PaymentLines;
		// $jsonoutput['image'] = $receiptemailBasepath;
		// $jsonoutput['vendorId'] = $order['vendorId'];
		// $jsonoutput['lastNumber'] = $this->fodfdm_model->getlastRecieptCount($order['vendorId']);
		// $jsonoutput['ProductLines1'] = $this->ProductLines;
		// $jsonoutput['PaymentLines1'] = $this->PaymentLines;
		// $jsonoutput['image1'] =$jsonoutput['image'];//$receiptemailBasepath;

		$jsonoutput =  [
			'TransactionDateTime' => date("c", $ordercreatedtime), //gmdate(DATE_ATOM); //"2020-08-08T12:40:54";
			'TransactionDateTime_Emp' => date("c", ($ordercreatedtime - 10)), //this is for when emp
			'TransactionNumber' => $transactionNumber,
			'ordernumberr'      => $order['orderId'],
			'image'             => $receiptemailBasepath,
			'image1'            => $receiptemailBasepath,
			'vendorId'          => $order['vendorId'],
			'lastNumber'        => $this->fodfdm_model->getlastRecieptCount($order['vendorId']),
			'ProductLines'      => $this->productLines,
			'PaymentLines'      => $this->paymentLines,
			// 'ProductLines1'     => $this->productLines,
			// 'PaymentLines1'     => $this->paymentLines,
		];

		$this->shoporder_model->setObjectId($orderId)->setProperty('bbOrderPrint', '1')->update();

		// header('Content-type: image/png');
		echo json_encode($jsonoutput);
	}

	private function setProductLines(array $products, string $separator, int $orderType): void
	{
		$this->productLines = array_map(function($productString) use($separator, $orderType) {
			$product = explode($separator, $productString);
			// 0 => tbl_shop_products_extended.name
			// 1 => tbl_shop_products_extended.price
			// 2 => tbl_shop_order_extended.quantity
			// 3 => tbl_shop_categories.category
			// 4 => tbl_shop_categories.id
			// 5 => tbl_shop_products_extended.shortDescription
			// 6 => tbl_shop_products_extended.longDescription
			// 7 => tbl_shop_products_extended.vatpercentage
			// 8 => tbl_shop_products_extended.deliveryPrice
			// 9 => tbl_shop_products_extended.deliveryVatpercentage
			// 10 => tbl_shop_products_extended.pickupPrice
			// 11 => tbl_shop_products_extended.pickupVatpercentage
			// 12 => tbl_shop_products_extended.productId

			$quantity = floatval($product[2]);
			$vatpercentage = $this->getProductVatpercantage($product, $orderType);
			$productPrice = $this->getProductPrice($product, $orderType);
			$price = $quantity * $productPrice;


			return  [
				'ProductGroupId'    =>  'PRGR' . $product[4], // only categoryId !!! DONE
				'ProductGroupName'  =>  $product[3], // categoryName !!! DONE
				'ProductId'         =>  'PROD' . $product[12], // productId !!! DONE
				'ProductName'       =>  $product[0],
				'Quantity'          =>  $quantity,
				'QuantityUnit'      =>  'P',
				'SellingPrice'      =>  $price,
				'VatRateId'         =>  Orderprint_helper::returnVatGrade($vatpercentage), //"B",
				'DiscountLines'     => [
					// array(
					// "DiscountId"        =>  "DISC002",
					// "DiscountName"      =>  "Prod. discount10%",
					// "DiscountType"      =>  "PRODUCTDISCOUNT",z`
					// "DiscountGrouping"  =>  0,
					// "DiscountAmount"    =>  1.19
					// ),
					// array(
					// "DiscountId"        =>  "DISC001",
					// "DiscountName"      =>  "Receipt. discount10%",
					// "DiscountType"      =>  "RECEIPTDISCOUNT",
					// "DiscountGrouping"  =>  0,
					// "DiscountAmount"    =>  1.07
					// ),
				],
			];
		}, $products);

	}

	private function setPaymentLines(int $orderId, float $orderAmount): void
	{
		$this->paymentLines = [[
			'PaymentId'             =>  (string)$orderId, //ONLY ORDER ID WITHOUT PAY TESTING VERSION DONE
			'PaymentName'           =>  'Alfred',
			'PaymentType'           =>  'EFT',
			'Quantity'              =>  1,
			'PayAmount'             =>  $orderAmount,
			'ForeignCurrencyAmount' =>  0,
			'ForeignCurrencyISO'    =>  '',
			'Reference'             =>  (string)("Order id:".$orderId), // PAYNL TRANSACTION ID !!! DONE !!!
		]];
	}


	public function getdraw_get()
	{
		$get = Utility_helper::sanitizeGet();
		if(!$get['mac']) return;
		$url = base_url() . 'api/orders/print/get?mac=' . $get['mac'];
		header('Content-type: image/png');
		echo file_get_contents($url);
	}

	private function getProductPrice(array $product, int $orderType): float
	{
		if ($orderType === $this->config->item('local')) {
			return floatval($product[1]);
		} elseif ($orderType === $this->config->item('deliveryType')) {
			return floatval($product[8]);
		} elseif ($orderType === $this->config->item('pickupType')) {
			return floatval($product[10]);
		}
	}

	private function getProductVatpercantage(array $product, int $orderType): int
	{
		if ($orderType === $this->config->item('local')) {
			return intval($product[7]);
		} elseif ($orderType === $this->config->item('deliveryType')) {
			return intval($product[9]);
		} elseif ($orderType === $this->config->item('pickupType')) {
			return intval($product[11]);
		}
	}

	public function emailed_post($orderId): void
	{
		$emailMessage = '';
		$logFile = FCPATH . 'application/tiqs_logs/messages.txt';

		Utility_helper::logMessage($logFile, 'ordernumber ' .$orderId);

		$orderId = intval($orderId);
		$order = $this->shoporder_model->getorderinformation($orderId);

		if ($order['printStatus'] === '0' && empty($order['paymentType'])) return;

		Utility_helper::logMessage($logFile, 'order vendor'.$order['vendorId']);


		if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
			// $image = time().'-'.$_FILES["image"]['name'];
			$file_name = $order['orderId'] . '-email-bb' . '.png';
			$config = array(
				'upload_path' => FCPATH . 'receipts' . DIRECTORY_SEPARATOR,
				'allowed_types' => "gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF",
				'overwrite' => TRUE,
				'max_size' => "99999999999",
				'file_name' => $file_name
				);
			$this->load->library('upload', $config); 
			
			if($this->upload->do_upload('image')) {
				$receiptemail = FCPATH . 'receipts' . DIRECTORY_SEPARATOR . $file_name;
				// $res['msg']="Image has been uploaded!";
			} else {
				$receiptemail = '';
			}
			
		}

		if ($order['printStatus'] === '1' && file_exists($receiptemail)) {
			// SEND EMAIL
			$subject =   "tiqs-Order : ". $order['orderId'] ;
			$email =    $order['buyerEmail'];
			Email_helper::sendOrderEmail( $email, $subject, $emailMessage, $receiptemail);
			redirect('https://tiqs.com/spot/sendok' );
		}
	}
}
