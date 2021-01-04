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
		$this->load->model('businessreport_model');
		
		$this->load->helper('utility_helper');
		$this->load->helper('reportesprint_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function index_get(): void
	{
		return;
    }

    public function zreport_get(): void
    {
		$vendorId = intval($this->input->get('vendorid', true));
		if (!$vendorId) return;
		$orders = $this->shoporder_model->fetchReportDetailsPaid($vendorId);
		if (!$orders) return;

		$totals = [
			'orders'			=> count($orders),
			'orderTotalAmount'		=> 0,
			'orderAmount'		=> 0,
			'productsExVat'		=> 0,
			'productsVat'		=> 0,
			'serviceFee'	=> 0,
			'exVatService'	=> 0,
			'vatService'		=> 0,
		];

		$details = array_merge(['count' => 0], array_fill_keys(array_keys($totals), 0));


		$totals['serviceTypes'] = [
			strval($this->config->item('local')) => $details,
			strval($this->config->item('deliveryType')) => $details,
			strval($this->config->item('pickupType')) => $details,
		];
		$totals['paymentTypes'] = array_fill_keys($this->config->item('paymentTypes'), $details);

		foreach($orders as $order) {
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

			$totals['serviceTypes'][$order['serviceTypeId']]['count']++;
			$totals['serviceTypes'][$order['serviceTypeId']]['orderTotalAmount'] += $orderTotalAmount;
			$totals['serviceTypes'][$order['serviceTypeId']]['orderAmount'] += $orderAmount;
			$totals['serviceTypes'][$order['serviceTypeId']]['productsExVat'] += $productsExVat;
			$totals['serviceTypes'][$order['serviceTypeId']]['productsVat'] += $productsVat;
			$totals['serviceTypes'][$order['serviceTypeId']]['serviceFee'] += $serviceFee;
			$totals['serviceTypes'][$order['serviceTypeId']]['exVatService'] += $exVatService;
			$totals['serviceTypes'][$order['serviceTypeId']]['vatService'] += $vatService;

			$totals['paymentTypes'][$order['paymentType']]['count']++;
			$totals['paymentTypes'][$order['paymentType']]['orderTotalAmount'] += $orderTotalAmount;
			$totals['paymentTypes'][$order['paymentType']]['orderAmount'] += $orderAmount;
			$totals['paymentTypes'][$order['paymentType']]['productsExVat'] += $productsExVat;
			$totals['paymentTypes'][$order['paymentType']]['productsVat'] += $productsVat;
			$totals['paymentTypes'][$order['paymentType']]['serviceFee'] += $serviceFee;
			$totals['paymentTypes'][$order['paymentType']]['exVatService'] += $exVatService;
			$totals['paymentTypes'][$order['paymentType']]['vatService'] += $vatService;
		}

		$totals['serviceTypes'] = array_filter($totals['serviceTypes'], function($el) {
			if ($el['count']) return $el;
		});

		$totals['paymentTypes'] = array_filter($totals['paymentTypes'], function($el) {
			if ($el['count']) return $el;
		});

		Reportesprint_helper::printZreport($totals);

		return;		
    }
}

