<div id="buttonbar">
	<?php
		require_once 'dbconfig.php';
		$rounds = $conn->query("SELECT round_id FROM round");
		while($row = $rounds->fetch_assoc())
		{
			$round = $row['round_id'];
			echo "<a class='button' href='#showround".$round."' id='showround".$round."'>Round ".$round."</a>";
		}
	?>
	<a class="button" href="#showall" id="showall">View all Rounds</a>
</div>
<div class="clear"></div>

<div id='resultbrackets'>
	<?php require 'results/getrounds.php'; ?>
</div>	

<script>
	$(document).ready(function(){
		var buttons = document.getElementById("buttonbar").getElementsByClassName("button");
		buttons[0].className = "button left";
		
		if(window.location.hash)
		{
			var hash = window.location.hash.substring(1);
			$("#"+hash).addClass(hash);
			$("#"+hash).attr('id', 'activeBar');
			if(hash != "showall")
			{
				var rounds = document.getElementById("resultbrackets").getElementsByClassName("round");
				var showround = hash.replace("show","")
				for (var i=0; i<rounds.length; i++)
					if (rounds[i].id != showround)
						rounds[i].style.display = "none";
			}
		}
		else
		{
			$("#showall").addClass("showall");
			$("#showall").attr('id', 'activeBar');
		}
		
		for (var i=0; i<buttons.length-1; i++)
		{
			buttons[i].addEventListener("click", function () {
				var rounds = document.getElementById("resultbrackets").getElementsByClassName("round");
				for (var i=0; i<rounds.length; i++)
					rounds[i].style.display = "none";
								
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
				
				if (document.getElementById(round) != null)
					document.getElementById(round).style.display = "table-row";
			});
		}
		
		buttons[i].addEventListener("click", function () {
			var rounds = document.getElementById("resultbrackets").getElementsByClassName("round");
			for (var i=0; i<rounds.length; i++)
				rounds[i].style.display = "table-row";
			
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
</script>