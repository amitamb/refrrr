function showDebug(msg)
{
	//document.title = msg;
	// var debugText = document.getElementById("debugText");
	
	//debugText.innerHTML = msg;
}

function getBrowser()
{
	var userAgent = navigator.userAgent.toLowerCase();

	// assumed default
	if (userAgent.indexOf('firefox') > -1)
	{
		return "firefox";
	}
	else if (userAgent.indexOf('chrome') > -1)
	{
		return "chrome";
	}
	else if (userAgent.indexOf('safari') > -1)
	{
		return "safari";
	}	
	else if (userAgent.indexOf('msie') > -1)
	{
		return "ie";
	}
}

function showStatusMessage(message)
{
	window.status = message;
	alert(message);
}

// supporting function
// gives hostname part of url
function getHostname(str) {
	var re = new RegExp('^(?:f|ht)tp(?:s)?\://([^/]+)', 'im');
	var t = str.match(re)[1];
//	if (t == null)
//		return null;
	return t.toString();
}

function getTitleForUrl(url, callback, linksManagerObj)
{
	$.getJSON(
		"http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22"+ encodeURIComponent(url) +"%22%20and%20xpath%3D'%2F%2Ftitle'&format=json&callback=?",
		function(data){	
			if (data.query)
			if (data.query.results)
			// Check specified below for typeof == "string" is for twitter 
			if (data.query.results.title != null && data.query.results.title != "")
			{
				var title = "";
				if ((typeof data.query.results.title) == "string")
				{
					title = data.query.results.title;
				}
				else if (data.query.results.title.content)
				{
					title = data.query.results.title.content;
				}
				
				if (title != "")
				{
					callback(linksManagerObj, url, title);
					// $("#"+elementId+" a:first span").html(title);
				}
				else
				{
					callback(linksManagerObj, url, null);
				}
			}
		}
	);
}

function getFaviconUrl(url)
{
	var hostName = getHostname(url);
	
	return "http://s2.googleusercontent.com/s2/favicons?domain=" + escape(hostName);
}

function gup( url,  name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( url );
  if( results == null )
    return "";
  else
    return results[1];
}

function isUrl(s) {
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}

function getActualUrl(url)
{
	var urlParamValue = gup(url, "url");

	if (urlParamValue == "")
	{
		if (url.indexOf("google")!= -1 && url.indexOf("/url?q=") != -1)
		{
			urlParamValue = gup(url, "q");
		}
	}

	if (urlParamValue == "")
	{
		return url;
	}
	else
	{
		// check if it is valid url
		if (isUrl(urlPa))
		return decodeURIComponent(urlParamValue);
	}
}

function getOriginUrl()
{
	originUrl = unescape(gup(window.location.toString(), 'o'));
	
	return originUrl;
}

function getSessionId()
{
	originUrl = unescape(gup(window.location.toString(), 'id'));
	
	return originUrl;
}

function changeFavIcon(href, type)
{
	if (type == undefined || type == null)
	{
		type = "image/x-icon";
	}
	
	var link = document.createElement('link');
    link.type = type;
    link.rel = 'shortcut icon';
    link.href = href;
    document.getElementsByTagName('head')[0].appendChild(link);
}

function changePageTitle(newTitle)
{
	document.title = newTitle;
}
