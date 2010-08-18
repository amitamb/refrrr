<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Sess.in - Better web sessions</title>
<link rel="stylesheet" type="text/css" href="css/reset-fonts-grids.css">
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/sessin-general.css">
<link rel="stylesheet" type="text/css" href="css/index.css">

<link rel="search" type="application/opensearchdescription+xml" title="Sess.in" href="plugin/SessinSearchPlugin.xml">

<script>
function installSearchEngine() {
	alert('sd');
 if (window.external && ("AddSearchProvider" in window.external)) {
   // Firefox 2 and IE 7, OpenSearch
   
   window.external.AddSearchProvider("http://sess.in/plugin/SessinSearchPlugin.xml");
 } else if (window.sidebar && ("addSearchEngine" in window.sidebar)) {
   // Firefox <= 1.5, Sherlock
   //window.sidebar.addSearchEngine("http://example.com/search-plugin.src",
                                  //"http://example.com/search-icon.png",
                                  //"Search Plugin", "");
	alert("No search engine support");
 } else {
   // No search engine support (IE 6, Opera, etc).
	alert("No search engine support");
 }
}
</script>

</head>
<body>
<div id="doc4" class="yui-t7">
	<div id="hd">
		<!-- PUT MASTHEAD CODE HERE -->
		<img id="topLogo" src="images/sessin.png" />
		<h2>Share, save and organize your web sessions.</h2>
		<!--
		alert('ex');
		-->
		<div id="mainTip"><img src="images/tip.jpg" /><span id="message">Remember don't click, just drag <a href="#" onclick="return false;">links</a><br /><a id="exampleLink" href="#" onclick="return false;" onmouseover="document.getElementById('dragDemo').style.display = 'inline';" onmouseout="document.getElementById('dragDemo').style.display = 'none';">See Example</a><br /><img id="dragDemo" src="images/dragDemo.gif" /></span></div>
		<br />
		<br />
		<br />
	</div>
	<div id="bd">
		<div id="yui-main">
			<div class="yui-b">
				<!-- PUT MAIN COLUMN CODE HERE -->
				<div id="startSessionNavig">
				<p>Enter a URL or search term to start.</p>
				<form action="reader.php">
				<input type="text" value="http://www.google.com/" name="o" id="o"></input>
				<button>Visit</button>
				<br />
				<span style="font-size:70%;"><i>This session will be stored in this browser.</i></span>
				</form>
				</div>
				<div id="addSearchBox">
					<a href="#" onclick="installSearchEngine(); return false;">Add Sess.in with Google</a>
				</div>
				<div id="subscribeDiv">
					Get informed when there is bigger release
					<form action="subscribe.php">
					Email: <input type="text" value="" name="email" id="email"></input>
					<button>Submit</button>
					<br />
					<span style="font-size:70%;"><i>Your email is safe with us.</i></span>
					<br />
					</form>
				</div>
			</div>
		</div>
		<div class="yui-b">
			<!-- PUT SECONDARY COLUMN CODE HERE -->
			
		</div>
	</div>
	<div id="ft">
		<!-- PUT FOOTER CODE HERE -->
	</div>
</div>
</body>
<script>
var o = document.getElementById('o');
o.focus();
</script>
</html>
