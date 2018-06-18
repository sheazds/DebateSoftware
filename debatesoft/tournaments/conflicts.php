<?php
	require_once '../dbconfig.php';
	
	if (isset($_POST['cmd']))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO scratch (judge_id, speaker_id) VALUES (?, ?)");
			$stmt->bind_param("ii", $judge_id, $speaker_id);

			$judge_name = $_POST["judge_name"];
			$arr = explode(" ", $judge_name);
			$judge_first_name = $arr[0];
			$judge_last_name = $arr[1];
			$sql2 = "SELECT judge_id FROM judge WHERE judge.judge_first_name = '$judge_first_name' 
					  AND judge.judge_last_name = '$judge_last_name'";
			$result2 = $conn->query($sql2);

			$row2 = $result2 -> fetch_assoc();
			$judge_id = $row2["judge_id"];

			$speaker_name = $_POST["speaker_name"];
			$arr2 = explode(" ", $speaker_name);
			$speaker_first_name = $arr2[0];
			$speaker_last_name = $arr2[1];
			$sql3 = "SELECT speaker_id FROM speaker WHERE speaker.speaker_first_name = '$speaker_first_name' 
					  AND speaker.speaker_last_name = '$speaker_last_name'";
			$result3 = $conn->query($sql3);

			$row3 = $result3 -> fetch_assoc();
			$speaker_id = $row3["speaker_id"];

			if ($stmt -> execute() === TRUE) {

			}
			else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;
			}
		}
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM scratch WHERE judge_id=".$_POST['judge_id']." AND speaker_id=".$_POST['speaker_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}
	}
	
	$sql = "SELECT judge.judge_id, judge_first_name, judge_last_name, speaker.speaker_id, speaker_first_name, speaker_last_name FROM scratch 
		  INNER JOIN judge ON scratch.judge_id = judge.judge_id INNER JOIN speaker ON scratch.speaker_id = speaker.speaker_id";
	$result = $conn->query($sql);
	?>

<table>
	<tr>
		<th>Judge Name</th>
		<th>Speaker Name</th>
		<th></th>
	</tr>
	<?php
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()){ ?>
			<tr>
				<td> <?php echo $row["judge_first_name"]. " ".$row["judge_last_name"]; ?> </td>
				<td> <?php echo $row["speaker_first_name"]." ".$row["speaker_last_name"]; ?> </td>
				<td> <input type='button' value='Del' onclick="del_conflict(<?php echo $row['judge_id']; ?>, <?php echo $row['speaker_id']; ?>)" /> </td>
			</tr>
		<?php
		}
	}
	else {
		echo "<br> 0 results";
	}
	?>
	<tr>
		<form id="conflict_form">
			<td><select form="conflict_form" name="judge_name">
				<option name="Select One">Select One</option>
				<?php
				require_once '../dbconfig.php';
				$sql = "SELECT judge_first_name, judge_last_name, judge_id FROM judge ORDER BY judge_id";
				$result = $conn->query($sql);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value = '" . $row['judge_first_name'] . " ". $row['judge_last_name']."'>". $row['judge_first_name'] . " ". $row['judge_last_name']. "</option>";
				}
				?>
			</select></td>
			<td><select form="conflict_form" name="speaker_name">
				<option name="Select One">Select One</option>
				<?php
				require_once '../dbconfig.php';
				$sql = "SELECT speaker_first_name, speaker_last_name, speaker_id FROM speaker ORDER BY speaker_id";
				$result = $conn->query($sql);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value = '" . $row['speaker_first_name'] . " ". $row['speaker_last_name']."'>". $row['speaker_first_name'] . " ". $row['speaker_last_name']. "</option>";
				}
				?>
			</select></td>
			<td><input form="conflict_form" type="button" value="Add" onclick="add_conflict($('#conflict_form').serializeArray())" /></td>
		</form>
	</tr>
</table>

<script>
	function add_conflict(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "tournaments/conflicts.php",
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function del_conflict(judge_id, speaker_id)
	{
		post_data = {'cmd':'del', 'judge_id':judge_id, 'speaker_id':speaker_id};
		
		$.ajax({
			url: "tournaments/conflicts.php",
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}