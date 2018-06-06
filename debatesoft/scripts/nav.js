$(document).ready(function(){
	var currentNav = null;
	$("#registration").click(function(){
		openNav(currentNav, "registration");
		currentNav = "registration";		
	});
	$("#tournaments").click(function(){
		openNav(currentNav, "tournaments");
		currentNav = "tournaments";
	});
	$("#results").click(function(){
		openNav(currentNav, "results");
		currentNav = "results";
	});
	$("#tools").click(function(){
		openNav(currentNav, "tools");
		currentNav = "tools";
	});
	$("#logout").click(function(){
	});
	
	function openNav(currentNav, newNav)
	{
		if (currentNav != null)
		{
			$("#activeNav").attr("id", currentNav);
		}
		$("#content").empty();
		$("#content").load(newNav+".php");
		$("#"+newNav).attr("id", "activeNav");
	}
});
