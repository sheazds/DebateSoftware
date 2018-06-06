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

$judge_first_name = "";
$judge_last_name = "";

$sql = "SELECT * FROM judge, school WHERE judge.school_id = school.school_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table>";
		echo "<tr>";
		echo "<th>Judge Name</th>";
		echo "<th>    </th>";
		echo "<th>school_name</th>";
		echo "<th></th>";
	echo "</tr>";
	
    while($row = $result->fetch_assoc())
	{
		echo "<tr>";
			echo "<td>" . $row["judge_first_name"]. "</td>";
			echo "<td>" . $row["judge_last_name"]. "</td>";
			echo "<td>" . $row["school_name"]. "</td>";
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
	$schoolName = $_POST["school_name"];
	$judge_first_name = $_POST["first_name"];
	$judge_last_name = $_POST["last_name"];
	
	$sql ="SELECT school_id FROM school where school_name = '$schoolName'";
	$result = $conn->query($sql);
	
	if ($result == 0){
		echo "No school id found";
		exit;
	}
	
	$resultRow = $result->fetch_assoc();	

    	$sql = "INSERT INTO judge (judge_first_name, judge_last_name, school_id) VALUES ('$judge_first_name', '$judge_last_name', '$resultRow[school_id]')";
	
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
		<form method="post" action="addJudge.php">
			<p>
				<div style="float: left; width: 305px"></div>
				School Name<br />
				
				
				<select name="school_name">
				<?php
					$query = "SELECT school_name FROM school";
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
				Judge First Name<br />
				<input style="width: 300px;" type="text" name="first_name" value="<?php echo htmlentities($judge_first_name); ?>" /><br />

				Judge Last Name<br />
				<input style="width: 300px;" type="text" name="last_name" value="<?php echo htmlentities($judge_last_name); ?>" />
			</p>
			
			
			<input type="hidden" name="cmd" value="add" />
			
			<p>
				<input type="submit" value="Add Judge" />
				<input onclick="window.location='addJudge.php'" type="button" value="Cancel" />
			</p>
		</form>
	</tr>
</table>