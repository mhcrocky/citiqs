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
        public $archived;
        public $isApi;
        public $areaId;

        private $table = 'tbl_shop_spots';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'printerId' || $property === 'spotTypeId' || $property === 'areaId') {
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
            if (isset($data['archived']) && !($data['archived'] === '1' || $data['archived'] === '0')) return false;
            if (isset($data['isApi']) && !($data['isApi'] === '1' || $data['isApi'] === '0')) return false;
            if (isset($data['areaId']) && !Validate_data_helper::validateInteger($data['areaId'])) return false;

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
                    $this->table . '.areaId AS areaId',
                    'tbl_shop_printers.printer AS printer',
                    'tbl_shop_printers.active AS printerActive',
                    'tbl_shop_spot_types.type AS spotType'
                ],
                [
                    'tbl_shop_printers.userId=' => $userId,
                    $this->table . '.archived' => '0',
                    $this->table . '.isApi' => '0',
                ],
                [
                    ['tbl_shop_printers', $this->table . '.printerId = tbl_shop_printers.id', 'INNER'],
                    ['tbl_shop_spot_types', $this->table . '.spotTypeId = tbl_shop_spot_types.id', 'INNER']
                ],
                'order_by',
                [$this->table . '.spotName', 'ASC']
            );
        }

        public function fetchUserActiveSpots(int $userId): ?array
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
                [
                    'tbl_shop_printers.userId=' => $userId,
                    $this->table . '.archived' => '0',
                    $this->table . '.active' => '1',
                ],
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
                    $this->table . '.spotTypeId AS spotTypeId',
                    'tbl_shop_printers.printer AS printer',
                    'tbl_shop_printers.active AS printerActive',
                    'tbl_shop_vendor_types.active as typeactive',
                    'tbl_shop_spot_types.type AS spotType',
                    'tblShopSpotTimes.spotTimes'
                ],
                'where' => $where,
                'joins' => [
                    ['tbl_shop_printers', $this->table . '.printerId = tbl_shop_printers.id', 'INNER'],
                    ['tbl_shop_spot_types', 'tbl_shop_spot_types.id = ' . $this->table . '.spotTypeId' , 'INNER'],
                    ['tbl_shop_vendor_types', 'tbl_shop_vendor_types.typeId = tbl_shop_spot_types.id', 'INNER'],
                    [
                        '(
                            SELECT
                                tbl_shop_spot_times.spotId,
                                GROUP_CONCAT(
                                    tbl_shop_spot_times.day,
                                    "|", tbl_shop_spot_times.timeFrom,
                                    "|", tbl_shop_spot_times.timeTo
                                ) AS spotTimes
                            FROM
                            tbl_shop_spot_times
                            GROUP BY tbl_shop_spot_times.spotId
                        ) tblShopSpotTimes',
                        'tblShopSpotTimes.spotId = ' . $this->table . '.id' ,
                        'LEFT'
                    ],
                    
                ],
                'conditions' => [
                    'order_by' => ['length(`spotName`),`spotName`'],
                    'group_by' =>  [$this->table . '.id']
                ]
				

            ]);
        }

        public function isActive(): bool
        {
            $this->setObject();
            return ($this->active === '1') ? true : false;
        }
        
        public function fetchSpot(int $vendorId, int $spotId): ?array
        {
            $where = [
                'tbl_shop_printers.userId=' => $vendorId,
                'tbl_shop_spots.active' => '1',
                'tbl_shop_spots.id' => $spotId,
                'tbl_shop_spots.archived' => '0',
                'tbl_shop_spots.isApi' => '0',
                'tbl_shop_vendor_types.active=' => '1',
                'tbl_shop_vendor_types.vendorId=' => $vendorId
            ];
            $spot = $this->fetchUserSpotsImporved($where);
            return (!empty($spot)) ? reset($spot) : null;
        }

        public function getSpotPrinterId(): int
        {
            $printerId = $this->getProperty('printerId');
            return intval($printerId);
        }

        public function fetchUserSpotsByType(int $userId, int $typeId): ?array
        {
            $result =  $this->read(
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
                [
                    'tbl_shop_printers.userId=' => $userId,
                    $this->table . '.archived = ' => '0',
                    $this->table . '.active = ' => '1',
                    $this->table . '.spotTypeId = ' => $typeId
                ],
                [
                    ['tbl_shop_printers', $this->table . '.printerId = tbl_shop_printers.id', 'INNER'],
                    ['tbl_shop_spot_types', $this->table . '.spotTypeId = tbl_shop_spot_types.id', 'INNER']
                ],
                'order_by',
                [$this->table . '.spotName', 'ASC']
            );

            return $result;
        }

        public function getApiDeliverySpotId(): ?int
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.printerId' => $this->printerId,
                    $this->table . '.isApi' => '1',
                    $this->table . '.spotTypeId' => $this->config->item('deliveryType'),
                    $this->table . '.spotName' => $this->config->item('api_spot_delivery'),
                ]
            ]);

            if (is_null($id)) {
                $insert = [
                    'printerId' => $this->printerId,
                    'spotName' => $this->config->item('api_spot_delivery'),
                    'active' => '1',
                    'spotTypeId' => $this->config->item('deliveryType'),
                    'isApi' => '1'
                ];
                return $this->setObjectFromArray($insert)->create() ? $this->id : null;
            }

            $id = reset($id);
            $id = intval($id['id']);
            return $id;
        }

        public function getApiPickupSpotId(): ?int
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.printerId' => $this->printerId,
                    $this->table . '.isApi' => '1',
                    $this->table . '.spotTypeId' => $this->config->item('pickupType'),
                    $this->table . '.spotName' => $this->config->item('api_spot_pickup'),
                ]
            ]);

            if (is_null($id)) {
                $insert = [
                    'printerId' => $this->printerId,
                    'spotName' => $this->config->item('api_spot_pickup'),
                    'active' => '1',
                    'spotTypeId' => $this->config->item('pickupType'),
                    'isApi' => '1'
                ];
                return $this->setObjectFromArray($insert)->create() ? $this->id : null;
            }

            $id = reset($id);
            $id = intval($id['id']);
            return $id;
        }

        public function insertInitialSpot(): bool
        {
            $this->load->config('custom');
            $this->active = '1';
            $this->spotName = 'Initial spot';
            $this->spotTypeId = $this->config->item('local');

            if (!$this->create()) return false;

            $this->load->model('shopspottime_model');

            return $this->shopspottime_model->setProperty('spotId', $this->id)->insertSpotTime();
        }

        public function updateAreaIdToNull(): bool
        {
            $query = 'UPDATE ' . $this->table . ' SET areaId = NULL WHERE areaId = ' . $this->areaId;
            return $this->db->query($query);
        }

        public function getFirstLocalSpotId(int $userId): ?int
        {
            $this->load->config('custom');
            $spotId =  $this->readImproved([
                'what' => [
                    $this->table . '.id AS spotId',
                ],
                'where' => [
                    'tbl_shop_printers.userId=' => $userId,
                    $this->table . '.archived = ' => '0',
                    $this->table . '.active = ' => '1',
                    $this->table . '.spotTypeId = ' => $this->config->item('local')
                ],
                'joins' => [
                    ['tbl_shop_printers', $this->table . '.printerId = tbl_shop_printers.id', 'INNER'],
                    ['tbl_shop_spot_types', $this->table . '.spotTypeId = tbl_shop_spot_types.id', 'INNER']
                ],
                'conditions' => [
                    'order_by' => [$this->table . '.spotName', 'ASC'],
                    'limit' => ['1']
                ]
            ]);

            if (is_null($spotId)) return null;

            $spotId = intval($spotId[0]['spotId']);
            return $spotId;
        }

        public function hasTypeActiveSpots($where): bool
        {
            $result = $this->readImproved([
                'what' => [
                    'tbl_shop_spot_types.id AS typeId',
                    'tbl_shop_spot_types.type AS type',
                ],
                'where' => $where,
                'joins' => [
                    ['tbl_shop_printers', 'tbl_shop_printers.id = ' . $this->table . '.printerId' , 'INNER'],
                    ['tbl_shop_spot_types', 'tbl_shop_spot_types.id = ' . $this->table . '.spotTypeId' , 'INNER']
                ],
                'conditions' => [
                    'group_by' =>  ['tbl_shop_spot_types.id']
                ]
            ]);

            return !is_null($result);
        }

        public function fetchTypeSpots(int $userId, string $type): ?array
        {
            $filterSpots = [
                'tbl_shop_printers.userId' => $userId,
                'tbl_shop_spots.spotTypeId' => $type,
            ];

            return $this->fetchUserSpotsImporved($filterSpots);
        }
    }
