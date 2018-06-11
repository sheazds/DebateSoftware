<?php
require_once '../dbconfig.php';

$sql = "SELECT speaker_id, speaker_first_name, speaker_last_name, team_name FROM speaker 
          INNER JOIN team ON speaker.team_id = team.team_id";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>Speaker ID</th>";
echo "<th>First Name</th>";
echo "<th>Last Name</th>";
echo "<th>Team Name</th>";
echo "<th></th>";
echo "</tr>";
if ($result->num_rows > 0) {
    // output data of each row


    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["speaker_id"] . "</td>";
        echo "<td>" . $row["speaker_first_name"] . "</td>";
        echo "<td>" . $row["speaker_last_name"] . "</td>";
        echo "<td>" . $row["team_name"] . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}

if (isset($_POST['speaker_first_name'])) {

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
        echo "New record created successfully";
        header("Refresh:0");
        echo "<meta http-equiv='refresh' content='0;URL=http://localhost/debatesoft/registration.php#'/>";
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
}
?>

<tr>
    <form method="post"action="registration/speakers.php">
        <td>
            <?php
            require_once '../dbconfig.php';
            $sql = "SELECT MAX(speaker_id) + 1 AS speaker_id FROM speaker";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();

            echo $row["speaker_id"];
            ?>
        </td>
        <td><input type="text" name="speaker_first_name"></td>
        <td><input type="text" name="speaker_last_name"></td>
        <td><select name="team_name">
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
        <td><input type="submit" name="submit" value="Add"></td>
    </form>
</tr>
</table>