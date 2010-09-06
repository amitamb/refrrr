<?php

require_once("framework/request.php");
require_once("framework/json.php");
require_once("collections/Session.php");

$session = Session::getSessionById(true);

function showHistoryLink($link, $parsedUrl)
{
	$faviconUrl = "http://s2.googleusercontent.com/s2/favicons?domain=".$parsedUrl["host"];
	$linkUrl = $link[URL];
	$linkCreatedAtDate = date("M d Y ",$link[CREATED_AT]);
	print "<div class='historyLinkDiv'><span class='date'>$linkCreatedAtDate</span><img src='$faviconUrl' /><a href='$linkUrl' target='_blank'>$linkUrl</a></div>";
}

?>
<title>Session History</title>

<script type="text/javascript" src="js/supporting.js" ></script>

<link rel="stylesheet" type="text/css" href="css/base.css">
<style>
body{margin-left:auto;margin-right:auto;width:940px;font-size:100%;}
#topMessage{}
.historyLinkDiv{margin:15px;}
.historyLinkDiv .date{margin-right:10px;}
.historyLinkDiv a{margin:20px;color:#444;}
.imgDiv{display:inline-block;margin:20px;width:100%;text-align:center;}
.imgDiv img{border:0px;}
.youtubeVideoDiv{margin:20px;}

.title {font-size:180%;}
</style>
<div id="topMessage">
<span class="title">Session History</span>
</div>
<?php

$len = count($session[LINKS_HISTORY]);

for ($i = $len - 1; $i >= 0; $i--)
{
	$link = $session[LINKS_HISTORY][$i];
	print "<div>";
	showHistoryLink($link, $parsedUrl);
	print "</div>";
}

?>
