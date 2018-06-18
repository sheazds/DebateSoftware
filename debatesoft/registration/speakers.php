<?php
	require_once '../dbconfig.php';
	
	if (isset($_POST['cmd']))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO speaker (speaker_id, speaker_first_name, 
				speaker_last_name, rank, school_id, team_id) VALUES (?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("issiii", $speaker_id, $speaker_first_name, $speaker_last_name, $rank, $school_id, $team_id);

			$team_name = $_POST['team_name'];

			$sql2 = "SELECT school_id FROM team WHERE team_name = '$team_name'";
			$result2 = $conn->query($sql2);

			$sql3 = "SELECT team_id FROM team WHERE team.team_name = '$team_name'";
			$result3 = $conn->query($sql3);

			//speaker_id is an auto-increment value so it is initialized to zero
			$speaker_id = 0;

			//speaker_first_name is a string of 20 characters max
			$speaker_first_name = $_POST["speaker_first_name"];

			// speaker_last_name is a string of 20 characters max
			$speaker_last_name = $_POST["speaker_last_name"];

			// rank is an unbounded int
			$rank = 0;

			// Needs to ba a valid school_id
			$row2 = $result2->fetch_assoc();
			$school_id = $row2['school_id'];

			//Needs to be a valid team_id
			$row3 = $result3->fetch_assoc();
			$team_id = $row3['team_id'];


			if ($stmt->execute() === TRUE) {

			} else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;
			}
		}
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM speaker WHERE speaker_id=".$_POST['speaker_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}
	}

	$sql = "SELECT speaker_id, speaker_first_name, speaker_last_name, team_name FROM speaker 
			  INNER JOIN team ON speaker.team_id = team.team_id";
	$result = $conn->query($sql);
?>
<table>
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Team Name</th>
		<th></th>
	</tr>
<?php 
	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) { ?>
				<tr>
				<td> <?php echo $row["speaker_first_name"]; ?></td>
				<td> <?php echo $row["speaker_last_name"]; ?></td>
				<td> <?php echo $row["team_name"]; ?></td>
				<td> <input type='button' value='Del' onclick="del_speaker(<?php echo $row['speaker_id']; ?>)" /> </td>
			</tr>
		<?php
		}
	} else {
		echo "<br> 0 results";
	}
	?>

	<tr>
		<form id="speaker_form">
			<td><input form="speaker_form" type="text" name="speaker_first_name"></td>
			<td><input form="speaker_form" type="text" name="speaker_last_name"></td>
			<td><select form="speaker_form" name="team_name">
					<option name="Select One">Select One</option>
					<?php
					require_once '../dbconfig.php';
					$sql = "SELECT team_name FROM team";
					$result = $conn->query($sql);

					while ($row = mysqli_fetch_array($result)) {
						echo "<option value = '" . $row['team_name'] . "'>" . $row['team_name'] . "</option>";
					}
					?>
				</select>
			</td>
			<td><input form="speaker_form" type="button" value="Add" onclick="add_speaker($('#speaker_form').serializeArray())" /></td>
		</form>
	</tr>
</table>

<script>
	function add_speaker(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "registration/speakers.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#speakers_section').find('.section_content').html(return_data);
			},
		});
	}
	
	function del_speaker(id)
	{
		post_data = {'cmd':'del', 'speaker_id':id};
		
		$.ajax({
			url: "registration/speakers.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#speakers_section').find('.section_content').html(return_data);
			},
		});
	}
</script>