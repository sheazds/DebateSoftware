 <?php
	require_once '../dbconfig.php';
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

	if(isset($_POST["submit"]))
	{
		$id = $_POST["region_id"];
		$name = $_POST["region_name"];
		$sql = "INSERT INTO region (region_id, region_name) VALUES ('$id', '$name')";
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
			header("Refresh:0");
		} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
?>

	<tr>
		<form method="post">
			<td><input type="text" name="region_id"></td>
			<td><input type="text" name="region_name"></td>
			<td><input type="submit" name="submit" value="Add"></td>
		</form>
	</tr>
</table>