<?php
	require_once '../dbconfig.php';
	
	if (isset($_POST['cmd']))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO pairing_preference (pp_id, pp_name, custom_bracket_size, reseed_pullout, 
						  matching_type, max_allowed_govt_assignments, random_room_assignment, bracket_type, same_school, same_region, 
						  pullup_only_once, previously_paired, pullout_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("isississsssss", $pp_id, $pp_name, $custom_bracket_size, $reseed_pullout,
				$matching_type, $max_allowed_govt_assignments, $random_room_assignment, $bracket_type, $same_school, $same_region,
				$pullup_only_once, $previously_paired, $pullout_type);

			$pp_id = 0;
			$pp_name = $_POST["pp_name"];
			$custom_bracket_size = $_POST["custom_bracket_size"];
			$reseed_pullout = $_POST["reseed_pullout"];
			$matching_type = $_POST["matching_type"];
			$max_allowed_govt_assignments = $_POST["max_allowed_govt_assignments"];
			$random_room_assignment = $_POST["random_room_assignment"];
			$bracket_type = $_POST["bracket_type"];
			$same_school = $_POST["same_school"];
			$same_region = $_POST["same_region"];
			$pullup_only_once = $_POST["pullup_only_once"];
			$previously_paired = $_POST["previously_paired"];
			$pullout_type = $_POST["pullup_type"];

			if ($stmt->execute() === TRUE) {

			} else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;
			}
		}
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM pairing_preference WHERE pp_id=".$_POST['pp_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}

	}
?>

<table class='pairing_preferences_table'>
	<tr>
		<th>PP Name</th>
		<th>Custom Bracket Size</th>
		<th>Reseed Pull Up</th>
		<th>Matching Type</th>
		<th>Max Allowed Gov Assignments</th>
		<th>Random Room Assignments</th>
		<th>Bracket Type</th>
		<th>Same School</th>
		<th>Same Region</th>
		<th>Pull Up Only Once</th>
		<th>Previously Paired</th>
		<th>Pull Up Type</th>
		<th></th>
	</tr>
	<?php
	$sql = "SELECT * FROM pairing_preference";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) { ?>
				<tr>
				<td> <?php echo $row["pp_name"]; ?> </td>
				<td> <?php echo $row["custom_bracket_size"]; ?> </td>
				<td> <?php echo $row["reseed_pullout"]; ?> </td>
				<td> <?php echo $row["matching_type"]; ?> </td>
				<td> <?php echo $row["max_allowed_govt_assignments"]; ?> </td>
				<td> <?php echo $row["random_room_assignment"]; ?> </td>
				<td> <?php echo $row["bracket_type"]; ?> </td>
				<td> <?php echo $row["same_school"]; ?> </td>
				<td> <?php echo $row["same_region"]; ?> </td>
				<td> <?php echo $row["pullup_only_once"]; ?> </td>
				<td> <?php echo $row["previously_paired"]; ?> </td>
				<td> <?php echo $row["pullout_type"]; ?> </td>
				<td> <input type='button' value='Del' onclick="del_pp(<?php echo $row['pp_id']; ?>)" /> </td>
			</tr>
		<?php
		}
	}
	else {
		echo "<br> 0 results";
	}
	?>
	<tr>
		<form id="pp_form">
			<td><input form="pp_form" type="text" name="pp_name"></td>
			<td><input form="pp_form" type="text" name="custom_bracket_size"></td>
			<td><select form="pp_form" name="reseed_pullout">
					<option value="T">T</option>
					<option value="F">F</option>
				</select></td>
			<td><select form="pp_form" name="matching_type">
					<option value="Random">Random</option>
					<option value="High-High">High-High</option>
					<option value="High-Low">High-Low</option>
				</select></td>
			<td><input form="pp_form" type="text" name="max_allowed_govt_assignments"></td>
			<td><select form="pp_form" name="random_room_assignment">
					<option value="T">T</option>
					<option value="F">F</option>
				</select></td>
			<td><select form="pp_form" name="bracket_type">
					<option name="No Bracketing">No Bracketing</option>
					<option name="Win-Loss">Win-Loss</option>
					<option name="Uniform Size">Uniform Size</option>
					<option name="Custom Size">Custom Size</option>
				</select></td>
			<td><select form="pp_form" name="same_school">
					<option value="T">T</option>
					<option value="F">F</option>
				</select></td>
			<td><select form="pp_form" name="same_region">
					<option value="T">T</option>
					<option value="F">F</option>
				</select></td>
			<td><select form="pp_form" name="pullup_only_once">
					<option value="T">T</option>
					<option value="F">F</option>
				</select></td>
			<td><select form="pp_form" name="previously_paired">
					<option value="T">T</option>
					<option value="F">F</option>
				</select></td>
			<td><select form="pp_form" name="pullup_type">
					<option name="Top Pullup">Top Pullup</option>
					<option name="Middle Pullup">Middle Pullup</option>
					<option name="Bottom Pullup">Bottom Pullup</option>
				</select></td>
			<td><input form="pp_form" type="button" value="Add" onclick="add_pp($('#pp_form').serializeArray())" /></td>
		</form>
	</tr>
</table>

<script>
	function add_pp(form)
	{
		console.log(form);
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "tournaments/preferences.php",
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function del_pp(id)
	{
		post_data = {'cmd':'del', 'pp_id':id};
		
		$.ajax({
			url: "tournaments/preferences.php",
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
</script>
