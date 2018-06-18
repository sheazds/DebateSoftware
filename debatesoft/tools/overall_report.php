<?php
require_once '../dbconfig.php';

/**
 * Created by PhpStorm.
 * User: Colton Aarts
 * Date: 2018-06-14
 * Time: 12:27 PM
 */


$round_sql = "SELECT round_id, round_name FROM round";
$round_result = $conn -> query($round_sql);

while($round_row = $round_result->fetch_assoc()) {
    $temp = $round_row["round_id"];
    $round_name = $round_row["round_name"];
    $sql = "SELECT `organization/structure` + `evidence/analysis` + `rebuttal/clash` + `delivery/etiquette` + `questioning/responding`
          AS total_score, speaker_first_name, speaker_last_name, ballot_round.ballot_id,  round.round_id FROM ballot_speaker_scores 
          INNER JOIN ballot_round ON ballot_speaker_scores.ballot_id = ballot_round.ballot_id
          INNER JOIN round ON round.round_id = ballot_round.round_id
          INNER JOIN speaker ON ballot_speaker_scores.speaker_id = speaker.speaker_id
          WHERE round.round_id = '$temp'
          GROUP BY  total_score DESC, speaker_last_name, speaker_first_name, ballot_round.ballot_id";
    $result = $conn->query($sql);

    echo "<table>";
    echo "<tr>";
    echo "<th>$round_name</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<th>Total Score</th>";
    echo "<th>Speaker Name</th>";
    echo "<th></th>";
    echo "</tr>";
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["total_score"] . "</td>";
            echo "<td>" . $row["speaker_last_name"] .", " . $row["speaker_first_name"] . "</td>";
            echo "<td></td>";
            echo "</tr>";
        }
    }
}

echo "<table>";
echo "<tr>";
echo "<th>Overall</th>";
echo "</tr>";
echo "<tr>";
echo "<th>Total Score</th>";
echo "<th>Speaker Name</th>";
echo "<th></th>";
echo "</tr>";

$overall_sql = "SELECT `organization/structure` + `evidence/analysis` + `rebuttal/clash` + `delivery/etiquette` + `questioning/responding`
          AS total_score, speaker_first_name, speaker_last_name FROM ballot_speaker_scores 
          INNER JOIN ballot_round ON ballot_speaker_scores.ballot_id = ballot_round.ballot_id
          INNER JOIN round ON round.round_id = ballot_round.round_id
          INNER JOIN speaker ON ballot_speaker_scores.speaker_id = speaker.speaker_id
          GROUP BY  total_score DESC, speaker_last_name, speaker_first_name";
$overall_result = $conn->query($overall_sql);
if ($overall_result->num_rows > 0) {
    // output data of each row
    while ($overall_row = $overall_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $overall_row["total_score"] . "</td>";
        echo "<td>" . $overall_row["speaker_last_name"] .", " . $overall_row["speaker_first_name"] . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}
