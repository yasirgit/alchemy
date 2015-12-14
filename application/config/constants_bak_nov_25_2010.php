<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE',	0644);
define('FILE_WRITE_MODE',	0666);
define('DIR_READ_MODE',		0755);
define('DIR_WRITE_MODE',	0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('API_URL',		'http://platform.fatsecret.com/js?'); 
//define('API_KEY',		'2bfaf3b0097b47bfbfa16bd9b2fcea4a');
//define('API_SECRET',	'8724fd7994a44518a4a7d351512f158e'); 
define('API_KEY',		'25d14a3c45194b05b91626f1db0ee583');
define('API_SECRET',	'0cb76c5578904f74a228a852455b40fa');
define('BASE_URL',		'http://platform.fatsecret.com/rest/server.api?');

define('_TWITTER_CONSUMER_KEY_',	"mNumEIE6ZNNUdAepAv7sQ");
define('_TWITTER_CONSUMER_SECRET_',	"0pBq5sdZqWrJ3ur3k9DizLN2wHRF0GYhDnHaiJIBs");
//define('_TWITTER_OAUTH_CALLBACK_',	'http://brian.ripemedia.com/application/libraries/twitteroauth/callback.php');
define('_TWITTER_URL_',				'');

define('_UPLOAD_PATH_',	'uploads');
define('PAGECNT_SMALL',	10);
define('PAGECNT_LARGE',	20);

define('_MAX_WATER_',	8);

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */