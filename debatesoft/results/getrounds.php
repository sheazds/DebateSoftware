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
				
				echo "<table class='ballotstable'><tbody>";
				$ballots_query = "SELECT judge_ballot.pairing_id, judge.judge_id, team.team_name, CONCAT(speaker.speaker_first_name, ' ', speaker.speaker_last_name) AS speaker_name, ballot_speaker_scores.speaker_id, `ballot_speaker_scores`.`organization/structure`, `ballot_speaker_scores`.`evidence/analysis`, `ballot_speaker_scores`.`rebuttal/clash`, `ballot_speaker_scores`.`delivery/etiquette`, `ballot_speaker_scores`.`questioning/responding`, `ballot_speaker_scores`.`comments`
								FROM judge
								INNER JOIN judge_ballot ON judge.judge_id = judge_ballot.judge_id
								INNER JOIN ballot_speaker_scores ON judge_ballot.ballot_id = ballot_speaker_scores.ballot_id
								INNER JOIN speaker ON ballot_speaker_scores.speaker_id = speaker.speaker_id
								INNER JOIN team on speaker.team_id = team.team_id
								WHERE judge_ballot.pairing_id = ".$currentpair." AND judge.judge_id = ".$row['judge_id']."
								ORDER BY `judge_ballot`.`pairing_id`, judge_ballot.judge_id, speaker.speaker_id ASC";
				$ballots_result = $conn->query($ballots_query);
				$j=0;
				while($row = $ballots_result->fetch_assoc())
				{
					if($j%2==0)
						echo "<tr>";
					echo "<td class='ballotstd'>";
					echo "<div id='ballot_speaker' class='ballot_speaker'><table class='ballot_inner_table'><tbody>";
						echo "<tr><td>Speaker:</td>
							<td>".$row['speaker_name']."</td>
							<td>Team Name:</br />".$row['team_name']."</td></tr>";
					
						echo "<tr><td>Criteria</td>";
						echo "<td><table><tbody><tr>
							<td>15<br />Poor</td>
							<td>16<br />Weak</td>
							<td>17<br />Avg</td>
							<td>18<br />Good</td>
							<td>19<br />Great</td>
							</tr></tbody></table></td>";
						echo "<td>Totals</td></tr>";
						
						echo "<tr><td style='text-align: center'>Organization/<br />Structure</td>
							<td><form action=''>
									<input type='radio' name='orgstruc'>
									<input type='radio' name='orgstruc'>
									<input type='radio' name='orgstruc'>
									<input type='radio' name='orgstruc'>
									<input type='radio' name='orgstruc'>
								</form></td>";
						echo "<td>score</td></tr>";
						
						echo "<tr><td style='text-align: center'>Evidence/<br />Analysis</td>
							<td><form action=''>
									<input type='radio' name='evidana'>
									<input type='radio' name='evidana'>
									<input type='radio' name='evidana'>
									<input type='radio' name='evidana'>
									<input type='radio' name='evidana'>
								</form></td>";
						echo "<td>score</td></tr>";
						
						echo "<tr><td style='text-align: center'>Rebuttal/<br />Clash</td>
							<td><form action=''>
									<input type='radio' name='rebcla'>
									<input type='radio' name='rebcla'>
									<input type='radio' name='rebcla'>
									<input type='radio' name='rebcla'>
									<input type='radio' name='rebcla'>
								</form></td>";
						echo "<td>score</td></tr>";
						
						echo "<tr><td style='text-align: center'>Delivery/<br />Etiquette</td>
							<td><form action=''>
									<input type='radio' name='deleti'>
									<input type='radio' name='deleti'>
									<input type='radio' name='deleti'>
									<input type='radio' name='deleti'>
									<input type='radio' name='deleti'>
								</form></td>";
						echo "<td>score</td></tr>";
						
						echo "<tr><td style='text-align: center'>Questioning/<br />Responding</td>
							<td><form action=''>
									<input type='radio' name='questres'>
									<input type='radio' name='questres'>
									<input type='radio' name='questres'>
									<input type='radio' name='questres'>
									<input type='radio' name='questres'>
								</form></td>";
						echo "<td>score</td></tr>";
						
						echo "<tr><td colspan='2'>Comments:</br>
								<textarea rows='4' cols='35'></textarea></td>
							<td>Total Score:</br>
							Sum</td></tr>";
							
					echo "</tbody></table></div>";
					echo "</td>";
					if($j==1 || $j==3)
						echo "</tr>";
					$j++;
				}
				echo "</tbody></table>";
				echo "</div></div>";
				echo "<br />";
			}
			echo "</td></tr></tbody></table>";
		echo "</div></div>";
			
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
		console.log(buttonid);
		ballotid = buttonid.replace("button","ballot");
		display = document.getElementById(ballotid).style.display;
		if (display == "none")
			document.getElementById(ballotid).style.display = "inline";
	}
	function collapse_ballot(buttonid)
	{	
		console.log(buttonid);
		ballotid = buttonid.replace("button","ballot");
		display = document.getElementById(ballotid).style.display;
		if (display == "inline")
			document.getElementById(ballotid).style.display = "none";	
	}
</script>