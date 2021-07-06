<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Floorplan_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $floorplanName;
        public $floorplanImage;
        public $canvas;

        private $table = 'tbl_floorplans';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'vendorId') {
                $value = intval($value);
            }
            return;
        }

        public function insertValidate(array $data): bool
        {
            if (
                isset($data['vendorId'])
                && isset($data['floorplanName'])
                && isset($data['floorplanImage'])
                && isset($data['canvas'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;

            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['floorplanName']) && !Validate_data_helper::validateStringImproved($data['floorplanName'], 2)) return false;
            if (isset($data['floorplanImage']) && !Validate_data_helper::validateStringImproved($data['floorplanImage'], 2)) return false;
            if (isset($data['canvas']) && !Validate_data_helper::validateStringImproved($data['canvas'], 2)) return false;

            return true;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function fetchVendorFloorplans(): ?array
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId
            ];

            if ($this->id) {
                $where[$this->table . '.id'] = $this->id;
            }

            $floorplans = $this->readImproved([
                'what'  => [
                    $this->table . '.*'
                ],
                'where' => $where
            ]);

            if (is_null($floorplans)) return null;

            $this->load->model('floorplanareas_model');

            return array_map(function($floorplan){
                return [
                    'floorplan' => $floorplan,
                    'areas' => $this->floorplanareas_model->get_floorplan_areas($floorplan['id'])
                ];
            }, $floorplans);
        }

        private function isVendorFloorplan(): bool
        {
            if (empty($this->id) || empty($this->vendorId)) return false;

            $id = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    $this->table . '.id' => $this->id,
                    $this->table . '.vendorId' => $this->vendorId,
                ]
            ]);

            return !is_null($id);
        }

        public function deleteFloorplan(Floorplanareas_model $floorplanAreas): bool
        {
            if (!$this->isVendorFloorplan()) return false;
            $floorplanAreas->setProperty('floorplanID', $this->id)->deleteFloorplanAreas();
            return $this->delete();
        }

        public function updateFloorplan(array $floorplan): bool
        {
            $this->setObjectFromArray($floorplan);
            return ($this->isVendorFloorplan()) ? $this->update() : false;
        }

        // public function fetch(): ?array
        // {
        //     return $this->read(
        //         [
        //             'tbl_floorplan_details.*',
        //             'tbl_spot_objects.startTime AS objectStartTime',
        //             'tbl_spot_objects.endTime AS objectEndTime',
        //             'tbl_floorplan_time_slots.timeFrom',
        //             'tbl_floorplan_time_slots.timeTo',
        //             'tbl_floorplan_time_slots.price'
        //         ],
        //         ['spot_object_id =' => $this->spot_object_id],
        //         [
        //             ['tbl_spot_objects', 'tbl_spot_objects.id = tbl_floorplan_details.spot_object_id', 'INNER'],
        //             ['tbl_floorplan_time_slots', 'tbl_floorplan_details.id = tbl_floorplan_time_slots.floorPlanId', 'LEFT']
        //         ],
        //         'order_by',
        //         ['tbl_floorplan_details.floor_name']
        //     );
        // }
    }