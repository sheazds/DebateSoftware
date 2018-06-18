<?php
	require_once '../dbconfig.php';
	
	if (isset($_POST["cmd"]))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO team (team_id, team_name, school_id, team_rank) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("isii", $team_id, $team_name, $school_id, $team_rank);

			$school_name = $_POST['school_name'];
			$sql2 = "SELECT school_id FROM school WHERE school.school_name = '$school_name'";
			$result2 = $conn->query($sql2);
			// team_id is an auto-incremented value so it is initialized to zero.
			$team_id = 0;

			// team_name is a string of max length 20
			$team_name = $_POST["team_name"];

			// Needs to be a valid school_name
			$row2 = $result2->fetch_assoc();
			$school_id = $row2["school_id"];
			// team_rank is an unbounded integer
			$team_rank = 0;

			if ($stmt->execute() === TRUE) {

			} else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;
			}
		}
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM team WHERE team_id=".$_POST['team_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}
	}
	
	
	
	$sql = "SELECT team_id, team_name, school_name FROM team INNER JOIN school ON team.school_id = school.school_id";
	$result = $conn->query($sql);


?>
<table>
	<tr>
		<th>Team Name</th>
		<th>School Name</th>
		<th></th>
	</tr>
	
	<?php
	if ($result->num_rows > 0)
	{
		// output data of each row
		while ($row = $result->fetch_assoc()) { ?>
			<tr>
				<td> <?php echo $row["team_name"] ?> </td>
				<td> <?php echo $row["school_name"] ?> </td>
				<td> <input type='button' value='Del' onclick="del_team(<?php echo $row['team_id']; ?>)" /> </td>
			</tr>
		<?php
		}
	}
	else
	{
		echo "<br> 0 results";
	}
	?>

	<tr>
		<form id="team_form">
			<td><input form="team_form" type="text" name="team_name"></td>
			<td><select form="team_form" name="school_name">
					<option name="Select One">Select One</option>
					<?php
					require_once '../dbconfig.php';
					$sql = "SELECT school_name FROM school";
					$result = $conn->query($sql);

					while ($row = mysqli_fetch_array($result)) {
						echo "<option value = '" . $row['school_name'] . "'>" . $row['school_name'] . "</option>";
					}
					?>
				</select>
			</td>
			<td><input form="team_form" type="button" value="Add" onclick="add_team($('#team_form').serializeArray())" /></td>
		</form>
	</tr>
</table>

<script>
	function add_team(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "registration/teams.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#teams_section').find('.section_content').html(return_data);
			},
		});
	}
	
	function del_team(id)
	{
		post_data = {'cmd':'del', 'team_id':id};
		
		$.ajax({
			url: "registration/teams.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#teams_section').find('.section_content').html(return_data);
			},
		});
	}
</script>