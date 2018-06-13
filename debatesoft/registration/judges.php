 <?php
 require_once '../dbconfig.php';
 $sql = "SELECT judge_id, judge_first_name, judge_last_name, rank, school_name FROM judge INNER JOIN school 
          ON school.school_id = judge.school_id";
 $result = $conn->query($sql);


 echo "<table>";
 echo "<tr>";
 echo "<th>Judge ID</th>";
 echo "<th>First Name</th>";
 echo "<th>Last Name</th>";
 echo "<th>Rank</th>";
 echo "<th>School Name</th>";
 echo "<th></th>";
 echo "</tr>";

 if ($result->num_rows > 0) {
     // output data of each row

     while($row = $result->fetch_assoc())
     {
         echo "<tr>";
         echo "<td>" . $row["judge_id"]. "</td>";
         echo "<td>" . $row["judge_first_name"]. "</td>";
         echo "<td>" . $row["judge_last_name"]. "</td>";
         echo "<td>" . $row["rank"]. "</td>";
         echo "<td>" . $row["school_name"]. "</td>";
         echo "<td></td>";
         echo "</tr>";
     }
 } else {
     echo "<br> 0 results";
 }

 if(isset($_POST["judges_first_name"]))
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
         echo "New record created successfully";
         header("Refresh:0");

     } else {
         echo "Error: " . $stmt . "<br>" . $conn->error;
     }
     echo "<meta http-equiv='refresh' content='0;URL=http://localhost/debatesoft/registration.php#'/>";
 }
?>

	<tr>
		<form method="post" action="registration/judges.php">
			<td>
                <?php
                require_once '../dbconfig.php';
                $sql = "SELECT MAX(judge_id) + 1 AS judge_id FROM judge";
                $result = $conn->query($sql);

                $row = $result->fetch_assoc();

                echo $row["judge_id"];
                ?>
            </td>
			<td><input type="text" name="judges_first_name"></td>
            <td><input type="text" name="judges_last_name"></td>
            <td><input type="text" name="rank"></td>
            <td><select name='school_name'>
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
			<td><input type="submit" name="submit" value="Add"></td>
		</form>
	</tr>
</table>