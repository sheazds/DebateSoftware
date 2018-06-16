$(document).ready(function(){
	var buttons = document.getElementById("buttonbar").getElementsByClassName("button");
	buttons[0].className = "button left";
	
	if(window.location.hash)
	{
		var hash = window.location.hash.substring(1);
		$("#"+hash).addClass(hash);
		$("#"+hash).attr('id', 'activeBar');
		$("#content").load($("#content").attr('class')+"/"+hash+".php");
	}
	
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