<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopcategory_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $userId;
        public $category;
        public $active;
        public $sendSms;
        public $driverNumber;
        public $delayTime;
        public $sortNumber;


        private $table = 'tbl_shop_categories';

        protected function setValueType(string $property,  &$value): void
        {

            if ($property === 'id' || $property === 'userId') {
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
            if (isset($data['userId']) && isset($data['category']) && isset($data['active'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['userId']) && !Validate_data_helper::validateInteger($data['userId'])) return false;
            if (isset($data['category']) && !Validate_data_helper::validateString($data['category'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            if (isset($data['sendSms']) && !($data['sendSms'] === '1' || $data['sendSms'] === '0')) return false;
            // if (isset($data['driverNumber']) && !Validate_data_helper::validateString($data['driverNumber'])) return false;
            if (isset($data['delayTime']) && !Validate_data_helper::validateInteger($data['delayTime'])) return false;
            if (isset($data['sortNumber']) && !Validate_data_helper::validateInteger($data['sortNumber'])) return false;

            return true;
        }

        public function fetch(array $where): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS categoryId',
                    $this->table . '.category',
                    $this->table . '.active',
                    $this->table . '.sendSms',
                    $this->table . '.driverNumber',
                    $this->table . '.delayTime',
                    $this->table . '.sortNumber',
                ],
                $where,
                [],
                'order_by',
                [$this->table . '.sortNumber', 'ASC']
            );
        }

        public function checkIsInserted(array $data): bool
        {
            $where = ['userId=' => $data['userId'],'category=' => $data['category']];
            if ($this->id) {
                $where['id!='] = $this->id;
            }
            $count = $this->read(['id'], $where);

            return $count ? true : false;
        }
    }
