<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Reservations extends BaseControllerWeb
{
	/**
	 * This is default constructor of the class
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('validate_data_helper');
		$this->load->helper('utility_helper');

		$this->load->model('user_subscription_model');
		$this->load->model('objectspot_model');
		$this->load->model('floorplandetails_model');
		$this->load->model('floorplanareas_model');
		$this->load->model('reservation_model');
		$this->load->model('floorpalspottimes_model');

		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->config('custom');
	}

	public function index($vendorId = false, $spotId = false)
	{
		if(!$vendorId){
			redirect('https://tiqs.com/presence/sites/home');
		}
		$this->global['pageTitle'] = 'TIQS : RESERVATIONS';
		$criteria = ['tbl_spot_objects.id>'=>0];

		if($spotId) {
            $criteria['id'] = $spotId;
        }

		$data = [
			'objects' => $this->objectspot_model->read(['tbl_spot_objects.*'],$criteria)
		];
		//var_dump($this->objectspot_model->read(['tbl_spot_objects.*'],$criteria));exit();

		if($spotId && $data['objects'] && count($data['objects']) == 0) {
		    redirect('reservations');
        }

        $this->global['page'] = 'reservations_index';

		if (!empty($_POST)) {
			$get = $this->input->post(null, true);
			$from = (isset($get['date']) && isset($get['start'])) ? $get['date'] . ' ' . $get['start'] . ':00' : null;
			$to = (isset($get['date']) && isset($get['end'])) ? $get['date'] . ' ' . $get['end'] . ':00' : null;

			$data['floorplans'] = $this->floorplandetails_model->read(['*'], ['spot_object_id' => $get['object']]);


			if($data['floorplans']) {
                foreach($data['floorplans'] as $key => $floorplan) {
                    $data['floorplans'][$key]['areas'] = $this->reservation_model->getReservations($floorplan['id'], $get['persons'], $from, $to);
                    $data['floorplans'][$key]['timeSlots'] = $this->floorpalspottimes_model->read(
                        [
                            'tbl_floorplan_time_slots.id AS slotId',
                            'tbl_floorplan_time_slots.timeFrom AS slotTimeFrom',
                            'tbl_floorplan_time_slots.timeTo AS slotTimeTo',
                            'tbl_floorplan_time_slots.price AS slotPrice'
                        ],
                        ['tbl_floorplan_time_slots.floorPlanId=' => $floorplan['id']]
                    );
                    for ($i = 0; $i < count($data['floorplans'][$key]['areas']); $i++) {
                        $data['floorplans'][$key]['areas'][$i]['timeslots'] = $data['floorplans'][$key]['timeSlots'];
                    }
                }
            }
			$data['get'] = $get;
		}
		$data['spotId'] = $spotId;
		$data['vendorId'] = $vendorId;

		$this->loadViews('reservations', $this->global, $data, NULL, 'headerwebloginhotelSettings_new'); // Menu profilepage
	}

	public function makeReservations(): void
	{
		$redirect = base_url() . 'reservations';

		if (!empty($_GET)) {
			$get = $this->input->get(null, true);
			$from = $get['date'] . ' ' . $get['start'] . ':00';
			$to = $get['date'] . ' ' . $get['end'] . ':00';

			$insert = [
				'areaId' => $get['areaId'],
				'persons' => $get['persons'],
				'price' => $get['price'],
				'from' => $from,
				'to' => $to,
			];
//			 var_dump($this->reservation_model->checkIsSpotFree($get['persons'], $from, $to, $get['areaId']));
//			 die();

			if ($this->reservation_model->checkIsSpotFree($get['persons'], $from, $to, $get['areaId'])) {
				if ($this->reservation_model->setObjectFromArray($insert)->create()) {
					$this->floorplanareas_model->setObjectId(intval($get['areaId']))->setObject();
					$_SESSION['reservation_data'] = [
						'reservationId' => $this->reservation_model->id,
						'price' => $get['price'],
						'numberofpersons' => $get['persons'],
						'SpotId' => $get['areaId'],
						'Spotlabel' => $this->floorplanareas_model->area_label,
						'timefrom' => $from,
						'timeto' => $to,

					];
//					var_dump($_SESSION);
					redirect('booking');
				} else {
					$this->session->set_flashdata('error', 'Reservation failed');
					redirect($redirect);
				}
			} else {
				$redirect = base_url() . 'reservations?';
				$redirect .= 'object=' . $get['object'];
				$redirect .= '&date=' . $get['date'];
				$redirect .= '&start=' . $get['start'];
				$redirect .= '&end=' .$get['end'];
				$redirect .= '&persons=' . $get['persons'];
				$this->session->set_flashdata('error', 'This spot is not available at this period!');
				redirect($redirect);
			}
		}
		exit();
	}


	public function success()
    {
        $this->global['pageTitle'] = 'TIQS : SUCCESS';
		$this->loadViews("reservationSuccess", $this->global, null, 'nofooter', 'noheader'); // payment screen

	}
}
