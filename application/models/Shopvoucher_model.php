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
        public $description;
        public $amount;
        public $percent;
        public $percentUsed;
        public $expire;
        public $active;
        public $numberOfTimes;
        public $activated;
        public $voucherused;
        public $productId;
        public $emailId;
        public $productGroup;
        public $created;
        public $startAmount;

        private $table = 'tbl_shop_voucher';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'percent') {
                $value = intval($value);
            }

            if ($property === 'amount' || $property === 'startAmount') {
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

            $this->load->config('custom');
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return true;
            if (isset($data['code']) && !Validate_data_helper::validateString($data['code'])) return false;
            #if (isset($data['description']) && !Validate_data_helper::validateString($data['description'])) return false;
            if (isset($data['amount']) && !Validate_data_helper::validateFloat($data['amount'])) return false;
            if (isset($data['percent']) && !Validate_data_helper::validateInteger($data['percent'])) return false;
            if (isset($data['percentUsed']) && !($data['percentUsed'] === '1' || $data['percentUsed'] === '0')) return false;
            if (isset($data['expire']) && !Validate_data_helper::validateDate($data['expire'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            if (isset($data['numberOfTimes']) && !Validate_data_helper::validateInteger($data['numberOfTimes'])) return false;
            if (isset($data['activated']) && !Validate_data_helper::validateInteger($data['activated'])) return false;
            if (isset($data['voucherused']) && !Validate_data_helper::validateInteger($data['voucherused'])) return false;
            if (isset($data['productId']) && !Validate_data_helper::validateInteger($data['productId'])) return false;
            if (isset($data['emailId']) && !Validate_data_helper::validateInteger($data['emailId'])) return false;
            if (isset($data['productGroup']) && !in_array($data['productGroup'], $this->config->item('productGroups'))) return false;
            if (isset($data['startAmount']) && !Validate_data_helper::validateFloat($data['startAmount'])) return false;

            return true;
        }

        public function setVoucher(): Shopvoucher_model
        {

            if ($this->code) {
                $where[$this->table . '.code'] = $this->code;
            }

            if ($this->id) {
                $where[$this->table . '.id'] = $this->id;
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

        public function payOrderWithVoucher(float $amount = 0): bool
        {
            if (!$this->checkIsValid()) return false;

            if ($this->percent === 0) {
                $newAmount = $this->amount - $amount;
                // extra check is amount spent
                if ($newAmount < 0) return false;
                $this->amount = $newAmount;
            } else {
                $this->percentUsed = '1';
            }

            return $this->updateVoucher();
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

        public function checkIsValid(): bool
        {
            return  ($this->active === '0' || $this->expire < date('Y-m-d') || $this->percentUsed === '1' || ($this->amount <= 0 && $this->percent === 0)) ? false : true;
        }

        public function getTicketVoucherId(int $ticketId): ?int
        {
            $id = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    'tbl_ticket_options.ticketId' => $ticketId
                ],
                'joins' => [
                    ['tbl_ticket_options', 'tbl_ticket_options.voucherId = ' . $this->table . '.id', 'INNER']
                ],
            ]);

            return is_null($id) ? null : intval($id[0]['id']);
        }

        /**
         * createVoucherFromTemplate
         *
         * Method creates voucher for ticket and reservation
         *
         * @param array $voucherTemplate
         * @param string $voucherBlueprint
         * @access public
         * @return boolean
         */
        public function createVoucherFromTemplate(array $voucherTemplate, string $voucherBlueprint): bool
        {
            $voucherTemplate['code'] = $voucherBlueprint;
            $voucherTemplate['numberOfTimes'] = 1;

            return $this->setObjectFromArray($voucherTemplate)->create();
        }

        public function getVoucher(): ?array
        {
            $voucher = $this->readImproved([
                'what' => [$this->table . '.*'],
                'where' => [
                    $this->table .'.id' => $this->id
                ]
            ]);

            return is_null($voucher) ? null : reset($voucher);
        }

        public function rollBackVoucher(object $orderObject): bool
        {
            $order = $orderObject->setProperty('voucherId', $this->id)->getLastVoucherOrder();

            if (is_null($order) || $order['paid'] === '1') return false;

            $this->active = '1';
            ($this->percent) ? $this->percentUsed = '0' : $this->amount += floatval($order['voucherAmount']);
            ($this->productId) ? intval($this->productId) : $this->productId = null;

            if ($this->update()) {
                $this->logRollback($order);
                return true;
            }

            return false;
        }

        private function logRollback(array $order): void
        {
            $this->load->helper('utility_helper');
            $file = APPPATH . 'tiqs_logs/voucher_rollback.txt';
            $message  = 'Voucher id = "' .  $this->id . '", ';
            $message .= 'refund from order id = "' . $order['id'] . '", ';
            $message .= 'refund amount id = "' . $order['voucherAmount'] . '"';
            Utility_helper::logMessage($file, $message);
        }

        public function getReservationVoucherId(object $data): ?int
        {

            // first check is voucherId connectd to agenda time slot id
            $id = $this->getAgendaTimeslotVoucherId(intval($data->timeslotId));
            if (!is_null($id)) return $id;

            // seconde check is voucherId connectd to agenda spot id
            $id = $this->getAgendaSpotVoucherId(intval($data->SpotId));
            if (!is_null($id)) return $id;

            // seconde check is voucherId connectd to agenda spot id
            $id = $this->getAgendaVoucherId(intval($data->eventid));
            if (!is_null($id)) return $id;

            return null;
        }

        public function getAgendaTimeslotVoucherId(int $timeSlotId): ?int
        {
            $id = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    'tbl_bookandpaytimeslots.id' => intval($timeSlotId)
                ],
                'joins' => [
                    ['tbl_bookandpaytimeslots', 'tbl_bookandpaytimeslots.voucherId = ' . $this->table . '.id', 'INNER']
                ],
            ]);

            return is_null($id) ? null : intval($id[0]['id']);
        }

        public function getAgendaSpotVoucherId(int $spotId): ?int
        {
            $id = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    'tbl_bookandpayspot.id' => intval($spotId)
                ],
                'joins' => [
                    ['tbl_bookandpayspot', 'tbl_bookandpayspot.voucherId = ' . $this->table . '.id', 'INNER']
                ],
            ]);

            return is_null($id) ? null : intval($id[0]['id']);
        }

        public function getAgendaVoucherId(int $agendaId): ?int
        {
            $id = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    'tbl_bookandpayagenda.id' => intval($agendaId)
                ],
                'joins' => [
                    ['tbl_bookandpayagenda', 'tbl_bookandpayagenda.voucherId = ' . $this->table . '.id', 'INNER']
                ],
            ]);

            return is_null($id) ? null : intval($id[0]['id']);
        }

        public function createReservationVoucher(object $bookandpay, string $value, string $serachKey = 'TransactionID'): bool
        {
            $data = $bookandpay->getReservationDataByKey($serachKey, $value, ['eventid', 'SpotId', 'timeslotId', 'voucher']);

            if (is_null($data)) return false;

            foreach($data as $info) {
                if (empty($info->voucher)) continue;

                $voucherId = $this->getReservationVoucherId($info);
                if (is_null($voucherId)) continue;

                $voucherBlueprint = $this->setObjectId($voucherId)->getVoucher();
                if (is_null($voucherBlueprint)) continue;

                if (!$this->createVoucherFromTemplate($voucherBlueprint, $info->voucher)) return false;
            }

            return true;
        }
    }
