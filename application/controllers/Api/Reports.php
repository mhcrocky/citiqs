<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Reports extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('shoporder_model');
		$this->load->model('user_model');

		$this->load->helper('utility_helper');
		$this->load->helper('reportesprint_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function index_get(): void
	{
		return;
    }

    public function report_get(): void
    {
		$get = Utility_helper::sanitizeGet();
		$vendorId = $this->getVendorId($get);
		$this->user_model->setUniqueValue($vendorId )->setWhereCondtition()->setUser('country');

		$taxRates = $this->config->item('countriesTaxes')[$this->user_model->country]['taxRates'];
		$from = (isset($get['datetimefrom'])) ? date('Y-m-d H:i:s', strtotime($get['datetimefrom'])) : date('Y-m-d 00:00:00');
		$to = (isset($get['datetimeto'])) ? date('Y-m-d H:i:s', strtotime($get['datetimeto'])) : date('Y-m-d H:i:s', strtotime('now'));
		$reportType = $get['report'];
		$isPosRequest = isset($get['finance']) ? false : true;
		$orders = $this->getOrders($vendorId, $from, $to, $reportType);
		$totals = $this->prepareTotals($orders, $reportType, $taxRates);
		$logo = $this->user_model->getUserProperty($vendorId, 'logo');
		$logoFile = (is_null($logo)) ? FCPATH . "/assets/home/images/tiqslogonew.png" : $this->config->item('uploadLogoFolder') . $logo;

		Reportesprint_helper::printReport($totals, $from, $to, $reportType, $logoFile, $vendorId, $isPosRequest);

		$folder = $isPosRequest ? $this->config->item('posReportes')  : $this->config->item('financeReportes');
		$report = $folder . $vendorId . '_' . $reportType . '.png';

		if (file_exists($report)) {
			$respone = [
				'status' => '1'
			];
		} else {
			$respone = [
				'status' => '0',
			];
		}

        echo json_encode($respone);

		return;
	}

	private function getVendorId(array $get): int
	{
		$vendorId = intval($get['vendorid']);
		if (!$vendorId) exit;
		return $vendorId;
	}

	private function getOrders(int $vendorId, string $from, string $to, string $reportType): array
	{
		$orders = $this->shoporder_model->fetchReportDetailsPaid($vendorId, $reportType, $from, $to);
		if (!$orders) exit;
		return $orders;
	}

	private function getProducts(string $orderProducts): array
	{
		$contactGroupSeparator = $this->config->item('contactGroupSeparatorNumber');
		$concatSeparator = $this->config->item('concatSeparatorNumber');
		$products = explode($contactGroupSeparator, $orderProducts);
		$products = array_map(function ($el) use($concatSeparator) {
			return explode($concatSeparator, $el);
		}, $products);

		return $products;
	}

	private function prepareTotals(array $orders, string $reportType, array $taxRates): array
	{
		$totals = [
			'orders'			=> count($orders),
			'orderTotalAmount'	=> 0,
			'orderAmount'		=> 0,
			'productsExVat'		=> 0,
			'productsVat'		=> 0,
			'serviceFee'		=> 0,
			'exVatService'		=> 0,
			'vatService'		=> 0,
		];


		$details = array_fill_keys(array_keys($totals), 0);
		$totals['vatGrades'] = array_fill_keys(array_values($taxRates), 0);
		$totals['serviceTypes'] = [
			strval($this->config->item('local')) => $details,
			strval($this->config->item('deliveryType')) => $details,
			strval($this->config->item('pickupType')) => $details,
		];
		$totals['paymentTypes'] = array_fill_keys($this->config->item('paymentTypes'), $details);

		if ($reportType === $this->config->item('x_report')) {
			$totals['productsDetailsXreport'] = [];
		}

		foreach($orders as $order) {
			$products = $this->getProducts($order['products']);

			$orderTotalAmount = floatval($order['orderTotalAmount']);
			$orderAmount = floatval($order['orderAmount']);
			$productsExVat = floatval($order['productsExVat']);
			$productsVat = floatval($order['productsVat']);
			$serviceFee = floatval($order['serviceFee']);
			$exVatService = floatval($order['exVatService']);
			$vatService = floatval($order['vatService']);

			$totals['orderTotalAmount'] += $orderTotalAmount;
			$totals['orderAmount'] += $orderAmount;
			$totals['productsExVat'] += $productsExVat;
			$totals['productsVat'] += $productsVat;
			$totals['serviceFee'] += $serviceFee;
			$totals['exVatService'] += $exVatService;
			$totals['vatService'] += $vatService;

			$this->calculateProductDetails($totals, $products);

			$totals['serviceTypes'][$order['serviceTypeId']]['orders']++;
			$totals['serviceTypes'][$order['serviceTypeId']]['orderTotalAmount'] += $orderTotalAmount;
			$totals['serviceTypes'][$order['serviceTypeId']]['orderAmount'] += $orderAmount;
			$totals['serviceTypes'][$order['serviceTypeId']]['productsExVat'] += $productsExVat;
			$totals['serviceTypes'][$order['serviceTypeId']]['productsVat'] += $productsVat;
			$totals['serviceTypes'][$order['serviceTypeId']]['serviceFee'] += $serviceFee;
			$totals['serviceTypes'][$order['serviceTypeId']]['exVatService'] += $exVatService;
			$totals['serviceTypes'][$order['serviceTypeId']]['vatService'] += $vatService;

			$totals['paymentTypes'][$order['paymentType']]['orders']++;
			$totals['paymentTypes'][$order['paymentType']]['orderTotalAmount'] += $orderTotalAmount;
			$totals['paymentTypes'][$order['paymentType']]['orderAmount'] += $orderAmount;
			$totals['paymentTypes'][$order['paymentType']]['productsExVat'] += $productsExVat;
			$totals['paymentTypes'][$order['paymentType']]['productsVat'] += $productsVat;
			$totals['paymentTypes'][$order['paymentType']]['serviceFee'] += $serviceFee;
			$totals['paymentTypes'][$order['paymentType']]['exVatService'] += $exVatService;
			$totals['paymentTypes'][$order['paymentType']]['vatService'] += $vatService;
		}

		$totals['serviceTypes'] = array_filter($totals['serviceTypes'], function($el) {
			if ($el['orders']) return $el;
		});

		$totals['paymentTypes'] = array_filter($totals['paymentTypes'], function($el) {
			if ($el['orders']) return $el;
		});


		return $totals;
	}

	private function calculateProductDetails(array &$totals, $products): void
	{
		foreach ($products as $product) {

			// product array declaration
			// z and x reportes
			// 0 => vat percent		string '21.00' (length=5)
			// 1 => total vat		string '5.21' (length=4)
			// x reportes
			// 2 => quantity		string '2' (length=1)
			// 3 => amount ex vat	string '24.79' (length=5)
			// 4 => product ex id	string '40197' (length=5)
			// 5 => product name	string 'COCA COLA' (length=9)

			$tax = intval($product[0]);
			$totals['vatGrades'][$tax] += floatval($product[1]);
			if (isset($totals['productsDetailsXreport'])) {
				$productExId = $product[4];
				if ( !isset($totals['productsDetailsXreport'][$productExId])) {
					$totals['productsDetailsXreport'][$productExId] = [
						'name' => $product[5],
						'quantity' => 0,
						'vat'	=> 0,
						'exVat'	=> 0,
						'total'	=> 0,
						'vatPercent' => $product[0]
					];
				}

				$vat = floatval($product[1]);
				$exVat = floatval($product[3]);
				$total = $exVat + $vat;

				$totals['productsDetailsXreport'][$productExId]['quantity'] += intval($product[2]);
				$totals['productsDetailsXreport'][$productExId]['vat'] += $vat;
				$totals['productsDetailsXreport'][$productExId]['exVat'] += $exVat;
				$totals['productsDetailsXreport'][$productExId]['total'] += $total;
			}
		}
	}
}
