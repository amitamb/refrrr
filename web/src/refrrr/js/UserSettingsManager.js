function UserSettingsManager()
{
	// workig till here
	
	this.getDefaultOriginUrl = function()
	{
		return "http://www.google.com/";		
	}
	
	this.getSearchUrl = function(searchTerm)
	{
		return "http://www.google.com/search?q=" + searchTerm;
	}
}

var userSettingsManager = new UserSettingsManager();
