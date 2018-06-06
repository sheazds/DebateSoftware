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

$sql = "SELECT team_id, team_name, school_id FROM team";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table>";
		echo "<tr>";
		echo "<th>team_id</th>";
		echo "<th>team_name</th>";
		echo "<th>school_id</th>";
		echo "<th></th>";
	echo "</tr>";
	
    while($row = $result->fetch_assoc())
	{
		echo "<tr>";
			echo "<td>" . $row["team_id"]. "</td>";
			echo "<td>" . $row["team_name"]. "</td>";
			echo "<td>" . $row["school_id"]. "</td>";
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
	$tid = $_POST["team_id"];
	$name = $_POST["team_name"];
	$id = $_POST["school_id"];
	$speaker_A_name = $_POST["speaker_a_name"];
	$speaker_B_name = $_POST["speaker_b_name"];
	
    	$sql = "INSERT INTO team (team_id, team_name, school_id) VALUES ('$tid', '$name', '$id')";
	
	//$sql2 = "INSERT INTO speaker (speaker_last_name, team_id, school_id) VALUES ( '$speaker_A_name',$team_ID, '$id')";
	//$sql3 = "INSERT INTO speaker (speaker_last_name, team_id, school_id) VALUES ( '$speaker_B_name', $team_ID, '$id')";
	$test = $conn->query($sql);
	//$test2 = $conn->query($sql2);
	//$test3 = $conn->query ($sql3);
	
	if ($test  == TRUE){    // && test2 == TRUE && $test3 == TRUE) {
		echo "New record created successfully";
		header("Refresh:0");
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
}
?>

	<tr>
		<form method="post" action="addTeam.php">
			<p>
				<div style="float: left; width: 305px"></div>
				School ID<br />
				
				<input id="team_name" style="width: 300px;" type="text" name="team_name" value="" />
				<select name="school_id">
				<?php
					$query = "SELECT school_id FROM school";
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
				<input type="submit" value="Add Team" />
				<input onclick="window.location='addTeam.php'" type="button" value="Cancel" />
			</p>
		</form>
	</tr>
</table>