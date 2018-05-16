//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__time2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return "UTC_TO_UNIXMICROTIME(".$table_name_short.".".$col_name.")";
	}

	return "UTC_TO_UNIXMICROTIME(".$table_name_short.".".$col_name.")::bigint AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
