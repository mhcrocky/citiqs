<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Floorplandetails_model extends AbstractSet_model implements InterfaceCrud_model
    {
        public $id;
        public $spot_object_id;
        public $file_name;
        public $file_type;
        public $file_path;
        public $orig_name;
        public $canvas;
        public $raw_name;
        public $floor_name;
        public $workingDays;        
        public $startDate;
        public $endDate;
        public $startTime;
        public $endTime;

        private $table = 'tbl_floorplan_details';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'imageID') {
                $value = intval($value);
            }
            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function get_floorplan ($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get($this->table);
            return $query->row();
        }

        public function fetch(): ?array
        {
            return $this->read(
                [
                    'tbl_floorplan_details.*',
                    'tbl_spot_objects.startTime AS objectStartTime',
                    'tbl_spot_objects.endTime AS objectEndTime',
                    'tbl_floorplan_time_slots.timeFrom',
                    'tbl_floorplan_time_slots.timeTo',
                    'tbl_floorplan_time_slots.price'
                ],
                ['spot_object_id =' => $this->spot_object_id],
                [
                    ['tbl_spot_objects', 'tbl_spot_objects.id = tbl_floorplan_details.spot_object_id', 'INNER'],
                    ['tbl_floorplan_time_slots', 'tbl_floorplan_details.id = tbl_floorplan_time_slots.floorPlanId', 'LEFT']
                ],
                'order_by',
                ['tbl_floorplan_details.floor_name']
            );
        }
    }