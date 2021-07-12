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

$route['Paysuccesslinktgetfood'] = "Paysuccesslinktgetfood";


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
$route['loggedinmanuals'] = 'loggedinmanuals';
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
$route['alfred_ambasador'] = 'login/registerAmbasador';
$route['ambasador_activate/(:any)'] = 'login/ambasadorActivate/$1';
$route['loginMe'] = 'login/loginMe';
$route['loginEmployee'] = 'login/loginEmployee';
$route['loginCustomer'] = 'login/loginCustomer';
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

$route['bookingpay'] = 'booking/bookingpay';
$route['bookingpay/ExchangePay'] = 'Bookingpay/ExchangePay';
$route['bookingpay/successBooking'] = 'Bookingpay/successBooking';
$route['bookingpay/onlinepayment/(:num)'] = 'Bookingpay/onlinepayment/$1';
$route['bookingpay/onlinepayment/(:num)/(:any)'] = 'Bookingpay/onlinepayment/$1/$2';
$route['booking/pdf/(:num)/(:any)'] = 'Bookingpay/download_email_pdf/$1/$2';

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
$route['create_password/(:any)'] = 'login/buyerCreatePassword/$1';
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";
$route['resend_activation_link'] = "login/resendActivationLink";

$route['switchlang/(:any)'] = "languageswitcher/switchLang/$1";

$route['ticket/(:any)'] = "appointment/print/$1";
$route['userCalimedlisting'] = 'user/userCalimedlisting';
$route['send'] = "send/index/";

// WAREHOUSE
$route['warehouse']             = "warehouse/index";
$route['product_categories']    = "warehouse/productCategories";
$route['products']              = "warehouse/products";
$route['products/(:any)']       = "warehouse/products/$1";
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
$route['areas']                 = "warehouse/areas";
$route['addarea']               = "warehouse/addArea";
$route['delete_area/(:num)']    = "warehouse/deleteArea/$1";
$route['edit_area/(:num)']      = "warehouse/editArea/$1";
$route['warehouse/replacepopupbuttonstyle'] = "warehouse/replacePopupButtonStyle";

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
$route['api/voucher/create']  = 'Api/Voucher/create';

$route['api/onesignal/data']  = 'Api/OneSignal/data';
$route['api/spotmobile/spotinsert']  = 'Api/SpotMobile/spotinsert';
$route['api/products/upload']  = 'Api/Products/upload';
$route['api/events/records']  = 'Api/Events/Records';
$route['api/events/tickettypes']  = 'Api/Events/TicketTypes';
$route['api/events/tickets']  = 'Api/Events/Tickets';

$route['api/events/ticketevents']  = 'Api/Events/Ticketevents';

$route['api/printers/printer']  = 'Api/Printers/Printer';
$route['api/categories/category']  = 'Api/Categories/category';
$route['api/tickettypes/types']  = 'Api/TicketTypes/Types';
$route['api/entrance/in']  = 'Api/Entrance/In';

$route['api/clean_printer_requests']  = 'Api/Cronjobs/cleanPrinterRequests';
$route['api/report']  = 'Api/Reports/report';

// ALFRED PAYMENT ENGINE
$route['paymentengine/(:num)/(:any)/(:num)'] = 'Alfredpayment/paymentEngine/$1/$2/$3';
$route['successPayment'] = 'Alfredpayment/successPayment';
$route['exchangePay'] = 'Alfredpayment/ExchangePay';


$route['success_reservation'] = 'Reservations/success';


// shop
$route['success'] = 'Paysuccesslink';
$route['successth'] = 'Paysuccesslinkth';
$route['pending']       = 'paysuccesslink/pending';
$route['authorised']    = 'paysuccesslink/authorised';
$route['verify']        = 'paysuccesslink/verify';
$route['cancel']        = 'paysuccesslink/cancel';
$route['denied']        = 'paysuccesslink/denied';
$route['pin_canceled']  = 'paysuccesslink/pinCanceled';

// eticketin
$route['ticketing_success']       = 'paylinkticketing/index';
$route['ticketing_pending']       = 'paylinkticketing/pending';
$route['ticketing_authorised']    = 'paylinkticketing/authorised';
$route['ticketing_verify']        = 'paylinkticketing/verify';
$route['ticketing_cancel']        = 'paylinkticketing/cancel';
$route['ticketing_denied']        = 'paylinkticketing/denied';
$route['ticketing_pin_canceled']  = 'paylinkticketing/pinCanceled';

// reservation
$route['reservation_success']       = 'Paylinkreservations/index';
$route['reservation_pending']       = 'Paylinkreservations/pending';
$route['reservation_authorised']    = 'Paylinkreservations/authorised';
$route['reservation_verify']        = 'Paylinkreservations/verify';
$route['reservation_cancel']        = 'Paylinkreservations/cancel';
$route['reservation_denied']        = 'Paylinkreservations/denied';
$route['reservation_pin_canceled']  = 'Paylinkreservations/pinCanceled';



$route['vendors'] = 'Api/Vendors/data';
$route['vendor_orders'] = 'Api/Vendors/orders';
$route['vendor/(:num)'] = 'Api/Vendors/vendor/$1';
$route['users'] = 'Api/Vendors/users'; // return all users with venodr role
$route['usersQR'] = 'Api/Vendors/usersQR'; // return all users from tbl_app_routes

$route['slug']['get']           = 'Api/Slug/data';
$route['slug']['post']          = 'Api/Slug/data';
$route['slug/(:num)']['put']    = 'Api/Slug/data/$1';
$route['slug/(:num)']['delete'] = 'Api/Slug/data/$1';

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
$route['marketing/targeting/save_cron_job'] = 'Marketing/Targeting/save_cron_job';

$route['api/video/upload_post'] = 'Api/Video/upload_post';

$route['dashboard'] = 'Businessreport/index';
$route['businessreport/get_report'] = 'Businessreport/get_report';
$route['businessreport/get_timestamp_totals'] = 'Businessreport/get_timestamp_totals';
$route['businessreport/get_timestamp_orders'] = 'Businessreport/get_timestamp_orders';
$route['businessreport/sortedWidgets'] = 'Businessreport/sortedWidgets';
$route['businessreport/sortWidgets'] = 'Businessreport/sortWidgets';
$route['businessreport/get_graphs'] = 'Businessreport/get_graphs';
$route['businessreport/get_totals'] = 'Businessreport/get_totals';
$route['businessreport/graphs'] = 'Businessreport/graphs';
$route['businessreports'] = 'Businessreport/reports';
$route['payment_methods'] = 'Businessreport/paymentMethods';
$route['all_payment_methods'] = 'Businessreport/allPaymentMethods';


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
$route['booking/successbooking'] = "Booking/successBooking";
$route['change_reservation'] = 'Booking_agenda/changeReservation';


$route['booking_agenda/resendReservation'] = "Booking_agenda/resendReservation";
$route['booking_agenda/reserved'] = "Booking_agenda/reserved";
$route['booking_agenda/payment_proceed'] = "Booking_agenda/payment_proceed";
$route['booking_agenda/select_payment_type'] = "Booking_agenda/select_payment_type";
$route['booking_agenda/pay'] = "Booking_agenda/pay";
$route['booking_agenda/delete_reservation/(:num)'] = "Booking_agenda/delete_reservation/$1";
$route['booking_agenda/get_agenda/(:any)'] = "Booking_agenda/get_agenda/$1";
$route['booking_agenda/get_agenda/spots/(:num)/(:num)'] = "Booking_agenda/get_agenda/spots/$1/$1";
$route['booking_agenda/getAllAgenda/(:any)'] = "Booking_agenda/getAllAgenda/$1";
$route['booking_agenda/(:any)'] = "Booking_agenda/index/$1";

$route['booking_agenda2/reserved'] = "Booking_agenda2/reserved";
$route['booking_agenda2/payment_proceed'] = "Booking_agenda2/payment_proceed";
$route['booking_agenda2/select_payment_type'] = "Booking_agenda2/select_payment_type";
$route['booking_agenda2/pay'] = "Booking_agenda2/pay";
$route['booking_agenda2/delete_reservation/(:num)'] = "Booking_agenda2/delete_reservation/$1";
$route['booking_agenda2/get_agenda/(:any)'] = "Booking_agenda2/get_agenda/$1";
$route['booking_agenda2/get_agenda/spots/(:num)/(:num)'] = "Booking_agenda2/get_agenda/spots/$1/$1";
$route['booking_agenda2/getAllAgenda/(:any)'] = "Booking_agenda2/getAllAgenda/$1";
$route['booking_agenda2/(:any)'] = "Booking_agenda2/index/$1";

//$route['agendabooking/reserved'] = "Agendabooking/reserved";
//$route['agendabooking/payment_proceed'] = "Agendabooking/payment_proceed";
//$route['agendabooking/select_payment_type'] = "Agendabooking/select_payment_type";
//$route['agendabooking/pay'] = "Agendabooking/pay";
//$route['agendabooking/delete_reservation/(:num)'] = "Agendabooking/delete_reservation/$1";
//$route['agendabooking/get_agenda/(:any)'] = "Agendabooking/get_agenda/$1";
//$route['agendabooking/get_agenda/spots/(:num)/(:num)'] = "Agendabooking/get_agenda/spots/$1/$1";
//$route['agendabooking/getAllAgenda/(:any)'] = "Agendabooking/getAllAgenda/$1";
//$route['agendabooking/(:any)'] = "Agendabooking/index/$1";

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
$route['agenda_booking/replacebuttonstyle'] = "Agenda_booking/replaceButtonStyle";
$route['agenda_booking/iframe/(:any)'] = "Agenda_booking/iframe/$1";
$route['agenda_booking/(:any)'] = "Agenda_booking/index/$1";

$route['agenda_reservation/payment_proceed'] = "Agenda_reservation/payment_proceed";
$route['agenda_reservation/select_payment_type'] = "Agenda_reservation/select_payment_type";
$route['agenda_reservation/pay'] = "Agenda_reservationpay";
$route['agenda_reservation/spot'] = "Agenda_reservationpay";
$route['agenda_reservation/(:any)'] = "Agenda_reservation/index/$1";

$route['customer_panel'] = "Customer_panel/index/";
$route['customer_panel/agenda'] = "Customer_panel/agenda";
$route['customer_panel/spots/(:num)'] = "Customer_panel/spots/$1";
$route['customer_panel/time_slots/(:num)'] = "Customer_panel/time_slots/$1";
$route['customer_panel/reservations_report'] = "Customer_panel/reservations";
$route['customer_panel/reservations_report/export'] = "Customer_panel/reservations_export";
$route['customer_panel/report'] = "Customer_panel/report";
$route['customer_panel/pivot'] = "Customer_panel/pivot";
$route['customer_panel/pivot_export'] = "Customer_panel/pivot_export";
$route['customer_panel/settings'] ="Customer_panel/settings";
$route['customer_panel/list_templates'] = "Customer_panel/listTemplates";
$route['customer_panel/get_email_template'] = "Customer_panel/get_email_template";
$route['customer_panel/spots_order'] = "Customer_panel/spots_order";
$route['customer_panel/financial_report'] = "Customer_panel/financial_report";
$route['customer_panel/financial_report2'] = "Customer_panel/financial_report";
$route['customer_panel/get_financial_report'] = "Customer_panel/get_financial_report";
$route['customer_panel/resend_reservation']="Customer_panel/resend_reservation";


$route['settingsmenu/savespotobject']="Settingsmenu/saveSpotObject";

$route['reservations/(:num)']="reservations/index/$1";

$route['invoices'] = 'Finance/index';
$route['finance/get_marketing_data'] = 'Finance/get_marketing_data';
$route['clearing'] = 'Finance/clearing';
$route['finance/get_clearings'] = 'finance/get_clearings';


$route['events/create'] = 'Events/create';
$route['events/save_event'] = 'Events/save_event';
$route['events/save_ticket'] = 'Events/save_ticket';
$route['events/save_ticket_options'] = 'Events/save_ticket_options';
$route['events/save_design/(:any)'] = 'Events/save_design/$1';
$route['events/get_tickets'] = 'Events/get_tickets';
$route['events/get_events'] = 'Events/get_events';
$route['events/get_ticket_options'] = 'Events/get_ticket_options';
$route['events/viewdesign/(:any)'] = 'Events/viewdesign/$1';
$route['events/emaildesigner'] = 'Events/email_designer';
$route['events/emaildesigner/ticketing'] = 'Events/email_designer_edit';
$route['events/financial_report'] = 'Events/financial_report';
$route['events/get_ticket_report'] = 'Events/get_ticket_report';
$route['events/get_tickets_report'] = 'Events/get_tickets_report';
$route['events/get_email_templates'] = 'Events/get_email_templates';
$route['events/get_financial_report'] = 'Events/get_financial_report';
$route['events/add_guest'] = 'Events/add_guest';
$route['events/delete_ticket'] = 'Events/delete_ticket';
$route['events/delete_group'] = 'Events/delete_group';
$route['events/import_guestlist'] = 'Events/import_guestlist';
$route['events/resend_ticket'] = 'Events/resend_ticket';
$route['events/resend_reservation'] = 'Events/resend_reservation';
$route['events/tags'] = 'Events/tags';
$route['events/get_event_tags'] = 'Events/get_event_tags';
$route['events/save_event_tags'] = 'Events/save_event_tags';
$route['events/update_event_tags'] = 'Events/update_event_tags';
$route['events/delete_event_tags'] = 'Events/delete_event_tags';
$route['events/get_event_inputs'] = 'Events/get_event_inputs';
$route['events/save_event_inputs'] = 'Events/save_event_inputs';
$route['events/update_event_inputs'] = 'Events/update_event_inputs';
$route['events/delete_event_inputs'] = 'Events/delete_event_inputs';
$route['events/update_event_archived'] = 'Events/update_event_archived';
$route['events/scannedin'] = 'Events/scannedin';
$route['events/copy_event'] = 'Events/copy_event';
$route['clearingtickets'] = 'Events/clearingtickets';
$route['events/clearings'] = 'Events/clearings';
$route['events/get_event_clearing'] = 'Events/get_event_clearing';
$route['events/save_event_clearing'] = 'Events/save_event_clearing';
$route['events/update_event_clearing'] = 'Events/update_event_clearing';
$route['events/delete_event_clearing'] = 'Events/delete_event_clearing';
$route['events/tags_graphs'] = 'Events/tags_graphs';
$route['events/tags_stats'] = 'Events/tags_stats';
$route['events/tags_graphs'] = 'Events/tags_graphs';
$route['events/marketing'] = 'Events/marketing';
$route['events/send_multiple_emails'] = 'Events/send_multiple_emails';
$route['events/get_clearing_stats/(:any)'] = 'Events/get_clearing_stats/$1';
$route['events/inputs/(:any)'] = 'Events/inputs/$1';
$route['events/event/(:num)'] = 'Events/event/$1';
$route['events/report/(:num)'] = 'Events/report/$1';
$route['events/graph/(:num)'] = 'Events/graph/$1';
$route['events/guestlist/(:num)'] = 'Events/guestlist/$1';
$route['events/get_guestlist/(:num)'] = 'Events/get_guestlist/$1';
$route['events/emaildesigner/ticketing/(:num)'] = 'Events/email_designer_edit/$1';

$route['events/shop'] = 'Booking_events/index';
$route['events/shop/termsofuse'] = 'Booking_events/termsofuse';
$route['events/shop/(:any)'] = 'Booking_events/index/$1';
$route['events/tickets/(:num)'] = 'Booking_events/tickets/$1';
$route['events/pay'] = 'Booking_events/pay';
$route['events/payment_proceed'] = 'Booking_events/payment_proceed';
$route['events/selectpayment'] = 'Booking_events/selectpayment';
$route['booking_events/clear_tickets'] = 'Booking_events/clear_tickets';
$route['booking_events/successBooking'] = 'Booking_events/successBooking';
$route['booking_events/ExchangePay'] = 'Booking_events/ExchangePay';
$route['booking_events/pdf/(:num)/(:any)'] = "Booking_events/download_email_pdf/$1/$2";
$route['booking/onlinepayment/(:num)'] = 'Booking_events/onlinepayment/$1';
$route['booking/onlinepayment/(:num)/(:any)'] = 'Booking_events/onlinepayment/$1/$2';



$route['booking_reservations/tickets/(:num)'] = 'Booking_reservations/tickets/$1';
$route['booking_reservations/add_to_basket'] = 'Booking_reservations/add_to_basket';
$route['booking_reservations/pay'] = 'Booking_reservations/pay';
$route['booking_reservations/payment_proceed'] = 'Booking_reservations/payment_proceed';
$route['booking_reservations/select_payment_type'] = 'Booking_reservations/select_payment_type';
$route['booking_reservations/delete_reservation'] = 'Booking_reservations/delete_reservation';
$route['booking_reservations/clear_reservations'] = 'Booking_reservations/clear_reservations';
$route['booking_reservations/spots/(:num)/(:num)'] = "Booking_reservations/spots/$1/$2";
$route['booking_reservations/pdf/(:num)/(:any)'] = "Booking_reservations/download_email_pdf/$1/$2";
$route['booking_reservations/(:any)'] = 'Booking_reservations/index/$1';

$route['video/get_videos'] = 'Video/get_videos';
$route['video/delete_video'] = 'Video/delete_video';
$route['video/add_video_description'] = 'Video/add_video_description';


$route['address'] = "profile/address";
$route['changepassword'] = "profile/changepassword";
$route['paymentsettings'] = "profile/paymentsettings";
$route['shopsettings'] = "profile/shopsettings";
$route['logo'] = "profile/logo";
$route['termsofuse'] = "profile/termsofuse";
$route['openandclose'] = "profile/openandclose";
$route['userapi'] = "profile/userApi";
$route['paynl_merchant'] = 'profile/paynlMerchant';
$route['reset_times'] = 'profile/resetTimes';
$route['reports_settings'] = 'profile/reportsSettings';

$route['inandout/(:any)/(:num)'] = "Blackbox/index/$1/$2";
$route['in/(:any)/(:num)'] = "Blackbox/actionIn/$1/$2";
$route['out/(:any)/(:num)'] = "Blackbox/actionOut/$1/$2";


$route['add_template'] = 'Templates/addTemplate';
$route['update_template/(:num)'] = 'Templates/updateTemplate/$1';
$route['update_template/(:num)/(:any)'] = 'Templates/updateTemplate/$1/$2';
$route['list_template'] = 'Templates/listTemplates';

$route['translate/get_languages'] = 'Translate/get_languages';

$route['voucher'] = 'Voucher/index';
$route['voucher/create'] = 'Voucher/create';
$route['voucher/send'] = 'Voucher/send';
$route['voucher/update_template/(:num)'] = 'Voucher/updateTemplate/$1';
$route['voucher/pdf/(:num)'] = 'Voucher/download_email_pdf/$1';

$route['qrcode'] = 'Qrcode/index';
$route['qrcode/get_qrcodes'] = 'Qrcode/get_qrcodes';
$route['qrcode/save_qrcode'] = 'Qrcode/save_qrcode';
$route['qrcode/update_qrcode'] = 'Qrcode/update_qrcode';

$route['productsonoff'] = 'Productsonoff/index';
$route['productsonoff/(:any)'] = 'Productsonoff/index/$1';

$route['appsettings'] = 'Appsettings/index';
$route['appsettings/get_appsettings'] = 'Appsettings/get_appsettings';
$route['appsettings/save_appsettings'] = 'Appsettings/save_appsettings';
$route['appsettings/update_appsettings'] = 'Appsettings/update_appsettings';
$route['appsettings/delete_appsettings'] = 'Appsettings/delete_appsettings';

$route['floorplans'] = 'Floorplans/index';
$route['add_floorplan'] = 'Floorplans/addFloorplan';
$route['edit_floorplan/(:num)'] = 'Floorplans/editFloorplan/$1';


// connections api routes

// buyer api
$route['api/connection/buyer']['get'] = 'Api/connection/Buyerapi/buyer';
$route['api/connection/buyer']['post'] = 'Api/connection/Buyerapi/buyer';
$route['api/connection/buyer/(:any)']['put'] = 'Api/connection/Buyerapi/buyer/$1';
$route['api/connection/buyer_extended/(:any)']['put'] = 'Api/connection/Buyerapi/buyerex/$1';



// orders
$route['api/connection/order']['post']  = 'Api/connection/Ordersapi/order';

//Finanza
$route['api/finanza/orders/(:any)'] = 'Api/finanza/orders/$1';

// send printer sms alert
$route['printer_sms_alert'] = 'Api/Cronjobs/smsAlert';

$route['send_reportes'] = 'Api/Cronjobs/sendReportes';

$route['update_payment_method'] = 'Api/Cronjobs/updatePaymentMethod';

// buyer

$route['buyer'] = 'Buyer/index';
$route['buyer_orders'] = 'Buyer/buyerOrders';
$route['buyer_tickets'] = 'Buyer/buyerTickets';
$route['buyer_reservations'] = 'Buyer/buyerReservations';
$route['buyer/get_tags_stats'] = 'Buyer/get_tags_stats';

//buyer ajax
$route['get_buyer_orders'] = 'Ajaxbuyer/getBuyerOrders';
$route['fetch_order/(:num)'] = 'Ajaxbuyer/fetchOrder/$1';



$route['send_log_file'] = 'Api/Cronjobs/sendLogFile';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
