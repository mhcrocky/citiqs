<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopvendortime_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $day;
        public $timeFrom;
        public $timeTo;

        private $table = 'tbl_shop_vendor_times';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId') {
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
            if (isset($data['vendorId']) && isset($data['day']) && isset($data['timeFrom']) && isset($data['timeTo'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['day']) && !(
                $data['day'] === 'Mon'
                || $data['day'] === 'Tue'
                || $data['day'] === 'Wed'
                || $data['day'] === 'Thu'
                || $data['day'] === 'Fri'
                || $data['day'] === 'Sat'
                || $data['day'] === 'Sun'
            )) return false;
            return true;
        }

        public function fetchWorkingTime(): ?array
        {
            $data = $this->readImproved([
                'what' => ['*'],
                'where' => [
                    'vendorId' => $this->vendorId
                ]
            ]);

            return $data;
        }

        public function insertVendorTime(): bool
        {
            if (empty($this->vendorId)) return false;

            $this->load->config('custom');
            $dayOfWeeks = $this->config->item('weekDays');
            foreach ($dayOfWeeks as $day) {
                $this->day = $day;
                $this->timeFrom = '00:00:00';
                $this->timeTo = '23:59:59';                
                if (!$this->create()) return false;
            }
            return true;
        }

        public function deleteVenodrTimes(): void
        {
            $query = 'DELETE FROM ' . $this->table . ' WHERE vendorId = ' . $this->vendorId . ';';
            $this->db->query($query);
        }

        public function isOpen(): bool
        {
            $hours = date('H:i:s');
            $result = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    'vendorId = '   => $this->vendorId,
                    'day = '        => date('D'),
                    'timeFrom <= '  => $hours,
                    'timeTo > '     => $hours
                ]
            ]);

            return is_null($result) ? false : true;
        }
    }
