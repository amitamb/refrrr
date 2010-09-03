function Communicator()
{
	this.getData = function(path, data, callback)
	{
		var targetPath = path;
		$.getJSON(
			targetPath,
			data,
			function(data){
				callback(data);
			}
		);
	}
	
	this.getDataSync = function(path, data)
	{
		var targetPath = path;
		
		var ajaxReturnVal = null;
		
		$.ajax(
				{
				async : false,
				url : targetPath,
				data : data,
				success : function(data)
				{
					ajaxReturnVal = data;
				}
			}
		);
		
		return ajaxReturnVal;
	}
	
	this.sendNOCallBack = function(path, data)
	{
		var targetPath = path;
	
		$.get(
			targetPath,
			data
			,
			function(data){
				//alert(data);
			}
		);
	}

	this.getLinks = function()
	{
		this.getData("default/getlinks", {"url" : sessionData.getParentUrl()} , function(data){

			for (lnk in data.links)
			{
				linksManager.addLink(new Link(data.links[lnk].url, null, null), null, true);
			}
		});
	}
	
	this.addLink = function(sessionId, linkurl) // no callback needed
	{
		var data = {"_id" : sessionId, 
					"url" : linkurl};
		this.getData("addLink.php", data, function(data){
			
		});
	}
	
	this.removeLink = function(sessionId, linkurl) // no callback needed
	{
		var data = {"_id" : sessionId, 
					"url" : linkurl};
		this.sendNOCallBack("removeLink.php", data, function(){});
	}
	
	this.getDialogHtml = function(path)
	{
		alert("Return something");
		
		return this.getDataSync(path);
	}
	
	this.getOtherLink = function(url)
	{
		var data = {"url" : url};
		this.getData("getOtherLinks.php", data, function(data){
			if (data!=null)
			{
				linksManager.addOtherLink(data.pageUrl, new OtherLink(data.pageUrl, data.otherLinkUrl, data.otherLinkTitle));
			}
		});
		
		if (linksManager != null)
		{
			//linksManager.addOtherLink(url, new OtherLink(originUrl, "http://www.bing.com/", "Comments"));
		}
	}
}
