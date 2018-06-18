<?php
/**
 * Created by PhpStorm.
 * User: Colton Aarts
 * Date: 2018-06-14
 * Time: 12:27 PM
 */

require_once "../dbconfig.php";

if(isset($_POST["team_name"])) {
    $sql = "SELECT round_id, round_name FROM round";
    $result = $conn ->query($sql);

    while($row = $result ->fetch_assoc()) {

        $round_id = $row["round_id"];
        $round_name = $row["round_name"];
        $team_name = $_POST["team_name"];

        $info_sql = "SELECT `organization/structure` + `evidence/analysis` + `rebuttal/clash` + `delivery/etiquette` 
            + `questioning/responding` AS total_score, speaker.speaker_id, speaker_first_name, speaker_last_name FROM ballot_speaker_scores 
            INNER JOIN speaker ON ballot_speaker_scores.speaker_id = speaker.speaker_id
            INNER JOIN team ON speaker.team_id = team.team_id
            INNER JOIN ballot_round ON ballot_speaker_scores.ballot_id = ballot_round.round_id
            WHERE round_id = '$round_id' AND team.team_name = '$team_name'
            GROUP BY round_id, speaker.speaker_id, speaker_last_name, speaker_first_name";
        $info_result = $conn ->query($info_sql);

        echo "<table>";
        echo "<tr>";
        echo "<th>$round_name</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Speaker Score</th>";
        echo "<th>Speaker Name</th>";
        echo "<th></th>";
        echo "</tr>";

        $total = 0;

        if ($info_result->num_rows > 0) {
            // output data of each row
            while ($info_row = $info_result->fetch_assoc()) {
                $total = $total + $info_row["total_score"];
                echo "<tr>";
                echo "<td>" . $info_row["total_score"] . "</td>";
                echo "<td>" . $info_row["speaker_last_name"]. ", " . $info_row["speaker_first_name"] . "</td>";
                echo "<td></td>";
                echo "</tr>";
            }
        }
        echo "<tr>";
        echo "<th>Total Score</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>$total</th>";
        echo "</tr>";

    }
}

?>
<tr>
    <form method="post" action="team_report.php">
        <td><select name="team_name">
                <option name="Select One">Select One</option>
                <?php
                require_once '../dbconfig.php';
                $sql = "SELECT team_name FROM team ORDER BY team_name";
                $result = $conn->query($sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['team_name'] . "'>" . $row['team_name'] . "</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="submit" name="submit" value="Submit"></td>
    </form>
</tr>
</table>

