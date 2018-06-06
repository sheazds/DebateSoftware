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


$sql = "SELECT * FROM scratches";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table>";
		echo "<tr>";
		echo "<th>Judge Name</th>";
		echo "<th>    </th>";
		echo "<th>Speaker_name</th>";
		echo "<th></th>";
	echo "</tr>";
	
    while($row = $result->fetch_assoc())
	{
		echo "<tr>";
			echo "<td>" . $row["judge_id"]. "</td>";
			//echo "<td>" . $row["judge_last_name"]. "</td>";
			echo "<td>" . $row["speaker_id"]. "</td>";
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
	$speakerName = $_POST["speaker_name"];
	$judgeName = $_POST["judge_name"];
	
	$speakerNames = explode(' ',$speakerName);
	$judgeNames = explode (' ',$judgeName);
	
	
	//Better to select id based on first AND last name
	$sql ="SELECT speaker_id FROM speaker where speaker_last_name = '$speakerNames[1]'";
	$resultSpeaker = $conn->query($sql);

	$sql ="SELECT judge_id FROM judge where judge_last_name = '$judgeNames[1]'";
	$resultJudge = $conn->query($sql);
	
	if ($resultSpeaker == 0 || $resultJudge == 0){
		echo "No school id found";
		exit;
	}
	
	$resultSpeakerRow = $resultSpeaker->fetch_assoc();
	$resultJudgeRow = $resultJudge->fetch_assoc();	

    	$sql = "INSERT INTO scratches (judge_id, speaker_id) VALUES ('$resultSpeakerRow[speaker_id]', '$resultJudgeRow[judge_id]')";
	
	$test = $conn->query($sql);
	
	if ($test  == TRUE){   
		echo "New record created successfully";
		header("Refresh:0");
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
}
?>

	<tr>
		<form method="post" action="addScratches.php">
			<p>
				<div style="float: left; width: 305px"></div>
				Speaker Name<br />
				
				
				<select name="speaker_name">
				<?php
					$query = "SELECT speaker_first_name ,speaker_last_name FROM speaker";
					$speakers =mysqli_query($conn, $query);
					$options = "";
					while ($speaker = mysqli_fetch_array($speakers)) {
						$options = $options."<option>$speaker[0] $speaker[1]</option>";
					}
					echo $options;
				?>
				</select>
			</p>
			<p>

				<div style="float: left; width: 305px"></div>
				Judge Name<br />	
		
				<select name="judge_name">
				<?php
					$query = "SELECT judge_first_name, judge_last_name FROM judge";
					$judges =mysqli_query($conn, $query);
					$options = "";
					while ($judge = mysqli_fetch_array($judges)) {
						$options = $options."<option>$judge[0] $judge[1]</option>";
					}
					echo $options;
				?>
				</select>
				
			</p>
			
			
			
			<input type="hidden" name="cmd" value="add" />
			
			<p>
				<input type="submit" value="Add Constraint" />
				<input onclick="window.location='addScratches.php'" type="button" value="Cancel" />
			</p>
		</form>
	</tr>
</table>