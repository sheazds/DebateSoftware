<?php
require_once '../dbconfig.php';
$sql = "SELECT region_id, region_name FROM region";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>Region ID</th>";
echo "<th>Region Name</th>";
echo "<th></th>";
echo "</tr>";
if ($result->num_rows > 0) {
    // output data of each row


    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["region_id"] . "</td>";
        echo "<td>" . $row["region_name"] . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<br> 0 results";
}

if (isset($_POST['region_name'])) {
    $stmt = $conn->prepare("INSERT INTO region (region_id, region_name) VALUES (?, ?)");
    $stmt->bind_param("is", $region_id, $region_name);

    // You do not want to assign a value to $region_id because it is auto-incremented so it is assigned 0 or NULL
    // Otherwise you give the variables the correct values based on user input and complete the call
    $region_id = 0;

    // You would replace this with the user input. region_name is a string of max length 20
    $region_name = $_POST['region_name'];

    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
        header("Refresh:0");
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
}
?>

<tr>
    <form method="post" action="regions.php">
        <td>
            <?php
            require_once '../dbconfig.php';
            $sql = "SELECT MAX(region_id) + 1 AS region_id FROM region";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();

            echo $row["region_id"];
            ?>
        </td>
        <td><input type="text" name="region_name"></td>
        <td><input type="submit" value="Add"></td>
    </form>
</tr>
</table>

