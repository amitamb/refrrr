function CommonLink(url)
{
	this.url = url;
}

function CommonLinksManager(commonLinksParentId)
{
	this.commonLinksParentElement = document.getElementById(commonLinksParentId);
	
	nextLinkDivId = 0;
	this.urlToLinkDivIdMap = Array();
	
	this.addCommonLink = function(commonLink)
	{
		if (commonLink != null)
		{
			var appendHtml = this.getAppendDivHTML(commonLink);

			this.commonLinksParentElement.innerHTML = this.commonLinksParentElement.innerHTML + appendHtml;
		}
	}
	
	this.getNextLinkDivId = function()
	{
		nextLinkDivId++;
		return "commonLinkDiv" + nextLinkDivId;
	}
	
	this.getAppendDivHTML = function(commonLink)
	{
		var commonLinkDivId = this.getNextLinkDivId();
		var faviconUrl = getFaviconUrl(commonLink.url);
		
		var url = commonLink.url;

		var text =  "<div id='" + commonLinkDivId + "' class='commonLinkDiv' >" +
					"<a href='" + url + "' target='_blank' onclick=\"return frameManager.navigateTo('" +  url + "');\" onrightclick=\"\">" +
					"<span class='commonLinkFavicon'><img src='"+ faviconUrl +"' order='0'></img></span>"+
					"</a>" +
					"</div>";

		return text;
	}
	
	this.addCommonLink(new CommonLink("http://www.google.com/"));

}

