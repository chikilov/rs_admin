<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Generally localhost
// $config['host'] = (ENVIRONMENT !== 'production' ? '127.0.0.1' : '172.31.18.13');
// The database you want to work on
//$config['db'] = (ENVIRONMENT !== 'production' ? 'rs_cbt' : 'rs');

//$config['host'] = (ENVIRONMENT !== 'production' ? '1.234.7.211' : '172.31.18.13');
//$config['db'] = (ENVIRONMENT !== 'production' ? 'rs_dev0' : 'rs');
$config['host'] = (ENVIRONMENT !== 'production' ? (ENVIRONMENT !== 'testing' ? '127.0.0.1' : '127.0.0.1') : '172.31.18.13');
$config['db'] = (ENVIRONMENT !== 'production' ? (ENVIRONMENT !== 'testing' ? 'rs_cbt' : 'rs') : 'rs');

// Generally 27017
$config['port'] = 27017;
// Required if Mongo is running in auth mode
//$config['user'] = 'rs_dev';
//$config['pass'] = 'dpdldosqlMongo$#@!';
/*
 * Defaults to FALSE. If FALSE, the program continues executing without waiting for a database response.
 * If TRUE, the program will wait for the database response and throw a MongoCursorException if the update did not succeed.
*/
$config['query_safety'] = TRUE;
//If running in auth mode and the user does not have global read/write then set this to true
$config['db_flag'] = TRUE;
//consider these config only if you want to store the session into mongoDB
//They will be used in MY_Session.php
$config['sess_use_mongo'] = FALSE;
$config['sess_collection_name']	= 'ci_sessions';
