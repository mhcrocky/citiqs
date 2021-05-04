<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Slug_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $slug;
        public $controller;
        public $redirect;
        public $vendorId;
        public $typeId;
        public $spotId;
        public $qrcode;

        private $table = 'tbl_app_routes';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'typeId' || $property === 'spotId') {
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
            if (
                isset($data['slug'])
                && isset($data['vendorId'])
                // && isset($data['redirect'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['slug']) && !Validate_data_helper::validateString($data['slug'])) return false;
            if (isset($data['controller']) && !Validate_data_helper::validateString($data['controller'])) return false;
            if (isset($data['redirect']) && !Validate_data_helper::validateString($data['redirect'])) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['typeId']) && !Validate_data_helper::validateInteger($data['typeId'])) return false;
            if (isset($data['spotId']) && !Validate_data_helper::validateInteger($data['spotId'])) return false;
            if (isset($data['qrcode']) && !Validate_data_helper::validateString($data['qrcode'])) return false;

            return true;
        }

        public function getSlugs(array $where): ?array
        {
            return $this->readImproved([
                'what' => [
                    $this->table . '.id slugId',
                    $this->table . '.slug slug',
                    $this->table . '.controller controller',
                    $this->table . '.vendorId vendorId',
                    $this->table . '.typeId typeId',
                    $this->table . '.spotId AS spotId',
                ],
                'where' => $where,
                'conditions' => [
                    'order_by' => [$this->table . '.id ASC']
                ]
            ]);
        }
    }
