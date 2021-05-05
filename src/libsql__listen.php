//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__listen($sql_handle, $channel)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$rc = @pg_query($sql_handle, 'LISTEN '.$channel.';');
	if ($rc === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
