//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2llike($item)
{
	if ($item === null)
	{
		return "NULL";
	}

	return "E'".libsql__var2inner_text($item)."%'::text";
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
