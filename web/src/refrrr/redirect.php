<?

$host = substr($_GET["host"], 0, -1);
$path = $_GET["path"];
$queryString = $_GET["queryString"];

$finalUrl = "http://".$host.$path;

if ($queryString != "")
{
	$finalUrl .= "?".$queryString;
}

//print $finalUrl;

header("location:http://www.sess.in/reader?o=".urlencode($finalUrl));

?>
