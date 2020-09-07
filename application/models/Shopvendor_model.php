<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopvendor_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $serviceFeePercent;
        public $serviceFeeAmount;
        public $paynlServiceId;
        public $termsAndConditions;
        public $requireMobile;
        public $payNlServiceId;
        public $printTimeConstraint;
        public $minimumOrderFee;
        public $serviceFeeTax;
        public $healthCheck;
        public $requireReservation;
        public $preferredView;

        public $bancontact;
        public $ideal;
        public $creditCard;
        public $giro;
        public $prePaid;
        public $postPaid;
        public $payconiq;


        private $table = 'tbl_shop_vendors';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateInteger($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'serviceFeeTax') {
                $value = intval($value);
            }
            if ($property === 'serviceFeePercent' || $property === 'serviceFeeAmount') {
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
            if (isset($data['vendorId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['requireMobile']) && !($data['requireMobile'] === '1' || $data['requireMobile'] === '0')) return false;
            // if (isset($data['termsAndConditions']) && !Validate_data_helper::validateString($data['termsAndConditions'])) return false;
            if (isset($data['serviceFeePercent']) && !Validate_data_helper::validateString($data['serviceFeePercent'])) return false;
            if (isset($data['serviceFeeAmount']) && !Validate_data_helper::validateFloat($data['serviceFeeAmount'])) return false;
            if (isset($data['paynlServiceId']) && !Validate_data_helper::validateString($data['paynlServiceId'])) return false;
            if (isset($data['bancontact']) && !($data['bancontact'] === '1' || $data['bancontact'] === '0')) return false;
			if (isset($data['payconiq']) && !($data['payconiq'] === '1' || $data['payconiq'] === '0')) return false;
            if (isset($data['ideal']) && !($data['ideal'] === '1' || $data['ideal'] === '0')) return false;
            if (isset($data['creditCard']) && !($data['creditCard'] === '1' || $data['creditCard'] === '0')) return false;
            if (isset($data['printTimeConstraint']) && !Validate_data_helper::validateInteger($data['printTimeConstraint'])) return false;
            if (isset($data['minimumOrderFee']) && !Validate_data_helper::validateFloat($data['minimumOrderFee'])) return false;
            if (isset($data['serviceFeeTax']) && !Validate_data_helper::validateInteger($data['serviceFeeTax'])) return false;
            if (isset($data['giro']) && !($data['giro'] === '1' || $data['giro'] === '0')) return false;
            if (isset($data['healthCheck']) && !($data['healthCheck'] === '1' || $data['healthCheck'] === '0')) return false;
            if (isset($data['requireReservation']) && !($data['requireReservation'] === '1' || $data['requireReservation'] === '0')) return false;            
            if (isset($data['prePaid']) && !Validate_data_helper::validateString($data['prePaid'])) return false;
            if (isset($data['postPaid']) && !Validate_data_helper::validateString($data['postPaid'])) return false;
            if (isset($data['preferredView']) && !Validate_data_helper::validateInteger($data['preferredView'])) return false;

            return true;
        }

        public function getVendorData(): ?array
        {

            $filter = [
                'what' => [
                    $this->table . '.id',
                    $this->table . '.serviceFeePercent',
                    $this->table . '.serviceFeeAmount',
                    $this->table . '.payNlServiceId',
                    $this->table . '.termsAndConditions',
                    $this->table . '.requireMobile',
					$this->table . '.bancontact',
					$this->table . '.payconiq',
                    $this->table . '.ideal',
                    $this->table . '.creditCard',
                    $this->table . '.printTimeConstraint',
                    $this->table . '.minimumOrderFee',
                    $this->table . '.serviceFeeTax',
                    $this->table . '.giro',
                    $this->table . '.healthCheck',
                    $this->table . '.requireReservation',
                    $this->table . '.prePaid',
                    $this->table . '.postPaid',
                    $this->table . '.preferredView',
                    'tbl_user.id AS vendorId',
                    'tbl_user.username AS vendorName',
					'tbl_user.logo AS logo',
                    'tbl_user.email AS vendorEmail',
                    'tbl_user.country AS vendorCountry',
                    'GROUP_CONCAT(
                        CONCAT(
                            tbl_shop_vendor_types.id,
                            "|", tbl_shop_vendor_types.active,
                            "|", tbl_shop_spot_types.type,
                            "|", tbl_shop_vendor_types.typeId
                        )                        
                    ) AS typeData'
                ],
                'where' => [
                    $this->table. '.vendorId' => $this->vendorId,
                ],
                'joins' => [
                    ['tbl_user', 'tbl_user.id = ' . $this->table .'.vendorId' , 'INNER'],
                    ['tbl_shop_vendor_types', 'tbl_shop_vendor_types.vendorId = ' . $this->table .'.vendorId' , 'LEFT'],
                    ['tbl_shop_spot_types', 'tbl_shop_spot_types.id = tbl_shop_vendor_types.typeId' , 'LEFT'],
                ],
                'conditons' => [
                    'group_by' =>  $this->table .'.vendorId'
                ]
            ];

            $result = $this->readImproved($filter);

            if (is_null($result)) return null;
            $result = reset($result);

            // FOR OLD USER ... FROM LOST AND FOUND
            if (is_null($result['id'])) {
                $this->create();
                return $this->getVendorData();
            }

            if (is_null($result['typeData'])) {
                $this->insertTypes();
                return $this->getVendorData();
            }

            $result['serviceFeePercent'] = floatval($result['serviceFeePercent']);
            $result['serviceFeeAmount'] = floatval($result['serviceFeeAmount']);
            $result['minimumOrderFee'] = floatval($result['minimumOrderFee']);
            $result['serviceFeeTax'] = intval($result['serviceFeeTax']);
            $result['printTimeConstraint'] = intval($result['printTimeConstraint']);
            $result['vendorId'] = intval($result['vendorId']);
            $result['typeData'] = $this->prepareTypes($result['typeData']);
            return $result;
        }

        public function getPrintTimeConstraint()
        {
            $printTimeConstraint = $this->shopvendor_model->readImproved([
                'what' => ['printTimeConstraint'],
                'where' => ['vendorId' => $this->vendorId]
            ]);

            $printTimeConstraint = reset($printTimeConstraint)['printTimeConstraint'];
            return date('Y-m-d H:i:s', strtotime( '-' . $printTimeConstraint . ' hours', time() ));
        }

        public function getVendors(array $where): ?array
        {

            $filter = [
                'what' => [
                    $this->table . '.id',
                    $this->table . '.serviceFeePercent',
                    $this->table . '.serviceFeeAmount',
                    $this->table . '.payNlServiceId',
                    $this->table . '.termsAndConditions',
                    $this->table . '.requireMobile',
                    $this->table . '.bancontact',
                    $this->table . '.ideal',
                    $this->table . '.creditCard',
                    $this->table . '.printTimeConstraint',
                    $this->table . '.minimumOrderFee',
                    'tbl_user.id AS vendorId',
                    'tbl_user.username AS vendorName',
					'tbl_user.logo AS logo',
                    'tbl_user.email AS vendorEmail'

                ],
                'where' => $where,
                'joins' => [
                    ['tbl_user', 'tbl_user.id = ' . $this->table .'.vendorId' , 'INNER']
                ]
            ];

            return $this->readImproved($filter);
        }

        private function prepareTypes(string $types): array
        {
            $return = [];
            $types = explode(',', $types);
            foreach ($types as $type) {
                $type = explode('|', $type);
                array_push($return, [
                    'id' => $type[0],
                    'active' => $type[1],
                    'type' => $type[2],
                    'typeId' => $type[3],
                ]);
            }

            return $return;
        }

        private function insertTypes()
        {
            $this->load->model('shopspottype_model');
            $this->load->model('shopvendortypes_model');
            $types = $this->shopspottype_model->readImproved([
                'what' => ['id'],
                'where' => [
                    'id>' => '0'
                ]
            ]);
            foreach ($types as $type) {
                $active = $type['id'] === '1' ? '1' : '0';
                $insert = [
                    'vendorId' => $this->vendorId,
                    'typeId' => $type['id'],
                    'active' => $active,
                ];
                $this->shopvendortypes_model->setObjectFromArray($insert)->create();
            }
        }
    }
