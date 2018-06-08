<?php
	require_once '../dbconfig.php';
	$fullpairings = "SELECT pairing.pairing_id, pairing.round_id, team1.team_name AS team1_name, team2.team_name AS team2_name, room.room_name, judge.judge_first_name, judge.judge_last_name
			FROM pairing
			INNER JOIN team AS team1
				ON pairing.team1_id = team1.team_id
			INNER JOIN team AS team2
				ON pairing.team2_id = team2.team_id
			INNER JOIN room
				ON pairing.room_id = room.room_id
			INNER JOIN judge_pairing
				ON pairing.pairing_id = judge_pairing.pairing_id
			INNER JOIN judge
				ON judge_pairing.judge_id = judge.judge_id";
	
	echo "<div id='tournamentbrackets'>";
		$prevround = null;
		$prevpair = null;
		$result = $conn->query($fullpairings);
		while($row = $result->fetch_assoc())
		{
			$currentround = $row['round_id'];
			$currentpair = $row['pairing_id'];
			
			if ($currentpair != $prevpair)
				if ($prevpair != null)
					echo "</td></tr></tbody></table></div></div>";
			if ($currentround != $prevround)
			{
				if ($prevround != null)
					echo "</div>";
				echo "<div id='round".$currentround."' class='round'>";
			}
			if ($currentpair != $prevpair)
			{
				echo "<div class='pair_spacer'>";
				echo "<div id='pair".$currentpair."' class='pair'>";
				echo "<table><tbody>";
				echo "<tr><td><b>Teams:</b></td><td>".$row['team1_name']."<br />".$row['team2_name']."</td></tr>";
				echo "<tr><td><b>Room:</b></td><td>".$row['room_name']."</td></tr>";
				echo "<tr><td><b>Judges:</b></td><td>".$row['judge_first_name']." ".$row['judge_last_name'];
			}
			else
			{
				echo "<br />".$row['judge_first_name']." ".$row['judge_last_name'];
			}
			$prevround = $currentround;
			$prevpair = $currentpair;
		}
	echo "</td></tr></table></div></div></div>";
	echo "</div>";
?>