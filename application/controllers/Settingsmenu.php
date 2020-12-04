<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Settingsmenu extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
	protected $userId;
    public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('validate_data_helper');
		$this->load->helper('utility_helper');

		$this->load->model('user_subscription_model');
		$this->load->model('objectspot_model');
		$this->load->model('floorplandetails_model');
		$this->load->model('floorplanareas_model');
		$this->load->model('floorpalspottimes_model');

		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->library('form_validation');
		$this->load->config('custom');
		$this->isLoggedIn();
		$this->userId = $this->session->userdata('userId');
    }

    public function index(): void
    {
        $this->load->helper('delete_unsaved_floorplans_helper');
        delete_unsaved_floorplans();
		$data = [];
		$data['objects'] =	$this->objectspot_model->fetch(intval($_SESSION['userId']));
		$this->global['pageTitle'] = 'TIQS : OBJECTS';
		$this->loadViews('spotObjects', $this->global, $data, 'footerbusiness', 'headerbusiness');
		return;
	}

	public function editSpotObject($objectId)
	{
		$data = $this->input->post(null, true);
		$data['workingDays'] = serialize($data['workingDays']);
		$update = $this->objectspot_model->updateSpotObject($objectId, $data);

		if ($update) {
			$this->session->set_flashdata('success', 'Update success! Please check working time and time slots on floor plan(s) and adjust them to new working time.');
		} else {
			$this->session->set_flashdata('error', 'Update failed');
		}

		redirect('settingsmenu');

	}

	public function floor_plans($objectId)
	{
		$objectId = intval($objectId);
        $this->load->helper('delete_unsaved_floorplans_helper');
        delete_unsaved_floorplans();
	    $data = [];
		$this->floorplandetails_model->spot_object_id = $objectId;
			$data = [
				'floorPlans' => $this->floorplandetails_model->fetch(),
				'subscripitonPaid' => 1,
				'object' => $this->objectspot_model->setObjectId($objectId)->fetch()
			];
			if ($data['floorPlans']) {
                $data['floorPlans'] = Utility_helper::resetArrayByKeyMultiple($data['floorPlans'], 'id');
			}
			if ($data['object']) {
				
				$data['object'] = reset($data['object']);
			}
		$this->global['pageTitle'] = 'TIQS : FLOOR PLANS';
		$this->loadViews('objectFloorPlans', $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}

	public function edit_floorplan($objectId, $planId = null)
	{
        $this->load->helper('delete_unsaved_floorplans_helper');
        delete_unsaved_floorplans();
        $this->load->helper('directory');
		$this->global['pageTitle'] = 'TIQS : EDIT FLOOR PLAN';
		$data = [];
		if ($planId) {
			$data = [
				'floorplan' => $this->floorplandetails_model->get_floorplan($planId),
				'areas' => $this->floorplanareas_model->get_floorplan_areas($planId)
			];
		}

		//Get all files from dir
        $floorplan_images = directory_map(FCPATH . $this->config->item('floorPlansImagesPath'), FALSE);

		//Remove '/' from category name, remove index.html
        foreach ($floorplan_images as $category => $val) {
            $new_cat_name = str_replace(DIRECTORY_SEPARATOR, '',$category);
            $floorplan_images[$new_cat_name] = $floorplan_images[$category];
            unset($floorplan_images[$category]);
            if (isset($floorplan_images[$new_cat_name]) AND is_array($floorplan_images[$new_cat_name])) {
                foreach ($floorplan_images[$new_cat_name] as $key => $file) {
                    if ($file == 'index.html') {
                        unset($floorplan_images[$new_cat_name][$key]);
                    }

                }
            }
        }

        $data['floorplan_images_path'] = $this->config->item('floorPlansImagesPath');
        $data['floorplan_images']  = $floorplan_images;
        $data['objectId'] = $objectId;
		$this->loadViews('edit_floorplan', $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}

	public function show_floorplan ($objectId, $planId = null)
    {
        $this->load->helper('delete_unsaved_floorplans_helper');
        delete_unsaved_floorplans();
        $this->global['pageTitle'] = 'TIQS : VIEW FLOOR PLAN';
        $floorplan = $this->floorplandetails_model->get_floorplan($planId);
        if (!$floorplan) {
            $this->session->set_flashdata('message','Floor plan not found');
            return redirect()->to('/settingsmenu/floor_plans/'.$objectId);
        }
		$areas = $this->floorplanareas_model->get_floorplan_areas($planId);
        $data = [
            'objectId' => $objectId,
            'floorplan' => $floorplan,
            'areas' => $areas
        ];
        $this->loadViews('show_floorplan', $this->global, $data, NULL, 'headerwebloginhotelSettings');
	}

	public function addObjectTimeSlots($objectId, $floorplanId): void
	{
		$data = $this->input->post(null, true);
		$floorplanId = intval($floorplanId);
		$redirect = '/settingsmenu/floor_plans/' . $objectId;
		$floorplan = $data['floorplan'];
		$timeSlots = $data['timeslots'];

		$floorplan['workingDays'] = serialize($floorplan['workingDays']);
		$updateFlorPlan = $this
							->floorplandetails_model
							->setObjectId($floorplanId)
							->setObjectFromArray($floorplan)
							->update();

		if (!$updateFlorPlan) {
			$this->session->set_flashdata('error', 'Floorplan working time update failed');
			redirect($redirect);
		}
		
		if (count($timeSlots['from']) === count($timeSlots['to']) && count($timeSlots['from']) === count($timeSlots['price'])) {
			$count = count($timeSlots['from']);
			$this->floorpalspottimes_model->floorPlanId = $floorplanId;

			if(!$this->floorpalspottimes_model->deleteFloorPlaTimeSlots()) {
				$this->session->set_flashdata('error', 'Insert failed! Please try again');
				redirect($redirect);
				return;
			}

			for ($i = 0; $i < $count; $i++) {
				if ($timeSlots['from'][$i] && $timeSlots['to'][$i] && $timeSlots['price'][$i]) {
					$insert = [
						'timeFrom' => $timeSlots['from'][$i],
						'timeTo' => $timeSlots['to'][$i],
						'price' => floatval($timeSlots['price'][$i]),
					];
					if (!$this->floorpalspottimes_model->setObjectFromArray($insert)->create()) {
						$this->session->set_flashdata('error', 'Insert failed! Invalid time slot(s) data');
						break;
					}
				}
			}
			$this->session->set_flashdata('success', 'Update success');
		} else {
			$this->session->set_flashdata('error', 'Insert failed! Invalid time slot(s) data');
		}
		redirect($redirect);
		return;
	}

	public function saveSpotObject(){
		$data = [
			'userId' => $this->userId,
			'objectTypeId' => $this->input->post('objectType'),
			'objectName' => $this->input->post('name'),
			'country' => $this->input->post('country'),
			'city' => $this->input->post('city'),
			'zipCode' => $this->input->post('zipcode'),
			'address' => $this->input->post('address')
		];

		$this->objectspot_model->saveSpotObject($data);
	}
}