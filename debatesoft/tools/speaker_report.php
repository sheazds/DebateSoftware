<?php
/**
 * Created by PhpStorm.
 * User: Colton Aarts
 * Date: 2018-06-14
 * Time: 12:27 PM
 */
require_once "../dbconfig.php";

if(isset($_POST["speaker_name"])) {
    $name = explode(" ", $_POST["speaker_name"]);
    $first_name = $name[1];
    $last_name = $name[0];

    $sql = "SELECT speaker_id FROM speaker WHERE speaker_first_name = '$first_name' AND speaker_last_name = '$last_name'";
    $result = $conn ->query($sql);
    $row = $result ->fetch_assoc();

    $round_sql = "SELECT round_id, round_name FROM round";
    $round_result = $conn -> query($round_sql);

    $speaker_id = $row["speaker_id"];

    while($round_row = $round_result->fetch_assoc()) {
        $temp = $round_row["round_id"];
        $round_name = $round_row["round_name"];
        $sql = "SELECT *, `organization/structure` + `evidence/analysis` + `rebuttal/clash` + `delivery/etiquette` + `questioning/responding`
          AS total_score FROM ballot_speaker_scores 
          INNER JOIN ballot_round ON ballot_speaker_scores.ballot_id = ballot_round.ballot_id
          INNER JOIN round ON round.round_id = ballot_round.round_id
          WHERE speaker_id = '$speaker_id' AND round.round_id = '$temp'";
        $result = $conn->query($sql);

        echo "<table>";
        echo "<tr>";
        echo "<th>$round_name</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Organization/Structure</th>";
        echo "<th>Evidence/Analysis</th>";
        echo "<th>Rebuttal/Clash</th>";
        echo "<th>Delivery/Etiquette</th>";
        echo "<th>Questioning/Responding</th>";
        echo "<th>Total</th>";
        echo "<th>Comments</th>";
        echo "<th></th>";
        echo "</tr>";
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["organization/structure"] . "</td>";
                echo "<td>" . $row["evidence/analysis"] . "</td>";
                echo "<td>" . $row["rebuttal/clash"] . "</td>";
                echo "<td>" . $row["delivery/etiquette"] . "</td>";
                echo "<td>" . $row["questioning/responding"] . "</td>";
                echo "<td>" . $row["total_score"] . "</td>";
                echo "<td>" . $row["comments"] . "</td>";
                echo "<td></td>";
                echo "</tr>";
            }
        }
    }
}
?>

<tr>
    <form method="post" action="speaker_report.php">
        <td><select name="speaker_name">
                <option name="Select One">Select One</option>
                <?php
                require_once '../dbconfig.php';
                $sql = "SELECT speaker_first_name, speaker_last_name FROM speaker ORDER BY speaker_last_name, speaker_first_name";
                $result = $conn->query($sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['speaker_last_name'] ." " . $row["speaker_first_name"]. "'>" . $row['speaker_last_name'] ." " . $row["speaker_first_name"]. "</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="submit" name="submit" value="Submit"></td>
    </form>
</tr>
</table>
