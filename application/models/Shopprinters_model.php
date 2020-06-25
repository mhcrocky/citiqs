<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopprinters_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $userId;
        public $printer;
        public $macNumber;
        public $active;
        private $table = 'tbl_shop_printers';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'userId') {
                $value = intval($value);
            }
            if ($property === 'price') {
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
            if (isset($data['userId']) && isset($data['printer']) && isset($data['macNumber'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['userId']) && !Validate_data_helper::validateInteger($data['userId'])) return false;
            if (isset($data['printer']) && !Validate_data_helper::validateString($data['printer'])) return false;
            if (isset($data['macNumber']) && !Validate_data_helper::validateString($data['macNumber'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;

            return true;
        }
        public function fetchtProductPrinters(int $productId): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS printerId',
                    $this->table . '.printer AS printer',
                    $this->table . '.active AS printerActive',
                ],
                ['tbl_shop_product_printers.productId=' => $productId],
                [
                    ['tbl_shop_product_printers', $this->table .'.id = tbl_shop_product_printers.printerId' ,'INNER']
                ]
            );
        }

        public function checkPrinterName(array $where): bool
        {
            $filter = [
                'what'  => ['id'],
                'where' => $where,
            ];
            return $this->readImproved($filter) ? true : false;
        }

    }
