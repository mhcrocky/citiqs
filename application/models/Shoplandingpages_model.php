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
        public $productGroup;
        public $landingPage;
        public $name;
        public $value;
        public $landingType;
        public $active;

        private $table = 'tbl_landing_pages';

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
            if (
                isset($data['vendorId'])
                && isset($data['productGroup'])
                && isset($data['landingPage'])
                && isset($data['name'])
                && isset($data['value'])
                && isset($data['landingType'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->config('custom');

            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return true;
            if (isset($data['productGroup']) && !in_array($data['productGroup'], $this->config->item('productGroups'))) return false;
            if (isset($data['landingPage']) && !in_array($data['landingPage'], $this->config->item('landingPages'))) return false;
            if (isset($data['name']) && !Validate_data_helper::validateString($data['name'])) return true;
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
                    $this->table . '.productGroup' => $this->productGroup,
                ]
            ]);

            return is_null($data) ? null : reset($data);
        }

        public function manageLandingPage(): bool
        {
            // method updateActiveStatus update object and deactivate other ladning pages in product group ...
            // ... object active status is 1
            return ($this->id) ? $this->updateActiveStatus() : $this->create();
        }

        public function checkIsNameFreeToUse(): bool
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.productGroup' => $this->productGroup,
                $this->table . '.name' => $this->name,
            ];

            if ($this->id) {
                $where[$this->table . '.id!='] = $this->id;
            }

            $check = $this->readImproved([
                'what' => [$this->table . '.name'],
                'where' => $where

            ]);

            return is_null($check);
        }

        public function getVendorLandingPages(): ?array
        {
            return $this->readImproved([
                'what' => [$this->table . '.*'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId,
                ]
            ]);
        }

        public function deactivateGroupLandingPages(): bool
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.productGroup' => $this->productGroup,
                $this->table . '.landingPage' => $this->landingPage,
                $this->table . '.id != ' => $this->id
            ];

            return $this->setProperty('active', '0')->customUpdate($where);
        }

        public function isVenodrPage(): bool
        {
            $check = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId,
                    $this->table . '.id' => $this->id,
                ]
            ]);

            return !is_null($check);
        }

        public function updateActiveStatus(): bool
        {
            $update = $this->update();

            // deactivate other templates in product group
            if ($this->active === '1') {
                $this->deactivateGroupLandingPages();
            }

            return $update;
        }
    }
