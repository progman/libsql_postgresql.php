//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__query_view()
{
	$result = new result_t(__FUNCTION__, __FILE__);


	global $GLOBAL_SQL_STR_LIST;
	global $GLOBAL_SQL_COUNT;


	if ($GLOBAL_SQL_STR_LIST != '')
	{
//		echo '<pre>';
//		echo msg_convert_in($GLOBAL_SQL_STR_LIST);
		echo $GLOBAL_SQL_STR_LIST;
//		echo '</pre>';
		echo '<hr />';
		echo '<span class="strong">Total sql query: '.$GLOBAL_SQL_COUNT.'</span><br /><br />';
	}
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
