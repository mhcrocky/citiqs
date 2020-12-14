<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Comparison extends BaseControllerWeb
{
	private $vendor_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('comparison_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
	}

	public function index(){
		$data['title'] = 'Comparison';
		$this->global['pageTitle'] = 'Comparison';
		$this->load->library('form_validation');
		if ($this->input->post('filename')) {
			$config['upload_path']   = FCPATH.'assets/csv';
            $config['allowed_types'] = 'csv';
            $config['max_size']      = '102400'; // 102400 100mb
			$config['file_name']     = $this->input->post('filename');
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('userfile')) {
				$errors   = $this->upload->display_errors('', '');
				var_dump($errors);
			} else {
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
				$start_row = 2;
				$i = 1;
				$csv_orders = [];
				$file = fopen(FCPATH."assets/csv/".$file_name,"r");
				$key = 0;
				$order_ids = [];
				$amounts = [];
				while (($row = fgets($file)) !== FALSE) {
					if($i == 1){
						$headers = explode(';',$row);
						
						foreach($headers as $key => $header){
							if($header == "OMZET_TOTAAL"){
								$price_col = $key;
							}
							if($header == "EXTRA1"){
								$col = $key;
							}
						}
					}
					if($i >= $start_row) {
						$explode_row = explode(';',$row);
						if(is_numeric($explode_row[$col])){
							$order_id = $explode_row[$col];
							$price = floatval(str_replace(",", ".", $explode_row[$price_col]));
							if( !in_array($order_id, array_values($order_ids)) ){
								$csv_orders[$key]['order_id'] = $order_id;
								$order_ids[] = $order_id;
								$amounts[$order_id] = $price ;
							} else {
								$amounts[$order_id] = $amounts[$order_id] + $price;
							}
							
							
						}
								
						
						$key++;
					}
					$i++;
				}
				fclose($file);
				/*
				$db_order_id = $this->comparison_model->getOrderId();
				$diff  = array_diff($csv_order_id, $db_order_id);

				$db_price = $this->comparison_model->getPriceByOrderId();
				$order_ids = array_diff($csv_order_id, $diff);
				$new_prices = [];

				foreach($order_ids as $order_id){
					$new_prices[$order_id] = $db_price[$order_id];
				}

				$data['diff_order_ids'] = array_values($diff);
				$data['order_ids'] = array_values($order_ids);
				$data['prices'] = $prices;
				$data['new_prices'] = $new_prices;
				*/
				$db_orders = $this->comparison_model->getPriceByOrderId();
				$orders = [];
				$duplicate_values = array_count_values($order_ids);
				
				foreach($csv_orders as $key => $csv_order){
					$order_id = $csv_order['order_id'];
					$price = $amounts[$order_id];
					$csv_orders[$key]['price'] = $price;
					$order = $this->arrayDiff($db_orders, $order_id, $price);

						if(count($order) > 0){
							$orders[] = $order;
							unset($csv_orders[$key]);
						}
				}

				unlink(FCPATH."assets/csv/".$file_name);

				$data['csv_orders'] = $csv_orders;
				$data['db_orders'] = array_map("unserialize", array_unique(array_map("serialize", $orders)));
				$this->loadViews("compare_file", $this->global, $data, 'footerbusiness', 'headerbusiness');
				
			}
		} else {
			$this->loadViews("compare_file", $this->global, $data, 'footerbusiness', 'headerbusiness');
		}
		
	}

	public function arrayDiff($db_orders, $order_id, $price)
	{
		$order = [];
		foreach($db_orders as $key => $db_order){
			if( $order_id == $db_order['order_id'] )
			{
				$order['order_id'] = $db_order['order_id'];
				$order['csv_price'] = $price;
				$order['db_price'] = $db_order['price'];
				return $order;
			}
		}
		return $order;

	}


}
