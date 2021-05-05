<?php
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
require_once("./submodule/libcore.php/libcore.php");
require_once("./submodule/lib_sql_postgresql.php/libsql_postgresql.php");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
$arg = new \stdClass();

$arg->sql_host     = libcore__get_var_str("SQL_HOST");
$arg->sql_port     = libcore__get_var_str("SQL_PORT");
$arg->sql_database = libcore__get_var_str("SQL_DATABASE");
$arg->sql_login    = libcore__get_var_str("SQL_LOGIN");
$arg->sql_password = libcore__get_var_str("SQL_PASSWORD");
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function xxx($val)
{
	echo 'detect xxx:'.$val."\n";
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function action($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


// channel name
	$channel = 'xxx';


// listen channel 'xxx', just send notify like: PERFORM pg_notify( 'xxx', '{"id":' || NEW.id || ',"value":' || NEW.value || '}' ); OR NOTIFY xxx, '{"id":1, "value": 777}';
	$rc = libsql__listen($arg->sql_handle, $channel);


// wait notify
	for (;;)
	{
		$notify = null;
		for (;;)
		{
			$rc = libsql__ping($arg->sql_handle); // check and refresh database connection if it need
			if ($rc->is_ok() === false) return $rc;


			$rc = libsql__get_notify($arg->sql_handle);
			if ($rc->is_ok() === false) return $rc;
			$notify = $rc->get_value();
			if ($notify !== false) break;


			libsql__notify_wait($arg->sql_handle);
		}


// do it
		if (strcmp($notify['message'], $channel) == 0)
		{
			xxx($notify['payload']);
		}
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function main($arg)
{
	$result = new result_t(__FUNCTION__, __FILE__);


// reset sql
	$arg->sql_handle = null;


// connect to sql database
	$rc = libsql__database_open($arg->sql_host, $arg->sql_port, $arg->sql_database, $arg->sql_login, $arg->sql_password);
	if ($rc->is_ok() === false) return $rc;
	$arg->sql_handle = $rc->get_value();


// action
	$rc = action($arg);


// close connect to sql database
	libsql__database_close($arg->sql_handle);


	return $rc;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
$rc = main($arg);
if ($rc->is_ok() !== false)
{
	echo "ok.\n";
	exit(0);
}
else
{
	echo "ERROR[".$rc->get_function_name()."(), ".$rc->get_file_name().":".$rc->get_line_number()."]: ".$rc->get_msg()."\n";
	echo print_r($rc->get_value(), true)."\n";
	exit(1);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
?>