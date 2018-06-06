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


$sql = "SELECT region_id, region_name FROM region";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table>";
		echo "<tr>";
		echo "<th>region_id</th>";
		echo "<th>region_name</th>";
		echo "<th></th>";
	echo "</tr>";
	
    while($row = $result->fetch_assoc())
	{
		echo "<tr>";
			echo "<td>" . $row["region_id"]. "</td>";
			echo "<td>" . $row["region_name"]. "</td>";
			echo "<td></td>";
		echo "</tr>";
    }
} else {
    echo "<br> 0 results";	
}

?>
<?php

if(isset($_POST["submit"]))
{
	$id = $_POST["region_id"];
	$name = $_POST["region_name"];
    $sql = "DELETE FROM region WHERE region_id = $id";
	if ($conn->query($sql) === TRUE) {
		header("Refresh:0");
		echo "Record deleted";
		
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
?>

<tr>
		<form method="post">
			<td><input type="text" name="region_id"></td>
			<td><input type="text" name="region_name"></td>
			<td><input type="submit" name="submit" value="Delete"></td>
		</form>
	</tr>
</table>