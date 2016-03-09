<?php
/*
:: MASTER CONFIGURATION
:: Author : iRUL
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

// -- App Info
define('APP_TITLE'  , 'DPPKAD KOTA TANGERANG SELATAN');
define('APP_NAME'   , 'pbbbphtb'); //no space please
define('APP_CORP'   , 'OpenSIPKD');
define('APP_VERSION', '0.1');
define('APP_YEAR'   , '2013');
define('LICENSE_TO' , 'KOTA TANGERANG SELATAN');
define('LICENSE_TO_SUB' , 'DINAS PENGELOLAAN PENDAPATAN, KEUANGAN DAN ASET DAERAH');
define('KD_PROPINSI','36');
define('KD_DATI2','76'); //03 //79

 
// -- Module
define('DEF_MODULE'     , 1); // 1. perencanaan 2.etc  ref => apps table
define('SELECT_MODULE'  , TRUE);

// -- Environment
define('MY_ENV', 'production'); //development testing production
//define('MY_ENV', 'development'); //development testing production

//redir --lport=3389 --cport=3389 --caddr=1921.... >&1 &

// -- System & Application
define('MY_SYS', 'sys213');
define('MY_APP', 'app213');
define('MY_DEFAULT_CONTROLLER', 'root');
define('MY_MODULES_LOCATIONS' , '../modules/');

// -- Database
define('DB_TYPE', 'postgre');  //mysql postgre
define('DB_HOST', '192.168.88.4');
define('DB_PORT', '5432');
define('DB_USER', 'pbbbphtb');
define('DB_PASS', '@991004s');
define('DB_NAME', 'pbbbphtb');

// -- Url
$PROTOCOL = "https://"; //. ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
$SERVER   = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
$SERVER   = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $SERVER; 
$BASE_URL = $PROTOCOL . $SERVER . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
define('MY_BASE_URL', $BASE_URL);
define('MY_INDEX_PAGE', '');

// -- Hook
define('MY_ENABLE_HOOKS', FALSE);

// -- Compress Output
define('MY_COMPRESS_OUTPUT', FALSE);

// -- Cache n minutes
define('MY_CACHE', 0);
define('MY_CACHE_PATH', 'cache/');

// -- Error Logging Threshold
/*
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
*/
define('MY_LOG_THRESHOLD', 4);

// -- Encrypt & Security
define('MY_ENCRYPTION_KEY', 'mr34n1k');
define('MY_GLOBAL_XSS_FILTERING', TRUE);
define('MY_CSRF_PROTECTION', FALSE);
define('MY_CSRF_TOKEN_NAME', APP_NAME.'_csrf_test');
define('MY_CSRF_COOKIE_NAME', APP_NAME.'_cookie_name');
define('MY_CSRF_EXPIRE', 150);

define('MY_SESS_COOKIE_NAME', APP_NAME.'_session');
define('MY_SESS_TABLE_NAME', APP_NAME.'_session');


// -- Etc
define('ADMIN_NAME', 'Administrator');
define('ADMIN_EMAIL', 'asd@ajetjet.com');
define('ADMIN_DATE_FORMAT', '%D, %d %M %Y %H:%i');
define('ADMIN_DATE_TIME_FORMAT', 'd/m/y H:i');

define('EMAIL_POSTF', '@ajetjet.com');

define('LOGIN_ATTEMPT', 3);
define('LOGIN_ATTEMPT_EXPIRE', 20); //60*60*24);

//POS PBB
define('POS_WIL','versi1');
define('DEF_POS_TYPE'     , 1); // 1. kanwil_kantor tp 2.etc  ref => apps table
if (DEF_POS_TYPE==1)
   define('POS_FIELD', 'kd_kanwil,kd_kantor,kd_tp');
else 
   define('POS_FIELD', 'kd_bank_tunggal,kd_bank_persepsi,kd_kanwil_bank,kd_kppbb_bank,kd_tp');

define('INTEGRASI_PBB_BPHTB', 1);
define('BPHTB_NEED_APPROVAL', FALSE);
?>
