//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__query($sql_handle, $sql_tag, $sql_str, $rc_target)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	global $GLOBAL_SQL_STR_LIST;
	global $GLOBAL_SQL_COUNT;


	$flag_log_sql = libcore__get_var_flag("FLAG_LOG_SQL", "0");


	if ($flag_log_sql == '1')
	{
		libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.log", $sql_str."\n");
	}


	$GLOBAL_SQL_COUNT = $GLOBAL_SQL_COUNT + 1;


	$time1 = microtime();

	$sql_result = @pg_query($sql_handle, $sql_str);

	$time2 = microtime();
	list($usec1, $sec1) = explode(" ", $time1);
	list($usec2, $sec2) = explode(" ", $time2);
	$work_time = (($sec2 - $sec1) * 1000000) + intval($usec2 * 1000000) - intval($usec1 * 1000000);


	if ($sql_result !== false)
	{
		if ($flag_log_sql == '1')
		{
			$out = time().' '.$work_time.' '.$sql_tag.' '.bin2hex($sql_str)."\n";
			libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.stat.log", $out);
		}
	}
//	else
//	{
//		libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.err", $sql_str."\n".libsql__error($sql_handle)."\n\n\n");
//	}
	if ($sql_result === false)
	{
		libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.err", $sql_str."\n".libsql__error($sql_handle)."\n\n\n");
	}


	$flag_debug_sql = libcore__get_var_flag("flag_debug_sql", "0");
	if (libcore__is_flag_set($flag_debug_sql) === true)
	{
		$sql_str = drop_sql_comment($sql_str);
		$sql_str = msg_convert_in($sql_str);
		$GLOBAL_SQL_STR_LIST=$GLOBAL_SQL_STR_LIST.'<hr />'.'&nbsp;<span class="strong">'.$rc_target->get_function_name().'</span>: '.$work_time.'<br />&nbsp;'.$sql_str.';';
	}


	return $sql_result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
