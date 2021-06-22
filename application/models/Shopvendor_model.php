<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopvendor_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $paynlServiceId;
        public $TpayNlServiceId;
        public $RpayNlServiceId;
        public $merchantId;
        public $accountId;
        public $termsAndConditions;
        public $requireMobile;
        public $printTimeConstraint;
        public $serviceFeeTax;
        public $healthCheck;
        public $requireReservation;
        public $preferredView;
        public $busyTime;
        public $requireRemarks; 
        public $requireNewsletter;
        public $sendEmailReceipt;
        public $showProductsImages;
        public $defaultProductsImage;
        public $requireEmail;
        public $requireName;
        public $showAllergies;
        public $showTermsAndPrivacy;
        public $showMenu;
        public $tipWaiter;
        public $minBusyTime;
        public $maxBusyTime;
        public $receiptOnlyToWaiter;
        public $printOnlyReceipt;
        public $deliveryAirDistance;
        public $cutTime;
        public $skipDate;
        public $activatePos;
        public $nonWorkFrom;
        public $nonWorkTo;
        public $pickupDeliveryWeeks;
        public $pickupDeliveryMinutes;
        public $googleAnalyticsCode;
        public $googleAdwordsConversionId;
        public $googleAdwordsConversionLabel;
        public $googleTagManagerCode;
        public $facebookPixelId;

        public $serviceFeePercent;
        public $serviceFeeAmount;
        public $minimumOrderFee;

        public $deliveryServiceFeePercent;
        public $deliveryServiceFeeAmount;
        public $deliveryMinimumOrderFee;

        public $pickupServiceFeePercent;
        public $pickupServiceFeeAmount;
        public $pickupMinimumOrderFee;

        public $serviceFeePercentPos;
        public $serviceFeeAmountPos;
        public $minimumOrderFeePos;

        public $deliveryServiceFeePercentPos;
        public $deliveryServiceFeeAmountPos;
        public $deliveryMinimumOrderFeePos;

        public $pickupServiceFeePercentPos;
        public $pickupServiceFeeAmountPos;
        public $pickupMinimumOrderFeePos;

        public $bancontact;
        public $ideal;
        public $creditCard;
        public $giro;
        public $prePaid;
        public $postPaid;
        public $payconiq;
        public $vaucher;
        public $myBank;
        public $pinMachine;
        public $emailFinanceReporets;
        public $voucherPaymentCode;
        public $sendAnonymousReceipt;
        private $table = 'tbl_shop_vendors';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            // if (!Validate_data_helper::validateNumber($value)) return;

            if (
                $property === 'id'
                || $property === 'vendorId'
                || $property === 'serviceFeeTax'
                || $property === 'busyTime'
                || $property === 'minBusyTime'
                || $property === 'maxBusyTime'
                || $property === 'deliveryAirDistance'
                || $property === 'pickupDeliveryWeeks'
                || $property === 'pickupDeliveryMinutes'

            ) {
                $value = intval($value);
            }
            if (
                $property === 'serviceFeePercent'
                || $property === 'serviceFeeAmount'
                || $property === 'minimumOrderFee'
            ) {
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
            if (isset($data['vendorId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['requireMobile']) && !($data['requireMobile'] === '1' || $data['requireMobile'] === '0')) return false;
            // if (isset($data['termsAndConditions']) && !Validate_data_helper::validateString($data['termsAndConditions'])) return false;
            if (isset($data['serviceFeePercent']) && !Validate_data_helper::validateString($data['serviceFeePercent'])) return false;
            if (isset($data['serviceFeeAmount']) && !Validate_data_helper::validateFloat($data['serviceFeeAmount'])) return false;
            if (isset($data['paynlServiceId']) && !Validate_data_helper::validateString($data['paynlServiceId'])) return false;
            if (isset($data['TpayNlServiceId']) && !Validate_data_helper::validateString($data['TpayNlServiceId'])) return false;
            if (isset($data['RpayNlServiceId']) && !Validate_data_helper::validateString($data['RpayNlServiceId'])) return false;
            if (isset($data['merchantId']) && !Validate_data_helper::validateString($data['merchantId'])) return false;
            if (isset($data['accountId']) && !Validate_data_helper::validateString($data['accountId'])) return false;
            if (isset($data['bancontact']) && !($data['bancontact'] === '1' || $data['bancontact'] === '0')) return false;
			if (isset($data['payconiq']) && !($data['payconiq'] === '1' || $data['payconiq'] === '0')) return false;
            if (isset($data['ideal']) && !($data['ideal'] === '1' || $data['ideal'] === '0')) return false;
            if (isset($data['creditCard']) && !($data['creditCard'] === '1' || $data['creditCard'] === '0')) return false;
            if (isset($data['printTimeConstraint']) && !Validate_data_helper::validateInteger($data['printTimeConstraint'])) return false;
            if (isset($data['minimumOrderFee']) && !Validate_data_helper::validateFloat($data['minimumOrderFee'])) return false;
            if (isset($data['serviceFeeTax']) && !Validate_data_helper::validateInteger($data['serviceFeeTax'])) return false;
            if (isset($data['giro']) && !($data['giro'] === '1' || $data['giro'] === '0')) return false;
            if (isset($data['healthCheck']) && !($data['healthCheck'] === '1' || $data['healthCheck'] === '0')) return false;
            if (isset($data['requireReservation']) && !($data['requireReservation'] === '1' || $data['requireReservation'] === '0')) return false;            
            if (isset($data['prePaid']) && !Validate_data_helper::validateString($data['prePaid'])) return false;
            if (isset($data['postPaid']) && !Validate_data_helper::validateString($data['postPaid'])) return false;
            if (isset($data['preferredView']) && !Validate_data_helper::validateInteger($data['preferredView'])) return false;
            if (isset($data['busyTime']) && !Validate_data_helper::validateInteger($data['busyTime'])) return false;
            if (isset($data['requireRemarks']) && !($data['requireRemarks'] === '1' || $data['requireRemarks'] === '0')) return false;
            if (isset($data['requireNewsletter']) && !($data['requireNewsletter'] === '1' || $data['requireNewsletter'] === '0')) return false;
            if (isset($data['sendEmailReceipt']) && !($data['sendEmailReceipt'] === '1' || $data['sendEmailReceipt'] === '0')) return false;
            if (isset($data['showProductsImages']) && !($data['showProductsImages'] === '1' || $data['showProductsImages'] === '0')) return false;
            if (isset($data['defaultProductsImage']) && !Validate_data_helper::validateString($data['defaultProductsImage'])) return false;
            if (isset($data['requireEmail']) && !($data['requireEmail'] === '1' || $data['requireEmail'] === '0')) return false;
            if (isset($data['requireName']) && !($data['requireName'] === '1' || $data['requireName'] === '0')) return false;
            if (isset($data['showAllergies']) && !($data['showAllergies'] === '1' || $data['showAllergies'] === '0')) return false;
            if (isset($data['vaucher']) && !($data['vaucher'] === '1' || $data['vaucher'] === '0')) return false;
            if (isset($data['myBank']) && !($data['myBank'] === '1' || $data['myBank'] === '0')) return false;            
            if (isset($data['pinMachine']) && !($data['pinMachine'] === '1' || $data['pinMachine'] === '0')) return false;
            if (isset($data['showTermsAndPrivacy']) && !($data['showTermsAndPrivacy'] === '1' || $data['showTermsAndPrivacy'] === '0')) return false;
            if (isset($data['showMenu']) && !($data['showMenu'] === '1' || $data['showMenu'] === '0')) return false;
            if (isset($data['tipWaiter']) && !($data['tipWaiter'] === '1' || $data['tipWaiter'] === '0')) return false;
            if (isset($data['minBusyTime']) && !Validate_data_helper::validateInteger($data['minBusyTime'])) return false;
            if (isset($data['maxBusyTime']) && !Validate_data_helper::validateInteger($data['maxBusyTime'])) return false;
            if (isset($data['receiptOnlyToWaiter']) && !($data['receiptOnlyToWaiter'] === '1' || $data['receiptOnlyToWaiter'] === '0')) return false;
            if (isset($data['printOnlyReceipt']) && !($data['printOnlyReceipt'] === '1' || $data['printOnlyReceipt'] === '0')) return false;
            if (isset($data['deliveryAirDistance']) && !Validate_data_helper::validateInteger($data['deliveryAirDistance'])) return false;
            if (isset($data['skipDate']) && !($data['skipDate'] === '1' || $data['skipDate'] === '0')) return false;
            if (isset($data['activatePos']) && !($data['activatePos'] === '1' || $data['activatePos'] === '0')) return false;
            if (isset($data['nonWorkFrom']) && !Validate_data_helper::validateDate($data['nonWorkFrom'])) return false;
            if (isset($data['nonWorkTo']) && !Validate_data_helper::validateDate($data['nonWorkTo'])) return false;
            if (isset($data['pickupDeliveryWeeks']) && !Validate_data_helper::validateInteger($data['pickupDeliveryWeeks'])) return false;
            if (isset($data['pickupDeliveryMinutes']) && !Validate_data_helper::validateInteger($data['pickupDeliveryMinutes'])) return false;

            if (isset($data['deliveryServiceFeePercent']) && !Validate_data_helper::validateString($data['deliveryServiceFeePercent'])) return false;
            if (isset($data['deliveryServiceFeeAmount']) && !Validate_data_helper::validateFloat($data['deliveryServiceFeeAmount'])) return false;
            if (isset($data['deliveryMinimumOrderFee']) && !Validate_data_helper::validateFloat($data['deliveryMinimumOrderFee'])) return false;

            if (isset($data['pickupServiceFeePercent']) && !Validate_data_helper::validateString($data['pickupServiceFeePercent'])) return false;
            if (isset($data['pickupServiceFeeAmount']) && !Validate_data_helper::validateFloat($data['pickupServiceFeeAmount'])) return false;
            if (isset($data['pickupMinimumOrderFee']) && !Validate_data_helper::validateFloat($data['pickupMinimumOrderFee'])) return false;


            if (isset($data['serviceFeePercentPos']) && !Validate_data_helper::validateString($data['serviceFeePercentPos'])) return false;
            if (isset($data['serviceFeeAmountPos']) && !Validate_data_helper::validateFloat($data['serviceFeeAmountPos'])) return false;
            if (isset($data['minimumOrderFeePos']) && !Validate_data_helper::validateFloat($data['minimumOrderFeePos'])) return false;

            if (isset($data['deliveryServiceFeePercentPos']) && !Validate_data_helper::validateString($data['deliveryServiceFeePercentPos'])) return false;
            if (isset($data['deliveryServiceFeeAmountPos']) && !Validate_data_helper::validateFloat($data['deliveryServiceFeeAmountPos'])) return false;
            if (isset($data['deliveryMinimumOrderFeePos']) && !Validate_data_helper::validateFloat($data['deliveryMinimumOrderFeePos'])) return false;

            if (isset($data['pickupServiceFeePercentPos']) && !Validate_data_helper::validateString($data['pickupServiceFeePercentPos'])) return false;
            if (isset($data['pickupServiceFeeAmountPos']) && !Validate_data_helper::validateFloat($data['pickupServiceFeeAmountPos'])) return false;
            if (isset($data['pickupMinimumOrderFeePos']) && !Validate_data_helper::validateFloat($data['pickupMinimumOrderFeePos'])) return false;

            if (isset($data['googleAnalyticsCode']) && !Validate_data_helper::validateString($data['googleAnalyticsCode'])) return false;
            if (isset($data['googleAdwordsConversionId']) && !Validate_data_helper::validateString($data['googleAdwordsConversionId'])) return false;
            if (isset($data['googleAdwordsConversionLabel']) && !Validate_data_helper::validateString($data['googleAdwordsConversionLabel'])) return false;
            if (isset($data['googleTagManagerCode']) && !Validate_data_helper::validateString($data['googleTagManagerCode'])) return false;
            if (isset($data['facebookPixelId']) && !Validate_data_helper::validateString($data['facebookPixelId'])) return false;

            if (isset($data['emailFinanceReporets']) && !($data['emailFinanceReporets'] === '1' || $data['emailFinanceReporets'] === '0')) return false;
            if (isset($data['voucherPaymentCode']) && !($data['voucherPaymentCode'] === '1' || $data['voucherPaymentCode'] === '0')) return false;
            if (isset($data['sendAnonymousReceipt']) && !($data['sendAnonymousReceipt'] === '1' || $data['sendAnonymousReceipt'] === '0')) return false;            

            return true;
        }

        public function getVendorData(): ?array
        {
            if (!ctype_digit(strval($this->vendorId))) return null;

            $filter = [
                'what' => [
                    $this->table . '.id',
                    $this->table . '.serviceFeePercent',
                    $this->table . '.serviceFeeAmount',
                    $this->table . '.payNlServiceId',
                    $this->table . '.TpayNlServiceId',
                    $this->table . '.RpayNlServiceId',
                    $this->table . '.termsAndConditions',
                    $this->table . '.requireMobile',
					$this->table . '.bancontact',
					$this->table . '.payconiq',
                    $this->table . '.ideal',
                    $this->table . '.creditCard',
                    $this->table . '.printTimeConstraint',
                    $this->table . '.minimumOrderFee',
                    $this->table . '.serviceFeeTax',
                    $this->table . '.giro',
                    $this->table . '.healthCheck',
                    $this->table . '.requireReservation',
                    $this->table . '.prePaid',
                    $this->table . '.postPaid',
                    $this->table . '.preferredView',
                    $this->table . '.busyTime',
                    $this->table . '.requireRemarks',
                    $this->table . '.requireNewsletter',
                    $this->table . '.sendEmailReceipt',
                    $this->table . '.showProductsImages',
                    $this->table . '.defaultProductsImage',
                    $this->table . '.requireEmail',
                    $this->table . '.requireName',
                    $this->table . '.showAllergies',
                    $this->table . '.myBank',                    
                    $this->table . '.vaucher',
                    $this->table . '.pinMachine',
                    $this->table . '.showTermsAndPrivacy',
                    $this->table . '.showMenu',
                    $this->table . '.tipWaiter',
                    $this->table . '.minBusyTime',
                    $this->table . '.maxBusyTime',
                    $this->table . '.receiptOnlyToWaiter',
                    $this->table . '.printOnlyReceipt',
                    $this->table . '.deliveryAirDistance',
                    $this->table . '.cutTime',
                    $this->table . '.skipDate',
                    $this->table . '.deliveryServiceFeePercent',
                    $this->table . '.deliveryServiceFeeAmount',
                    $this->table . '.deliveryMinimumOrderFee',
                    $this->table . '.pickupServiceFeePercent',
                    $this->table . '.pickupServiceFeeAmount',
                    $this->table . '.pickupMinimumOrderFee',
                    $this->table . '.activatePos',
                    $this->table . '.serviceFeePercentPos',
                    $this->table . '.serviceFeeAmountPos',
                    $this->table . '.minimumOrderFeePos',
                    $this->table . '.deliveryServiceFeePercentPos',
                    $this->table . '.deliveryServiceFeeAmountPos',
                    $this->table . '.deliveryMinimumOrderFeePos',
                    $this->table . '.pickupServiceFeePercentPos',
                    $this->table . '.pickupServiceFeeAmountPos',
                    $this->table . '.pickupMinimumOrderFeePos',
                    $this->table . '.nonWorkFrom',
                    $this->table . '.nonWorkTo',
                    $this->table . '.pickupDeliveryWeeks',
                    $this->table . '.pickupDeliveryMinutes',
                    $this->table . '.googleAnalyticsCode',
                    $this->table . '.googleAdwordsConversionId',
                    $this->table . '.googleAdwordsConversionLabel',
                    $this->table . '.googleTagManagerCode',
                    $this->table . '.facebookPixelId',
                    $this->table . '.emailFinanceReporets',
                    $this->table . '.voucherPaymentCode',
                    $this->table . '.sendAnonymousReceipt',
                    'tbl_user.id AS vendorId',
                    'tbl_user.username AS vendorName',
					'tbl_user.logo AS logo',
                    'tbl_user.email AS vendorEmail',
                    'tbl_user.country AS vendorCountry',
                    'tbl_user.receiptEmail AS receiptEmail',
                    'tbl_user.lat AS vendorLat',
                    'tbl_user.lng AS vendorLon',
                    'tbl_user.oneSignalId AS oneSignalId',
                    'vendorTemplates.templateValue AS design',

                    'GROUP_CONCAT(
                        CONCAT(
                            tbl_shop_vendor_types.id,
                            "|", tbl_shop_vendor_types.active,
                            "|", tbl_shop_spot_types.type,
                            "|", tbl_shop_vendor_types.typeId
                        )                        
                    ) AS typeData'
                ],
                'where' => [
                    $this->table. '.vendorId' => $this->vendorId,
                ],
                'joins' => [
                    ['tbl_user', 'tbl_user.id = ' . $this->table .'.vendorId' , 'INNER'],
                    ['tbl_shop_vendor_types', 'tbl_shop_vendor_types.vendorId = ' . $this->table .'.vendorId' , 'LEFT'],
                    ['tbl_shop_spot_types', 'tbl_shop_spot_types.id = tbl_shop_vendor_types.typeId' , 'LEFT'],
                    [
                        '(
                            SELECT
                                tbl_shop_vendor_templates.vendorId,
                                tbl_shop_vendor_templates.templateValue
                            FROM
                                tbl_shop_vendor_templates
                            WHERE
                                tbl_shop_vendor_templates.active = "1"
                                AND tbl_shop_vendor_templates.vendorId =  ' . $this->vendorId . '
                        ) vendorTemplates', 'vendorTemplates.vendorId = ' . $this->table .'.vendorId' , 'LEFT'
                        ]
                ],
                'conditons' => [
                    'group_by' =>  $this->table .'.vendorId'
                ]
            ];

            $result = $this->readImproved($filter);

            if (is_null($result) || is_null($result[0]['id'])) return null;
            $result = reset($result);

            // FOR OLD USER ... FROM LOST AND FOUND
            // if (is_null($result['id'])) {
            //     $this->create();
            //     return $this->getVendorData();
            // }

            if (is_null($result['typeData'])) {
                $this->insertTypes();
                return $this->getVendorData();
            }

            $result['serviceFeePercent'] = floatval($result['serviceFeePercent']);
            $result['serviceFeeAmount'] = floatval($result['serviceFeeAmount']);
            $result['minimumOrderFee'] = floatval($result['minimumOrderFee']);
            $result['serviceFeeTax'] = intval($result['serviceFeeTax']);
            $result['printTimeConstraint'] = intval($result['printTimeConstraint']);
            $result['vendorId'] = intval($result['vendorId']);
            $result['typeData'] = $this->prepareTypes($result['typeData']);
            $result['vendorLat'] = floatval($result['vendorLat']);
            $result['vendorLon'] = floatval($result['vendorLon']);
            $result['deliveryAirDistance'] = floatval($result['deliveryAirDistance']);
            $result['pickupDeliveryWeeks'] = intval($result['pickupDeliveryWeeks']);
            $result['pickupDeliveryMinutes'] = intval($result['pickupDeliveryMinutes']);

            $result['deliveryServiceFeePercent'] = floatval($result['deliveryServiceFeePercent']);
            $result['deliveryServiceFeeAmount'] = floatval($result['deliveryServiceFeeAmount']);
            $result['deliveryMinimumOrderFee'] = floatval($result['deliveryMinimumOrderFee']);


            $result['pickupServiceFeePercent'] = floatval($result['pickupServiceFeePercent']);
            $result['pickupServiceFeeAmount'] = floatval($result['pickupServiceFeeAmount']);
            $result['pickupMinimumOrderFee'] = floatval($result['pickupMinimumOrderFee']);
            return $result;
        }

        public function getPrintTimeConstraint()
        {
            $printTimeConstraint = $this->shopvendor_model->readImproved([
                'what' => ['printTimeConstraint'],
                'where' => ['vendorId' => $this->vendorId]
            ]);

            if (empty($printTimeConstraint)) return;
            $printTimeConstraint = reset($printTimeConstraint)['printTimeConstraint'];
            return date('Y-m-d H:i:s', strtotime( '-' . $printTimeConstraint . ' hours', time() ));
        }

        public function getPrintTimeConstraintFromMac(string $macNumber)
        {
            $printTimeConstraint = $this->shopvendor_model->readImproved([
                'what' => [$this->table . '.printTimeConstraint printTimeConstraint'],
                'where' => ['tbl_shop_printers.macNumber' => $macNumber],
                'joins' => [
                    ['tbl_shop_printers', 'tbl_shop_printers.userId = ' . $this->table . '.vendorId', 'INNER']
                ]
            ]);

            $printTimeConstraint = reset($printTimeConstraint)['printTimeConstraint'];
            return date('Y-m-d H:i:s', strtotime( '-' . $printTimeConstraint . ' hours', time() ));
        }

        public function getVendors(array $where): ?array
        {

            $filter = [
                'what' => [
                    $this->table . '.id',
                    $this->table . '.serviceFeePercent',
                    $this->table . '.serviceFeeAmount',
                    $this->table . '.payNlServiceId',
                    $this->table . '.termsAndConditions',
                    $this->table . '.requireMobile',
                    $this->table . '.bancontact',
                    $this->table . '.ideal',
                    $this->table . '.creditCard',
                    $this->table . '.myBank',                    
                    $this->table . '.printTimeConstraint',
                    $this->table . '.minimumOrderFee',
                    'tbl_user.id AS vendorId',
                    'tbl_user.username AS vendorName',
					'tbl_user.logo AS logo',
                    'tbl_user.email AS vendorEmail',
                    'tbl_user.active AS active'
                ],
                'where' => $where,
                'joins' => [
                    ['tbl_user', 'tbl_user.id = ' . $this->table .'.vendorId' , 'INNER']
                ],
                'conditions' => [
                    'ORDER_BY' => ['tbl_user.username', 'ASC'],
                ]
            ];

            return $this->readImproved($filter);
        }

        private function prepareTypes(string $types): array
        {
            $return = [];
            $types = explode(',', $types);
            foreach ($types as $type) {
                $type = explode('|', $type);
                array_push($return, [
                    'id' => $type[0],
                    'active' => $type[1],
                    'type' => $type[2],
                    'typeId' => $type[3],
                ]);
            }

            return $return;
        }

        private function insertTypes()
        {
            $this->load->model('shopspottype_model');
            $this->load->model('shopvendortypes_model');
            $types = $this->shopspottype_model->readImproved([
                'what' => ['id'],
                'where' => [
                    'id>' => '0'
                ]
            ]);
            foreach ($types as $type) {
                $active = $type['id'] === '1' ? '1' : '0';
                $insert = [
                    'vendorId' => $this->vendorId,
                    'typeId' => $type['id'],
                    'active' => $active,
                ];
                $this->shopvendortypes_model->setObjectFromArray($insert)->create();
            }
        }

        public function getProperty(string $property): ?string
        {
            if ($this->id) {
                $where = ['id=' => $this->id];
            } elseif ($this->vendorId) {
                $where = ['vendorId=' => $this->vendorId];
            } else {
                return null;
            }

            $result = $this->readImproved([
                'what' => [$property],
                'where' => $where
            ]);

            if (empty($result)) return null;
            return $result[0][$property];
        }

        public function sendEmailWithReceipt(): bool
        {
            $result = $this->readImproved([
                'what'  => ['sendEmailReceipt'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId
                ]
            ]);

            $result = reset($result)['sendEmailReceipt'];

            return $result === '1' ? true : false;
        }

        public function getProperties(array $properties): ?array
        {
            if ($this->id) {
                $where = ['id=' => $this->id];
            } elseif ($this->vendorId) {
                $where = ['vendorId=' => $this->vendorId];
            } else {
                return null;
            }

            $result = $this->readImproved([
                'what' => $properties,
                'where' => $where
            ]);

            if (empty($result)) return null;
            return $result[0];
        }

        public function getVendorAnalytics(): array
        {
            $result =   $this->readImproved([
                            'what' => ['googleAnalyticsCode', 'googleAdwordsConversionId', 'googleAdwordsConversionLabel', 'googleTagManagerCode', 'facebookPixelId'],
                            'where' => [
                                $this->table . '.id' => $this->id,
                            ]
                        ]);
            return reset($result);
        }

        public function isVendorExists(): bool
        {
            $result = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table. '.vendorId' => $this->vendorId
                ]
            ]);
            return !is_null($result);
        }
    }
