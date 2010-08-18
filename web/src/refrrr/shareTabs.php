<?php

require_once("framework/request.php");
require_once("framework/json.php");
require_once("collections/Session.php");

$sharedSession = Session::shareSession();

?>


<link rel="stylesheet" type="text/css" href="css/base.css">
<style>
body{margin-left:auto;margin-right:auto;width:940px;font-size:14px;}
#topMessage{}
.defaultLinkDiv{margin:20px;}
.defaultLinkDiv a{margin:20px;color:#444;}
.imgDiv{display:inline-block;margin:20px;width:100%;text-align:center;}
.imgDiv img{border:0px;}
.youtubeVideoDiv{margin:20px;}
</style>
<h2>
<a href="reader.php?id=<?php echo $sharedSession[ID]; ?>">Use this link</a> for sharing.
</h2>
It contains following links

<ul>
<?php 

foreach ($sharedSession[TAB_LINKS] as $link)
{
	$linkUrl = $link[URL];
	print "<li>";
	print "<a href='$linkUrl'>$linkUrl</a>";
	print "</li>";
}

?>
</ul>
