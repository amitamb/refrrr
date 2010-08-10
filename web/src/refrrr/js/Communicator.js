function Communicator()
{
	this.getData = function(path, data, callback)
	{
		var targetPath = "/greader/"+path+".json";
		$.getJSON(
			targetPath,
			data,
			function(data){
				callback(data);
			}
		);
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
		this.sendNOCallBack("addLink.php", data, function(){});
	}
	
	this.removeLink = function(sessionId, linkurl) // no callback needed
	{
		var data = {"_id" : sessionId, 
					"url" : linkurl};
		this.sendNOCallBack("removeLink.php", data, function(){});
	}
}
