<?php 

require_once('collections/User.php');

$method = getMethod();

switch ($method) {
    case "index":
        break;
    default:
    	User::processMethod($method);
}

?>
