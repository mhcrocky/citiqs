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
        private $serviceFeePercent;
        private $serviceFeeAmount;
        private $paynlServiceId;
        public $termsAndConditions;
        public $requireMobile;

        private $table = 'tbl_shop_vendors';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'vendorId') {
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

    }
