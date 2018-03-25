<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

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
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE',
    'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',
    'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 1); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', -1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', -3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', -4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', -5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', -6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', -7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', -8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', -9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', -125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| Exit Status Codes (extra)
|--------------------------------------------------------------------------
|
 */
defined('EXIT_USER_EXISTS') or define('EXIT_USER_EXISTS', -201); //  user is exists
defined('EXIT_DATABASE_ERROR') or define('EXIT_DATABASE_ERROR', -202); //  DATABASE ERROR
defined('EXIT_DATABASE_DATA_NOT_FOUND') or define('EXIT_DATABASE_DATA_NOT_FOUND', -204); //  DATABASE DATA NOT FOUND
defined('EXIT_NO_PERMISSION') or define('EXIT_NO_PERMISSION', -203); //   no permission

/*
|--------------------------------------------------------------------------
| Log Error Codes
|--------------------------------------------------------------------------
|
 */
defined('LOG_E_UNKNOWN') or define('LOG_E_UNKNOWN', 0);
defined('LOG_E_GENERAL') or define('LOG_E_GENERAL', 1);
defined('LOG_E_EXCEPTION') or define('LOG_E_EXCEPTION', 2);
defined('LOG_E_DATABASE') or define('LOG_E_DATABASE', 3);
defined('LOG_E_PHP') or define('LOG_E_PHP', 4);

/*
|--------------------------------------------------------------------------
| Condition
|--------------------------------------------------------------------------
|
 */
defined('CONDITION_GT') or define('CONDITION_GT', '>');
defined('CONDITION_GE') or define('CONDITION_GE', '>=');
defined('CONDITION_LT') or define('CONDITION_LT', '<');
defined('CONDITION_LE') or define('CONDITION_LE', '<=');
defined('CONDITION_EQ') or define('CONDITION_EQ', '=');
defined('CONDITION_NE') or define('CONDITION_NE', '!=');

/*
|--------------------------------------------------------------------------
| Common Setting
|--------------------------------------------------------------------------
|
| Used to common variable.
|
 */
defined('COMMON_PASSWORD') or define('COMMON_PASSWORD', 'ants102b!@#'); // login common password
defined('ENABLED') or define('ENABLED', true); // enable
defined('DISABLED') or define('DISABLED', false); // disable
defined('ACCEPT') or define('ACCEPT', true);
defined('DENIED') or define('DENIED', false);
defined('PUBLISHED') or define('PUBLISHED', true);
defined('UNPUBLISHED') or define('UNPUBLISHED', false);

/*
|--------------------------------------------------------------------------
| Admin user_id
|--------------------------------------------------------------------------
|
 */
defined('ADMIN_USERS') or define('ADMIN_USERS', [3, 5]);

/*
|--------------------------------------------------------------------------
| Identity type
|--------------------------------------------------------------------------
|
| User identity
| Check database table "identity".
 */
defined('IDENTITY_CUSTOMER') or define('IDENTITY_CUSTOMER', 1);
defined('IDENTITY_EMPLOYEE') or define('IDENTITY_EMPLOYEE', 2);
defined('IDENTITY_ADMIN') or define('IDENTITY_ADMIN', 4);
defined('IDENTITY_SUPERADMIN') or define('IDENTITY_SUPERADMIN', 5);

/*
|--------------------------------------------------------------------------
| Group level
|--------------------------------------------------------------------------
|
 */
defined('GROUP_LEVEL_DISTRICT') or define('GROUP_LEVEL_DISTRICT', 1);
defined('GROUP_LEVEL_DEPARTMENT') or define('GROUP_LEVEL_DEPARTMENT', 2);
defined('GROUP_LEVEL_UNIT') or define('GROUP_LEVEL_UNIT', 3);

/*
|--------------------------------------------------------------------------
| Event type
|--------------------------------------------------------------------------
|
| Log event type
| Check database table "system_log_user_event".
 */
defined('EVENT_INSERT') or define('EVENT_INSERT', 1);
defined('EVENT_UPDATE') or define('EVENT_UPDATE', 2);
defined('EVENT_DELETE') or define('EVENT_DELETE', 3);
defined('EVENT_ERROR') or define('EVENT_ERROR', 99);

/*
|--------------------------------------------------------------------------
| News type
|--------------------------------------------------------------------------
|
 */
defined('NEWS_NEW') or define('NEWS_NEW', 0); // 最新消息
defined('NEWS_SYSTEM') or define('NEWS_SYSTEM', 1); // 系統公告
defined('NEWS_COURSE') or define('NEWS_COURSE', 2); // 課程公告

/*
|--------------------------------------------------------------------------
| Notify type
|--------------------------------------------------------------------------
|
| Notify read type
 */
defined('NOTIFY_IS_READ') or define('NOTIFY_IS_READ', 1);
defined('NOTIFY_NO_READ') or define('NOTIFY_NO_READ', 0);
defined('NOTIFY_IS_ACTION') or define('NOTIFY_IS_ACTION', 1);
defined('NOTIFY_NO_ACTION') or define('NOTIFY_NO_ACTION', 0);

defined('NOTIFY_ACTION_NULL') or define('NOTIFY_ACTION_NULL', 0);
defined('NOTIFY_ACTION_URL') or define('NOTIFY_ACTION_URL', 1);
defined('NOTIFY_ACTION_METHOD') or define('NOTIFY_ACTION_METHOD', 2);