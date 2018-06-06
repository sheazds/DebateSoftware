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


$sql = "SELECT school_id, school_name, region_id FROM school";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table>";
		echo "<tr>";
		echo "<th>school_id</th>";
		echo "<th>school_name</th>";
		echo "<th>region_id</th>";
		echo "<th></th>";
	echo "</tr>";
	
    while($row = $result->fetch_assoc())
	{
		echo "<tr>";
			echo "<td>" . $row["school_id"]. "</td>";
			echo "<td>" . $row["school_name"]. "</td>";
			echo "<td>" . $row["region_id"]. "</td>";
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
	$sid = $_POST["school_id"];
	$name = $_POST["school_name"];
	$id = $_POST["region_id"];
    $sql = "INSERT INTO school (school_id, school_name, region_id) VALUES ('$sid','$name', '$id')";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
		header("Refresh:0");
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
}
?>

<form method="post" action="addSchool.php" >
			<p>
				School Name<br />
				<input id="school_name" style="width: 400px;" type="text" name="school_name" value=" " /><br />
				Region<br />
				<select name ="region_id">
				<?php
					$query = "SELECT region_id FROM region";
					$regions =mysqli_query($conn, $query);
					$options = "";
					while ($region = mysqli_fetch_array($regions)) {
						$options = $options."<option>$region[0]</option>";
					}
					echo $options;
		
				?>
				</select>
			</p>
			<input type="hidden" name="cmd" value="add" />
			<input type="submit" value="Add School" />
			<input onclick="window.location='addSchool.php'" type="button" value="Cancel" />
		</form>