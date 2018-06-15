<?php
	if (file_exists ('dbconfig.php'))
		require_once 'dbconfig.php';
	else
		require_once '../dbconfig.php';
	
	$pairingrooms = "SELECT pairing.pairing_id, pairing.round_id, room.room_name
		FROM pairing
			INNER JOIN room
				ON pairing.room_id = room.room_id";
	
		$prevround = null;
		
		$pairingresult = $conn->query($pairingrooms);
		while($row = $pairingresult->fetch_assoc())
		{
			$currentpair = $row['pairing_id'];
			$currentround = $row['round_id'];
			
			
			if ($prevround != $currentround)
			{
				if ($prevround != null)
					echo "</div>";
				echo "<div id='round".$currentround."' class='round'>";
			}
			
			echo "<div class='pair_spacer'>";
				echo "<div id='pair".$currentpair."' class='pair'>";
					echo "<table><tbody>";
						
						//echo "<tr><td><div class='allballots'><b>Ballots: </b></div></td>";
						//echo "<td>X/Y</td></tr>";
						
						echo "<tr><td><b>Room:</b><br />".$row['room_name']."</td></tr>";
						
						echo "<tr><td><b>Teams:</b><br />";
						$pairingteams = "SELECT pairing.pairing_id, team.team_name
							FROM pairing
								INNER JOIN pairing_team
									ON pairing.pairing_id = pairing_team.pairing_id
								INNER JOIN team
									ON pairing_team.team_id = team.team_id
								WHERE pairing.pairing_id = ".$currentpair;
						$teamresult = $conn->query($pairingteams);
						while($row = $teamresult->fetch_assoc())
							echo $row['team_name']."<br />";
						echo "</td></tr>";
						
						echo "<tr><td><b>Judges:</b><br />";
						$judgepairings = "SELECT pairing.pairing_id, judge.judge_id, CONCAT(judge.judge_first_name,' ',judge.judge_last_name) AS judge_name
							FROM pairing
								INNER JOIN judge_pairing
									ON pairing.pairing_id = judge_pairing.pairing_id
								INNER JOIN judge
									ON judge_pairing.judge_id = judge.judge_id
								WHERE pairing.pairing_id = ".$currentpair;
						$judgeresult = $conn->query($judgepairings);
						while($row = $judgeresult->fetch_assoc())
						{
							echo "<div class='judge_ballot_row'>";
								echo $row['judge_name'];
								echo "<button id='button_pair".$currentpair."_judge".$row['judge_id']."' onclick='expand_ballot(id)' style='float:right; margin-left:5px;'><b>+</b></button>";
							echo "</div>";
							
							echo "<div id='ballot_pair".$currentpair."_judge".$row['judge_id']."' class='ballotpair' style='display: none'>";
								echo "<div class='ballotpair_spacer'>";
									echo "<h2 style='float:left; margin-left:10px;'>".$row['judge_name']."</h2>";
									echo "<button id='button_pair".$currentpair."_judge".$row['judge_id']."' onclick='collapse_ballot(id)' style='float:right;margin-right:10px;'><h2 style='width:30px;'>X</h2></button>";
									echo "<div class='clear'></div>";
									
									echo "<div id='ballotsheet_pair".$currentpair."_judge".$row['judge_id']."'></div>";
									echo "<div class='clear'></div>";
									
								echo "</div>";
							echo "</div>";
							echo "<br />";
						}
					echo "</td></tr></tbody></table>";
				echo "</div>";
			echo "</div>";
				
			$prevround = $currentround;
		}
	echo "</div>";
?>

<script>
	if ($("#activeBar").length)
	{
		var round = $("#activeBar").attr('class').replace("button show","");
		round = round.replace("button left show","");
		document.getElementById(round).style.display = "table-row";
	}
	
	function expand_ballot(buttonid)
	{	
		ballotid = buttonid.replace("button","ballot");
		display = document.getElementById(ballotid).style.display;
		if (display == "none")
		{
			document.getElementById(ballotid).style.display = "";
			
			pairing = buttonid.replace("button_pair","");
			pairing = pairing.slice(0, pairing.indexOf("_"));
			judge = buttonid.slice(pairing.lastIndexOf("_"));
			show_ballot(pairing, judge);
		}
	}
	
	function show_ballot(pairing, judge)
	{
		post_data = {pair:pairing, judge:judge};
		$.ajax({
			url: "results/getballots.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$("#ballotsheet_pair"+pairing+"_judge"+judge).html(return_data);
			},
		});
	}
	
	function collapse_ballot(buttonid)
	{	
		ballotid = buttonid.replace("button","ballot");
		display = document.getElementById(ballotid).style.display;
		if (display == "")
		{
			document.getElementById(ballotid).style.display = "none";
			
			pairing = buttonid.replace("button_pair","");
			pairing = pairing.slice(0, pairing.indexOf("_"));
			judge = buttonid.slice(pairing.lastIndexOf("_"));
			$("#ballotsheet_pair"+pairing+"_judge"+judge).empty();
		}
	}
	function post_ballot(ballot_form, ballot_id, ballot_value, pairing, judge)
	{
		if (ballot_form == "comments")
			var post_data = {form:ballot_form, id:ballot_id, value:ballot_value};
		else
			var post_data = {form:ballot_form[0].name, id:ballot_id, value:ballot_form.value};
		$.ajax({
			url: "results/postballot.php",	
			type: "POST",
			data: post_data,
			success: function(){
				if (ballot_form != "comments")
					show_ballot(pairing, judge);
			},
		});
	}
</script>