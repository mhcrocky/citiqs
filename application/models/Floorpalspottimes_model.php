<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Floorpalspottimes_model extends AbstractSet_model implements InterfaceCrud_model
    {
        public $id;
        public $floorPlanId;
        public $timeFrom;
        public $timeTo;
        public $price;
        private $table = 'tbl_floorplan_time_slots';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'floorPlanId') {
                $value = intval($value);
            }
            if ($property === 'price') {
                $value = floatval($value);
            }
            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function deleteFloorPlaTimeSlots (): bool
        {
            return $this->db->delete($this->table, array('floorPlanId=' => $this->floorPlanId));
        }

    }