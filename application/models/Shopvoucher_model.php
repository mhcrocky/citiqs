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

        private $table = 'tbl_shop_voucher';
        private $update = false;
        private $oldAmount;

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
                    if ($property === 'id' || $property === 'percent') {
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

        public function payOrderWithVoucher(float $amount, bool $payPartial = false): Shopvoucher_model
        {
            if ($this->percent === 100 && $this->percentUsed === '0') {
                $this->update = true;
                $this->percentUsed = '1';
            } else {
                $newAmount = $this->amount - $amount;
                if ($newAmount >= 0) {
                    $this->amount = $newAmount;
                    $this->update = true;
                } else  {
                    if ($payPartial) {
                        if ($this->percent === 0) {
                            $this->oldAmount = $this->amount;
                            $this->amount = 0;
                        } else {
                            $this->percentUsed = '1';
                        }
                        $this->update = true;
                    }
                }
            }
            
            return $this;
        }

        public function updateVoucher(): bool
        {
            if (!$this->update) return false;
            if ($this->amount == 0 && ($this->percent === 0 || $this->percentUsed === '1')) {
                $this->active = '0';
            }

            return $this->update();
        }

        public function getOldAmount(): ?float
        {
            return $this->oldAmount;
        }

        
    }
