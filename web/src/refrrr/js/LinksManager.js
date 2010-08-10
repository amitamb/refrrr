function Link(url, referrer, isStaticTopLink)
{
	this.url = url;
	
	this.parentLink = referrer;
	
	this.isStaticTopLink = isStaticTopLink;
}

function LinksManager(linksListParentId, staticTopLink)
{
	this.tabWidth = 200;
	this.tabCount = 0;
	
	this.linksListParentId = linksListParentId;
	this.linksListParentElement = document.getElementById(linksListParentId);

	this.urlToLinkDivIdMap = Array();
	
	this.selectedLinkDivId = null;

	// private variables
	nextLinkDivId = 0;

	this.addLink = function(nLink, isStaticTopLink, dontContactServer)
	{
		var url = nLink.url; //dropEventData.url;
		
		if (staticTopLink)
		{
			alert('adding static top link');
		}
		else if (!this.doesUrlAlreadyAdded(url))
		{
			var linkDivId = this.getNextLinkDivId();

			var appendHtml = this.getAppendDivHTML(url, linkDivId);

			// this.linksListParentElement.innerHTML = this.linksListParentElement.innerHTML + appendHtml;
			
			var linksListParentObj = $("#"+linksListParentId).append(appendHtml);
			this.tabCount++;
			this.resetTabWidth();
			
			if (this.selectedLinkDivId == null)
			{
				// first tab added
				this.linkSelected(linkDivId);
			}

			this.addAllEventHandlers(linkDivId);

			frameManager.navigateTo(url, true);
						
			if (!dontContactServer)
			{
				communicator.addLink(sessionData.getId(), url);
			}
		}
		else
		{
			alert("Link already exists");
			// !!!!!!!!!!!
			// Error occured
			// !!!!!!!!!!!
			// Link already exists
			
			// no need to do anything
			// showStatusMessage("Link already exists");
			
			var linkDivObj = $("#" + this.urlToLinkDivIdMap[url]);
			
			alert(linkDivObj.addClass);

			// Start blinking
			linkDivObj.addClass("blink");

			window._blinkingDiv = linkDivObj;
			// Stop blinking in 1000 millis
			//setTimeout(function(){window._blinkingDiv.removeClass("blink")}, 500);
		}
	}
	
	this.removeLink = function(linkDivObj)
	{
		var url = linkDivObj.children("a:first").attr('href');
		var linkDivId = linkDivObj.attr('id');
		
		if (this.isLinkDivSelected(linkDivObj))
		{
			// no smart way found iterating through the array and finding the element 
			// to select when selected link is removed
			
			var idToSelect = null;
			var urlToSelect = null;
			var deletedDivFound = false;
			
			// divIdKey is a url
			for (var divIdKey in this.urlToLinkDivIdMap)
			{
				var currentDivId = this.urlToLinkDivIdMap[divIdKey];
				
				if (currentDivId == null)
				{
					// since I am not actually removing element just
					// setting it to null
					continue;
				}

				if ( currentDivId == linkDivId )
				{
					deletedDivFound = true;
				}
				else
				{
					idToSelect = currentDivId;
					urlToSelect = divIdKey;
					
					if (deletedDivFound == true)
					{
						break;
					}
				}
			}
			
			if (idToSelect != null && urlToSelect != null)
			{
				linksManager.linkSelected(idToSelect);
				frameManager.navigateTo(urlToSelect);
			}
		}
		
		this.urlToLinkDivIdMap[url] = null;		
		linkDivObj.remove();
		this.tabCount--;
		this.resetTabWidth();
		frameManager.removeFrame(url);
		
		// ask server to remove it
		communicator.removeLink(sessionData.getId(), url);
	}
	
	this.resetTabWidth = function()
	{
		var totalWidth = $(this.linksListParentElement).width();
			
		if (totalWidth < (this.tabWidth * this.tabCount) || this.tabWidth < 200)
		{
			// need to resize tab
			var newTabWidth = ((totalWidth) / this.tabCount) - 7;
			
			this.tabWidth = newTabWidth;
			$("div.link").width(this.tabWidth);
			$("span.title").width(this.tabWidth - 20);
		}
	}
	
	this.setTitleForUrl = function(url, title)
	{
		var linkDivId = this.getLinkDivIdForUrl(url);
		
		var titleObj = $("#"+linkDivId+" span[class='title']");
		
		titleObj.html(title);
	}
	
	function getTitleCallBack(linksManagerObj, url, title)
	{
		if (title != null)
		{
			linksManagerObj.setTitleForUrl(url, title);
		}
		else
		{
			// not decided
		}
	}
	
	this.getNextLinkDivId = function()
	{
		nextLinkDivId++;
		return "linkDiv" + nextLinkDivId;
	}
	
	this.doesUrlAlreadyAdded = function(url)
	{
		if (this.urlToLinkDivIdMap[url] == null)
		{
			return false;
		}
		
		return true;
	}
	
	this.getLinkDivIdForUrl = function(url)
	{
		return this.urlToLinkDivIdMap[url];
	}
	
	this.addLinkDivIdToMap = function(url, linkDivId)
	{
		this.urlToLinkDivIdMap[url] = linkDivId;
	}
	
	this.getLinkIdForUrl = function(url)
	{
		return this.urlToLinkDivIdMap[url];
	}
	
	this.addAllEventHandlers = function(linkDivId)
	{
		// Adding event handlers
		var linkDivObj = $("#"+linkDivId);
		
		linkDivObj.mousedown(this.linkMouseDown);
		
		linkDivObj.click(this.linkClick);
		
		//linkDivObj.mouseenter(this.linkMouseEnter);
		
		//linkDivObj.mouseleave(this.linkMouseLeave);
	}
	
	this.isLinkDivSelected = function(linkDivObj)
	{
		var retVal;
		//alert(linkDivObj.css("background-color"));

		if (linkDivObj.css("background-color") == "rgb(210, 225, 246)")
		{
			retVal = true;
		}
		
		return retVal;
	}
	
	this.linkMouseEnter = function(e)
	{
		var linkDivObj = $(this); //"#"+linkDivId);
		
		if (!linksManager.isLinkDivSelected(linkDivObj))
		{
			linkDivObj.css("background-color", "#EFFBFB");
			// #81BEF7
		}
	}
	
	this.linkMouseLeave = function(e)
	{
		var linkDivObj = $(this);
		
		if (!linksManager.isLinkDivSelected(linkDivObj))
		{
			linkDivObj.css("background-color", "transparent");
		}
	}
	
	this.linkSelected = function(linkDivId)
	{
		this.selectedLinkDivId = linkDivId;
		
		var linkDivObj = $("#"+linkDivId);
		
		this.deSelectAll();
		
		//linkDivObj.css("background-color", "#81BEF7");
		linkDivObj.css("background-color", "#d2e1f6");
		linkDivObj.css("border-style", "inset");
	}
	
	this.deSelectAll = function()
	{
		$("#"+linksListParentId).children("[class='link']").each(function(){$(this).css("background-color", "transparent");$(this).css("border-style", "outset");});
	}
	
	this.linkMouseDown = function(e)
	{
		var linkDivId = $(this).attr('id');
		var url = $(this).children("a:first").attr('href');
		
		var middleClick;
		if (e.which) middleClick = (e.which == 2);
		else if (e.button) middleClick = (e.button == 1);
		
		var leftClick;
		if (e.which) leftClick = (e.which == 1);
		else if (e.button) leftClick = (e.button == 0);
	
		if (leftClick)
		{
			linksManager.linkSelected(linkDivId);
			frameManager.navigateTo(url);
		}
		else if (middleClick)
		{
			linksManager.removeLink($(this));
		}
		
		//alert(this);
		
		//linksManager.linkSelected('"+linkDivId+"');return frameManager.navigateTo('"+ url +"');
	}
	
	this.linkClick = function(e)
	{
		//var url = $(this).children("a:first").attr('href');
		//var containsIFrameBuster = frameManager.doesFrameContainsIFrameBuster(url);
		//if (!containsIFrameBuster)
		//{
			e.preventDefault();
		//}
	}
	
	this.next = function()
	{
		//"linkDiv"
		// length = 7
		
		var currentIdNumber = parseInt(this.selectedLinkDivId.substr(7));
		
		for (var i=currentIdNumber+1; i<=nextLinkDivId; i++)
		{
			var linkDivId = "linkDiv"+i
			
			if (document.getElementById(linkDivId) == null)
			{
				continue;
			}
			else
			{
				this.linkSelected(linkDivId);
				var url = $("#"+linkDivId).children("a:first").attr('href');
				frameManager.navigateTo(url);
				break;
			}
		}
	}
	
	this.prev = function()
	{
		//"linkDiv"
		// length = 7
		
		var currentIdNumber = parseInt(this.selectedLinkDivId.substr(7));
		
		for (var i=currentIdNumber-1; i>0; i--)
		{
			var linkDivId = "linkDiv"+i
			
			if (document.getElementById(linkDivId) == null)
			{
				continue;
			}
			else
			{
				this.linkSelected(linkDivId);
				var url = $("#"+linkDivId).children("a:first").attr('href');
				frameManager.navigateTo(url);
				break;
			}
		}
	}
	
	alert("Hey");
	
	this.getAppendDivHTML = function(url, linkDivId)
	{
		var faviconUrl = getFaviconUrl(url);
		
		var commentUrl = "";
		var removeUrl = "";
		
		var title = "loading";
		var tooltipText = url;
		
		getTitleForUrl(url, getTitleCallBack, this);
		
		this.addLinkDivIdToMap(url, linkDivId);

		var text = "<div id='" + linkDivId + "' class='link'\">";
		text = text + "<a href='" + url + "' title='" + tooltipText + "' target='_blank'>";
		text = text + "<table><tr><td rowspan='2'>";
		text = text + "<div class='linkIcon'><img src='"+faviconUrl+"' alt=' ' /></div>";
		text = text + "</td>";
		text = text + "<td class='titleTd'>";
		text = text + "<span class='title'>"+title+"</span>";
		text = text + "<img class='closeButton' src='images/close_button.png' onclick=\"linksManager.removeLink($('#"+linkDivId+"')); return false;\" />";
		text = text + "</td>";
		text = text + "</tr>";
		
		text = text + "<tr>";
		text = text + "<td class='otherLinksTd'>";
		text = text + "<span class='removeLink otherLink' onclick=\"alert('Remove link');\">Remove</span>";
		text = text + "<span class='commentLink otherLink otherLinkSelected' onclick=\"alert('Show comments');\">Comments</span><br>";
											
		text = text + "</td>";
		text = text + "</tr>";
		text = text + "</table>";
		text = text + "</a>";	
		text = text + "</div>";	
		
		return text;
	}
	
	//this.addLink(staticTopLink, true);
	this.addLink(new Link(sessionData.getParentUrl(), null, null), null, true);
	
	//communicator.getLinks();
}
