<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoppaymentmethods_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $productGroup;
        public $paymentMethod;
        public $vendorCost;
        public $percent;
        public $amount;
        public $active;

        private $table = 'tbl_shop_payment_methods';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId') {
                $value = intval($value);
            }

            if ($property === 'percent' || $property === 'amount') {
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
            if (isset($data['vendorId']) && isset($data['productGroup']) && isset($data['paymentMethod'])) {
                return $this->updateValidate($data);
            }

            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->helper('validate_data_helper');
            $this->load->config('custom');

            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['productGroup']) && !in_array($data['productGroup'], $this->config->item('productGroups'))) return false;
            if (isset($data['paymentMethod']) && !in_array($data['paymentMethod'], $this->config->item('onlinePaymentTypes'))) return false;
            if (isset($data['vendorCost']) && !($data['vendorCost'] === '0' || $data['vendorCost'] === '1')) return false;
            if (isset($data['percent']) && !Validate_data_helper::validateFloat($data['percent'])) return false;
            if (isset($data['amount']) && !Validate_data_helper::validateFloat($data['amount'])) return false;
            if (isset($data['active']) && !($data['active'] === '0' || $data['active'] === '1')) return false;

            return true;
        }



        private function getGroupAndMethods(): array
        {
            return [
                $this->config->item('productGroups'),
                $this->config->item('paymentTypes'),
            ];
        }

        private function getNewProductGroups(int $vendorId, array $configProductGroups): array
        {
            $productGroups = $this->readImproved([
                'what' => ['DISTINCT(productGroup)'],
                'where' => [
                    $this->table . '.vendorId' => $vendorId,
                ]
            ]);

            if (is_null($productGroups)) return $configProductGroups;

            $productGroups = array_map( function($group) {
                return reset($group);
            }, $productGroups);

            return array_diff($configProductGroups, $productGroups);
        }

        private function getNewPaymentMethods(int $vendorId, array $configPaymentMethods, string $productGroup): array
        {
            $paymentMethods = $this->readImproved([
                'what' => ['DISTINCT(paymentMethod)'],
                'where' => [
                    $this->table . '.productGroup' => $productGroup,
                    $this->table . '.vendorId' => $vendorId,
                ]
            ]);

            if (is_null($paymentMethods)) return $configPaymentMethods;

            $paymentMethods = array_map( function($group) {
                return reset($group);
            }, $paymentMethods);

            return array_diff($configPaymentMethods, $paymentMethods);
        }

        public function insertAll(array $vendorIds): bool
        {
            $this->load->config('custom');
            list($configProductGroups, $configPaymentMethods) = $this->getGroupAndMethods();

            if (
                !$this->insertAllGroups($vendorIds, $configProductGroups, $configPaymentMethods)
                || !$this->insertAllMethods($vendorIds, $configProductGroups, $configPaymentMethods)
            ) return false;

            return true;
        }

        private function insertAllGroups(array $vendorIds, array $configProductGroups, array $configPaymentMethods): bool
        {
            // insert all groups
            $insertGroups = [];

            foreach ($vendorIds as $vendor) {
                $vendorId = intval($vendor['vendorId']);
                $newGroups = $this->getNewProductGroups($vendorId, $configProductGroups);
                if ($newGroups) {
                    foreach ($newGroups as $group) {
                        $paymentMethods = $this->getNewPaymentMethods($vendorId, $configPaymentMethods, $group);
                        foreach ($paymentMethods as $method) {
                            $insert = [
                                'vendorId' => $vendorId,
                                'productGroup' => $group,
                                'paymentMethod' => $method,
                                'percent' => $this->config->item('paymentPrice')[$group][$method]['percent'],
                                'amount' => $this->config->item('paymentPrice')[$group][$method]['amount']
                            ];
                            $this->setInsertActive($insert, $method);
                            array_push($insertGroups, $insert);
                        }
                    }
                }
            }

            return $insertGroups ? ($this->multipleCreate($insertGroups) > 0) : true;
        }

        private function insertAllMethods(array $vendorIds, array $configProductGroups, array $configPaymentMethods): bool
        {
            // insert all payment methods
            $insertMethods = [];

            foreach ($vendorIds as $vendorId) {
                $vendorId = intval($vendorId['vendorId']);
                foreach ($configProductGroups as $group) {
                    $newMethods = $this->getNewPaymentMethods($vendorId, $configPaymentMethods, $group);
                    if ($newMethods) {
                        foreach ($newMethods as $method) {
                            $insert = [
                                'vendorId' => $vendorId,
                                'productGroup' => $group,
                                'paymentMethod' => $method,
                                'percent' => $this->config->item('paymentPrice')[$group][$method]['percent'],
                                'amount' => $this->config->item('paymentPrice')[$group][$method]['amount']
                            ];
                            $this->setInsertActive($insert, $method);
                            array_push($insertMethods, $insert);
                        }
                    }
                }
            }

            return $insertMethods ?  ($this->multipleCreate($insertMethods) > 0) : true;
        }

        private function setInsertActive(array &$insert, string $method): void
        {
            $insert['active'] = in_array($method, $this->config->item('cashPaymentTypes')) ? '0' : '1';
        }

        public function getVendorGroupPaymentMethods(): ?array
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.productGroup' => $this->productGroup,
            ];

            if (!is_null($this->active)) {
                $where[$this->table . '.active'] = $this->active;
            }

            return $this->readImproved([
                'what' => [
                    $this->table . '.id',
                    $this->table . '.productGroup',
                    $this->table . '.paymentMethod',
                    $this->table . '.active',
                    $this->table . '.vendorCost',
                    $this->table . '.percent',
                    $this->table . '.amount'
                ],
                'where' => $where
            ]);
        }

        public function updatePaymentMethod(): bool
        {
            if (!$this->checkIsVendorRecord()) return false;

            return $this->update();
        }

        private function checkIsVendorRecord(): bool
        {
            $check = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    $this->table . '.id' => $this->id,
                    $this->table . '.vendorId' => $this->vendorId,
                ]
            ]);

            return !is_null($check);
        }

        /**
         * insertVendorPaymentMethods
         *
         * This method inserts vendor payment methods on account activation.
         * First deletes vendor data from table (if activation process is repeat from some reason).
         *
         * @access public
         * @return boolean
         */
        public function insertVendorPaymentMethods(): bool
        {
            $this->deleteVendorPaymentMethods();
            $insert = [
                'vendorId' => $this->vendorId
            ];
            return $this->insertAll([$insert]);
        }

        public function deleteVendorPaymentMethods(): bool
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId
            ];

            return $this->customDelete($where);
        }
    }
