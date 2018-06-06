<?php
	require_once 'dbconfig.php';
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
	
	echo "<div id='brackets'>";
		//For each round in tournament
		$i=1;
		$sqlrounds = $conn->query("SELECT DISTINCT(round_id) FROM pairing");
		while($rounds = $sqlrounds->fetch_assoc())
		{	
			echo "<div id='round".$i."'>";
			$sqlpairs = $conn->query("SELECT DISTINCT(pairing_id) FROM pairing");
			while($pairs = $sqlpairs->fetch_assoc())
			{
				echo "<div id='round".$i."'>";
				$prev = null;
				$result = $conn->query($fullpairings);
				while($row = $result->fetch_assoc())
				{
					if (($pairs['pairing_id'] == $row['pairing_id'])
						&&($rounds['round_id'] == $row['round_id']))
					{
						$current = $row["pairing_id"];
						if ($current != $prev)
						{
							echo "<td>" . $row["pairing_id"]. "</td>";
							echo "<td>" . $row["round_id"]. "</td>";
							echo "<td>" . $row["team1_name"]. "</td>";
							echo "<td>" . $row["team2_name"]. "</td>";
							echo "<td>" . $row["room_name"]. "</td>";
							echo "<td>" . $row["judge_first_name"]. "</td>";
							echo "<td>" . $row["judge_last_name"]. "</td>";
						}
						else
						{
							echo "<td>" . $row["judge_first_name"]. "</td>";
							echo "<td>" . $row["judge_last_name"]. "</td>";
						}
						$prev = $current;
					}
				}
				echo "<br />";
										
				echo "</div>";
			}
			echo "</div>";
			$i++;
		}
	echo "</div>";
?>

<?php
	$result = $conn->query($fullpairings);
	if ($result->num_rows > 0) {
		// output data of each row
		echo "<table>";
			echo "<tr>";
			echo "<th>pairing_id</th>";
			echo "<th>round_id</th>";
			echo "<th>team1_name</th>";
			echo "<th>team2_name</th>";
			echo "<th>room_name</th>";
			echo "<th>Judge</th>";
		echo "</tr>";
		
		while($row = $result->fetch_assoc())
		{
			//if( $row["round_id"] == 1)
			{
				echo "<tr>";
					echo "<td>" . $row["pairing_id"]. "</td>";
					echo "<td>" . $row["round_id"]. "</td>";
					echo "<td>" . $row["team1_name"]. "</td>";
					echo "<td>" . $row["team2_name"]. "</td>";
					echo "<td>" . $row["room_name"]. "</td>";
					echo "<td>" . $row["judge_first_name"]. "</td>";
					echo "<td>" . $row["judge_last_name"]. "</td>";
				echo "</tr>";
			}
		}
	}
?>