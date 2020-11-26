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
        public $driverSmsMessage;
        public $archived;
        public $private;
        public $openKey;

        private $table = 'tbl_shop_categories';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

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
            if (isset($data['archived']) && !($data['archived'] === '1' || $data['archived'] === '0')) return false;
            if (isset($data['private']) && !($data['private'] === '1' || $data['private'] === '0')) return false;
            if (isset($data['openKey']) && !Validate_data_helper::validateString($data['openKey'])) return false;

            return true;
        }

        public function fetch(array $where): ?array
        {
            $where['archived'] = '0';
            return $this->read(
                [
                    $this->table . '.id AS categoryId',
                    $this->table . '.category',
                    $this->table . '.active',
                    $this->table . '.sendSms',
                    $this->table . '.driverNumber',
                    $this->table . '.delayTime',
                    $this->table . '.sortNumber',
                    $this->table . '.driverSmsMessage',
                    $this->table . '.private',
                    $this->table . '.openKey'
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


        private function isFreekKey(string $openKey): bool
        {
            $check = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    'openKey' => $openKey,
                    'userId !=' => $this->userId
                ]
            ]);
            return is_null($check);
        }

        public function createOpenKey(): string
        {
            $this->load->helper('utility_helper');

            $openKey = Utility_helper::shuffleString(8);
            if (!$this->isFreekKey($openKey)) {
                return $this->createOpenKey();
            }
            $query = 'UPDATE ' . $this->table . ' SET openKey = "' . $openKey . '" WHERE userId = ' . $this->userId . ';';
            $this->db->query($query);

            return $this->db->affected_rows() ? $openKey : $this->createOpenKey();
        }

    }
