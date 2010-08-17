$(document).ready(function(){

	var overlayDropText = document.getElementById("overlayDropText");

	overlayDropText.ondragenter=overlayDropTextDragEnter;
	overlayDropText.ondragover=overlayDropTextDragOver;
	overlayDropText.ondragleave=overlayDropTextDragLeave;

	/////////////
	// Firefox supports ondrop
	// but used for clearing interval i.e. clearing tracker which checks if drop is completed
	overlayDropText.ondrop=overlayDropTextDragdrop;
	
	// onmouseover="hideOverlayText()" onmouseout="showOverlayText()"
	$("#leftDiv").mouseenter(function(e){
		hideOverlayText();
	});
	
	$("#leftDiv").mouseleave(function(e){
		showOverlayText();
	});

	if (true) //getBrowser() == "chrome")
	{
		$("#bottomWhiteSpaceForChrome").css("display", "table-row");
	}
	
	if (getBrowser() == "chrome" || getBrowser() == "safari")
	{
		$("div.link").css("border-bottom-width", "1px");
		$("div.link").css("border-left-width", "1px");
	}
	
	if (getBrowser() == "ie")
	{
		$("div.link").css("display", "inline");
	}
	
	if (getBrowser() == "chrome")
	{
		$("#bottomWhiteSpaceForChrome").css("background-color","Red");
	}
})
