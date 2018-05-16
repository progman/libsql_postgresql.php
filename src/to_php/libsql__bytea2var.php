//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__bytea2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return "ENCODE(".$table_name_short.".".$col_name.", 'hex')::text";
	}

	return "ENCODE(".$table_name_short.".".$col_name.", 'hex')::text AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
