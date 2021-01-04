<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// config variables for crm api
$config['apiLeadStatus'] = 2;
$config['apiLeadSource'] = 6;

// drop of point values 
$config['dropOfPointTrue'] = 1;
$config['dropOfPointFalse'] = 0;

// TIQS id in tbl_user used when inserting finde item in tbl_label for userId value
$config['tiqsId'] = 1;
// TIQS email
$config['tiqsEmail'] = 'ceo@tiqs.com';
$config['petersEmail'] = MIGRATION_EMAIL;

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

// paynl payment types
$config['idealPaymentType'] = '10';
$config['creditCardPaymentType'] = '706';
$config['bancontactPaymentType'] = '436';
$config['giroPaymentType'] = '694';
$config['payconiqPaymentType'] = '2379';
$config['pinMachinePaymentType'] = '1927';

// time utility
$config['workingDays'] = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
$config['weekDays'] = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
$config['timeFrom'] = '00:00:00';
$config['timeTo'] = '23:59:59';

// LOGO IMAGES FOLDER
$config['uploadLogoFolder']    = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'vendorLogos' . DIRECTORY_SEPARATOR;
$config['defaultProductsImages'] = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'defaultProductsImages' . DIRECTORY_SEPARATOR;
$config['placeImages'] = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'placeImages' . DIRECTORY_SEPARATOR;
$config['backGroundImages']    = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'backGroundImages' . DIRECTORY_SEPARATOR;
//spot types
$config['local'] = 1;
$config['deliveryType'] = 2;
$config['pickupType'] = 3;

$config['typeColors'] = [
    'local' => '#e25f2a',
    'delivery' => '#72b19f',
    'pickup' => '#008ae6',
];

//ALL ALFRED PAYMENT TYPES
//cash payment types
$config['prePaid'] = 'prePaid';
$config['postPaid'] = 'postPaid';

//paynl payment types
$config['idealPayment'] = 'ideal payment';
$config['creditCardPayment'] = 'credit card payment';
$config['bancontactPayment'] = 'bancontact payment';
$config['giroPayment'] = 'giro payment';
$config['payconiqPayment'] = 'payconiq payment';
$config['pinMachinePayment'] = 'pin machine';
$config['voucherPayment'] = 'voucher';

$config['paymentTypes'] = [
    $config['prePaid'],
    $config['postPaid'],
    $config['idealPayment'],
    $config['creditCardPayment'],
    $config['bancontactPayment'],
    $config['giroPayment'],
    $config['payconiqPayment'],
    $config['pinMachinePayment'],
    $config['voucherPayment'],
];

//paynl errorId
$config['paymentTypeErr'] = 'PAY-405';

// PRODUCT IMAGES FOLDER
$config['uploadProductImageFolder']    = FCPATH . 'assets/images/productImages' . DIRECTORY_SEPARATOR;

//make order view
$config['oldMakeOrderView'] = '1';
$config['newMakeOrderView'] = '2';

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

$config['defaultSalesAgentId'] = '1';

$config['payNlSuccess'] = '100';
$config['payNlPending'] = '50';
$config['payNlAuthorised'] = '95';
$config['payNlVerify'] = '85';
$config['payNlCancel'] = '-90';
$config['payNlDenied'] = '-63';

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

$config['_temp'] = '_temp';

$config['z_report'] = 'z_report';
$config['x_report'] = 'x_report';