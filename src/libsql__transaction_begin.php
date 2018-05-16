//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__transaction_begin($sql_handle, $flag_serializable = false)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$sql_tag = "";
	$sql_str = "";
	if ($flag_serializable === false)
	{
		$sql_tag = "SQL002";
		$sql_str = "BEGIN TRANSACTION ISOLATION LEVEL READ COMMITTED; -- ".$sql_tag;
	}
	else
	{
		$sql_tag = "SQL003";
		$sql_str = "BEGIN TRANSACTION ISOLATION LEVEL SERIALIZABLE; -- ".$sql_tag;
	}


	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
