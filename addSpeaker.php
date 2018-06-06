 <?php
// this will get moved to an external php file in the future
$servername = "localhost";
$username = "Shahana";
$password = "asIf1969";
$dbname = "attemp1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$speaker_a_name = "";
$speaker_b_name = "";

$sql = "SELECT * FROM team, speaker WHERE team.team_id = speaker.team_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table>";
		echo "<tr>";
		echo "<th>team_name</th>";
		echo "<th>school_id</th>";
		echo "<th>speaker name</th>";
		echo "<th></th>";
	echo "</tr>";
	
    while($row = $result->fetch_assoc())
	{
		echo "<tr>";
			echo "<td>" . $row["team_name"]. "</td>";
			echo "<td>" . $row["school_id"]. "</td>";
			echo "<td>" . $row["speaker_first_name"]. "</td>";
			echo "<td>" . $row["speaker_last_name"]. "</td>";
			echo "<td></td>";
		echo "</tr>";
    }
} else {
    echo "<br> 0 results";	
}

?>

<?php
if(isset($_POST['cmd'])){
	if($_POST['cmd'] == "add")
{
	
	$name = $_POST["team_name"];
	
	$speaker_A_name = $_POST["speaker_a_name"];
	$speaker_B_name = $_POST["speaker_b_name"];
	
	$sql = "SELECT team_id, school_id FROM team WHERE team_name = '$name'";
	$result = $conn->query($sql);
if ($result == 0 ){
	echo "No rows found";
exit;
}
	$tid = $result->fetch_assoc();

    	

	$sql2 = "INSERT INTO speaker (speaker_last_name, team_id, school_id) VALUES ( '$speaker_A_name', '$tid[team_id]', '$tid[school_id]' )";
	$sql3 = "INSERT INTO speaker (speaker_last_name, team_id, school_id) VALUES ( '$speaker_B_name', '$tid[team_id]', '$tid[school_id]' )";
	
	$test = $conn->query($sql2);
	$test2 = $conn->query($sql3);
	//$test3 = $conn->query ($sql3);
	
	if ($test  == TRUE && $test2 == TRUE){    
		echo "New record created successfully";
		header("Refresh:0");
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
}
?>

	<tr>
		<form method="post" action="addSpeaker.php">
			<p>
				
				Team Name<br />
				
				<select name="team_name">
				<?php
					$query = "SELECT team_name FROM team";
					$schools =mysqli_query($conn, $query);
					$options = "";
					while ($school = mysqli_fetch_array($schools)) {
						$options = $options."<option>$school[0]</option>";
					}
					echo $options;
				?>
				</select>
			</p>
			<p>
				Speaker A<br />
				<input style="width: 300px;" type="text" name="speaker_a_name" value="<?php echo htmlentities($speaker_a_name); ?>" /><br />

				Speaker B<br />
				<input style="width: 300px;" type="text" name="speaker_b_name" value="<?php echo htmlentities($speaker_b_name); ?>" />
			</p>
			
			
			<input type="hidden" name="cmd" value="add" />
			
			<p>
				<input type="submit" value="Add Speakers" />
				<input onclick="window.location='addSpeaker.php'" type="button" value="Cancel" />
			</p>
		</form>
	</tr>
</table>