function Communicator()
{
	this.getData = function(path, data, callback)
	{
		var targetPath = "/greader/"+path+".json";
		$.getJSON(
			targetPath,
			data,
			function(data){
				//alert(data.commonlinks.toSource());
				callback(data);
			}
		);
	}
	
	this.sendNOCallBack = function(path, data)
	{
		var targetPath = "/greader/"+path;
		$.get(
			targetPath,
			data
			//,
			//function(data){
				////alert("Returned");
			//}
		);
	}


	this.getCommonLinks = function(callback)
	{
		this.getData("default/commonlinks", null, function(data){
			var commonlinks = data.commonlinks;
			
			callback(commonlinks);
		});
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
	
	this.addLink = function(url, linkurl) // no callback needed
	{
		var data = {"url" : url, 
					"linkurl" : linkurl};
		this.sendNOCallBack("default/addlink", data, function(){});
	}
	
	this.removeLink = function(url, linkurl) // no callback needed
	{
		var data = {"url" : url, 
					"linkurl" : linkurl};
		this.sendNOCallBack("default/removelink", data, function(){});
	}
}
