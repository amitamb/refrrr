<?php

function json_encode_mongoObj($mongoObj)
{
	$mongoObj["_id"] = (string)$mongoObj["_id"];
	$retVal = json_encode($mongoObj);
	
	return $retVal;
}

?>
