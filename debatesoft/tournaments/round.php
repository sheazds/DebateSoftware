<?php

require_once '../dbconfig.php';
$sql = "SELECT round_id, round_name, pp_name FROM round 
          INNER JOIN pairing_preference ON round.pp_id = pairing_preference.pp_id";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>Round ID</th>";
echo "<th>Round Name</th>";
echo "<th>Pairing Preference Name</th>";
echo "<th></th>";
echo "</tr>";
if ($result->num_rows > 0) {
    // output data of each row


    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>" . $row["round_id"]."</td>";
        echo "<td>" . $row["round_name"]."</td>";
        echo "<td>". $row["pp_name"]."</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}

if(isset($_POST["pp_name"]))
{

    $stmt = $conn->prepare("INSERT INTO round (round_id, round_name, pp_id) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $round_id,$round_name, $pp_id);

    $pp_name = $_POST["pp_name"];
    $sql2 = "SELECT pp_id FROM pairing_preference WHERE pp_name = '$pp_name'";
    $result2 = $conn ->query($sql2);

    $row2 = $result2 ->fetch_assoc();
    $pp_id = $row2["pp_id"];

    $round_id = 0;

    $round_name = $_POST["round_name"];

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
    <form method="post" action="tournaments/round.php">
        <td><input type="text" name="round_name"></td>
        <td>
            <select name="pp_name">
                <option name="Select One">Select One</option>
                <?php
                require_once '../dbconfig.php';
                $sql3 = "SELECT pp_name, pp_id FROM pairing_preference ORDER BY pp_id";
                $result3 = $conn->query($sql3);

                while ($row3 = mysqli_fetch_array($result3)) {
                    echo "<option value = '" . $row3['pp_name'] ."'>". $row3['pp_name'] .  "</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="submit" name="submit" value="Add"></td>
    </form>
</tr>
</table>