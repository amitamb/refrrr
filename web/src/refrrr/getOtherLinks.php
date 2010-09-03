<?php 

require_once("framework/request.php");
require_once("collections/HNLinks.php");

// get other links and return
$url = requestParam(URL);

$parsedUrl = parse_url($url);

if ($parsedUrl["host"] == "news.ycombinator.com")
{
	$hnLink = HNLinks::getByCommentsUrl($url);
	
	if ($hnLink["commentsUrl"] != $hnLink["url"])
	{
		$retVal = array("pageUrl" => $hnLink["commentsUrl"], "otherLinkUrl" => $hnLink["url"], "otherLinkTitle" => "Article");
	}
	else
	{
		$retVal = null;
	}
}
else
{
	$hnLink = HNLinks::getByUrl($url);
	$retVal = array("pageUrl" => $hnLink["url"], "otherLinkUrl" => $hnLink["commentsUrl"], "otherLinkTitle" => "Comment");
}

print json_encode($retVal);

?>
