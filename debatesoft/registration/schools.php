<?php
	require_once '../dbconfig.php';

	if (isset($_POST['cmd']))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO school (school_id, school_name, region_id) VALUES (?, ?, ?)");
			$stmt->bind_param("isi", $school_id, $school_name, $region_id);

			$region_name = $_POST["region_name"];
			$sql2 ="SELECT region_id FROM region WHERE region.region_name = '$region_name'";
			$result2 = $conn->query($sql2);

			// school_id is an auto-incremented value so it is set to 0.
			$school_id = 0;

			// school_name is a string that is max length 20
			$school_name = $_POST['school_name'];

			// Needs to be a valid region_id
			$row2 = $result2->fetch_assoc();
			$region_id = $row2["region_id"];


			if ($stmt->execute() === TRUE) {

			} else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;
			}
		}
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM school WHERE school_id=".$_POST['school_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}
	}



	$sql = "SELECT school_id, school_name, region_name FROM school 
		INNER JOIN region ON school.region_id = region.region_id";
	$result = $conn->query($sql);
?>
	<table>
		<tr>
			<th>School Name</th>
			<th>Region Name</th>
			<th></th>
		</tr>
		<?php
		if ($result->num_rows > 0) {
			// output data of each row
			while ($row = $result->fetch_assoc()) { ?>
				<tr>
					<td> <?php echo $row["school_name"] ?> </td>
					<td> <?php echo $row["region_name"] ?> </td>
					<td> <input type='button' value='Del' onclick="del_school(<?php echo $row['school_id']; ?>)" /> </td>
				</tr>
			<?php
			}
		} else {
			echo "<br> 0 results";
		}
		?>

		<tr>
			<form id="school_form">
				<td>
					<input form="school_form" type="hidden" name="school_id" value="<?php echo $row['school_id']; ?>" />
					<input form="school_form" type="text" name="school_name"></td>
				<td><select form="school_form" name="region_name">
						<option name="Select One">Select One</option>
						<?php
						require_once '../dbconfig.php';
						$sql = "SELECT region_name FROM region";
						$result = $conn->query($sql);

						while ($row = mysqli_fetch_array($result)) {
							echo "<option value = '" . $row['region_name'] . "'>" . $row['region_name'] . "</option>";
						}
						?>
					</select>
				</td>
				<td><input form="school_form" type="button" value="Add" onclick="add_school($('#school_form').serializeArray())" /></td>
			</form>
		</tr>
</table>

<script>
	function add_school(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "registration/schools.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#schools_section').find('.section_content').html(return_data);
			},
		});
	}
	
	function del_school(id)
	{
		post_data = {'cmd':'del', 'school_id':id};
		
		$.ajax({
			url: "registration/schools.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#schools_section').find('.section_content').html(return_data);
			},
		});
	}
</script>