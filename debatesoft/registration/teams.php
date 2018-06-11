<?php
require_once '../dbconfig.php';
$sql = "SELECT team_id, team_name, school_name FROM team INNER JOIN school ON team.school_id = school.school_id";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>Team ID</th>";
echo "<th>Team Name</th>";
echo "<th>School Name</th>";
echo "<th></th>";
echo "</tr>";

if ($result->num_rows > 0) {
    // output data of each row


    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["team_id"] . "</td>";
        echo "<td>" . $row["team_name"] . "</td>";
        echo "<td>" . $row["school_name"] . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}

if (isset($_POST["team_name"])) {
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
        echo "New record created successfully";
        header("Refresh:0");
        echo "<meta http-equiv='refresh' content='0;URL=http://localhost/debatesoft/registration.php#'/>";
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
}
?>

<tr>
    <form method="post" action="registration/teams.php">
        <td>
            <?php
            require_once '../dbconfig.php';
            $sql = "SELECT MAX(team_id) + 1 AS team_id FROM team";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();

            echo $row["team_id"];
            ?>
        </td>
        <td><input type="text" name="team_name"></td>
        <td><select name="school_name">
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
        <td><input type="submit" name="submit" value="Add"></td>
    </form>
</tr>
</table>