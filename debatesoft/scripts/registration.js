$(document).ready(function()
{	
	var currentSection = null;
	
	if(window.location.hash)
	{
		var hash = window.location.hash.substring(1);
		openSection(currentSection, hash);
		currentSection = hash;
	}
	
	$("#regions").click(function(){
		openSection(currentSection, "regions");
		currentSection = "regions";
	});
	$("#schools").click(function(){
		openSection(currentSection, "schools");
		currentSection = "schools";
	});
	$("#teams").click(function(){
		openSection(currentSection, "teams");
		currentSection = "teams";
	});
	$("#speakers").click(function(){
		openSection(currentSection, "speakers");
		currentSection = "speakers";
	});
	$("#judges").click(function(){
		openSection(currentSection, "judges");
		currentSection = "judges";
	});
	$("#rooms").click(function(){
		openSection(currentSection, "rooms");
		currentSection = "rooms";
	});
	
	function openSection(currentSection, newSection)
	{
		if (currentSection != null)
		{
			$("#"+currentSection+"_section").find(".section_content").empty();
			$("#"+currentSection+"_section").attr("class", "reg_section closed");
		}
		$("#"+newSection+"_section").find(".section_content").load("registration/"+newSection+".php");
		$("#"+newSection+"_section").attr("class", "reg_section open");
	}
});