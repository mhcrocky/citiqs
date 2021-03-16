<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoparea_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $printerId;
        public $area;

        private $table = 'tbl_shop_areas';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'printerId') {
                $value = intval($value);
            }

            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['vendorId']) && isset($data['area']) && isset($data['printerId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['printerId']) && !Validate_data_helper::validateInteger($data['printerId'])) return false;
            if (isset($data['area']) && !Validate_data_helper::validateString($data['area'])) return false;
            return true;
        }


        public function createArea(): ?int
        {
            if ($this->checkIsAreaExists()) return null;
            return $this->create() ? $this->id : null;
        }

        private function checkIsAreaExists(): bool
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.area' => $this->area
            ];

            if (!empty($this->id)) {
                $where[$this->table . '.id !='] = $this->id;
            }
            
            $area = $this->readImproved([
                'what' => ['id'],
                'where' => $where
            ]);

            return !empty($area);
        }

        public function fetchVednorAreas(): ?array
        {
            return $this->readImproved([
                'what' => [
                    $this->table . '.id areaId',
                    $this->table . '.vendorId',
                    $this->table . '.printerId',
                    $this->table . '.area',
                    'tbl_shop_printers.id printerId',
                    'tbl_shop_printers.printer printerName'
                ],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId
                ],
                'joins' => [
                    ['tbl_shop_printers', 'tbl_shop_printers.id = ' . $this->table . '.printerId', 'INNER']
                ]
            ]);
        }

        public function checkAreaId(): bool
        {
            $check = $this->readImproved([
                'what' => [$this->table . '.area',],
                'where' => [
                    $this->table . '.id' => $this->id,
                    $this->table . '.vendorId' => $this->vendorId
                ],
            ]);

            return !is_null($check);
        }

        public function updateArea(): bool
        {
            if ($this->checkIsAreaExists()) return false;


            return $this->update();
        }
    }
