<?php

require_once("framework/request.php");
require_once("framework/json.php");
require_once("collections/Session.php");

$session = Session::getSessionById();

function getQueryParams($queryString)
{
	$var  = html_entity_decode($queryString);
	$var  = explode('&', $var);
	$arr  = array();

	foreach($var as $val)
	{
		$x          = explode('=', $val);
		$arr[$x[0]] = urldecode($x[1]);
	}

	return $arr;
}

function showDefaultLink($linkUrl, $parsedUrl)
{
	$faviconUrl = "http://s2.googleusercontent.com/s2/favicons?domain=".$parsedUrl["host"];
	print "<div class='defaultLinkDiv'><img src='$faviconUrl' /><a href='$linkUrl' target='_blank'>$linkUrl</a></div>";
}

function showYoutubeLink($linkUrl, $parsedUrl)
{
	$youtubeEmbedText = '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/%1$s?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/%1$s?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed></object>';
	$params = getQueryParams($parsedUrl["query"]);

	//var_dump($params);

	if (isset($params["v"]))
	{
		//$youtubeEmbedText = "Red";
		$videoId = $params["v"];
		print("<div class='youtubeVideoDiv'>");
		printf($youtubeEmbedText, $videoId);
		print("</div>");
	}
	else
	{
		showDefaultLink($linkUrl, $parsedUrl);
	}
}

// http://www.google.com/imgres?imgurl=http://www.topnews.in/files/KatrinaKaif.jpg&
//imgrefurl=http://www.topnews.in/katrina-kaifs-success-journey-barnet-bollywood-2177407&
//usg=__dB-28XLJkt6B_0NcuhpXTd5NhTI=&
//h=400&
//w=400&
//sz=37&hl=en&start=0&tbnid=uiU_5du_THcTCM:&tbnh=139&tbnw=136&prev=/images%3Fq%3Dkatrina%2Bkaif%26um%3D1%26hl%3Den%26safe%3Doff%26sa%3DX%26biw%3D1360%26bih%3D606%26tbs%3Disch:1&um=1&itbs=1&iact=hc&vpx=845&vpy=251&dur=276&hovh=225&hovw=225&tx=102&ty=125&ei=6UhlTJzpJIqqvQOD2ZzfDA&oei=6UhlTJzpJIqqvQOD2ZzfDA&esq=1&page=1&ndsp=24&ved=1t:429,r:13,s:0
function showGoogleImageLink($linkUrl, $parsedUrl)
{
	$params = getQueryParams($parsedUrl["query"]);
	
	$imgurl = $params["imgurl"];
	$imgrefurl = $params["imgrefurl"];
	$h = intval($params["h"]);
	$w = intval($params["w"]);
	
	if ($w > 900)
	{
		$wd = 900;
		$scalingFactor = $wd / ($w * 1.0);
	}
	else
	{
		$wd = $w;
		$scalingFactor = 1.0;
	}
	
	$ht = $h * $scalingFactor;
	
/*
	$ht = 300.0;
	
	$scalingFactor = $ht / ($h * 1.0);

	$wd = $w * $scalingFactor;
*/
	
	printf('<div class="imgDiv"><a href="%1$s" target="_blank"><img src="%1$s" alt="" width="%2$d" height="%3$d" /></a></div>', $imgurl, $wd, $ht);
}

function showImageLink($linkUrl, $parsedUrl)
{
	$params = getQueryParams($parsedUrl["query"]);
	
	$imgurl = $linkUrl;
	$ht = 200;
	$wd = 200;
	
	printf('<div class="imgDiv"><a href="%1$s" target="_blank"><img src="%1$s" alt="" width="%2$dpt" height="%3$dpt" /></a></div>', $imgurl, $wd, $ht);
}

?>

<script type="text/javascript" src="js/supporting.js" ></script>

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
</style>
<div id="topMessage">
<span class="title">View Session</span>
</div>
<?php

//var_dump($session);

foreach ($session[TAB_LINKS] as $link)
{
	$linkUrl = $link[URL];
	print "<div>";
	$parsedUrl = parse_url($linkUrl);
	//var_dump($parsedUrl);
	
	$lcPath = strtolower($parsedUrl["path"]);

	// http://www.youtube.com/watch?v=saalGKY7ifU
	if ($parsedUrl["host"] == "www.youtube.com")
	{
		showYoutubeLink($linkUrl, $parsedUrl);
	}
	// http://t1.gstatic.com/images?q=tbn:ANd9GcRxotCpzlqMnuIlxGZkQpY4bE7B70sj6SXbZQ1Vv4MKr_9jnik&t=1&usg=__QWIP8L9tEwDjx8Gf1sjTPoWfbJA=
	else if (($parsedUrl["host"] == "www.google.com" || $parsedUrl["host"] == "www.google.co.in" || $parsedUrl["host"] == "www.google.co.uk") 
	&& $parsedUrl["path"]=="/imgres")
	{
		showGoogleImageLink($linkUrl, $parsedUrl);
	}
	else if (strstr($lcPath, ".jpg") || strstr($lcPath, ".png") || strstr($lcPath, ".gif"))
	{
		showImageLink($linkUrl, $parsedUrl);
	}
	else
	{
		showDefaultLink($linkUrl, $parsedUrl);
	}
	print "</div>";
}
?>
