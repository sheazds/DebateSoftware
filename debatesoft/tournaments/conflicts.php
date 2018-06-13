<?php
require_once '../dbconfig.php';
$sql = "SELECT judge_first_name, judge_last_name, speaker_first_name, speaker_last_name FROM scratches 
          INNER JOIN judge ON scratches.judge_id = judge.judge_id INNER JOIN speaker ON scratches.speaker_id = speaker.speaker_id";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>Judge Name</th>";
echo "<th>Speaker Name</th>";
echo "<th></th>";
echo "</tr>";
if ($result->num_rows > 0) {
    // output data of each row


    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>" . $row["judge_first_name"]. " ".$row["judge_last_name"]. "</td>";
        echo "<td>" . $row["speaker_first_name"]." ".$row["speaker_last_name"] . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}

if(isset($_POST["judge_name"]))
{

    $stmt = $conn->prepare("INSERT INTO scratches (judge_id, speaker_id) VALUES (?, ?)");
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
        echo "New record created successfully";
        header("Refresh:0");
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
    echo "<meta http-equiv='refresh' content='0;URL=http://localhost/debatesoft/tournaments.php#'/>";
}
?>

<tr>
    <form method="post" action="tournaments/conflicts.php">
        <td><select name="judge_name">
                <option name="Select One">Select One</option>
                <?php
                require_once '../dbconfig.php';
                $sql = "SELECT judge_first_name, judge_last_name, judge_id FROM judge ORDER BY judge_id";
                $result = $conn->query($sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['judge_first_name'] . " ". $row['judge_last_name']."'>". $row['judge_first_name'] . " ". $row['judge_last_name']. "</option>";
                }
                ?>
            </select>
            <select name="speaker_name">
                <option name="Select One">Select One</option>
                <?php
                require_once '../dbconfig.php';
                $sql = "SELECT speaker_first_name, speaker_last_name, speaker_id FROM speaker ORDER BY speaker_id";
                $result = $conn->query($sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['speaker_first_name'] . " ". $row['speaker_last_name']."'>". $row['speaker_first_name'] . " ". $row['speaker_last_name']. "</option>";
                }
                ?>
            </select>
        <td><input type="submit" name="submit" value="Add"></td>
    </form>
</tr>
</table>