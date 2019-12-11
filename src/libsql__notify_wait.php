//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
/**
 * wait postgresql notify
 * \param[in] value hex string
 * \param[in] flag_force always use it function
 * \return ok if ok
 */
function libsql__notify_wait($sql_handle, $timewait = 60, $timeout = 1000000)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$rc = function_exists("pg_socket"); // php < 5.6
	if ($rc === false)
	{
		usleep($timeout);
		return $result;
	}


	$rc = @pg_socket($sql_handle);
	if ($rc === false)
	{
		usleep($timeout);
		return $result;
	}
	$sock = $rc;


	$read   = array($sock);
	$write  = array();
	$except = array($sock);
	$rc = stream_select($read, $write, $except, $timewait);
	if ($rc === false)
	{
		usleep($timeout);
		return $result;
	}


	$result->set_ok();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
