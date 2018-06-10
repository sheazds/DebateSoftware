<?php
	if (file_exists ('dbconfig.php'))
		require_once 'dbconfig.php';
	else
		require_once '../dbconfig.php';
	
	$prevround = null;
		
	$pairingrooms = "SELECT pairing.pairing_id, pairing.round_id, room.room_name
	FROM pairing
		INNER JOIN room
			ON pairing.room_id = room.room_id";
	$pairingresult = $conn->query($pairingrooms);
	while($row = $pairingresult->fetch_assoc())
	{
		$currentpair = $row['pairing_id'];
		$currentround = $row['round_id'];
		
		
		if ($prevround != $currentround)
		{
			if ($prevround != null)
				echo "</div>";
			echo "<div id='round'".$currentround."' class='round'>";
		}
		
		echo "<div class='pair_spacer'>";
		echo "<div id='pair".$currentpair."' class='pair'>";
		echo "<table><tbody>";
		echo "<tr><td><b>Room:</b></td><td>".$row['room_name']."</td></tr>";
		
		echo "<tr><td><b>Teams:</b></td><td>";
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
		
		echo "<tr><td><b>Judges:</b></td><td>";
		$judgepairings = "SELECT pairing.pairing_id, CONCAT(judge.judge_first_name,' ',judge.judge_last_name) AS judge_name
			FROM pairing
				INNER JOIN judge_pairing
					ON pairing.pairing_id = judge_pairing.pairing_id
				INNER JOIN judge
					ON judge_pairing.judge_id = judge.judge_id
				WHERE pairing.pairing_id = ".$currentpair;
		$judgeresult = $conn->query($judgepairings);
		while($row = $judgeresult->fetch_assoc())
			echo $row['judge_name']."<br />";
		echo "</td></tr></tbody></table></div></div>";
		
		$prevround = $currentround;
	}
	echo "</div>";
?>
<script>
</script>