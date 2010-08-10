<?php 

require_once("framework/request.php");
require_once("framework/json.php");
require_once("collections/Session.php");

print json_encode_mongoObj(Session::getOrCreateSessionByUrl());

?>
