function SessionData() //parentUrl)
{
	var originUrl = getOriginUrl();
	
	this.sessionObj = null;
	
	var sessionInit = false;
	
	if (!originUrl || originUrl == "")
	{
		// try to get Id
		var sessionId = getSessionId();
		
		if (sessionId && sessionId != "")
		{
			var tempSessionHolder = null;
			$.ajax(
				{
				async : false,
				url : "getSessionById.php",
				data : {"_id" : sessionId},
				success : function(data)
				{
					sessionInit = true;
					var session = data;
					tempSessionHolder =session;
				},
				error : function(XMLHttpRequest, textStatus, errorThrown)
				{
					alert("Error occured");
				},
				dataType : 'json'
				}
			);
			this.sessionObj = tempSessionHolder;
			originUrl = this.sessionObj.url;
		}
		else
		{
			originUrl=userSettingsManager.getDefaultOriginUrl();
		}
	}
	
	this.parentUrl = originUrl;
	
	this.getParentUrl = function()
	{
		return this.parentUrl;
	}
	
	this.getId = function()
	{
		return this.sessionObj._id;
	}
	
	if (!sessionInit && (originUrl != null || originUrl != ""))
	{
		$.ajax(
			{
			url : "getSessionByUrl.php",
			data : {"url" : originUrl},
			success : function(data)
			{
				var session = data;
				sessionData.sessionObj = data;
				initAll(false, session);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown)
			{
				initAll(true, null);
			},
			dataType : 'json'
			}
		);
	}
	else
	{
		setTimeout("initAll(false, sessionData.sessionObj)", 200);;
	}
}

function initAll(offlineMode, session)
{
	if (offlineMode)
	{
		//alert("You are not logged in. Working in offline mode. Click login to go to online mode.");		
	}
	else
	{
		if (session != null && session._id != null)
		{
			showTabLinks(session);
			
			setShareLink(session);
			setViewLink(session);
			setHistoryLink(session);
			setResetLink(session)
			
			// set view link
			//$("#viewSessionLink").attr("href", "view.php?_id="+session._id);
			//view.php?_id=
		}
	}
}

function setShareLink(session)
{
	$("#sharelink").attr("href", "shareTabs.php?_id="+session._id);
	$("#sharelink").attr("target", "_blank");
}


function setViewLink(session)
{
	$("#viewlink").attr("href", "view.php?_id="+session._id);
	$("#viewlink").attr("target", "_blank");
}

function setHistoryLink(session)
{
	$("#historylink").attr("href", "sessionHistory.php?_id="+session._id);
	$("#historylink").attr("target", "_blank");
}

function setResetLink(session)
{
	$("#resetlink").click(function(){linksManager.reset();});
}

function showTabLinks(session)
{
	var tabLinks = session.tabLinks;

	if (tabLinks != null)
	{
		for (var tabLink in tabLinks)
		{
			linksManager.addLink(new Link(tabLinks[tabLink].url), false, true);
		}
	}
	else
	{
		//alert('No tab links');
	}
}
