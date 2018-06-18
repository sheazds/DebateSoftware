<?php
	require_once '../dbconfig.php';
	
	if (isset($_POST['cmd']))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO judge (judge_id, judge_first_name, judge_last_name, rank, school_id)
			VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("issii", $judge_id, $judge_first_name, $judge_last_name, $rank, $school_id);

			$school_name = $_POST['school_name'];
			$sql2 = "SELECT school_id FROM school WHERE school.school_name = '$school_name'";
			$result2 = $conn->query($sql2);

			// Judge_id is a auto-incremented value so it is set to 0.
			$judge_id = 0;

			// This is a string of max size 20
			$judge_first_name = $_POST["judges_first_name"];

			// Also a string of max size 20
			$judge_last_name = $_POST["judges_last_name"];

			// Integer that is currently not bounded but that can be changed
			$rank = $_POST["rank"];

			// Needs to be a valid school_id.
			$row2 = $result2 -> fetch_assoc();
			$school_id = $row2["school_id"];

			if ($stmt -> execute() === TRUE) {
				
			} else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;	
			}
		}	
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM judge WHERE judge_id=".$_POST['judge_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}
	}

	
	$sql = "SELECT judge_id, judge_first_name, judge_last_name, rank, school_name FROM judge INNER JOIN school 
		  ON school.school_id = judge.school_id";
	$result = $conn->query($sql);
?>
<table>
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Rank</th>
		<th>School Name</th>
		<th></th>
	</tr>
	<?php
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) { ?>
			<tr>
				<td> <?php echo $row["judge_first_name"]; ?> </td>
				<td> <?php echo $row["judge_last_name"]; ?> </td>
				<td> <?php echo $row["rank"]; ?> </td>
				<td> <?php echo $row["school_name"]; ?> </td>
				<td> <input type='button' value='Del' onclick="del_judge(<?php echo $row['judge_id']; ?>)" /> </td>
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
		<form id="judge_form">
			<td><input form="judge_form" type="text" name="judges_first_name"></td>
            <td><input form="judge_form" type="text" name="judges_last_name"></td>
            <td><input form="judge_form" type="text" name="rank"></td>
            <td><select form="judge_form" name='school_name'>
                    <option value="Select One"> Select One</option>
                    <?php
                        require_once '../dbconfig.php';
                        $sql = "SELECT school_name FROM school";
                        $result = $conn->query($sql);

                        while ($row = mysqli_fetch_array($result)){
                            echo "<option value = '" .$row['school_name'] . "'>" . $row['school_name'] . "</option>";
                        }
                    ?>
                </select>
            </td>
			<td><input form="judge_form" type="button" value="Add" onclick="add_judge($('#judge_form').serializeArray())" /></td>
		</form>
	</tr>
</table>

<script>
	function add_judge(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "registration/judges.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#judges_section').find('.section_content').html(return_data);
			},
		});
	}
	
	function del_judge(id)
	{
		post_data = {'cmd':'del', 'judge_id':id};
		
		$.ajax({
			url: "registration/judges.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#judges_section').find('.section_content').html(return_data);
			},
		});
	}
</script>