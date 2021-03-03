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
        public $buyerCost;
        
        private $table = 'tbl_shop_payment_methods';

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
            if (isset($data['vendorId']) && isset($data['productGroup']) && isset($data['paymentMethod'])) {
                return $this->updateValidate($data);
            }

            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->helper('validate_data_helper');
            $this->load->custom('config');

            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['productGroup']) && !in_array($data['productGroup'], $this->config->item('productGroups'))) return false;
            if (isset($data['paymentMethod']) && !in_array($data['paymentMethod'], $this->config->item('onlinePaymentTypes'))) return false;

            return true;
        }

        public function insertProductGroupsAndPaymentMethods(int $vendorId): bool
        {
            $this->load->config('custom');
            $configProductGroups  = $this->config->item('productGroups');
            $configPaymentMethods  = $this->config->item('onlinePaymentTypes');

            if (
                !$this->insertNewGroups($vendorId, $configProductGroups, $configPaymentMethods)
                || !$this->insertNewMethods($vendorId, $configProductGroups, $configPaymentMethods)
            ) return false;

            return true;
        }

        public function insertNewGroups(int $vendorId, array $configProductGroups, array $configPaymentMethods): bool
        {
            $newGroups = $this->getNewProductGroups($vendorId, $configProductGroups);

            if ($newGroups) {
                foreach ($newGroups as $group) {
                    foreach ($configPaymentMethods as $method) {
                        $insert = [
                            'vendorId' => $vendorId,
                            'productGroup' => $group,
                            'paymentMethod' => $method
                        ];
                        if (!$this->setObjectFromArray($insert)->create()) return false;
                    }
                }
            }

            return true;
        }

        public function getNewProductGroups(int $vendorId, array $configProductGroups): array
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

        public function insertNewMethods(int $vendorId, array $configProductGroups, array $configPaymentMethods): bool
        {

            foreach ($configProductGroups as $group) {
                $newMethods = $this->getNewPaymentMethods($vendorId, $configPaymentMethods, $group);
                if ($newMethods) {
                    foreach ($newMethods as $method) {
                        $insert = [
                            'vendorId' => $vendorId,
                            'productGroup' => $group,
                            'paymentMethod' => $method
                        ];
                        if (!$this->setObjectFromArray($insert)->create()) return false;
                    }
                }
            }

            return true;
        }

        public function getNewPaymentMethods(int $vendorId, array $configPaymentMethods, string $productGroup): array
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
            $configProductGroups  = $this->config->item('productGroups');
            $configPaymentMethods  = $this->config->item('onlinePaymentTypes');

            if (
                !$this->insertAllGroups($vendorIds, $configProductGroups, $configPaymentMethods)
                || !$this->insertAllMethods($vendorIds, $configProductGroups, $configPaymentMethods)
            ) return false;

            return true;
        }

        public function insertAllGroups(array $vendorIds, array $configProductGroups, array $configPaymentMethods): bool
        {
            // insert all groups
            $insertGroups = [];

            foreach ($vendorIds as $vendorId) {
                $vendorId = intval($vendorId['vendorId']);
                $newGroups = $this->getNewProductGroups($vendorId, $configProductGroups);
                if ($newGroups) {
                    foreach ($newGroups as $group) {
                        foreach ($configPaymentMethods as $method) {
                            $insert = [
                                'vendorId' => $vendorId,
                                'productGroup' => $group,
                                'paymentMethod' => $method
                            ];
                            array_push($insertGroups, $insert);
                        }
                    }
                }
            }
            return $insertGroups ? ($this->multipleCreate($insertGroups) > 0) : true;
        }

        public function insertAllMethods(array $vendorIds, array $configProductGroups, array $configPaymentMethods): bool
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
                                'paymentMethod' => $method
                            ];
                            array_push($insertMethods, $insert);
                        }
                    }
                }
            }

            return $insertMethods ?  ($this->multipleCreate($insertMethods) > 0) : true;
        }

        public function getVendorGroupPaymentMethods(): ?array
        {
            return $this->readImproved([
                'what' => [
                    $this->table . '.id',
                    $this->table . '.productGroup',
                    $this->table . '.paymentMethod',
                    $this->table . '.vendorCost',
                    $this->table . '.buyerCost'
                ],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId,
                    $this->table . '.productGroup' => $this->productGroup,
                ]
            ]);
        }
    }
