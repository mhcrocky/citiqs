<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoporderpaynl_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $orderId;
        public $transactionId;
        public $payNlResponse;
        public $requestSuccess;
        public $exchangePay;
        public $successPayment;

        private $table = 'tbl_shop_orders_paynl';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'orderId') {
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
            if (isset($data['orderId']) && isset($data['transactionId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['orderId']) && !Validate_data_helper::validateInteger($data['orderId'])) return false;
            if (isset($data['transactionId']) && !Validate_data_helper::validateString($data['transactionId'])) return false;
            if (isset($data['payNlResponse']) && !Validate_data_helper::validateString($data['payNlResponse'])) return false;
            if (isset($data['requestSuccess']) && !Validate_data_helper::validateDate($data['requestSuccess'])) return false;
            if (isset($data['exchangePay']) && !Validate_data_helper::validateDate($data['exchangePay'])) return false;
            if (isset($data['successPayment']) && !Validate_data_helper::validateDate($data['successPayment'])) return false;
            
            return true;
        }

        public function setAlfredOrderId(): Shoporderpaynl_model
        {
            $orderId = $this->readImproved([
                'what' => ['orderId'],
                'where' => ['transactionId' => $this->transactionId]
            ]);

            if (!is_null($orderId)) {
                $orderId = reset($orderId);
                $this->orderId = intval($orderId['orderId']);
            }

            return $this;
        }

        public function updatePayNl(array $what): void
        {
            $update = $this
                        ->db
                            ->where('transactionId', $this->transactionId)
                            ->update($this->table, $what);

            if (!$update) {
                $this->load->helper('utility_helper');
                $file = FCPATH . 'application/tiqs_logs/messages.txt';
                $message = 'Record "tbl_shop_orders_paynl.transactionId = ' . $this->transactionId . '" not updated';
                Utility_helper::logMessage($file, $message);
            }
        }
        
        public function getOrderTransactionId(): ?string
        {
            $transactionId = $this->readImproved([
                'what' => [
                    $this->table . '.transactionId'
                ],
                'where' => [
                    $this->table . '.orderId' => $this->orderId
                ]
            ]);

            if (is_null($transactionId)) return null;

            $transactionId = reset($transactionId);

            return $transactionId['transactionId'];
        }
    }
