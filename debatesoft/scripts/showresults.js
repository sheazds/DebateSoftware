$(document).ready(function(){
	$("#resultbrackets").load('getresults.php');
	var rounds = document.getElementById("resultbrackets").getElementsByClassName("round");
	for (var i=0; i<rounds.length; i++)
		rounds[i].style.display = "none";
	
	var buttons = document.getElementById("buttonbar").getElementsByClassName("button");
	buttons[0].className = "button left";
	
	for (var i=0; i<buttons.length-1; i++)
	{
		buttons[i].addEventListener("click", function () {
			
			var currentBar = $("#activeBar").attr('class');
			var newSection = this.id;
			var round = this.id.replace("show","");
			if (currentBar != null)
			{
				currentBar = currentBar.replace('button ', '');
				currentBar = currentBar.replace('left ', '');
				$("#activeBar").removeClass(currentBar);
				$("#activeBar").attr("id", currentBar);
			}
			$("#"+newSection).addClass(newSection);
			$("#"+newSection).attr("id", "activeBar");
			
			document.getElementById(round).style.display = "table-row";
		});
	}
	
	buttons[i].addEventListener("click", function () {
		var rounds = document.getElementById("resultbrackets").getElementsByClassName("round");
		for (var i=0; i<rounds.length; i++)
			rounds[i].style.display = "none";
		
		var currentBar = $("#activeBar").attr('class');
		var newSection = this.id;
		if (currentBar != null)
		{
			currentBar = currentBar.replace('button ', '');
			currentBar = currentBar.replace('left ', '');
			$("#activeBar").removeClass(currentBar);
			$("#activeBar").attr("id", currentBar);
		}
		$("#"+newSection).addClass(newSection);
		$("#"+newSection).attr("id", "activeBar");
		
		
	});
});