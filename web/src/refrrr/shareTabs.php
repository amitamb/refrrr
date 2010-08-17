<?php

require_once("framework/request.php");
require_once("framework/json.php");
require_once("collections/Session.php");

$sharedSession = Session::shareSession();

?>


Use following link to share tabs

<br />
<h2>
<a href="reader.php?id=<?php echo $sharedSession[ID]; ?>">Use this link</a>
</h2>
<br />
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
