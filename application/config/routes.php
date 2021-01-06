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
$route['places'] = "places/index";
$route['places/(:any)'] = "places/index/$1";
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
$route['viewdesign']            = "warehouse/viewdesign";
$route['productsorder']         = "warehouse/productsOrder";
$route['updateproductorderno']  = "warehouse/updateProductOrderNo";
$route['getproducts']           = "warehouse/getProducts";

// PUBLIC
$route['make_order']                = 'publicorders/index';
$route['checkout_order']            = 'publicorders/checkout_order';
$route['buyer_details']             = 'publicorders/buyer_details';
$route['pay_order']                 = 'publicorders/pay_order';
$route['closed/(:num)']             = 'publicorders/closed/$1';
$route['spot_closed/(:num)']        = 'publicorders/spotClosed/$1';
$route['temporarily_closed/(:num)/(:num)'] = 'publicorders/temporarilyClosed/$1/$2';

// POS
$route['pos']       = 'pos/index';
$route['pos_login']       = 'pos/posLogin';

//INSERT ORDER
$route['onlinepayment/(:num)/(:any)'] = 'alfredinsertorder/onlinePayment/$1/$2';
$route['cashPayment/(:num)/(:any)'] = 'alfredinsertorder/cashPayment/$1/$2';
$route['voucherPayment']     = 'alfredinsertorder/voucherPayment';

// API
$route['api/orders/print/get']  = 'Api/Orders/data';
$route['api/orders/print']      = 'Api/Orders/data';
$route['sendDriverSms']         = 'Api/Orders/sms';
$route['updateOrderEx']         = 'Api/Orders/updateTwoToZero';

$route['api/voucher']  = 'Api/Voucher/data';

$route['api/onesignal/data']  = 'Api/OneSignal/data';

$route['api/clean_printer_requests']  = 'Api/Cronjobs/cleanPrinterRequests';
$route['api/report']  = 'Api/Reports/report';

// ALFRED PAYMENT ENGINE
$route['paymentengine/(:num)/(:any)/(:num)'] = 'Alfredpayment/paymentEngine/$1/$2/$3';
$route['successPayment'] = 'Alfredpayment/successPayment';
$route['exchangePay'] = 'Alfredpayment/ExchangePay';

$route['success'] = 'Paysuccesslink';
$route['successth'] = 'Paysuccesslinkth';
$route['success_reservation'] = 'Reservations/success';

$route['pending']       = 'paysuccesslink/pending';
$route['authorised']    = 'paysuccesslink/authorised';
$route['verify']        = 'paysuccesslink/verify';
$route['cancel']        = 'paysuccesslink/cancel';
$route['denied']        = 'paysuccesslink/denied';

$route['vendors'] = 'Api/Vendors/data';

$route['order/lines'] = 'Orderlines/index';
$route['visma/export/(:num)'] = 'Api/Visma/export_single_invoice/$1';
$route['visma'] = 'Api/Visma/index';
$route['visma/login'] = 'Api/Visma/login';
$route['visma/config'] = 'Accounting/VismaSetting/index';
$route['config_visma/app_settings'] = 'Accounting/VismaSetting/app_setting';

$route['setting/visma/vat'] = 'Accounting/VismaAccountSetting/vat_rates';
$route['setting/visma/vat/(:num)'] = 'Accounting/VismaAccountSetting/vat_rates_edit/$1';
$route['setting/visma_vatrate/save'] = 'Accounting/VismaAccountSetting/save_visma_vat';
$route['setting/visma_vatrate/update'] = 'Accounting/VismaAccountSetting/update_visma_vat';
$route['setting/visma/vat_delete/(:num)'] = 'Accounting/VismaAccountSetting/delete_visma_vat/$1';

$route['setting/visma/debitors'] = 'Accounting/VismaAccountSetting/debitors';
$route['setting/visma/debitors/(:num)'] = 'Accounting/VismaAccountSetting/debitors_edit/$1';
$route['setting/visma_debitor/save'] = 'Accounting/VismaAccountSetting/save_debitor';
$route['setting/visma_debitor/update'] = 'Accounting/VismaAccountSetting/update_debitor';
$route['setting/visma/debit_delete/(:num)'] = 'Accounting/VismaAccountSetting/delete_debitor/$1';


$route['setting/visma/creditors'] = 'Accounting/VismaAccountSetting/creditors';
$route['setting/visma/creditors/(:num)'] = 'Accounting/VismaAccountSetting/creditors_edit/$1';
$route['setting/visma_credit/save'] = 'Accounting/VismaAccountSetting/save_credit';
$route['setting/visma_credit/update'] = 'Accounting/VismaAccountSetting/update_credit';
$route['setting/visma/credit_delete/(:num)'] = 'Accounting/VismaAccountSetting/delete_credit/$1';

$route['marketing/selection'] = 'Marketing/Selection';
$route['marketing/selection/allbuyers'] = 'Marketing/Selection/allbuyers';
$route['marketing/selection/sendmessage'] = 'Marketing/Selection/sendMessage';

$route['marketing/calculator'] = 'Marketing/Calculator';
$route['marketing/calculator/savecalc'] = 'Marketing/Calculator/saveCalc';
$route['marketing/targeting'] = 'Marketing/Targeting';
$route['marketing/targeting/get_report'] = 'Marketing/Targeting/get_report';
$route['marketing/targeting/save_result'] = 'Marketing/Targeting/save_result';
$route['marketing/targeting/save_query'] = 'Marketing/Targeting/save_query';
$route['marketing/targeting/edit_query'] = 'Marketing/Targeting/edit_query';
$route['marketing/targeting/delete_query'] = 'Marketing/Targeting/delete_query';

$route['api/video/upload_post'] = 'Api/Video/upload_post';

$route['dashboard'] = 'Businessreport/index';
$route['businessreport/get_report'] = 'Businessreport/get_report';
$route['businessreport/get_timestamp_totals'] = 'Businessreport/get_timestamp_totals';
$route['businessreport/get_timestamp_orders'] = 'Businessreport/get_timestamp_orders';
$route['businessreport/sortedWidgets'] = 'Businessreport/sortedWidgets';
$route['businessreport/sortWidgets'] = 'Businessreport/sortWidgets';
$route['businessreport/get_graphs'] = 'Businessreport/get_graphs';
$route['businessreport/graphs'] = 'Businessreport/graphs';
$route['businessreports'] = 'Businessreport/reports';

$route['accounting/report'] = 'AccountingReports/index';
$route['accountingreport/get_report'] = 'AccountingReports/get_report';
$route['accountingreport/get_timestamp_totals'] = 'AccountingReports/get_timestamp_totals';
$route['accountingreport/sortedWidgets'] = 'AccountingReports/sortedWidgets';
$route['accountingreport/sortWidgets'] = 'AccountingReports/sortWidgets';


$route['accounting2/report'] = 'AccountingReports2/index';
$route['accountingreport2/get_report'] = 'AccountingReports2/get_report';
$route['accountingreport2/get_timestamp_totals'] = 'AccountingReports2/get_timestamp_totals';
$route['accountingreport2/sortedWidgets'] = 'AccountingReports2/sortedWidgets';
$route['accountingreport2/sortWidgets'] = 'AccountingReports2/sortWidgets';



$route['visma/export/(:num)'] = 'Api/Visma/export_single_invoice/$1';
$route['visma'] = 'Api/Visma/index';
$route['visma/login'] = 'Api/Visma/login';
$route['visma/config'] = 'Accounting/VismaSetting/index';
$route['config_visma/app_settings'] = 'Accounting/VismaSetting/app_setting';

$route['setting/visma/vat'] = 'Accounting/VismaAccountSetting/vat_rates';
$route['setting/visma/vat/(:num)'] = 'Accounting/VismaAccountSetting/vat_rates_edit/$1';
$route['setting/visma_vatrate/save'] = 'Accounting/VismaAccountSetting/save_visma_vat';
$route['setting/visma_vatrate/update'] = 'Accounting/VismaAccountSetting/update_visma_vat';
$route['setting/visma/vat_delete/(:num)'] = 'Accounting/VismaAccountSetting/delete_visma_vat/$1';

$route['setting/visma/debitors'] = 'Accounting/VismaAccountSetting/debitors';
$route['setting/visma/debitors/(:num)'] = 'Accounting/VismaAccountSetting/debitors_edit/$1';
$route['setting/visma_debitor/save'] = 'Accounting/VismaAccountSetting/save_debitor';
$route['setting/visma_debitor/update'] = 'Accounting/VismaAccountSetting/update_debitor';
$route['setting/visma/debit_delete/(:num)'] = 'Accounting/VismaAccountSetting/delete_debitor/$1';


$route['setting/visma/creditors'] = 'Accounting/VismaAccountSetting/creditors';
$route['setting/visma/creditors/(:num)'] = 'Accounting/VismaAccountSetting/creditors_edit/$1';
$route['setting/visma_credit/save'] = 'Accounting/VismaAccountSetting/save_credit';
$route['setting/visma_credit/update'] = 'Accounting/VismaAccountSetting/update_credit';
$route['setting/visma/credit_delete/(:num)'] = 'Accounting/VismaAccountSetting/delete_credit/$1';

$route['setting/visma/service'] = 'Accounting/VismaAccountSetting/service';
$route['setting/visma/service/(:num)'] = 'Accounting/VismaAccountSetting/service_edit/$1';
$route['setting/visma_service/save'] = 'Accounting/VismaAccountSetting/save_service';
$route['setting/visma_service/update'] = 'Accounting/VismaAccountSetting/update_service';
$route['setting/visma/service_delete/(:num)'] = 'Accounting/VismaAccountSetting/delete_service/$1';

// Exact
$route['exact'] = 'Api/Exact/index';
$route['exact/config'] = 'Accounting/ExactSetting/index';
$route['config_exact/app_settings'] = 'Accounting/ExactSetting/app_setting';



$route['setting/exact/vat'] = 'Accounting/ExactAccountSetting/vat_rates';
$route['setting/exact/vat/(:num)'] = 'Accounting/ExactAccountSetting/vat_rates_edit/$1';
$route['setting/exact_vatrate/save'] = 'Accounting/ExactAccountSetting/save_vat';
$route['setting/exact_vatrate/update'] = 'Accounting/ExactAccountSetting/update_vat';
$route['setting/exact/vat_delete/(:num)'] = 'Accounting/ExactAccountSetting/delete_vat/$1';

$route['setting/exact/debitors'] = 'Accounting/ExactAccountSetting/debitors';
$route['setting/exact/debitors/(:num)'] = 'Accounting/ExactAccountSetting/debitors_edit/$1';
$route['setting/exact_debitor/save'] = 'Accounting/ExactAccountSetting/save_debitor';
$route['setting/exact_debitor/update'] = 'Accounting/ExactAccountSetting/update_debitor';
$route['setting/exact/debit_delete/(:num)'] = 'Accounting/ExactAccountSetting/delete_debitor/$1';


$route['setting/exact/creditors'] = 'Accounting/ExactAccountSetting/creditors';
$route['setting/exact/creditors/(:num)'] = 'Accounting/ExactAccountSetting/creditors_edit/$1';
$route['setting/exact_credit/save'] = 'Accounting/ExactAccountSetting/save_credit';
$route['setting/exact_credit/update'] = 'Accounting/ExactAccountSetting/update_credit';
$route['setting/exact/credit_delete/(:num)'] = 'Accounting/ExactAccountSetting/delete_credit/$1';

$route['booking_agenda/reserved'] = "Booking_agenda/reserved";
$route['booking_agenda/payment_proceed'] = "Booking_agenda/payment_proceed";
$route['booking_agenda/select_payment_type'] = "Booking_agenda/select_payment_type";
$route['booking_agenda/pay'] = "Booking_agenda/pay";
$route['booking_agenda/delete_reservation/(:num)'] = "Booking_agenda/delete_reservation/$1";
$route['booking_agenda/get_agenda/(:any)'] = "Booking_agenda/get_agenda/$1";
$route['booking_agenda/get_agenda/spots/(:num)/(:num)'] = "Booking_agenda/get_agenda/spots/$1/$1";
$route['booking_agenda/getAllAgenda/(:any)'] = "Booking_agenda/getAllAgenda/$1";
$route['booking_agenda/(:any)'] = "Booking_agenda/index/$1";
$route['booking/successbooking'] = "Booking/successBooking";


$route['agenda_booking/reserved'] = "Agenda_booking/reserved";
$route['agenda_booking/payment_proceed'] = "Agenda_booking/payment_proceed";
$route['agenda_booking/select_payment_type'] = "Agenda_booking/select_payment_type";
$route['agenda_booking/pay'] = "Agenda_booking/pay";
$route['agenda_booking/delete_reservation/(:num)'] = "Agenda_booking/delete_reservation/$1";
$route['agenda_booking/get_agenda/(:any)'] = "Agenda_booking/get_agenda/$1";
$route['agenda_booking/get_agenda/spots/(:num)/(:num)'] = "Agenda_booking/get_agenda/spots/$1/$1";
$route['agenda_booking/getAllAgenda/(:any)'] = "Agenda_booking/getAllAgenda/$1";
$route['agenda_booking/design'] = "Agenda_booking/design";
$route['agenda_booking/savedesign'] = "Agenda_booking/saveDesign";
$route['agenda_booking/(:any)'] = "Agenda_booking/index/$1";

$route['customer_panel'] = "Customer_panel/index/";
$route['customer_panel/agenda'] = "Customer_panel/agenda";
$route['customer_panel/spots/(:num)'] = "Customer_panel/spots/$1";
$route['customer_panel/time_slots/(:num)'] = "Customer_panel/time_slots/$1";
$route['customer_panel/reservations_report'] = "Customer_panel/reservations";
$route['customer_panel/reservations_report/export'] = "Customer_panel/reservations_export";
$route['customer_panel/report'] = "Customer_panel/report";
$route['customer_panel/pivot'] = "Customer_panel/pivot";
$route['customer_panel/pivot_export']="Customer_panel/pivot_export";
$route['customer_panel/settings']="Customer_panel/settings";

$route['settingsmenu/savespotobject']="Settingsmenu/saveSpotObject";

$route['reservations/(:num)']="reservations/index/$1";

$route['invoices'] = 'Finance/index';
$route['finance/get_marketing_data'] = 'Finance/get_marketing_data';

$route['events/event'] = 'events/event';
$route['events/save_event'] = 'events/save_event';
$route['events/test'] = 'events/test';

$route['address'] = "profile/address";
$route['changepassword'] = "profile/changepassword";
$route['paymentsettings'] = "profile/paymentsettings";
$route['shopsettings'] = "profile/shopsettings";
$route['logo'] = "profile/logo";
$route['termsofuse'] = "profile/termsofuse";
$route['openandclose'] = "profile/openandclose";
$route['userapi'] = "profile/userApi";

$route['inandout/(:any)/(:num)'] = "Blackbox/index/$1/$2";
$route['in/(:any)/(:num)'] = "Blackbox/actionIn/$1/$2";
$route['out/(:any)/(:num)'] = "Blackbox/actionOut/$1/$2";
/* End of file routes.php */
/* Location: ./application/config/routes.php */
