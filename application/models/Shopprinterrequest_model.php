<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopprinterrequest_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $printerId;
        public $conected;
        public $orderId;
        public $printerEcho;
        private $table = 'tbl_shop_printer_requests';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'printerId' || $property === 'orderId') {
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

        public function insertPrinterRequest(string $macNumber): bool
        {
            $query  = 'INSERT INTO ' . $this->table . ' (printerId) ';
            $query .= 'SELECT id FROM tbl_shop_printers WHERE macNumber = "' . $macNumber . '";';
            $this->db->query($query);

            $this->id = $this->db->insert_id();
            return  $this->id ? true : false;
        }

        public function insertValidate(array $data): bool
        {
            return true;

        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['printerId']) && !Validate_data_helper::validateInteger($data['printerId'])) return false;
            if (isset($data['conected']) && !Validate_data_helper::validateDate($data['conected'])) return false;
            if (isset($data['orderId']) && !Validate_data_helper::validateInteger($data['orderId'])) return false;
            if (isset($data['printerEcho']) && !Validate_data_helper::validateDate($data['printerEcho'])) return false;
            return true;
        }

        public function checkIsPrinterConnected(): bool
        {
            $connected = $this->readImproved([
                'what'  => ['id'],
                'where' => [
                    $this->table . '.printerId = ' => $this->printerId,
                    $this->table . '.conected >= ' => $this->conected,
                ],
                'LIMIT'=> ['1']
            ]);
            return !is_null($connected);
        }
    }
