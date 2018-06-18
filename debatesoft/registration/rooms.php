<?php
	require_once '../dbconfig.php';
	
	if (isset($_POST['cmd']))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO room (room_id, room_name, room_priority) VALUES (?, ?, ?)");
			$stmt->bind_param("isi", $room_id, $room_name, $room_priority);

			// room_id is an auto-incremented value so it is set to 0.
			$room_id = 0;

			// room_name is a string of max length 20
			$room_name = $_POST['rooms_name'];

			// Unbounded integer that can be bound to acceptable values.
			$room_priority = $_POST['room_priority'];

			if ($stmt -> execute() === TRUE) {
			
			}
			else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;
			}
		}
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM room WHERE room_id=".$_POST['room_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}
	}
	
	$sql = "SELECT room_id, room_name, room_priority FROM room";
	$result = $conn->query($sql);
?>
<table>
	<tr>
		<th>Room Name</th>
		<th>Room Priority</th>
		<th></th>
	</tr>
	<?php
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()){ ?>
			 <tr>
				<td> <?php echo $row["room_name"]; ?> </td>
				<td> <?php echo $row["room_priority"]; ?> </td>
				<td> <input type='button' value='Del' onclick="del_room(<?php echo $row['room_id']; ?>)" /> </td>
			</tr>
		<?php
		}
	}
	else {
		echo "<br> 0 results";
	}
	?>
	<tr>
		<form id="room_form">
			<td><input form="room_form" type="text" name="rooms_name"></td>
            <td><input form="room_form" type="text" name="room_priority"></td>
			<td><input form="room_form" type="button" value="Add" onclick="add_room($('#room_form').serializeArray())" /></td>
		</form>
	</tr>
</table>

<script>
	function add_room(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "registration/rooms.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#rooms_section').find('.section_content').html(return_data);
			},
		});
	}
	
	function del_room(id)
	{
		post_data = {'cmd':'del', 'room_id':id};
		
		$.ajax({
			url: "registration/rooms.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#rooms_section').find('.section_content').html(return_data);
			},
		});
	}
</script>