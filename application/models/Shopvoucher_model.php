<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    


    Class Shopvoucher_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $code;
        public $amount;
        public $percent;
        public $percentUsed;
        public $expire;
        public $active;
        public $productId;

        private $table = 'tbl_shop_voucher';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateInteger($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'percent') {
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
            if (isset($data['vendorId']) && isset($data['code']) && (isset($data['amount']) || isset($data['percent']))) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['code']) && !Validate_data_helper::validateString($data['code'])) return false;
            if (isset($data['amount']) && !Validate_data_helper::validateFloat($data['amount'])) return false;
            if (isset($data['percent']) && !Validate_data_helper::validateInteger($data['percent'])) return false;
            if (isset($data['percentUsed']) && !($data['percentUsed'] === '1' || $data['percentUsed'] === '0')) return false;
            if (isset($data['expire']) && !Validate_data_helper::validateDate($data['expire'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            if (isset($data['productId']) && !Validate_data_helper::validateInteger($data['productId'])) return false;

            return true;
        }

        public function setVoucher(): Shopvoucher_model
        {
            if ($this->id) {
                $where[$this->table . '.id'] = $this->id;
            }

            if ($this->code) {
                $where[$this->table . '.code'] = $this->code;
            }

            $voucher = $this->readImproved([
                'what'  => ['*'],
                'where' => $where
            ]);

            if ($voucher) {                
                $voucher = reset($voucher);
                foreach ($voucher as $property => $value) {
                    if ($property === 'id' || $property === 'percent' || $property === 'productId') {
                        $this->{$property} = intval($value);
                    } elseif ($property === 'amount') {
                        $this->{$property} = floatval($value);
                    } else {
                        $this->{$property} = $value;
                    }
                }
            }

            return $this;
        }

        public function payOrderWithVoucher(float $amount, bool $payPartial = false): ?float
        {
            if ($this->percent === 0) {
                $newAmount = $this->amount - $amount;
                // return null if whole order must be paid from voucehr amount and not enough funds on voucher
                if (!$payPartial && $newAmount < 0) return null;
                $returnAmount = ($newAmount > 0) ? $amount  : $this->amount;
                $this->amount = ($newAmount > 0) ? $newAmount  : 0;
            } else {
                // extra check is percnet already used
                if ($this->percentUsed === '1') return null;
                $this->percentUsed = '1';
                $returnAmount = $amount * $this->percent / 100;
                $returnAmount = round($returnAmount, 2);
            }

            return $this->updateVoucher() ? $returnAmount : null;
        }

        private function updateVoucher(): bool
        {
            if ($this->amount == 0 && ($this->percent === 0 || $this->percentUsed === '1')) {
                $this->active = '0';
            }

            if (!$this->productId) {
                $this->productId = null;
            }
            return $this->update();
        }

        public function getOldAmount(): ?float
        {
            return $this->oldAmount;
        }

        
    }
