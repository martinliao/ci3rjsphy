<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	//'hostname' => '192.168.50.104',
	'hostname' => '192.168.50.23',
	'username' => 'root',
	'password' => 'jack5899',
	//'database' => 'dcsdphy104',
	'database' => 'course',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	'cache_on' => TRUE,
	'cachedir' => '/tmp/db_cache',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['dcsdphy'] = array(
	'dsn'	=> '',
	//'hostname' => '192.168.50.104',
	'hostname' => '192.168.50.23',
	'username' => 'root',
	'password' => 'jack5899',
	//'database' => 'dcsdphy104',
	'database' => 'course',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	'cache_on' => TRUE,
	'cachedir' => '/tmp/db_cache',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['training'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.50.103',
	'username' => 'root',
	'password' => 'jack5899',
	'database' => 'training',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	'cache_on' => TRUE,
	'cachedir' => '/tmp/db_cache',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['phy_require'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.50.103',
	'username' => 'root',
	'password' => 'jack5899',
	'database' => 'moodle',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	'cache_on' => TRUE,
	'cachedir' => '/tmp/db_cache',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

