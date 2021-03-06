<?php

define("METHOD", "method");
define("ERROR_MESSAGE", "errorMessage");

function getMethod()
{
	$method = requestParam("method");
	if ($method == null)
		return "index";
	
	return $method;
}

function redirectSuccess($location)
{
	header('location:'.$location);
	exit();
}

function redirectFailure($location, $message = NULL)
{
	header('location:'.$location);
	exit();
}

function showErrorMessage($message)
{
	print $message;	
}

?>