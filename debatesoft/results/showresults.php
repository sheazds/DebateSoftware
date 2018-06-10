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
	<a class="button" href="#brackets" id="brackets">View all Rounds</a>
</div>
<div class="clear"></div>

<div id='resultbrackets'>
	<?php require 'results/getrounds.php'; ?>
</div>	

<script>
	$(document).ready(function(){
		var rounds = document.getElementById("resultbrackets").getElementsByClassName("round");
		for (var i=0; i<rounds.length; i++)
			rounds[i].style.display = "none";
		
		var buttons = document.getElementById("buttonbar").getElementsByClassName("button");
		buttons[0].className = "button left";
		for (var i=0; i<buttons.length-1; i++)
		{
			buttons[i].addEventListener("click", function () {
				var rounds = document.getElementById("resultbrackets").getElementsByClassName("round");
				for (var i=0; i<rounds.length; i++)
					rounds[i].style.display = "none";
								
				var currentBar = $("#activeBar").attr('class');
				if (currentBar == 'button brackets')
					$("#resultbrackets").load('results/getrounds.php');
				
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
			
			$("#resultbrackets").load('results/getbrackets.php');
		});
	});
</script>