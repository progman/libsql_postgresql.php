//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2time($item)
{
	if (libcore__is_uint($item) === false)
	{
		$item = null;
	}


	if ($item === null)
	{
		return "NULL";
	}


	return "UNIXMICROTIME_TO_UTC('".$item."'::bigint)::timestamp";
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
