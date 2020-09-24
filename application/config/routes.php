<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "start";
$route['404_override'] = 'start'; // here we need to have page sorry we could not find what you are looking for.
$route['translate_uri_dashes'] = FALSE;

/*********** USER DEFINED ROUTES *******************/

$route['emaildesigner/new'] = "emaildesigner/edit";

$route['thuishaven'] = "thuishavensoldout";
$route['places'] = "places";
//$route['thuishaven'] = "thuishavenagenda/index/1";

$route['thuishavensales/(:any)/(:any)'] = "thuishaven/index/$1/$2";
$route['thuishavenagenda/(:num)'] = "thuishavenagenda/index/$1";

$route['resendreservations'] = "resendreservations";
$route['resendreservations/resend'] = "resendreservations/resend";

$route['visitor'] = "createvisitor/index";
$route['cqrcode'] = "check424/cqrcode";
$route['check424email'] = "check424/check424email";
$route['check424/(:any)'] = "check424/index/$1";
$route['questionnaire'] = "check424/questionnaire";

$route['start'] = 'start';
$route['loggedin'] = 'loggedin';
$route['info_spot'] = 'info_spot';
$route['info_business'] = 'info_business';
$route['testscreen'] = 'testscreen';
$route['tags'] = 'info_stickers';
$route['getDHLPrice/(:num)/(:num)'] = 'DHLprice/getDHLPrice/$1/$2';
$route['getDHLPrice/(:num)'] = 'DHLprice/getDHLPrice/$1';
$route['contactform'] = 'contactform';
$route['info_security'] = 'info_security';
$route['newregistererdhotelinfo'] = 'newregisteredhotelinfo';
$route['qrscanner'] = 'qrscanner';
$route['getyourreward'] = 'foundlabelregistered';
$route['whatislostisfound'] = 'whatislostisfound';
$route['itemfound'] = 'home/upload';
$route['itemfound/(:any)/(:any)'] = 'home/upload/$1/$2';
$route['itemregisternew'] = 'home/uploadcheckemail';
$route['itemregisternew/(:any)'] = 'home/uploadcheckemail/$1';
$route['bagit/(:any)/(:any)/(:any)'] = 'bagit/bagitwithcode/$1/$2/$3';
$route['info_green'] = 'info_green';
$route['info_DHL'] = 'info_DHL';
$route['info_hotel'] = 'info_hotel';
$route['info_events'] = 'info_events';
$route['claimcheckout/(:any)'] = "claimcheckout/index/$1";
$route['box'] = 'hotelairbnbinfo';
$route['downloadapp'] = 'downloadapp';
$route['personaltagsinfo'] = 'personaltagsinfo';
$route['hotelairbnbinfo'] = 'hotelairbnbinfo';
$route['festivaleventsinfo'] = 'festivaleventsinfo';
$route['PdfDesigner'] = 'PdfDesigner';
$route['legal'] = 'legal';
$route['pdfdesigner'] = 'pdfdesigner';
$route['Howitworks'] = 'Howitworks';
$route['howitworksbusiness'] = 'howitworksbusiness';
$route['Howitworksconsumer'] = 'howitworksconsumer';
$route['home'] = 'home';
$route['ajax'] = 'ajax/users';
$route['id'] = 'login/id';
$route['dhlxml/(:num)'] = 'DHLlogin/dhllogin/$1';
$route['dhlxmlcron'] = 'DHLlogin/cronJob';
$route['dhlprice'] = 'DHLprice/dhlpricing';
$route['menuapp'] = 'menu/menuapp';
$route['PdfDesigner/download'] = 'error_404';
$route['PdfDesigner/download/(:num)'] = 'PdfDesigner/download/$1';
$route['menuorder'] = 'menu/menuorder';
$route['appointment/(:any)/(:any)'] = "appointment/index/$1/$2";
$route['appointmentSetup'] = "appointment/appointmentSetup";
$route['addNewAppointment'] = "appointment/addNewAppointment";
$route['addNewAppointementSetup'] = "appointment/addNewAppointementSetup";
$route['editOldAppointment/(:num)'] = "appointment/editOldAppointment/$1";
$route['selectAppointment/(:num)/(:any)/(:any)']  = "appointment/selectAppointment/$1/$2/$3";
$route['deleteAppointment'] = "appointment/deleteAppointment";
$route['employeeEdit/(:num)'] = "employee/employeeEdit/$1";
$route['addNewEmployee'] = "employee/addNewEmployee";
$route['addNewEmployeeSetup'] = "employee/addNewEmployeeSetup";
$route['generateEmployeeCode'] = "employee/generateEmployeeCode";
$route['deleteEmployee'] = "employee/deleteEmployee";
$route['emailEmployee'] = "employee/emailEmployee";
$route['location/(:any)']= "labelspublic/locationid/$1";
$route['whatislostisfound'] = 'whatislostisfound';
$route['saveLocation'] = 'Whatislostisfound/saveLocation';
$route['register'] = 'login/register';
$route['registerbusiness'] = 'login/registerbusiness';
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user/index';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['lostandfoundlist'] = 'user/lostandfoundlist';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['lostandfoundlistpublic'] = 'labelspublic/lostandfoundlist';
$route['lostandfoundlistpublic/(:num)'] = 'labelspublic/lostandfoundlist/$1';
$route['userReturnitemslisting'] = 'user/userReturnitemslisting';
$route['lostandfoundlist/(:num)'] = 'user/lostandfoundlist/$1';
$route['userReturnitemslisting/(:num)'] = 'user/userReturnitemslisting/$1';
$route['userLabelImageCreate'] = 'user/userLabelImageCreate';

$route['uploadIdentification'] = 'user/uploadIdentification';
$route['uploadUtilitybill'] = 'user/uploadUtilitybill';
$route['orderListing'] = 'user/orderListing';
$route['orderListing/(:num)'] = "user/orderListing/$1";
$route['addNew'] = "user/addNew";
$route['addNewlabel'] = "user/addNewlabel";
$route['editUserlabel'] = "user/editUserlabel";
$route['qrcode'] = "user/qrcode";
$route['addNewUser'] = "user/addNewUser";
$route['addNewUserlabel'] = "user/addNewUserlabel";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editOldlabel'] = "user/editOldlabel";
$route['editOldlabel/(:num)'] = "user/editOldlabel/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
//$route['profile'] = "user/profilepage";
//$route['profile/(:any)'] = "user/profilepage/$1";
$route['profileUpdate'] = "user/profileUpdate";
$route['profileUpdate/(:any)'] = "user/profileUpdate/$1";
$route['profileDropOffPointSettings'] = "user/profileDropOffPointSettings";
$route['profileDropOffPointSettings/(:any)'] = "user/profileDropOffPointSettings$1";
$route['buddyUpdate'] = "user/buddyUpdate";
$route['buddyUpdate/(:any)'] = "user/buddyUpdate/$1";
$route['setlost/(:num)/(:num)'] = "user/setlost/$1/$2";
$route['setlostreturn/(:num)/(:num)'] = "user/setlostreturn/$1/$2";
$route['check/(:any)'] = "check/index/$1";
$route['checkregister'] = "check/register";
$route['checkfacebook'] = "check/facebook";
$route['checkfbcallback'] = "check/fbcallback";
$route['claim'] = "foundclaim/index/";
$route['claim/(:any)'] = "foundclaim/index/$1";
$route['foundclaim/(:any)'] = "foundclaim/index/$1";
$route['found/(:any)'] = "found/index/$1";
$route['foundregisterclaim'] = "foundclaim/register";
//$route['foundregisterclaim/(:any)'] = "foundclaim/register/index/$1";
$route['foundregister'] = "found/register";
$route['foundfacebook'] = "found/facebook";
$route['foundfbcallback'] = "found/fbcallback";
$route['loginfacebook'] = "login/facebook";
$route['loginfbcallback'] = "login/fbcallback";

$route['thuishaventime/(:num)/(:any)'] = "thuishaventime/index/$1/$2";
$route['thuishaventime/(:num)'] = "thuishaventime/index/$1";
$route['thuishaventime'] = "thuishaventime/index/$1";


$route['pay/(:num)/(:any)'] = "pay/index/$1/$2";
$route['pay/(:num)'] = "pay/index/$1";
$route['pay'] = "pay/index/$1";

$route['pay424/(:num)/(:any)'] = "pay424/index/$1/$2";
$route['pay424/(:num)'] = "pay424/index/$1";
$route['pay424'] = "pay424/index/$1";
$route['paynl/(:num)'] = "pay/paynl/$1";

$route['booking/successpay/(:any)'] = "booking/successPaymentPay/$1";
//$route['booking/exchangepay'] = "booking/ExchangePay";

$route['bookingpay'] = "booking/bookingpay";

$route['pay/successpay'] = "pay/successPaymentPay";
$route['pay424/successpay'] = "pay424/successPaymentPay";
$route['pay/successdeliverydhlpay'] = "pay/successDeliveryDhlPay";
$route['pay/exchangepay'] = "pay/ExchangePay";

$route['pay424/exchangepay'] = "pay424/ExchangePay";
$route['payfacebook'] = "pay/facebook";
$route['payfbcallback'] = "pay/fbcallback";
$route['payregisterandpaysubscription'] = "pay/payregisterandpaysubscription";
$route['payppcallback/(:any)'] = "pay/payppcallback/$1";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['changePassword/(:any)'] = "user/changePassword/$1";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";
$route['PdfDesigner/print/(:any)'] = "PdfDesigner/print/$1";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

$route['switchlang/(:any)'] = "languageswitcher/switchLang/$1";

$route['ticket/(:any)'] = "appointment/print/$1";
$route['userCalimedlisting'] = 'user/userCalimedlisting';
$route['send'] = "send/index/";

// WAREHOUSE
$route['warehouse']             = "warehouse/index";
$route['product_categories']    = "warehouse/productCategories";
$route['products']              = "warehouse/products";
$route['orders']                = "warehouse/orders";
$route['spots']                 = "warehouse/spots";
$route['printers']              = "warehouse/printers";
$route['product_types']         = "warehouse/productTypes";
$route['visitors']              = "warehouse/visitors";
$route['dayreport']           	= "warehouse/dayreport";
$route['vatreport']           	= "warehouse/vatreport";

// PUBLIC
$route['make_order']                = 'publicorders/index';
$route['checkout_order']            = 'publicorders/checkout_order';
$route['pay_order']                 = 'publicorders/pay_order';
$route['closed/(:num)']             = 'publicorders/closed/$1';
$route['spot_closed/(:num)']        = 'publicorders/spotClosed/$1';
$route['insertorder/(:num)/(:any)'] = 'publicorders/insertOrder/$1/$2';
$route['cashPayment/(:num)/(:any)'] = 'publicorders/cashPayment/$1/$2';
$route['voucherPayment/(:num)']     = 'publicorders/voucherPayment/$1';

// API
$route['api/orders/print/get']  = 'Api/Orders/data';
$route['api/orders/print']      = 'Api/Orders/data';
$route['sendDriverSms']         = 'Api/Orders/sms';
$route['updateOrderEx']         = 'Api/Orders/updateTwoToZero';

$route['api/voucher']  = 'Api/Voucher/data';


// ALFRED PAYMENT ENGINE
$route['paymentengine/(:num)/(:any)'] = 'Alfredpayment/paymentEngine/$1/$2';
$route['successPayment'] = 'Alfredpayment/successPayment';
$route['exchangePay'] = 'Alfredpayment/ExchangePay';

$route['success'] = 'Paysuccesslink';
$route['successth'] = 'Paysuccesslinkth';


$route['vendors'] = 'Api/Vendors/data';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
