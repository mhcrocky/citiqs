<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopcategorytime_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $categoryId;
        public $day;
        public $timeFrom;
        public $timeTo;
        private $table = 'tbl_shop_categories_times';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'categoryId') {
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
            if (isset($data['categoryId']) && isset($data['day']) && isset($data['timeFrom']) && isset($data['timeTo'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;

            $this->load->config('custom');

            if (isset($data['categoryId']) && !Validate_data_helper::validateInteger($data['categoryId'])) return false;
            if (isset($data['day']) && !in_array($data['day'], $this->config->item('weekDays'))) return false;
            return true;
        }

        public function deleteProductTimes(): void
        {
            $where = [
                $this->table . '.categoryId' => $this->categoryId
            ];

            $this->customDelete($where);
        }

        public function insertCategoryTimes(int $categoryId): bool
        {

            $this->load->config('custom');
            $days = $this->config->item('weekDays');

            $timeFrom = $this->config->item('timeFrom');
            $timeTo = $this->config->item('timeTo');
            foreach ($days as $day) {
                $insert = [
                    'categoryId' => $categoryId,
                    'day' => $day,
                    'timeFrom' => $timeFrom,
                    'timeTo' => $timeTo,
                ];
                if (!$this->setObjectFromArray($insert)->create()) return false;
            }
            return true;
        }

        private function isCategoryInserted(): bool
        {
            $id = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    $this->table . '.categoryId' => $this->categoryId
                ],
                'conditions' => [
                    'limit' => ['1']
                ]
            ]);

            return !is_null($id);
        }

        public function isCategoryOpen(): bool
        {
            // category is open every day from 00:00:00 to 23:59:59 if no any records in table
            if (!$this->isCategoryInserted()) return true;

            $day = date('D');
            $time = date('H:i:s');
            $id = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    $this->table . '.categoryId' => $this->categoryId,
                    $this->table . '.day' => $day,
                    $this->table . '.timeFrom<=' => $time,
                    $this->table . '.timeTo>' => $time
                ],
                'conditions' => [
                    'limit' => ['1']
                ]
            ]);

            return !is_null($id);
        }

    }
