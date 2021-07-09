<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    Class Shopproducttime_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $productId;
        public $day;
        public $timeFrom;
        public $timeTo;
        private $table = 'tbl_shop_product_times';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'productId') {
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
            if (isset($data['productId']) && isset($data['day']) && isset($data['timeFrom']) && isset($data['timeTo'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['productId']) && !Validate_data_helper::validateInteger($data['productId'])) return false;
            if (isset($data['day']) && !in_array($data['day'], $this->config->item('weekDays'))) return false;

            return true;
        }

        public function deleteProductTimes(): void
        {
            $this->db->delete($this->table, array('productId' => $this->productId));
        }

        public function insertProductTimes(int $productId): bool
        {

            $this->load->config('custom');
            $days = $this->config->item('weekDays');

            $timeFrom = $this->config->item('timeFrom');
            $timeTo = $this->config->item('timeTo');
            foreach ($days as $day) {
                $insert = [
                    'productId' => $productId,
                    'day' => $day,
                    'timeFrom' => $timeFrom,
                    'timeTo' => $timeTo,
                ];
                if (!$this->setObjectFromArray($insert)->create()) return false;
            }
            return true;
        }

        public function resetProductTimes(int $venodrId, string $timeFrom = '', string $timeTo = ''): bool
        {
            if (!$timeFrom && !$timeFrom) return false;
            if ($timeFrom && $timeFrom && strtotime($timeFrom) > strtotime($timeTo)) return false;

            $timeFrom = $this->db->escape($timeFrom);
            $timeTo = $this->db->escape($timeTo);
            $venodrId = $this->db->escape($venodrId);

            if ($timeFrom && $timeTo) {
                $update = 'timeFrom = ' . $timeFrom . ', timeTo = ' . $timeTo;
            } else {
                if ($timeFrom) {
                    $update = 'timeFrom = ' . $timeFrom;
                } else {
                    $update = 'timeTo = ' . $timeTo;
                }
            }


            $query =
                    'UPDATE
                        tbl_shop_product_times
                    SET
                        ' . $update . '
                    WHERE
                        tbl_shop_product_times.id IN
                            (
                                SELECT
                                    productTimesIds.id
                                FROM
                                (
                                    SELECT
                                        tbl_shop_product_times.id
                                    FROM
                                        tbl_shop_product_times
                                    INNER JOIN
                                        tbl_shop_products ON tbl_shop_products.id = tbl_shop_product_times.productId
                                    INNER JOIN
                                        tbl_shop_categories ON tbl_shop_products.categoryId = tbl_shop_categories.id
                                    WHERE tbl_shop_categories.userId = ' . $venodrId . '
                                ) productTimesIds
                        );';

            $this->db->query($query);
            return ($this->db->affected_rows() > 0) ? true : false;
        }
    }
