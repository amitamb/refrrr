<?php

require_once("framework/request.php");
require_once("framework/json.php");
require_once("collections/Session.php");

$sharedSession = Session::shareSession();

$sharedSessionLink = "reader.php?id=".$sharedSession[ID];

$sharedSessionLink = InternetCombineUrl(getCurrentUrl() , $sharedSessionLink);

function showDefaultLink($linkUrl)
{
	$faviconUrl = "http://s2.googleusercontent.com/s2/favicons?domain=".$parsedUrl["host"];
	print "<div class='defaultLinkDiv'><img src='$faviconUrl' /><a href='$linkUrl' target='_blank'>$linkUrl</a></div>";
}

function InternetCombineUrl($absolute, $relative) {
	$p = parse_url($relative);
	if($p["scheme"])return $relative;
	
	extract(parse_url($absolute));
	
	$path = dirname($path); 

	if($relative{0} == '/') {
		$cparts = array_filter(explode("/", $relative));
	}
	else {
		$aparts = array_filter(explode("/", $path));
		$rparts = array_filter(explode("/", $relative));
		$cparts = array_merge($aparts, $rparts);
		foreach($cparts as $i => $part) {
			if($part == '.') {
				$cparts[$i] = null;
			}
			if($part == '..') {
				$cparts[$i - 1] = null;
				$cparts[$i] = null;
			}
		}
		$cparts = array_filter($cparts);
	}
	$path = implode("/", $cparts);
	$url = "";
	if($scheme) {
		$url = "$scheme://";
	}
	if($user) {
		$url .= "$user";
		if($pass) {
			$url .= ":$pass";
		}
		$url .= "@";
	}
	if($host) {
		$url .= "$host/";
	}
	$url .= $path;
	return $url;
}

function getCurrentUrl() 
{
	// Checks scheme.
	$url = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';	
	// Checks port.
	$url .= ($_SERVER['SERVER_PORT'] != '80') ? $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'] : $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
 
	// Returns full URL.
	return $url;
}

?>


<link rel="stylesheet" type="text/css" href="css/base.css">
<style>
body{margin-left:auto;margin-right:auto;width:940px;font-size:100%;}
#topMessage{}
.defaultLinkDiv{margin:20px;}
.defaultLinkDiv a{margin:20px;color:#444;}
.imgDiv{display:inline-block;margin:20px;width:100%;text-align:center;}
.imgDiv img{border:0px;}
.youtubeVideoDiv{margin:20px;}

.title {font-size:180%;}
#sharedSessionLinkText{font-size:130%;width:80%;background-color:lightblue;}

</style>
<span class="title">Share Session</span>
<h2>
Use following <a href="<?php echo $sharedSessionLink; ?>">link</a> for sharing.
</h2>

<input type="text" id="sharedSessionLinkText" value="<?php echo $sharedSessionLink; ?>" onmouseup="this.select()" />
<h2>
It conains following links
</h2>
<?php 

foreach ($sharedSession[TAB_LINKS] as $link)
{
	$linkUrl = $link[URL];
	showDefaultLink($linkUrl);
}

?>
<script>
document.getElementById("sharedSessionLinkText").select();
</script>
