<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    


    Class Shoplandingpages_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $landingPage;
        public $value;
        public $landingType;
        public $active;

        private $table = 'tbl_shop_landing_pages';

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
            if (isset($data['vendorId']) && isset($data['landingPage']) && (isset($data['value']) || isset($data['landingType']))) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->config('custom');

            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return true;
            if (isset($data['landingPage']) && !in_array($data['landingPage'], $this->config->item('landingPages'))) return false;
            if (isset($data['value']) && !Validate_data_helper::validateString($data['value'])) return false;
            if (isset($data['landingType']) && !in_array($data['landingType'], $this->config->item('landingTypes'))) return false;
            if (isset($data['active']) && !($data['active'] === '0' || $data['active'] === '1')) return false;

            return true;
        }

        public function getLandingPage(): ?array
        {
            $data = $this->readImproved([
                'what' => [$this->table . '.value', $this->table . '.landingType'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId,
                    $this->table . '.landingPage' => $this->landingPage,
                    $this->table . '.active' => '1',
                ]
            ]);

            return is_null($data) ? null : reset($data);
        }
    }
