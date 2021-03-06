<?php
	
	if (empty($_GET))
	{
		echo "fail";
	}
	
	/**
	 * 得到客户端IP
	 * @param $long
	 */
	function getClientIP($long=FALSE)
	{
		if (isset($_SERVER))
		{
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			else if (isset($_SERVER["HTTP_CLIENT_IP"]))
			{
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			}
			else
			{
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		}
		else
		{
			if (getenv("HTTP_X_FORWARDED_FOR"))
			{
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			}
			else if (getenv("HTTP_CLIENT_IP"))
			{
				$realip = getenv("HTTP_CLIENT_IP");
			}
			else
			{
				$realip = getenv("REMOTE_ADDR");
			}
		}
		if ($long)
		{
			return ip2long($realip);
		}
		return addslashes($realip);
	}
	date_default_timezone_set('PRC');
	$clientIP = getClientIP();
	$string = "new log from ---> " . $clientIP . "   time ---> " . date("H:m:s") . "\r\n";
	$today = date("Ymd") . ".log";
	try
	{
		$log_file = fopen($today, "a");
		$data = urldecode(key($_GET));
		$string = ereg_replace("&", "\r\n", $data);
		fwrite($log_file, $string);
		fclose($log_file);
		echo "success";
	}
	catch (Exception $e)
	{
		var_dump($e-> getMessage());
		echo "fail";
	}
?>