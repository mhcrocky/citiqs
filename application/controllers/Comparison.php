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
				$csv_order_id = [];
				$prices = [];
				$file = fopen(FCPATH."assets/csv/".$file_name,"r");
				while (($row = fgets($file)) !== FALSE) {
					if($i == 1){
						$headers = explode(';',$row);
						//var_dump($headers);
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
							$csv_order_id[] = $explode_row[$col];

							if(strpos($explode_row[$price_col], ',') !== false){
								$prices[$order_id] = abs(floatval(str_replace(",", ".", $explode_row[$price_col])));
							} else
							{
								$prices[$order_id] = abs(intval($explode_row[$price_col]));
							}
								
						}
					}
					$i++;
				}
				fclose($file);
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
				
				unlink(FCPATH."assets/csv/".$file_name);
				$this->loadViews("compare_file", $this->global, $data, 'footerbusiness', 'headerbusiness');
				
			}
		} else {
			$this->loadViews("compare_file", $this->global, $data, 'footerbusiness', 'headerbusiness');
		}
		
	}


}
