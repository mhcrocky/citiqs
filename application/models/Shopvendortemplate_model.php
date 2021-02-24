<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

	Class Shopvendortemplate_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
	{

		public $id;
        public $vendorId;
        public $templateName;
        public $templateValue;
        public $active;

        private $table = 'tbl_shop_vendor_templates';
        private $defaultVendorId = 1;

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
            if (isset($data['vendorId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['templateName']) && !Validate_data_helper::validateString($data['templateName'])) return false;
            if (isset($data['templateValue']) && !Validate_data_helper::validateString($data['templateValue'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            return true;
        }

      
        public function getDefaultDesign(): ?array
        {
            $design = $this->readImproved([
                'what' => ['templateValue'],
                'where' => [
                    $this->table . '.vendorId' => $this->defaultVendorId,
                    $this->table . '.active' => '1',
                ]
            ]);

            if (!$design) return null;

            $design = reset($design);
            $design = unserialize($design['templateValue']);

            return $design;
        }

        public function getDefaultDesignData(): ?array
        {
            $design = $this->readImproved([
                'what' => ['*'],
                'where' => [
                    $this->table . '.vendorId' => $this->defaultVendorId,
                    $this->table . '.active' => '1',
                ]
            ]);

            if (!$design) return null;

            $design = reset($design);
            $design['templateValue'] = unserialize($design['templateValue']);

            return $design;
        }

        public function getAllDefaultDesigns(): ?array
        {
            $design = $this->readImproved([
                'what' => ['*'],
                'where' => [
                    $this->table . '.vendorId' => $this->defaultVendorId
                ]
            ]);

            return $design;
        }

        public function getVendorDesigns(): ?array
        {
            $design = $this->readImproved([
                'what' => ['*'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId
                ]
            ]);

            return $design;
        }

        public function getVendorActiveDesign(): ?array
        {
            $design = $this->readImproved([
                'what' => ['*'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId,
                    $this->table . '.active' => '1',
                ]
            ]);

            if (is_null($design)) return null;

            $design = reset($design);
            $design['templateValue'] = unserialize($design['templateValue']);

            return $design;
        }


        public function checkIsNameExists(): bool
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.templateName' => $this->templateName,
            ];

            if ($this->id) {
                $where['id !='] = $this->id;
            }
            $templateName = $this->readImproved([
                'what' => ['id'],
                'where' => $where,
            ]);
            return !is_null($templateName);
        }

        public function isActiveExists(): bool
        {

            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.active' => '1',
            ];

            if ($this->id) {
                $where['id !='] = $this->id;
            }

            $active = $this->readImproved([
                'what' => ['id'],
                'where' => $where
            ]);
            return !is_null($active);
        }

        public function deactivateActive(): bool
        {

            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.active' => '1',
            ];

            if ($this->id) {
                $where['id !='] = $this->id;
            }

            $active = $this->readImproved([
                'what' => ['id'],
                'where' => $where
            ]);

            if (is_null($active)) return true;
            $query = 'UPDATE ' . $this->table . ' SET active = "0" WHERE id = ' . $active[0]['id'] . ';';
            $this->db->query($query);
            return ($this->db->affected_rows() > 0) ? true : false;

        }

        public function getDesign(): array
        {
            $design = $this->readImproved([
                'what' => ['*'],
                'where' => [
                    $this->table . '.id' => $this->id,
                ]
            ]);

            $design = reset($design);


            $design['templateValue'] = unserialize($design['templateValue']);
            return $design;
        }

        public function insertDefaultDesign(): bool
        {
            $templateValue = $this->getDefaultDesign();

            if (is_null($templateValue)) return false;

            $this->templateName = 'default';
            $this->templateValue = $templateValue;
            $this->active = '1';

            return $this->create();
        }
    }
