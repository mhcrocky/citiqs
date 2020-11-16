<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);
const MIGRATION_EMAIL ="pnroos@icloud.com";



/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/**** USER DEFINED CONSTANTS **********/

define('ROLE_ADMIN',                            '1');
define('ROLE_MANAGER',                         	'2');
define('ROLE_EMPLOYEE',                         '3');

define('SEGMENT',								2);

/************************** DATABASE  **************************************/
//Database:	tiqs_alfred
//Host:	localhost
//Username:	tiqs_alfred
//Password:	dpME10hk7


// switch (strtolower($_SERVER['HTTP_HOST']))
// {
// 	case 'tiqs.com':
// 		define('HOSTNAME', 'localhost');
// 		define('USERNAME', 'tiqs_alfred');
// 		define('PASSWORD', 'dpME10hk7');
// 		define('DATABASE', 'tiqs_alfred');
// 		break;

// 	case 'www.tiqs.com':
// 		define('HOSTNAME', 'localhost');
// 		define('USERNAME', 'tiqs_alfred');
// 		define('PASSWORD', 'dpME10hk7');
// 		define('DATABASE', 'ticqs_alfred');
// 		break;

// 	// used by Peter sandbox
// 	case '127.0.0.1':
// 		define('HOSTNAME', 'localhost');
// 		define('USERNAME', 'root');
// 		define('PASSWORD', '');
// 		define('DATABASE', 'ticqs_alfred');
// 		break;

// 	case '192.168.219.101':
// 		define('HOSTNAME', 'localhost');
// 		define('USERNAME', 'root');
// 		define('PASSWORD', 'root');
// 		define('DATABASE', 'ticqs_lost');
// 		break;

//     case 'spot.loc':
//         define('HOSTNAME', 'localhost');
//         define('USERNAME', 'mysql');
//         define('PASSWORD', 'mysql');
//         define('DATABASE', 'spot');
//         break;

//  	default:
// 		define('HOSTNAME', 'localhost');
// 		define('USERNAME', 'root');
// 		define('PASSWORD', '');
// 		define('DATABASE', 'ticqs_alfred');
// 		// break;
// 	}

/************** PERFEX API  **************************************/
// LIVE
const PERFEX_API = 'https://tiqs.com/backoffice/admin/api/';
const PERFEX_API_KEY = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGlxc3dlYiIsIm5hbWUiOiJ0aXFzd2ViIiwicGFzc3dvcmQiOm51bGwsIkFQSV9USU1FIjoxNTgyNTQ2NTc1fQ.q7ssJqcwsXhuNVDyspGYh_KV7_JsbwS8vq2TT9R-MGk';
// development
// const PERFEX_API = 'path to /perfex/perfex_crm/admin/api/';
// const PERFEX_API_KEY = 'api key localhost';

/************************* SANDY EMAIL CONSTANTS  *************************************/
const SANDY_API_KEY = 'TtlB6UhkbYarYr4PwlR1';
const SANDY_LIST_ID = 'ECFC3PrhFpKLqmt7ClrvXQ';

/************************* EMAIL CONSTANTS ****************************/

define('EMAIL_FROM','lost-found@tiqs.com'); // e.g. email@example.com
define('EMAIL_BCC','Your bcc email');		// e.g. email@example.com
define('FROM_NAME','CIAS Admin System');	// Your system name
define('EMAIL_PASS','Your email password');	// Your email password
define('PROTOCOL','smtp');	// mail, sendmail, smtp
define('SMTP_HOST','email-smtp.eu-west-1.amazonaws.com'); // your smtp host e.g. smtp.gmail.com
define('SMTP_PORT',587);	// your smtp port e.g. 25, 587
define('SMTP_USER','AKIAVGUIAKNKAAWXVR3G'); // your smtp user
define('SMTP_PASS','BNE/7m+ZPiN74EX/5XAbaqa7WzKV9Z+RSGsMlbb+OMMa'); // your smtp password
define('MAIL_PATH','/usr/sbin/sendmail');

/********************** DHL  **************************/
const DHL_USERNAME = "tiqsNL";
const DHL_PASSWORD = "N#0sD@1wP^6e";
const DHL_NONCE = "w/82dZ0Jn5rM/MTfqM7xXIilq10=";
const DHL_CREATED = "2019-11-19T16:19:13Z";

/********************* PAYNL **********************/
const PAYNL_DATA_TOKEN = '35c1bce89516c74ce7f8475d66c31dd59937d72a';
const PAYNL_DATA_TOKEN_RECURRING = 'bbd5159d61f3ca78e91dfd633610df9abadd0a1e';
const PAYNL_DATA_TOKEN_ID = 'AT-0051-0895';
const PAYNL_DATA_TOKEN_ID_RECURRING = 'AT-0058-0425';
const PAYNL_SERVICE_ID = 'SL-1145-9321';
const PAYNL_SERVICE_ID_RECURRING = 'SL-3410-9231';
const PAYNL_SERVICE_ID_CHECK424 = 'SL-6756-9571';

/****** ENCRYPTION_KEY 16 bytes (charcters) long */
const ENCRYPTION_KEY = '1234567890123456';

defined('VISMA_client_id')      OR define('VISMA_client_id', 'reviewmedia');
defined('VISMA_flow')      OR define('VISMA_flow', 'Code Flow');
defined('VISMA_secret')      OR define('VISMA_secret', '4305mXa84olnp335EHQIprH57Zf5OS212x1v1N7BqTxZeeMY58VUlV52nj5yY21');
defined('VISMA_redirect')      OR define('VISMA_redirect', 'http://localhost/tiqs_alfred/visma');
defined('VISMA_scope')      OR define('VISMA_scope', 'offline_access ea:api ea:sales ea:accounting ea:purchase');
defined('VISMA_SANDBOX_DEBUG_MODE')      OR define('VISMA_SANDBOX_DEBUG_MODE', TRUE);

// defined('VISMA_client_id')      OR define('VISMA_client_id', 'orangelynx1');
// defined('VISMA_flow')      OR define('VISMA_flow', 'Code Flow');
// defined('VISMA_secret')      OR define('VISMA_secret', 'B26izzDpuY56848G68VePFrD46pw38T964RZeSxXQ2GJtTi2pE46kbq5HG838T0');
// defined('VISMA_redirect')      OR define('VISMA_redirect', 'https://localhost/tiqs_alfred/visma');
// defined('VISMA_scope')      OR define('VISMA_scope', 'offline_access ea:api ea:sales ea:accounting ea:purchase');
// defined('VISMA_SANDBOX_DEBUG_MODE')      OR define('VISMA_SANDBOX_DEBUG_MODE', TRUE);
