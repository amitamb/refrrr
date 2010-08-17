var hideDialogFn = function(){}

function showBackgroundForDialog()
{
	$("#backgroundForDialog").css("display", "block");
}

function hideBackgroundForDialog()
{
	$("#backgroundForDialog").css("display", "none");;
}

function showSessionMenu(sourceElement, eventData)
{
	showBackgroundForDialog();
	
	// get sourceElement 's bottom and left
	// that is menu's top and left
	var offset = $(sourceElement).offset();
	var height = $(sourceElement).height();
	var left = offset.left;
	var top = offset.top + height + 4;
	
	$("#sessionMenu").css("display", "block");
	$("#sessionMenu").css("left", left+"px");
	$("#sessionMenu").css("top", top+"px");
	
	$("#sessionMenu a").click(function(){
		hideDialogFn();
		hideBackgroundForDialog()
	});

	hideDialogFn = function()
	{
		$("#sessionMenu").css("display", "none");
	};
}
