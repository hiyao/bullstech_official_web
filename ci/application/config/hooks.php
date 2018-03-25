<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$ga_account_id = 'UA-xxxxxxx-x';
$ga_domain_name = 'auto';

$hook['display_override'] = array(
    'class'    => 'googleAnalytics',
    'function' => 'insert_ga_script',
    'filename' => 'Google_analytics.php',
    'filepath' => 'hooks',
    'params'   => array($ga_account_id, $ga_domain_name)
);

//$hook['pre_controller'] = array(
//    'class'  => 'XHProf',
//    'function' => 'XHProf_Start',
//    'filename' => 'Xhprof.php',
//    'filepath' => 'hooks',
//    'params' => array()
//);
//
//$hook['post_controller'] = array(
//    'class'  => 'XHProf',
//    'function' => 'XHProf_End',
//    'filename' => 'Xhprof.php',
//    'filepath' => 'hooks',
//    'params' => array()
//);

