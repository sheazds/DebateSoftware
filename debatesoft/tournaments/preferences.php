<?php

require_once '../dbconfig.php';
$sql = "SELECT * FROM pairing_preference";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>PP ID</th>";
echo "<th>PP Name</th>";
echo "<th>Custom Bracket Size</th>";
echo "<th>Reseed Pull Up</th>";
echo "<th>Matching Type</th>";
echo "<th>Max Allowed Gov Assignments</th>";
echo "<th>Random Room Assignments</th>";
echo "<th>Bracket Type</th>";
echo "<th>Same School</th>";
echo "<th>Same Region</th>";
echo "<th>Pull Up Only Once</th>";
echo "<th>Previously Paired</th>";
echo "<th>Pull Up Type</th>";
echo "<th></th>";
echo "</tr>";
if ($result->num_rows > 0) {
    // output data of each row


    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["pp_id"] . "</td>";
        echo "<td>" . $row["pp_name"] . "</td>";
        echo "<td>" . $row["custom_bracket_size"] . "</td>";
        echo "<td>" . $row["reseed_pullout"] . "</td>";
        echo "<td>" . $row["matching_type"] . "</td>";
        echo "<td>" . $row["max_allowed_govt_assignments"] . "</td>";
        echo "<td>" . $row["random_room_assignment"] . "</td>";
        echo "<td>" . $row["bracket_type"] . "</td>";
        echo "<td>" . $row["same_school"] . "</td>";
        echo "<td>" . $row["same_region"] . "</td>";
        echo "<td>" . $row["pullup_only_once"] . "</td>";
        echo "<td>" . $row["previously_paired"] . "</td>";
        echo "<td>" . $row["pullout_type"] . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}

if (isset($_POST['pp_name'])) {
    $stmt = $conn->prepare("INSERT INTO pairing_preference (pp_id, pp_name, custom_bracket_size, reseed_pullout, 
                  matching_type, max_allowed_govt_assignments, random_room_assignment, bracket_type, same_school, same_region, 
                  pullup_only_once, previously_paired, pullout_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isississsssss", $pp_id, $pp_name, $custom_bracket_size, $reseed_pullout,
        $matching_type, $max_allowed_govt_assignments, $random_room_assignment, $bracket_type, $same_school, $same_region,
        $pullup_only_once, $previously_paired, $pullout_type);

    $pp_id = 0;
    $pp_name = $_POST["pp_name"];
    $custom_bracket_size = $_POST["custom_bracket_size"];
    $reseed_pullout = $_POST["reseed_pullout"];
    $matching_type = $_POST["matching_type"];
    $max_allowed_govt_assignments = $_POST["max_allowed_govt_assignments"];
    $random_room_assignment = $_POST["random_room_assignment"];
    $bracket_type = $_POST["bracket_type"];
    $same_school = $_POST["same_school"];
    $same_region = $_POST["same_region"];
    $pullup_only_once = $_POST["pullup_only_once"];
    $previously_paired = $_POST["previously_paired"];
    $pullout_type = $_POST["pullup_type"];

    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
        header("Refresh:0");

    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
    echo "<meta http-equiv='refresh' content='0;URL=http://localhost/debatesoft/tournaments.php#'/>";

}
?>

<tr>
    <form method="post" action="tournaments/preferences.php">
        <td>
            <?php
            require_once '../dbconfig.php';
            $sql = "SELECT MAX(pp_id) + 1 AS pp_id FROM pairing_preference";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();

            echo $row["pp_id"];
            ?>
        </td>
        <td><input type="text" name="pp_name"></td>
        <td><input type="text" name="custom_bracket_size"></td>
        <td><select name="reseed_pullout">
                <option value="T">T</option>
                <option value="F">F</option>
            </select></td>
        <td><select name="matching_type">
                <option value="Random">Random</option>
                <option value="High-High">High-High</option>
                <option value="High-Low">High-Low</option>
            </select></td>
        <td><input type="text" name="max_allowed_govt_assignments"></td>
        <td><select name="random_room_assignment">
                <option value="T">T</option>
                <option value="F">F</option>
            </select></td>
        <td><select name="bracket_type">
                <option name="No Bracketing">No Bracketing</option>
                <option name="Win-Loss">Win-Loss</option>
                <option name="Uniform Size">Uniform Size</option>
                <option name="Custom Size">Custom Size</option>
            </select></td>
        <td><select name="same_school">
                <option value="T">T</option>
                <option value="F">F</option>
            </select></td>
        <td><select name="same_region">
                <option value="T">T</option>
                <option value="F">F</option>
            </select></td>
        <td><select name="pullup_only_once">
                <option value="T">T</option>
                <option value="F">F</option>
            </select></td>
        <td><select name="previously_paired">
                <option value="T">T</option>
                <option value="F">F</option>
            </select></td>
        <td><select name="pullup_type">
                <option name="Top Pullup">Top Pullup</option>
                <option name="Middle Pullup">Middle Pullup</option>
                <option name="Bottom Pullup">Bottom Pullup</option>
            </select></td>
        <td><input type="submit" value="Add"></td>
    </form>
</tr>
</table>
