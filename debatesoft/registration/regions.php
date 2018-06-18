<span>Schools must belong to a region. Create an appropriate region(s) for schools in the tournament.</span>
<?php
	require_once '../dbconfig.php';
	
	if (isset($_POST['cmd']))
	{
		if ($_POST['cmd'] == "add")
		{
			$stmt = $conn->prepare("INSERT INTO region (region_id, region_name) VALUES (?, ?)");
			$stmt->bind_param("is", $region_id, $region_name);

			// You do not want to assign a value to $region_id because it is auto-incremented so it is assigned 0 or NULL
			// Otherwise you give the variables the correct values based on user input and complete the call
			$region_id = 0;

			// You would replace this with the user input. region_name is a string of max length 20
			$region_name = $_POST['region_name'];

			if ($stmt->execute() === TRUE) {
				
			} else {
				//echo "Error: " . $stmt . "<br>" . $conn->error;
			}
		}
		else if ($_POST['cmd'] == "del")
		{
			$sql = "DELETE FROM region WHERE region_id=".$_POST['region_id'];

			if ($conn->query($sql) === TRUE) {
				//echo "Record deleted successfully";
			} else {
				//echo "Error deleting record: " . $conn->error;
			}
		}
	}
	
	$sql = "SELECT region_id, region_name FROM region";
	$result = $conn->query($sql);
?>

<table>
	<tr>
		<th>Region Name</th>
		<th></th>
	</tr>
	<?php
	if ($result->num_rows > 0) {
		// output data of each row

		while ($row = $result->fetch_assoc()) { ?>
			<tr>
				<td> <?php echo $row["region_name"] ?> </td>
				<td><input type='button' value='Del' onclick="del_region(<?php echo $row['region_id']; ?>)" /></td>
			</tr>
		<?php
		}
	} else {
		echo "<br> 0 results";
	}
	?>

	<tr>
		<form id="region_form">
			<td><input form="region_form" type="text" name="region_name" /></td>
			<td><input form="region_form" type="button" value="Add" onclick="add_region($('#region_form').serializeArray())" /></td>
		</form>
	</tr>
</table>

<script>
	function add_region(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		post_data['cmd'] = 'add';
		
		$.ajax({
			url: "registration/regions.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#regions_section').find('.section_content').html(return_data);
			},
		});
	}
	
	function del_region(id)
	{
		post_data = {'cmd':'del', 'region_id':id};
		
		$.ajax({
			url: "registration/regions.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#regions_section').find('.section_content').html(return_data);
			},
		});
	}
</script>
