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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
	The 'App Area' allows you to specify the base folder used for all of
	the contexts in the app. By default, this is set to '/admin', but this
	does not make sense for all applications.
*/
define('SITE_AREA', 'admin');

/*
	The 'IS_AJAX' constant allows for a quick simple check to verify that the
	request is infact a XHR Request, it can be used to help secure your AJAX
	methods by just verifying that 'IS_AJAX' == TRUE.
*/

$ajax_request = ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? TRUE : FALSE;
define('IS_AJAX' , $ajax_request );
unset ( $ajax_request );

//user types
define('USER_ADMIN', 'a');
define('USER_TRAINER', 't');
define('USER_MEMBER', 'm');
//END*/

//PER PRICE*/
define('WEEK', 0);
define('MONTH',1);
define('YEAR', 2);
//END*/

//ACTIVATED*/
define('BAN', 2);
define('ACTIVATED', 1);
define('DEACTIVATED', 0);
//END*/

//STATUS*/
define('SOLD',0);
define('FEATURED', 1);
//END*/

//PURPOSE*/
define('SALES', 0);
define('RENT', 1);
define('SALES_AND_RENT',2);
//END*/

//REQUEST
//Service Types
define('SERVICE_TYPE_SINGLE', 's');
define('SERVICE_TYPE_GROUP', 'g');

define('TRAIN_TIME_MORNING', 'm');
define('TRAIN_TIME_MID', 'd');
define('TRAIN_TIME_EVENING', 'e');

define('REQUEST_PENDING', 1);
define('REQUEST_CLOSED', 2);

define('QUOTE_PENDING', 1);
define('QUOTE_ACCEPTED', 2);
/* End of file constants.php */
/* Location: ./application/config/constants.php */