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
        public $driverNumber;
        public $smsDelay;
        public $termsAndConditions;

        private $table = 'tbl_shop_vendors';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'vendorId' || $property === 'smsDelay') {
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
            if (isset($data['serviceFeePercent']) && !Validate_data_helper::validateFloat($data['serviceFeePercent'])) return false;
            if (isset($data['serviceFeeAmount']) && !Validate_data_helper::validateFloat($data['serviceFeeAmount'])) return false;
            if (isset($data['paynlServiceId']) && !Validate_data_helper::validateString($data['paynlServiceId'])) return false;
            // if (isset($data['driverNumber']) && !Validate_data_helper::validateString($data['driverNumber'])) return false;
            // if (isset($data['smsDelay']) && !Validate_data_helper::validateInteger($data['smsDelay'])) return false;
            // if (isset($data['termsAndConditions']) && !Validate_data_helper::validateString($data['termsAndConditions'])) return false;
            
            return true;
        }

        public function getVendorData(): ?array
        {

            $filter = [
                'what' => [
                    $this->table . '.serviceFeePercent',
                    $this->table . '.serviceFeeAmount',
                    $this->table . '.payNlServiceId',
                    'tbl_user.id AS vendorId',
                    'tbl_user.username AS vendorName',
                    'tbl_user.email AS vendorEmail'
                ],
                'where' => [
                    $this->table. '.vendorId' => $this->vendorId,
                ],
                'joins' => [
                    ['tbl_user', 'tbl_user.id = ' . $this->table .'.vendorId' , 'INNER']
                ]  
            ];
            // var_dump($filter);
            // die();

            $result = $this->readImproved($filter);

            if (is_null($result)) return null;
            $result = reset($result);

            $result['serviceFeePercent'] = floatval($result['serviceFeePercent']);
            $result['serviceFeeAmount'] = floatval($result['serviceFeeAmount']);
            $result['vendorId'] = intval($result['vendorId']);
            return $result;
        }

        public function updateVendorData(array $data): bool
        {
            $where = ' vendorId = ' . $data['vendorId'];
            $update = [
                'driverNumber' => $data['driverNumber'],
                'smsDelay' => $data['smsDelay'],
                'termsAndConditions' => $data['termsAndConditions'],
            ];
            return $this->db->update($this->getThisTable(), $update, $where);
        }

    }
