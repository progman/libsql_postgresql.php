//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2bool_list($item_list, $flag_skip_null = true)
{
	$str = "ARRAY[";
	$size = count($item_list);
	for ($i=0; $i < $size; $i++)
	{
		if (($item_list[$i] === null) && ($flag_skip_null === true)) continue;

		if ($i !== 0)
		{
			$str .= ', ';
		}

		$str .= libsql__var2bool($item_list[$i]);
	}
	$str .= "]::boolean[]";

	return $str;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
