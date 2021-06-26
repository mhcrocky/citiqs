<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Customeremailsent_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $emailId;
        public $emailSent;
        public $campaignId;

        private $table = 'tbl_customer_emails_sent';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'emailId' || $property === 'campaignId') {
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
            if (isset($data['emailId']) && isset($data['emailSent'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;

            if (isset($data['emailId']) && !Validate_data_helper::validateInteger($data['emailId'])) return false;
            if (isset($data['campaignId']) && !Validate_data_helper::validateInteger($data['campaignId'])) return false;
            if (isset($data['emailSent']) && !($data['emailSent'] === '1' || $data['emailSent'] === '0')) return false;

            return true;
        }

        public function getCampaign(int $vendorId, int $campaignId): ?array
        {
            return $this->readImproved([
                'what' => [
                    $this->table . '.id AS sentEmailId',
                    $this->table . '.emailSent AS emailSent',
                    $this->table . '.campaign AS emailCampaign',
                    'tbl_customer_emails.id AS emailId',
                    'tbl_customer_emails.email AS customerEmail',
                ],
                'where' => [
                    $this->table . '.campaignId' => $campaignId,
                    'tbl_customer_emails.vendorId' => $vendorId,
                ],
                'joins' => [
                    ['tbl_customer_emails', 'tbl_customer_emails.id = ' . $this->table . '.emailId', 'INNER']
                ]
            ]);
        }

        
        /**
         * sendEmails
         *
         * Method sends an email to email from emails array.
         *
         * @param array     $emails         emails fetched from tbl_customer_emails
         * @param integer   $break          pause mailing process after $break mails sent
         * @param string    $helper         name of helper that will be loaded
         * @param string    $callback       callback method for sending email
         * @param array     $arguments      argument that are passed to callback method
         * @return void
         */
        public function sendEmails(array $emails, int $break, string $helper, string $callback, array $arguments): void
        {
            $this->load->helper(strtolower($helper));

            $sent = 0;

            while ($emails) {
                $data = array_pop($emails);
                $sendArguments = [];

                // set arguments for passing them to callback method
                $sendArguments = $this->getArgumentsForSendingEmail($arguments, $data['email']);

                if (!empty(call_user_func_array([ucfirst($helper), $callback], $sendArguments))) {
                    $sent++;
                    $insertSent = $this->getInsertData(intval($data['id']), '1');
                    if ($sent % $break === 0) sleep(10);
                } else {
                    $insertSent = $this->getInsertData(intval($data['id']), '0');
                }

                $this->setObjectFromArray($insertSent)->create();
            }
        }

        private function getInsertData(int $emailId, string $emailSent): array
        {
            $insertSent = [
                'emailId' => $emailId,
                'emailSent' => $emailSent,
            ];

            if (!is_null($this->campaignId)) {
                $insertSent['campaignId'] = $this->campaignId;
            }

            return $insertSent;
        }

        /**
         * getArgumentsForSendingEmail
         * 
         * Method populates arguments array with customer email and campaign id if it exists.
         *
         * @see https://www.php.net/manual/en/function.array-unshift.php
         * @param array $arguments
         * @param string $email
         * @return array
         */
        private function getArgumentsForSendingEmail(array $arguments, string $email): array
        {
            // customer email goes to first place in array
            // that is why the email must be first argument in method that will be called in later process
            array_unshift($arguments, $email);

            // ... but if it is set $this->campaignId object property, it will be on first place and email on seconde
            // campaign id will be used for fetching campaign template (every campaign has template id)
            if (!is_null($this->campaignId)) {
                array_unshift($arguments, $this->campaignId);
            }

            return $arguments;
        }

        /**
         * sendCampaignEmails
         *
         * Method sends campaign emails
         * $this->campaignId MUST be set. See $this->setProperty($key, $value), it is defined in application/abstract/AbstractSet_model.php 
         *
         * @param integer   $break          pause mailing process after $break mails sent
         * @param string    $helper         name of helper that will be loaded
         * @param string    $callback       callback method for sending email
         * @param array     $arguments      arguments that are passed to callback method
         *
         * @see Customeremailsent_model::sendEmails
         * @see Customeremailsent_model::getCampaignEmails
         * @see Campaignlist_model::getCampaignLists
         * @see AbstractSet_model::setProperty
         * @return void
         */
        public function sendCampaignEmails(int $break, string $helper, string $callback, array $arguments): void
        {
            $this->load->model('campaignlist_model');
            $this->load->model('emaillist_model');

            $lists = $this->campaignlist_model->setProperty('campaignId', $this->campaignId)->getCampaignLists(['tbl_lists.active' => '1']);
            $emails = is_null($lists) ? null : $this->getCampaignEmails($lists);

            if ($emails) $this->sendEmails($emails, $break, $helper, $callback, $arguments);
            return;
        }

        private function getCampaignEmails(array $lists): ?array
        {
            $emails = [];
            foreach ($lists as $list) {
                $listEmails =   $this
                                    ->emaillist_model
                                        ->setProperty('listId', intval($list['listId']))
                                        ->getActiveListEmails([
                                            'tbl_customer_emails.id as id',
                                            'tbl_customer_emails.email as email'
                                        ]);
                if ($listEmails) {
                    $emails = array_map(function($element) {
                        return $element;
                    }, $listEmails);
                }
            }

            return is_null($emails) ? null : $emails;
        }

    }
