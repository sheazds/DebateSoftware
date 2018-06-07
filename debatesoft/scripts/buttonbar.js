$(document).ready(function(){
	var buttons = document.getElementById("buttonbar").getElementsByClassName("button");
	buttons[0].className = "button left";
	
	for (var i=0; i<buttons.length; i++)
	{
		buttons[i].addEventListener("click", function () {
			var currentBar = $("#activeBar").attr('class');
			var newSection = this.id;
			if (currentBar != null)
			{
				currentBar = currentBar.replace('button ', '');
				currentBar = currentBar.replace('left ', '');
				$("#activeBar").removeClass(currentBar);
				$("#activeBar").attr("id", currentBar);
			}
			$("#content").empty();
			$("#content").load($("#content").attr('class')+"/"+newSection+".php");
			$("#"+newSection).addClass(newSection);
			$("#"+newSection).attr("id", "activeBar");	
		});
	}
});