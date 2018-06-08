<?php
// this will get moved to an external php file in the future
require_once '../dbconfig.php';
$sql = "SELECT school_id, school_name, region_name FROM school 
    INNER JOIN region ON school.region_id = region.region_id";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>School ID</th>";
echo "<th>School Name</th>";
echo "<th>Region Name</th>";
echo "<th></th>";
echo "</tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["school_id"] . "</td>";
        echo "<td>" . $row["school_name"] . "</td>";
        echo "<td>" . $row["region_name"] . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}

if (isset($_POST['school_name'])) {

    $stmt = $conn->prepare("INSERT INTO school (school_id, school_name, region_id) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $school_id, $school_name, $region_id);

    $sql2 = $conn->prepare("SELECT region_id FROM region WHERE region.region_name = ?");
    $region_name = $_POST['region_name'];
    $sql2->bind_param(s, $region_name);
    $result2 = $sql2->execute();

    // school_id is an auto-incremented value so it is set to 0.
    $school_id = 0;

    // school_name is a string that is max length 20
    $school_name = $_POST['school_name'];

    // Needs to be a valid region_id
    $row2 = $result2->fetch_assoc();
    $region_id = $row2["region_id"];

    $stmt->execute();

    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
        header("Refresh:0");
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
}
?>

<tr>
    <form method="post" action="schools.php">
        <td>
            <?php
            require_once '../dbconfig.php';
            $sql = "SELECT MAX(school_id) + 1 AS school_id FROM school";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();

            echo $row["school_id"];
            ?>
        </td>
        <td><input type="text" name="school_name"></td>
        <td><select name="region_name">
                <option name="Select One">Select One</option>
                <?php
                require_once '../dbconfig.php';
                $sql = "SELECT region_name FROM region";
                $result = $conn->query($sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['region_name'] . "'>" . $row['region_name'] . "</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="submit" name="submit" value="Add"></td>
    </form>
</tr>
</table>