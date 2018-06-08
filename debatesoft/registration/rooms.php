 <?php
 require_once '../dbconfig.php';
 $sql = "SELECT room_id, room_name, room_priority FROM room";
 $result = $conn->query($sql);

 echo "<table>";
 echo "<tr>";
 echo "<th>Room ID</th>";
 echo "<th>Room Name</th>";
 echo "<th>Room Priority</th>";
 echo "<th></th>";
 echo "</tr>";
 if ($result->num_rows > 0) {
     // output data of each row


     while($row = $result->fetch_assoc())
     {
         echo "<tr>";
         echo "<td>" . $row["room_id"]. "</td>";
         echo "<td>" . $row["room_name"]. "</td>";
         echo "<td>" . $row["room_priority"]. "</td>";
         echo "<td></td>";
         echo "</tr>";
     }
 } else {
     echo "<br> 0 results";
 }

 if(isset($_POST["room_name"]))
 {

     $stmt = $conn->prepare("INSERT INTO room (room_id, room_name, room_priority) VALUES (?, ?, ?)");
     $stmt->bind_param("isi", $room_id, $room_name, $room_priority);

     // room_id is an auto-incremented value so it is set to 0.
     $room_id = 0;

     // room_name is a string of max length 20
     $room_name = $_POST["room_name"];

     // Unbounded integer that can be bound to acceptable values.
     $room_priority = $_POST["room_priority"];

     if ($stmt -> execute() === TRUE) {
         echo "New record created successfully";
         header("Refresh:0");
     } else {
         echo "Error: " . $stmt . "<br>" . $conn->error;
     }
 }
?>

	<tr>
		<form method="post">
			<td>
                <?php
                require_once '../dbconfig.php';
                $sql = "SELECT MAX(room_id) + 1 AS room_id FROM room";
                $result = $conn->query($sql);

                $row = $result->fetch_assoc();

                echo $row["room_id"];
                ?>
            </td>
			<td><input type="text" name="rooms_name"></td>
            <td><input type="text" name="room_priority"></td>
			<td><input type="submit" name="submit" value="Add"></td>
		</form>
	</tr>
</table>