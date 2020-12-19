<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoppaynlcsv_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $csvFile;
        public $paymentType;
        public $transactionId;
        public $created;
        public $oldId;
        public $amount;
        public $storno;
        public $calculated;

        private $table = 'tbl_shop_paynl_csv';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'oldId') {
                $value = intval($value);
            }

            if ($property === 'amount') {
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
            if (
                isset($data['csvFile'])
                && isset($data['paymentType'])
                && isset($data['transactionId'])
                && isset($data['created'])
                && isset($data['oldId'])
                && isset($data['amount'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['csvFile']) && !Validate_data_helper::validateString($data['csvFile'])) return false;
            if (isset($data['paymentType']) && !Validate_data_helper::validateString($data['paymentType'])) return false;
            if (isset($data['transactionId']) && !Validate_data_helper::validateString($data['transactionId'])) return false;
            if (isset($data['created']) && !Validate_data_helper::validateDate($data['created'])) return false;
            if (isset($data['oldId']) && !Validate_data_helper::validateInteger($data['oldId'])) return false;
            if (isset($data['amount']) && !Validate_data_helper::validateFloat($data['amount'])) return false;
            if (isset($data['storno']) && !($data['storno'] === '1' || $data['storno'] === '0')) return false;
            if (isset($data['calculated']) && !($data['calculated'] === '1' || $data['calculated'] === '0')) return false;

            return true;
        }

        public function updateStorno(): bool
        {
            $query =
                "UPDATE tbl_shop_paynl_csv SET storno = '1' WHERE id IN
                    (
                        SELECT
                            updateTable.id
                        FROM
                            (
                                SELECT
                                    tbl_shop_paynl_csv.id AS id
                                FROM
                                    tbl_shop_paynl_csv, tbl_shop_paynl_csv AS alias
                                WHERE
                                    tbl_shop_paynl_csv.transactionId = alias.transactionId
                                    AND tbl_shop_paynl_csv.amount != alias.amount
                            ) updateTable
                    )";
            return $this->db->query($query);
        }

        public function fetchForCalculation(): ?array
        {
            return $this->readImproved([
                'what' => [
                    $this->table . '.id AS id',
                    $this->table . '.oldId AS oldId',
                    $this->table . '.transactionId AS transactionId',
                    $this->table . '.created AS created',
                    $this->table . '.amount AS amount'
                ],
                'where' => [
                    $this->table . '.calculated = ' => '0',
                    $this->table . '.storno = ' => '0',
                    $this->table . '.csvFile = ' => '01.csv' // TO DO CHANGE FOR NEXT CSV FILE
                ],
                'conditions' => [
                    'ORDER_BY' => [$this->table . '.id ASC']
                ]
            ]);
        }
    }
