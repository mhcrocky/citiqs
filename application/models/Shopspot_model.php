<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopspot_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $printerId;
        public $spotName;
        public $active;
        public $spotTypeId;

        private $table = 'tbl_shop_spots';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateInteger($value)) return;

            if ($property === 'id' || $property === 'printerId' || $property === 'spotTypeId') {
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

        public function insertValidate(array $data): bool
        {
            if (isset($data['printerId']) && isset($data['spotName']) && isset($data['active']) && isset($data['spotTypeId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['printerId']) && !Validate_data_helper::validateInteger($data['printerId'])) return false;
            if (isset($data['spotName']) && !Validate_data_helper::validateString($data['spotName'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            if (isset($data['spotTypeId']) && !Validate_data_helper::validateInteger($data['spotTypeId'])) return false;            

            return true;
        }

        public function fetchUserSpots(int $userId): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS spotId',
                    $this->table . '.printerId AS spotPrinterId',
                    $this->table . '.spotName AS spotName',
                    $this->table . '.active AS spotActive',
                    $this->table . '.spotTypeId AS spotTypeId',
                    'tbl_shop_printers.printer AS printer',
                    'tbl_shop_printers.active AS printerActive',
                    'tbl_shop_spot_types.type AS spotType'
                ],
                [ 'tbl_shop_printers.userId=' => $userId],
                [
                    ['tbl_shop_printers', $this->table . '.printerId = tbl_shop_printers.id', 'INNER'],
                    ['tbl_shop_spot_types', $this->table . '.spotTypeId = tbl_shop_spot_types.id', 'INNER']
                ],
                'order_by',
                [$this->table . '.spotName', 'ASC']
            );
        }

        public function checkSpottName(array $where): bool
        {
            $count = $this->readImproved(
                [
                    'what'  => [$this->table . '.id'],
                    'where' => $where,
                    'joins' => [
                        ['tbl_shop_printers', $this->table.'.printerId = tbl_shop_printers.id', 'LEFT']
                    ],
                    'conditions' => [
                        'LIMIT' => ['1'],
                    ]

                ]
            );

            return $count ? true : false;
        }

        public function fetchUserSpotsImporved($where): ?array
        {
            return $this->readImproved([
                'what' => [
                $this->table . '.id AS spotId',
                    $this->table . '.printerId AS spotPrinterId',
                    $this->table . '.spotName AS spotName',
                    $this->table . '.active AS spotActive',
                    'tbl_shop_printers.printer AS printer',
                    'tbl_shop_printers.active AS printerActive',
                    'tbl_shop_vendor_types.active as typeactive'
                ],
                'where' => $where,
                'joins' => [
                    ['tbl_shop_printers', $this->table . '.printerId = tbl_shop_printers.id', 'INNER'],
                    ['tbl_shop_spot_types', 'tbl_shop_spot_types.id = ' . $this->table . '.spotTypeId' , 'INNER'],
                    ['tbl_shop_vendor_types', 'tbl_shop_vendor_types.typeId = tbl_shop_spot_types.id', 'INNER']
                ],
                'conditions' => [
                    'order_by' => ['length(`spotName`),`spotName`'],
                    'group_by' =>  [$this->table . '.id']
                ]
				

            ]);
        }

//		[$this->table . '.id', 'ASC']

        public function isActive(): bool
        {
            $this->setObject();
            return ($this->active === '1') ? true : false;
        }
    }
