////////////////
// For Chrome which doesn't seem to support drop
////////////////
var dropTrackerId=-1;
var curDropX, curDropY;

function dropTracker()
{
	var overlayDropText = document.getElementById("overlayDropText");

	if (overlayDropText.value != "")
	{
		clearInterval(dropTrackerId);
		dropTrackerId = -1;
		var url = overlayDropText.value;
		overlayDropText.value = "";
		linkDropped(curDropX, curDropY, url);
	}
}

function overlayDropTextDragEnter(event)
{
	curDropX = event.clientX;
	curDropY = event.clientY;

	linkEnter(curDropX, curDropY);
	linkDragging(curDropX, curDropY);

	if ((getBrowser() == "chrome" || getBrowser() == "safari") && dropTrackerId == -1)
	{
		dropTracker();
		dropTrackerId = setInterval(dropTracker, 20);
	}
	
}

function overlayDropTextDragOver(event)
{
	curDropX = event.clientX;
	curDropY = event.clientY;

	linkDragging(curDropX, curDropY);
}

function overlayDropTextDragLeave(event)
{
	if (dropTrackerId != -1)
	{
		clearInterval(dropTrackerId);
		dropTrackerId = -1;
	}

	linkExit();
}

///////////////
// Not used for now
// Will be used in future if decided to use ondrop
// but ondrop does not work in chrome
function overlayDropTextDragdrop(event)
{
	var overlayDropText = document.getElementById("overlayDropText");
	var url = overlayDropText.value;
	overlayDropText.value = "";
	linkDropped(event.clientX, event.clientY, url);	
}

function hideOverlayText()
{
	var overlayDropText = document.getElementById("overlayDropText");
	
	overlayDropText.style.visibility = 'hidden';
}

function showOverlayText()
{
	var overlayDropText = document.getElementById("overlayDropText");
	
	overlayDropText.style.visibility = 'visible';
}

//////////////////////////////////
// Following functions will be called
// at appropriate times
//////////////////////////////////
linkEnterEventHandler = function(){};
linkDraggingEventHandler = function(){};
linkExitEventHandler = function(){};
linkDroppedEventHandler = function(){};

var xOffset;
var yOffset;

function linkEnter(x, y)
{
	xOffset = document.getElementById("dummy").offsetLeft;
	yOffset = document.getElementById("dummy").offsetTop;

	//document.title = "Enter";
	
	linkEnterEventHandler(x, y);
}

function linkDragging(x, y)
{
	x = x - xOffset;
	y = y - yOffset;
	
	showDebug(x +","+y);
	linkDraggingEventHandler(x, y);
}

function linkExit()
{
	// document.title = "Exit";
	linkExitEventHandler();
}

function linkDropped(x, y, url)
{
	x = x - xOffset;
	y = y - yOffset;

	linkDroppedEventHandler(new DropEventData(x, y, url));
}

function DropEventData(x, y, url)
{
	this.x = x;
	this.y = y;
	this.url = url;
	
	// now find on which element this link was drag dropped

/*	
	// if inside linksListParent
	var linksListParentOffset = $("#" + "linksListParent").offset();
	
	if ( y >= linksListParentOffset.top && x >= linksListParentOffset.left)
	{
		parentElementId = "linksListParent";
	}
	else
	{
		var commonLinksParentOffset = $("#" + "commonLinksParent").offset();
		
		if (y >= commonLinksParentOffset.top && x >= commonLinksParentOffset.left)
		{
			parentElementId = "commonLinksParent";
		}
		else
		{
			parentElementId = "unknown";
		}
	}
*/

	parentElementId = "linksListParent";
	
	// if inside commonLinksParent
	this.parentElementId = parentElementId;
}
