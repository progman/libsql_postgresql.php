//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__time2var($table_name_short, $col_name, $col_alias = null, $flag_make_col_alias = true)
{
// stupid compatible
//("table_name_short", "col_name")
//("table_name_short", "col_name", true)
//("table_name_short", "col_name", "col_alias")
//("table_name_short", "col_name", "col_alias", true)
	for (;;)
	{
		if (gettype($col_alias) === "boolean")
		{
			$flag_make_col_alias = $col_alias;
			$col_alias = $col_name;
			break;
		}

		if ($col_alias === null)
		{
			$col_alias = $col_name;
			break;
		}

		break;
	}

	if ($flag_make_col_alias === false)
	{
		return "UTC_TO_UNIXMICROTIME(".$table_name_short.".".$col_name.")";
	}

	return "UTC_TO_UNIXMICROTIME(".$table_name_short.".".$col_name.")::bigint AS ".$col_alias;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
