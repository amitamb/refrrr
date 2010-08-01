<?php

function requestParam($param)
{
	$val = $_POST[$param];
	
	if ($val == null)
		return $_GET[$param];
	else
		return $val;
}

?>