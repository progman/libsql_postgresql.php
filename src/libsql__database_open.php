//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__database_open($host, $port, $database, $login, $password)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$connection_string = "host=".$host." port=".$port." dbname=".$database." user=".$login." password=".$password;
	$sql_handle = @pg_connect($connection_string, PGSQL_CONNECT_FORCE_NEW);
	if ($sql_handle === false)
	{
		$result->set_err(1, "SQL сервер недоступен");
		return $result;
	}


	$sql_tag = "SQL001";
	$sql_str = "SET bytea_output = escape; -- ".$sql_tag;
	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	$result->set_value($sql_handle);
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
