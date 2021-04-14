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
        public $isApi;
        public $image;
        public $showImage;

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
            if (isset($data['isApi']) && !($data['isApi'] === '1' || $data['isApi'] === '0')) return false;
            if (isset($data['showImage']) && !($data['showImage'] === '1' || $data['showImage'] === '0')) return false;

            return true;
        }

        public function fetch(array $where): ?array
        {
            $where['archived'] = '0';
            $where['isApi'] = '0';

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
                    $this->table . '.openKey',
                    $this->table . '.image',
                    $this->table . '.showImage',
                ],
                $where,
                [],
                'order_by',
                [$this->table . '.sortNumber', 'ASC']
            );
        }

        public function fetcUserCategories(): ?array
        {
            $where = [];
            foreach ($this as $key => $value) {
                if (!is_null($value) && $key !== 'table') {
                    $where[$this->table . '.' . $key] = $value;
                }
            }
            return $this->fetch($where);
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

        public function checkOpenKey()
        {
            $check = $this->readImproved([
                'what'  => ['id'],
                'where' => [
                    'id'        => $this->id,
                    'openKey'   => $this->openKey
                ]
            ]);

            return !is_null($check);
        }

        public function getApiCategoryId(): ?int
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.userId' => $this->userId,
                    $this->table . '.isApi' => '1',
                    $this->table . '.category' => $this->config->item('api_category'),
                ]
            ]);

            if (is_null($id)) {
                $insert = [
                    'userId' => $this->userId,
                    'active' => '1',
                    'category' => $this->config->item('api_category'),
                    'isApi' => '1'
                ];
                return $this->setObjectFromArray($insert)->create() ? $this->id : null;
            }

            $id = reset($id);
            $id = intval($id['id']);
            return $id;
        }

        public function insertInitialCategory(string $category): ?int
        {
            $this->category = $category;
            $this->active = '1';

            return $this->create() ? $this->id : null;
        }

        public function getImages(): ?array
        {
            $images = $this->readImproved([
                'what'  => [$this->table . '.category', $this->table . '.image'],
                'where' => [
                    $this->table . '.userId' => $this->userId,
                    $this->table . '.active' => '1',
                    $this->table . '.showImage' => '1',
                    $this->table . '.image !=' => NULL,
                ]
            ]);

            if (is_null($images)) return null;

            $this->load->helper('utility_helper');

            $images = Utility_helper::resetArrayByKeyMultiple($images, 'category');

            return $images;
        }
    }
