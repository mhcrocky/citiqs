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

//ROLES
$config['owner'] = '2';
$config['buyer'] = '4';
