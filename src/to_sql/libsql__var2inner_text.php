//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2inner_text($item)
{
	settype($item, "string");
	$item_size = strlen($item);


	$tmp = "";
	for ($i=0; $i < $item_size; $i++)
	{
		$ch = ord($item[$i]);
		if ($ch === 0)
		{
			continue;
		}
		$tmp.="\x".sprintf("%02x", $ch);
	}


//	$tmp = @addslashes($item); // для 0 пораждает \0 что не приемлемо для postgres, а так же не обрабатывает \r и \n

/*
	$tmp1 = @pg_escape_string($item); // не обрабатывает \r и \n
	$tmp2 = @str_replace(chr(hexdec("0a")), '\r', $tmp1);
	$tmp3 = @str_replace(chr(hexdec("0d")), '\n', $tmp2);
	$tmp  = $tmp3;
*/

	return $tmp;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
