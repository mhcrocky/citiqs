<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Cronjobs extends REST_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('shopprinterrequest_model');
            $this->load->model('shopreport_model');
            
            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');
            $this->load->helper('queue_helper');
            $this->load->helper('email_helper');

            $this->load->config('custom');
            $this->load->library('language', array('controller' => $this->router->class));
        }

		public function index_delete()
		{
			return;
        }

        public function cleanPrinterRequests_get(): void
        {
            $where = [
                'conected<' => date('Y-m-d H:i:s', strtotime ( '-4 hours' , strtotime(date('Y-m-d H:i:s'))) )
            ];

            $this->shopprinterrequest_model->customDeleteTest($where);
        }

        public function release_queue_get($buyers = '1'): void
        {
        	return;
            // redirect 100 buyers from queue to alfred
            $buyers = intval($buyers);
            var_dump(Queue_helper::releaseQueue($buyers));
        }

        public function smsAlert_get(): void
        {
            $this->shopprinterrequest_model->sendSmsAlert();
        }

        public function sendReportes_get(): void
        {
            $reportsSettings = $this->shopreport_model->fetchReportsForCronJob();

            if (is_null($reportsSettings)) return;

            $concatSeparator = $this->config->item('concatSeparator');
            $date = date('d');
            $numberOfDaysInMonth = date('t');
            $reportesFolder =  $this->config->item('financeReportes');
            $xReport = $this->config->item('x_report');
            $zReport = $this->config->item('z_report');

            foreach ($reportsSettings as $report) {
                $this->setReportEmails($report, $concatSeparator);
                $this->setDateTimeFromTo($report, $numberOfDaysInMonth, $date);
                if ($report['xReport'] === '1' && $this->saveReport(intval($report['vendorId']), $report['form'], $report['to'],  $xReport)) {
                    $xReportFile = $reportesFolder . $report['vendorId'] . '_' . $xReport . '.png';
                    $this->sendEmailWithReport($report['reportEmails'], $xReportFile, $xReport);
                }

                if ($report['zReport'] === '1' && $this->saveReport(intval($report['vendorId']), $report['form'], $report['to'], $zReport)) {
                    $zReportFile = $reportesFolder . $report['vendorId'] . '_' . $zReport . '.png';
                    $this->sendEmailWithReport($report['reportEmails'], $zReportFile, $zReport);
                }
            }

            return;
        }

        private function setReportEmails(array &$report, string $concatSeparator): void
        {
            $report['reportEmails'] = explode($concatSeparator, $report['reportEmails']);
            return;
        }

        private function setDateTimeFromTo(array &$report, string $numberOfDaysInMonth, string $date): void
        {
            $report['to'] = date('Y-m-d ' . $report['sendTime']);

            if ($report['sendPeriod'] === $this->config->item('dayPeriod')) {
                $report['form'] = date('Y-m-d ' . $report['sendTime'], strtotime("-1 day"));
            } elseif ($report['sendPeriod'] === $this->config->item('weekPeriod')) {
                $report['form'] = date('Y-m-d ' . $report['sendTime'], strtotime("-1 week"));
            } elseif ($report['sendPeriod'] === $this->config->item('monthPeriod')) {
                if ($numberOfDaysInMonth === $date) {
                    $report['form'] = date('Y-m-d ' . $report['sendTime'], strtotime("last day of -1 month"));
                } else {
                    $report['form'] = date('Y-m-d ' . $report['sendTime'], strtotime("-1 month"));
                }
            }

            return;
        }

        private function saveReport(int $userId, string $from, string $to, string $report): bool
        {
            $url  = base_url() . 'api/report?';
            $url .= 'vendorid=' . $userId;
            $url .= '&datetimefrom=' . str_replace(' ', 'T', $from);
            $url .= '&datetimeto=' . str_replace(' ', 'T', $to);
            $url .= '&report=' . $report;
            $url .= '&finance=1';

            $reportResponse = json_decode(file_get_contents($url));

            return (!empty($reportResponse && $reportResponse->status === '1' )) ? true : false;
        }

        private function sendEmailWithReport(array $reportEmails, string $reportFile, string $reportType): void
        {
            foreach ($reportEmails as $email) {
                Email_helper::sendEmail($email, $reportType, '', false, $reportFile);
            }

            unlink($reportFile);
            return;
        }

        public function updatePaymentMethod_get(): void
        {
            $csvFolder = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'paynl' . DIRECTORY_SEPARATOR;
            $files = scandir($csvFolder);
            $paymentMethods = [
                'iDEAL',
                'Visa Mastercard',
                'Giropay',
                'Payconiq - Payconiq Nederland',
                'Bancontact'
            ];

            $query = 'UPDATE tbl_bookandpay SET paymentMethod = CASE ';
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;

                $ile = $csvFolder . $file;
                $lines = file($ile, FILE_IGNORE_NEW_LINES);
                $transactionIds = [];

                foreach ($lines as $key => $value) {
                    if ($key === 0) continue;
                    $data = str_getcsv($value, ';');
                    if (!in_array($data[14], $paymentMethods)) continue;
                    $tranhsactionId = '"' . $data[25] . '"';
                    array_push($transactionIds, $tranhsactionId);
                    $query .= ' WHEN TransactionID = "' . $data[25] . '" THEN "' . $this->getPaymentMethods($data[14]) . '" ';
                }
            }

            $query .= ' END ';
            $query .= ' WHERE 1;';
            $this->db->query($query);
            var_dump($this->db->affected_rows());

        }

        private function getPaymentMethods(string $payNlPaymentMethod): string
        {
            $alfredNameMethod = '';
            if ($payNlPaymentMethod === 'iDEAL') {
                $alfredNameMethod = $this->config->item('idealPayment');
            } elseif ($payNlPaymentMethod === 'Giropay') {
                $alfredNameMethod = $this->config->item('giroPayment');
            } elseif ($payNlPaymentMethod === 'Payconiq - Payconiq Nederland') {
                $alfredNameMethod = $this->config->item('payconiqPayment');
            } elseif ($payNlPaymentMethod === 'Bancontact') {
                $alfredNameMethod = $this->config->item('bancontactPayment');
            } else {
                $alfredNameMethod = $this->config->item('creditCardPayment');
            }

            return $alfredNameMethod;
        }

        public function sendLogFile_get(): void
        {
            $yesterday =  date('Y-m-d', strtotime('-1 day'));
            $logFileName = 'log-' . $yesterday . '.php';
            $logFile = FCPATH . 'application/logs/' . $logFileName;

            if (file_exists($logFile)) {
                $subject = 'Log file for ' . $yesterday;
                $emails = [$this->config->item('tiqsEmail'), $this->config->item('dev01')];

                foreach($emails as $email) {
                    Email_helper::sendEmail($email, $subject, '', false, $logFile);
                }
            }

            return;
        }
    }
