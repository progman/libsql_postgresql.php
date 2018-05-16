//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__get_notify($sql_handle)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$notify = @pg_get_notify($sql_handle);


	$result->set_ok();
	$result->set_value($notify);
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//