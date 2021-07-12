<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// config variables for crm api
$config['apiLeadStatus'] = 2;
$config['apiLeadSource'] = 6;

// drop of point values 
$config['dropOfPointTrue'] = 1;
$config['dropOfPointFalse'] = 0;

// TIQS id in tbl_user used when inserting finde item in tbl_label for userId value
$config['tiqsId'] = TIQS_ID;
// TIQS email
$config['tiqsEmail'] = (ENVIRONMENT === 'development') ? 'antevidovic@gmail.com' : 'ceo@tiqs.com';
$config['petersEmail'] = MIGRATION_EMAIL;
$config['dev01'] = 'antevidovic@gmail.com';

// business types ids => Id is id value of business type in tbl_business_types
$config['Airbnb']= '1';
$config['Amusement Park']= '2';
$config['Aviation']= '3';
$config['B&B']= '4';
$config['Bar']= '5';
$config['Camping']= '6';
$config['Car Rental']= '7';
$config['Club']= '8';
$config['Event']= '9';
$config['Event Hall']= '10';
$config['Festival']= '11';
$config['Hotel']= '12';
$config['Mall']= '13';
$config['Movie Theater']= '14';
$config['Municipality']= '15';
$config['Museum']= '16';
$config['Public Transport']= '17';
$config['Restaurant']= '18';
$config['School']= '19';
$config['Sport']= '20';
$config['Store & Market']= '21';
$config['Theater']= '22';
$config['Tour operator'] = '23';
$config['Transport']= '24';
$config['University ']= '25';

// UPLOAD FOLDERS
$config['uploadFolder']    = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;
$config['labelFolder']     = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'LabelImages' . DIRECTORY_SEPARATOR;
$config['labelFolderBig']  = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'LabelImagesBig' . DIRECTORY_SEPARATOR;
$config['dhlXmlRequests']  = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'xmlrequest' . DIRECTORY_SEPARATOR;
$config['floorPlansFolder'] = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'floorPlans';
$config['floorPlansImagesPath'] = 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'floorplan_objects' . DIRECTORY_SEPARATOR;
$config['unlayerUploadFolder']    = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'campaigns';
$config['unlayerRelativeUploadFolder']    = 'uploads' . DIRECTORY_SEPARATOR . 'campaigns/';

// SENSITIVE DATA CATEGORIES ID
$config['creditCard'] = 11;
$config['debitCard'] = 10;
$config['driverLicense'] = 28;
$config['identityCard'] = 27;
$config['passport'] = 8;
$config['sensitiveData'] = 30;

// OTHER CATEGORY ID
$config['otherCategoryId'] = 26;
$config['bagsCategoryId'] = 3;

//DHL TIQS COMMISSION
$config['tiqsCommission'] = 10;

//PAY STATUS
$config['paystatusError'] = 1;
$config['paystatusPayed'] = 2;
$config['paystatusPending'] = 3;

// FREE PACKAGE DATA
$config['freePackageDclw'] = 1;
$config['freePackageDcll'] = 1;
$config['freePackageDclh'] = 1;
$config['freePackageDclwgt'] = 1;

// PACKAGES TYPES
//$config['freePackage'] = 'free';
$config['freePackage'] = 'fly';
$config['basicPackage'] = 'basic';
$config['standardPackageDclh'] = 'standard';
$config['volumePackageDclwgt'] = 'volume';

//  LABEL TYPES IDS

$config['labelLost'] = 1;
$config['labelSend'] = 2;
$config['labelSubscription'] = 3;

// ROLES
$config['administrator'] = '1';
$config['owner'] = '2';
$config['buyer'] = '6';

// ORDER STATUS
$config['orderNotSeen'] = 'not seen';
$config['orderSeen'] = 'seen';
$config['orderInProcess'] = 'in process';
$config['orderDone'] = 'done';
$config['orderFinished'] = 'finished';

$config['orderStatuses'] = [
    $config['orderNotSeen'],
    $config['orderSeen'],
    $config['orderInProcess'],
    $config['orderDone'],
    $config['orderFinished']
];

// ORDED STAUSES
$config['orderConfirmWaiting'] = '0'; // NO ACTION DONE
$config['orderConfirmTrue'] = '1'; // CONFIREMD
$config['orderConfirmFalse'] = '2'; // REJECTED

$config['orderNotPaid'] = '0';
$config['orderPaid'] = '1';

// SEPARATORS
$config['contactGroupSeparator'] = ')$=';
$config['concatSeparator'] = ')#%';
$config['allergiesSeparator'] = '|||';
$config['contactGroupSeparatorNumber'] = '|';
$config['concatSeparatorNumber'] = '#';


// time utility
$config['workingDays'] = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
$config['weekDays'] = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
$config['timeFrom'] = '00:00:00';
$config['timeTo'] = '23:59:59';

//spot types
$config['local'] = 1;
$config['deliveryType'] = 2;
$config['pickupType'] = 3;

$config['localTypeString'] = 'LOCAL';
$config['deliveryTypeString'] = 'DELIVERY';
$config['pickupTypeString'] = 'PICKUP';

$config['serviceTypes'] = [
    $config['localTypeString'] => $config['local'],
    $config['deliveryTypeString'] => $config['deliveryType'],
    $config['pickupTypeString'] => $config['pickupType'],
];

$config['typeColors'] = [
    'local' => '#FBDE8A',
    'delivery' => '#72b19f',
    'pickup' => '#008ae6',
];

//ALL ALFRED PAYMENT TYPES AND PRODUCT GROUPS

//cash payment types
$config['prePaid'] = 'prePaid';
$config['postPaid'] = 'postPaid';

$config['cashPaymentTypes'] = [
    $config['prePaid'],
    $config['postPaid']
];

// PAY NL

//paynl payment types
$config['idealPayment'] = 'ideal payment';
$config['creditCardPayment'] = 'credit card payment';
$config['bancontactPayment'] = 'bancontact payment';
$config['giroPayment'] = 'giro payment';
$config['payconiqPayment'] = 'payconiq payment';
$config['pinMachinePayment'] = 'pin machine';
$config['voucherPayment'] = 'voucher';
$config['myBankPayment'] = 'my bank';

$config['onlinePaymentTypes'] = [
    $config['idealPayment'],
    $config['creditCardPayment'],
    $config['bancontactPayment'],
    $config['giroPayment'],
    $config['payconiqPayment'],
    $config['pinMachinePayment'],
    $config['voucherPayment'],
    $config['myBankPayment'],
];

$config['paymentTypes'] = array_merge($config['cashPaymentTypes'], $config['onlinePaymentTypes']);

$config['storeAndPos'] = 'Store & POS';
$config['reservations'] = 'Reservations';
$config['eTicketing'] = 'E-Ticketing';

$config['productGroups'] = [
    $config['storeAndPos'],
    $config['reservations'],
    $config['eTicketing'],
];

$config['paymentPrice'] = [
    $config['storeAndPos'] => [
        $config['idealPayment'] => [
            'percent' => 0,
            'amount' => 0.25,
        ],
        $config['creditCardPayment'] => [
                'percent' => 2,
                'amount' => 0.35,
            ],
        $config['bancontactPayment'] => [
                'percent' => 0,
                'amount' => 0.25,
            ],
        $config['giroPayment'] => [
                'percent' => 0,
                'amount' => 0.25,
            ],
        $config['payconiqPayment'] => [
                'percent' => 0,
                'amount' => 0.25,
            ],
        $config['pinMachinePayment'] => [
                'percent' => 0,
                'amount' => 0.25,
            ],
        $config['voucherPayment'] => [
                'percent' => 0,
                'amount' => 0,
            ],
        $config['myBankPayment'] => [
                'percent' => 1,
                'amount' => 0.25,
            ],
        $config['prePaid'] => [
                'percent' => 0,
                'amount' => 0.00,
            ],
        $config['postPaid'] => [
                'percent' => 0,
                'amount' => 0.00,
            ]
    ],
    $config['reservations'] => [
        $config['idealPayment'] => [
                'percent' => 0,
                'amount' => 0.50,
            ],
        $config['creditCardPayment'] => [
                'percent' => 2,
                'amount' => 0.35,
            ],
        $config['bancontactPayment'] => [
                'percent' => 0,
                'amount' => 0.50,
            ],
        $config['giroPayment'] => [
                'percent' => 2,
                'amount' => 0.35,
            ],
        $config['payconiqPayment'] => [
                'percent' => 0,
                'amount' => 0.50,
            ],
        $config['pinMachinePayment'] => [
                'percent' => 0,
                'amount' => 0.50,
            ],
        $config['voucherPayment'] => [
                'percent' => 0,
                'amount' => 0,
            ],
        $config['myBankPayment'] => [
                'percent' => 2,
                'amount' => 0.30,
            ],
        $config['prePaid'] => [
                'percent' => 1,
                'amount' => 0.25,
            ],
        $config['postPaid'] => [
                'percent' => 1,
                'amount' => 0.25,
            ]
    ],
    $config['eTicketing'] => [
        $config['idealPayment'] => [
            'percent' => 0,
            'amount' => 0.50,
        ],
        $config['creditCardPayment'] => [
                'percent' => 2,
                'amount' => 0.30,
            ],
        $config['bancontactPayment'] => [
                'percent' => 0,
                'amount' => 0.50,
            ],
        $config['giroPayment'] => [
                'percent' => 2,
                'amount' => 0.30,
            ],
        $config['payconiqPayment'] => [
                'percent' => 0,
                'amount' => 0.50,
            ],
        $config['pinMachinePayment'] => [
                'percent' => 0,
                'amount' => 0.25,
            ],
        $config['voucherPayment'] => [
                'percent' => 0,
                'amount' => 0,
            ],
        $config['myBankPayment'] => [
                'percent' => 2,
                'amount' => 0.30,
            ],
        $config['prePaid'] => [
                'percent' => 1,
                'amount' => 0.25,
            ],
        $config['postPaid'] => [
                'percent' => 1,
                'amount' => 0.25,
            ]
    ],
];

// paynl payment types
$config['idealPaymentType'] = '10';
$config['creditCardPaymentType'] = '706';
$config['bancontactPaymentType'] = '436';
$config['giroPaymentType'] = '694';
$config['payconiqPaymentType'] = '2379';
$config['pinMachinePaymentType'] = '1927';
$config['myBankPaymentType'] = '1588';

$config['pinMachineOptionSubId'] = 'TH-9268-3020';

//paynl errorId
$config['paymentTypeErr'] = 'PAY-405';


// paynl url details

// transaction namespace
$config['transactionNamespace'] = 'Transaction';

// transaction functions and versions
$config['orderPayNlFunction'] = 'start';
$config['orderPayNlVersion'] = 'v13';


$config['getRefundPayNlFunction'] = 'refund';
$config['getRefundPayNlVersion'] = 'v16';

// alliance namespace
$config['allianceNamespace'] = 'Alliance';

// alliance functions and versions
$config['addMerchantPayNlFunction'] = 'addMerchant';
$config['addMerchantPayNlVersion'] = 'v6';

$config['addPayNlServiceFunction'] = 'addService';
$config['addPayNlServiceVersion'] = 'v6';

$config['getMerchantPayNlFunction'] = 'getMerchant';
$config['getMerchantPayNlVersion'] = 'v6';

// document namespace

$config['documentNamespace'] = 'Document';

// alliance functions and versions
$config['addDocumentPayNlFunction'] = 'add';
$config['addDocumentPayNlVersion'] = 'v1';

// language id
$config['englishLngPayNlId'] = '4';

// service category id
$config['payNlServiceCategoryId'] = '25';

// paynl documet statuses
$config['paynlDocumentRequested'] = '1';
$config['paynlDocumentUploaded'] = '2';
$config['paynlDocumentApproved'] = '3';
$config['paynlDocumentRejected'] = '4';
$config['paynlDocumentExpired'] = '5';
$config['paynlDocumentStatusDesc'] = [
    $config['paynlDocumentRequested'] => 'requested',
    $config['paynlDocumentUploaded'] => 'uploaded',
    $config['paynlDocumentApproved'] => 'approved',
    $config['paynlDocumentRejected'] => 'rejected',
    $config['paynlDocumentExpired'] => 'expired',
];

// END PAYNL


//make order view
$config['oldMakeOrderView'] = '1';
$config['newMakeOrderView'] = '2';
$config['view2021'] = '3';

//alergies
$config['allergies'] = [
    'cereal',
    'gluten',
    'milk',
    'eggs',
    'peanuts',
    'nuts',
    'crustaceans',
    'mustard',
    'fish',
    'lupin',
    'sesame',
    'celery',
    'soya',
    'molluscs',
    'sulphur dioxide'
];

$config['notActiveColor'] = '#ff4d4d';

$config['defaultSalesAgentId'] = 1;

$config['payNlSuccess'] = '100';
$config['payNlPending'] = ['20', '25', '50', '90'];
$config['payNlAuthorised'] = '95';
$config['payNlVerify'] = '85';
$config['payNlCancel'] = '-90';
$config['payNlDenied'] = '-63';
// $config['payNlPinCanceled'] = '20';

$config['minMobileLength'] = 6;

$config['orderDataGetKey'] = 'order';

$config['buyershorturl'] = 'tiqs_shop_service';

$config['maxRemarkLength'] = 35;

$config['design'] = 'design';

// POS SESSION KEYS
$config['posCheckoutOrder'] = 'posCheckoutOrder';
$config['posBuyerDetails'] = 'posBuyerDetails';
$config['posPay'] = 'posPay';
$config['posSuccessLink'] = 'posSuccessLink';
$config['posPaymentFailedLink'] = 'posPaymentFailedLink';


$config['employeeIn'] = 'IN';
$config['employeeOut'] = 'UIT';

$config['fodInActive'] = 'temporarily_closed';


$config['taxA'] = 21;
$config['taxB'] = 12;
$config['taxC'] = 6;
$config['taxD'] = 0;

$config['countriesTaxes'] = [
    'NL' => [
        'taxRates' => [21, 9, 0, 0],
        'taxGrades' => ['A', 'B', 'C', 'D'],
    ],
    'BE' => [
        'taxRates' => [21, 12, 6, 0],
        'taxGrades' => ['A', 'B', 'C', 'D'],
    ],
    'ES' => [
        'taxRates' => [21, 10, 4, 0],
        'taxGrades' => ['A', 'B', 'C', 'D'],
    ],
    'IT' => [
        'taxRates' => [22, 10, 5, 4, 0],
        'taxGrades' => ['A', 'B', 'C', 'D', 'E'],
    ],
];

$config['_temp'] = '_temp';

$config['z_report'] = 'z_report';
$config['x_report'] = 'x_report';

$config['reportes'] = FCPATH . 'reportes' . DIRECTORY_SEPARATOR;
$config['posReportes'] = $config['reportes'] . 'pos'  . DIRECTORY_SEPARATOR;
$config['financeReportes'] = $config['reportes'] . 'finance' . DIRECTORY_SEPARATOR ;

$config['main_type'] = 'MAIN PRODUCT';

$config['side_dishes'] = 'sideDishes';
$config['api_category'] = 'API CATEGORY';
$config['api_printer'] = 'API PRINTER';
$config['api_spot_delivery'] = 'API SPOT DELIVERY';
$config['api_spot_pickup'] = 'API SPOT PICKUP';
$config['api_side_dishes_product_type'] = 'API SIDE DISHES';


// MENU OPTION ID
$config['posMenuOptionId'] = 25;

// EMAIL TEMPLATES

$config['sendActivationLink'] = 'Send activation link';
$config['sendResetPasswordLink'] = 'Send reset password link';
$config['emailTemplates'] = [ $config['sendActivationLink'], $config['sendResetPasswordLink'] ];

$config['template_extension'] = 'txt';
$config['unlayerObjectFolder'] = 'unlayer_object';
$config['assetsFolder'] = 'assets' . DIRECTORY_SEPARATOR;
$config['imagesFolder'] = $config['assetsFolder'] . 'images' . DIRECTORY_SEPARATOR;
$config['emailImagesFolder'] = $config['imagesFolder'] . 'email_images' . DIRECTORY_SEPARATOR;
$config['emailTemplatesFolder'] = $config['assetsFolder'] . 'email_templates' . DIRECTORY_SEPARATOR;


// IMAGES FOLDERS
$config['uploadLogoFolder']    = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'vendorLogos' . DIRECTORY_SEPARATOR;
$config['defautProductsImagesRelativePath']   = $config['imagesFolder'] . DIRECTORY_SEPARATOR . 'defaultProductsImages' . DIRECTORY_SEPARATOR;
$config['defaultProductsImages'] = FCPATH . $config['defautProductsImagesRelativePath'];
$config['placeImages'] = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'placeImages' . DIRECTORY_SEPARATOR;
$config['backGroundImages']    = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'backGroundImages' . DIRECTORY_SEPARATOR;

$config['productsImagesRelativePath']   = $config['imagesFolder'] . DIRECTORY_SEPARATOR . 'productImages' . DIRECTORY_SEPARATOR;
$config['uploadProductImageFolder']     = FCPATH . $config['productsImagesRelativePath'];


// initial values
$config['initialDrinkCategory'] = 'Drinks';
$config['initialFoodCategory'] = 'Food';

$config['initialDrinkProduct'] = 'coca cola';
$config['initialFoodProduct'] = 'bread';
$config['initialFoodAddon'] = 'butter';

$config['initialMainType'] = 'Main';
$config['initialAddonType'] = 'Addon';

$config['ambasadorCokkiePrefix'] = 'crmAmbasador';


// category images
$config['categoriesImagesRelPath'] = 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'categories_images' . DIRECTORY_SEPARATOR;
$config['categoriesImagesFullPath'] = FCPATH . $config['categoriesImagesRelPath'];


// landing page templates
$config['successLandingPage'] = 'success';
$config['pendingLandingPage'] = 'pending';
$config['authorisedLandingPage'] = 'authorised';
$config['verifyLandingPage'] = 'verify';
$config['cancelLandingPage'] = 'cancel';
$config['deniedLandingPage'] = 'denied';
$config['pinCanceledLandingPage'] = 'pinCanceled';

$config['landingPages'] = [
    $config['successLandingPage'],
    $config['pendingLandingPage'],
    $config['authorisedLandingPage'],
    $config['verifyLandingPage'],
    $config['cancelLandingPage'],
    $config['deniedLandingPage'],
    $config['pinCanceledLandingPage']
];

$config['urlLanding'] = 'url';
$config['templateLanding'] = 'template';

$config['landingTypes'] = [
    $config['urlLanding'],
    $config['templateLanding']
];

$config['landingPageFolder'] = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'landing_pages' . DIRECTORY_SEPARATOR;
$config['landingTemplateExt'] = 'txt';
$config['landingPageView'] = 'ladnigPages/template';

// report periods
$config['dayPeriod'] = 'day';
$config['weekPeriod'] = 'week';
$config['monthPeriod'] = 'month';

$config['reportPeriods'] = [$config['dayPeriod'],$config['weekPeriod'], $config['monthPeriod']];

$config['messageToBuyerTags'] = ['{orderId}', '{buyerName}'];

$config['testingIds'] = [417, 423, 421, 422, 43533, 46244, 59413, 45960, 45846, 24888 ];

$config['eventImagesFolder'] = 'assets/images/events/';

$config['facebookAppId'] = '236297284755592';
