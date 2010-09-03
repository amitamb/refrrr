function Frame(url, iFrameId, backgroundFrame)
{
	if (backgroundFrame == null)
	{
		backgroundFrame = false;
	}

	// add Frame
	var parent = document.getElementById("navigFrameParent");
	
	var newFrame = document.createElement("iframe");
	newFrame.id = iFrameId;
	
	// TODO later
	// don't load immediately
	// newFrame.src = "about:blank";

	if (backgroundFrame)
	{
		newFrame.src = "loading.htm"; //"about:blank";
	}
	else
	{
		newFrame.src = url;
	}

	if (backgroundFrame)
	{
		//newFrame.style.visibility = "hidden";
		
		hideIframeObj(newFrame);
	}
	
	parent.appendChild(newFrame);
	
	// Member variable
	this.url = url;
	this.iframeId = iFrameId;
	this.iframeObj = document.getElementById(this.iframeId);

	//frameLoadQueue.addToQueue(this);

	this.containsIFrameBuster = false;
	
	this.getFrame = function()
	{
		// var iFrame = document.getElementById(this.iframeId);
		
		var iFrame = this.iframeObj;
		
		if (iFrame == null)
		{
			alert("Error in Frame.getFrame()");
		}

		return iFrame;
	}
	
	this.navigateTo = function(newUrl)
	{
		this.url = newUrl;
		this.iframeObj.src = this.url;
	}
	
	this.show = function()
	{
		//this.iframeObj.style.visibility = "visible";
		
		// check if frameLoadQueue has started loading it
		// if not start it immediately
		if (this.iframeObj.src != this.url)
		{
			this.iframeObj.src = this.url;
		}
		
		showIframeObj(this.iframeObj);
		
		// nothing works
		//$(this.iframeObj).focus();
		//alert(this.iframeObj.contentWindow.focus); //();
		//this.iframeObj.contentWindow.focus();
		//this.iframeObj.setActive();
	}
	
	function showIframeObj(iframeObj)
	{
		iframeObj.style.width = "100%";
		iframeObj.style.height = "100%";
		
		iframeObj.style.visibility = "visible";
	}
	
	this.hide = function()
	{
		//this.iframeObj.style.visibility = "hidden";
		
		hideIframeObj(this.iframeObj);
	}
	
	function hideIframeObj(iframeObj)
	{
		iframeObj.style.width = "0%";
		iframeObj.style.height = "0%";
		
		iframeObj.style.visibility = "hidden";
	}
	
	this.remove = function()
	{
		//alert("Removing" + this.url);
		//frameLoadQueue.removed(this.url);
		$(this.iframeObj).remove();
	}
}

Frame.baseFrame = null;

Frame.addBaseFrame = function()
{
	Frame.baseFrame = new Frame("about:blank", "baseFrame", true);
}

function FrameManager(enableIFrameBusterBuster)
{
	if (enableIFrameBusterBuster == null)
	{
		enableIFrameBusterBuster = true;
	}
	
	this.enableIFrameBusterBuster = enableIFrameBusterBuster;

	// using window obj
	// deviation from normal practice
	// since this will be used in setInterval
	// it has direct access to window
	this.lastLoadedIFrameUrl = null;
	
	this.setLastLoadedIFrameUrl = function(url)
	{
		this.lastLoadedIFrameUrl = url;
	}
	
	this.getLastLoadedIFrameUrl = function()
	{
		return this.lastLoadedIFrameUrl;
	}
	
	this.clearLastLoadedIFrameUrl = function()
	{
		this.lastLoadedIFrameUrl = null;
	}
	
	this.urlToFrameMap = new Array();
	this.lastIframeId = Math.random() * 1000;
	
	this.currentFrontFrame = null;
	
	this.getNextIframeId = function()
	{
		var id = "navigFrame" + (this.lastIframeId++);
		return id;
	}
	
	this.bringToFront = function(targetFrame)
	{
		for (frame in this.urlToFrameMap)
		{
			var curFrame = this.urlToFrameMap[frame];
			
			if (targetFrame != curFrame)
			{
				curFrame.hide();
			}
		}
		
		Frame.baseFrame.hide();
		
		targetFrame.show();
		
		this.currentFrontFrame = targetFrame;
		
		changeFavIcon(getFaviconUrl(targetFrame.url));
		changePageTitle(targetFrame.url);
		$("#statusUrl").val(targetFrame.url);
	}
	
	this.doesFrameContainsIFrameBuster = function(url)
	{
		var frame = this.urlToFrameMap[url];
		
		return frame && frame.containsIFrameBuster;
	}

	this.navigateTo = function(url, backgroundFrame)
	{
		var frame = this.urlToFrameMap[url];
		
		if (frame == null)
		{
			frame = new Frame(url, this.getNextIframeId(), backgroundFrame);
			
			this.urlToFrameMap[url] = frame;
		}
		else
		{
			if (frame.containsIFrameBuster)
			{
				// show such message insie iframe
				// todo
				
				// do nothing
			}
		}
		
		if (!backgroundFrame)
		{
			this.bringToFront(frame);
		}

		this.setLastLoadedIFrameUrl(url);
		this.enableTemporaryIframeBusterBuster();
		
		// to cancel default action
		return false;
	}
	
	this.removeFrame = function(url)
	{
		var frame = this.urlToFrameMap[url];
		
		if (frame)
		{
			frame.remove();
		}
	}
	
	this.getCurrentUrl = function()
	{
		return this.currentFrontFrame.url;
	}
	
	this.lastTimeOutId = null;
	
	this.enableTemporaryIframeBusterBuster = function()
	{
		if (this.enableIFrameBusterBuster)
		{
			window.onbeforeunload = function() { prevent_bust++;} 
			
			// clear last timeout as it will clear the onbeforeunload prematurely for current page
			if (this.lastTimeOutId != null)
			{
				// it might have been diabled already
				clearTimeout(this.lastTimeOutId);
			}
			
			// disable it in 4 second
			// that should be enough time for page to load
			// actually it should be disabled on onload
			this.lastTimeOutId = setTimeout(function(){frameManager.clearLastLoadedIFrameUrl();window.onbeforeunload=window.onbeforeunload = defaultonbeforeunload;}, 4000);
		}
	}
	
	window.permanantIFrameBusterBuster = false;
	
	window.defaultonbeforeunload = function() {
		if (window.permanantIFrameBusterBuster)
		{
			prevent_bust++;
		}
		else
		{
			//var answer = confirm ("Do you want to stop navigating away from the reader?");
			// if (answer)
			if (false)
			{
				prevent_bust++;
				window.permanantIFrameBusterBuster = true;
			}
			else
			{
				window.permanantIFrameBusterBuster = false;
			}
		}
	} 
	
	window.onbeforeunload = defaultonbeforeunload;
	
	this.setLastLoadedLinkAsIFrameBuser = function()
	{
		var convictUrl = this.getLastLoadedIFrameUrl();
		
		frameManager.clearLastLoadedIFrameUrl();

		if (this.urlToFrameMap[convictUrl] != null)
		{
			this.urlToFrameMap[convictUrl].containsIFrameBuster = true;
		}
	}
	
	if (this.enableIFrameBusterBuster)
	{
		window.prevent_bust = 0;
		setInterval(function() {  
			if (prevent_bust > 0) {
				prevent_bust -= 2;
				window.top.location = 'support/204.php'; 
				frameManager.setLastLoadedLinkAsIFrameBuser();
			  }  
			}, 1) ;
	}
	
	// Add baseFrame
	// <iframe name="baseFrame" id="baseFrame" src="about:blank"></iframe>
	Frame.addBaseFrame();
	
	this.showBaseFrame = function()
	{
		//Frame.baseFrame.
		this.bringToFront(Frame.baseFrame);	
	};
}
