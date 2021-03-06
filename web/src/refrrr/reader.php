<html>
<head>

<title>Sess.in - Making web sessions better</title>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 

<!--
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
-->

<script type="text/javascript" src="js/jquery.min.js"></script>

<script type="text/javascript" src="js/supporting.js" ></script>
<script type="text/javascript" src="js/dragDrop.js" ></script>
<script type="text/javascript" src="js/init.js" ></script>

<script type="text/javascript" src="js/CommonLinksManager.js" ></script>
<script type="text/javascript" src="js/FrameManager.js" ></script>
<script type="text/javascript" src="js/LinksManager.js" ></script>
<script type="text/javascript" src="js/UserSettingsManager.js" ></script>
<script type="text/javascript" src="js/SessionData.js" ></script>
<script type="text/javascript" src="js/Communicator.js" ></script>
<script type="text/javascript" src="js/menu.js" ></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-15652129-3']);
  _gaq.push(['_setDomainName', '.sess.in']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">

linkDroppedEventHandler = function(dropEventData)
{
	//alert("P");
	var direction = getDropDirection(dropEventData.x, dropEventData.y, lastKnownMouseX, lastKnownMouseY);
	
	var url = dropEventData.url;
	var text = dropEventData.text;
	var actualUrl = null;
	if (url == null || url == "")
	{
		// try using text
		if (text == null || text == "")
		{
			// this is major problem
			alert("Drop failed.");
		}
		else
		{
			if (isUrl(text))
			{
				actualUrl = text;
			}
			else
			{
				actualUrl = userSettingsManager.getSearchUrl(encodeURIComponent(text));
			}
		}
	}
	else
	{
		actualUrl = getActualUrl(url);
	}

	if (dropEventData.parentElementId == "linksListParent")
	{
		var nLink = new Link(actualUrl, frameManager.getCurrentUrl());
		
		if (direction == dropDirection.RB)
		{
			var linkDivId = linksManager.addLinkAndSelect(nLink);
		}
		else
		{
			var linkDivId = linksManager.addLink(nLink);
		}
	}
	else if (dropEventData.parentElementId == "commonLinksParent")
	{
		var commonLink = new CommonLink(actualUrl);
		commonLinksManager.addCommonLink(commonLink);
	}
};

</script>

<link href="reader.css" media="screen" rel="stylesheet" type="text/css" />

</head>
<body onload="">
<div id="crazyOLLeft" onmousemove="OLMouseMove(event, this)"  ondrop="fnHandleDrop(event)" ondragover="fnCancelDefault(event)" ondragenter="fnHandleDragEnter(event)" ></div>
<div id="crazyOLRight" onmousemove="OLMouseMove(event, this)"  ondrop="fnHandleDrop(event)" ondragover="fnCancelDefault(event)" ondragenter="fnHandleDragEnter(event)" ></div>
<div id="bodyDiv">
<table id="topTable">
	<tr id="bottomWhiteSpaceForChrome">
		<td id="bottomPrevTd" rowspan="2">
			<button id="prevButton" onclick="linksManager.prev()"><</button>
		</td>	
		<td colspan="3">
			<!--
				<a id="sharelink" href="#">Share current tabs</a>
			-->
			&nbsp;
			<input type="text" id="statusUrl"></input>
		</td>
		<td id="bottomNextTd" rowspan="2">
			<button id="nextButton" onclick="linksManager.next()">></button>
		</td>
	</tr>
	<tr>	
	    <td id="bottomLeftTd" style="width:70px;">
			<button id="logoIcon" style="width:70px;height:30px;" onclick="showSessionMenu(this, event)">
				Session&darr;
			</button>
	    </td>
	    <td id="bottomTd">
			<div id="linksListParentBottom">
                <!--Tabs should come here-->
			</div>
			<span id="plusButton" onclick="plusButtonClick(this, event)">
				+
			</span>
		</td>
		<td id="bottomRightTd">
			<a id="viewSessionLink" href="index.php" target="_blank">
                <img id="rightBottomLogo" src="images/sessin.png" />
            </a>
		</td>

	</tr>
	<tr>
		<td id="lefttd">
			<div id="leftDiv">
				<div id="leftDivContent">
					<div id="dummy" style="position:relative;top:0px;left:0px;width:100%;height:100%;">
					<input id="overlayDropText" type="text" value="" />
					<table>
						<tr style="height:20px;">
							<td id="commonLinksTd">
								<span id="commonLinksTitle">Common Links</span><br/>
								<div id="commonLinksParent">
									<!-- Common links -->
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="linksListParent">
									<!-- Following nbsp is a hack to make drag drop work in chrome / It was with &nbsp; along with overlayDropText -->
									<div id="dummyLinkDiv" class="link"  onclick="">
										<a href="#">
										<table>
											<tr>
											<td rowspan="2">
												<div class="icon"> <img src="http://localhost/favicon.ico" alt="favicon" /></div>
											</td>
											<td class='titleTd'>
												<span class="title">This is title of the frame</span>
											</td>
											</tr>
											<tr>
											<td>
												<span class="removeLink otherLink">Remove</span>
												<span class="commentLink otherLink">Comment</span><br>
											</td>
											</tr>
										</table>
										</a>
									</div>
								</div>
							</td>
						</tr>
					</table>
					</div>
				</div>
			</div>
		</td>
		<td id="righttd" colspan="5">
			<div id="navigFrameParent">
				<div id="gotoParentButton" onclick="linksManager.goUp(false);">&nbsp;</div>
				<div id="gotoParentAndCloseButton" onclick="linksManager.goUp(true);">&nbsp;</div>
<!--
		<iframe name="searchFrame" id="searchFrame" src="about:blank"></iframe>
-->
			</div>
		</td>
	</tr>
</table>
</div>

<!---
Following are some extra divs that can be used 
for showing some menus etc.
-->
<div id="sessionMenu" class="floatDiv">
<ul>
<!--
<li><a id="resetlink" href="#"><img src="images/close.gif" />Close All Tabs</a></li>
-->
<li><a id="sharelink" href="#"><img src="images/share.gif" />Share</a></li>
<li><a id="viewlink" href="#"><img src="images/list.png" />View</a></li>
<li><a id="historylink" href="#"><img src="images/history.png" />History</a></li>
</ul>
</div>

<div id="otherLinkLinkDiv">
Show other link
</div>

<div id="backgroundForDialog" class="floatDiv" onclick="hideBackgroundForDialog();hideDialogFn();">
<!--
Background when some doalog is shown to user
-->
</div>
</body>
<script>

//////////////////////
// This is old
//////////////////////

//var sessionData = new SessionData("http://www.google.com/search?q=india");
var communicator = new Communicator();
//var userSettingsManager = new UserSettingsManager();
//var sessionData = new SessionData("http://localhost:8000/greader/static/oldReader/Hacker News.html");
//var sessionData = new SessionData("http://news.ycombinator.com/");
//var sessionData = new SessionData("http://www.techcrunch.com/");
var sessionData = new SessionData();
var frameManager = new FrameManager();
var linksManager = new LinksManager("linksListParentBottom");

//frameManager.navigateTo("http://news.ycombinator.com/");
frameManager.navigateTo(sessionData.getParentUrl());


var cntr = 1;

function testFunction()
{
	cntr = cntr + 1;
	
	document.title= cntr;
}

//overlayDropText.onmousedown=testFunction;


var viewSquareSize = 7;

function getLeftOL()
{
	return document.getElementById("crazyOLLeft");
}

function getRightOL()
{
	return document.getElementById("crazyOLRight");
}


// This function is called when the user 
//  initiates a drag-and-drop operation.
function fnHandleDragStart(event)
{                                      
  var oData = event.dataTransfer;

  // Set the effectAllowed on the source object.
  oData.effectAllowed = "move";
}

// This function is called by the target 
//  object in the ondrop event.
function fnHandleDrop(event)
{
	//var oTarg = window.event.srcElement;
	var oData = event.dataTransfer;

	// Cancel default action.
	fnCancelDefault(event);

	x = event.clientX;
	y = event.clientY;
	url = oData.getData("URL");
	text = oData.getData("Text");
	
	linkDroppedEventHandler(new DropEventData(x, y, url, text));
}

// This function sets the dropEffect when the user moves the 
//  mouse over the target object.
function fnHandleDragEnter(event)
{
  var oData = event.dataTransfer;

  // Cancel default action.
  fnCancelDefault(event);

  // Set the dropEffect for the target object.
  oData.dropEffect = "move";
}

function fnCancelDefault(event)
{
  // Cancel default action.
  if (event.stopPropagation)
    event.stopPropagation();
  if (event.preventDefault)
    event.preventDefault();
  event.returnValue = false;
}

/*
if (getBrowser() == "chrome" || getBrowser() == "safari" || getBrowser() == "firefox")
{
	$("#crazyOLLeft").replaceWith("<div id=\"crazyOLLeft\" onmousemove=\"OLMouseMove(event, this)\"  ondrop=\"fnHandleDrop(event)\" ondragover=\"fnCancelDefault(event)\" ondragenter=\"fnHandleDragEnter(event)\" ></div>");
	$("#crazyOLRight").replaceWith("<div id=\"crazyOLRight\" onmousemove=\"OLMouseMove(event, this)\" ondrop=\"alert('great');fnHandleDrop(event);\" ondragover=\"fnCancelDefault(event)\" ondragenter=\"fnHandleDragEnter(event)\" ></div>");

}
*/

var leftOL = document.getElementById("crazyOLLeft");
var rightOL = document.getElementById("crazyOLRight");


function rightOLMouseMove(event, rightOL)
{
	//alert("move");
	//alert(event);
	
}

function rightDrop(eventData, rightText)
{
	//var url = rightText.value;
	
	x = 0;
	y = 0;
	url = rightOL.value;
	
	linkDroppedEventHandler(new DropEventData(x, y, url));
	
	rightOL.value = "";

	//document.getElement
}

//rightOL.ondrop = rightDrop;

if (getBrowser() == "firefox")
{
	//rightOL.ondrop = rightDrop;
}


var clientWidth = rightOL.clientWidth;


var lastResizeX = 0;

var lastKnownMouseX, lastKnownMouseY;

function OLMouseMove(event, sourceElem)
{
	//alert("move");
	//alert(event);
	//var leftOL = document.getElementById("crazyOLLeft");
	//var rightOL = document.getElementById("crazyOLRight");
	
	var X = event.clientX;
	var Y = event.clientY;
	
	lastKnownMouseX = X;
	lastKnownMouseY = Y;
	
	//if (lastResizeX >= X || (X - (lastResizeX - viewSquareSize)) >= 0)
	
	var stepFractionLeft = (X % viewSquareSize);
	var stepFractionRight = (viewSquareSize - stepFractionLeft);

	var leftWidth = X - stepFractionLeft;
	var rightWidth = (clientWidth - X) - stepFractionRight;
	
	if (rightWidth < 0)
	{
		rightWidth = 0;
	}
	
	if (leftWidth < 0)
	{
		leftWidth = 0;
	}
		
	rightOL.style.width = rightWidth+'px';
	leftOL.style.width = leftWidth+'px';
	
	//alert(rightWidth);
	//alert(leftWidth);

/*
	if (sourceElem.id == "crazyOLLeft")
	{
		var newX = X - (viewSquareSize - (X % viewSquareSize));

		rightOL.style.width = (rightOL.clientWidth + viewSquareSize) + "px";
		leftOL.style.width = (leftOL.clientWidth - viewSquareSize) + "px";
	}
	else
	{
		//var newX = X + (viewSquareSize - (X % viewSquareSize));
		
		rightOL.style.width = (rightOL.clientWidth - viewSquareSize) + "px";
		leftOL.style.width = (leftOL.clientWidth + viewSquareSize) + "px";
	}
	
*/
	
	//rightOL.style.width = (newX + viewSquareSize)+'px';
	//rightOL.style.width = (newX + viewSquareSize)+'px';
	//leftOL.style.width = (newX - viewSquareSize)+'px';
}

function plusButtonClick(thisObj, eventData)
{
	var randomnumber=Math.floor(Math.random()*100000);
	var newUrl = "http://www.google.com/webhp?" + randomnumber;
	// TODO
	// userSettingsManager.getDefaultOriginUrl();
	var nLink = new Link(newUrl , frameManager.getCurrentUrl());
	linksManager.addLinkAndSelect(nLink);
}

var dropDirection = {
    RT : 0,
    RB : 1,
    LT : 2,
    LB : 3
}

function getDropDirection(destX, destY,  sourceX, sourceY)
{	
	if (destX > sourceX)
	{
		// right
		if (destY > sourceY)
		{
			// bottom
			retval = dropDirection.RB;
		}
		else
		{
			// top
			retval = dropDirection.RT;
		}
	}
	else
	{
		// left
		if (destY > sourceY)
		{
			// bottom
			retval = dropDirection.LB;
		}
		else
		{
			// top
			retval = dropDirection.LT;
		}
	}
	
	return retval;
}

</script>
</html>
