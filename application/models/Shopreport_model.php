<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopreport_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $xReport;
        public $zReport;
        public $sendPeriod;
        public $sendTime;
        public $sendDay;
        public $sendDate;
        

        private $table = 'tbl_shop_reports';

        protected function getThisTable(): string
        {
            return $this->table;
        }

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId') {
                $value = intval($value);
            }
            return;
        }

        public function insertValidate(array $data): bool
        {
            if (
                isset($data['vendorId'])
                && (isset($data['xReport']) || isset($data['zReport']))
                && isset($data['sendPeriod'])
                && isset($data['sendTime'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->config('custom');

            if (!count($data)) return false;

            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['xReport']) && !($data['xReport'] === '1' || $data['xReport'] === '0')) return false;
            if (isset($data['zReport']) && !($data['zReport'] === '1' || $data['zReport'] === '0')) return false;
            if (isset($data['sendPeriod']) && !in_array($data['sendPeriod'], $this->config->item('reportPeriods'))) return false;
            if (isset($data['sendTime']) && !Validate_data_helper::validateDate($data['sendTime'])) return false;
            if (isset($data['sendDay']) && !in_array($data['sendDay'], $this->config->item('weekDays'))) return false;
            if (isset($data['sendDate']) && !Validate_data_helper::validateInteger($data['sendDate'])) return false;

            return true;
        }

        public function createReport():bool
        {
            return $this->create();
        }

        public function updateReport():bool
        {
            return ($this->isVendorReport()) ? $this->update() : false;
        }

        private function isVendorReport(): bool
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

        public function getVendorReport(): ?array
        {
            $separator = '|||';
            $report = $this->readImproved([
                'what' => [
                    $this->table . '.*',
                    'GROUP_CONCAT(
                        tbl_shop_reports_emails.email
                        SEPARATOR "'. $separator . '"
                    ) AS reportEmails',
                ],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId
                ],
                'joins' => [
                    ['tbl_shop_reports_emails', 'tbl_shop_reports_emails.reportId = ' . $this->table . '.id', 'LEFT']
                ],
            ]);

            $report = reset($report);
            if (is_null($report['id'])) return null;


            $report['reportEmails'] = ($report['reportEmails']) ? explode($separator, $report['reportEmails']) : null;
            $report['sendDate'] = intval($report['sendDate']);

            return $report;
        }
    }
